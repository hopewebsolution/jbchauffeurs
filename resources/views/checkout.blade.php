@extends('masters/master')
@section('title', 'Booking Checkout')
@section('content')
<div id="midwrap1">
    <div class="container">
        <div class="cntblock">
            <div class="row">
                <div class="col-md-8 col-sm-8">
                    <div class="leftholder">
                        @if(session()->has('error'))
                            <div class="alert alert-danger">
                                {{ session()->get('error') }}
                            </div>
                        @endif
                        <div class="pg-title">Make Your Booking</div>
                        {!!
                        Form::open(['route'=>['user.placeBooking'],'class'=>'form-horizontal','novalidate'=>'novalidate','id'=>"validate-form"])
                        !!}
                        <div id="logged-in-msg"></div>
                        @if(Auth::guard('web')->check())
                        <div width="100%" border="0" cellspacing="5" cellpadding="5">
                            <div class="form-group">
                                <div style="color: #5cb85c">
                                    You're logged in as {{Auth::guard('web')->user()->email}}, Please continue your
                                    booking process.
                                </div>
                            </div>
                        </div>
                        @else
                        <div width="100%" border="0" cellspacing="5" cellpadding="5">
                            <div id="choose-customerInfoType">
                                <div class="radio-btns">
                                    @if($infoTypes)
                                    @foreach($infoTypes as $key=>$infoType)
                                    <input type="radio" name="customerInfoType" value="{{$key}}" class="required"
                                        aria-required="true" @if($key==$tripData->customerInfoType) checked @endif >
                                    {{$infoType}}<br>
                                    @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div width="100%" border="0" cellspacing="5" cellpadding="5">
                            <div id="customer-info-form" style="display: none;">
                                <div class="form-group">
                                    <label class="col-sm-4 col-xs-6 control-label">First Name:</label>
                                    <div class="col-sm-8 col-xs-6">
                                        {!! Form::text('fname','',['class'=>'form-control inputst1
                                        required','required'=>'required','placeholder'=>'First Name']) !!}
                                        <span
                                            class="hws_error text-right text-danger">{{ $errors->first('fname') }}</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 col-xs-6 control-label">Last Name:</label>
                                    <div class="col-sm-8 col-xs-6">
                                        {!! Form::text('lname','',['class'=>'form-control inputst1
                                        required','required'=>'required','placeholder'=>'Last Name']) !!}
                                        <span
                                            class="hws_error text-right text-danger">{{ $errors->first('lname') }}</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 col-xs-6 control-label">Phone:</label>
                                    <div class="col-sm-8 col-xs-6">
                                        {!! Form::number('phone','',['class'=>'form-control inputst1
                                        required','required'=>'required','placeholder'=>'Phone']) !!}
                                        <span
                                            class="hws_error text-right text-danger">{{ $errors->first('phone') }}</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 col-xs-6 control-label">Mobile Num.</label>
                                    <div class="col-sm-8 col-xs-6">
                                        {!! Form::number('mobile','',['class'=>'form-control inputst1
                                        required','required'=>'required','placeholder'=>'Mobile Number']) !!}
                                        <span
                                            class="hws_error text-right text-danger">{{ $errors->first('mobile') }}</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 col-xs-6 control-label">Email:</label>
                                    <div class="col-sm-8 col-xs-6">
                                        {!! Form::email('email','',['class'=>'form-control inputst1
                                        required','required'=>'required','placeholder'=>'Email']) !!}
                                        <span
                                            class="hws_error text-right text-danger">{{ $errors->first('email') }}</span>
                                    </div>
                                </div>
                                <div class="form-group password-field">
                                    <label class="col-sm-4 col-xs-6 control-label">Account Type:</label>
                                    <div class="col-sm-8 col-xs-6">
                                        <input type="radio" name="account_type" value="personal" checked="">
                                        Personal<br>
                                        <input type="radio" name="account_type" value="business"> Business
                                    </div>
                                </div>


                                <!--Only for Businness Registration-->
                                <div id="only-for-business" style="display: none;">
                                    <fieldset>
                                        <legend>Business Details:</legend>
                                        <div class="form-group">
                                            <label class="col-sm-4 col-xs-6 control-label">Company Name:</label>
                                            <div class="col-sm-8 col-xs-6">
                                                <input type="text" name="company_name" placeholder="Company Name"
                                                    autocomplete="off" class="form-control company_name" value="">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-4 col-xs-6 control-label">Company Address :</label>
                                            <div class="col-sm-8 col-xs-6">
                                                <input type="text" name="company_address" placeholder="Company Address"
                                                    autocomplete="off" class="form-control company_address" value="">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-4 col-xs-6 control-label">Company Phone :</label>
                                            <div class="col-sm-8 col-xs-6">
                                                <input type="text" name="company_phone" placeholder="Company Phone"
                                                    autocomplete="off" class="form-control company_phone" value="">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-4 col-xs-6 control-label">Company Website :</label>
                                            <div class="col-sm-8 col-xs-6">
                                                <input type="text" name="website" placeholder="Company Website"
                                                    autocomplete="off" class="form-control website" value="">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-4 col-xs-6 control-label">Nature of Business:</label>
                                            <div class="col-sm-8 col-xs-6">
                                                <input type="text" name="nature_of_business"
                                                    placeholder="Nature of Business" autocomplete="off"
                                                    class="form-control nature_of_business" value="">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-4 col-xs-6 control-label">Registration Number:</label>
                                            <div class="col-sm-8 col-xs-6">
                                                <input type="text" name="registration_number"
                                                    placeholder="Registration Number" autocomplete="off"
                                                    class="form-control registration_number" value="">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-4 col-xs-6 control-label">Contact Person's
                                                Name:</label>
                                            <div class="col-sm-8 col-xs-6">
                                                <input type="text" name="contact_person_name"
                                                    placeholder="Contact Person's Name" autocomplete="off"
                                                    class="form-control contact_person_name" value="">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-4 col-xs-6 control-label">Contact Person's
                                                Position:</label>
                                            <div class="col-sm-8 col-xs-6">
                                                <input type="text" name="contact_person_position"
                                                    placeholder="Contact Person's Position" autocomplete="off"
                                                    class="form-control contact_person_position" value="">
                                            </div>
                                        </div>
                                    </fieldset>
                                </div>
                                <!--End only for Business Registration-->

                                <div class="form-group password-field">
                                    <label class="col-sm-4 col-xs-6 control-label">Password:</label>
                                    <div class="col-sm-8 col-xs-6">
                                        {!! Form::password('password',['class'=>'form-control inputst1
                                        required','required'=>'required','placeholder'=>"********"]) !!}
                                        <span
                                            class="hws_error text-right text-danger">{{ $errors->first('password') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div width="50%" border="0" cellspacing="5" cellpadding="5">

                            <div id="login-form" style="display: none;">
                                @if ($errors->any())
                                <div class="alert alert-danger">
                                    @foreach ($errors->all() as $error)
                                    {{ $error }}
                                    @endforeach
                                </div>
                                @endif
                                <div class="form-group">
                                    <label class="col-sm-4 col-xs-6 control-label">Login Email:</label>
                                    <div class="col-sm-8 col-xs-6">
                                        <input type="text" name="login_email" class="form-control inputst1">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 col-xs-6 control-label">Password:</label>
                                    <div class="col-sm-8 col-xs-6">
                                        <input type="password" name="login_password" class="form-control inputst1">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 col-xs-6 control-label">&nbsp;</label>
                                    <div class="col-sm-8 col-xs-6">
                                        <button type="submit" class="form-control btn-success">Login</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif

                        <div width="100%" border="0" cellspacing="5" cellpadding="5">
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
                                    {!! Form::select('baby',$babySeats,$tripData->babySeats,['class'=>'form-control
                                    select1','id'=>'baby_seat']) !!}
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
                <div class="col-md-4 col-sm-4">
                    @include('sidebar')
                    <div class="clear"></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('footer-scripts')
<script type="text/javascript">
var fare = '{{$fare}}';

$(document).ready(function() {
    $("#validate-form").validate();
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
    var url = "{{ route('user.checkout') }}";
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