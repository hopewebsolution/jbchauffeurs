<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Operator;

class OperatorLoginController extends Controller
{
    
    public function operatorlogin(Request $request){
        
        return view('operatorlogin');
    }


    // public function operatorloginsubmit(Request $request)
    // {
    //     $request->validate([
    //         'email' => 'required|email',
    //         'password' => 'required|min:6',
    //     ]);

    //     if (Auth::guard('operator')->attempt(['email' => $request->email, 'password' => $request->password])) {
    //         return redirect()->intended('/operator/dashboard');
    //     }

    //     return redirect()->back()->withInput($request->only('email', 'remember'))->withErrors([
    //         'email' => 'These credentials do not match our records.',
    //     ]);
    // }


    public function operatorloginsubmit(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        $operator = Operator::where('email', $request->email)->first();

        if ($operator && Hash::check($request->password, $operator->password)) {
            return redirect()->route('operator.dashboard');

        }

        return redirect()->back()->withInput($request->only('email', 'remember'))->withErrors([
            'email' => 'These credentials do not match our records.',
        ]);
    }


    // Handle logout
    public function operatorlogout()
    {
        Auth::logout();
        return redirect('/operator/login');
    }


}

