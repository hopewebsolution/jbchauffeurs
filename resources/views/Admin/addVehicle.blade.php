@extends('Admin/masters/master')
@section('title', 'Add Vehicle')
@push('page-scripts')
@endpush
@if($vehicle_id)
  @section('page_title','Edit Vehicle')
@else
  @section('page_title','Add Vehicle')
@endif
@section('content')
  <!-- page content -->
  <div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
      {!! Form::open(['route' =>['admin.vehicles.create',$vehicle_id],'files' => true]) !!}
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
                        <label for="name" class="hws_form_label">Name:<span class="text-danger small">* </span></label>
                        {!! Form::text('name',$vehicle->name,['class'=>'form-control','required'=>'required','data-type'=>'text']) !!}
                        <span class="hws_error text-right text-danger">{{ $errors->first('name') }}</span>
                      </div>
                      <div class="col-md-6 col-sm-6 col-xs-6 form-group has-feedback" style="position: relative;">
                        <label for="passengers" class="hws_form_label">Passengers:<span class="text-danger small">* </span></label>
                        {!! Form::number('passengers',$vehicle->passengers,['class'=>'form-control','required'=>'required']) !!}
                        <span class="hws_error text-right text-danger">{{ $errors->first('passengers') }}</span>
                      </div>
                      <div class="col-md-6 col-sm-6 col-xs-6 form-group has-feedback" style="position: relative;">
                        <label for="suitecases" class="hws_form_label">Hand Bags:<span class="text-danger small">* </span></label>
                        {!! Form::number('suitecases',$vehicle->suitecases,['class'=>'form-control','required'=>'required']) !!}
                        <span class="hws_error text-right text-danger">{{ $errors->first('suitecases') }}</span>
                      </div>
                      <div class="col-md-6 col-sm-6 col-xs-6 form-group has-feedback" style="position: relative;">
                        <label for="luggages" class="hws_form_label">Luggages:<span class="text-danger small">* </span></label>
                        {!! Form::number('luggages',$vehicle->luggages,['class'=>'form-control','required'=>'required']) !!}
                        <span class="hws_error text-right text-danger">{{ $errors->first('luggages') }}</span>
                      </div>
                      <div class="col-md-6 col-sm-6 col-xs-6 form-group has-feedback" style="position: relative;">
                        <label for="per_stop" class="hws_form_label">Additional Stop:<span class="text-danger small">* </span></label>
                        {!! Form::number('per_stop',$vehicle->per_stop,['class'=>'form-control','required'=>'required']) !!}
                        <span class="hws_error text-right text-danger">{{ $errors->first('per_stop') }}</span>
                      </div>
                      <div class="col-md-6 col-sm-6 col-xs-6 form-group has-feedback" style="position: relative;">
                        <label for="baby_seat" class="hws_form_label">Baby Seat:<span class="text-danger small">* </span></label>
                        {!! Form::number('baby_seat',$vehicle->baby_seat,['class'=>'form-control','required'=>'required']) !!}
                        <span class="hws_error text-right text-danger">{{ $errors->first('baby_seat') }}</span>
                      </div>
                      <div class="col-md-6 col-sm-6 col-xs-6 form-group has-feedback" style="position: relative;">
                        <label for="parking_charge" class="hws_form_label">Parking:<span class="text-danger small">* </span></label>
                        {!! Form::number('parking_charge',$vehicle->parking_charge,['class'=>'form-control','required'=>'required']) !!}
                        <span class="hws_error text-right text-danger">{{ $errors->first('parking_charge') }}</span>
                      </div>
                      <div class="col-md-6 col-sm-6 col-xs-6 form-group has-feedback" style="position: relative;">
                        <label for="fixed_rate" class="hws_form_label">Fixed Rate(0-300%):<span class="text-danger small">* </span></label>
                        {!! Form::number('fixed_rate',$vehicle->fixed_rate,['class'=>'form-control','required'=>'required']) !!}
                        <span class="hws_error text-right text-danger">{{ $errors->first('fixed_rate') }}</span>
                      </div>
                      <div class="col-md-6 col-sm-6 col-xs-6 form-group has-feedback" style="position: relative;">
                        <label for="position" class="hws_form_label">Order:<span class="text-danger small">* </span></label>
                        {!! Form::number('position',$vehicle->position,['class'=>'form-control','required'=>'required']) !!}
                        <span class="hws_error text-right text-danger">{{ $errors->first('position') }}</span>
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
                          <label>Vehicle Image: (280px X 131px)</label>
                          {!! Form::file('image',['class'=>'form-control','id'=>'image','onchange'=>'preview(this);']) !!}
                      </div>
                      
                      <div id="icon_img">
                        @if($vehicle->image)
                        <a title="Delete image" href="#" class="btn btn-danger btn-xs deleteFile"><i class="fa fa-trash"></i> </a>
                        <input type="hidden" name="imageName" value="{{$vehicle->image}}">
                        <img class="side_img" src="{{ $vehicle->image }}">
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