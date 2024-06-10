<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use Auth;
class OperatorBookingController extends Controller
{
    
    public function booking(Request $request){
         
        $currCountry = request()->segment(1);
        $listing_count= $this->perpage;
        $search_key="";
        if($request->search_key){
            $search_key=$request->search_key;
        } 
        // $bookings=Booking::where(['country'=>$currCountry])->where('status','!=','pending')
        $user = Auth::guard('weboperator')->id();

        $bookings=Booking::where(['country'=>$currCountry])->where('operator_id',$user)
                    ->where(function($query) use ($search_key){
                        if($search_key!=""){
                            return $query->orWhere('id','LIKE','%'. $search_key .'%')
                                        ->orWhere('start','LIKE','%'. $search_key .'%')
                                        ->orWhere('end','LIKE','%'. $search_key .'%');
                        } 
                    })
                    ->with('user')
                    ->with('vehicle')
                    ->orderBy('id','desc')
                    ->paginate($listing_count);
                //    dd($bookings); 
        return view('booking', compact('bookings'));

        // return view('booking');
    }

    public function newBooking(Request $request)
    {  
        $currCountry = request()->segment(1);
        $listing_count= $this->perpage;
        $search_key="";
        if($request->search_key){
            $search_key=$request->search_key;
        } 
        // $bookings=Booking::where(['country'=>$currCountry])->where('status','!=','pending')
        $bookings=Booking::where(['country'=>$currCountry])->where('status','pending')->where('operator_id',null)
                    ->where(function($query) use ($search_key){
                        if($search_key!=""){
                            return $query->orWhere('id','LIKE','%'. $search_key .'%')
                                        ->orWhere('start','LIKE','%'. $search_key .'%')
                                        ->orWhere('end','LIKE','%'. $search_key .'%');
                        } 
                    })
                    ->with('user')
                    ->with('vehicle')
                    ->orderBy('id','desc')
                    ->paginate($listing_count);
        return view('newbooking', compact('bookings'));

    }


    public function accept(Request $request)
    {
       
        $user = Auth::guard('weboperator')->id();
        $bookingId = $request->input('booking_id');
        $updated = Booking::where('id', $bookingId)->update(['operator_id' => $user]);
        if ($updated) {
            return redirect()->back()->with('success', 'Booking accepted successfully.');
        } else {
            return redirect()->back()->withErrors('error', 'Booking not found or not accepted.');
        }
    }
    
    public function viewDetails(Request $request,$id){
    //    dd($id);
        $cartObj=new CartController();
     $currCountry = request()->segment(2);
        //  dd($country);
        $booking_id=$request->booking_id;
        $bookingId = $id;
        $booking=Booking::where('id', $bookingId)
                        ->with('vehicle')
                        ->with('user')
                        ->first();
                //  dd($booking);       
        $cartTotals=$cartObj->cartCalc($booking);
        $bundles=[
            'booking'=>$booking,
            'fare'=>$cartTotals['fare'],
            'babySeatFare'=>$cartTotals['babySeatFare'],
            'waitCharge'=>$cartTotals['waitCharge'],
            'GST'=>$cartTotals['GST'],
            'gstAmount'=>$cartTotals['gstAmount'],
            'cardFee'=>$cartTotals['cardFee'],
            'total'=>$cartTotals['total'],
        ];
        return view('bookingDetails',$bundles);
    }
   
}