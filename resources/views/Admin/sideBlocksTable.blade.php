<div class="pagi_row">
  <div class="page_counts"> 
        Results: {{ $sidebarBlocks->firstItem() }}
        - {{ $sidebarBlocks->lastItem() }}
        of 
      {{ $sidebarBlocks->total() }}
  </div>
  <div class="vehi_pagination"> 
      {{ $sidebarBlocks->links() }}
  </div> 
</div>
<table  class="all_users table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
  <thead>
    <tr>
      <th style="min-width: 120px;">Title</th>
      <th>Type</th>
      <th>Show Home</th>
      <th>Image</th>
      <th style="min-width:95px;">Date</th>
      <th style="width: 112px;">Action</th>
    </tr>
  </thead>
  <tbody>
    @if($sidebarBlocks->total()>0)
      @foreach ($sidebarBlocks as $sidebarBlock)
        <tr>
          <td>{{ $sidebarBlock->title }}</td>
          <td>{{ $sidebarBlock->type }}</td>
          <td>{{ $sidebarBlock->is_home }}</td>
          <td>@if($sidebarBlock->image)<img class="service_img" src="{{ $sidebarBlock->image }}"> @else NA @endif</td>
          <td>{{ $sidebarBlock->created_at->format('d-M-Y') }}</td>
          <td class=" last">
            <a title="Edit Page" href="{{ route('admin.sideBlocks.edit',['block_id'=>$sidebarBlock->id]) }}" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> </a>
            <a title="Delete" href="#" class="btn btn-danger btn-xs delete" data-id="{{$sidebarBlock->id}}"><i class="fa fa-trash"></i> </a>
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
        Results: {{ $sidebarBlocks->firstItem() }}
        - {{ $sidebarBlocks->lastItem() }}
        of 
      {{ $sidebarBlocks->total() }}
  </div>
  <div class="vehi_pagination"> 
      {{ $sidebarBlocks->links() }}
  </div>
</div>
