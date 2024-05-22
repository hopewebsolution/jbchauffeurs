<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Auth;
use App\Models\FixedRate;
use App\Models\Vehicle;

class FixedRateController extends Controller{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(){

    }
    public function deleteFixedRate(Request $request){
        $response=array();
        $success=0;
        $msg="Something went wrong,Please try again later!";
        if($request->id){
            $id=$request->id;
            $fixedRate=FixedRate::where(['id'=>$id])
                ->first();
            if($fixedRate){
                $fixedRate->forceDelete();
                $success=1;
                $msg="deleted successfully! ";
            }else{
                $success=0;
                $msg="invalid id to delete!";
            }
        }
        $response['success']=$success;
        $response['message']=$msg;
        return response()->json($response);
    }
    public function getAdminAllFixedRates(Request $request){
        $currCountry = request()->segment(2);
        $listing_count= $this->perpage;
        $search_key="";
        if($request->search_key){
            $search_key=$request->search_key;
        }
              
        $fixedRates=FixedRate::where(['country'=>$currCountry])
                    ->where(function($query) use ($search_key){
                        if($search_key!=""){
                            return $query->orWhere('name','LIKE','%'. $search_key .'%');
                        } 
                    })
                    ->orderBy('id','desc')
                    ->paginate($listing_count);
        $bundle=['fixedRates'=>$fixedRates];            
        if(Request()->ajax()){
            return response()->json(view('Admin.fixedRatesTable',$bundle)->render());
        }
        return view('Admin.fixedRates',$bundle);
    } 
    public function addFixedRate(Request $request){
        $currCountry = request()->segment(2);
        $id=null;
        if($request->id){
            $id=$request->id;
        }
        $fixedRate=new FixedRate();
        $vehicles=Vehicle::where(['country'=>$currCountry])->get(['id','name']);
        $vehicles=$this->getDropArray($vehicles);
        if($id){
            $fixedRate=FixedRate::where(['id'=>$id])->first();
        }
        if($fixedRate){
            return view('Admin.addFixedRate',['fixedRate'=>$fixedRate,'vehicles'=>$vehicles]);
        }else{
            return view('Admin.page_404');
        }
    }
    public function createFixedRate(Request $request){
        $id=null;
        if($request->id){
            $id=$request->id;
        }
        $success=0;
        $message="unable to Add Fixed Rate, Something went wrong!";
        $validator = Validator::make($request->all(), [
            'start'=>'required',
            'end'=>'required',
            'amount'=>'required',
        ]);
        if($validator->fails()){
            $success=0;
            return  back()->withErrors($validator)->withInput();
        }else{
            $insert_data=$request->all();
            $start=$request->start;
            $end=$request->end;
            $currCountry = request()->segment(2);
            $insert_data['country']=$currCountry;
            $distance=$this->getDistance($start,$end);
            if($distance>0){
                $fixedRate=FixedRate::updateOrCreate(['id' =>$id],$insert_data);
                if($fixedRate){
                    $success=1;
                    $message="Fixed Rate added successfully !";
                }
            }else{
                $success=0;
                $message="Incorrect location, please select correct locations!!";
            }
        }
        if($success){
            return redirect()->route('admin.fixedRates')->with('success',$message); 
        }else{
            return redirect()->back()->withErrors([$message]);
        }
    } 
}
