<div class="pagi_row">
  <div class="page_counts"> 
        Results: {{ $airports->firstItem() }}
        - {{ $airports->lastItem() }}
        of 
      {{ $airports->total() }}
  </div>
  <div class="vehi_pagination"> 
      {{ $airports->links() }}
  </div> 
</div>
<table  class="all_users table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
  <thead>
    <tr>
      <th style="min-width: 120px;">Name</th>
      <th>Image</th>
      <th style="min-width:95px;">Date</th>
      <th style="width: 112px;">Action</th>
    </tr>
  </thead>
  <tbody>
    @if($airports->total()>0)
      @foreach ($airports as $airport)
        <tr>
          <td>{{ $airport->title }}</td>
          <td>@if($airport->image)<img class="service_img" src="{{ $airport->image }}"> @else NA @endif</td>
          <td>{{ $airport->created_at->format('d-M-Y') }}</td>
          <td class=" last">
            <a title="Edit Airport" href="{{ route('admin.airports.edit',['airport_id'=>$airport->id]) }}" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> </a>
            <a title="Delete Airport" href="#" class="btn btn-danger btn-xs delete" data-id="{{$airport->id}}"><i class="fa fa-trash"></i> </a>
          </td>
        </tr>
      @endforeach 
    @else
      <tr><td colspan="4" class="text-center">No Record Found</td></tr>
    @endif   
  </tbody>
</table>
<div class="pagi_row">  
  <div class="page_counts"> 
        Results: {{ $airports->firstItem() }}
        - {{ $airports->lastItem() }}
        of 
      {{ $airports->total() }}
  </div>
  <div class="vehi_pagination"> 
      {{ $airports->links() }}
  </div>
</div>
