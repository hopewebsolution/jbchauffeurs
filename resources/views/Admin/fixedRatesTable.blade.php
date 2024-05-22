<div class="pagi_row">
  <div class="page_counts"> 
        Results: {{ $fixedRates->firstItem() }}
        - {{ $fixedRates->lastItem() }}
        of 
      {{ $fixedRates->total() }}
  </div>
  <div class="vehi_pagination"> 
      {{ $fixedRates->links() }}
  </div> 
</div>
<table  class="all_users table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
  <thead>
    <tr>
      <th>Start</th>
      <th>End</th>
      <th>Amount</th>
      <th style="width:95px;">Date</th>
      <th style="width: 112px;">Action</th>
    </tr>
  </thead>
  <tbody>
    @if($fixedRates->total()>0)
      @foreach ($fixedRates as $fixedRate)
        <tr>
          <td>{{ $fixedRate->start }}</td>
          <td>{{ $fixedRate->end }}</td>
          <td>${{ $fixedRate->amount }}</td>
          <td>{{ $fixedRate->created_at->format('d-M-Y') }}</td>
          <td class=" last">
            <a title="Edit Rate" href="{{ route('admin.fixedRates.edit',['id'=>$fixedRate->id]) }}" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> </a>
            <a title="Delete Rate" href="#" class="btn btn-danger btn-xs delete" data-id="{{$fixedRate->id}}"><i class="fa fa-trash"></i> </a>
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
        Results: {{ $fixedRates->firstItem() }}
        - {{ $fixedRates->lastItem() }}
        of 
      {{ $fixedRates->total() }}
  </div>
  <div class="vehi_pagination"> 
      {{ $fixedRates->links() }}
  </div>
</div>
