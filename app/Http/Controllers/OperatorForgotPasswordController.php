<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OperatorForgotPasswordController extends Controller
{

    public function operatorforgotpassword(Request $request){
        
        return view('operatorforgotpassword');
    }

}
