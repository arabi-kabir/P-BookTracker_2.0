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
        <link href="{{ asset('public/assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('public/assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('public/assets/css/app.min.css') }}" rel="stylesheet" type="text/css" />

    </head>

    <body class="authentication-bg">

    <div class="home-btn d-none d-sm-block">
        <a href="index.html"><i class="fas fa-home h2 text-dark"></i></a>
    </div>

    <div class="account-pages mt-5 mb-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <div class="text-center mb-4">
                        <a href="index.html">
                            <h2> <span style="color: #3498db">BOOK</span> <span style="color: #95a5a6;">Tracker</span> </h2>
                        </a>
                    </div>
                    <div class="card" style="">
                        <div class="card-body p-4">
                            @yield('content')
                        </div>
                    </div>

                    @yield('bottom_content')

                </div>
            </div>
        </div>

    </div>

    <script src="{{ asset('public/assets/js/vendor.min.js') }}"></script>
    <script src="{{ asset('public/assets/js/app.min.js') }}"></script>

    </body>

</html>