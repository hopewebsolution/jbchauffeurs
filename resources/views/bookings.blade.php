@extends('masters/master')
@section('title', 'Bookings')
@section('content')
<div id="midwrap1">
    <div class="container">
        @include('customerNav')
        <div class="search-holder">&nbsp;&nbsp;<strong>Your booking history</strong></div>
        @if(session()->has('error'))
            <div class="alert alert-danger">
                {{ session()->get('error') }}
            </div>
        @endif
        <div id="frm-holder">
            <table class="table-responsive booking_table" width="100%" border="0" cellspacing="0" cellpadding="0">
                <thead>
                    <tr bgcolor="#ebeaea">
                        <th>Booking Id</th>
                        <th>Booked Date/Time</th>
                        <th>Journey From</th>
                        <th>Journey To</th>
                        <th>Pickup Date/Time</th>
                        <th>Fare</th>
                        <th>Country</th>
                        <th class="text-center">Options</th>
                    </tr>
                </thead>
                <tbody>
                    @if($bookings->total()>0)
                    @foreach($bookings as $booking)
                    <tr>
                        <td align="center">BK00{{$booking->id}}</td>
                        <td align="center">{{$booking->created_at}}</td>
                        <td align="center">{{$booking->start}}</td>
                        <td align="center">{{$booking->end}}</td>
                        <td align="center">{{$booking->pickup_date}} {{$booking->pickup_time}}</td>
                        <td align="center">{{$booking->currency}}{{$booking->total_fare}}</td>
                        <td align="center">{{$booking->country}}</td>
                        <td align="center" style="padding-left: 2%">
                            <a href="{{route('user.printBooking',['booking_id'=>$booking->id])}}" target="_blank">View / Print Details</a>
                            @if($booking->status=="pending")
                            <a href="{{route('user.createPayment',['booking_id'=>$booking->id])}}" class="btn btn-success pay_btn">Pay {{$booking->currency}}{{$booking->total_fare}}</a>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                    @else
                    <tr>
                        <td colspan=7 align="center">- No Bookings done yet -</td>
                    </tr>
                    @endif
                </tbody>
            </table>
            <div class="clear"></div>
        </div>
    </div>
</div>
@endsection
@push('footer-scripts')
    
@endpush