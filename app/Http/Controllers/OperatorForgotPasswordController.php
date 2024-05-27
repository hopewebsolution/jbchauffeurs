<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use Carbon\Carbon;

class OperatorForgotPasswordController extends Controller
{

    public function showLinkRequestForm(Request $request){
        
        return view('operatorforgotpassword');
    }

    public function sendResetLinkEmail(Request $request)
{
    $request->validate(['email' => 'required|email']);

    $email = $request->email;
    $token = Str::random(4);

    DB::table('password_resets')->updateOrInsert(
        ['email' => $email],
        ['token' => $token, 'created_at' => Carbon::now()]
    );

    $domain = URL::to("/forgot-password");
    $url = $domain . "/operator-otp?token=" . $token;

    $data = [
        'token' => $token,
        'url' => $url,
        'email' => $email
    ];
      $data['title'] =" password Reset";
      $data["body"] = "Please Click on the below link";
    Mail::send('operator-otp', $data, function ($message) use ($data) {
        $message->to($data['email']);
        $message->subject('Your OTP for Password Reset');
       
    });

    return back()->with('status', 'We have emailed your OTP!');
}

public function operator_otp()
{
    return view('operator-otp');
}

}
