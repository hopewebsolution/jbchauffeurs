@extends('Admin/masters/master')
@section('title', 'Add Fare')
@push('page-scripts')
@endpush
@if($fare->id)
  @section('page_title','Edit Fare')
@else
  @section('page_title','Add Fare')
@endif
@section('content')
  <!-- page content -->
  <div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
      {!! Form::open(['route' =>['admin.fares.create',$fare->id]]) !!}
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
                        <label for="start" class="hws_form_label">Start:<span class="text-danger small">* </span></label>
                        {!! Form::number('start',$fare->start,['class'=>'form-control','required'=>'required','id'=>'start']) !!}
                        <span class="hws_error text-right text-danger">{{ $errors->first('start') }}</span>
                      </div>
                      <div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback" style="position: relative;">
                        <label for="end" class="hws_form_label">End:<span class="text-danger small">* </span></label>
                        {!! Form::number('end',$fare->end,['class'=>'form-control','required'=>'required','id'=>'end']) !!}
                        <span class="hws_error text-right text-danger">{{ $errors->first('end') }}</span>
                      </div>
                      <div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback" style="position: relative;">
                        <label for="rate" class="hws_form_label">Rate:<span class="text-danger small">* </span></label>
                        {!! Form::number('rate',$fare->rate,['class'=>'form-control','required'=>'required','step'=>'0.1']) !!}
                        <span class="hws_error text-right text-danger">{{ $errors->first('rate') }}</span>
                      </div>
                    </div>                   
                  </div>
              </div>
          </div>
          <div class="col-sm-4">
            <div class="x_panel">
              <div class="x_content">
                <div class="form-group has-feedback" style="position: relative;">
                  <label for="vehicle_id" class="hws_form_label">Vehicle<span class="text-danger small">* </span></label>
                  {!! Form::select('vehicle_id',$vehicles,$fare->vehicle_id,['placeholder' => 'Select Vehicle','class'=>'form-control','id'=>'vehicle_id','required'=>'required']) !!}
                  <span class="hws_error text-danger text-right">{{ $errors->first('vehicle_id') }}</span>                                        
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
@endpush