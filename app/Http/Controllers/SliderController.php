<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Auth;
use App\Models\Slider;

class SliderController extends Controller{
    public function __construct(){

    }
    public function deleteRow(Request $request){
        $response=array();
        $success=0;
        $msg="Something went wrong,Please try again later!";
        if($request->id){
            $id=$request->id;
            $slider=Slider::where(['id'=>$id])
                ->first();
            if($slider){
                $slider->forceDelete();
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
    public function getAdminAllSliders(Request $request){
        $currCountry = request()->segment(2);
        $listing_count= $this->perpage;
        $search_key="";
        if($request->search_key){
            $search_key=$request->search_key;
        }
              
        $sliders=Slider::where(['country'=>$currCountry])
                    ->where(function($query) use ($search_key){
                        if($search_key!=""){
                            return $query->orWhere('title','LIKE','%'. $search_key .'%');
                        } 
                    })
                    ->orderBy('id','desc')
                    ->paginate($listing_count);
        $bundle=['sliders'=>$sliders];            
        if(Request()->ajax()){
            return response()->json(view('Admin.slidersTable',$bundle)->render());
        }
        return view('Admin.sliders',$bundle);
    } 
    public function addSlider(Request $request){
        $slide_id=null;
        if($request->slide_id){
            $slide_id=$request->slide_id;
        }
        $slider=new Slider();
        if($slide_id){
            $slider=Slider::where(['id'=>$slide_id])->first();
        }
        if($slider){
            return view('Admin.addSlider',['slider'=>$slider,'slide_id'=>$slide_id]);
        }else{
            return view('Admin.page_404');
        }
    }
    public function createSlider(Request $request){
        $currCountry = request()->segment(2);
        $slide_id=null;
        $service_name="";
        if($request->slide_id){
            $slide_id=$request->slide_id;
        }
        $success=0;
        $message="unable to Add Slide, Something went wrong!";
        $validator = Validator::make($request->all(), [
            'title'=>'required',
        ]);
        if($validator->fails()){
            $success=0;
            return  back()->withErrors($validator)->withInput();
        }else{
            $insert_data=$request->all();
            $insert_data['country']=$currCountry;
            if($request->slide_img){
                $fileName=$this->fileUpload($request,"slide_img",$this->sliderPath);
                if($fileName!=""){
                    $insert_data['slide_img']=$fileName;
                } 
            }
            $slider=Slider::updateOrCreate(['id' =>$slide_id],$insert_data);
            if($slider){
                $success=1;
                $message="Slide added successfully !";
            }
        }
        if($success){
            return redirect()->route('admin.sliders')->with('success',$message); 
        }else{
            return redirect()->back()->withErrors([$message]);
        }
    }  
}
