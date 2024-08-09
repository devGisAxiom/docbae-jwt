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
                <a class="navbar-brand" title="" target="_blank">Docbae</a>
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
                    <form class="form" action="{{ route('login.get') }}" method="POST">
                        @csrf

                        <div class="header">
                            <div class="logo-container">
                                <img src="{{ asset('assets/images/doc_logo.png') }}" alt="">
                            </div>
                            <h5>Log in</h5>
                        </div>
                        <div class="content">

                            <div id="adminFields">
                                <div class="input-group">
                                    <input class="form-control" type="text" id="user_name" name="user_name"
                                        placeholder="Enter User Name">
                                    <span class="input-group-addon">
                                        <i class="zmdi zmdi-account-circle"></i>
                                    </span>
                                </div>

                                <div class="input-group">
                                    <input class="form-control" type="text" id="password" name="password"
                                        placeholder="Enter Password">
                                    <span class="input-group-addon">
                                        <i class="zmdi zmdi-lock"></i>
                                    </span>
                                </div>

                            </div>

                            <div id="instituteFields" style="display: none;">

                                <div class="input-group">
                                    <input class="form-control" type="number" id="mobile" name="mobile"
                                        placeholder="Enter Phone">
                                    <span class="input-group-addon">
                                        <i class="zmdi zmdi-account-circle"></i>
                                    </span>
                                </div>
                            </div>

                            <div class="input-group">
                                <span style="padding-left: 30px">
                                    <input type="radio" id="adminRadio" name="user_type" value="0"
                                        checked="checked" onchange="toggleFields()"><span
                                        class="pms-subscription-plan-name ">Admin</span>
                                    &nbsp;&nbsp;&nbsp;
                                </span>

                                <span style="padding-left: 100px">
                                    <input type="radio" id="instituteRadio" name="user_type" value="2"
                                        onchange="toggleFields()">
                                    <span class="pms-subscription-plan-name ">Institute</span>
                                </span>

                            </div>

                            {{-- <input type="radio" id="adminRadio" name="userType" value="admin" checked="checked"
                                onchange="toggleFields()">
                            <label for="adminRadio">Admin</label><br>

                            <input type="radio" id="instituteRadio" name="userType" value="institute"
                                onchange="toggleFields()">
                            <label for="instituteRadio">Institute</label><br><br> --}}


                        </div>
                        <div class="footer text-center">
                            <button class="btn btn-primary btn-round btn-block" type="submit">SIGN IN</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>

    <!-- Jquery Core Js -->
    <script src="assets/bundles/libscripts.bundle.js"></script>
    <script src="assets/bundles/vendorscripts.bundle.js"></script> <!-- Lib Scripts Plugin Js -->


</body>

</html>

<script>
    function toggleFields() {
        var adminFields = document.getElementById("adminFields");
        var instituteFields = document.getElementById("instituteFields");

        if (document.getElementById("adminRadio").checked) {
            adminFields.style.display = "block";
            instituteFields.style.display = "none";
        } else if (document.getElementById("instituteRadio").checked) {
            adminFields.style.display = "none";
            instituteFields.style.display = "block";
        }
    }
</script>
