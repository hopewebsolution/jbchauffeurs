@if(request()->segment(1) == 'admin')
{{-- Admin Side AJAX --}}
    Fare: {{$common->adminCountry['currency']}}{{$fare}} ({{$tripData->route_type}}) <br>
    <span id="baby_total_d">Baby Seat : {{$common->adminCountry['currency']}} {{$babySeatFare}}</span><br>
    @if($stopsCost>0)
    <span id="add_rate_waiting_time_s">Additional Stops: {{$common->adminCountry['currency']}} {{$stopsCost}}</span><br>
    @endif
    @if($parking_charge>0)
    <span id="add_rate_waiting_time_s">Parking: {{$common->adminCountry['currency']}} {{$parking_charge}}</span><br>
    @endif
    @if($waitCharge>0)
    <span id="add_rate_waiting_time_s">Wait Time: {{$common->adminCountry['currency']}} {{$waitCharge}}</span><br>
    @endif
    {{$site_settings->tax_type}}({{$GST}}%): <span id="add_rate_gst_s">{{$gstAmount}}</span><br>
    Paypal Charge: {{$common->adminCountry['currency']}}{{$cardFee}}<br>----------------------------<br>
    <span id="grand_total_d">Total: {{$common->adminCountry['currency']}}{{$total}}</span><br>
{{--  --}}
@else
{{-- User Side AJAX --}}
    Fare: {{$common->currCountry['currency']}}{{$fare}} ({{$tripData->route_type}}) <br>
    <span id="baby_total_d">Baby Seat : {{$common->currCountry['currency']}} {{$babySeatFare}}</span><br>
    @if($stopsCost>0)
    <span id="add_rate_waiting_time_s">Additional Stops: {{$common->currCountry['currency']}} {{$stopsCost}}</span><br>
    @endif
    @if($parking_charge>0)
    <span id="add_rate_waiting_time_s">Parking: {{$common->currCountry['currency']}} {{$parking_charge}}</span><br>
    @endif
    @if($waitCharge>0)
    <span id="add_rate_waiting_time_s">Wait Time: {{$common->currCountry['currency']}} {{$waitCharge}}</span><br>
    @endif
    {{$site_settings->tax_type}}({{$GST}}%): <span id="add_rate_gst_s">{{$gstAmount}}</span><br>
    Paypal Charge: {{$common->currCountry['currency']}}{{$cardFee}}<br>----------------------------<br>
    <span id="grand_total_d">Total: {{$common->currCountry['currency']}}{{$total}}</span><br>
{{--  --}}
@endif
