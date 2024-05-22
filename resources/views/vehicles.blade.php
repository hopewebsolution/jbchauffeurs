@extends('masters/master')
@section('title', 'Vehicles')
@section('content')
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
                                    {!! Form::open(['route' =>['user.addCarToCart']]) !!}
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
                                                        <label for="one_way_{{$vehicle->id}}">One Way {{$common->currCountry['currency']}}{{$vehicle->cost($tripData->distance,$vehicle->fares,$fixedAmount)}}</label>

                                                    </p>
                                                    <p>
                                                        <input type="radio" value="two_way" name="route_type" id="two_way_{{$vehicle->id}}">
                                                        <label for="two_way_{{$vehicle->id}}">Two Way {{$common->currCountry['currency']}}{{$vehicle->cost($tripData->distance,$vehicle->fares,$fixedAmount,2)}}</label>
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
    
@endpush