@extends('Admin/masters/master')
@section('title', 'Add Slider')
@push('page-scripts')
@endpush
@if($slide_id)
  @section('page_title','Edit Slider')
@else
  @section('page_title','Add Slider')
@endif
@section('content')
  <!-- page content -->
  <div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
      {!! Form::open(['route' =>['admin.sliders.create',$slide_id],'files' => true]) !!}
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
                        <label for="title" class="hws_form_label">Title:<span class="text-danger small">* </span></label>
                        {!! Form::text('title',$slider->title,['class'=>'form-control','required'=>'required','data-type'=>'text']) !!}
                        <span class="hws_error text-right text-danger">{{ $errors->first('title') }}</span>
                      </div>
                      <div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback" style="position: relative;">
                        <label for="slide_img" class="hws_form_label">Slide Image: (1350px X 510px)<span class="text-danger small">* </span></label>
                        {!! Form::file('slide_img',['class'=>'form-control','id'=>'slide_img','onchange'=>'preview(this);']) !!}
                        <span class="hws_error text-right text-danger">{{ $errors->first('slide_img') }}</span>
                        <div id="icon_img">
                          @if($slider->slide_img)
                          <img class="side_img" src="{{ $slider->slide_img }}">
                          @endif
                        </div>
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