<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Invoice</title>
        <style>
            table {
                border-spacing: 0px;
            }
        </style>
    </head>
    <body>
        <table style="width: 700px; border:1px solid #000000; padding: 10px">
            <tr style="color: #ffffff; font-family: 'Droid Serif', serif; font-size: 18px; background-color: #011e47">
                <td style="background-color: #011e47; padding: 10px">
                    Operator Invoice Generated
                </td>
            </tr>
            <tr>
                <td style="padding: 0px 5px;">
                    <strong>Operator Invoice</strong>
                </td>
            </tr>
            <tr>
                <td>
                    <table style="width: 230px;">
                        <tr>
                            <td><strong>Name</strong></td>
                            <td>{{ $contact_data['first_name'] }}</td>
                        </tr>
                        <tr>
                            <td><strong>Email</strong></td>
                            <td>{{ $contact_data['email'] }}</td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td style="padding-top: 20px; padding-bottom: 20px;">
                    <table style="width: 100%;">
                        <tr>
                            <td style="width: 335px;">
                                <table style="width: 330px; border:1px solid #eeeeee; float:left;">
                                    <tr style="border:1px solid #eeeeee;  color: #001E47; font-family: 'Droid Serif', serif; font-size: 18px;">
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
                                </table>
                            </td>
                            <td style="width: 335px;">
                                <table style="width: 330px; border:1px solid #eeeeee;">
                                    <tr style="border: 1px solid #eeeeee;  color: #001E47; font-family: 'Droid Serif', serif; font-size: 18px;">
                                        <th colspan="2" style="text-align:left; padding: 5px; border-bottom: 1px solid #ccc;">&nbsp;</th>
                                    </tr>
                                    <tr>
                                        <td style="padding: 5px; color: #FF9900; font-weight: bold;">Booking ID</td>
                                        <td style="padding: 5px;">BK00{{$booking->id}}</td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 5px;"></td>
                                        <td style="padding: 5px;">
                                            <table>
                                                <tr>
                                                    <td>{{$booking->currency}}{{$cartTotals['fare']}} : Journey Fare</td>
                                                </tr>
                                                @if($cartTotals['babySeatFare']>0)
                                                <tr>
                                                    <td>{{$booking->currency}}{{$cartTotals['babySeatFare']}} : Baby Seat</td>
                                                </tr>
                                                @endif
                                                @if($cartTotals['stopsCost']>0)
                                                <tr>
                                                    <td>{{$booking->currency}}{{$cartTotals['stopsCost']}} : Additional Stops</td>
                                                </tr>
                                                @endif
                                                @if($cartTotals['parking_charge']>0)
                                                <tr>
                                                    <td>{{$booking->currency}}{{$cartTotals['parking_charge']}} : Parking</td>
                                                </tr>
                                                @endif
                                                @if($cartTotals['waitCharge']>0)
                                                <tr>
                                                    <td>{{$booking->currency}}{{$cartTotals['waitCharge']}} : Waiting</td>
                                                </tr>
                                                @endif
                                                <tr>
                                                    <td>{{$booking->currency}}{{$cartTotals['gstAmount']}} : {{$site_settings->tax_type}}</td>
                                                </tr>
                                                <tr>
                                                    <td>{{$booking->currency}}{{$cartTotals['cardFee']}} : Paypal Charge</td>
                                                </tr>
                                                <tr>
                                                    <td>-----------------------</td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td><b>{{$booking->currency}}{{ $cartTotals['total'] }}</b></td>
                                    </tr>
                                    <tr>
                                        <td style="padding:1px 5px 5px 5px; color: #FF9900; font-weight: bold;">Commission ({{ $setting->admin_commission }}%)</td>
                                        <?php
                                        $commission = ($cartTotals['total'] * $setting->admin_commission) / 100;
                                        $cartTotal = $cartTotals['total'] - $commission;
                                        ?>
                                        <td><b>{{$booking->currency}}{{$commission}}</b></td>
                                    </tr>

                                    <tr>
                                        <td></td>
                                        <td>-----------------------</td>
                                    </tr>
                                    <tr>
                                        <td style="padding:1px 5px 5px 5px; color: #FF9900; font-weight: bold;">Your Earning</td>
                                        <td><b>{{$booking->currency}}{{$cartTotal}}</b></td>
                                    </tr>
                                    <!-- <tr>
                                        <td style="padding: 5px; color: #FF9900; font-weight: bold;">Payment Type</td>
                                        <td style="padding: 5px;">Paypal / Credit Card</td>
                                    </tr> -->
                                    <tr>
                                        <td style="padding: 5px; color: #FF9900; font-weight: bold;">Distance</td>
                                        <td style="padding: 5px;">{{$booking->distance}} {{$booking->distanceUnit}}</td>
                                    </tr>

                                    <tr>
                                        <td style="padding: 5px; color: #FF9900; font-weight: bold;">Special Instructions</td>
                                        <td style="padding: 5px;">{{$booking->instructions}}</td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td style="padding-bottom: 20px; padding-top: 20px;">
                    <table style="width: 100%;">
                        <tr>
                            <td style="width: 335px;">
                                <table style="width: 330px; border:1px solid #eeeeee; ">
                                    <tr style="border:1px solid #eeeeee;  color: #001E47; font-family: 'Droid Serif', serif; font-size: 18px;">
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
                                </table>
                            </td>
                            @if($booking->route_type=="two_way")
                            <td style="width: 335px;">
                                <table style="width: 330px; border:1px solid #eeeeee; float:left;">
                                    <tr style="border:1px solid #eeeeee;  color: #001E47; font-family: 'Droid Serif', serif; font-size: 18px;">
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
                                </table>
                            </td>
                            @endif
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td>
                    <b>Thank you!</b><br>
                    <h3>JBChauffeurs.com</h3>
                </td>
            </tr>
            <tr style="color: #ffffff; font-family: 'Droid Serif', serif; font-size: 18px; background-color: #011e47">
                <td style="background-color: #011e47; padding:8px;color:#fff;text-align:center">
                    © {{ date('Y')}} <a href="https://www.jbchauffeurs.com/" style="color:#fff"> Jbchauffeurs.com </a>. All Right Reserved.
                </td>
            </tr>
        </table>
    </body>

</html>
