@extends('Admin/masters/master')
@section('title', 'Add Page')
@push('page-scripts')
@endpush
@if($operator->id)
  @section('page_title','Edit Operator')
@else
  @section('page_title','Add Operator')
@endif
@section('content')
  <!-- page content -->
  <div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
      {!! Form::open(['route' =>['admin.operator.save'],'files' => true]) !!}
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
                      {{-- <ul class="nav navbar-right panel_toolbox">
                          <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                          <li><a class="close-link"><i class="fa fa-close"></i></a></li>
                      </ul> --}}
                      <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <div class="row">
                      <div class="col-md-6 col-sm-12 col-xs-12 form-group has-feedback" style="position: relative;">
                        <label for="name" class="hws_form_label">Office Email Address:<span class="text-danger small">* </span></label>
                        {!! Form::text('office_email',$operator->office_email,['class'=>'form-control','required'=>'required']) !!}
                        <span class="hws_error text-right text-danger">{{ $errors->first('office_email') }}</span>
                      </div>
                      @csrf
                      <input type="hidden" name="id" value="{{$operator->id}}">

                      <div class="col-md-6 col-sm-12 col-xs-12 form-group has-feedback" style="position: relative;">
                        <label for="title" class="hws_form_label">First Name:<span class="text-danger small">* </span></label>
                        {!! Form::text('first_name',$operator->first_name,['class'=>'form-control' ]) !!}
                        <span class="hws_error text-right text-danger">{{ $errors->first('title') }}</span>
                      </div>

                      <div class="col-md-6 col-sm-12 col-xs-12 form-group has-feedback" style="position: relative;">
                        <label for="title" class="hws_form_label">Your Surname :<span class="text-danger small">* </span></label>
                        {!! Form::text('sur_name',$operator->sur_name,['class'=>'form-control']) !!}
                        <span class="hws_error text-right text-danger">{{ $errors->first('title') }}</span>
                      </div>
                      <div class="col-md-6 col-sm-12 col-xs-12 form-group has-feedback" style="position: relative;">
                        <label for="title" class="hws_form_label">Operator Name :<span class="text-danger small">* </span></label>
                        {!! Form::text('cab_operator_name',$operator->cab_operator_name,['class'=>'form-control']) !!}
                        <span class="hws_error text-right text-danger">{{ $errors->first('title') }}</span>
                      </div>
                      <div class="col-md-6 col-sm-12 col-xs-12 form-group has-feedback" style="position: relative;">
                        <label for="title" class="hws_form_label">Legal Company Name :<span class="text-danger small">* </span></label>
                        {!! Form::text('legal_company_name',$operator->legal_company_name,['class'=>'form-control']) !!}
                        <span class="hws_error text-right text-danger">{{ $errors->first('title') }}</span>
                      </div>
                      <div class="col-md-6 col-sm-12 col-xs-12 form-group has-feedback" style="position: relative;">
                        <label for="title" class="hws_form_label">Office Phone Number :<span class="text-danger small">* </span></label>
                        {!! Form::text('office_phone_number',$operator->office_phone_number,['class'=>'form-control']) !!}
                        <span class="hws_error text-right text-danger">{{ $errors->first('title') }}</span>
                      </div>
                      <div class="col-md-6 col-sm-12 col-xs-12 form-group has-feedback" style="position: relative;">
                        <label for="title" class="hws_form_label">Postcode<span class="text-danger small">* </span></label>
                        {!! Form::text('postcode',$operator->postcode,['class'=>'form-control']) !!}
                        <span class="hws_error text-right text-danger">{{ $errors->first('title') }}</span>
                      </div>
                      <div class="col-md-6 col-sm-12 col-xs-12 form-group has-feedback" style="position: relative;">
                        <label for="title" class="hws_form_label">Website<span class="text-danger small">* </span></label>
                        {!! Form::text('website',$operator->website,['class'=>'form-control']) !!}
                        <span class="hws_error text-right text-danger">{{ $errors->first('title') }}</span>
                      </div>
                      <div class="col-md-6 col-sm-12 col-xs-12 form-group has-feedback" style="position: relative;">
                        <label for="title" class="hws_form_label">Licensing Local Authority<span class="text-danger small">* </span></label>
                        {!! Form::text('licensing_local_authority',$operator->fleetDetail->licensing_local_authority,['class'=>'form-control']) !!}
                        <span class="hws_error text-right text-danger">{{ $errors->first('title') }}</span>
                      </div>
                      <div class="col-md-6 col-sm-12 col-xs-12 form-group has-feedback" style="position: relative;">
                        <label for="title" class="hws_form_label">Operator Licence Number<span class="text-danger small">* </span></label>
                        {!! Form::text('private_hire_operator_licence_number',$operator->fleetDetail->private_hire_operator_licence_number,['class'=>'form-control']) !!}
                        <span class="hws_error text-right text-danger">{{ $errors->first('title') }}</span>
                      </div>
                      <div class="col-md-6 col-sm-12 col-xs-12 form-group has-feedback" style="position: relative;">
                        <label for="title" class="hws_form_label">Licence Expiry Date<span class="text-danger small">* </span></label>
                        {!! Form::text('licence_expiry_date',$operator->fleetDetail->licence_expiry_date,['class'=>'form-control']) !!}
                        <span class="hws_error text-right text-danger">{{ $errors->first('title') }}</span>
                      </div>



                      <div class="col-md-6 col-sm-12 col-xs-12 form-group has-feedback" style="position: relative;">
                        <label for="title" class="hws_form_label">Fleet size<span class="text-danger small">* </span></label>
                        {!! Form::text('fleet_size',$operator->fleetDetail->fleet_size,['class'=>'form-control']) !!}
                        <span class="hws_error text-right text-danger">{{ $errors->first('title') }}</span>
                      </div>
                      <div class="col-md-6 col-sm-12 col-xs-12 form-group has-feedback" style="position: relative;">
                        <label for="title" class="hws_form_label">Dispatch system<span class="text-danger small">* </span></label>
                        {!! Form::text('dispatch_system',$operator->fleetDetail->dispatch_system,['class'=>'form-control']) !!}
                        <span class="hws_error text-right text-danger">{{ $errors->first('title') }}</span>
                      </div>
                      <div class="col-md-6 col-sm-12 col-xs-12 form-group has-feedback" style="position: relative;">
                        <label for="title" class="hws_form_label">Email<span class="text-danger small">* </span></label>
                        {!! Form::text('email',$operator->email,['class'=>'form-control']) !!}
                        <span class="hws_error text-right text-danger">{{ $errors->first('title') }}</span>
                      </div>



                      <div class="col-md-6 col-sm-12 col-xs-12 form-group has-feedback" style="position: relative;">
                        <label for="title" class="hws_form_label">Authorised Contact Person  :<span class="text-danger small">* </span></label>
                        {!! Form::text('authorised_contact_person',$operator->authorised_contact_person,['class'=>'form-control']) !!}
                        <span class="hws_error text-right text-danger">{{ $errors->first('title') }}</span>
                      </div>
                      <div class="col-md-6 col-sm-12 col-xs-12 form-group has-feedback" style="position: relative;">
                        <label for="title" class="hws_form_label">Authorised Contact Email Address:<span class="text-danger small">* </span></label>
                        {!! Form::text('authorised_contact_email_address',$operator->authorised_contact_email_address,['class'=>'form-control']) !!}
                        <span class="hws_error text-right text-danger">{{ $errors->first('title') }}</span>
                      </div>
                      <div class="col-md-6 col-sm-12 col-xs-12 form-group has-feedback" style="position: relative;">
                        <label for="title" class="hws_form_label">Authorised Contact Mobile Number :<span class="text-danger small">* </span></label>
                        {!! Form::text('authorised_contact_mobile_number',$operator->authorised_contact_mobile_number,['class'=>'form-control']) !!}
                        <span class="hws_error text-right text-danger">{{ $errors->first('title') }}</span>
                      </div>
                      <div class="col-md-6 col-sm-12 col-xs-12 form-group has-feedback" style="position: relative;">
                        <label for="title" class="hws_form_label">How Did You Hear About Us<span class="text-danger small">* </span></label>
                        {!! Form::text('about_us',$operator->about_us,['class'=>'form-control']) !!}
                        <span class="hws_error text-right text-danger">{{ $errors->first('title') }}</span>
                      </div>
                      <div class="col-md-6 col-sm-12 col-xs-12 form-group has-feedback" style="position: relative;">
                        <label for="title" class="hws_form_label">How Much £ Revenue Each Week Would You Like To Earn<span class="text-danger small">* </span></label>
                        {!! Form::text('revenue',$operator->revenue,['class'=>'form-control']) !!}
                        <span class="hws_error text-right text-danger">{{ $errors->first('title') }}</span>
                      </div>

                      <div class="col-md-6 col-sm-12 col-xs-12 form-group has-feedback" style="position: relative;">
                        <label for="title" class="hws_form_label">Status<span class="text-danger small">* </span></label>
                        <select class="form-control submitFromStatuss" name="status">
                            <option value="1" {{ ($operator->status == '1')?'selected':'' }}>Active</option>
                            <option value="0" {{ ($operator->status == '0')?'selected':'' }}>Inactive</option>
                        </select>
                        <span class="hws_error text-right text-danger">{{ $errors->first('') }}</span>
                      </div>
                      <div class="col-md-6 col-sm-12 col-xs-12 form-group has-feedback" style="position: relative;">
                        <label for="title" class="hws_form_label">Is Approved<span class="text-danger small">* </span></label>
                        <select class="form-control submitFromStatuss" name="is_approved">
                            <option value="1" {{ ($operator->is_approved == '1')?'selected':'' }}>Approved</option>
                            <option value="0" {{ ($operator->is_approved == '0')?'selected':'' }}>Un-Approved</option>
                        </select>
                        <span class="hws_error text-right text-danger">{{ $errors->first('title') }}</span>
                      </div>


                      <div class="col-md-12 mb-3 col-sm-12 col-xs-12 form-group has-feedback" style="position: relative;">
                        <br>
                        <br>
                        <br>
                        {{-- <label for="title" class="hws_form_label">How Much £ Revenue Each Week Would You Like To Earn<span class="text-danger small">* </span></label> --}}
                        {!! Form::submit('Save',['class'=>'btn btn-primary form-control']) !!}

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
