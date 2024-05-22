<a href="#" onclick="window.print();return false;" class="hide-on-print">Print this page</a>
<a href="{{route('user.bookings')}}" style="padding: 9px;background-color: #001e47;color: #fff;text-decoration: none;border-radius: 6px;margin-left: 20px;margin-top: 10px;display: inline-block;">Bookings</a>

<style type="text/css">
    .alert-danger {
        color: #a94442;
        background-color: #f2dede;
        border-color: #ebccd1;
    }
    .alert {
        padding: 15px;
        margin-bottom: 20px;
        border: 1px solid transparent;
        border-radius: 4px;
    }
    .alert-success {
        color: #3c763d;
        background-color: #dff0d8;
        border-color: #d6e9c6;
    }
    .paynowBtn {
        background-color: green;
        color: #fff;
        padding: 6px 14px;
        border-radius: 4px;
        text-decoration: none;
        font-size: 13px;
    }
</style>

<div class="wrapper" style="border: 1px solid #cccccc; width: 800px; margin: 0 auto; padding: 15px;">
    @if(session()->has('success'))
        <div class="alert alert-success">
            {{ session()->get('success') }}
        </div>
    @endif
    @if(session()->has('error'))
        <div class="alert alert-danger">
            {{ session()->get('error') }}
        </div>
    @endif
    <div class="header" style="background-color: #001E47; padding:10px; height: 50px; font-family: 'Droid Serif', serif;">
        <div class="biz-name" style="float:left; width: 100%; font-size: 18px; text-transform:uppercase; color: #fff;">
            Booking of Jbchauffeurs.com - Booking ID: BK00{{$booking->id}}  
        </div>
    </div>
    <div class="clear" style="clear:both;"></div>            
    <p>
        <strong>Dear {{$user->fname}} {{$user->lname}},</strong><br>
        </p><p>Thank you for your reservation. We'll confirm your reservation shortly. Below are your reservation details:</p>
    <p></p>
        
    <div class="table" style="margin: 20px 0;">
        <table style="width: 50%; border:1px solid #eeeeee; float:left; width: 380px; margin-bottom: 20px;">
            <tbody><tr style="border:1px solid #eeeeee;  color: #001E47; font-family: 'Droid Serif', serif; font-size: 18px;">
                <th colspan="2" style="text-align:left; padding: 5px; border-bottom: 1px solid #ccc;">Passenger Details</th>
            </tr>
            <tr>
                <td style="padding: 5px; color: #FF9900; font-weight: bold;">Name</td>
                <td style="padding: 5px;">{{$user->fname}} {{$user->lname}}</td>
            </tr>
            <tr>
                <td style="padding: 5px; color: #FF9900; font-weight: bold;">Phone</td>
                <td style="padding: 5px;">{{$user->phone}}</td>
            </tr>
            <tr>
                <td style="padding: 5px; color: #FF9900; font-weight: bold;">Mobile</td>
                <td style="padding: 5px;">{{$user->mobile}}</td>
            </tr>
            <tr>
                <td style="padding: 5px; color: #FF9900; font-weight: bold;">Email</td>
                <td style="padding: 5px;">{{$user->email}}</td>
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
        
        <table style="width: 50%; border:1px solid #eeeeee; float:left; width: 380px; margin-bottom: 20px;">
            <tbody><tr style="border:1px solid #eeeeee;  color: #001E47; font-family: 'Droid Serif', serif; font-size: 18px;">
                <th colspan="2" style="text-align:left; padding: 5px; border-bottom: 1px solid #ccc;">&nbsp;</th>
            </tr>
            <tr>
                <td style="padding: 5px; color: #FF9900; font-weight: bold;">Booking ID</td>
                <td style="padding: 5px;">BK00{{$booking->id}}</td>
            </tr>
            <tr>
                <td style="padding: 5px; color: #FF9900; font-weight: bold;"></td>
            <td style="padding: 5px;">{{$booking->currency}}{{$fare}} : Journey Fare<br>
                @if($babySeatFare>0)
                    {{$booking->currency}}{{$babySeatFare}} : Baby Seat<br>
                @endif
                @if($stopsCost>0)
                    {{$booking->currency}}{{$stopsCost}} : Additional Stops<br>
                @endif
                @if($parking_charge>0)
                    {{$booking->currency}}{{$parking_charge}} : Parking<br>
                @endif
                @if($waitCharge>0)
                    {{$booking->currency}}{{$waitCharge}} : Waiting<br>
                @endif
                {{$booking->currency}}{{$gstAmount}} : {{$site_settings->tax_type}} <br>
                {{$booking->currency}}{{$cardFee}} : Paypal Charge<br>
                -----------------------<br>
            </td>
            </tr>
            <tr>
                <td style="padding:1px 5px 5px 5px; color: #FF9900; font-weight: bold;">Total Fare</td>
                <td><b>{{$booking->currency}}{{$total}} @if($booking->status=="pending")<a href="{{route('user.createPayment',['booking_id'=>$booking->id])}}" class="paynowBtn">Pay Now</a>@endif</b></td>
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
        

    <div class="thank-you">
        <b>Thank you!</b><br>
            <h3>JBChauffeurs.com | {{strtoupper($booking->country)}}</h3>
            <p>Booking operate and supported by SILVER CONNECT PTY LTD</p>
    </div>

    <div class="copyright" style="background-color: #001E47; padding: 8px; color:#fff; text-align:center;">
        Copyright ©  2021. <a href="https://www.jbchauffeurs.com/" style="color:#fff;">  Jbchauffeurs.com </a>. All Right Reserved.
    </div>
</div>