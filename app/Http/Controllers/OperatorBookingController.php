<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Operator;
use App\Mail\OperatorInvoice;
// use Barryvdh\DomPDF\Facade as PDF;
use PDF;
use Illuminate\Support\Facades\Mail;
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
                    $statuss=['statuss'=>$this->userbookingStatus];  
                //    dd($bundle); 
        return view('booking', compact('bookings','statuss'));

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



    public function updateStatus(Request $request)
    {
        $request->validate([
            'booking_id' => 'required|integer|exists:bookings,id',
            'status' => 'required|string'
        ]);

        $booking = Booking::findOrFail($request->booking_id);        
        $booking->status = $request->status;
        $booking->save();

        $cartObj=new CartController();
        $cartTotals=$cartObj->cartCalc($booking); 
        $operators = Operator::where('country', $booking->country)->get();
           foreach ($operators as $operator) {
               $contact_data = [
                   "id" => $operator->id,
                   "first_name" => $operator->first_name,
                   "email" => $operator->email, 
               ];

               if ($request->status == 'completed') {
                
                $pdf = PDF::loadView('invoices.operator_invoice', compact('booking', 'cartTotals', 'contact_data'));               
                Mail::to($operator->email)->send(new OperatorInvoice($booking, $cartTotals, $contact_data, $pdf));

            
            }
              
           }

        return response()->json(['success' => true, 'message' => 'Status updated.']);
    }
   
}