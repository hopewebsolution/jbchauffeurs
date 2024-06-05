<!DOCTYPE html>
<html lang="en-US" dir="ltr">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <!--  
        Document Title
        =============================================
        -->
        <title>Jbchauffeurs Admin | @yield('title') </title>
        <meta name="msapplication-TileColor" content="#ffffff">
        <meta name="theme-color" content="#ffffff">
        <link href="{{ asset('public/assets/images/favicon.png')}}" type="image/x-icon" rel="icon">
        <!--  
        Stylesheets
        ============================================
        -->
        <!-- Default stylesheets-->
        <link href="{{ asset('public/assets/admin_assets/vendors/bootstrap/dist/css/bootstrap.min.css')}}" rel="stylesheet">
        <!-- Font Awesome -->
        <link href="{{ asset('public/assets/admin_assets/vendors/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet">
        <!-- bootstrap-progressbar -->
        <link href="{{ asset('public/assets/admin_assets/vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css')}}" rel="stylesheet">
        <link href="{{ asset('public/assets/admin_assets/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css')}}" rel="stylesheet">
        <link href="{{ asset('public/assets/admin_assets/vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css')}}" rel="stylesheet">
        <!-- bootstrap-daterangepicker -->
         <link href="{{ asset('public/assets/admin_assets/vendors/bootstrap-daterangepicker/daterangepicker.css')}}" rel="stylesheet">
        <!-- bootstrap-datetimepicker -->

        <link href="{{ asset('public/assets/admin_assets/vendors/switchery/dist/switchery.min.css')}}" rel="stylesheet">
        <link href="{{ asset('public/assets/admin_assets/css/custom.min.css')}}" rel="stylesheet">
        <!-- iCheck -->
        <link href="{{ asset('public/assets/admin_assets/vendors/iCheck/skins/flat/green.css')}}" rel="stylesheet">

        <link href="{{ asset('public/assets/admin_assets/css/view_style.css')}}" rel="stylesheet">
        <link href="{{ asset('public/assets/admin_assets/vendors/pnotify/dist/pnotify.css')}}" rel="stylesheet" type="text/css" />
        @stack('page-scripts')
    </head>
    <body class="nav-md">
        <div class="loader_html">
            <div class="ajax-loader">
                <div class="loading">Loading...</div>
            </div>
        </div>
        <div class="container body">
            <div class="main_container">
                <div class="col-md-3 left_col">
                  <div class="left_col scroll-view">
                    <div class="navbar nav_title" style="border: 0;">
                        <a href="" class="site_title"><img src="{{ asset('public/assets/front_assets/images/logo.png')}}" alt=""/><span></span></a>
                    </div>
                    <div class="clearfix"></div>
                    <!-- menu profile quick info -->
                    {{--
                    <div class="profile clearfix">
                        <div class="profile_pic">
                            <img src="{{ asset('public/assets/admin_assets/images/img.jpg') }}" alt="..." class="img-circle profile_img">
                        </div>
                        <div class="profile_info">
                            <span>Welcome,</span>
                            <h2>{{ Auth::guard('admin')->user()->name }}</h2>
                        </div>
                    </div>
                    --}}
                    <!-- /menu profile quick info -->
                    <br/>
                    <!-- sidebar menu -->
                    <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
                        <div class="menu_section">
                            <!-- <h3>General</h3> -->
                            <ul class="nav side-menu">
                                <!-- <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li> -->
                                <li>
                                    <a><i class="fa fa-flag"></i> Change Country <span class="fa fa-chevron-down"></span></a>
                                    <ul class="nav child_menu">
                                        @if($common->countries)
                                            @foreach($common->countries as $country)
                                                <li>
                                                    <a href="{{url('/admin')}}/{{$country['short']}}/dashboard?redirect_uri={{Route::current()->getName()}}">
                                                        <img src="{{ asset('public/assets/front_assets/images/')}}/{{$country['flag']}}" alt="" /> {{$country['name']}}
                                                    </a>
                                                </li>
                                            @endforeach
                                        @endif
                                    </ul>
                                </li>
                                <li><a href="{{ route('admin.users') }}"><i class="fa fa-users"></i> Users</a></li>
                                <li><a href="{{ route('admin.bookWithUs') }}"><i class="fa fa-ticket"></i>Book With  Us</a></li>
                                <li><a href="{{ route('admin.sideBlocks') }}"><i class="fa fa-ticket"></i>Sidebar Blocks</a></li>
                                <li><a href="{{ route('admin.fixedRates') }}"><i class="fa fa-ticket"></i> Fixed Rates</a></li>
                                <li><a href="{{ route('admin.fares') }}"><i class="fa fa-ticket"></i> Fares</a></li>
                                <li><a href="{{ route('admin.settings') }}"><i class="fa fa-gear"></i></i> Settings</a></li>
                                <li><a href="{{ route('admin.sliders') }}"><i class="fa fa-sliders"></i> Sliders</a></li>
                                <li><a href="{{ route('admin.services') }}"><i class="fa fa-wrench"></i> Services</a></li>
                                <li><a href="{{route('admin.vehicles')}}"><i class="fa fa-car"></i> Vehicles</a></li>
                                <li><a href="{{route('admin.bookings')}}"><i class="fa fa-book"></i> Bookings</a></li>
                                <li><a href="{{route('admin.faqs')}}"><i class="fa fa-question-circle"></i> Faqs</a></li>
                                <li><a href="{{route('admin.pages')}}"><i class="fa fa-file"></i> Pages</a></li>
                                <li><a href="{{route('admin.operator')}}"><i class="fa fa-users"></i> Operator</a></li>
                                <li><a href="{{route('admin.airports')}}"><i class="fa fa-plane"></i> Airports</a></li>
                                
                                                            
                            </ul>
                        </div>
                    </div>
                    <!-- /sidebar menu -->

                    <!-- /menu footer buttons -->
                    <div class="sidebar-footer hidden-small">
                      <a data-toggle="tooltip" data-placement="top" title="Settings">
                        <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
                      </a>
                      <a data-toggle="tooltip" data-placement="top" title="FullScreen">
                        <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
                      </a>
                      <a data-toggle="tooltip" data-placement="top" title="Lock">
                        <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
                      </a>
                      <a data-toggle="tooltip" data-placement="top" title="Logout" href="{{ route('admin.logout') }}">
                        <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
                      </a>
                    </div>
                    <!-- /menu footer buttons -->
                  </div>
                </div>
                <!-- top navigation -->
                <div class="top_nav">
                    <div class="nav_menu">
                        <nav>
                            <div class="nav toggle">
                                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
                            </div>
                            <ul class="nav navbar-nav">
                                <li class="" style="display: inline-block;padding: 16px 5px;">
                                    <img src="{{ asset('public/assets/front_assets/images')}}/{{$common->adminCountry['flag']}}"  alt=""> 
                                    <span>{{$common->adminCountry['name']}}</span>
                                </li>
                            </ul>
                            <ul class="nav navbar-nav navbar-right">
                                <li class="">
                                  <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                    @if(Auth::guard('admin')->check())
                                        {{ Auth::guard('admin')->user()->name }}
                                    @endif
                                    <span class=" fa fa-angle-down"></span>
                                  </a>
                                  <ul class="dropdown-menu dropdown-usermenu pull-right">
                                    <!-- <li><a href="javascript:;"> Profile</a></li>
                                    <li>
                                      <a href="javascript:;">
                                        <span class="badge bg-red pull-right">50%</span>
                                        <span>Settings</span>
                                      </a>
                                    </li>
                                    <li><a href="javascript:;">Help</a></li> -->
                                    <li><a href="{{ route('admin.adminChangePwd') }}"><i class="fa fa-key pull-right"></i> Change Password</a></li><li><a href="{{ route('admin.logout') }}"><i class="fa fa-sign-out pull-right"></i> Log Out</a></li>
                                  </ul>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
                <!-- /top navigation -->
	            <!-- page content -->
                <div class="right_col" role="main">
                    <div class="page-title">
                        <div class="title_left">
                            <h3> @yield('page_title') </h3>
                        </div>
                    </div>
                    @yield('content')
                </div>
                <!-- /page content -->

                <!-- footer content -->
                <footer>
                    <div class="pull-right">
                        {{ config('app.name', 'Laravel') }} <a href="{{ url('/') }}">HWS</a>
                    </div>
                    <div class="clearfix"></div>
                </footer>
                <!-- /footer content -->
            </div>
        </div>  
        <!-- jQuery -->
        <script src="{{ asset('public/assets/admin_assets/vendors/jquery/dist/jquery.min.js')}}"></script>
        <!-- Bootstrap -->
        <script src="{{ asset('public/assets/admin_assets/vendors/bootstrap/dist/js/bootstrap.min.js')}}"></script>
        <script src="{{ asset('public/assets/admin_assets/vendors/bootstrap-progressbar/bootstrap-progressbar.min.js')}}"></script>
        <script src="{{ asset('public/assets/admin_assets/vendors/datatables.net/js/jquery.dataTables.min.js')}}"></script>
        <script src="{{ asset('public/assets/admin_assets/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>
        <script src="{{ asset('public/assets/admin_assets/vendors/datatables.net-responsive/js/dataTables.responsive.min.js')}}"></script>
        <script src="{{ asset('public/assets/admin_assets/vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js')}}"></script>
        
        <script src="{{ asset('public/assets/admin_assets/vendors/moment/min/moment.min.js')}}"></script>
        <script src="{{ asset('public/assets/admin_assets/vendors/bootstrap-daterangepicker/daterangepicker.js')}}"></script>
        <script src="{{ asset('public/assets/admin_assets/vendors/switchery/dist/switchery.min.js')}}"></script>
       
        <!-- Custom Theme Scripts -->
        <script src="{{ asset('public/assets/admin_assets/js/custom.min.js')}}"></script>
        <script src="{{ asset('public/assets/admin_assets/vendors/ckeditor/ckeditor.js') }}"></script>
        <script src="{{ asset('public/assets/admin_assets/vendors/ckeditor/js/sample.js') }}"></script>
        <script type="text/javascript" src="{{ asset('public/assets/admin_assets/vendors/pnotify/dist/pnotify.js')}}"></script>
        <!-- iCheck -->
        <script type="text/javascript" src="{{ asset('public/assets/admin_assets/vendors/iCheck/icheck.min.js')}}"></script>
        <script type="text/javascript" language="javascript">
            
            $(function(){
                
                if($("#editor").length){
                    CKEDITOR.replace('editor',{});
                }if($("#short_desc").length){
                    CKEDITOR.replace('short_desc',{});
                }if($("#protection").length){
                    CKEDITOR.replace('protection',{});
                }if($("#about").length){
                    CKEDITOR.replace('about',{});
                }if($("#challenge").length){
                    CKEDITOR.replace('challenge',{});
                }if($("#impact").length){
                    CKEDITOR.replace('impact',{});
                }if($("#solutions").length){
                    CKEDITOR.replace('solutions',{});
                }
            });
            $(document).ready(function(){
                $('.ui-pnotify').remove();
                $(document).on("click",'.deleteFile',function(){
                    $(this).parent().html("");
                });
            });
        </script>
        @stack('footer-scripts') 
    </body>
</html>