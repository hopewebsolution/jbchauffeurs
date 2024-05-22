<div class="pagi_row">
  <div class="page_counts"> 
        Results: {{ $fares->firstItem() }}
        - {{ $fares->lastItem() }}
        of 
      {{ $fares->total() }}
  </div>
  <div class="vehi_pagination"> 
      {{ $fares->links() }}
  </div> 
</div>
<table  class="all_users table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
  <thead>
    <tr>
      <th>Distance</th>
      <th>Rate</th>
      <th>Vehicle</th>
      <th style="width: 112px;">Action</th>
    </tr>
  </thead>
  <tbody>
    @if($fares->total()>0)
      @foreach ($fares as $fare)
        <tr>
          <td>{{ $fare->start }} - {{ $fare->end }}</td>
          <td>${{ $fare->rate }}</td>
          <td>@if($fare->vehicle) {{$fare->vehicle->name}} @endif</td>
          <td class=" last">
            <a title="Edit Fare" href="{{ route('admin.fares.edit',['id'=>$fare->id]) }}" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> </a>
            <a title="Delete Fare" href="#" class="btn btn-danger btn-xs delete" data-id="{{$fare->id}}"><i class="fa fa-trash"></i> </a>
          </td>
        </tr>
      @endforeach 
    @else
      <tr><td colspan="5" class="text-center">No Record Found</td></tr>
    @endif   
  </tbody>
</table>
<div class="pagi_row">  
  <div class="page_counts"> 
        Results: {{ $fares->firstItem() }}
        - {{ $fares->lastItem() }}
        of 
      {{ $fares->total() }}
  </div>
  <div class="vehi_pagination"> 
      {{ $fares->links() }}
  </div>
</div>
