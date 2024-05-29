@include('templates.toastr-notifications')

<!doctype html>
<html class="no-js " lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">

    <title>:: Docbae :: Sign In</title>
    <!-- Favicon-->
    <link rel="icon" href="favicon.ico" type="image/x-icon">
    <!-- Custom Css -->
    <link rel="stylesheet" href="assets/plugins/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/main.css">
    <link rel="stylesheet" href="assets/css/authentication.css">
    <link rel="stylesheet" href="assets/css/color_skins.css">
</head>

<body class="theme-cyan authentication sidebar-collapse">
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg fixed-top navbar-transparent">
        <div class="container">
            <div class="navbar-translate n_logo">
                <a class="navbar-brand" href="javascript:void(0);" title="" target="_blank">Docbae</a>
                <button class="navbar-toggler" type="button">
                    <span class="navbar-toggler-bar bar1"></span>
                    <span class="navbar-toggler-bar bar2"></span>
                    <span class="navbar-toggler-bar bar3"></span>
                </button>
            </div>

        </div>
    </nav>
    <!-- End Navbar -->
    <div class="page-header">
        <div class="page-header-image" style="background-image:url(assets/images/login.jpg)"></div>
        <div class="container">
            <div class="col-md-12 content-center">
                <div class="card-plain">
                    <form class="form" action="{{ route('otp.submit') }}" method="POST">
                        @csrf

                        <div class="header">
                            <div class="logo-container">
                                <img src="{{ asset('assets/images/doc_logo.png') }}" alt="">
                            </div>
                            <h5>Log in</h5>
                        </div>

                        <div class="content">
                            <div class="input-group">
                                <input type="number" class="form-control" placeholder="Enter otp" name="otp"
                                    required>
                                <span class="input-group-addon">
                                    <i class="zmdi zmdi-account-circle"></i>
                                </span>
                            </div>

                        </div>
                        <div class="footer text-center">
                            <button class="btn btn-primary btn-round btn-block" type="submit">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>

    <!-- Jquery Core Js -->
    <script src="assets/bundles/libscripts.bundle.js"></script>
    <script src="assets/bundles/vendorscripts.bundle.js"></script> <!-- Lib Scripts Plugin Js -->

    <script>
        $(".navbar-toggler").on('click', function() {
            $("html").toggleClass("nav-open");
        });
        //=============================================================================
        $('.form-control').on("focus", function() {
            $(this).parent('.input-group').addClass("input-group-focus");
        }).on("blur", function() {
            $(this).parent(".input-group").removeClass("input-group-focus");
        });
    </script>


    </script>

</body>


</html>
