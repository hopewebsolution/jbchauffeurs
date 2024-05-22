@extends('Admin/masters/master')
@section('title', 'Change Password')
@push('page-scripts')
@endpush
@section('page_title','Change Password')
@section('content')
  <!-- page content -->
  <div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
      {!! Form::open(['route' =>['admin.updateAdminPwd']]) !!}
        @if ($errors->any())
          <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach   
          </div>
        @endif
        @if(session()->has('success'))
            <div class="row justify-content-center">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="alert alert-success">
                        <strong>{{ session('success') }}</strong>
                    </div>
                </div>
            </div>
        @endif 
        @if(session()->has('error'))
            <div class="row justify-content-center">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="alert alert-danger">
                        <strong>{{ session('error') }}</strong>
                    </div>
                </div>
            </div>
        @endif 
        <div class="row">
          <div class="col-sm-12">
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
                        <label for="old_password" class="hws_form_label">Old Password:<span class="text-danger small">* </span></label>
                        {!! Form::text('old_password',"",['class'=>'form-control']) !!}
                        <span class="hws_error text-right text-danger">{{ $errors->first('old_password') }}</span>
                      </div>
                      <div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback" style="position: relative;">
                        <label for="password" class="hws_form_label">New Password:<span class="text-danger small">* </span></label>
                        {!! Form::text('password',"",['class'=>'form-control']) !!}
                        <span class="hws_error text-right text-danger">{{ $errors->first('password') }}</span>
                      </div>
                      <div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback" style="position: relative;">
                        <label for="conf_password" class="hws_form_label">Confirm Password:<span class="text-danger small">* </span></label>
                        {!! Form::text('conf_password',"",['class'=>'form-control']) !!}
                        <span class="hws_error text-right text-danger">{{ $errors->first('conf_password') }}</span>
                      </div>
                      <div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback" style="position: relative;">
                        <button class="btn btn-primary btn-fw" type="submit"><i class="fa fa-check"></i> Update &amp; Save</button>
                      </div>
                      
                    </div>
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