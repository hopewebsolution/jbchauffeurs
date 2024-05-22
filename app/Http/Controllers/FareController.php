<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Auth;
use App\Models\Fare;
use App\Models\Vehicle;

class FareController extends Controller{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(){

    }
    public function deleteFare(Request $request){
        $response=array();
        $success=0;
        $msg="Something went wrong,Please try again later!";
        if($request->id){
            $id=$request->id;
            $fixedRate=Fare::where(['id'=>$id])
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
    public function getAdminAllFares(Request $request){
        $listing_count= $this->perpage;
        $currCountry = request()->segment(2);
        $search_key="";
        if($request->search_key){
            $search_key=$request->search_key;
        }
              
        $fares=Fare::where(function($query) use ($search_key){
                        if($search_key!=""){
                            return $query->orWhere('name','LIKE','%'. $search_key .'%');
                        } 
                    })
                    ->with('vehicle')
                    ->whereHas('vehicle', function ($query) use($currCountry) {
                        return $query->where('country', '=', $currCountry);
                    })
                    ->orderBy('id','desc')
                    ->paginate($listing_count);
        $bundle=['fares'=>$fares];            
        if(Request()->ajax()){
            return response()->json(view('Admin.faresTable',$bundle)->render());
        }
        return view('Admin.fares',$bundle);
    } 
    public function addFare(Request $request){
        $currCountry = request()->segment(2);
        $id=null;
        if($request->id){
            $id=$request->id;
        }
        $fare=new Fare();
        $vehicles=Vehicle::where(['country'=>$currCountry])->get(['id','name']);
        $vehicles=$this->getDropArray($vehicles);
        if($id){
            $fare=Fare::where(['id'=>$id])->first();
        }
        if($fare){
            return view('Admin.addFare',['fare'=>$fare,'vehicles'=>$vehicles]);
        }else{
            return view('Admin.page_404');
        }
    }
    public function createFare(Request $request){
        $id=null;
        if($request->id){
            $id=$request->id;
        }
        $success=0;
        $message="unable to Add Fixed Rate, Something went wrong!";
        $validator = Validator::make($request->all(), [
            'vehicle_id'=>'required',
            'start'=>'required',
            'end'=>'required',
            'rate'=>'required',
        ]);
        if($validator->fails()){
            $success=0;
            return  back()->withErrors($validator)->withInput();
        }else{
            $insert_data=$request->all();
            $start=$request->start;
            $end=$request->end;
            if($start<$end){
                $fare=Fare::updateOrCreate(['id' =>$id],$insert_data);
                if($fare){
                    $success=1;
                    $message="Fare added successfully !";
                }
            }else{
                $success=0;
                $message="Incorrect start and end, end should grater than start !!";
            }
        }
        if($success){
            return redirect()->route('admin.fares')->with('success',$message); 
        }else{
            return redirect()->back()->withInput()->withErrors([$message]);
        }
    } 
}
