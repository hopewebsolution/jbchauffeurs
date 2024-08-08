<?php

namespace App\Http\Controllers;

use PDF;
use Auth;
use Carbon\Carbon;
use App\Models\User;
// use Barryvdh\DomPDF\Facade as PDF;
use App\Models\Booking;
use App\Models\Setting;
use App\Models\Operator;
use Illuminate\Http\Request;
use App\Mail\OperatorInvoice;
use App\Mail\UserBookingCompleted;
use Illuminate\Support\Facades\Mail;

class OperatorBookingController extends Controller
{

    public function booking(Request $request)
    {

        $currCountry = request()->segment(1);
        $listing_count = $this->perpage;
        $search_key = "";
        if ($request->search_key) {
            $search_key = $request->search_key;
        }
        // $bookings=Booking::where(['country'=>$currCountry])->where('status','!=','pending')
        $user = Auth::guard('weboperator')->id();

        $bookingQuery = Booking::where(['country' => $currCountry, 'operator_id' => $user])
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

        if (isset($request->status)) {
            $bookingQuery->where('status', $request->status);
        }

        $bookings = $bookingQuery
            ->paginate($listing_count);

        $statuss = ['statuss' => $this->userbookingStatus];

        return view('booking', compact('bookings', 'statuss'));
    }

    public function newBooking(Request $request)
    {
        $currCountry = request()->segment(1);
        $user = Auth::guard('weboperator')->user();
        $listing_count = $this->perpage;
        $search_key = "";
        if ($request->search_key) {
            $search_key = $request->search_key;
        }
        $bookings = Booking::where(['country' => $user->country])->where('status', 'pending')->where('operator_id', null)
            ->where(function ($query) use ($search_key) {
                if ($search_key != "") {
                    return $query->orWhere('id', 'LIKE', '%' . $search_key . '%')
                        ->orWhere('start', 'LIKE', '%' . $search_key . '%')
                        ->orWhere('end', 'LIKE', '%' . $search_key . '%');
                }
            })
            ->with('user')
            ->with('vehicle')
            ->orderBy('id', 'desc')
            ->paginate($listing_count);
        return view('newbooking', compact('bookings'));
    }


    public function accept(Request $request)
    {

        $user = Auth::guard('weboperator')->id();
        $bookingId = $request->input('booking_id');
        $booking = Booking::where('id', $bookingId)->where('operator_id', null)->first();

        if (!$booking) {
            return redirect()->back()->withErrors('error', 'Booking not found or already accepted by another operator.');
        }

        $booking->operator_id = $user;
        $updated = $booking->save();

        if ($updated) {
            return redirect()->back()->with('success', 'Booking accepted successfully.');
        } else {
            return redirect()->back()->withErrors('error', 'Booking not found or not accepted.');
        }
    }

    public function viewDetails(Request $request, $id)
    {

        $cartObj = new CartController();
        $currCountry = request()->segment(2);
        $booking_id = $request->booking_id;
        $bookingId = $id;
        $booking = Booking::where('id', $bookingId)
            ->where(function ($query) use ($currCountry) {
                $query->where('operator_id', Auth::guard('weboperator')->id())
                    ->orWhere('operator_id', null);
            })
            ->with('vehicle')
            ->with('user')
            ->first();

        if (!$booking) {
            return redirect()->route('booking')->with('error', 'Booking not found or already accepted by another operator.');
        }

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
        return view('operator-booking-details', $bundles);
    }



    public function updateStatus(Request $request)
    {
        $request->validate([
            'booking_id' => 'required|integer|exists:bookings,id',
            'status' => 'required|string'
        ]);

        $booking = Booking::findOrFail($request->booking_id);
        $booking->status = $request->status;
        $booking->save();

        $cartObj = new CartController();
        $cartTotals = $cartObj->cartCalc($booking);
        //
        $currCountry = request()->segment(1);
        $setting = Setting::where(['country' => $currCountry])->first();

        if ($request->status == 'completed') {

            $commission = ($cartTotals['total'] * $setting->admin_commission) / 100;
            $cartTotal = $cartTotals['total'] - $commission;

            $booking->operator_earning = $cartTotal;
            $booking->save();

            $operator = Operator::where('id', $booking->operator_id)->first();
            $contact_data = [
                "id" => $operator->id,
                "first_name" => $operator->first_name,
                "email" => $operator->email,
            ];

            try {
                //code...
                $customer = User::where('id', $booking->user_id)->first();
                if ($customer->email != null) {
                    Mail::to($customer->email)->send(new UserBookingCompleted($customer, $booking, $cartTotals, $contact_data, $setting));
                }
            } catch (\Throwable $th) {
                //throw $th;
            }

            try {
                $pdf = PDF::loadView('invoices.operator_invoice', compact('booking', 'cartTotals', 'contact_data', 'setting'));
                $pdf->setPaper('A4', 'portrait');
                Mail::to($operator->email)->send(new OperatorInvoice($booking, $cartTotals, $contact_data, $setting, $pdf));
            } catch (\Exception $e) {
            }
        }

        return response()->json(['success' => true, 'message' => 'Status updated.']);
    }
}
