<?php

namespace App\Http\Controllers;

use Svg\Tag\Rect;
use Carbon\Carbon;
use App\Models\Fare;
use App\Models\Booking;
use App\Models\Vehicle;
use App\Models\Operator;
use App\Mail\AdminNotify;
use App\Mail\WelcomeEmail;
use Illuminate\Support\Str;
use App\Models\FleetDetails;
use Illuminate\Http\Request;
use App\Models\PasswordReset;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class OperatorController extends Controller
{
    public function __construct() {}

    public function operatorRegisters(Request $request)
    {
        return view('operatorregister');
    }

    public function AddRegisters(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email'    => "required|email|max:100|unique:operators,email," . $request->id . ",id",
            'office_email' => 'required|email',
            'country' => 'required',
            'first_name' => 'required|string|max:255',
            'sur_name' => 'required|string|max:255',
            'cab_operator_name' => 'required|string|max:255',
            'legal_company_name' => 'required|string|max:255',
            'office_phone_number' => 'required|string|max:20',
            'postcode' => 'required|string|max:10',
            'website' => 'required',
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
        //
        if ($validator->fails()) {
            return  back()->withErrors($validator)->withInput();
        } else {
            try {
                $validatedData = $request->all();
                $validatedData['password'] = Hash::make($validatedData['password']);
                if ($request->upload_operator_licence) {
                    $fileName = $this->fileUpload($request, "upload_operator_licence", $this->OperatorLicencePath);
                    if ($fileName != "") {
                        $validatedData['upload_operator_licence'] = $fileName;
                    }
                }

                if ($request->upload_public_liability_Insurance) {
                    $fileName = $this->fileUpload($request, "upload_public_liability_Insurance", $this->OperatorLicencePath);
                    if ($fileName != "") {
                        $validatedData['upload_public_liability_Insurance'] = $fileName;
                    }
                }

                $operator = Operator::create($validatedData);
                $fleetTypes = implode(',', $request->input('fleet_type', []));

                FleetDetails::create([
                    'operator_id' => $operator->id,
                    'licensing_local_authority' => $validatedData['licensing_local_authority'],
                    'private_hire_operator_licence_number' => $validatedData['private_hire_operator_licence_number'],
                    'licence_expiry_date' => $validatedData['licence_expiry_date'],
                    'upload_operator_licence' => $validatedData['upload_operator_licence'],
                    'upload_public_liability_Insurance' => $validatedData['upload_public_liability_Insurance'],
                    'fleet_size' => $validatedData['fleet_size'],
                    'fleet_type' => $fleetTypes,
                    'dispatch_system' => $validatedData['dispatch_system'],
                ]);

                // send email
                try {
                    $this->sendVerificationEmail($operator);
                } catch (\Exception $e) {
                    return redirect()->back()->with('error', 'Error while registration!');
                }
                return redirect()->route('operator.login')->with('success', 'Thank you for registration! Please check your email to verify your account.');
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Error while registration!');
            }
        }
    }


    public function showLinkRequestFormEmail(Request $request)
    {
        return view('operatorforgotpassword');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ]);
        if ($validator->fails()) {
            return  back()->withErrors($validator)->withInput();
        }

        $login = Operator::where('email', $request->email)->get();
        $login = Operator::where('email', $request->email)->get();

        if ($login->isEmpty()) {
            return redirect()->back()->withErrors(['operatorloginsubmit' => 'Invalid email Please correct email'])->withInput($request->except('password'));
        } else {
            $token = Str::random(6);
            PasswordReset::create([
                'token' => $token,
                'email' => $request->email,
                'created_at' => Carbon::now(),

            ]);
            Mail::send('operator-otp-emailPage', ['token' => $token], function ($message) use ($request) {
                $message->to($request->email);
                $message->subject('Operator Reset Password');
            });
            return back()->with('success', 'Please check your email ');
        }
    }

    public function forgetPasswordLink($token)
    {
        return view('otp-forget-page', ['token' => $token]);
    }

    public function forgetPasswordstore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:4|max:8|',
            'password_confirmation' => 'required|same:password',
        ]);
        if ($validator->fails()) {
            return  back()->withErrors($validator)->withInput();
        }
        $updatePassword = PasswordReset::where([
            'email' => $request->email,
            'token' => $request->token
        ])->first();
        if (!$updatePassword) {
            return redirect()->back()->withErrors(['operatorloginsubmit' => 'Invalid email Please correct email'])->withInput($request->except('password'));
        } else {
            $operator = Operator::where('email', $request->email)->first();
            $operator->password = Hash::make($request->password);
            $operator->save();
            PasswordReset::where('email', $request->email)->delete();
            return redirect()->route('operator.login')->with('success', 'Your password has been reset successfully!');
        }
    }



    public function operatorlogin(Request $request)
    {
        return view('operatorlogin');
    }

    public function operatorloginsubmit(Request $request)
    {
        // return $request;
        $validator = Validator::make($request->all(), [
            'password' => 'required',
            'email' => 'required|email',
        ]);
        if ($validator->fails()) {
            return  back()->withErrors($validator)->withInput();
        }

        $currCountry = request()->segment(1);

        if (!$this->validateUser($request, $currCountry)) {
            return redirect()->back()->withErrors(['operatorloginsubmit' => 'Invalid email or password!'])->withInput($request->except('password'));
        } else {

            $operator = Operator::where(['email' => $request->email, 'country' => $currCountry])->first();
            if (!$operator->status) {
                Auth::guard('weboperator')->logout();
                return redirect()->back()->with('error', 'Your email is not verified. Please check your inbox for a verification link.');
            }
            if (!$operator->is_approved) {
                Auth::guard('weboperator')->logout();
                return redirect()->back()->with('error', 'Your account is not approved at! Please contact with Support!');
            }

            return redirect()->route('operator.dashboard');
        }
    }

    public function operatorVerifyEmail(Request $request)
    {
        if (now()->timestamp > $request->expires) {
            // The timestamp has expired
            // return redirect()->route('operator.login')->with('error', 'Validation link has expired. Please try again!');
        }

        $operator = Operator::where('id', $request->id)->first();
        if ($operator) {
            $operator->status = '1';
            $operator->save();
            return redirect()->route('operator.login')->with('success', 'Email verified successfully. Please login now!');
        } else {
            return redirect()->route('operator.login')->with('error', 'Invalid Link. Please try again!');
        }
    }

    public function validateUser(Request $request, $currCountry)
    {
        if (!Auth::guard('weboperator')->attempt(['email' => $request->email, 'password' => $request->password, 'country' => $currCountry])) {
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


    public function dashboard(Request $request)
    {
        $user = Auth::guard('weboperator')->user();

        //
        $bookingCountAll = Booking::where(['operator_id' => $user->id]);
        $bookingInTransit = Booking::where(['operator_id' => $user->id])->where('status', 'intransit')->where('pickup_date', Carbon::today())->count();
        $bookingCountPending = Booking::where(['operator_id' => $user->id])->where('status', 'pending')->where('pickup_date', Carbon::today())->count();
        $bookingCountCompleted = Booking::where(['operator_id' => $user->id])->where('status', 'completed');
        $bookingAmount = Booking::where(['operator_id' => $user->id])->where('status', 'completed');


        if (isset($request->booking_days)) {
            $bookingDays = $request->booking_days;

            if ($bookingDays == 'month') {
                $bookingCountAll->whereMonth('pickup_date', Carbon::now()->month);
            }
            if ($bookingDays == 'year') {
                $bookingCountAll->whereYear('pickup_date', Carbon::now()->year);
            }
            if ($bookingDays == 'today') {
                $bookingCountAll->where('pickup_date', Carbon::today());
            }
        }

        if ($request->earning_days) {
            if ($request->earning_days == 'month') {
                $bookingAmount->whereMonth('pickup_date', Carbon::now()->month);
            }
            if ($request->earning_days == 'year') {
                $bookingAmount->whereYear('pickup_date', Carbon::now()->year);
            }
            if ($request->earning_days == 'today') {
                $bookingAmount->where('pickup_date', Carbon::today());
            }
        }

        if ($request->completed_booking_days) {
            if ($request->completed_booking_days == 'month') {
                $bookingCountCompleted->whereMonth('pickup_date', Carbon::now()->month);
            }
            if ($request->completed_booking_days == 'year') {
                $bookingCountCompleted->whereYear('pickup_date', Carbon::now()->year);
            }
            if ($request->completed_booking_days == 'today') {
                $bookingCountCompleted->where('pickup_date', Carbon::today());
            }
        }



        $data = [
            'bookingCountAll' => $bookingCountAll->count(),
            'bookingAmount' => $bookingAmount->sum('operator_earning'),
            'bookingInTransit' => $bookingInTransit,
            'bookingCountPending' => $bookingCountPending,
            'bookingCountCompleted' => $bookingCountCompleted->count(),
            'user' => $user
        ];

        return view('operatordashboard', $data);
    }

    public function profileEdit()
    {
        $userId = Auth::guard('weboperator')->user()->id;
        $operator = Operator::with('fleetDetail')->where('id', $userId)->first();
        return view('operatorProfile', compact('operator'));
    }


    public function changePassword()
    {
        return view('changePassword');
    }



    public function update(Request $request)
    {
        $userId = Auth::guard('weboperator')->id();
        $validatedData = $request->validate([
            'office_email' => 'required|email',
            'first_name' => 'required|string|max:255',
            'sur_name' => 'required|string|max:255',
            'cab_operator_name' => 'required|string|max:255',
            'legal_company_name' => 'required|string|max:255',
            'office_phone_number' => 'required|string|max:20',
            'postcode' => 'required|string|max:10',
            'website' => 'required',
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
            'password' => 'required|string|min:6|max:8',
            'password_confirmation' => 'required|same:password',
        ]);
        if ($validator->fails()) {
            return  back()->withErrors($validator)->withInput();
        }
        $user = Auth::guard('weboperator')->user();
        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->back()->withErrors(['current_password' => 'The current password is incorrect.']);
        }
        $user->password = Hash::make($request->password);
        $user->save();
        return redirect()->back()->with('success', 'Password changed successfully.');
    }


    public function acceptBooking()
    {


        if (Auth::guard('weboperator')) {


            return redirect()->route('operator.dashboard');
        } else {
            return redirect()->route('operator.login');
        }
    }


    public function operatorVehicles(Request $request)
    {

        $listing_count = $this->perpage;
        $currCountry = request()->segment(1);
        $tripData = null;
        $data = [];

        $vehicles = Vehicle::where(['country' => $currCountry])
            ->where('operator_id', Auth::guard('weboperator')->user()->id)
            ->orderBy('position', 'DESC')
            ->paginate($listing_count);

        $data['vehicles'] = $vehicles;
        $data['title'] = 'Vehicles';
        $data['currCountry'] = $currCountry;

        return view('operator.vehicles', $data);


        $vehicles = Vehicle::where('operator_id', Auth::guard('weboperator')->user()->id)->get();
        return view('operator.vehicles', $data);
    }


    public function operatorVehiclesCreate(Request $request)
    {
        $data = [];
        $data['title'] = 'Create Vehicles';
        return view('operator.add', $data);
    }

    public function operatorVehiclesEdit($id)
    {
        $data = [];
        $data['title'] = 'Edit Vehicles';
        $data['vehicle'] = Vehicle::find($id);
        return view('operator.add', $data);
    }


    public function operatorVehiclesStore(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'passengers' => 'required',
            'suitecases' => 'required',
            'luggages' => 'required',
            'fixed_rate' => 'required',
            'per_stop'  => 'required',
            'baby_seat' => 'required',
            'parking_charge' => 'required',
            'position' => 'required',
        ]);

        $operator = Auth::guard('weboperator')->user();
        $currCountry = request()->segment(1);

        $data = [
            'operator_id' => $operator->id,
            'name' => $request->name,
            'country' => $currCountry,
            'passengers' => $request->passengers,
            'suitecases' => $request->suitecases,
            'luggages' => $request->luggages,
            'fixed_rate' => $request->fixed_rate,
            'per_stop'  => $request->per_stop,
            'baby_seat' => $request->baby_seat,
            'parking_charge' => $request->parking_charge,
            'position' => $request->position,
        ];

        if ($request->has('image')) {
            $fileName = $this->fileUpload($request, "image", $this->vehiclePath);
            if ($fileName != "") {
                $data['image'] = $fileName;
            }
        }

        Vehicle::updateOrCreate([
            'id' => $request->id,
        ], $data);

        $message = isset($request->id) ? 'Vehicle updated successfully.' : 'Vehicle added successfully.';
        return redirect()->route('operator.vehicles')->with('success', $message);
    }

    public function operatorVehiclesDelete($id)
    {
        Vehicle::where('id', $id)->delete();
        return redirect()->route('operator.vehicles')->with('success', 'Vehicle deleted successfully.');
    }


    public function operatorFares(Request $request)
    {
        $listing_count = $this->perpage;
        $currCountry = request()->segment(1);

        $data = [];
        $vehicles = Vehicle::where(['country' => $currCountry])->where('operator_id', Auth::guard('weboperator')->user()->id)->pluck('id')->toArray();
        $fares = Fare::whereIn('vehicle_id', $vehicles)
            ->orderBy('created_at', 'DESC')
            ->paginate($listing_count);

        $data['fares'] = $fares;
        $data['title'] = 'Fares';
        $data['currCountry'] = $currCountry;

        return view('operator.fares.fares', $data);
    }

    public function operatorFaresCreate(Request $request)
    {
        $currCountry = request()->segment(1);
        $data = ['title' => 'Create Fares'];
        $data['vehicles'] = Vehicle::where('country', $currCountry)->where('operator_id', Auth::guard('weboperator')->user()->id)->get();

        return view('operator.fares.add-fare', $data);
    }

    public function operatorFaresStore(Request $request)
    {
        //
        $validator = Validator::make($request->all(), [
            'vehicle_id' => 'required',
            'start' => 'required|numeric|min:0|lt:end',
            'end' => 'required|numeric|gt:start',
            'rate' => 'required',
        ], [
            'vehicle_id.required' => 'Please select vehicle.',
            'start.required' => 'Please enter start value.',
            'start.numeric' => 'Please enter valid start value.',
            'start.lt' => 'Start value should be less than end value.',
            'end.required' => 'Please enter end value.',
            'end.numeric' => 'Please enter valid end value.',
            'end.gt' => 'End value should be greater than start value.',
            'rate.required' => 'Please enter rate.',
            'rate.numeric' => 'Please enter valid rate.',
            'start.min' => 'Start value should be greater than or equal to 0.',
        ]);

        if ($validator->fails()) {
            return  back()->withErrors($validator)->withInput();
        }

        Fare::updateOrCreate([
            'id' => $request->id,
        ], [
            'vehicle_id' => $request->vehicle_id,
            'start' => $request->start,
            'end' => $request->end,
            'rate' => $request->rate,
        ]);

        $message = isset($request->id) ? 'Fare updated successfully.' : 'Fare added successfully.';
        return redirect()->route('operator.fares')->with('success', $message);
    }

    public function operatorFaresEdit(Request $request, $id)
    {
        $data['fare'] = Fare::where('id', $id)->first();
        $data['title'] = 'Edit Fares';
        $currCountry = request()->segment(1);
        $data['vehicles'] = Vehicle::where('country', $currCountry)->where('operator_id', Auth::guard('weboperator')->user()->id)->get();
        return view('operator.fares.add-fare', $data);
    }

    public function operatorFaresDelete($id)
    {
        $fare = Fare::where('id', $id)->first();
        if ($fare) {
            $fare->delete();
        } else {
            return redirect()->route('operator.fares')->with('error', 'Fare not found.');
        }
        return redirect()->route('operator.fares')->with('success', 'Fare deleted successfully.');
    }
}
