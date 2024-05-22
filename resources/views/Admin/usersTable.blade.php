<div class="pagi_row">
  <div class="page_counts"> 
        Results: {{ $users->firstItem() }}
        - {{ $users->lastItem() }}
        of 
      {{ $users->total() }}
  </div>
  <div class="vehi_pagination"> 
      {{ $users->links() }}
  </div> 
</div>
<table  class="all_users table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
  <thead>
    <tr>
      <th style="min-width: 120px;">Name</th>
      <th>Email</th>
      <th>Phone</th>
      <th>Account Type</th>
      <th style="min-width:95px;">Date</th>
      <th style="width: 135px;">Status</th>
      <th style="width: 55px;">Action</th>
    </tr>
  </thead>
  <tbody>
    @if($users->total()>0)
      @foreach ($users as $user)
        <tr>
          <td>{{ $user->fname }} {{ $user->lname }}</td>
          <td>{{ $user->email }}</td>
          <td>{{ $user->phone }}</td>
          <td>{{ $user->account_type }}</td>
          <td>{{ $user->created_at->format('d-M-Y') }}</td>
          <td class=" last">
            {!! Form::select('status',['active'=>'Active','block'=>'Block'],$user->status,['class'=>'form-control hws_select status_change','user-id'=>$user->id]) !!}
          </td>
          <td><a title="Delete Rate" href="#" class="btn btn-danger btn-xs delete" data-id="{{$user->id}}"><i class="fa fa-trash"></i> </a></td>
        </tr>
      @endforeach 
    @else
      <tr><td colspan="4" class="text-center">No Record Found</td></tr>
    @endif   
  </tbody>
</table>
<div class="pagi_row">  
  <div class="page_counts"> 
        Results: {{ $users->firstItem() }}
        - {{ $users->lastItem() }}
        of 
      {{ $users->total() }}
  </div>
  <div class="vehi_pagination"> 
      {{ $users->links() }}
  </div>
</div>
