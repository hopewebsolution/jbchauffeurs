<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Validator;
use App\Models\Vehicle;
use App\Models\FixedRate;
use App\Http\Controllers\SettingController;
class CartController extends Controller{
    public function __construct(){

    }
    
    public function getSessionCart(){
        $cart = session('cart');
        return $cart;
    }
    public function getCart(){
        $cartData = session('cart');
        return $cartData;
    }
    public function cartCalc($tripData){
        $cartTotal=array();
        if($tripData->vehicle){

            $babySeatFare=0;
            $total=0;
            $subtotal=0;
            $fixedAmount=0;
            $obj=new SettingController();
            $settings=$obj->getAllSettings();
            $fixedRate=FixedRate::where(['start'=>$tripData->start,'end'=>$tripData->end])->first();
            $fare=0;
            if($fixedRate){
                $fare=$fixedAmount=$fixedRate->amount;
                if($tripData->vehicle->fixed_rate>0){
                    $fare=$fare+($fare*($tripData->vehicle->fixed_rate)/100);
                }
            }else{
                if($tripData->vehicle){
                    $fare=$tripData->vehicle->cost($tripData->distance,$tripData->vehicle->fares);
                }
            }
            if($tripData->route_type=="two_way"){
               $fare=$fare*2; 
            }
            $babySeatRate=$tripData->vehicle->baby_seat;
            $waitCharge=0;
            $parking_charge=$tripData->vehicle->parking_charge;
            $per_stop=$tripData->vehicle->per_stop;
            $totalStops=0;
            $stopsCost=0;
            $GST=$settings->gst;
            $cardFee=$settings->cardFee;
            $gstAmount=0;
            $baby=$tripData->babySeats;
            if($tripData->stops){
                $totalStops=count($tripData->stops);
            } 
            /*if($fixedRate){
                $parking_charge=$fixedRate->parking_charge;
                $per_stop=$fixedRate->per_stop;
                $babySeatRate=$fixedRate->baby_seat;
            }*/
            $stopsCost=$totalStops*$per_stop;
            if($baby=="no"){
                $babySeatFare=0;
            }else if($baby=="baby_seat" || $baby=="booster_seat"){
                $babySeatFare=$babySeatRate; 
            }else{
                $babySeatFare=2*$babySeatRate; 
            }
            $subtotal+=$fare+$babySeatFare+$waitCharge+$stopsCost+$parking_charge;
            if($GST>0){
                $gstAmount=(($subtotal*$GST)/100);
            }
            $total=$subtotal+$gstAmount+$cardFee;
            $total=number_format($total, 2, '.','');
            $cartTotal=[
                'fare'=>$fare,
                'babySeatFare'=>$babySeatFare,
                'waitCharge'=>$waitCharge,
                'parking_charge'=>$parking_charge,
                'per_stop'=>$per_stop,
                'stopsCost'=>$stopsCost,
                'GST'=>$GST,
                'gstAmount'=>$gstAmount,
                'cardFee'=>$cardFee,
                'total'=>$total,
            ];
        }
        return $cartTotal;
    }
    public function checkout(Request $request){
        //session()->forget('cart');
        $obj=new SettingController();
        $settings=$obj->getAllSettings();
        if($settings->maintenance=="0"){
            $listing_count= $this->perpage;
            $currCountry = request()->segment(1);
            $tripData=null;
            if($request->session()->has('cart')){
                $tripData=(object) session('cart');
                $vehicle=Vehicle::where(['country'=>$currCountry,'id'=>$tripData->vehicle_id])->first();
                
                $baby=$tripData->babySeats;
                if($request->baby){
                    $baby=$request->baby;
                    $tripData->babySeats=$baby;
                }
                $cartTotals=$this->cartCalc($tripData);
                $bundles=[
                    'tripData'=>$tripData,
                    'vehicle'=>$vehicle,
                    'babySeats'=>$this->babySeats,
                    'fare'=>$cartTotals['fare'],
                    'babySeatFare'=>$cartTotals['babySeatFare'],
                    'waitCharge'=>$cartTotals['waitCharge'],
                    'parking_charge'=>$cartTotals['parking_charge'],
                    'stopsCost'=>$cartTotals['stopsCost'],
                    'GST'=>$cartTotals['GST'],
                    'gstAmount'=>$cartTotals['gstAmount'],
                    'cardFee'=>$cartTotals['cardFee'],
                    'total'=>$cartTotals['total'],
                    'infoTypes'=>$this->infoTypes,
                ];
                if(Request()->ajax()) {
                    return response()->json(view('ajaxCheckout',$bundles)->render());
                }
                return view('checkout',$bundles);
            }else{
                return redirect()->route('user.home');      
            }
        }else{
            return view('maintenance');
        }
    }
    
     
    public function addToCart(Request $request){
        $currCountry = request()->segment(2);
        $response=array();
        $success=0;
        $message="Some thing went wrong please try again later.";
        
        $cart=$this->getSessionCart();
        if(!$cart){
            $cart=[
                'start'=>'',
                'end'=>'',
                'stops'=>null,
                'vehicle_id'=>0,
                'vehicle'=>NULL,
                'charge'=>0,
                'route_type'=>'one_way',
                'distance'=>0,
                'distanceUnit'=>'KM',
                'country'=>$currCountry,
                'customerInfoType'=>'book-with-register',
                'passengers'=>1,
                'luggage'=>0,
                'handBags'=>0,
                'babySeats'=>"no",
                'pickupAddress'=>"",
                'pickupDate'=>"",
                'pickupTime'=>"",
                'dropAddress'=>"",
                'instructions'=>"",
                'returnDetails'=>(object)[
                    'pickupAddress'=>"",
                    'pickupDate'=>"",
                    'pickupTime'=>"",
                    'dropAddress'=>"",
                ],

            ];
        }
        $vehicle_id=0;
        $route_type="one_way";
        $start="";
        $end="";
        $stops=array();
        $cart['country']=$currCountry;
        if($request->customerInfoType){
            $cart['customerInfoType']=$request->customerInfoType;
        }if($request->passengers){
            $cart['passengers']=$request->passengers;
        }if($request->luggages){
            $cart['luggage']=$request->luggages;
        }if($request->suitecases){
            $cart['handBags']=$request->suitecases;
        }if($request->baby){
            $cart['babySeats']=$request->baby;
        }if($request->pickup_address){
            $cart['pickupAddress']=$request->pickup_address;
        }if($request->pickup_date){
            $cart['pickupDate']=$request->pickup_date;
        }if($request->pickupTime){
            $cart['pickupTime']=$request->pickupTime;
        }if($request->drop_address){
            $cart['dropAddress']=$request->drop_address;
        }if($request->instructions){
            $cart['instructions']=$request->instructions;
        }
        if($request->return_pickup_date){
            $cart['returnDetails']->pickupDate=$request->return_pickup_date;
        }if($request->returnPickupTime){
            $cart['returnDetails']->pickupTime=$request->returnPickupTime;
        }if($request->return_pickup_address){
            $cart['returnDetails']->pickupAddress=$request->return_pickup_address;
        }if($request->return_dropoff_address){
            $cart['returnDetails']->dropAddress=$request->return_dropoff_address;
        }
        if($request->vehicle_id){
            $vehicle_id=$request->vehicle_id;
        }
        if($request->route_type){
            $route_type=$request->route_type;
        }
        if($request->start){
            $start=$request->start;
            $cart['start']=$start;
        }
        if($request->end){
            $end=$request->end;
            $cart['end']=$end;
        }
        if($request->stops){
            $stops=$request->stops;
            $cart['stops']=$stops;
        }
        if($request->distanceUnit){
            $cart['distanceUnit']=$request->distanceUnit;
        }
        if($request->distance) {
            $distance=$request->distance;
            if($distance==-1){
                $distance=0;
            }
            $cart['distance']=$distance;
        }
        
        $vehicle=Vehicle::where(['id'=>$vehicle_id])->first();
        if($vehicle){
            $cart['vehicle']=$vehicle;
            $cart['vehicle_id']=$vehicle_id;
            $cart['charge']=$vehicle->charge;
            $cart['route_type']=$route_type;
        }
        session(['cart'=>$cart]);
        $success=1;
        $message="added to cart";
        $response['success']=$success;
        $response['message']=$message;
        return response()->json($response);
    }  
    
    


    public function adminCheckout(Request $request){

        //session()->forget('cart');
        // dd( $request);
        $obj=new SettingController();
        $settings=$obj->AdmingetAllSettings();
        //  dd( $settings);
        if($settings->maintenance=="0"){
            $listing_count= $this->perpage;
            $currCountry = request()->segment(2);
//  dd($currCountry);
            $tripData=null;
            if($request->session()->has('cart')){
                $tripData=(object) session('cart');
                //  dd($tripData);
                $vehicle=Vehicle::where(['country'=>$currCountry,'id'=>$tripData->vehicle_id])->first();
                //  dd($vehicle);
                $baby=$tripData->babySeats;
                if($request->baby){
                    $baby=$request->baby;
                    $tripData->babySeats=$baby;
                }
                $cartTotals=$this->cartCalc($tripData);
                $bundles=[
                    'tripData'=>$tripData,
                    'vehicle'=>$vehicle,
                    'babySeats'=>$this->babySeats,
                    'fare'=>$cartTotals['fare'],
                    'babySeatFare'=>$cartTotals['babySeatFare'],
                    'waitCharge'=>$cartTotals['waitCharge'],
                    'parking_charge'=>$cartTotals['parking_charge'],
                    'stopsCost'=>$cartTotals['stopsCost'],
                    'GST'=>$cartTotals['GST'],
                    'gstAmount'=>$cartTotals['gstAmount'],
                    'cardFee'=>$cartTotals['cardFee'],
                    'total'=>$cartTotals['total'],
                    'infoTypesAdmin'=>$this->infoTypesAdmin,
                ];
                if(Request()->ajax()) {
                    return response()->json(view('ajaxCheckout',$bundles)->render());
                }

                return view('Admin.admincheckout',$bundles);
            }else{
                // return"no ";
                return redirect()->route('user.home');      
            }
        }else{
            return view('maintenance');
        }
    }
}
