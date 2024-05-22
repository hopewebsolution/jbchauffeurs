@extends('Admin/masters/master')
@section('title', 'Users')
@push('page-scripts')
@endpush
@section('content')
  <div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="x_panel">
        <div class="x_title">
          <h2>All Users</h2>
          <div class="clearfix"></div>
        </div>
        <div class="title_right">
          <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
            <div class="input-group">
              <input type="text" id="search_key" class="form-control searchInput" placeholder="Search for...">
              <span class="input-group-btn">
                <button class="btn btn-default" type="button">Go!</button>
              </span>
            </div>
          </div>
        </div>
        <div class="x_content hws_table_responsive" id="ajax_data">
          @include('Admin.usersTable')
        </div>
      </div>
    </div> 
  </div>
@endsection
@push('footer-scripts')
<script>
  $(document).ready(function(){
    $('.searchInput').on('keyup', function(){
      var out_put=$("#ajax_data");
      var search_key=$(this).val();
      if(search_key!=""){
        search_key="/"+search_key;
      }
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
      $.ajax({
        url : "{{ route('admin.users.search') }}"+search_key,
        method: 'GET',
      }).done(function (data){
        out_put.html(data);
      }).fail(function () {
        console.log("unable to get data!");
      }); 
    });
    $(document).on("change", '.status_change', function(event){ 
      var status = $(this).val();
      var sel_obj=$(this);
      var user_id=$(this).attr('user-id');
      console.log(status);
      var url="{{ route('admin.users.status') }}";
      var data={'status':status,'user_id':user_id};
      if(confirm("Are You sure want to change this user status?")){
        userStatus(url,data);
      }else{
        window.location.href="";
      }
    });

    $(document).on("click", '.delete', function(event){ 
      var id=$(this).attr('data-id');
      var click_obj=$(this);
      var url="{{ route('admin.users.delete') }}";
      var data={'id':id};
      if(confirm("Are You sure want to delete this?")){
          deleteRow(url,data,click_obj);
      }
    });
  });
  function deleteRow(url,data,click_obj){
    $(".loader_html").show();
    $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url : url,
        method: 'POST',
        data: data,
    }).done(function (data){
        if(data.success==1){
          click_obj.parent().parent().remove();
          new PNotify({
            title: 'Success',
            text: data.message,
            delay:2000,
            type:'success',
            styling:'bootstrap3'
          });    
        }else{
          new PNotify({
            title: 'Error',
            text: data.message,
            delay:4000,
            type:'error',
            styling:'bootstrap3'
          }); 
        }
        $(".loader_html").hide();
        console.log("updated done");
    }).fail(function () {
        $(".loader_html").hide();
        console.log("Somehing went wrong please try again!");
    });    
  }
  function userStatus(url,data){
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
    $.ajax({
        url : url,
        method: 'POST',
        data: data,
    }).done(function (data){
      new PNotify({
        title: 'Success',
        text: data.message,
        delay:2000,
        type:'success',
        styling:'bootstrap3'
      });
      console.log("updated done");
    }).fail(function () {
      console.log("Somehing went wrong please try again!");
    });    
  }
</script>
@endpush
