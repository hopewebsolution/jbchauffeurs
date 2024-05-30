<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Operator;
use Validator;


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
        // return $request;
        $validator = Validator::make($request->all(), [
            'password' => 'required',
            'email'=>'required|email',
        ]);
        if ($validator->fails()) {
            return  back()
                    ->withErrors($validator)
                    ->withInput();
        }

        if(!$this->validateUser($request)){
            return back()->withErrors(['message'=>'invalid email or password!']);
        }else{
             
            return redirect()->route('operator.dashboard');

            // $userData=Auth::user();
            // if($userData->status=='active'){
            //     return redirect()->route('operator.dashboard');
            // }else if($userData->status!='active'){
            //     $this->makeLogout();
            //     return back()->withErrors(['message'=>'Your account is block by Admin, please contact with customer support']);
            // }
            
        }
        
        // $request->validate([
        //     'email' => 'required|email',
        //     'password' => 'required|min:6',
        // ]);

        // $operator = Operator::where('email', $request->email)->first();
        
        // if ($operator && Hash::check($request->password, $operator->password)) {
             
        //     return redirect()->route('operator.dashboard');

        // }
        // return redirect()->back()->withInput($request->only('email', 'remember'))->withErrors([
        //     'email' => 'These credentials do not match our records.',
        // ]);

    }


 

   public function validateUser(Request $request){
    //  dd(Auth::guard('weboperator'));
    
        if (Auth::guard('weboperator')->attempt(['email'=>$request->email,'password'=>$request->password])) {
            
            return false;
        }
        return true;
    }


    public function logout(Request $request)
    {
        Auth::guard('weboperator')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('operator.login'); 
    }
}

