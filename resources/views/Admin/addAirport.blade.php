@extends('Admin/masters/master')
@section('title', 'Add Airport')
@push('page-scripts')
@endpush
@if($airport_id)
  @section('page_title','Edit Airport')
@else
  @section('page_title','Add Airport')
@endif
@section('content')
  <!-- page content -->
  <div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
      {!! Form::open(['route'=>['admin.airports.create',$airport_id],'files' => true]) !!}
        @if ($errors->any())
          <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach   
          </div>
        @endif
        <div class="row">
          <div class="col-sm-8">
              <div class="x_panel">
                  <div class="x_title">
                      <h2 class="sub_title">Page Content</h2>
                      <ul class="nav navbar-right panel_toolbox">
                          <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                          <li><a class="close-link"><i class="fa fa-close"></i></a></li>
                      </ul>
                      <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <div class="row">
                      <div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback" style="position: relative;">
                        <label for="title" class="hws_form_label">Airport Name:<span class="text-danger small">* </span></label>
                        {!! Form::text('title',$airport->title,['class'=>'form-control','required'=>'required','data-type'=>'text']) !!}
                        <span class="hws_error text-right text-danger">{{ $errors->first('title') }}</span>
                      </div>
                      <div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback" style="position: relative;">
                        <label for="short_desc" class="hws_form_label">Short Description::</label>
                        {!! Form::textarea('short_desc',$airport->short_desc,['class'=>'form-control','rows'=>"5",'id'=>'short_desc']) !!}
                        <span class="hws_error text-danger text-right">{{ $errors->first('short_desc') }}</span>
                      </div>
                      <div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback" style="position: relative;">
                        <label for="descriptions" class="hws_form_label">Description:</label>
                        {!! Form::textarea('descriptions',$airport->descriptions,['class'=>'form-control','rows'=>"5",'id'=>'editor']) !!}
                        <span class="hws_error text-danger text-right">{{ $errors->first('descriptions') }}</span>
                      </div>
                    </div>                   
                  </div>
              </div>
          </div>
          <div class="col-sm-4">
              <div class="x_panel">
                  <div class="x_title">
                      <h2 class="sub_title">Page Image</h2>
                      <div class="clearfix"></div>
                  </div>
                  <div class="x_content">

                      <div class="form-group">
                          <label>Image <small>(Size 296px x 155px)</small>:</label>
                          {!! Form::file('image',['class'=>'form-control','id'=>'image','onchange'=>'preview(this);']) !!}
                      </div>
                      
                      <div id="icon_img">
                        @if($airport->image)
                        <a title="Delete image" href="#" class="btn btn-danger btn-xs deleteFile"><i class="fa fa-trash"></i> </a>
                        <input type="hidden" name="imageName" value="{{$airport->image}}">
                        <img class="side_img" src="{{ $airport->image }}">
                        @endif
                      </div>
                  </div>
              </div>
              <div class="x_panel">
                  <div class="x_content text-center">
                      <button class="btn btn-primary btn-fw" type="submit"><i class="fa fa-check"></i> Update &amp; Save</button>
                  </div>
              </div>
          </div>
        </div>
      {!! Form::close() !!}
    </div> 
  </div>
  <!-- /page content -->
@endsection
@push('footer-scripts')
  <script>
      
  </script>
@endpush