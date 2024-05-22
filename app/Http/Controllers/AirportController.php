<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Auth;
use App\Models\Airport;
use App\Models\SidebarBlock;
use App\Models\Page;
use Illuminate\Support\Str;

class AirportController extends Controller{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(){

    }
    public function deleteAirport(Request $request){
        $response=array();
        $success=0;
        $msg="Something went wrong,Please try again later!";
        if($request->id){
            $id=$request->id;
            $service=Airport::where(['id'=>$id])
                ->first();
            if($service){
                $service->forceDelete();
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
    public function airportTrans(Request $request){
        $currCountry = request()->segment(1);
        $listing_count= $this->perpage;
        $airports=Airport::where(['country'=>$currCountry])->paginate($listing_count);
        $pageData=Page::where(["country"=>$currCountry,"page_type"=>"airports"])->first();
        
        if(!$pageData){
            $pageData=new Page();
        }
        return view('airportTransfer',['airports'=>$airports,'pageData'=>$pageData]);
    }
    public function airportTransDetails(Request $request){
        $currCountry = request()->segment(1);
        $airport_id=null;
        $airport=null;
        if($request->airport_id){
            $airport_id=$request->airport_id;
        }
        if($airport_id){
            $airport=Airport::where(['id'=>$airport_id])->first();
        }
        if($airport){
            return view('airportTransferDetails',['airport'=>$airport]);
        }else{
            return view('page_404');
        }
    }

    public function getAdminAllAirports(Request $request){
        $currCountry = request()->segment(2);
        $listing_count= $this->perpage;
        $search_key="";
        if($request->search_key){
            $search_key=$request->search_key;
        }
              
        $airports=Airport::where(['country'=>$currCountry])
                    ->where(function($query) use ($search_key){
                        if($search_key!=""){
                            return $query->orWhere('title','LIKE','%'. $search_key .'%');
                        } 
                    })
                    ->orderBy('id','desc')
                    ->paginate($listing_count);
        $bundle=['airports'=>$airports];            
        if(Request()->ajax()){
            return response()->json(view('Admin.airportsTable',$bundle)->render());
        }
        return view('Admin.airports',$bundle);
    } 
    public function addAirport(Request $request){
        $airport_id=null;
        if($request->airport_id){
            $airport_id=$request->airport_id;
        }
        $airport=new Airport();
        if($airport_id){
            $airport=Airport::where(['id'=>$airport_id])->first();
        }
        if($airport){
            return view('Admin.addAirport',['airport'=>$airport,'airport_id'=>$airport_id]);
        }else{
            return view('Admin.page_404');
        }
    }
    public function createAirport(Request $request){
        $currCountry = request()->segment(2);
        $airport_id=null;
        $airport_name="";
        if($request->airport_id){
            $airport_id=$request->airport_id;
        }
        $success=0;
        $message="unable to Add airport, Something went wrong!";
        $validator = Validator::make($request->all(), [
            'title'=>'required',
        ]);
        if($validator->fails()){
            $success=0;
            return  back()->withErrors($validator)->withInput();
        }else{
            $insert_data=array();
            if($request->name){
                $airport_name=$request->title;
            }
            $insert_data=[
                'title'=>$request->title,
                'descriptions'=>$request->descriptions,
                'short_desc'=>$request->short_desc,
                'url_slug'=>Str::slug($airport_name, '-'),
                'country'=>$currCountry,
            ];
            if(!$request->imageName){
                $insert_data['image']=null;
            }
            if($request->image){
                $fileName=$this->fileUpload($request,"image",$this->airportPath);
                if($fileName!=""){
                    $insert_data['image']=$fileName;
                } 
            }
            
            $airport=Airport::updateOrCreate(['id'=>$airport_id],$insert_data);
            if($airport){
                $success=1;
                $message="Airport added successfully !";
            }
        }
        if($success){
            return redirect()->route('admin.airports')->with('success',$message); 
        }else{
            return redirect()->back()->withErrors([$message]);
        }
    }  
}
