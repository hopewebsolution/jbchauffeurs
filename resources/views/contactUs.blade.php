@extends('masters/master')
@section('title', 'Contact Us')
@section('content')
<div id="midwrap1">
    <div class="container">
        <div class="cntblock">
            <div class="row">
                <div class="col-md-8 col-sm-8">
                    <div class="leftholder">
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
                        <div style="margin-bottom: 20px;">
                            <div class="pg-title"><h1>{{$pageData->title}}</h1></div>
                            <div style="line-height:24px;text-align: center;">
                                <p style="text-align: center;"><strong><span style="font-size:16px;"><img src="{{ asset('public/assets/front_assets/images')}}/{{$common->currCountry['logo']}}" style="width: 96px;">Ph: +{{$site_settings->contact_phone}}</span></strong></p>
                               <!-- <span style="font-size:14px;">Feel free to contact us on any enquirers regarding our service,<br>
                                or any booking requirements not listed in our booking system.<br>
                                So that we can help you quicly and effectively, please provide us with as many details<br>
                                as possible using the form below.</span> -->
                            </div>
                            <div>
                                @if($pageData->image)
                                <img src="{{$pageData->image}}" alt="" width="100%" />
                                @endif
                                {!! $pageData->descriptions !!}
                            </div>
                        </div>
                        <div style="margin-bottom: 20px;">

                            {!! Form::open(['route' =>['user.webSendContactUs'],'class'=>'bookfrm','id'=>'reservation']) !!}
                                <div class="booking_form_fields1">
                                    <div class="passenger_details1">
                                        <div class="passenger_details_left1">
                                            <div class="form-group pas_detail_align1">
                                                <label class="col-sm-3 col-xs-5 control-label"> Name : </label>
                                                <div class="col-sm-9 col-xs-7">
                                                    <input type="text" class="form-control inputst1 required" id="name" name="name">
                                                </div>
                                            </div>
                                            <div class="form-group pas_detail_align1">
                                                <label class="col-sm-3 col-xs-5 control-label">Email : </label>
                                                <div class="col-sm-9 col-xs-7">
                                                    <input type="text" class="form-control inputst1 required email" id="email" name="email">
                                                </div>
                                            </div>
                                            <div class="pas_detail_align1">
                                                <label class="col-sm-3 col-xs-5 control-label">Mob/Phone : </label>
                                                <div class="col-sm-9 col-xs-7">
                                                    <input type="text" class="form-control inputst1 required" id="phone" name="phone">
                                                </div>
                                            </div>
                                            <div class="clear"></div>
                                            <div class="pas_detail_align1">
                                                <label class="col-sm-3 col-xs-5 control-label">Message : </label>
                                                <div class="col-sm-9 col-xs-7">
                                                    <textarea class="form-control text_area" id="message" name="message" rows='4'></textarea>
                                                </div>
                                            </div>
                                            <div class="clear"></div>
                                            <div class="pas_detail_align1 {{ $errors->has('g-recaptcha-response') ? ' has-error' : '' }} ">
                                                <label class="col-sm-3 col-xs-5 control-label"> </label>
                                                <div class="col-sm-9 col-xs-7">
                                                    {!! app('captcha')->display() !!}
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
                                </div>
                                <div style="clear:both; width:100%;"></div>
                            {!! Form::close() !!}
                        </div>
                        <div>
                            {!!$site_settings->map!!}
                            <!-- <iframe src="{{$site_settings->map}}" width="600" height="450" frameborder="0" style="border:0" allowfullscreen=""></iframe> -->
                        </div>
                        <div class="contact-content" style="margin-top:10px;text-align: center;">
                            <br>
                            <em><span style="font-size:12px;">{{$site_settings->address}}</span></em><br><br>    
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-4">
                    @include('sidebar')
                    @if($pageData->side_app_title)
                    <div class="dnwl-holder" style="margin-top:30px;">{{$pageData->side_app_title}}</div>
                    @endif
                    <div style="margin-bottom:25px;">
                        <a href="{{$pageData->side_app_link}}" target="_blank"><img src="{{$pageData->side_app_image}}" alt="" width="100%" /></a>
                    </div>
                    <div class="clear"></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('footer-scripts')  
@endpush