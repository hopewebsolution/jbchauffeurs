<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\Operator;
use App\Models\FleetDetails;
use Validator;
use Illuminate\Support\Facades\Hash;
use App\Mail\AdminNotify;
use Illuminate\Support\Facades\Mail;

class OperatorRegistersController extends Controller{    
    public function __construct(){

    }

    public function operatorRegisters(Request $request){
        
        return view('operatorregister');
    }
     
    public function AddRegisters(Request $request)
    {
        // Validate the incoming request


        // dd($request->all());
        $validatedData = $request->validate([
            'email'    => "required|email|max:100|unique:operators,email,".$request->id.",id",
            'office_email' => 'required|email',
            'first_name' => 'required|string|max:255',
            'sur_name' => 'required|string|max:255',
            'cab_operator_name' => 'required|string|max:255',
            'legal_company_name' => 'required|string|max:255',
            'office_phone_number' => 'required|string|max:20',
            'postcode' => 'required|string|max:10',
            'website' => 'required|url',
            'licensing_local_authority' => 'required|string|max:255',
            'private_hire_operator_licence_number' => 'required|string|max:255',
            'licence_expiry_date' => 'required|date',
            'fleet_size' => 'required|string|max:255',
            'dispatch_system' => 'required|string|max:255',
            'password' => 'required|string|min:8',
            'password_confirmation' => 'required|same:password',
            'authorised_contact_person' => 'required|string|max:255',
            'authorised_contact_email_address' => 'required|email',
            'authorised_contact_mobile_number' => 'required|string|max:20',
            'about_us' => 'required|string|max:255',
            'revenue' => 'required|string|max:255',
             'upload_operator_licence' => 'required|file|mimes:pdf,jpg,png',
             'upload_public_liability_Insurance' => 'required|file|mimes:pdf,jpg,png',
        ]);
        
        if ($request->hasFile('upload_operator_licence')) {
            $validatedData['upload_operator_licence'] = $request->file('upload_operator_licence')->store('uploads');
        }

        if ($request->hasFile('upload_public_liability_Insurance')) {
            $validatedData['upload_public_liability_Insurance'] = $request->file('upload_public_liability_Insurance')->store('uploads');
        }
        $operator = Operator::create($validatedData);
        $fleetTypes = implode(',', $request->input('fleet_type', []));
        FleetDetails::create([
            'operator_id' => $operator->id,
            'licensing_local_authority' =>$validatedData['licensing_local_authority'],
            'private_hire_operator_licence_number' =>$validatedData['private_hire_operator_licence_number'],
            'licence_expiry_date' => $validatedData['licence_expiry_date'],
            'upload_operator_licence' =>$validatedData['upload_operator_licence'],
            'upload_public_liability_Insurance' =>$validatedData['upload_public_liability_Insurance'],
            'fleet_size' => $validatedData['fleet_size'],
            'fleet_type' => $fleetTypes,
           
            'dispatch_system' =>$validatedData['dispatch_system'],
            'password' => Hash::make($validatedData['password']),


        ]);

        
        return redirect()->back()->with('success', 'Registration Successful!');
    }
        
}
