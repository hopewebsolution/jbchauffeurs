@extends('Admin/masters/master')
@section('title', 'Add Fixed Rate')
@push('page-scripts')
@endpush
@if($fixedRate->id)
  @section('page_title','Edit Fixed Rate')
@else
  @section('page_title','Add Fixed Rate')
@endif
@section('content')
  <!-- page content -->
  <div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
      {!! Form::open(['route' =>['admin.fixedRates.create',$fixedRate->id]]) !!}
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
                        {!! Form::text('start',$fixedRate->start,['class'=>'form-control','required'=>'required','id'=>'start']) !!}
                        <span class="hws_error text-right text-danger">{{ $errors->first('start') }}</span>
                      </div>
                      <div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback" style="position: relative;">
                        <label for="end" class="hws_form_label">End:<span class="text-danger small">* </span></label>
                        {!! Form::text('end',$fixedRate->end,['class'=>'form-control','required'=>'required','id'=>'end']) !!}
                        <span class="hws_error text-right text-danger">{{ $errors->first('end') }}</span>
                      </div>
                      <div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback" style="position: relative;">
                        <label for="amount" class="hws_form_label">Amount:<span class="text-danger small">* </span></label>
                        {!! Form::number('amount',$fixedRate->amount,['class'=>'form-control','required'=>'required','id'=>'amount']) !!}
                        <span class="hws_error text-right text-danger">{{ $errors->first('amount') }}</span>
                      </div>
                    </div>                   
                  </div>
              </div>
          </div>
          <div class="col-sm-4">
            {{-- 
            <div class="x_panel">
              <div class="x_content">
                <div class="form-group has-feedback" style="position: relative;">
                  <label for="vehicle_id" class="hws_form_label">Vehicle<span class="text-danger small">* </span></label>
                  {!! Form::select('vehicle_id',$vehicles,$fixedRate->vehicle_id,['placeholder' => 'Select Vehicle','class'=>'form-control','id'=>'vehicle_id','required'=>'required']) !!}
                  <span class="hws_error text-danger text-right">{{ $errors->first('vehicle_id') }}</span>                                        
                </div>
              </div>
            </div>
            --}}
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
  <script src="https://maps.googleapis.com/maps/api/js?libraries=places&key={{ config('services.google_map_key') }}&libraries=places,geometry"></script>
  <script src=" https://cdnjs.cloudflare.com/ajax/libs/geocomplete/1.4/jquery.geocomplete.js"></script>
  <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment-with-locales.js"></script>
  <script type="text/javascript">
    function initialize() {
        var input = document.getElementById('start');
        var autocomplete = new google.maps.places.Autocomplete(input);
        var input = document.getElementById('end');
        var autocomplete = new google.maps.places.Autocomplete(input);
    }
    google.maps.event.addDomListener(window, 'load', initialize);
  </script>
@endpush