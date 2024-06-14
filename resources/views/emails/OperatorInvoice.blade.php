<div style="border:1px solid #cccccc;width:800px;margin:0 auto;padding:15px;box-sizing: border-box;">
	<div style="background-color:#001e47;float: left;width: 100%;font-family:'Droid Serif',serif;">
		<div style="float:left;width:100%;font-size:18px;color:#fff;padding: 10px;">
			 Operator Invoice Generated
		</div>
	</div>
	<div style="clear:both"></div>
	<p><strong>Operator Invoice</strong><br></p>
	<p></p>
	<div style="margin:20px 0">
		<table style="float:left;width: 100%;margin-bottom:20px;">
			<tbody>
				<tr style="float:left;padding:0px 30px;clear:both">
					<td style="font-weight:bold;padding-right:8px;">Name: </td>
					<td> {{ $contact_data['first_name'] }}</td>
				</tr>
				<tr style="float:left;padding:0px 30px;clear:both">
					<td style="font-weight:bold;padding-right:8px;">Email: </td>
					<td>{{ $contact_data['email'] }}</td>
				</tr>
                <tr>
          
            </tr>


			</tbody>
		</table>

        <div class="table" style="margin: 20px 0;">
			        <table style="width: 50%; border:1px solid #eeeeee; float:left; width: 380px; margin-bottom: 20px;">
			            <tbody><tr style="border:1px solid #eeeeee;  color: #001E47; font-family: 'Droid Serif', serif; font-size: 18px;">
			                <th colspan="2" style="text-align:left; padding: 5px; border-bottom: 1px solid #ccc;">Passenger Details</th>
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
			            <td style="padding: 5px;">{{$booking->currency}}{{$cartTotals['fare']}} : Journey Fare<br>
			                @if($cartTotals['babySeatFare']>0)
			                    {{$booking->currency}}{{$cartTotals['babySeatFare']}} : Baby Seat<br>
			                @endif
			                @if($cartTotals['stopsCost']>0)
			                    {{$booking->currency}}{{$cartTotals['stopsCost']}} : Additional Stops<br>
			                @endif
			                @if($cartTotals['parking_charge']>0)
			                    {{$booking->currency}}{{$cartTotals['parking_charge']}} : Parking<br>
			                @endif
                                <!-- @if($cartTotals['waitCharge']>0)
                                    {{$booking->currency}}{{$cartTotals['waitCharge']}} : Waiting<br>
                                @endif
                                {{$booking->currency}}{{$cartTotals['gstAmount']}} : {{$site_settings->tax_type}} <br>
                                {{$booking->currency}}{{$cartTotals['cardFee']}} : Paypal Charge<br> -->
			                -----------------------<br>
			            </td>
			            </tr>
			            <tr>
			                <td style="padding:1px 5px 5px 5px; color: #FF9900; font-weight: bold;">Total Fare</td>
			                <td><b>{{$booking->currency}}{{$cartTotals['total']}}</b></td>
			            </tr>
			            <!-- <tr>
			                <td style="padding: 5px; color: #FF9900; font-weight: bold;">Payment Type</td>
			                <td style="padding: 5px;">paypal / Credit Card</td>
			            </tr> -->
			            <tr>
			                <td style="padding: 5px; color: #FF9900; font-weight: bold;">Distance</td>
			                <td style="padding: 5px;">{{$booking->distance}} {{$booking->distanceUnit}}</td>
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
		<div style="clear:both"></div>
	</div>
	<div>
		<b>Thank you!</b><br>
		<h3>JBChauffeurs.com</h3>
	</div>
	<div style="background-color:#001e47;padding:8px;color:#fff;text-align:center">
        © {{ date('Y')}} <a href="https://www.jbchauffeurs.com/" style="color:#fff"> Jbchauffeurs.com </a>. All Right Reserved.
	</div>
</div>