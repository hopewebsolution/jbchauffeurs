<div class="pagi_row">
  <div class="page_counts"> 
        Results: {{ $services->firstItem() }}
        - {{ $services->lastItem() }}
        of 
      {{ $services->total() }}
  </div>
  <div class="vehi_pagination"> 
      {{ $services->links() }}
  </div> 
</div>
<table  class="all_users table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
  <thead>
    <tr>
      <th style="min-width: 120px;">Name</th>
      <th>Slug</th>
      <th>Image</th>
      <th style="min-width:95px;">Date</th>
      <th style="width: 112px;">Action</th>
    </tr>
  </thead>
  <tbody>
    @if($services->total()>0)
      @foreach ($services as $service)
        <tr>
          <td>{{ $service->name }}</td>
          <td>{{ $service->url_slug }}</td>
          <td>@if($service->image)<img class="service_img" src="{{ $service->image }}"> @else NA @endif</td>
          <td>{{ $service->created_at->format('d-M-Y') }}</td>
          <td class=" last">
            <a title="Edit Service" href="{{ route('admin.services.edit',['service_id'=>$service->id]) }}" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> </a>
            <a title="Delete Service" href="#" class="btn btn-danger btn-xs delete" data-id="{{$service->id}}"><i class="fa fa-trash"></i> </a>
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
        Results: {{ $services->firstItem() }}
        - {{ $services->lastItem() }}
        of 
      {{ $services->total() }}
  </div>
  <div class="vehi_pagination"> 
      {{ $services->links() }}
  </div>
</div>
