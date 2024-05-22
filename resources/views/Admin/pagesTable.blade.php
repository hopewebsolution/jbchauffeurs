<div class="pagi_row">
  <div class="page_counts"> 
        Results: {{ $pages->firstItem() }}
        - {{ $pages->lastItem() }}
        of 
      {{ $pages->total() }}
  </div>
  <div class="vehi_pagination"> 
      {{ $pages->links() }}
  </div> 
</div>
<table  class="all_users table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
  <thead>
    <tr>
      <th style="min-width: 120px;">Name</th>
      <th style="min-width: 120px;">Page Type</th>
      <th>Image</th>
      <th style="min-width:95px;">Date</th>
      <th style="width: 112px;">Action</th>
    </tr>
  </thead>
  <tbody>
    @if($pages->total()>0)
      @foreach ($pages as $page)
        <tr>
          <td>{{ $page->name }}</td>
          <td>{{ $page->page_type }}</td>
          <td>@if($page->image)<img class="service_img" src="{{ $page->image }}"> @else NA @endif</td>
          <td>{{ $page->created_at->format('d-M-Y') }}</td>
          <td class=" last">
            <a title="Edit Page" href="{{ route('admin.pages.edit',['page_id'=>$page->id]) }}" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> </a>
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
        Results: {{ $pages->firstItem() }}
        - {{ $pages->lastItem() }}
        of 
      {{ $pages->total() }}
  </div>
  <div class="vehi_pagination"> 
      {{ $pages->links() }}
  </div>
</div>
