<div class="pagi_row">
  <div class="page_counts"> 
        Results: {{ $operators->firstItem() }}
        - {{ $operators->lastItem() }}
        of 
      {{ $operators->total() }}
  </div>
  <div class="vehi_pagination"> 
      {{ $operators->links() }}
  </div> 
</div>
<table  class="all_users table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
  <thead>
    <tr>
      <th style="min-width: 120px;">Operator Name</th>
      <th style="min-width: 120px;">Email</th>
      <th style="min-width:95px;">Date</th>
      <th style="width: 112px;">Action</th>
    </tr>
  </thead>
  <tbody>
    @if($operators->total()>0)
      @foreach ($operators as $operator)
        <tr>
          <td>{{ $operator->first_name }}</td>
          <td>{{ $operator->email }}</td>
          <td>{{ $operator->created_at->format('d-M-Y') }}</td>
          <td class=" last">
          <a title="Edit" href="{{ route('admin.operator.edit',['page_id'=>$operator->id]) }}" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> </a>
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
        Results: {{ $operators->firstItem() }}
        - {{ $operators->lastItem() }}
        of 
      {{ $operators->total() }}
  </div>
  <div class="vehi_pagination"> 
      {{ $operators->links() }}
  </div>
</div>
