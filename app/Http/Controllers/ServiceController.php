<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Auth;
use App\Models\Service;
use Illuminate\Support\Str;

class ServiceController extends Controller{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(){

    }
    public function deleteService(Request $request){
        $response=array();
        $success=0;
        $msg="Something went wrong,Please try again later!";
        if($request->id){
            $id=$request->id;
            $service=Service::where(['id'=>$id])
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
    public function serviceDetails(Request $request){
        $service_id=null;
        $service=null;
        if($request->service_id){
            $service_id=$request->service_id;
        }
        if($service_id){
            $service=Service::where(['id'=>$service_id])->first();
        }
        if($service){
            return view('serviceDetails',['service'=>$service,'service_id'=>$service_id]);
        }else{
            return view('page_404');
        }
    }
    public function getAdminAllServices(Request $request){
        $currCountry = request()->segment(2);
        $listing_count= $this->perpage;
        $search_key="";
        if($request->search_key){
            $search_key=$request->search_key;
        }
              
        $services=Service::where(['country'=>$currCountry])
                    ->where(function($query) use ($search_key){
                        if($search_key!=""){
                            return $query->orWhere('name','LIKE','%'. $search_key .'%');
                        } 
                    })
                    ->orderBy('id','desc')
                    ->paginate($listing_count);
        $bundle=['services'=>$services];            
        if(Request()->ajax()){
            return response()->json(view('Admin.servicesTable',$bundle)->render());
        }
        return view('Admin.services',$bundle);
    } 
    public function addService(Request $request){
        $service_id=null;
        if($request->service_id){
            $service_id=$request->service_id;
        }
        $service=new Service();
        if($service_id){
            $service=Service::where(['id'=>$service_id])->first();
        }
        if($service){
            return view('Admin.addService',['service'=>$service,'service_id'=>$service_id]);
        }else{
            return view('Admin.page_404');
        }
    }
    public function createService(Request $request){
        $currCountry = request()->segment(2);
        $service_id=null;
        $service_name="";
        if($request->service_id){
            $service_id=$request->service_id;
        }
        $success=0;
        $message="unable to Add Service, Something went wrong!";
        /*$validator = Validator::make($request->all(), [
            'name'=>'required',
        ]);
        if($validator->fails()){
            $success=0;
            return  back()->withErrors($validator)->withInput();
        }else{*/
            $insert_data=$request->except(['imageName']);
            if($request->name){
                $service_name=$request->name;
            }
            $insert_data['url_slug']=Str::slug($service_name, '-');
            $insert_data['country']=$currCountry;
            if(!$request->imageName){
                $insert_data['image']=null;
            }
            if($request->image){
                $fileName=$this->fileUpload($request,"image",$this->servicePath);
                if($fileName!=""){
                    $insert_data['image']=$fileName;
                } 
            }
            $service=Service::updateOrCreate(['id' =>$service_id],$insert_data);
            if($service){
                $success=1;
                $message="Service added successfully !";
            }
        //}
        if($success){
            return redirect()->route('admin.services')->with('success',$message); 
        }else{
            return redirect()->back()->withErrors([$message]);
        }
    } 
}
