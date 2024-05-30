<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use App\Models\Operator;
use Illuminate\Support\Facades\Hash;
use App\Models\PasswordReset;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Validator;


class OperatorForgotPasswordController extends Controller
{

    public function showLinkRequestFormEmail(Request $request)
    {
        
        return view('operatorforgotpassword');
    }

    public function sendResetLinkEmail(Request $request)
    {
        // $request->validate([
        //     'email' => 'required|exists:operators,email',
        // ]);
        $validator = Validator::make($request->all(), [
            'email'=>'required|email',
        ]);
        if ($validator->fails()) {
            return  back()->withErrors($validator)->withInput();
        }


        // if(!$this->validateUser($request)){
        //     return redirect()->back()->withErrors(['operatorloginsubmit' => 'Invalid email Please correct email'])->withInput($request->except('password'));
        // }
        $login = Operator ::where('email',$request->email)->get();
        $login = Operator::where('email', $request->email)->get();

        if ($login->isEmpty()) {
            return redirect()->back()->withErrors(['operatorloginsubmit' => 'Invalid email Please correct email'])->withInput($request->except('password'));
        } else {
            $token = Str::random(6);
            PasswordReset::create([
                'token' => $token,
                'email' => $request->email,
                'created_at' => Carbon::now(),
            
            ]);
            Mail::send('operator-otp-emailPage', ['token' => $token], function ($message) use ($request) {
                $message->to($request->email);
                $message->subject('Operator Reset Password');
            });
            return back()->with('success', 'Please check your email ');
           
        }



        // if($login){
        //     $token = Str::random(6);
        //     PasswordReset::create([
        //         'token' => $token,
        //         'email' => $request->email,
        //         'created_at' => Carbon::now(),
            
        //     ]);
        //     Mail::send('operator-otp-emailPage', ['token' => $token], function ($message) use ($request) {
        //         $message->to($request->email);
        //         $message->subject('Reset Password');
        //     });
        //     return back()->with('success', 'Please check your email');
            
        // }
        // else{
        //     return redirect()->back()->withErrors(['operatorloginsubmit' => 'Invalid email Please correct email'])->withInput($request->except('password'));
            
        // }
        
       
    }

    public function forgetPasswordLink($token)
    {
        return view('otp-forget-page', ['token' => $token]);
    }

    public function forgetPasswordstore(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'email'=>'required|email',
            'password' => 'required|string|min:4|max:8|',
            'password_confirmation' => 'required|same:password',
        ]);
        if ($validator->fails()) {
            return  back()->withErrors($validator)->withInput();
        }

        // $request->validate([
        //     'email' => 'required|email|exists:operators,email',

        //     'password' => 'required|string|min:8',
        //     'password_confirmation' => 'required|same:password',
        //     // 'password' => 'required|string|min:4|max:8|confirmed',
        //     // 'password_confirmation' => 'required',

        //     ]);

            $updatePassword = PasswordReset::where([
                'email' => $request->email,
                'token' => $request->token
            ])->first();

           

            if (!$updatePassword) {
                return redirect()->back()->withErrors(['operatorloginsubmit' => 'Invalid email Please correct email'])->withInput($request->except('password'));
            } else {
                $operator = Operator::where('email', $request->email)->first();
                $operator->password = Hash::make($request->password);
                $operator->save();
                PasswordReset::where('email', $request->email)->delete();
                return redirect()->route('operator.login')->with('success', 'Your password has been reset successfully!');
            }
            
            // return redirect()->route('operator.login')->with('message', 'Your password has been changed!');
    }

    public function validateUser(Request $request)
    {   

        $login = Operator ::where('email',$request->email)->get();
        if($login){
            return false;
        }else{
            return true;
        }
        //      if (!Auth::guard('weboperator')->attempt(['email'=>$request->email,'password'=>$request->password])) {
        //      return false;
        //  }
        //  return true;
     }
}
