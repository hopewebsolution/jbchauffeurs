<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Operator;
use App\Models\FleetDetails;
use Illuminate\Support\Facades\Hash;
use Validator;


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



    public function update(Request $request)
    { 
        // dd($request);
        $userId = Auth::guard('weboperator')->id();

        $validatedData = $request->validate([
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
            'authorised_contact_person' => 'required|string|max:255',
            'authorised_contact_email_address' => 'required|email',
            'authorised_contact_mobile_number' => 'required|string|max:20',
            'about_us' => 'required|string|max:255',
            'revenue' => 'required|string|max:255',
            'upload_operator_licence' => 'nullable|file|mimes:pdf,jpg,png',
            'upload_public_liability_Insurance' => 'nullable|file|mimes:pdf,jpg,png',
        ]);

        if ($request->hasFile('upload_operator_licence')) {
            $fileName = $this->fileUpload($request, "upload_operator_licence", $this->OperatorLicencePath);
            if ($fileName != "") {
                $validatedData['upload_operator_licence'] = $fileName;
            }
        }

        if ($request->hasFile('upload_public_liability_Insurance')) {
            $fileName = $this->fileUpload($request, "upload_public_liability_Insurance", $this->OperatorLicencePath);
            if ($fileName != "") {
                $validatedData['upload_public_liability_Insurance'] = $fileName;
            }
        }

        $operator = Operator::findOrFail($userId);
        $operator->update($validatedData);

        $fleetTypes = implode(',', $request->input('fleet_type', []));

        $fleetDetail = FleetDetails::where('operator_id', $operator->id)->first();
        if ($fleetDetail) {
            $fleetDetail->update([
                'licensing_local_authority' => $validatedData['licensing_local_authority'],
                'private_hire_operator_licence_number' => $validatedData['private_hire_operator_licence_number'],
                'licence_expiry_date' => $validatedData['licence_expiry_date'],
                'upload_operator_licence' => $validatedData['upload_operator_licence'] ?? $fleetDetail->upload_operator_licence,
                'upload_public_liability_Insurance' => $validatedData['upload_public_liability_Insurance'] ?? $fleetDetail->upload_public_liability_Insurance,
                'fleet_size' => $validatedData['fleet_size'],
                'fleet_type' => $fleetTypes,
                'dispatch_system' => $validatedData['dispatch_system'],
            ]);
        } else {
            FleetDetails::create([
                'operator_id' => $operator->id,
                'licensing_local_authority' => $validatedData['licensing_local_authority'],
                'private_hire_operator_licence_number' => $validatedData['private_hire_operator_licence_number'],
                'licence_expiry_date' => $validatedData['licence_expiry_date'],
                'upload_operator_licence' => $validatedData['upload_operator_licence'],
                'fleet_size' => $validatedData['fleet_size'],
                'fleet_type' => $fleetTypes,
                'dispatch_system' => $validatedData['dispatch_system'],
            ]);
        }

        return redirect()->route('profile.edit')->with('success', 'Profile updated successfully.');
        
    }



    public function OperatorChangePassword(Request $request)
    { 

        $validator = Validator::make($request->all(), [
            'current_password' => 'required',
            // 'new_password' => 'required|min:6||max:8|confirmed',
            'password' => 'required|string|min:6|max:8',
            'password_confirmation' => 'required|same:password',
        ]);
        if ($validator->fails()) {
            return  back()->withErrors($validator)->withInput();
        }
        $user = Auth::user();
        
        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->back()->withErrors(['current_password' => 'The current password is incorrect.']);
        }
        

        $user->password = Hash::make($request->new_password);

        $user->save();

        return redirect()->back()->with('success', 'Password changed successfully.');
    }
}