<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BookWithUs;
use Validator;
use Auth;
use Illuminate\Support\Str;

class BookWithUsControlloer extends Controller{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(){

    }
    public function deleteBookWith(Request $request){
        $response=array();
        $success=0;
        $msg="Something went wrong,Please try again later!";
        if($request->id){
            $id=$request->id;
            $user=BookWithUs::where(['id'=>$id])
                ->first();
            if($user){
                $user->forceDelete();
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
    public function getAdminAllBookWithUs(Request $request){
        $currCountry = request()->segment(2);
        $listing_count= $this->perpage;
        $search_key="";
        if($request->search_key){
            $search_key=$request->search_key;
        }
        $bookWithUs=BookWithUs::where(['country'=>$currCountry])
                    ->where(function($query) use ($search_key){
                        if($search_key!=""){
                            return $query->orWhere('title','LIKE','%'. $search_key .'%');
                        } 
                    })
                    ->orderBy('id','desc')
                    ->paginate($listing_count);
        $bundle=['bookWithUs'=>$bookWithUs];            
        if(Request()->ajax()){
            return response()->json(view('Admin.bookWithUsTable',$bundle)->render());
        }
        return view('Admin.bookWithUs',$bundle);
    } 
    public function addBookWithUs(Request $request){
        $id=null;
        if($request->id){
            $id=$request->id;
        }
        $bookWithUs=new BookWithUs();
        if($id){
            $bookWithUs=BookWithUs::where(['id'=>$id])->first();
        }
        if($bookWithUs){
            $page_types=$this->page_types;
            return view('Admin.addBookWithUs',['bookWithUs'=>$bookWithUs]);
        }else{
            return view('Admin.page_404');
        }
    }
    public function createBookWithUs(Request $request){
        $currCountry = request()->segment(2);
        $id=null;
        $title="";
        if($request->id){
            $id=$request->id;
        }
        $success=0;
        $message="unable to Add, Something went wrong!";
        $validator = Validator::make($request->all(), [
            'title'=>'required',
            //'image'=>'required',
        ]);
        if($validator->fails()){
            $success=0;
            return  back()->withErrors($validator)->withInput();
        }else{
            $insert_data=[
                'country'=>$currCountry,
                'title'=>$request->title,
            ];
            if(!$request->imageName){
                $insert_data['image']=null;
            }
            $image="";
            if($request->image){
                $fileName=$this->fileUpload($request,"image",$this->bookWithUs);
                if($fileName!=""){
                    $insert_data['image']=$image=$fileName;
                } 
            }
            $bookWithUs=BookWithUs::updateOrCreate(['id' =>$id],$insert_data);
            if($bookWithUs){
                $success=1;
                $message="Book With Us added successfully !";
            }
        }
        if($success){
            return redirect()->route('admin.bookWithUs')->with('success',$message); 
        }else{
            return redirect()->back()->withErrors([$message]);
        }
    }   
}
