@extends('masters/master')
@section('title', 'About Us')
@section('content')
<style type="text/css">
    .icon-table .icon img{
        width: 55px;
        height: 55px;
        object-fit: contain;
    }
</style>
<div id="midwrap1">
    <div class="container">
        <div class="cntblock">
            <div class="leftholder about-us">
                <div class="pg-title">
                    <h1>{{$pageData->title}}</h1>
                </div>
                <div>
                    <div class="about-image">
                        <img src="{{$pageData->image}}" alt="" width="100%" />
                    </div>
                    <div style="line-height:24px;">
                        {!! $pageData->descriptions !!}
                    </div>
                </div>
            </div>
            <div class="icon-table">
                <h3><strong>{{$site_settings->book_with_title}}</strong></h3>
                <div class="row">
                    @if($bookWithUs)
                        @foreach($bookWithUs as $bookWith)
                            <div class="col-md-6 col-sm-6">
                                <div class="icon-list">
                                    <div class="icon"><img src="{{ $bookWith->image }}"></div>
                                    <div class="icon-title">
                                        <h4>{{$bookWith->title}}</h4>
                                    </div>
                                    <div class="clearfix">&nbsp;</div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
                {{-- <div class="row">
                    <div class="col-md-6 col-sm-6">
                        <div class="icon-list">
                            <div class="icon">
                                <img src="{{ asset('public/assets/front_assets/images/about-icon/openanac.png')}}"></div>
                            <div class="icon-title">
                                <h4>
                                    Open an Account</h4>
                            </div>
                            <div class="clearfix">
                                &nbsp;</div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <div class="icon-list">
                            <div class="icon">
                                <img src="{{ asset('public/assets/front_assets/images/about-icon/service24.png')}}"></div>
                            <div class="icon-title">
                                <h4>
                                    24/7 Service</h4>
                            </div>
                            <div class="clearfix">
                                &nbsp;</div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <div class="icon-list">
                            <div class="icon">
                                <img src="{{ asset('public/assets/front_assets/images/about-icon/nohiddencharge.png')}}"></div>
                            <div class="icon-title">
                                <h4>
                                    No hidden charges</h4>
                            </div>
                            <div class="clearfix">
                                &nbsp;</div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <div class="icon-list">
                            <div class="icon">
                                <img src="{{ asset('public/assets/front_assets/images/about-icon/pickuptime.png')}}"></div>
                            <div class="icon-title">
                                <h4>
                                    On Time Pick up</h4>
                            </div>
                            <div class="clearfix">
                                &nbsp;</div>
                        </div>
                    </div>
                    <div class="clearfix">
                        &nbsp;</div>
                    <div class="col-md-6 col-sm-6">
                        <div class="icon-list">
                            <div class="icon">
                                <img src="{{ asset('public/assets/front_assets/images/about-icon/secure-payment.png')}}"></div>
                            <div class="icon-title">
                                <h4>
                                    Secure Payment</h4>
                            </div>
                            <div class="clearfix">
                                &nbsp;</div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <div class="icon-list">
                            <div class="icon">
                                <img src="{{ asset('public/assets/front_assets/images/about-icon/price_tag.png')}}"></div>
                            <div class="icon-title">
                                <h4>
                                    Affordable and competitive prices</h4>
                                <p>
                                    100% refunds guarantee if you change your mind ahead of travel.<br>
                                    &nbsp;</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <div class="icon-list">
                            <div class="icon-title">
                                <h4>
                                    <span style="font-size:14px;"><img alt="" src="{{ asset('public/assets/front_assets/images/about-icon/book_car_png BMW Black(1).png')}}" style="width: 78px; height: 46px;">&nbsp;Wide range of Luxury vehicles</span></h4>
                            </div>
                            <div class="clearfix">
                                &nbsp;</div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <div class="icon-list">
                            <div class="icon">
                                <img src="{{ asset('public/assets/front_assets/images/about-icon/booking-system.png')}}"></div>
                            <div class="icon-title">
                                <h4>
                                    Easy booking system&nbsp;</h4>
                            </div>
                            <div class="clearfix">
                                &nbsp;</div>
                        </div>
                    </div>
                </div> --}}
                <br>                    
            </div>
            <!-- <div class="icon-table">
                <h3><strong>Why Book with us</strong></h3>
                
            </div> -->
        </div>
    </div>
</div>
@endsection
@push('footer-scripts')
    
@endpush