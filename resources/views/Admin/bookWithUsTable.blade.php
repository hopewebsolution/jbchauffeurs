<div class="pagi_row">
  <div class="page_counts"> 
        Results: {{ $bookWithUs->firstItem() }}
        - {{ $bookWithUs->lastItem() }}
        of 
      {{ $bookWithUs->total() }}
  </div>
  <div class="vehi_pagination"> 
      {{ $bookWithUs->links() }}
  </div> 
</div>
<table  class="all_users table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
  <thead>
    <tr>
      <th style="min-width: 120px;">Title</th>
      <th>Image</th>
      <th style="min-width:95px;">Date</th>
      <th style="width: 112px;">Action</th>
    </tr>
  </thead>
  <tbody>
    @if($bookWithUs->total()>0)
      @foreach ($bookWithUs as $bookWith)
        <tr>
          <td>{{ $bookWith->title }}</td>
          <td>@if($bookWith->image)<img class="service_img" src="{{ $bookWith->image }}" style="object-fit: contain;"> @else NA @endif</td>
          <td>{{ $bookWith->created_at->format('d-M-Y') }}</td>
          <td class=" last">
            <a title="Edit Page" href="{{ route('admin.bookWithUs.edit',['id'=>$bookWith->id]) }}" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> </a>
            <a title="Delete Rate" href="#" class="btn btn-danger btn-xs delete" data-id="{{$bookWith->id}}"><i class="fa fa-trash"></i> </a>
          </td>
        </tr>
      @endforeach 
    @else
      <tr><td colspan="7" class="text-center">No Record Found</td></tr>
    @endif   
  </tbody>
</table>
<div class="pagi_row">  
  <div class="page_counts"> 
        Results: {{ $bookWithUs->firstItem() }}
        - {{ $bookWithUs->lastItem() }}
        of 
      {{ $bookWithUs->total() }}
  </div>
  <div class="vehi_pagination"> 
      {{ $bookWithUs->links() }}
  </div>
</div>
