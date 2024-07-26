@extends('Admin/masters/master')
@section('title', 'Booking Checkout')
@section('content')

<style>
    .cntblock .tabholder {
    padding: 15px;
    background-color: #e9e9e9;
    border: 2px solid #dadada;
    color: #333;
    margin-bottom: 15px;
    line-height: 22px;
}
.cntblock {
    height: auto;
    font-size: 17px;
    color: #333;
    margin-top: 50px;
}
.image_block img {
    height: 131px;
    object-fit: contain;
    width: 100%;
}
.about-image img, .leftholder img {
    border: 5px solid #ccc;
    margin-right: 10px;
}
.tabholder .txtst1 {
    font-size: 18px;
    font-weight: bold;
    color: #0a3e85;
}
.cntblock {
    font-size: 11px;
}
.leftholder p {
    font-size: 14px;
    line-height: 24px;
}
.price_box p, .price_box label {
    margin: 0px;
}
.submit {
    background: #ff6000;
    border: none;
    color: #FFFFFF;
    font-size: 12px;
    height: 30px;
    text-align: center;
    width: 86px;
    line-height: 32px;
    font-weight: bold;
    font-family: Arial, Helvetica, sans-serif;
    cursor: pointer;
}
.cntblock .pg-title {
    font-size: 25px;
    color: #000;
    margin-bottom: 15px;
    height: 40px;
    background-image: url(https://jbchauffeurs.com/public/assets/front_assets/images/img_welcome_sep.jpg);
    background-repeat: no-repeat;
    background-position: bottom left;
}
.leftholder p {
    font-size: 14px;
    line-height: 24px;
}
#midwrap1 .formblock {
    background: rgb(68, 67, 67);
    padding: 15px;
}
.formblock {
    background: rgba(30, 30, 30, 0.6);
    padding: 20px;
    border-radius: 10px;
}
.cntblock #banform .form-head-bg img, .cntblock #banform .formblock {
    width: 100%;
}
#midwrap1 #banform {
    margin: 15px 0;
}
.cntblock #banform {
    position: static;
}
.rightholder #banform {
    width: 100%;
}
#banform {
      z-index: 9999;
    width: 100%;
       padding-top: 55px;
}
.bannerTitle {
    text-shadow: 0 0 10px #000;
    color: #fff;
    padding-top: 15px;
    margin-bottom: 30px !important;
}
.form-border .form-control {
    -webkit-box-shadow: inset 1px 1px 5px 0px rgba(0, 0, 0, 0.39);
    -moz-box-shadow: inset 1px 1px 5px 0px rgba(0, 0, 0, 0.39);
    box-shadow: inset 1px 1px 5px 0px rgba(0, 0, 0, 0.39);
}
#banform input[type="text"], #banform select, #banform input[type="submit"] {
    border-radius: 5px !important;
    border: 0px;
}
.formblock .form-control {
    border-radius: 0 !important;
    height: 42px;
}
.btn-plus {
    background: #edc20b;
    color: #fff;
    padding: 10px 12px;
    margin-left:10px ;
}
.getmore {
    float: left;
    width: auto;
    min-width:328px !important;
}
.inputst1 {
    background-color: #fff;
    border: 1px solid #c1c1c1;
    color: #000;
    padding: 5px;
    margin-left: 5px;
    margin-top: 5px;
}




.form-horizontal .control-label {
    padding-top: 7px;
    margin-bottom: 0;
    text-align: left;
    font-weight: normal;
    font-size: 14px;
}
.inputst1 {
    background-color: #fff;
    border: 1px solid #c1c1c1;
    color: #000;
    padding: 5px;
    margin-left: 5px;
    margin-top: 5px;
}
#choose-customerInfoType .radio-btns{
    display: none;
}
</style>
<div id="midwrap1">
    <div class="container">
        <div class="cntblock">
            <div class="row">
                <div class="col-md-8 col-sm-8">
                    <div class="leftholder">
                        <!-- @if(session()->has('error'))
                            <div class="alert alert-danger">
                                {{ session()->get('error') }}
                            </div>
                        @endif -->
                        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
                        <!-- <div class="pg-title">Make Your Booking</div> -->
                        {!!
                        Form::open(['route'=>['admin.placeBooking'],'class'=>'form-horizontal','novalidate'=>'novalidate','id'=>"validate-form"])
                        !!}
                        <div id="logged-in-msg"></div>
                        <!-- @if(Auth::guard('web')->check())
                        <div width="100%" border="0" cellspacing="5" cellpadding="5">
                            <div class="form-group">
                                <div style="color: #5cb85c">
                                    You're logged in as {{Auth::guard('web')->user()->email}}, Please continue your
                                    booking process.
                                </div>
                            </div>
                        </div>
                        @else -->
                        <div width="100%" border="0" cellspacing="5" cellpadding="5">
                            <div id="choose-customerInfoType">
                                <div class="radio-btns">
                                    @if($infoTypesAdmin)
                                    @foreach($infoTypesAdmin as $key=>$infoType)
                                    <input type="radio" name="customerInfoType" value="{{$key}}" class="required"
                                        aria-required="true" @if($key==$tripData->customerInfoType) checked @endif >
                                    {{$infoType}}<br>
                                    @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endif

                        <div width="100%" border="0" cellspacing="5" cellpadding="5">
                            <legend><strong>Client Details</strong></legend>
                            <div class="form-group">
                                <label class="col-sm-4 col-xs-6 control-label">Name:</label>
                                <div class="col-sm-8 col-xs-6">
                                    <input type="text" id="fname" name="fname" placeholder="Name"
                                        autocomplete="off" class="form-control inputst1"
                                        value="{{$tripData->pickupAddress}}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 col-xs-6 control-label">Email:</label>
                                <div class="col-sm-8 col-xs-6">
                                    <input type="text" id="email" name="email" placeholder="Email"
                                        autocomplete="off" class="form-control inputst1"
                                        value="{{$tripData->pickupAddress}}">
                                </div>
                            </div>

                            <legend><strong>Passengers Details</strong></legend>
                            <div class="form-group">
                                <label class="col-sm-4 col-xs-6 control-label">No. of Passengers</label>
                                <div class="col-sm-8 col-xs-6">
                                    {!!
                                    Form::selectRange('passengers',1,$vehicle->passengers,$tripData->passengers,['class'=>'form-control
                                    select1']) !!}
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 col-xs-6 control-label">No. of Luggage:</label>
                                <div class="col-sm-8 col-xs-6">
                                    {!!
                                    Form::selectRange('luggages',0,$vehicle->luggages,$tripData->luggage,['class'=>'form-control
                                    select1','id'=>'luggages']) !!}
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 col-xs-6 control-label">No. of Hand Bags: </label>
                                <div class="col-sm-8 col-xs-6">
                                    {!!
                                    Form::selectRange('suitecases',0,$vehicle->suitecases,$tripData->handBags,['class'=>'form-control
                                    select1','id'=>'suitecases']) !!}
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 col-xs-6 control-label">Additional Stops:</label>
                                <div class="col-sm-8 col-xs-6">
                                    @if($tripData->stops) {{count($tripData->stops)}} @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 col-xs-6 control-label">Baby Seat / Booster:</label>
                                <div class="col-sm-8 col-xs-6">
                                    {!! Form::select('baby',$babySeats,$tripData->babySeats,['class'=>'form-control select1','id'=>'baby_seat']) !!}
                                </div>
                            </div>

                            <legend><strong>Journey Details</strong></legend>
                            <div class="form-group">
                                <label class="col-sm-4 col-xs-6 control-label">Pick up Address:</label>
                                <div class="col-sm-8 col-xs-6">
                                    {{$tripData->start}}
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 col-xs-6 control-label">Address Line:</label>
                                <div class="col-sm-8 col-xs-6">
                                    <input type="text" id="pickup_address" name="pickup_address" placeholder="Address"
                                        autocomplete="off" class="form-control inputst1"
                                        value="{{$tripData->pickupAddress}}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 col-xs-6 control-label">Pick Up Date:</label>
                                <div class="col-sm-8 col-xs-6">
                                    <input class="form-control" type="date" id="pickup_date" name="pickup_date"
                                        value="{{$tripData->pickupDate}}" autocomplete="off">
                                    <span
                                        class="hws_error text-right text-danger">{{ $errors->first('pickup_date') }}</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 col-xs-6 control-label">Pick Up Time:</label>
                                <div class="col-sm-8 col-xs-6">
                                    <input class="form-control" type="time" id="pickupTime" name="pickupTime"
                                        value="{{$tripData->pickupTime}}" autocomplete="off">
                                    <span
                                        class="hws_error text-right text-danger">{{ $errors->first('pickupTime') }}</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 col-xs-6 control-label">Drop off Address:</label>
                                <div class="col-sm-8 col-xs-6">
                                    {{$tripData->end}}
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 col-xs-6 control-label">Address Line:</label>
                                <div class="col-sm-8 col-xs-6">
                                    <input type="text" id="drop_address" name="drop_address" placeholder="Address"
                                        autocomplete="off" class="form-control inputst1"
                                        value="{{$tripData->dropAddress}}">
                                </div>
                            </div>
                            @if($tripData->stops)
                            <div class="form-group">
                                <label class="col-sm-4 col-xs-6 control-label">Additional Stops:</label>
                                <div class="col-sm-8 col-xs-6">
                                    @foreach($tripData->stops as $stop)
                                    <span style="display: block;">- {{$stop}}</span>
                                    @endforeach
                                </div>
                            </div>
                            @endif
                            <div class="form-group">
                                <label class="col-sm-4 col-xs-6 control-label">Distance:</label>
                                <div class="col-sm-8 col-xs-6">
                                    {{$tripData->distance}} {{$tripData->distanceUnit}}
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 col-xs-6 control-label">Price:</label>
                                <div class="col-sm-8 col-xs-6" id="ajaxCheckout">
                                    @include('ajaxCheckout')
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 col-xs-6 control-label">Vehicle:</label>
                                <div class="col-sm-8 col-xs-6">
                                    {{$vehicle->name}}
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 col-xs-6 control-label">Instructions:</label>
                                <div class="col-sm-8 col-xs-6">
                                    <textarea rows="3" class="form-control text_area"
                                        name="instructions">{{$tripData->instructions}}</textarea>
                                </div>
                            </div>
                            @if($tripData->route_type=="two_way")
                            <legend><strong>Return Details</strong></legend>
                            <div class="form-group">
                                <label class="col-sm-4 col-xs-6 control-label">Pick Up Date:</label>
                                <div class="col-sm-8 col-xs-6">
                                    <input type="date" id="return_pickup" name="return_pickup_date"
                                        value="{{$tripData->returnDetails->pickupDate}}" autocomplete="off"
                                        class="form-control inputst1">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 col-xs-6 control-label">Pick Up Time:</label>
                                <div class="col-sm-8 col-xs-6">
                                    <input class="form-control" type="time" id="returnPickupTime"
                                        name="returnPickupTime" value="{{$tripData->returnDetails->pickupTime}}"
                                        autocomplete="off">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 col-xs-6 control-label">Pick Up Address:</label>
                                <div class="col-sm-8 col-xs-6">
                                    <input type="text" id="return_pickup_address" name="return_pickup_address"
                                        placeholder="Address" autocomplete="off" class="form-control inputst1 required"
                                        value="{{$tripData->returnDetails->pickupAddress}}" aria-required="true">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 col-xs-6 control-label">Drop off Address:</label>
                                <div class="col-sm-8 col-xs-6">
                                    <input type="text" id="return_pickupaddress" name="return_dropoff_address"
                                        placeholder="Address" autocomplete="off" class="form-control inputst1 required"
                                        value="{{$tripData->returnDetails->dropAddress}}" aria-required="true">
                                </div>
                            </div>
                            @endif
                            <div class="form-group" style="display:none">
                                <label class="col-sm-4 col-xs-6 control-label">Payment Type:</label>
                                <div class="col-sm-8 col-xs-6">
                                    <input type="radio" name="payment_type" value="paypal" checked="">
                                    Card / Paypal
                                    <input type="radio" name="payment_type" value="cash">
                                    Cash to Driver
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 col-xs-6 control-label"></label>
                                <div class="col-sm-8 col-xs-6">
                                    <input type="checkbox" name="checkbox" id="checkbox" value="1" class="required"
                                        checked="" aria-required="true">
                                    I agree to the <a href="{{route('user.customerTerms')}}" target="_blank">Terms and
                                        Conditions</a>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 col-xs-6 control-label"></label>
                                <div class="col-sm-8 col-xs-6">
                                    <input type="submit" class="submit" value="Book Now">
                                </div>
                            </div>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<style>
    .inputst1 {
        margin-left: 0px;
    }
</style>
@endsection
@push('footer-scripts')
<script type="text/javascript">
var fare = '{{$fare}}';

$(document).ready(function() {

    // $("#validate-form").validate();
    $('#customer-info-form').hide();
    $('#login-form').hide();
    $('#only-for-business').hide();

    showHideCustomerInfoBox();

    $('input[name="customerInfoType"]').change(function() {
        showHideCustomerInfoBox();
    });

    $('input[name="account_type"]').change(function() {
        showHiddenBusinessBox();
    });

    $("#baby_seat").change(function() {
        var baby_seat = $(this).val();
        var data = {
            baby: baby_seat
        }
        updateCheckout(data);
    });

    $('input[name="email"]').change(function() {

        var email = $('input[name="email"]').val();
        $.ajax({
            type: "POST",
            url: "ajaxRequest.php",
            data: {
                'function': 'checkIfEmailExists',
                'email': email
            },
            //dataType: "json",
            success: function(response) {
                if (response == 'exists') {
                    alert("Email Already Exists. Please try another!");
                    $('input[name="email"]').val('');
                    $('input[name="email"]').focus();
                }
            }
        });

    });

    $('input[name="confirm-email"]').change(function() {

        var email = $('input[name="email"]').val();
        var confirmEmail = $('input[name="confirm-email"]').val();

        if (email == '' || confirmEmail == '')
            return;

        if (email != confirmEmail) {
            alert("Email Mismatch! Enter Again.");
            $('input[name="confirm-email"]').val('');
            $('input[name="confirm-email"]').focus();
        }

    });
});

function showHideCustomerInfoBox() {
    if ($('input[name="customerInfoType"]:checked').val() == 'book-without-register') {
        $('#customer-info-form').show();
        $('.password-field').hide();
        $('#login-form').hide();
    } else if ($('input[name="customerInfoType"]:checked').val() == 'book-with-register') {
        $('#customer-info-form').show();
        $('.password-field').show();
        $('#login-form').hide();
    } else if ($('input[name="customerInfoType"]:checked').val() == 'book-with-login') {
        $('#customer-info-form').hide();
        $('#login-form').show();
    }
}

function showHiddenBusinessBox() {
    if ($('input[name="account_type"]:checked').val() == 'business') {
        $('#only-for-business').show();
    } else if ($('input[name="account_type"]:checked').val() == 'personal') {
        $('#only-for-business').hide();
    }
}


function updateCheckout(data = null) {
    //$(".loader_html").show();
    var url = "{{ route('admin.checkout') }}";
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: url,
        method: 'GET',
        data: data,
    }).done(function(data) {
        //$(".loader_html").hide();
        $('#ajaxCheckout').html(data);
    }).fail(function() {
        window.href = "";
    });
}

</script>
@endpush
