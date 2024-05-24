<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OperatorDashboardController extends Controller
{
    
    public function dashboard(){
        
        return view('operatordashboard');
    }

}
