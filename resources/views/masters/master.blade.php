<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="description" content="">
        <meta name="author" content="">
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <!--  
        Document Title
        =============================================
        -->
        <title>Airport Transfer | @yield('title') </title>
        
        <link href="{{ asset('assets/front_assets/images/favicon.png')}}" type="image/x-icon" rel="icon">
        <!--  
        Stylesheets
        ============================================
        -->
        <!-- Default stylesheets-->
        <link href="{{ asset('assets/front_assets/css/bootstrap.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/front_assets/vendors/bootstrap-select/dist/css/bootstrap-select.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/front_assets/css/style.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/front_assets/css/main.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/front_assets/css/jcarousel.responsive.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/front_assets/css/datepicker.css')}}" rel="stylesheet" type="text/css" />
        
        <link href="{{ asset('assets/front_assets/customer/css/login.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/front_assets/css/responsive.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/front_assets/vendors/font-awesome/css/font-awesome.css')}}" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" href="{{ asset('assets/front_assets/css/rslides.css')}}">
        <style type="text/css">
            .page_banner img {
                width: 100%;
                border: none;
            }
            .ajax-loader {
                position: fixed;
                background: #7d7d7d3d;
                bottom: 0;
                right: 0;
                left: 0;
                top: 0;
                z-index: 9998;
                float: left;
                width: 100%;
            }
            .loader_html {
                display: none;
            }
            @-webkit-keyframes load {
              0% {
                -webkit-transform: rotate(0deg);
                transform: rotate(0deg);
              }
              100% {
                -webkit-transform: rotate(360deg);
                transform: rotate(360deg);
              }
            }

            @keyframes load {
              0% {
                -webkit-transform: rotate(0deg);
                transform: rotate(0deg);
              }
              100% {
                -webkit-transform: rotate(360deg);
                transform: rotate(360deg);
              }
            }
            .loading {
                position: absolute;
                border-left: 2px solid #ffffff;
                border-top: 2px solid rgb(50, 122, 182);
                border-right: 2px solid rgba(50, 122, 182, 0.97);
                border-bottom: 2px solid rgb(50, 122, 182);
                height: 46px;
                width: 46px;
                left: 50%;
                top: 50%;
                margin: -23px 0 0 -23px;
                text-indent: -9999em;
                font-size: 10px;
                z-index: 9999;
                -webkit-animation: load 0.8s infinite linear;
                -moz-animation: load 0.8s infinite linear;
                ms-animation: load 0.8s infinite linear;
                o-animation: load 0.8s infinite linear;
                animation: load 0.8s infinite linear;
            }
            .loading, .loading:after {
                border-radius: 50%;
                width: 50px;
                height: 50px;
            }
            ul#nav li:last-child a {
                border: none;
            }
            @media only screen and (min-width: 1400px){
                body {
                    background-color: #fef8da;
                }
            }
        </style>
        {!! NoCaptcha::renderJs() !!}
        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=G-4G5X5KMNKS"></script>
        <script>
          window.dataLayer = window.dataLayer || [];
          function gtag(){dataLayer.push(arguments);}
          gtag('js', new Date());
        
          gtag('config', 'G-4G5X5KMNKS');
        </script>
    </head>
    <body class="">
        <div class="loader_html">
            <div class="ajax-loader">
                <div class="loading">Loading...</div>
            </div>
        </div>
        <div id="mainwrap" class="aus-main">
            <div class="top-all">
                <div class="container">
                    <div class="row">
                        <div class="col-md-3 col-sm-4 call">
                           {!!$site_settings->phone!!}
                        </div>
                        <div class="col-md-4 col-sm-4">
                            <ul class="tz_social list-inline">
                                <li>
                                    <a href="{{$site_settings->facebook}}" target="_blank" class="fa fa-facebook"></a>
                                </li>
                                <li>
                                    <a href="{{$site_settings->instagram}}" target="_blank" class="fa fa-google-plus"></a>
                                </li>
                                <li>
                                    <a href="{{$site_settings->twitter}}" target="_blank" class="fa fa-twitter"></a>
                                </li>
                                <li>
                                    <a href="{{$site_settings->linkedin}}" target="_blank" class="fa fa-linkedin"></a>
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-5 col-sm-4">
                            <div class="slct">
                                <h3 class="choose-country">Choose Country</h3>
                                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                                    <img src="{{ asset('assets/front_assets/images')}}/{{$common->currCountry['flag']}}"  alt=""> 
                                    {{$common->currCountry['name']}}
                                    <span class="caret">
                                    </span>
                                </button>

                                <ul class="dropdown-menu" role="menu">
                                    @if($common->countries)
                                        @foreach($common->countries as $country)
                                            <li class="{{($country['short'] == Request::segment(1)) ? 'active' : ''}}">
                                                <a href="{{url('/')}}/{{$country['short']}}">
                                                    <img src="{{ asset('assets/front_assets/images/')}}/{{$country['flag']}}" alt="" /> {{$country['name']}}
                                                </a>
                                            </li>
                                        @endforeach
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="top">
                <div class="container">
                    <div class="row">  
                        <div class="col-sm-5 col-md-3 col-lg-4">
                            <div class="topleft">
                                <a href="{{route('user.home')}}">
                                    @if($site_settings->logo)
                                        <img src="{{ asset('assets/images')}}/{{$site_settings->logo}}" alt="jbchauffeurs">
                                    @else
                                        <img src="{{ asset('assets/front_assets/images/logo.png')}}" alt="jbchauffeurs">
                                    @endif
                                </a>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <ul class="topbar-image hidden-sm hidden-xs">
                                <li>
                                    <div class="top-lft">
                                        <img src="{{ asset('assets/front_assets/images/img-lft.png')}}" alt="left" width="100%" />
                                    </div> 
                                </li>
                            </ul>
                        </div>

                        <div class="col-md-4 col-sm-6 text-right hidden-sm hidden-xs">
                            @if($site_settings->header_img)
                                <img src="{{ asset('assets/images')}}/{{$site_settings->header_img}}" alt="jbchauffeurs" width="auto" class="mid-img">
                            @else
                                <img src="https://www.jbchauffeurs.com/uploads/banner/-78.jpg" alt="" width="auto" class="mid-img"/>
                            @endif
                        </div>
                        <div class="col-md-2 col-sm-6 text-right hidden-sm hidden-xs">
                            <img src="{{ asset('assets/front_assets/images/img-right.png')}}" alt="right_img" />
                        </div>
                    </div>
                </div>
            </div>
            <div class="navigation-mobile">
                <div class="container">
                    <label for="show-menu" class="show-menu">
                        Menu
                        <div class="menu-line">
                            <span class="line"></span>
                            <span class="line"></span>
                            <span class="line"></span>
                        </div>
                    </label>
                    <input type="checkbox" id="show-menu" role="button">
                    <ul id="menu">
                        <li><a href="{{route('user.home')}}" class="menulink">Home</a></li>
                        <li><a href="{{route('user.about')}}" class="menulink">About Us</a>
                           
                        <li><a href="{{route('user.airportTrans')}}" class="menulink">Airport Transfers </a></li>
                        <li><a href="{{route('user.howItWorks')}}" class="menulink">How it Works</a></li>
                        @if(Auth::guard('web')->check())
                            <li><a href="{{route('user.dashboard')}}" class="menulink">Dashboard</a></li>
                        @else
                            {{-- <li><a href="{{route('user.signupForm')}}" class="menulink">Open an Account</a></li> --}}
                        @endif

                        <li><a href="{{route('user.faq')}}" class="menulink">FAQ</a></li>
                        <li><a href="{{route('user.contactUs')}}" class="menulink" >Contact us</a></li>
                    </ul>

                    <div class="clear"></div>
                </div>
            </div>

            <div class="navigation-destop">
                <div class="container">
                    <ul id="nav">
                        @if($common->header_menus)
                            @foreach ($common->header_menus as $header_menu)
                                <li><a href="{{route('user.cmsPage',['page_slug'=>$header_menu->page_type])}}" class="menulink">{{$header_menu->name}}</a></li>
                            @endforeach
                        @endif
                        @if(Auth::guard('web')->check())
                            <li><a href="{{route('user.dashboard')}}" class="menulink">Dashboard</a></li>
                        @else
                            {{-- <li><a href="{{route('user.signupForm')}}" class="menulink">Open an Account</a></li> --}}
                        @endif
                        <!-- <li><a href="{{route('user.home')}}" class="menulink">Home</a></li>
                        <li><a href="{{route('user.about')}}" class="menulink">About Us</a>
                           
                        <li><a href="{{route('user.airportTrans')}}" class="menulink">Airport Transfers </a></li>
                        <li><a href="{{route('user.howItWorks')}}" class="menulink">How it Works</a></li>
                        
                        <li><a href="{{route('user.faq')}}" class="menulink">FAQ</a></li>
                        <li><a href="{{route('user.contactUs')}}" class="menulink" style="border: none;">Contact us</a></li>
                        <div class="clear"></div> -->
                    </ul>
                </div>
            </div>
            <!-- include ('includes/nav.php')-->
            <div class="clear"></div>
            <div class="main-wrap" id="">
                @yield('content') 
            </div>
            <div class="clear"></div>
        </div>
        <div id="footwrap">
            <div id="footer">
                <div class="container">
                    <div class="row">
                        <div class="col-md-8 col-sm-6">
                            <div class="footer-left">
                                @if($common->footer_menus)
                                    @foreach ($common->footer_menus as $footer_menu)
                                       <a href="{{route('user.cmsPage',['page_slug'=>$footer_menu->page_type])}}">{{$footer_menu->name}}</a> | 
                                    @endforeach
                                @endif
                                <!-- <a href="{{route('user.privacyPolicy')}}">Privacy Policy</a> | 
                                <a href="{{route('user.terms')}}">Terms &amp; Conditions</a><br> -->
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-6">
                            <div class="footer-right">
                                <img src="{{ asset('assets/front_assets/images/cards.png')}}" alt="Payment Accepted" width="50%" />
                            </div>
                            <div class="clear"></div>
                        </div>
                    </div>
                    <div class="cr">
                        {{-- &copy; <?php echo date('Y') ?>-{{ config('app.url', 'Laravel') }} . All rights reserved. --}}
                        {{$site_settings->footer_text}}
                    </div>
                </div>
            </div>       
        </div>
        <script type="text/javascript" src="{{ asset('assets/front_assets/js/jquery.js')}}"></script>
        <script type="text/javascript" src="{{ asset('assets/front_assets/js/bootstrap.min.js')}}"></script>
        <script type="text/javascript" src="{{ asset('assets/front_assets/js/jquery.jcarousel.min.js')}}"></script>
        <script type="text/javascript" src="{{ asset('assets/front_assets/js/jcarousel.responsive.js')}}"></script>

        <!--<script type="text/javascript" src="scripts/jquery.validate.js"></script>-->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.14.0/jquery.validate.min.js"></script>
        <script type="text/javascript" src="{{ asset('assets/front_assets/js/wowslider.js')}}"></script>
        <script type="text/javascript" src="{{ asset('assets/front_assets/js/jQueryUI.js')}}"></script>
        <!-- bxslider -->
        <link href="{{ asset('assets/front_assets/css/jquery.bxslider.css')}}" rel="stylesheet">
        <script src="{{ asset('assets/front_assets/js/jquery.bxslider.min.js')}}"></script>
        <script src="{{ asset('assets/front_assets/js/rslides.js')}}"></script>
        <script type="text/javascript">
            /*idleMax = 5;// Logout after 5 minutes of IDLE
             idleTime = 0;
             $(document).ready(function () {
             var idleInterval = setInterval("timerIncrement()", 60000);
             $(this).mousemove(function (e) {idleTime = 0;});
             $(this).keypress(function (e) {idleTime = 0;});
             })
             function timerIncrement() {
             idleTime = idleTime + 1;
             if (idleTime > idleMax) {
             window.location="./?session=destroy";
             }
             }*/
            $(document).ready(function(){
                $('#select_country').on('change',function(){
                    var type = this.value;
                    $.ajax({
                        url:'./',
                        type: 'GET',
                        data: {rt : 'country', type : type},
                        success: function(){
                            location.reload();
                        }
                    });
                });
                $('.pay_btn').on('click',function(){
                    $(".loader_html").show();
                });
            });
            $(document).ready(function(){
                //var pgurl = window.location.href.substr(window.location.href.lastIndexOf("/") + 1);
                var pgurl = window.location.href;
                $("#nav li a").each(function(){
                    if($(this).attr("href") == pgurl || $(this).attr("href") == '')
                    $(this).addClass("current");
                });
                $("#customer-nav li a").each(function(){
                    if($(this).attr("href") == pgurl || $(this).attr("href") == '')
                    $(this).addClass("current");
                });
            });
        </script>
        <script type="text/javascript" src="{{ asset('assets/front_assets/vendors/bootstrap-select/dist/js/bootstrap-select.js')}}"></script>
        @stack('footer-scripts')

        <script type="text/javascript">
            $(document).ready(function () {
                $(function () {
                    $(".rslides").responsiveSlides({
                        auto: true,
                        speed: 600
                    });
                });
            });
        </script> 
    </body>
</html>