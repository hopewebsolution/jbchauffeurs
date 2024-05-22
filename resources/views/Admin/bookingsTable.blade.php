<div class="pagi_row">
  <div class="page_counts"> 
        Results: {{ $bookings->firstItem() }}
        - {{ $bookings->lastItem() }}
        of 
      {{ $bookings->total() }}
  </div>
  <div class="vehi_pagination"> 
      {{ $bookings->links() }}
  </div> 
</div>
<table  class="all_users table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
  <thead>
    <tr>
      <th>Booking#</th>
      <th>Name</th>
      <th>Mobile</th>
      <th>Vehicle</th>
      <th>Start</th>
      <th>End</th>
      <th>Pickup Date</th>
      <th>Total</th>
      <th style="min-width:95px;">Date</th>
      <th style="width: 135px;">Status</th>
      <th style="width: 55px;">Action</th>
    </tr>
  </thead>
  <tbody>
    @if($bookings->total()>0)
      @foreach ($bookings as $booking)
        <tr>
          <td><a href="{{route('admin.bookingDetails',['booking_id'=>$booking->id])}}" style="color: #2196f3;font-weight: bold;">#{{ $booking->id }}</a></td>
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
          <td><a title="Delete Booking" href="#" class="btn btn-danger btn-xs delete" data-id="{{$booking->id}}"><i class="fa fa-trash"></i> </a></td>
        </tr>
      @endforeach 
    @else
      <tr><td colspan="10" class="text-center">No Record Found</td></tr>
    @endif   
  </tbody>
</table>
<div class="pagi_row">  
  <div class="page_counts"> 
        Results: {{ $bookings->firstItem() }}
        - {{ $bookings->lastItem() }}
        of 
      {{ $bookings->total() }}
  </div>
  <div class="vehi_pagination"> 
      {{ $bookings->links() }}
  </div>
</div>
