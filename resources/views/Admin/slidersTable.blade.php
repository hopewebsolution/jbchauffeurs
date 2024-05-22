<div class="pagi_row">
  <div class="page_counts"> 
        Results: {{ $sliders->firstItem() }}
        - {{ $sliders->lastItem() }}
        of 
      {{ $sliders->total() }}
  </div>
  <div class="vehi_pagination"> 
      {{ $sliders->links() }}
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
    @if($sliders->total()>0)
      @foreach ($sliders as $slider)
        <tr>
          <td>{{ $slider->title }}</td>
          <td>@if($slider->slide_img)<img class="service_img" src="{{ $slider->slide_img }}"> @else NA @endif</td>
          <td>{{ $slider->created_at->format('d-M-Y') }}</td>
          <td class=" last">
            <a title="Edit Service" href="{{ route('admin.sliders.edit',['slide_id'=>$slider->id]) }}" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> </a>
            <a title="Delete Rate" href="#" class="btn btn-danger btn-xs delete" data-id="{{$slider->id}}"><i class="fa fa-trash"></i> </a>
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
        Results: {{ $sliders->firstItem() }}
        - {{ $sliders->lastItem() }}
        of 
      {{ $sliders->total() }}
  </div>
  <div class="vehi_pagination"> 
      {{ $sliders->links() }}
  </div>
</div>
