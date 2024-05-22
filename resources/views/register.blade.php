@extends('masters/master')
@section('title', 'Register')
@section('content')
<div id="midwrap1">
    <div class="container">
        <div class="cntblock">
            <div class="row">
                <div class="col-md-8 col-sm-8">
                    <div class="leftholder">
                        <div class="pg-title"><h1>Customer Registration</h1></div>
                        {!! Form::open(['route'=>['user.signup'],'class'=>'form-horizontal bookfrm','id'=>'register']) !!}
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach   
                                </div>
                            @endif
                            <div class="booking_form_fields1">
                                <p class="book_p1">Personal Details</p>
                                <div class="passenger_details1">
                                    <div class="passenger_details_left1">
                                        <div class="form-group pas_detail_align1">
                                            <input type="hidden" name="country" value="aus">
                                            <label class="col-sm-3 col-xs-6 control-label"> First Name : </label>
                                            <div class="col-sm-9 col-xs-6">
                                                {!! Form::text('fname','',['class'=>'form-control inputst1 required','required'=>'required']) !!}
                                                <span class="hws_error text-right text-danger">{{ $errors->first('fname') }}</span>
                                            </div>
                                        </div>
                                        <div class="form-group pas_detail_align1">
                                            <label class="col-sm-3 col-xs-6 control-label"> Last Name : </label>
                                            <div class="col-sm-9 col-xs-6">
                                                {!! Form::text('lname','',['class'=>'form-control inputst1 required','required'=>'required']) !!}
                                                <span class="hws_error text-right text-danger">{{ $errors->first('lname') }}</span>
                                            </div>
                                        </div>
                                        <div class="form-group pas_detail_align1">
                                            <label class="col-sm-3 col-xs-6 control-label"> Phone : </label>
                                            <div class="col-sm-9 col-xs-6">
                                                {!! Form::number('phone','',['class'=>'form-control inputst1 required','required'=>'required']) !!}
                                                <span class="hws_error text-right text-danger">{{ $errors->first('phone') }}</span>
                                            </div>
                                        </div>
                                        <div class="form-group pas_detail_align1">
                                            <label class="col-sm-3 col-xs-6 control-label"> Mobile : </label>
                                            <div class="col-sm-9 col-xs-6">
                                                {!! Form::number('mobile','',['class'=>'form-control inputst1 required','required'=>'required']) !!}
                                                <span class="hws_error text-right text-danger">{{ $errors->first('mobile') }}</span>
                                            </div>
                                        </div>
                                        <div class="form-group pas_detail_align1">
                                            <label class="col-sm-3 col-xs-6 control-label">Email : </label>
                                            <div class="col-sm-9 col-xs-6">
                                                {!! Form::email('email','',['class'=>'form-control inputst1 required','required'=>'required']) !!}
                                                <span class="hws_error text-right text-danger">{{ $errors->first('email') }}</span>
                                            </div>
                                        </div>
                                        <div class="form-group pas_detail_align1">
                                            <label class="col-sm-3 col-xs-6 control-label">Password : </label>
                                            <div class="col-sm-9 col-xs-6">
                                                {!! Form::password('password',['class'=>'form-control inputst1 required','required'=>'required']) !!}
                                                <span class="hws_error text-right text-danger">{{ $errors->first('password') }}</span>
                                            </div>
                                        </div>
                                        <div class="form-group pas_detail_align1">
                                            <label class="col-sm-3 col-xs-6 control-label"> Account Type : </label>
                                            <div class="col-sm-9 col-xs-6">
                                                <input type="radio" name="account_type" value="personal" checked> <span style="color:black; margin-right: 10px;">Personal</span><br>
                                                <input type="radio" name="account_type" value="business"> <span style="color:black;">Business</span>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <p class="book_p1 business">Company Details</p>
                                <div class="passenger_details1 business">
                                    <div class="passenger_details_left1">
                                        <div class="form-group pas_detail_align1">
                                            <label class="col-sm-3 col-xs-6 control-label"> Company Name : </label>
                                            <div class="col-sm-9 col-xs-6">
                                                {!! Form::text('company_name','',['class'=>'form-control inputst1 required','required'=>'required']) !!}
                                                <span class="hws_error text-right text-danger">{{ $errors->first('company_name') }}</span>
                                            </div>
                                        </div>
                                        <div class="form-group pas_detail_align1">
                                            <label class="col-sm-3 col-xs-6 control-label"> Company Address : </label>
                                            <div class="col-sm-9 col-xs-6">
                                                {!! Form::text('company_address','',['class'=>'form-control inputst1 required','required'=>'required']) !!}
                                                <span class="hws_error text-right text-danger">{{ $errors->first('company_address') }}</span>
                                            </div>
                                        </div>
                                        <div class="form-group pas_detail_align1">
                                            <label class="col-sm-3 col-xs-6 control-label"> Company Phone : </label>
                                            <div class="col-sm-9 col-xs-6">
                                                {!! Form::text('company_phone','',['class'=>'form-control inputst1 required','required'=>'required']) !!}
                                                <span class="hws_error text-right text-danger">{{ $errors->first('company_phone') }}</span>
                                            </div>
                                        </div>
                                        <div class="form-group pas_detail_align1">
                                            <label class="col-sm-3 col-xs-6 control-label"> Company Website : </label>
                                            <div class="col-sm-9 col-xs-6">
                                                {!! Form::text('website','',['class'=>'form-control inputst1 required','required'=>'required']) !!}
                                                <span class="hws_error text-right text-danger">{{ $errors->first('website') }}</span>
                                            </div>
                                        </div>
                                        <div class="form-group pas_detail_align1">
                                            <label class="col-sm-3 col-xs-6 control-label"> Nature of Business: </label>
                                            <div class="col-sm-9 col-xs-6">
                                                {!! Form::text('business_type','',['class'=>'form-control inputst1 required','required'=>'required']) !!}
                                                <span class="hws_error text-right text-danger">{{ $errors->first('business_type') }}</span>
                                            </div>
                                        </div>
                                        <div class="form-group pas_detail_align1">
                                            <label class="col-sm-3 col-xs-6 control-label"> Registration Number: </label>
                                            <div class="col-sm-9 col-xs-6">
                                                {!! Form::text('reg_no','',['class'=>'form-control inputst1 required','required'=>'required']) !!}
                                                <span class="hws_error text-right text-danger">{{ $errors->first('reg_no') }}</span>
                                            </div>
                                        </div>

                                        <div class="form-group pas_detail_align1">
                                            <label class="col-sm-3 col-xs-6 control-label"> Contact Person's Name: </label>
                                            <div class="col-sm-9 col-xs-6">
                                                {!! Form::text('contact_name','',['class'=>'form-control inputst1 required','required'=>'required']) !!}
                                                <span class="hws_error text-right text-danger">{{ $errors->first('contact_name') }}</span>
                                            </div>
                                        </div>
                                        <div class="form-group pas_detail_align1">
                                            <label class="col-sm-3 col-xs-6 control-label"> Contact Person's Position: </label>
                                            <div class="col-sm-9 col-xs-6">
                                                {!! Form::text('contact_position','',['class'=>'form-control inputst1 required','required'=>'required']) !!}
                                                <span class="hws_error text-right text-danger">{{ $errors->first('contact_position') }}</span>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <div class="passenger_details1">
                                    <div class="pas_detail_align1" style="margin:10px 0 0 10px; color:#000;">
                                        <input type="checkbox" name="checkbox" id="checkbox" value="1" class="required">
                                        &nbsp;&nbsp;I agree to the <a href="{{route('user.customerTerms')}}" target="_blank">Terms and Conditions</a> 
                                    </div>
                                    <div class=" {{ $errors->has('g-recaptcha-response') ? ' has-error' : '' }} ">
                                        <div class="col-md-12 mb-2">
                                            {{-- {!! app('captcha')->display() !!} --}}
                                            <div class="g-recaptcha" data-sitekey="{{config('services.nocaptcha_sitekey')}}"></div>
                                            @if($errors->has('g-recaptcha-response'))
                                                <span class="invalid-feedback d-block" role="alert">
                                                    <strong>{{ $errors->first('g-recaptcha-response') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="pas_detail_align1" style="margin:10px 0 10px 10px; color:#000;">
                                        <input type="submit"  value="Submit" id="f_button" name="submit" class="submit" >
                                    </div>
                                </div>
                                
                            </div>
                            <div style="clear:both; width:100%;"></div>
                        {!! Form::close() !!}
                    </div>
                </div>
                <div class="col-md-4 col-sm-4">
                    @include('sidebar')
                    <div class="clear"></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('footer-scripts')
    <script type="text/javascript">
        $(document).ready(function(){
            $('#register').validate();
            if ($('input[name="account_type"]:checked').val() == 'personal') {
                $('.business').hide();
            }else if ($('input[name="account_type"]:checked').val() == 'business') {
                $('.business').show();
            }

            $('input[name="account_type"]').change(function () {
                if ($('input[name="account_type"]:checked').val() == 'personal') {
                    $('.business').hide();
                } else if ($('input[name="account_type"]:checked').val() == 'business') {
                    $('.business').show();
                }
            });

        });
    </script>
@endpush