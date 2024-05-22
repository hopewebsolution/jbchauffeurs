@extends('Admin/masters/master')
@section('title', 'Add Block')
@push('page-scripts')
@endpush
@if($sidebarBlock->id)
  @section('page_title','Edit Block')
@else
  @section('page_title','Add Block')
@endif
@section('content')
  <!-- page content -->
  <div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
      {!! Form::open(['route' =>['admin.sideBlocks.create',$sidebarBlock->id],'files' => true]) !!}
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
                        {!! Form::text('title',$sidebarBlock->title,['class'=>'form-control']) !!}
                        <span class="hws_error text-right text-danger">{{ $errors->first('title') }}</span>
                      </div>
                      <div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback" style="position: relative;">
                        <label for="link" class="hws_form_label">Link:<span class="text-danger small">* </span></label>
                        {!! Form::text('link',$sidebarBlock->link,['class'=>'form-control']) !!}
                        <span class="hws_error text-right text-danger">{{ $errors->first('link') }}</span>
                      </div>
                      <div class="col-md-4 col-sm-6 col-xs-4 form-group has-feedback" style="position: relative;">
                        <label for="type" class="hws_form_label">Type:<span class="text-danger small">* </span></label>
                        {!! Form::select('type',['app'=>'App','text'=>'Text Block'],$sidebarBlock->type, ['class'=>'form-control','id'=>'type','required'=>'required']) !!}
                        <span class="hws_error text-danger text-right">{{ $errors->first('type') }}</span>
                      </div>
                      <div class="col-md-4 col-sm-6 col-xs-4 form-group has-feedback" style="position: relative;">
                        <label for="is_sidebar" class="hws_form_label">Sidebar:<span class="text-danger small">* </span></label>
                        {!! Form::select('is_sidebar',['0'=>'No','1'=>'YES'],$sidebarBlock->is_sidebar, ['class'=>'form-control','id'=>'is_sidebar','required'=>'required']) !!}
                        <span class="hws_error text-danger text-right">{{ $errors->first('is_sidebar') }}</span>
                      </div>
                      <div class="col-md-4 col-sm-6 col-xs-4 form-group has-feedback" style="position: relative;">
                        <label for="is_home" class="hws_form_label">Show Home:<span class="text-danger small">* </span></label>
                        {!! Form::select('is_home',['0'=>'No','1'=>'YES'],$sidebarBlock->is_home, ['class'=>'form-control','id'=>'is_home','required'=>'required']) !!}
                        <span class="hws_error text-danger text-right">{{ $errors->first('is_home') }}</span>
                      </div>
                      <div class="col-md-4 col-sm-6 col-xs-4 form-group has-feedback" style="position: relative;">
                        <label for="status" class="hws_form_label">Show / Hide:<span class="text-danger small">* </span></label>
                        {!! Form::select('status',['0'=>'No','1'=>'YES'],$sidebarBlock->status, ['class'=>'form-control','id'=>'status','required'=>'required']) !!}
                        <span class="hws_error text-danger text-right">{{ $errors->first('status') }}</span>
                      </div>
                    </div>
                                        
                    <div class="row"> 
                      <div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback" style="position: relative;">
                        <label for="descriptions" class="hws_form_label">Description:</label>
                        {!! Form::textarea('descriptions',$sidebarBlock->descriptions,['class'=>'form-control','rows'=>"5",'id'=>'editor']) !!}
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
                          <label>Image<small> (Size 500 x 385px)</small></label>
                          {!! Form::file('image',['class'=>'form-control','id'=>'image','onchange'=>'preview(this);']) !!}
                      </div>
                      <div id="icon_img">
                        @if($sidebarBlock->image)
                        <a title="Delete image" href="#" class="btn btn-danger btn-xs deleteFile"><i class="fa fa-trash"></i> </a>
                        <input type="hidden" name="imageName" value="{{$sidebarBlock->image}}">
                        <img class="side_img" src="{{ $sidebarBlock->image }}">
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