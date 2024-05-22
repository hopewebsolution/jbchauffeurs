<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\CartController;
use Validator;
use Auth;
use App\Models\Vehicle;
use App\Models\FixedRate;
use App\Http\Controllers\SettingController;
use Illuminate\Support\Facades\File; 

class VehiclesController extends Controller{
    public function __construct(){

    }
    public function deleteVehicle(Request $request){
        $response=array();
        $success=0;
        $msg="Something went wrong,Please try again later!";
        if($request->id){
            $id=$request->id;
            $vehicle=Vehicle::where(['id'=>$id])->withCount('bookings')
                ->first();
            if($vehicle){
                if($vehicle->bookings_count==0){
                $vehicle->forceDelete();
                    $success=1;
                    $msg="deleted successfully! ";
                }else{
                    $success=0;
                    $msg="This vehicle have booked bookings !";
                }
            }else{
                $success=0;
                $msg="invalid id to delete!";
            }
        }
        $response['success']=$success;
        $response['message']=$msg;
        return response()->json($response);
    }
    public function getVehicles(Request $request){
        $obj=new SettingController();
        $settings=$obj->getAllSettings();
        if($settings->maintenance=="0"){
            $cartObj=new CartController();
            $currCountry = request()->segment(1);
            $start="";
            $end="";
            $stops=array();
            $distance=-1;
            if($request->start){
            	$start=$request->start;
            }
            if($request->end){
            	$end=$request->end;
            }
            if($request->stops){
            	$stops=$request->stops;
            }
            if($start!="" && $end!=""){
            	$distanceUnit='M';
            	if($currCountry=='aus' || $currCountry=='nz'){
            		$distanceUnit='K';
            		$request->distanceUnit="KM";
            	}else{
            		$request->distanceUnit="Miles";
            	}
            	$distance=$this->getDistance($start,$end,$distanceUnit);
                //$distance=110;
            }
            if($distance>0){
            	//$distance=-1;
                $request->distance=$distance;
                $cartObj->addToCart($request);
                return redirect()->route('user.listVehicles');
            }else{
                return  back()->withErrors(['message'=>'Incorrect location, please select correct locations!!'])->withInput();
            }
        }else{
            return view('maintenance');
        }
    }
    public function addCarToCart(Request $request){
        $cartObj=new CartController();
        $currCountry = request()->segment(1);
        $cartObj->addToCart($request);
        return redirect()->route('user.checkout');
    }
    public function listVehicles(Request $request){
    	$listing_count= $this->perpage;
    	$currCountry = request()->segment(1);
        $tripData=null;
        if($request->session()->has('cart')){
        	$tripData=(object) session('cart');
        	if($tripData->country==$currCountry){
	        	$vehicles=Vehicle::where(['country'=>$currCountry])
                        /*->with('fixedRate',function ($query) use($tripData) {
                            return $query->where(['start'=>$tripData->start,'end'=>$tripData->end]);
                        })*/
	        			->orderBy('position','ASC')
	                    ->paginate($listing_count);
                $fixedAmount=0;
                $fixedRate=FixedRate::where(['start'=>$tripData->start,'end'=>$tripData->end])->first();
                if($fixedRate){
                    $fixedAmount=$fixedRate->amount;
                }
                //dd($vehicles);
	        	return view('vehicles',['tripData'=>$tripData,'vehicles'=>$vehicles,'currCountry'=>$currCountry,'fixedAmount'=>$fixedAmount]);
        	}else{
        		return redirect()->route('user.home');
        	}
    	}else{
    		return redirect()->route('user.home');		
    	}
    } 
    public function getAdminAllVehicles(Request $request){
        $currCountry = request()->segment(2);
        $listing_count= $this->perpage;
        $search_key="";
        if($request->search_key){
            $search_key=$request->search_key;
        }
              
        $vehicles=Vehicle::where(['country'=>$currCountry])
                    ->where(function($query) use ($search_key){
                        if($search_key!=""){
                            return $query->orWhere('name','LIKE','%'. $search_key .'%');
                        } 
                    })
                    ->withCount('bookings')
                    ->orderBy('id','desc')
                    ->paginate($listing_count);
        $bundle=['vehicles'=>$vehicles];            
        if(Request()->ajax()){
            return response()->json(view('Admin.vehiclesTable',$bundle)->render());
        }
        return view('Admin.vehicles',$bundle);
    } 
    public function addVehicle(Request $request){
        $vehicle_id=null;
        if($request->vehicle_id){
            $vehicle_id=$request->vehicle_id;
        }
        $vehicle=new Vehicle();
        if($vehicle_id){
            $vehicle=Vehicle::where(['id'=>$vehicle_id])->first();
        }
        if($vehicle){
            return view('Admin.addVehicle',['vehicle'=>$vehicle,'vehicle_id'=>$vehicle_id]);
        }else{
            return view('Admin.page_404');
        }
    }
    public function createVehicle(Request $request){
        $currCountry = request()->segment(2);
        $vehicle_id=null;
        if($request->vehicle_id){
            $vehicle_id=$request->vehicle_id;
        }
        $success=0;
        $message="unable to Add Vehicle, Something went wrong!";
        $validator = Validator::make($request->all(), [
            'name'=>'required',
        ]);
        if($validator->fails()){
            $success=0;
            return  back()->withErrors($validator)->withInput();
        }else{
            $insert_data=$request->except(['imageName']);
            $insert_data['country']=$currCountry;
            if(!$request->imageName){
                $insert_data['image']=null;
            }
            if($request->image){
                $fileName=$this->fileUpload($request,"image",$this->vehiclePath);
                if($fileName!=""){
                    $insert_data['image']=$fileName;
                } 
            }
            $vehicle=Vehicle::updateOrCreate(['id' =>$vehicle_id],$insert_data);
            if($vehicle){
                $success=1;
                $message="Vehicle added successfully !";
            }
        }
        if($success){
            return redirect()->route('admin.vehicles')->with('success',$message); 
        }else{
            return redirect()->back()->withErrors([$message]);
        }
    } 
}
