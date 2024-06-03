@extends('Admin/masters/master')
@section('title', 'Add Page')
@push('page-scripts')
@endpush
@if($operator->id)
  @section('page_title','View Operator')
@else
  @section('page_title','Add Operator')
@endif
@section('content')
  <!-- page content -->
  <div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
      {!! Form::open(['route' =>['admin.pages.create',$page->id],'files' => true]) !!}
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
                      <h2 class="sub_title">Operator Content</h2>
                      <ul class="nav navbar-right panel_toolbox">
                          <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                          <li><a class="close-link"><i class="fa fa-close"></i></a></li>
                      </ul>
                      <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <div class="row">
                      <div class="col-md-6 col-sm-12 col-xs-12 form-group has-feedback" style="position: relative;">
                        <label for="name" class="hws_form_label">Office Email Address:<span class="text-danger small">* </span></label>
                        {!! Form::text('name',$operator->office_email,['class'=>'form-control','required'=>'required','readonly'=>'readonly']) !!}
                        <span class="hws_error text-right text-danger">{{ $errors->first('office_email') }}</span>
                      </div>
                      

                      <div class="col-md-6 col-sm-12 col-xs-12 form-group has-feedback" style="position: relative;">
                        <label for="title" class="hws_form_label">First Name:<span class="text-danger small">* </span></label>
                        {!! Form::text('title',$operator->first_name,['class'=>'form-control' ,'readonly'=>'readonly']) !!}
                        <span class="hws_error text-right text-danger">{{ $errors->first('title') }}</span>
                      </div>

                      <div class="col-md-6 col-sm-12 col-xs-12 form-group has-feedback" style="position: relative;">
                        <label for="title" class="hws_form_label">Your Surname :<span class="text-danger small">* </span></label>
                        {!! Form::text('title',$operator->sur_name,['class'=>'form-control','readonly'=>'readonly']) !!}
                        <span class="hws_error text-right text-danger">{{ $errors->first('title') }}</span>
                      </div>
                      <div class="col-md-6 col-sm-12 col-xs-12 form-group has-feedback" style="position: relative;">
                        <label for="title" class="hws_form_label">Operator Name :<span class="text-danger small">* </span></label>
                        {!! Form::text('title',$operator->cab_operator_name,['class'=>'form-control','readonly'=>'readonly']) !!}
                        <span class="hws_error text-right text-danger">{{ $errors->first('title') }}</span>
                      </div>
                      <div class="col-md-6 col-sm-12 col-xs-12 form-group has-feedback" style="position: relative;">
                        <label for="title" class="hws_form_label">Legal Company Name :<span class="text-danger small">* </span></label>
                        {!! Form::text('title',$operator->legal_company_name,['class'=>'form-control','readonly'=>'readonly']) !!}
                        <span class="hws_error text-right text-danger">{{ $errors->first('title') }}</span>
                      </div>
                      <div class="col-md-6 col-sm-12 col-xs-12 form-group has-feedback" style="position: relative;">
                        <label for="title" class="hws_form_label">Office Phone Number :<span class="text-danger small">* </span></label>
                        {!! Form::text('title',$operator->office_phone_number,['class'=>'form-control','readonly'=>'readonly']) !!}
                        <span class="hws_error text-right text-danger">{{ $errors->first('title') }}</span>
                      </div>
                      <div class="col-md-6 col-sm-12 col-xs-12 form-group has-feedback" style="position: relative;">
                        <label for="title" class="hws_form_label">Postcode<span class="text-danger small">* </span></label>
                        {!! Form::text('title',$operator->postcode,['class'=>'form-control','readonly'=>'readonly']) !!}
                        <span class="hws_error text-right text-danger">{{ $errors->first('title') }}</span>
                      </div>
                      <div class="col-md-6 col-sm-12 col-xs-12 form-group has-feedback" style="position: relative;">
                        <label for="title" class="hws_form_label">Website<span class="text-danger small">* </span></label>
                        {!! Form::text('title',$operator->website,['class'=>'form-control','readonly'=>'readonly']) !!}
                        <span class="hws_error text-right text-danger">{{ $errors->first('title') }}</span>
                      </div>
                      <div class="col-md-6 col-sm-12 col-xs-12 form-group has-feedback" style="position: relative;">
                        <label for="title" class="hws_form_label">Licensing Local Authority<span class="text-danger small">* </span></label>
                        {!! Form::text('title',$operator->fleetDetail->licensing_local_authority,['class'=>'form-control','readonly'=>'readonly']) !!}
                        <span class="hws_error text-right text-danger">{{ $errors->first('title') }}</span>
                      </div>
                      <div class="col-md-6 col-sm-12 col-xs-12 form-group has-feedback" style="position: relative;">
                        <label for="title" class="hws_form_label">Operator Licence Number<span class="text-danger small">* </span></label>
                        {!! Form::text('title',$operator->fleetDetail->private_hire_operator_licence_number,['class'=>'form-control','readonly'=>'readonly']) !!}
                        <span class="hws_error text-right text-danger">{{ $errors->first('title') }}</span>
                      </div>
                      <div class="col-md-6 col-sm-12 col-xs-12 form-group has-feedback" style="position: relative;">
                        <label for="title" class="hws_form_label">Licence Expiry Date<span class="text-danger small">* </span></label>
                        {!! Form::text('title',$operator->fleetDetail->licence_expiry_date,['class'=>'form-control','readonly'=>'readonly']) !!}
                        <span class="hws_error text-right text-danger">{{ $errors->first('title') }}</span>
                      </div>



                      <div class="col-md-6 col-sm-12 col-xs-12 form-group has-feedback" style="position: relative;">
                        <label for="title" class="hws_form_label">Fleet size<span class="text-danger small">* </span></label>
                        {!! Form::text('title',$operator->fleetDetail->fleet_size,['class'=>'form-control','readonly'=>'readonly']) !!}
                        <span class="hws_error text-right text-danger">{{ $errors->first('title') }}</span>
                      </div>
                      <div class="col-md-6 col-sm-12 col-xs-12 form-group has-feedback" style="position: relative;">
                        <label for="title" class="hws_form_label">Dispatch system<span class="text-danger small">* </span></label>
                        {!! Form::text('title',$operator->fleetDetail->dispatch_system,['class'=>'form-control','readonly'=>'readonly']) !!}
                        <span class="hws_error text-right text-danger">{{ $errors->first('title') }}</span>
                      </div>
                      <div class="col-md-6 col-sm-12 col-xs-12 form-group has-feedback" style="position: relative;">
                        <label for="title" class="hws_form_label">Email<span class="text-danger small">* </span></label>
                        {!! Form::text('title',$operator->email,['class'=>'form-control','readonly'=>'readonly']) !!}
                        <span class="hws_error text-right text-danger">{{ $errors->first('title') }}</span>
                      </div>
                    

                   
                      <div class="col-md-6 col-sm-12 col-xs-12 form-group has-feedback" style="position: relative;">
                        <label for="title" class="hws_form_label">Authorised Contact Person  :<span class="text-danger small">* </span></label>
                        {!! Form::text('title',$operator->authorised_contact_person,['class'=>'form-control','readonly'=>'readonly']) !!}
                        <span class="hws_error text-right text-danger">{{ $errors->first('title') }}</span>
                      </div>
                      <div class="col-md-6 col-sm-12 col-xs-12 form-group has-feedback" style="position: relative;">
                        <label for="title" class="hws_form_label">Authorised Contact Email Address:<span class="text-danger small">* </span></label>
                        {!! Form::text('title',$operator->authorised_contact_email_address,['class'=>'form-control','readonly'=>'readonly']) !!}
                        <span class="hws_error text-right text-danger">{{ $errors->first('title') }}</span>
                      </div>
                      <div class="col-md-6 col-sm-12 col-xs-12 form-group has-feedback" style="position: relative;">
                        <label for="title" class="hws_form_label">Authorised Contact Mobile Number :<span class="text-danger small">* </span></label>
                        {!! Form::text('title',$operator->authorised_contact_mobile_number,['class'=>'form-control','readonly'=>'readonly']) !!}
                        <span class="hws_error text-right text-danger">{{ $errors->first('title') }}</span>
                      </div>
                      <div class="col-md-6 col-sm-12 col-xs-12 form-group has-feedback" style="position: relative;">
                        <label for="title" class="hws_form_label">How Did You Hear About Us<span class="text-danger small">* </span></label>
                        {!! Form::text('title',$operator->about_us,['class'=>'form-control','readonly'=>'readonly']) !!}
                        <span class="hws_error text-right text-danger">{{ $errors->first('title') }}</span>
                      </div>
                      <div class="col-md-6 col-sm-12 col-xs-12 form-group has-feedback" style="position: relative;">
                        <label for="title" class="hws_form_label">How Much £ Revenue Each Week Would You Like To Earn<span class="text-danger small">* </span></label>
                        {!! Form::text('title',$operator->revenue,['class'=>'form-control','readonly'=>'readonly']) !!}
                        <span class="hws_error text-right text-danger">{{ $errors->first('title') }}</span>
                      </div>


                    </div>
                  </div>
              </div>
          </div>




          <div class="col-sm-4">
            <div class="x_panel">
                <div class="x_title">
                      <h2 class="sub_title">Upload Operator Licence</h2>
                      <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <div class="form-group">
                          <label>Image<small> (Size 500 x 385px)</small></label>
                          {!! Form::file('image',['class'=>'form-control','id'=>'image','onchange'=>'preview(this);']) !!}
                      </div>
                      <div id="icon_img">
                        @if($operator->fleetDetail->upload_operator_licence)
                        <a title="Delete image" href="#" class="btn btn-danger btn-xs deleteFile"><i class="fa fa-trash"></i> </a>
                        <input type="hidden" name="bannerImage" value="{{$page->image}}">
                        <img class="side_img" src="{{ asset('public/assets\front_assets\uploads\OperatorLicence/' . $operator->fleetDetail->upload_operator_licence) }}">
                        @endif
                      </div>
                  </div>
              </div>
          </div>
          <div class="col-sm-4">
            <div class="x_panel">
                <div class="x_title">
                      <h2 class="sub_title">Upload Public Liability Insurance</h2>
                      <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <div class="form-group">
                          <label>Image<small> (Size 500 x 385px)</small></label>
                          {!! Form::file('image',['class'=>'form-control','id'=>'image','onchange'=>'preview(this);']) !!}
                      </div>
                      <div id="icon_img">
                        @if($operator->fleetDetail->upload_public_liability_Insurance)
                        <a title="Delete image" href="#" class="btn btn-danger btn-xs deleteFile"><i class="fa fa-trash"></i> </a>
                        <input type="hidden" name="bannerImage" value="{{$page->image}}">
                        <img class="side_img" src="{{ asset('public/assets\front_assets\uploads\OperatorLicence/' . $operator->fleetDetail->upload_public_liability_Insurance) }}">
                        @endif
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