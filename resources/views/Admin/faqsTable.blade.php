<div class="pagi_row">
  <div class="page_counts"> 
        Results: {{ $faqs->firstItem() }}
        - {{ $faqs->lastItem() }}
        of 
      {{ $faqs->total() }}
  </div>
  <div class="vehi_pagination"> 
      {{ $faqs->links() }}
  </div> 
</div>
<table  class="all_users table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
  <thead>
    <tr>
      <th style="min-width: 120px;">Title</th>
      <th>Answer</th>
      <th style="min-width:95px;">Date</th>
      <th style="width: 112px;">Action</th>
    </tr>
  </thead>
  <tbody>
    @if($faqs->total()>0)
      @foreach ($faqs as $faq)
        <tr>
          <td>{{ $faq->question }}</td>
          <td>{!! $faq->answer !!}</td>
          <td>{{ $faq->created_at->format('d-M-Y') }}</td>
          <td class=" last">
            <a title="Edit Blog" href="{{ route('admin.faqs.edit',['faq_id'=>$faq->id]) }}" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> </a>
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
        Results: {{ $faqs->firstItem() }}
        - {{ $faqs->lastItem() }}
        of 
      {{ $faqs->total() }}
  </div>
  <div class="vehi_pagination"> 
      {{ $faqs->links() }}
  </div>
</div>
