<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Faq;
use App\Models\Page;
use Validator;
use Auth;
use Illuminate\Support\Str;

class FaqController extends Controller{
    public function __construct(){

    }
    public function faqs(Request $request){
        $currCountry = request()->segment(1);
        $listing_count= $this->perpage;
        $faqs=Faq::orderBy('id','ASC')->paginate($listing_count);
        $pageData=Page::where(["country"=>$currCountry,"page_type"=>"faq"])->first();
        $bundle=['faqs'=>$faqs,'pageData'=>$pageData];            
        return view('faq',$bundle);
    }
    public function getAdminAllFaqs(Request $request){
        $listing_count= $this->perpage;
        $search_key="";
        if($request->search_key){
            $search_key=$request->search_key;
        }
        $faqs=Faq::
                    where(function($query) use ($search_key){
                        if($search_key!=""){
                            return $query->orWhere('name','LIKE','%'. $search_key .'%');
                        } 
                    })
                    ->orderBy('id','desc')
                    ->paginate($listing_count);
        $bundle=['faqs'=>$faqs];            
        if(Request()->ajax()){
            return response()->json(view('Admin.faqsTable',$bundle)->render());
        }
        return view('Admin.faqs',$bundle);
    } 
    public function addFaq(Request $request){
        $faq_id=null;
        if($request->faq_id){
            $faq_id=$request->faq_id;
        }
        $faq=new Faq();
        if($faq_id){
            $faq=Faq::where(['id'=>$faq_id])->first();
        }
        if($faq){
            return view('Admin.addFaq',['faq'=>$faq]);
        }else{
            return view('Admin.page_404');
        }
    }
    public function createFaq(Request $request){
        $faq_id=null;
        $title="";
        if($request->faq_id){
            $faq_id=$request->faq_id;
        }
        $success=0;
        $message="unable to Add Faq, Something went wrong!";
        $validator = Validator::make($request->all(), [
            'question'=>'required',
            'answer'=>'required',
        ]);
        if($validator->fails()){
            $success=0;
            return  back()->withErrors($validator)->withInput();
        }else{
            $insert_data=$request->all();
            $faq=Faq::updateOrCreate(['id' =>$faq_id],$insert_data);
            if($faq){
                $success=1;
                $message="Faq added successfully !";
            }
        }
        if($success){
            return redirect()->route('admin.faqs')->with('success',$message); 
        }else{
            return redirect()->back()->withErrors([$message]);
        }
    }   
}
