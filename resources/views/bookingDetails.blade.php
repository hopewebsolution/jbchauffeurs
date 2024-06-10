@extends('app.master')
@section('content')
<main id="main" class="main">
<div class="row">
    <div class="col-md-12">
      <div class="x_panel">
        <div class="x_title">
          <h2>Booking Details</h2>
          
          <div class="clearfix"></div>
        </div>
        <div class="x_content">
          <section class="content invoice">
            <div class="wrapper" style="border: 1px solid #cccccc; margin: 0 auto; padding: 15px;">
                <div class="header" style="background-color: #001E47; padding:10px; height: 50px; font-family: 'Droid Serif', serif;">
                    <div class="biz-name" style="float:left; width: 100%; font-size: 18px; text-transform:uppercase; color: #fff;">
                        Booking of Jbchauffeurs.com - Booking ID: BK00{{$booking->id}}  
                    </div>
                </div>
                <div class="clear" style="clear:both;"></div>            
                                   
                <div class="table" style="margin: 20px 0;">
                    <table style="width: 50%; border:1px solid #eeeeee; float:left; margin-bottom: 20px;">
                        <tbody><tr style="border:1px solid #eeeeee;  color: #001E47; font-family: 'Droid Serif', serif; font-size: 18px;">
                            <th colspan="2" style="text-align:left; padding: 5px; border-bottom: 1px solid #ccc;">Passenger Details</th>
                        </tr>
                        <tr>
                            <td style="padding: 5px; color: #FF9900; font-weight: bold;">Name</td>
                            <td style="padding: 5px;">{{$booking->user->fname}} {{$booking->user->lname}}</td>
                        </tr>
                        <tr>
                            <td style="padding: 5px; color: #FF9900; font-weight: bold;">Phone</td>
                            <td style="padding: 5px;">{{$booking->user->phone}}</td>
                        </tr>
                        <tr>
                            <td style="padding: 5px; color: #FF9900; font-weight: bold;">Mobile</td>
                            <td style="padding: 5px;">{{$booking->user->mobile}}</td>
                        </tr>
                        <tr>
                            <td style="padding: 5px; color: #FF9900; font-weight: bold;">Email</td>
                            <td style="padding: 5px;">{{$booking->user->email}}</td>
                        </tr>
                        <tr>
                            <td style="padding: 5px; color: #FF9900; font-weight: bold;">No. of Passengers</td>
                            <td style="padding: 5px;">{{$booking->passengers}}</td>
                        </tr>
                        <tr>
                            <td style="padding: 5px; color: #FF9900; font-weight: bold;">No. of Luggage</td>
                            <td style="padding: 5px;">{{$booking->luggages}}</td>
                        </tr>
                        <tr>
                            <td style="padding: 5px; color: #FF9900; font-weight: bold;">No. of Hand Bags</td>
                            <td style="padding: 5px;">{{$booking->suitcases}}</td>
                        </tr>
                        <tr>
                            <td style="padding: 5px; color: #FF9900; font-weight: bold;">Additional Stops</td>
                            <td style="padding: 5px;">@if($booking->stops) {{count($booking->stops)}}  @endif</td>
                        </tr>
                        <tr>
                            <td style="padding: 5px; color: #FF9900; font-weight: bold;">No. of Baby Seats</td>
                            <td style="padding: 5px;">{{$booking->babySeats}}</td>
                        </tr>
                    </tbody></table>
                    
                    <table style="width: 50%; border:1px solid #eeeeee; float:left; margin-bottom: 20px;">
                        <tbody><tr style="border:1px solid #eeeeee;  color: #001E47; font-family: 'Droid Serif', serif; font-size: 18px;">
                            <!-- <th colspan="2" style="text-align:left; padding: 5px; border-bottom: 1px solid #ccc;">&nbsp;</th> -->
                            <th colspan="2" style="text-align:left; padding: 5px; border-bottom: 1px solid #ccc;">
                             @if(Auth::guard('weboperator')->check())
                             @if(!$booking->operator_id)
    <!-- Form is hidden when $booking->operator_id is null -->
    <form action="{{ route('accept_booking') }}" method="POST" style="display: inline-block;">
        @csrf
        <input type="hidden" name="booking_id" value="{{ $booking->id }}">
        <button type="submit" style="padding: 5px 10px; background-color: #001e47; color: #fff; text-decoration: none; border: none; border-radius: 4px; float: right;">Accept Booking</button>
    </form>
@else
    <!-- Form is shown when $booking->operator_id is not null -->
   
@endif







                                     @endif

                            </th>
                        </tr>

                        <tr>
                            <td style="padding: 5px; color: #FF9900; font-weight: bold;">Booking ID</td>
                            <td style="padding: 5px;">BK00{{$booking->id}}</td>
                        </tr>
                        <tr>
                            <td style="padding: 5px; color: #FF9900; font-weight: bold;"></td>
                        <td style="padding: 5px;">${{$fare}} : Journey Fare<br>${{$babySeatFare}} : Baby Seat<br>${{$gstAmount}} : VAT <br>${{$cardFee}} : Paypal Charge<br>-----------------------<br></td></tr><tr>
                            <td style="padding:1px 5px 5px 5px; color: #FF9900; font-weight: bold;">Total Fare</td>
                            <td><b>${{$total}}</b></td>
                        </tr>
                        <tr>
                            <td style="padding: 5px; color: #FF9900; font-weight: bold;">Payment Type</td>
                            <td style="padding: 5px;">paypal / Credit Card</td>
                        </tr>
                        <tr>
                            <td style="padding: 5px; color: #FF9900; font-weight: bold;">Distance</td>
                            <td style="padding: 5px;">{{$booking->distance}} {{$booking->distanceUnit}}</td>
                        </tr>
                        <tr>
                            <td style="padding: 5px; color: #FF9900; font-weight: bold;">Vehicle</td>
                            <td style="padding: 5px;">{{$booking->vehicle->name}}</td>
                        </tr>
                        <tr>
                            <td style="padding: 5px; color: #FF9900; font-weight: bold;">Special Instructions</td>
                            <td style="padding: 5px;">{{$booking->instructions}}</td>
                        </tr>   
                    </tbody></table>
                    <div class="clear" style="clear:both;"></div>
                                    
                </div>

                    
                <div class="table" style="margin: 30px 0;">
                    <table style="width: 50%; border:1px solid #eeeeee; float:left; width: 380px; margin-bottom: 20px;">
                        <tbody><tr style="border:1px solid #eeeeee;  color: #001E47; font-family: 'Droid Serif', serif; font-size: 18px;">
                            <th colspan="2" style="text-align:left; padding: 5px; border-bottom: 1px solid #ccc;">Pickup/DropOff Details</th>
                        </tr>
                        <tr>
                            <td style="padding: 5px; color: #FF9900; font-weight: bold;">Pickup Date/Time</td>
                            <td style="padding: 5px;">{{$booking->pickup_date}} {{$booking->pickup_time}}</td>
                        </tr>
                        <tr>
                            <td style="padding: 5px; color: #FF9900; font-weight: bold;">Pickup Address</td>
                            <td style="padding: 5px;">{{$booking->start}}</td>
                        </tr>
                        <tr>
                            <td style="padding: 5px; color: #FF9900; font-weight: bold;">Pickup Address Location</td>
                            <td style="padding: 5px;">{{$booking->pickup_address_line}}</td>
                        </tr>
                        
                        <tr>
                            <td style="padding: 5px; color: #FF9900; font-weight: bold;">Drop Off Address</td>
                            <td style="padding: 5px;">{{$booking->end}}</td>
                        </tr>
                        <tr>
                            <td style="padding: 5px; color: #FF9900; font-weight: bold;">Drop Off Address Location</td>
                            <td style="padding: 5px;">{{$booking->dropoff_address_line}}</td>
                        </tr>
                        
                                    
                    </tbody></table>
                    @if($booking->route_type=="two_way")
                    <table style="width: 50%; border:1px solid #eeeeee; float:left; width: 380px; margin-bottom: 20px;">
                        <tbody><tr style="border:1px solid #eeeeee;  color: #001E47; font-family: 'Droid Serif', serif; font-size: 18px;">
                            <th colspan="2" style="text-align:left; padding: 5px; border-bottom: 1px solid #ccc;">Return Details</th>
                        </tr>
                        <tr>
                            <td style="padding: 5px; color: #FF9900; font-weight: bold;">Pick Up Date/Time</td>
                            <td style="padding: 5px;">{{$booking->return_pickup_date}} {{$booking->return_pickup_time}}</td>
                        </tr>
                        <tr>
                            <td style="padding: 5px; color: #FF9900; font-weight: bold;">Pickup Address</td>
                            <td style="padding: 5px;">{{$booking->return_pickup_address}}</td>
                        </tr>
                        <tr>
                            <td style="padding: 5px; color: #FF9900; font-weight: bold;">Drop Off Address</td>
                            <td style="padding: 5px;">{{$booking->return_dropoff_address}}</td>
                        </tr>
                    </tbody></table>
                    @endif
                    
                    <div class="clear" style="clear:both;"></div>
                </div>

            </div>
          </section>
          
        </div>
      </div>
    </div>
  </div>

  </main>
@endsection