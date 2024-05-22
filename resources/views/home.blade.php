@extends('masters/master')
@section('title', 'Home')
@section('content')

<div id="banner" style="min-height: 300px;">
    @if(!$sliders->isEmpty())
    <ul class="rslides">
        @foreach($sliders as $slider)
        <li><img src="{{$slider->slide_img}}" alt=""></li>
        @endforeach
    </ul>
    @endif
    <div class="container banner-wrap">
        @if($site_settings->maintenance=="1")
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 service-block-in-sp" style="text-align: center;margin: 15% 0px;">
                <h3 style="font-weight: 700;text-transform: uppercase;background-color: #00000038;color: #fff;">{{$common->currCountry['name']}} Site Under Maintenance</h3>
            </div>
        </div>
        @else
        @include('masters.locationForm',['formType'=>'homeForm'])
        @endif
    </div>
</div>

<div id="midwrap" class="services-wrap">
    <div class="container">    
        <div class="slogantitle"> 
            <h1 class="slogantitle">{{$site_settings->slogantitle}}</h1>
        </div>
        @if(!$services->isEmpty())
        <ul class="bxslider-services">
            @foreach($services as $service)
            <li>
                <div class="serviceslist">
                    <img src="{{$service->image}}" alt="">
                    {{--
                    @if($service->url_slug)
                    <div class="service-title">
                        <a href="{{route('user.serviceDetails',['service_id'=>$service->id,'slug'=>$service->url_slug])}}">{{$service->name}}</a>
                    </div>
                    @endif
                    <!-- <div class="service-cnt">
                        {!!$service->descriptions!!}
                    </div> -->
                    --}}
                </div>
            </li>
            @endforeach
        </ul>
        @endif
        
    </div>
</div>

<div id="bodywrap" class="section">
    <div class="container">
        <div class="row">
            
            <div class="col-md-7 col-sm-7">
                @if($pageData)
                <div class="main-cnt-holder">
                    <div class="wel-txt-holder">{{$pageData->title}}</div>
                    <div>
                        <div class="row">
                            <div class="col-md-4 col-sm-4">
                                <div class="image1">
                                    <img src="{{$pageData->image}}" alt="">
                                </div>
                            </div>
                            <div class="col-md-8 col-sm-8">
                                <div class="cnt-para">{!! $pageData->descriptions !!}
                                </div>
                            </div>
                        </div>
                        <div class="clear"></div>
                    </div>
                </div>
                @endif
            </div>
            
            <div class="col-md-5 col-sm-5">
                <div class="right-cnt-holder">
                    @if($appBlocks)
                        @foreach($appBlocks as $appBlock)
                            <div class="dnwl-holder">{{$appBlock->title}}</div>
                            <div style="margin-bottom:25px;">
                                <a href="{{$appBlock->link}}" target="_blank">
                                <img src="{{$appBlock->image}}" alt="" width="100%" /></a>
                            </div>
                        @endforeach
                    @endif
                    @if($textBlocks)
                        @foreach($textBlocks as $textBlock)
                            <div style="margin-bottom:10px;" class="txtst01">{{$textBlock->title}}</div>
                            <div class="cot-para1">{!!$textBlock->descriptions!!}
                            </div>
                        @endforeach
                    @endif
                </div>
                <div class="clear"></div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('footer-scripts')
    <script>
            $(function () {

                var no_of_slide = 0;

                if ($(window).width() <= 380) {
                    no_of_slide = 1;
                } else if ($(window).width() <= 640) {
                    no_of_slide = 2;
                } else {
                    no_of_slide = 3;
                }
         
                $('.bxslider-services').bxSlider({
                    minSlides: no_of_slide,
                    maxSlides: 3,
                    slideWidth: 310,
                    slideMargin: 20,
                    ticker: true,
                    speed: 75000,
                });
            });
    </script>
@endpush