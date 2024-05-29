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
use Carbon\Carbon;

class OperatorForgotPasswordController extends Controller
{

    public function showLinkRequestFormEmail(Request $request){
        
        return view('operatorforgotpassword');
    }

    public function sendResetLinkEmail(Request $request)
{
    $request->validate([
        'email' => 'required|exists:operators,email',
    ]);

    $token = Str::random(6);

    PasswordReset::create([
        'token' => $token,
        'email' => $request->email,
        'created_at' => Carbon::now(),
       
    ]);

    Mail::send('operator-otp-emailPage', ['token' => $token], function ($message) use ($request) {
        $message->to($request->email);
        $message->subject('Reset Password');
    });

    return back()->with('success', 'Please check your email');


}

public function forgetPasswordLink($token)
{
    return view('otp-forget-page', ['token' => $token]);
}

// public function forgetPasswordstore(Request $request)
// {
   
    
    
//     // $request->validate([
//     //     'email' => 'required|exists:operators,email',
//     //     'password' => 'required|string|min:4|max:8|confirmed',
//     //     'password_confirmation' => 'required'
//     // ]);

//     // $updatePassword = PasswordReset::where(['email' => $request->email, 'token' => $request->token])->first();
//     // dd($updatePassword);
//     // if ($updatePassword == $request->email) {
//     //     $user = Operator::where('email', $request->email)->update(['password' => Hash::make($request->password)]);
//     //     PasswordReset::where('email', $request->email)->delete();
//     //     return redirect('/operator/login')->with('message', 'Your password has been changed!');
//     //     // return back()->with('fail', "Invalid Email");
//     // } else {
//     //     return back()->with('fail', "Invalid Email");
//     //     // $user = Operator::where('email', $request->email)->update(['password' => Hash::make($request->password)]);
//     //     // PasswordReset::where('email', $request->email)->delete();
//     //     // return redirect('/loginpage')->with('message', 'Your password has been changed!');
//     // }

//    // Validate the request
//    $request->validate([
//     'email' => 'required|email|exists:operators,email',
//     'password' => 'required|string|min:4|max:8|confirmed',
//     'password_confirmation' => 'required',
//     // 'token' => 'required'
// ]);

// // Find the password reset token
// $updatePassword = PasswordReset::where([
//     'email' => $request->email,
//     'token' => $request->token
// ])->first();
// // If token data is not found, return with an error message
// // if (!$updatePassword) {
// //     return back()->with('fail', 'Invalid token or email.');
// // }

// // Update the user's password
// $operator = Operator::where('email', $request->email)->first();
// $operator->password = Hash::make($request->password);
// $operator->save();

// // Delete the password reset token
// PasswordReset::where('email', $request->email)->delete();

// // Redirect to login with a success message
// return redirect()->route('operator.login')->with('message', 'Your password has been changed!');


// }
public function forgetPasswordstore(Request $request)
{
    // Validate the request
    $request->validate([
        'email' => 'required|email|exists:operators,email',
        'password' => 'required|string|min:4|max:8|confirmed',
        'password_confirmation' => 'required',
        'token' => 'required'  // Include validation for the token
    ]);

    // Find the password reset token
    $updatePassword = PasswordReset::where([
        'email' => $request->email,
        'token' => $request->token
    ])->first();

    // If token data is not found, return with an error message
    if (!$updatePassword) {
        return back()->with('fail', 'Invalid token or email.');
    }

    // Update the user's password
    $operator = Operator::where('email', $request->email)->first();
    $operator->password = Hash::make($request->password);
    $operator->save();

    // Delete the password reset token
    PasswordReset::where('email', $request->email)->delete();

    // Redirect to login with a success message
    return redirect()->route('operator.login')->with('message', 'Your password has been changed!');
}


}
