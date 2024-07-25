@extends('Admin/masters/master')
@section('title', 'Site Settings')
@push('page-scripts')
@endpush
@section('content')
  <!-- page content -->
  <div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
      {!! Form::open(['route' =>['admin.settings.create'],'class'=>'add_package','id'=>'add_package','files' => true]) !!}
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
                      <h2 class="sub_title">Basic Settings</h2>
                      <ul class="nav navbar-right panel_toolbox">
                          <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                          <li><a class="close-link"><i class="fa fa-close"></i></a></li>
                      </ul>
                      <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <div class="row">
                      <div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback" style="position: relative;">
                        <label for="slogantitle" class="hws_form_label">Slogan Title:<span class="text-danger small">* </span></label>
                        {!! Form::text('slogantitle',$settings->slogantitle,['class'=>'form-control','required'=>'required']) !!}
                        <span class="hws_error text-right text-danger">{{ $errors->first('slogantitle') }}</span>
                      </div>
                      <div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback" style="position: relative;">
                        <label for="phone" class="hws_form_label">Phone On Top:<span class="text-danger small">* </span></label>
                        {!! Form::textarea('phone',$settings->phone,['class'=>'form-control','required'=>'required','id'=>'editor']) !!}
                        <span class="hws_error text-right text-danger">{{ $errors->first('phone') }}</span>
                      </div>
                      <div class="col-md-6 col-sm-6 col-xs-6 form-group has-feedback" style="position: relative;">
                        <label for="maintenance" class="hws_form_label">Maintinance:<span class="text-danger small">* </span></label>
                        {!! Form::select('maintenance',['0'=>'No','1'=>'YES'],$settings->maintenance, ['class'=>'form-control','id'=>'maintenance','required'=>'required']) !!}
                        <span class="hws_error text-danger text-right">{{ $errors->first('maintenance') }}</span>
                      </div>

                      <div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback" style="position: relative;">
                        <label for="footer_text" class="hws_form_label">Footer Text:<span class="text-danger small">* </span></label>
                        {!! Form::textarea('footer_text',$settings->footer_text,['class'=>'form-control','required'=>'required','rows'=>'3']) !!}
                        <span class="hws_error text-right text-danger">{{ $errors->first('footer_text') }}</span>
                      </div>
                      <div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback" style="position: relative;">
                        <label for="book_with_title" class="hws_form_label">Why Book With Us Title:<span class="text-danger small">* </span></label>
                        {!! Form::text('book_with_title',$settings->book_with_title,['class'=>'form-control','required'=>'required']) !!}
                        <span class="hws_error text-right text-danger">{{ $errors->first('book_with_title') }}</span>
                      </div>


                    </div>

                  </div>
              </div>
              <div class="x_panel">
                  <div class="x_title">
                      <h2 class="sub_title">Paypal Settings</h2>
                      <ul class="nav navbar-right panel_toolbox">
                          <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                          <li><a class="close-link"><i class="fa fa-close"></i></a></li>
                      </ul>
                      <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <div class="row">
                      <div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback" style="position: relative;">
                        <label for="paypal_mode" class="hws_form_label">Mode:<span class="text-danger small">* </span></label>
                        {!! Form::select('paypal_mode',['sandbox'=>'Sandbox','live'=>'Live'],$settings->paypal_mode, ['class'=>'form-control','id'=>'paypal_mode','required'=>'required']) !!}
                        <span class="hws_error text-danger text-right">{{ $errors->first('paypal_mode') }}</span>
                      </div>
                      <div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback" style="position: relative;">
                        <label for="paypal_sandbox_client_id" class="hws_form_label">Sandbox Client Id:<span class="text-danger small">* </span></label>
                        {!! Form::text('paypal_sandbox_client_id',$settings->paypal_sandbox_client_id,['class'=>'form-control','required'=>'required']) !!}
                        <span class="hws_error text-right text-danger">{{ $errors->first('paypal_sandbox_client_id') }}</span>
                      </div>
                      <div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback" style="position: relative;">
                        <label for="paypal_sandbox_client_secret" class="hws_form_label">Sandbox Client Secret:<span class="text-danger small">* </span></label>
                        {!! Form::text('paypal_sandbox_client_secret',$settings->paypal_sandbox_client_secret,['class'=>'form-control','required'=>'required']) !!}
                        <span class="hws_error text-right text-danger">{{ $errors->first('paypal_sandbox_client_secret') }}</span>
                      </div>
                      <div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback" style="position: relative;">
                        <label for="paypal_live_client_id" class="hws_form_label">Live Client Id:<span class="text-danger small">* </span></label>
                        {!! Form::text('paypal_live_client_id',$settings->paypal_live_client_id,['class'=>'form-control','required'=>'required']) !!}
                        <span class="hws_error text-right text-danger">{{ $errors->first('paypal_live_client_id') }}</span>
                      </div>
                      <div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback" style="position: relative;">
                        <label for="paypal_live_client_secret" class="hws_form_label">Live Client Secret:<span class="text-danger small">* </span></label>
                        {!! Form::text('paypal_live_client_secret',$settings->paypal_live_client_secret,['class'=>'form-control','required'=>'required']) !!}
                        <span class="hws_error text-right text-danger">{{ $errors->first('paypal_live_client_secret') }}</span>
                      </div>

                    </div>
                  </div>
              </div>
              <div class="x_panel">
                  <div class="x_title">
                      <h2 class="sub_title">Social Settings</h2>
                      <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <div class="row">
                      <div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback" style="position: relative;">
                        <label for="title" class="hws_form_label">Facebook:<span class="text-danger small">* </span></label>
                        {!! Form::text('facebook',$settings->facebook,['class'=>'form-control','required'=>'required']) !!}
                        <span class="hws_error text-right text-danger">{{ $errors->first('facebook') }}</span>
                      </div>
                      <div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback" style="position: relative;">
                        <label for="insta" class="hws_form_label">Instagram:<span class="text-danger small">* </span></label>
                        {!! Form::text('instagram',$settings->instagram,['class'=>'form-control','required'=>'required']) !!}
                        <span class="hws_error text-right text-danger">{{ $errors->first('insta') }}</span>
                      </div>
                      <div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback" style="position: relative;">
                        <label for="linkedin" class="hws_form_label">LinkedIn:<span class="text-danger small">* </span></label>
                        {!! Form::text('linkedin',$settings->linkedin,['class'=>'form-control','required'=>'required']) !!}
                        <span class="hws_error text-right text-danger">{{ $errors->first('linkedin') }}</span>
                      </div>
                      <div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback" style="position: relative;">
                        <label for="twitter" class="hws_form_label">Twitter:<span class="text-danger small">* </span></label>
                        {!! Form::text('twitter',$settings->twitter,['class'=>'form-control','required'=>'required']) !!}
                        <span class="hws_error text-right text-danger">{{ $errors->first('twitter') }}</span>
                      </div>

                    </div>
                  </div>
              </div>
              <div class="x_panel">
                  <div class="x_title">
                      <h2 class="sub_title">Contact Settings</h2>
                      <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <div class="row">
                      <div class="col-md-6 col-sm-12 col-xs-12 form-group has-feedback" style="position: relative;">
                        <label for="contact_phone" class="hws_form_label">Contact Phone:<span class="text-danger small">* </span></label>
                        {!! Form::number('contact_phone',$settings->contact_phone,['class'=>'form-control','required'=>'required']) !!}
                        <span class="hws_error text-right text-danger">{{ $errors->first('contact_phone') }}</span>
                      </div>
                      <div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback" style="position: relative;">
                        <label for="address" class="hws_form_label">Contact Address:<span class="text-danger small">* </span></label>
                        {!! Form::textarea('address',$settings->address,['class'=>'form-control','required'=>'required','rows'=>'3']) !!}
                        <span class="hws_error text-right text-danger">{{ $errors->first('address') }}</span>
                      </div>
                      <div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback" style="position: relative;">
                        <label for="map" class="hws_form_label">Map:<span class="text-danger small">* </span></label>
                        {!! Form::text('map',$settings->map,['class'=>'form-control','required'=>'required']) !!}
                        <span class="hws_error text-right text-danger">{{ $errors->first('facebook') }}</span>
                      </div>

                    </div>
                  </div>
              </div>
              <div class="x_panel">
                  <div class="x_title">
                      <h2 class="sub_title">Additional Rates</h2>
                      <ul class="nav navbar-right panel_toolbox">
                          <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                          <li><a class="close-link"><i class="fa fa-close"></i></a></li>
                      </ul>
                      <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <div class="row">
                      <div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback" style="position: relative;">
                        <label for="waitCharge" class="hws_form_label">Waiting Charge (per 15 min) ($):<span class="text-danger small">* </span></label>
                        {!! Form::number('waitCharge',$settings->waitCharge,['class'=>'form-control','required'=>'required','step'=>'0.1']) !!}
                        <span class="hws_error text-right text-danger">{{ $errors->first('waitCharge') }}</span>
                      </div>
                      <div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback" style="position: relative;">
                        <label for="gst" class="hws_form_label">TAX Type:<span class="text-danger small">* </span></label>
                        {!! Form::select('tax_type',['VAT'=>'VAT','GST'=>'GST'],$settings->tax_type,['class'=>'form-control','required'=>'required']) !!}
                        <span class="hws_error text-right text-danger">{{ $errors->first('tax_type') }}</span>
                      </div>
                      <div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback" style="position: relative;">
                        <label for="gst" class="hws_form_label">TAX (%):<span class="text-danger small">* </span></label>
                        {!! Form::number('gst',$settings->gst,['class'=>'form-control','required'=>'required','step'=>'0.1']) !!}
                        <span class="hws_error text-right text-danger">{{ $errors->first('gst') }}</span>
                      </div>
                      <div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback" style="position: relative;">
                        <label for="cardFee" class="hws_form_label">Paypal Charge ($):<span class="text-danger small">* </span></label>
                        {!! Form::number('cardFee',$settings->cardFee,['class'=>'form-control','required'=>'required','step'=>'0.1']) !!}
                        <span class="hws_error text-right text-danger">{{ $errors->first('cardFee') }}</span>
                      </div>

                      {{-- Admin Commission --}}
                      <div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback" style="position: relative;">
                        <label for="admin_commission" class="hws_form_label">Admin Commission (%):<span class="text-danger small">* </span></label>
                        {!! Form::number('admin_commission',$settings->admin_commission,['class'=>'form-control','required'=>'required','step'=>'1']) !!}
                        <span class="hws_error text-right text-danger">{{ $errors->first('admin_commission') }}</span>
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
                          <label>Logo: (125px X 68px)</label>
                          {!! Form::file('logo',['class'=>'form-control','id'=>'logo','onchange'=>'preview(this);']) !!}
                      </div>
                      <div id="icon_img">
                        @if($settings->logo)
                        <a title="Delete image" href="#" class="btn btn-danger btn-xs deleteFile"><i class="fa fa-trash"></i> </a>
                        <input type="hidden" name="logoName" value="{{$settings->logo}}">
                        <img class="side_img" src="{{ asset('public/assets/images/'.$settings->logo)}}">
                        @endif
                      </div>
                  </div>
                  <div class="x_content">
                      <div class="form-group">
                          <label>Header Image: (303px X 88px)</label>
                          {!! Form::file('header_img',['class'=>'form-control','id'=>'header_img','onchange'=>'preview(this,"#head_img");']) !!}
                      </div>
                      <div id="head_img">
                        @if($settings->header_img)
                        <a title="Delete image" href="#" class="btn btn-danger btn-xs deleteFile"><i class="fa fa-trash"></i> </a>
                        <input type="hidden" name="header_imgName" value="{{$settings->logo}}">
                        <img class="side_img" src="{{ asset('public/assets/images/'.$settings->header_img)}}">
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
