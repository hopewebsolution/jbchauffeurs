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
                                        <!-- <th scope="col">Booking Id</th>
                                        <th scope="col">Booked Date / Time</th>
                                        <th scope="col">Journey Form</th>
                                        <th scope="col">Journey To</th>
                                        <th scope="col">Pickup Date / Time</th>
                                        <th scope="col">Fare</th>
                                        <th scope="col">Country</th>
                                        <th scope="col">Options</th> -->
                                        <th scope="col">Booking#</th>
                                        <th scope="col" >Name</th>
                                        <th scope="col">Mobile</th>
                                        <th scope="col">Vehicle</th>
                                        <th scope="col">Start</th>
                                        <th scope="col">End</th>
                                        <th scope="col">Pickup Date</th>
                                        <th scope="col">Total</th>
                                        <th style="min-width:95px;">Date</th>
                                        <th style="width: 135px;">Status</th>

                                    </tr>
                                </thead>
                                <tbody>
                                @if($bookings->total()>0)
                                @foreach ($bookings as $booking)
                                    <tr>
                                    <td><a href="{{route('bookingviewDetails',$booking->id)}}" style="color: #2196f3;font-weight: bold;">#{{ $booking->id }}</a></td>
                                    <td>@if($booking->user){{ $booking->user->fname }} {{ $booking->user->lname }}@endif</td>
                                    <td>@if($booking->user){{ $booking->user->mobile }}@endif</td>
                                    <td>{{ $booking->vehicle->name }}</td>
                                    <td>{{ $booking->start }}</td>
                                    <td>{{ $booking->end }}</td>
                                    <td>{{ $booking->pickup_date }} {{ $booking->pickup_time }}</td>
                                    <td>${{ $booking->total_fare }}</td>
                                    <td>{{ $booking->created_at->format('d-M-Y') }}</td>


                                    <td class=" last">
                                        {!! Form::select('status',$statuss,$booking->status,['class'=>'form-control hws_select status_change','booking-id'=>$booking->id]) !!}
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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script type="text/javascript">
        $(document).ready(function() {
            $('.status_change').on('change', function() {
                var bookingId = $(this).attr('booking-id');
                var status = $(this).val();
                $.ajax({
                    url: "{{ route('update.status') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        booking_id: bookingId,
                        status: status
                    },
                    success: function(response) {
                        if(response.success) {
                            alert(response.message);
                        } else {
                            alert('Failed to update status.');
                        }
                    },
                    error: function(xhr) {
                        console.error('Error:', xhr);
                        alert('An error occurred while updating the status.');
                    }
                });
            });
        });
    </script>
@endsection
