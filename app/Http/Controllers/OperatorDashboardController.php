<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OperatorDashboardController extends Controller
{
    
    public function dashboard(){
         
        
        return view('operatordashboard');
    }


    public function homedashBoard()
    {
         
        return view('indexdashboard'); 

    }



    public function profile()
    {
      
        return view('operatorProfile');



    }


    public function changePassword()
    {
        return view('changePassword');
    }
}