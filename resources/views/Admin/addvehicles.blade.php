@extends('Admin/masters/master')
@section('title', 'Vehicles')
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
</style>
<div id="midwrap1">

    <div class="container">
        <div class="cntblock">
            <div class="row">
                <div class="col-md-8 col-sm-8">
                    <div class="leftholder">
                        <div class="pg-title">Available Vehicles </div>
                        <p style="margin-bottom:10px;"><strong>Pick Up Point : </strong>{{$tripData->start}}</p>
                        <p style="margin-bottom:10px;"><strong>Drop Off Point : </strong>{{$tripData->end}}</p>
                        <p style="margin-bottom:10px;"><strong>Distance : </strong>{{$tripData->distance}} {{$tripData->distanceUnit}}</p>
                        <div class="clear"></div>
                        <div class="vehicles">
                            @if($vehicles->total()>0)
                            @foreach($vehicles as $vehicle)
                                <div class="tabholder" style="float: left;width: 100%;">
                                    {!! Form::open(['route' =>['admin.addCarToCart']]) !!}
                                        <p class="txtst1" style="margin-bottom:10px;">{{$vehicle->name}}</p>
                                        <input type="hidden" name="vehicle_id" value="{{$vehicle->id}}">
                                        <div class="row">
                                            <div class="col-md-5 col-lg-6 image_block">
                                                <img src="{{$vehicle->image}}">
                                            </div>
                                            <div class="col-md-7 col-lg-6 right_block">
                                                <p style="margin-bottom:0px;">{{$vehicle->passengers}} Passengers, {{$vehicle->luggages}} Luggage, {{$vehicle->suitecases}} Hand Bags</p>
                                                <p style="margin-bottom: 0px;font-weight: bold;">Price:</p>
                                                <div class="price_box" width="100%" border="0" cellpadding="0">
                                                    <p>
                                                        <input type="radio" name="route_type" value="one_way" checked id="one_way_{{$vehicle->id}}">
                                                        <label for="one_way_{{$vehicle->id}}">One Way {{$common->adminCountry['currency']}}{{$vehicle->cost($tripData->distance,$vehicle->fares,$fixedAmount)}}</label>

                                                    </p>
                                                    <p>
                                                        <input type="radio" value="two_way" name="route_type" id="two_way_{{$vehicle->id}}">
                                                        <label for="two_way_{{$vehicle->id}}">Two Way {{$common->adminCountry['currency']}}{{$vehicle->cost($tripData->distance,$vehicle->fares,$fixedAmount,2)}}</label>
                                                    </p>
                                                </div>
                                                <div style="margin-top:5px;">
                                                    <input type="submit" class="submit" value="Book Now">
                                                </div>
                                            </div>
                                        </div>

                                    {!! Form::close() !!}
                                </div>
                                <div class="clear"></div>
                            @endforeach
                            @else
                            <div class='notification n-information'>No records to display.</div>
                            @endif
                            <div class="pagi_row">
                                <div class="page_counts">
                                    Results: {{ $vehicles->firstItem() }}
                                    - {{ $vehicles->lastItem() }}
                                    of
                                  {{ $vehicles->total() }}
                                </div>
                                <div class="vehi_pagination">
                                    {{ $vehicles->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
@push('footer-scripts')

@endpush
