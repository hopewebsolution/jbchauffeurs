@extends('app.master')
@section('content')
<main id="main" class="main">
    <div class="pagetitle">
        <h1>Booking</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('operator.dashboard')}}">Home</a></li>
                <li class="breadcrumb-item active">Booking</li>
            </ol>
        </nav>
    </div>
    
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
            @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif


                <div class="card">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">Booking Id</th>
                                        <th scope="col">Journey Form</th>
                                        <th scope="col">Journey To</th>
                                        <th scope="col">Pickup Date / Time</th>
                                        <th scope="col">Total</th>
                                        <th scope="col">Date</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @if($bookings->total()>0)
                                @foreach ($bookings as $booking)
                                    <tr>
                                    <td><a href="{{route('bookingviewDetails',$booking->id)}}" style="color: #2196f3;font-weight: bold;">#{{ $booking->id }}</a></td>
                                    <td>{{ $booking->pickup_address_line }}</td>
                                    <td>{{ $booking->end }}</td>
                                    <td>{{ $booking->pickup_date }} {{ $booking->pickup_time }}</td>
                                    <td>${{ $booking->total_fare }}</td>
                                    <td>{{ $booking->created_at->format('d-M-Y') }}</td>
                                    <td><span style="color:blue"> {{$booking->status}}</span></td>
                                    <td>
                                    @if(Auth::guard('weboperator')->check())
                                    <form action="{{ route('accept_booking') }}" method="POST" style="display: inline-block;">
                                        @csrf
                                        <input type="hidden" name="booking_id" value="{{ $booking->id }}">
                                        <button type="submit" style="padding: 5px 10px; background-color: #001e47; color: #fff; text-decoration: none; border: none; border-radius: 4px; float: right;">Accept Booking</button>
                                    </form>
                                     @endif
                                    </td>
                                    </tr>
                                    
                                    @endforeach 
                                @else
                                <tr><td colspan="10" class="text-center">No Record Found</td></tr>
                                @endif 

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="pagi_rowop">
        <div class="page_counts">
            Results: {{ $bookings->firstItem() }}
            - {{ $bookings->lastItem() }}
            of 
            {{ $bookings->total() }}
        </div>
        <div class="vehi_paginationop">
            {{ $bookings->links() }}
        </div>
    </div>
    
    <!-- <ul class="page">
        <li class="page__btn"><span class="material-icons"><i class="bi bi-arrow-left-short"></i></span></li>
        <li class="page__numbers active">1</li>
        <li class="page__numbers">2</li>
        <li class="page__numbers">3</li>
        <li class="page__numbers">4</li>
        <li class="page__numbers">5</li>
        <li class="page__dots">...</li>
        <li class="page__numbers"> 10</li>
        <li class="page__btn active"><span class="material-icons"><i class="bi bi-arrow-right-short"></i></span></li>
    </ul> -->

</main>
@endsection