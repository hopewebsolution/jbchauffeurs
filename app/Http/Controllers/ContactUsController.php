<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Models\Page;
use Auth;
use App\Mail\ContactUsEmail;
use Illuminate\Support\Facades\Mail;

class ContactUsController extends Controller{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(){

    }
    public function contactUs(Request $request){
        $currCountry = request()->segment(1);
        $pageData=Page::where(["country"=>$currCountry,"page_type"=>"contact-us"])->first();
        $bundle=['pageData'=>$pageData];
        return view('contactUs',$bundle);
    } 
    public  function webSendContactUs(Request $request){
        $success=0;
        $message="unable to send, Something went wrong please try again!";
        $validator = Validator::make($request->all(), [
            'name'=>'required',
            'phone'=>'required',
            'email'=>'required',
            'message'=>'required',
            'g-recaptcha-response' => 'required|captcha',  
        ]);
        if($validator->fails()){
            $success=0;
            return  back()->withErrors($validator)->withInput();
        }else{

            $email=$request->email;
            $contact_data=[
                "name"=>$request->name,
                "email"=>$request->email,
                "phone"=>$request->phone,
                "message"=>$request->message,
            ];
            $success=1;
            $message="Thank you!! We will get back to you soon !!";
            try{
                Mail::to($this->adminEmail)->send(new ContactUsEmail((object) $contact_data));
            }catch(Exception $e){
                //echo $e;
            }
        }
        if($success){
            return redirect()->route('user.contactUs')->with('success',$message); 
        }else{
            return redirect()->back()->withErrors([$message]);
        }
    }
}
