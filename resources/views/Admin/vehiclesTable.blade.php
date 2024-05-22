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
<table  class="all_users table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
  <thead>
    <tr>
      <th style="min-width: 120px;">Name</th>
      <th>Image</th>
      <th>Passengers</th>
      <th>Hand Bags</th>
      <th>Luggages</th>
      <th>Per Stop</th>
      <th>Parking</th>
      <th>Baby Seat</th>
      <th style="min-width:95px;">Date</th>
      <th style="width: 112px;">Action</th>
    </tr>
  </thead>
  <tbody>
    @if($vehicles->total()>0)
      @foreach ($vehicles as $vehicle)
        <tr>
          <td>{{ $vehicle->name }}</td>
          <td>@if($vehicle->image)<img class="service_img" src="{{ $vehicle->image }}"> @else NA @endif</td>
          <td>{{ $vehicle->passengers }}</td>
          <td>{{ $vehicle->suitecases }}</td>
          <td>{{ $vehicle->luggages }}</td>
          <td>${{ $vehicle->per_stop }}</td>
          <td>${{ $vehicle->parking_charge }}</td>
          <td>${{ $vehicle->baby_seat }}</td>
          <td>{{ $vehicle->created_at->format('d-M-Y') }}</td>
          <td class=" last">
            <a title="Edit Service" href="{{ route('admin.vehicles.edit',['vehicle_id'=>$vehicle->id]) }}" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> </a>
            @if($vehicle->bookings_count==0)
            <a title="Delete Vehicle" href="#" class="btn btn-danger btn-xs delete" data-id="{{$vehicle->id}}"><i class="fa fa-trash"></i> </a>
            @endif
          </td>
        </tr>
      @endforeach 
    @else
      <tr><td colspan="8" class="text-center">No Record Found</td></tr>
    @endif   
  </tbody>
</table>
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
