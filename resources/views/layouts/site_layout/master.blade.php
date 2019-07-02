<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8" />
        <title>Book Tracker</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
        <meta content="Coderthemes" name="author" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="public/assets/images/favicon.ico">

        <!-- App css -->
        @include('include.css')

        <style>
            .toast {
                margin-top: 30px !important;
                opacity: 1 !important;
            }
        </style>

        @yield('page_css')

    </head>

    <body>

    <!-- Navigation Bar-->
    <header id="topnav">

        <!-- Topbar Start -->
        <div class="navbar-custom">
            <div class="container-fluid">
                <ul class="list-unstyled topnav-menu float-right mb-0">

                    <li class="dropdown notification-list">
                        <!-- Mobile menu toggle-->
                        <a class="navbar-toggle nav-link">
                            <div class="lines">
                                <span></span>
                                <span></span>
                                <span></span>
                            </div>
                        </a>
                        <!-- End mobile menu toggle-->
                    </li>

                    <li class="d-none d-sm-block">
                        <form class="app-search">
                            <div class="app-search-box">
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Search...">
                                    <div class="input-group-append">
                                        <button class="btn" type="submit">
                                            <i class="fe-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </li>

                    {{--@include('include.notification')--}}

                    <li class="dropdown notification-list">
                        <a class="nav-link dropdown-toggle nav-user mr-0 waves-effect" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                            <img src="{{ asset('public/files/profileImage/'. Auth::user()->profile_image) }}" alt="user-image" class="rounded-circle">
                            <span class="pro-user-name ml-1">
                                {{ Auth::user()->name }} <i class="mdi mdi-chevron-down"></i>
                            </span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right profile-dropdown ">
                            <!-- item-->
                            <div class="dropdown-header noti-title">
                                <h6 class="text-overflow m-0">Welcome !</h6>
                            </div>

                            <!-- item-->
                            <a href="{{ route('profile.show') }}" class="dropdown-item notify-item">
                                <i class="fe-user"></i>
                                <span>My Profile</span>
                            </a>

                            <!-- item-->
                            {{--<a href="javascript:void(0);" class="dropdown-item notify-item">--}}
                                {{--<i class="fe-settings"></i>--}}
                                {{--<span>Settings</span>--}}
                            {{--</a>--}}

                            <div class="dropdown-divider"></div>

                            <a class="dropdown-item notify-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="fe-log-out"></i>
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>

                        </div>
                    </li>

                </ul>

                <!-- LOGO -->
                <div class="logo-box">
                    <a href="{{ route('home') }}" class="logo text-center">
                        <span class="logo-lg">
                            <span onclick="openHome()" class="logo-lg-text-light"> <span style="color: #ffffff;"> [ Book ] </span> <span style="color: #ffffff; padding:5px; background-color: #e74c3c;">Tracker</span> </span>
                        </span>
                        <span class="logo-sm">
                            <span class=""> <span style="color: #ffffff;"> [ Book ] </span> <span style="color: #ffffff; padding:5px; background-color: #e74c3c;">Tracker</span> </span> </span>
                        </span>
                    </a>
                </div>

            </div>
        </div>

        @include('include.menubar')

    </header>

    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        @yield('content')
                    </div>
                </div>
            </div>
        </div>
    </div>



    @include('include.footer')

    @include('include.script')

    {{-- Script --}}
    @if(Session::has('success_message'))
        <script>
            toastr.options.timeOut = 4000;
            toastr.options.closeButton = false;
            toastr.options.progressBar = false;
            toastr.options.positionClass = "toast-top-center";
            toastr.success("{{ Session::get('success_message') }}", {timeOut: 4000})
        </script>
    @endif

    @if(Session::has('error_message'))
        <script>
            toastr.options.timeOut = 4000;
            toastr.options.closeButton = false;
            toastr.options.progressBar = false;
            toastr.options.positionClass = "toast-top-center";
            toastr.error("{{ Session::get('error_message') }}", {timeOut: 4000})
        </script>
    @endif

    @yield('page_script')
    
    {{-- Custom --}}
    <script>

    </script>


    </body>
</html>