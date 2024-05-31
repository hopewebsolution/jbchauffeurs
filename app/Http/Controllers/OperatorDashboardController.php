<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Operator;
use App\Models\FleetDetails;


class OperatorDashboardController extends Controller
{
    
    public function dashboard(){
         
        
        return view('operatordashboard');
    }


    public function homedashBoard()
    {
         
        return view('indexdashboard'); 

    }



    public function profileEdit()
    {
        $userId = Auth::guard('weboperator')->user()->id;
        $operator = Operator::with('fleetDetail')->where('id',$userId)->first();
        
        //  dd($data);
        return view('operatorProfile', compact('operator'));
        // return view('operatorProfile');



    }


    public function changePassword()
    {
        return view('changePassword');
    }
}