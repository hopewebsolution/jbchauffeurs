<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Auth;
use App\Http\Controllers\CartController;
use App\Models\Booking;
use App\Models\Operator;
use App\Models\User;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Hash;
//use Srmklive\PayPal\Services\ExpressCheckout;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use App\Mail\AdminNotify;
use App\Mail\BookingEmail;
use App\Mail\OperatorNotification;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class BookingController extends Controller
{
    public function __construct()
    {
    }
    public function bookingDelete(Request $request)
    {
        $response = array();
        $success = 0;
        $msg = "Something went wrong,Please try again later!";
        if ($request->id) {
            $id = $request->id;
            $booking = Booking::where(['id' => $id])
                ->first();
            if ($booking) {
                $booking->forceDelete();
                $success = 1;
                $msg = "deleted successfully! ";
            } else {
                $success = 0;
                $msg = "invalid id to delete!";
            }
        }
        $response['success'] = $success;
        $response['message'] = $msg;
        return response()->json($response);
    }
    public function cancelPayment(Request $request)
    {
        return redirect()
            ->route('user.bookings')
            ->with('error', $response['message'] ?? 'You have canceled the transaction.');
    }
    public function paymentSuccess(Request $request)
    {
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));

        $provider->getAccessToken();
        $response = $provider->capturePaymentOrder($request['token']);

        if (isset($response['status']) && $response['status'] == 'COMPLETED') {
            $booking_id = $response['purchase_units'][0]['reference_id'];
            $user = Auth::user();
            $user_id = $user->id;
            $booking = Booking::where(['user_id' => $user_id, 'id' => $booking_id])->with('vehicle')->first();

            if ($booking) {
                if ($booking->status == 'pending') {
                    $booking->status = "paid";
                    $booking->fares = $booking->vehicle;
                    $booking->save();
                    $cartObj = new CartController();
                    $cartTotals = $cartObj->cartCalc($booking);

                    $operators = Operator::where('country', $booking->country)->get();
                    // $operatorEmails = array();

                    foreach ($operators as $key => $operator) {
                        $contact_data = [
                            "id" => $operator->id,
                            "first_name" => $operator->first_name,
                            "email" => $operator->email,
                        ];
                        // $operatorEmails[] = $operator->email;

                        Mail::to($operator->email)->send(new OperatorNotification($booking, $cartTotals, $contact_data));
                    }

                    try {
                        // Mail to user
                        Mail::to($booking->user->email)->send(new BookingEmail($booking, $cartTotals));
                    } catch (Exception $e) {
                        echo $e;
                    }

                    try {
                        // Mail to admin
                        $emails = $this->adminEmails[$booking->country];
                        Mail::to($emails)->send(new BookingEmail($booking, $cartTotals, 'admin'));
                    } catch (Exception $e) {
                        echo $e;
                    }
                }
                return redirect()->route('user.printBooking', ['booking_id' => $booking->id])->with('success', 'Booking payment done successfully!!');
            } else {
                return redirect()
                    ->back()
                    ->with('error', $response['message'] ?? 'Something went wrong.');
            }
        } else {
            return redirect()
                ->back()
                ->with('error', $response['message'] ?? 'Something went wrong.');
        }
    }
    public function createPayment(Request $request)
    {

        $currency_code = "USD";
        $cartObj = new CartController();
        $booking_id = $request->booking_id;
        $user = Auth::user();
        $user_id = $user->id;
        $booking = Booking::where(['user_id' => $user_id, 'id' => $booking_id])->with('vehicle')->first();
        //   dd($booking);

        if ($booking) {
            if ($booking->status == 'pending') {
                $index = array_search($booking->country, array_column($this->countries, 'short'));

                $currCountry = $this->countries[$index];
                $currency_code = $currCountry['currency_code'];
                $cartTotals = $cartObj->cartCalc($booking);
                $total = $cartTotals['total'];
                // dd($total);
                $booking->total_fare = $total;
                $booking->save();

                $provider = new PayPalClient;
                //  dd($provider);

                $provider->setApiCredentials(config('paypal'));
                $paypalToken = $provider->getAccessToken();
                //  dd($paypalToken);

                $response = $provider->createOrder([
                    "intent" => "CAPTURE",
                    "application_context" => [
                        "return_url" => route('user.paymentSuccess'),
                        "cancel_url" => route('user.cancelPayment'),
                    ],

                    "purchase_units" => [
                        0 => [
                            "amount" => [
                                "currency_code" => $currency_code,
                                "value" => $total
                            ],
                            'reference_id' => $booking_id,
                        ]
                    ]
                ]);
                // dd( $response['id'] );
                if (isset($response['id']) && $response['id'] != null) {
                    foreach ($response['links'] as $links) {
                        if ($links['rel'] == 'approve') {
                            return redirect()->away($links['href']);
                        }
                    }
                    return redirect()
                        ->back()
                        ->with('error', 'Something went wrong.');
                } else {
                    return redirect()
                        ->back()
                        ->with('error', $response['message'] ?? 'Something went wrong.');
                }
            } else {
                return redirect()
                    ->back()
                    ->with('error', "Payment already done on this booking !!");
            }
        }
    }

    public function placeBooking(Request $request)
    {
        $user_id = null;

        $status = "error";
        $message = "Something went wrong !!";
        $cartObj = new CartController();
        $currCountry = request()->segment(1);
        $customerInfoType = "";
        if ($request->customerInfoType) {
            $customerInfoType = $request->customerInfoType;
        }
        $cartObj->addToCart($request);
        $tripData = (object) session('cart');
        $cartTotals = $cartObj->cartCalc($tripData);
        $total_fare = $cartTotals['total'];
        //$vehicle=Vehicle::where(['country'=>$currCountry])->first();
        // dd(Auth::guard('web')->check());

        if (Auth::guard('web')->check()) {
            $status = "success";
        } else if ($customerInfoType == "book-with-login") {
            $userObj = new UserController();

            $login_email = $request->login_email;
            $login_password = $request->login_password;
            $loginReq = new Request();
            $loginReq->email = $login_email;
            $loginReq->password = $login_password;
            if (!$userObj->validateUser($loginReq)) {
                return back()->withErrors(['message' => 'invalid email or password!']);
            }
            return redirect()->route('user.checkout');
        } else if ($customerInfoType == "book-with-register" || $customerInfoType == "book-without-register") {
            $rules = [
                'email' => 'required|email|unique:users,email',
                'fname' => 'required',
                'lname' => 'required',
                'phone' => 'required',
                'mobile' => 'required',
            ];
            if ($customerInfoType == "book-with-register") {
                $rules['password'] = 'min:6|required';
                $rules['account_type'] = 'required';
            }
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return  back()
                    ->withErrors($validator)
                    ->withInput();
            } else {
                $insert_data = array();
                $account_type = "personal";
                if ($request->account_type) {
                    $account_type = $request->account_type;
                }
                $password = Hash::make($request->email);
                if ($customerInfoType == "book-with-register") {
                    $password = Hash::make($request->password);
                }
                $insert_data = [
                    'password' => $password,
                    'email' => $request->email,
                    'fname' => $request->fname,
                    'lname' => $request->lname,
                    'phone' => $request->phone,
                    'mobile' => $request->mobile,
                    'account_type' => $account_type,
                ];

                if ($account_type == "business") {
                    $insert_data['company_name'] = $request->company_name;
                    $insert_data['company_address'] = $request->company_address;
                    $insert_data['company_phone'] = $request->company_phone;
                    $insert_data['website'] = $request->website;
                    $insert_data['business_type'] = $request->business_type;
                    $insert_data['reg_no'] = $request->reg_no;
                    $insert_data['contact_name'] = $request->contact_name;
                    $insert_data['contact_position'] = $request->contact_position;
                }
                $user = User::create($insert_data);
                if ($user) {
                    if ($customerInfoType == "book-with-register") {
                        try {
                            Mail::to($this->adminEmail)->send(new AdminNotify($user));
                        } catch (Exception $e) {
                            echo $e;
                        }
                    }
                    $user_id = $user->id;
                    Auth::loginUsingId($user_id);
                    $status = 'success';
                }
            }
        }
        $bookngData = null;
        if ($status == 'success') {
            $validator = Validator::make($request->all(), [
                'pickup_date' => 'required',
                'pickupTime' => 'required',
            ]);
            if ($validator->fails()) {
                return  back()
                    ->withErrors($validator)
                    ->withInput();
            } else {
                $pickupDate = $tripData->pickupDate;
                $pickupTime = $tripData->pickupTime;
                $pickdate = Carbon::parse($pickupDate . " " . $pickupTime);
                $hours = $pickdate->diffInHours(Carbon::now(), true);
                if ($hours <= 12) {
                    return  back()->withErrors($validator)->withInput()->with('error', 'Booking allowed when is more than 12 hrs from pickup time.');
                }
                $user = Auth::user();
                if ($user) {
                    $user_id = $user->id;
                }
                $bookngData = [
                    'user_id' => $user_id,
                    'vehicle_id' => $tripData->vehicle_id,
                    'start' => $tripData->start,
                    'route_type' => $tripData->route_type,
                    'pickup_date' => $tripData->pickupDate,
                    'pickup_time' => $tripData->pickupTime,
                    'pickup_address_line' => $tripData->pickupAddress,
                    'end' => $tripData->end,
                    'dropoff_address_line' => $tripData->dropAddress,
                    'passengers' => $tripData->passengers,
                    'babySeats' => $tripData->babySeats,
                    'luggages' => $tripData->luggage,
                    'suitcases' => $tripData->handBags,
                    'stops' => $tripData->stops,
                    'instructions' => $tripData->instructions,
                    'distance' => $tripData->distance,
                    'distanceUnit' => $tripData->distanceUnit,
                    'country' => $tripData->country,
                    'fares' => $tripData->vehicle,
                    'total_fare' => $total_fare,
                ];
                if ($tripData->route_type == "two_way") {
                    $bookngData['return_pickup_date'] = $tripData->returnDetails->pickupDate;
                    $bookngData['return_pickup_time'] = $tripData->returnDetails->pickupTime;
                    $bookngData['return_dropoff_address'] = $tripData->returnDetails->dropAddress;
                    $bookngData['return_pickup_address'] = $tripData->returnDetails->pickupAddress;
                }
                $booking = Booking::create($bookngData);
                // dd($booking);
                if ($booking) {
                    session()->forget('cart');
                    return redirect()->route('user.createPayment', ['booking_id' => $booking->id]);
                    //return redirect()->route('user.printBooking',['booking_id'=>$booking->id]);
                    //return redirect()->route('user.bookings');
                }
            }
        }
    }
    public function userBookings(Request $request)
    {
        $currCountry = request()->segment(1);
        $user_id = Auth::id();
        $listing_count = $this->perpage;
        $bookings = Booking::where(['user_id' => $user_id])->where('status', '!=', 'pending')->orderBy('id', 'desc')->paginate($listing_count);
        return view('bookings', ['bookings' => $bookings]);
    }

    public function printBooking(Request $request)
    {
        $cartObj = new CartController();
        $currCountry = request()->segment(1);
        $user = Auth::user();
        $user_id = $user->id;
        $booking_id = $request->booking_id;
        $booking = Booking::where(['user_id' => $user_id, 'id' => $booking_id])
            ->with('vehicle')
            ->first();

        if ($booking->status != "pending") {
            $booking->vehicle = $booking->booked_vehicle;
        }
        //dd($booking->vehicle);
        $cartTotals = $cartObj->cartCalc($booking);

        $bundles = [
            'booking' => $booking,
            'user' => $user,
            'fare' => $cartTotals['fare'],
            'babySeatFare' => $cartTotals['babySeatFare'],
            'waitCharge' => $cartTotals['waitCharge'],
            'parking_charge' => $cartTotals['parking_charge'],
            'stopsCost' => $cartTotals['stopsCost'],
            'GST' => $cartTotals['GST'],
            'gstAmount' => $cartTotals['gstAmount'],
            'cardFee' => $cartTotals['cardFee'],
            'total' => $cartTotals['total'],
        ];
        return view('bookingPrint', $bundles);
    }

    public function getAdminAllBookings(Request $request)
    {
        $currCountry = request()->segment(2);
        $listing_count = $this->perpage;
        $search_key = "";
        if ($request->search_key) {
            $search_key = $request->search_key;
        }

        // $bookings=Booking::where(['country'=>$currCountry])->where('status','!=','paid')
        $query = Booking::where(['country' => $currCountry])
            ->where(function ($query) use ($search_key) {
                if ($search_key != "") {
                    return $query->orWhere('id', 'LIKE', '%' . $search_key . '%')
                        ->orWhere('start', 'LIKE', '%' . $search_key . '%')
                        ->orWhere('end', 'LIKE', '%' . $search_key . '%');
                }
            })
            ->with('user')
            ->with('vehicle')
            ->orderBy('id', 'desc');

        if (isset($request->operator_id)) {
            $query->where('operator_id', $request->operator_id);
        }
        $bookings = $query->paginate($listing_count);
        $bundle = ['bookings' => $bookings, 'statuss' => $this->bookingStatus];
        if (Request()->ajax()) {
            return response()->json(view('Admin.bookingsTable', $bundle)->render());
        }
        return view('Admin.bookings', $bundle);
    }
    public function apiUpdateBooking(Request $request)
    {
        $response = array();
        $success = 0;
        $message = "unable to change, Something went wrong!";
        $validator = Validator::make($request->all(), [
            'booking_id' => 'required',
            'status' => 'required',
        ]);
        if ($validator->fails()) {
            $success = 0;
            $message = $validator->messages()->all()[0];
        } else {
            $booking_id = $request->booking_id;
            $status = $request->status;
            $booking = Booking::where(['id' => $booking_id])->first();
            if ($booking) {
                $booking->status = $status;
                $currDate = \Carbon\Carbon::now();
                //$order->action_at=$currDate;
                $booking->save();
                $success = 1;
                $message = "status Updated successfully!";
            } else {
                $success = 0;
                $message = "Invalid id!";
            }
        }
        $response['success'] = $success;
        $response['message'] = $message;
        return response()->json($response);
    }

    public function bookingDetails(Request $request)
    {
        $cartObj = new CartController();
        $currCountry = request()->segment(1);
        $booking_id = $request->booking_id;
        $booking = Booking::where(['id' => $booking_id])
            ->with('vehicle')
            ->with('user')
            ->first();
        $cartTotals = $cartObj->cartCalc($booking);
        $bundles = [
            'booking' => $booking,
            'fare' => $cartTotals['fare'],
            'babySeatFare' => $cartTotals['babySeatFare'],
            'waitCharge' => $cartTotals['waitCharge'],
            'GST' => $cartTotals['GST'],
            'gstAmount' => $cartTotals['gstAmount'],
            'cardFee' => $cartTotals['cardFee'],
            'total' => $cartTotals['total'],
        ];
        return view('bookingDetails', $bundles);
    }


    public function addBookings(Request $request)
    {

        return view('Admin.addBooking');
    }




    public function adminPlaceBooking(Request $request)
    {
        // return $request;

        $operatorExists = User::where('email', $request->email)->exists();
        // if ($operatorExists) {
        //     return back()->withErrors(['error' => 'Email Already Exists'])->withInput();
        // }
        $user_id = null;

        $status = "error";

        $message = "Something went wrong !!";
        $cartObj = new CartController();
        // dd($cartObj);
        $currCountry = request()->segment(2);
        $customerInfoType = "";

        if ($request->customerInfoType) {
            $customerInfoType = $request->customerInfoType;
        }
        $cartObj->addToCart($request);

        $tripData = (object) session('cart');
        // dd($tripData);
        $cartTotals = $cartObj->cartCalc($tripData);

        $total_fare = $cartTotals['total'];

        if (Auth::guard('admin')->user()) {
            $status = "success";
        } else if ($customerInfoType == "book-with-login") {
            $userObj = new UserController();

            $login_email = $request->login_email;
            $login_password = $request->login_password;
            $loginReq = new Request();
            $loginReq->email = $login_email;
            $loginReq->password = $login_password;
            if (!$userObj->validateUser($loginReq)) {
                return back()->withErrors(['message' => 'invalid email or password!']);
            }
            return redirect()->route('admin.checkout');
        } else if ($customerInfoType == "book-with-register" || $customerInfoType == "book-without-register") {
            $rules = [
                'email' => 'required|email|unique:users,email',
                'fname' => 'required',
                'lname' => 'required',
                'phone' => 'required',
                'mobile' => 'required',
            ];
            if ($customerInfoType == "book-with-register") {
                $rules['password'] = 'min:6|required';
                $rules['account_type'] = 'required';
            }
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return  back()
                    ->withErrors($validator)
                    ->withInput();
            } else {
                $insert_data = array();
                $account_type = "personal";
                if ($request->account_type) {
                    $account_type = $request->account_type;
                }
                $password = Hash::make($request->email);
                if ($customerInfoType == "book-with-register") {
                    $password = Hash::make($request->password);
                }
                $insert_data = [
                    'password' => $password,
                    'email' => $request->email,
                    'fname' => $request->fname,
                    'lname' => $request->lname,
                    'phone' => $request->phone,
                    'mobile' => $request->mobile,
                    'account_type' => $account_type,
                ];

                if ($account_type == "business") {
                    $insert_data['company_name'] = $request->company_name;
                    $insert_data['company_address'] = $request->company_address;
                    $insert_data['company_phone'] = $request->company_phone;
                    $insert_data['website'] = $request->website;
                    $insert_data['business_type'] = $request->business_type;
                    $insert_data['reg_no'] = $request->reg_no;
                    $insert_data['contact_name'] = $request->contact_name;
                    $insert_data['contact_position'] = $request->contact_position;
                }

                $user = User::create($insert_data);
                if ($user) {
                    if ($customerInfoType == "book-with-register") {
                        try {
                            Mail::to($this->adminEmail)->send(new AdminNotify($user));
                        } catch (Exception $e) {
                            echo $e;
                        }
                    }
                    $user_id = $user->id;
                    Auth::loginUsingId($user_id);
                    $status = 'success';
                }
            }
        }
        $bookngData = null;

        if ($status == 'success') {
            $validator = Validator::make($request->all(), [
                'pickup_date' => 'required',
                'pickupTime' => 'required',
            ]);
            if ($validator->fails()) {
                return  back()
                    ->withErrors($validator)
                    ->withInput();
            } else {
                $pickupDate = $tripData->pickupDate;
                $pickupTime = $tripData->pickupTime;
                $pickdate = Carbon::parse($pickupDate . " " . $pickupTime);
                $hours = $pickdate->diffInHours(Carbon::now(), true);
                if ($hours <= 12) {
                    return back()->withErrors($validator)->withInput()->with('error', 'Booking allowed when is more than 12 hrs from pickup time.');
                }

                $user = User::updateOrCreate(['email' => $request->email], [
                    'fname' => $request->fname,
                    'email' => $request->email,
                ]);
                // dd($user);

                if ($user) {
                    $user_id = $user->id;
                }
                $bookngData = [
                    'user_id' => $user_id,
                    'vehicle_id' => $tripData->vehicle_id,
                    'start' => $tripData->start,
                    'route_type' => $tripData->route_type,
                    'pickup_date' => $tripData->pickupDate,
                    'pickup_time' => $tripData->pickupTime,
                    'pickup_address_line' => $tripData->pickupAddress,
                    'end' => $tripData->end,
                    'dropoff_address_line' => $tripData->dropAddress,
                    'passengers' => $tripData->passengers,
                    'babySeats' => $tripData->babySeats,
                    'luggages' => $tripData->luggage,
                    'suitcases' => $tripData->handBags,
                    'stops' => $tripData->stops,
                    'instructions' => $tripData->instructions,
                    'distance' => $tripData->distance,
                    'distanceUnit' => $tripData->distanceUnit,
                    'country' => $tripData->country,
                    'fares' => $tripData->vehicle,
                    'total_fare' => $total_fare,

                ];
                if ($tripData->route_type == "two_way") {
                    $bookngData['return_pickup_date'] = $tripData->returnDetails->pickupDate;
                    $bookngData['return_pickup_time'] = $tripData->returnDetails->pickupTime;
                    $bookngData['return_dropoff_address'] = $tripData->returnDetails->dropAddress;
                    $bookngData['return_pickup_address'] = $tripData->returnDetails->pickupAddress;
                }
                $booking = Booking::create($bookngData);
                $cartObj = new CartController();
                $cartTotals = $cartObj->cartCalc($booking);
                $operators = Operator::where('country', $booking->country)->get();
                // dd($operators);
                foreach ($operators as $operator) {
                    $contact_data = [
                        "id" => $operator->id,
                        "first_name" => $operator->first_name,
                        "email" => $operator->email,
                    ];
                    Mail::to($operator->email)->send(new OperatorNotification($booking, $cartTotals, $contact_data));
                }

                if ($booking) {
                    session()->forget('cart');

                    // return redirect()->back();
                    // return redirect()->route('user.createPayment',['booking_id'=>$booking->id]);
                    //return redirect()->route('user.printBooking',['booking_id'=>$booking->id]);
                    return redirect()->route('admin.bookings')->with('success', 'Booking created successfully.');
                }
            }
        }
    }
}
