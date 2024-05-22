@extends('Admin/masters/master')
@section('title', 'Vehicles Fares')
@push('page-scripts')
@endpush
@section('content')
  <div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="x_panel">
        <div class="x_title">
          <h2>All Fares</h2>
          <div class="navbar-right">
              <a href="{{ route('admin.fares.add') }}" class="btn btn-primary"><i class="fa fa-plus"></i>&nbsp;Add New</a>
          </div>
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
          @include('Admin.faresTable')
        </div>
      </div>
    </div> 
  </div>
@endsection
@push('footer-scripts')
<script>
  $(document).ready(function(){
    $(document).on("click", '.delete', function(event){ 
      var id=$(this).attr('data-id');
      var click_obj=$(this);
      var url="{{ route('admin.fares.delete') }}";
      var data={'id':id};
      if(confirm("Are You sure want to delete this?")){
          deleteRates(url,data,click_obj);
      }
    });
  });
  function deleteRates(url,data,click_obj){
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
</script>
@endpush
