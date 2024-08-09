<!DOCTYPE html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=Edge" />
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport" />
    <meta name="description" content="Responsive Bootstrap 4 and web Application ui kit." />
    <title>:: DocBae :: Home</title>
    <link rel="icon" href="favicon.ico" type="image/x-icon" />
    <!-- Favicon-->
    <link rel="stylesheet" href="{{ asset('assets/plugins/bootstrap/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/plugins/jvectormap/jquery-jvectormap-2.0.3.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/plugins/morrisjs/morris.min.css') }}" />
    <!-- Custom Css -->
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/color_skins.css') }}" />

    <!-- JQuery DataTable Css -->
    <link rel="stylesheet" href="{{ asset('../assets/plugins/jquery-datatable/dataTables.bootstrap4.min.css') }}" />
</head>

<body class="theme-cyan">
    <!-- Page Loader -->
    {{-- <div class="page-loader-wrapper">
        <div class="loader">
            <div class="m-t-30">
                <img class="zmdi-hc-spin"
                    src="https://thememakker.com/templates/oreo/hospital/html/assets/images/logo.svg" width="48"
                    height="48" alt="Oreo" />
            </div>
            <p>Please wait...</p>
        </div>
    </div> --}}
    <!-- Overlay For Sidebars -->
    <div class="overlay"></div>
    <!-- Top Bar -->
    <nav class="navbar p-l-5 p-r-5">
        <ul class="nav navbar-nav navbar-left">
            <li>
                <div class="navbar-header">
                    <a href="javascript:void(0);" class="bars"></a>
                    <a class="navbar-brand"><img src="{{ asset('assets/images/doc_logo.png') }}" width="30"
                            alt="Oreo" /><span class="m-l-10">DocBae</span></a>
                </div>
            </li>
            <li>
                <a href="javascript:void(0);" class="ls-toggle-btn" data-close="true"><i class="zmdi zmdi-swap"></i></a>
            </li>
            {{-- <li class="dropdown">
                <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button"><i
                        class="zmdi zmdi-notifications"></i>
                    <div class="notify">
                        <span class="heartbit"></span><span class="point"></span>
                    </div>
                </a>
                <ul class="dropdown-menu pullDown">
                    <li class="body">
                        <ul class="menu list-unstyled">
                            <li>
                                <a href="javascript:void(0);">
                                    <div class="media">
                                        <img class="media-object" src="assets/images/xs/avatar2.jpg" alt="" />
                                        <div class="media-body">
                                            <span class="name">Sophia
                                                <span class="time">30min ago</span></span>
                                            <span class="message">There are many variations
                                                of passages</span>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="javascript:void(0);">
                                    <div class="media">
                                        <img class="media-object" src="assets/images/xs/avatar3.jpg" alt="" />
                                        <div class="media-body">
                                            <span class="name">Sophia
                                                <span class="time">31min ago</span></span>
                                            <span class="message">There are many variations
                                                of passages of Lorem
                                                Ipsum</span>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="javascript:void(0);">
                                    <div class="media">
                                        <img class="media-object" src="assets/images/xs/avatar4.jpg" alt="" />
                                        <div class="media-body">
                                            <span class="name">Isabella
                                                <span class="time">35min ago</span></span>
                                            <span class="message">There are many variations
                                                of passages</span>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="javascript:void(0);">
                                    <div class="media">
                                        <img class="media-object" src="assets/images/xs/avatar5.jpg" alt="" />
                                        <div class="media-body">
                                            <span class="name">Alexander
                                                <span class="time">35min ago</span></span>
                                            <span class="message">Contrary to popular belief,
                                                Lorem Ipsum random</span>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="javascript:void(0);">
                                    <div class="media">
                                        <img class="media-object" src="assets/images/xs/avatar6.jpg" alt="" />
                                        <div class="media-body">
                                            <span class="name">Grayson
                                                <span class="time">1hr ago</span></span>
                                            <span class="message">There are many variations
                                                of passages</span>
                                        </div>
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="footer">
                        <a href="javascript:void(0);">View All</a>
                    </li>
                </ul>
            </li> --}}
            {{-- <li class="dropdown">
                <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button"><i
                        class="zmdi zmdi-flag"></i>
                    <div class="notify">
                        <span class="heartbit"></span>
                        <span class="point"></span>
                    </div>
                </a>
                <ul class="dropdown-menu pullDown">
                    <li class="header">Project</li>
                    <li class="body">
                        <ul class="menu tasks list-unstyled">
                            <li>
                                <a href="javascript:void(0);">
                                    <div class="progress-container progress-primary">
                                        <span class="progress-badge">Neurology</span>
                                        <div class="progress">
                                            <div class="progress-bar" role="progressbar" aria-valuenow="86"
                                                aria-valuemin="0" aria-valuemax="100" style="width: 86%">
                                                <span class="progress-value">86%</span>
                                            </div>
                                        </div>
                                        <ul class="list-unstyled team-info">
                                            <li class="m-r-15">
                                                <small class="text-muted">Team</small>
                                            </li>
                                            <li>
                                                <img src="assets/images/xs/avatar2.jpg" alt="Avatar" />
                                            </li>
                                            <li>
                                                <img src="assets/images/xs/avatar3.jpg" alt="Avatar" />
                                            </li>
                                            <li>
                                                <img src="assets/images/xs/avatar4.jpg" alt="Avatar" />
                                            </li>
                                        </ul>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="javascript:void(0);">
                                    <div class="progress-container progress-info">
                                        <span class="progress-badge">Gynecology</span>
                                        <div class="progress">
                                            <div class="progress-bar" role="progressbar" aria-valuenow="45"
                                                aria-valuemin="0" aria-valuemax="100" style="width: 45%">
                                                <span class="progress-value">45%</span>
                                            </div>
                                        </div>
                                        <ul class="list-unstyled team-info">
                                            <li class="m-r-15">
                                                <small class="text-muted">Team</small>
                                            </li>
                                            <li>
                                                <img src="assets/images/xs/avatar10.jpg" alt="Avatar" />
                                            </li>
                                            <li>
                                                <img src="assets/images/xs/avatar9.jpg" alt="Avatar" />
                                            </li>
                                            <li>
                                                <img src="assets/images/xs/avatar8.jpg" alt="Avatar" />
                                            </li>
                                            <li>
                                                <img src="assets/images/xs/avatar7.jpg" alt="Avatar" />
                                            </li>
                                            <li>
                                                <img src="assets/images/xs/avatar6.jpg" alt="Avatar" />
                                            </li>
                                        </ul>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="javascript:void(0);">
                                    <div class="progress-container progress-warning">
                                        <span class="progress-badge">Cardio Monitoring</span>
                                        <div class="progress">
                                            <div class="progress-bar" role="progressbar" aria-valuenow="29"
                                                aria-valuemin="0" aria-valuemax="100" style="width: 29%">
                                                <span class="progress-value">29%</span>
                                            </div>
                                        </div>
                                        <ul class="list-unstyled team-info">
                                            <li class="m-r-15">
                                                <small class="text-muted">Team</small>
                                            </li>
                                            <li>
                                                <img src="assets/images/xs/avatar5.jpg" alt="Avatar" />
                                            </li>
                                            <li>
                                                <img src="assets/images/xs/avatar2.jpg" alt="Avatar" />
                                            </li>
                                            <li>
                                                <img src="assets/images/xs/avatar7.jpg" alt="Avatar" />
                                            </li>
                                        </ul>
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="footer">
                        <a href="javascript:void(0);">View All</a>
                    </li>
                </ul>
            </li> --}}

            @php
                $user = session()->get('user');

                $user_type = $user->user_type;

                if ($user_type == 2) {
                    $user_name = $user->name;
                } else {
                    $user_name = $user->user_name;
                }

            @endphp

            <li class="dropdown" style="padding-left: 550px">
                <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown"
                    role="button">{{ $user_name }}
                </a>
                <ul class="dropdown-menu pullDown">
                    <li class="footer">
                        <a href="{{ route('logout') }}">Logout</a>
                    </li>
                </ul>
            </li>
        </ul>
    </nav>

    @php $url = Request::path(); @endphp
    <!-- Left Sidebar -->
    <aside id="leftsidebar" class="sidebar">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#dashboard"><i
                        class="zmdi zmdi-home m-r-5"></i>DocBae</a>
            </li>

        </ul>
        <div class="tab-content">
            <div class="tab-pane stretchRight active" id="dashboard">
                <div class="menu">
                    <ul class="list">
                        <li>
                            <div class="user-info">
                                <div class="image">
                                    <a href=""><img src="{{ asset('assets/images/doc_logo.png') }}"
                                            alt="User" /></a>
                                </div>
                            </div>
                        </li>
                        @if ($user_type == 0)
                            <li class="header">MAIN</li>
                            <li class="{{ Request::is('admin/dashboard') ? 'active' : '' }}">
                                <a href=" {{ route('admin.dashboard') }}"><i
                                        class="zmdi zmdi-home"></i><span>Dashboard</span></a>
                            </li>

                            <li>
                            <li class="{{ Request::is('admin/invitations') ? 'active' : '' }}">
                                <a href="{{ route('appointment.list') }}">
                                    <i class="zmdi zmdi-calendar-check"></i><span>Invitations</span>
                                </a>
                            </li>

                            <li class="{{ Request::is('admin/emergency-call') ? 'active' : '' }}">
                                <a href="{{ route('Patients.emergency-call') }}">
                                    <i class="zmdi zmdi-calendar-check"></i><span>Emergency Call</span>
                                </a>
                            </li>

                            <li
                                class="{{ $url == 'admin/doctors' || $url == 'admin/new-applicants' || $url == 'admin/doctors-schedule-list' ? 'active' : '' }}">
                                <a href="javascript:void(0);" class="menu-toggle"><i
                                        class="zmdi zmdi-account-add"></i><span>Doctors</span>
                                </a>

                                <ul class="ml-menu">
                                    <li class="{{ $url == 'admin/new-applicants' ? 'active' : '' }}">
                                        <a href="{{ route('doctors.new') }}">New Applicants</a>
                                    </li>
                                    <li class="{{ $url == 'admin/doctors' ? 'active' : '' }}">
                                        <a href="{{ route('doctors.all') }}">All Doctors</a>
                                    </li>
                                    <li class="{{ $url == 'admin/doctors-schedule-list' ? 'active' : '' }}">
                                        <a href="{{ route('doctors.schedule_list') }}">Doctor Schedule</a>
                                    </li>
                                </ul>
                            </li>

                            <li class="{{ $url == 'admin/patients' ? 'active' : '' }}">
                                <a href="javascript:void(0);" class="menu-toggle"><i
                                        class="zmdi zmdi-account-add"></i><span>Patients</span>
                                </a>

                                <ul class="ml-menu">
                                    <li class="{{ $url == 'admin/patients' ? 'active' : '' }}">
                                        <a href="{{ route('Patients.all') }}">All Patients</a>
                                    </li>

                                </ul>
                            </li>

                            <li class="{{ $url == 'admin/departments' ? 'active' : '' }}">
                                <a href="{{ route('department.list') }}">
                                    <i class="zmdi zmdi-label-alt"></i><span>Departments</span>
                                </a>
                            </li>

                            <li class="{{ Request::is('admin/institutes') ? 'active' : '' }}">
                                <a href=" {{ route('institute.list') }}"><i class="zmdi zmdi-apps"></i><span>Institute
                                    </span></a>
                            </li>

                            <li
                                class="{{ $url == 'admin/appointment-history' || $url == 'admin/appointment-report' || $url == 'admin/payment-report' ? 'active' : '' }}">
                                <a href="javascript:void(0);" class="menu-toggle"><i
                                        class="zmdi zmdi-copy"></i><span>Reports</span>
                                </a>

                                <ul class="ml-menu">
                                    <li class="{{ $url == 'admin/appointment-report' ? 'active' : '' }}">
                                        <a href="{{ route('report.appointment') }}">Appointment Report</a>
                                    </li>
                                    <li class="{{ $url == 'admin/payment-report' ? 'active' : '' }}">
                                        <a href="{{ route('report.payment') }}">Payment Report</a>
                                    </li>
                                    <li class="{{ $url == 'admin/appointment-history' ? 'active' : '' }}">
                                        <a href="{{ route('report.appointment-history') }}">Appointment History</a>
                                    </li>
                                </ul>
                            </li>

                            <li class="{{ Request::is('admin/settings') ? 'active' : '' }}">
                                <a href=" {{ route('settings') }}"><i class="material-icons">settings</i> <span
                                        class="icon-name">settings</span> </a>
                            </li>
                        @endif

                        @if ($user_type == 2)
                            <li class="header">MAIN</li>
                            <li class="{{ Request::is('institute/dashboard') ? 'active' : '' }}">
                                <a href="{{ route('institute.dashboard') }}"><i
                                        class="zmdi zmdi-home"></i><span>Dashboard</span></a>
                            </li>

                            <li>
                            <li class="{{ Request::is('institute/invitations') ? 'active' : '' }}">
                                <a href="{{ route('institute.appointment.list') }}">
                                    <i class="zmdi zmdi-calendar-check"></i><span>Invitations</span>
                                </a>
                            </li>

                            <li class="{{ Request::is('institute/emergency-call') ? 'active' : '' }}">
                                <a href="{{ route('institute.emergency-call') }}">
                                    <i class="zmdi zmdi-calendar-check"></i><span>Emergency Call</span>
                                </a>
                            </li>

                            <li class="{{ $url == 'institute/students' ? 'active' : '' }}">
                                <a href="javascript:void(0);" class="menu-toggle"><i
                                        class="zmdi zmdi-account-add"></i><span>Institute Management</span>
                                </a>

                                <ul class="ml-menu">
                                    <li class="{{ $url == 'institute/students' ? 'active' : '' }}">
                                        <a href="{{ route('student.list') }}">Student List</a>
                                    </li>

                                </ul>
                            </li>

                            <li class="{{ $url == 'institute/appointment-history' ? 'active' : '' }}">
                                <a href="javascript:void(0);" class="menu-toggle"><i
                                        class="zmdi zmdi-copy"></i><span>Reports</span>
                                </a>

                                <ul class="ml-menu">
                                    <li class="{{ $url == 'institute/appointment-history' ? 'active' : '' }}">
                                        <a href="{{ route('institute.appointment-history') }}">Appointment History</a>
                                    </li>

                                </ul>
                            </li>
                        @endif


                    </ul>
                </div>
            </div>
        </div>
    </aside>
    <!-- Right Sidebar -->
    <aside id="rightsidebar" class="right-sidebar">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#setting"><i
                        class="zmdi zmdi-settings zmdi-hc-spin"></i></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#chat"><i class="zmdi zmdi-comments"></i></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#activity">Activity</a>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane slideRight active" id="setting">
                <div class="slim_scroll">
                    <div class="card">
                        <h6>General Settings</h6>
                        <ul class="setting-list list-unstyled">
                            <li>
                                <div class="checkbox">
                                    <input id="checkbox1" type="checkbox" />
                                    <label for="checkbox1">Report Panel Usage</label>
                                </div>
                            </li>
                            <li>
                                <div class="checkbox">
                                    <input id="checkbox2" type="checkbox" checked="" />
                                    <label for="checkbox2">Email Redirect</label>
                                </div>
                            </li>
                            <li>
                                <div class="checkbox">
                                    <input id="checkbox3" type="checkbox" checked="" />
                                    <label for="checkbox3">Notifications</label>
                                </div>
                            </li>
                            <li>
                                <div class="checkbox">
                                    <input id="checkbox4" type="checkbox" checked="" />
                                    <label for="checkbox4">Auto Updates</label>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="card">
                        <h6>Skins</h6>
                        <ul class="choose-skin list-unstyled">
                            <li data-theme="purple">
                                <div class="purple"></div>
                            </li>
                            <li data-theme="blue">
                                <div class="blue"></div>
                            </li>
                            <li data-theme="cyan" class="active">
                                <div class="cyan"></div>
                            </li>
                            <li data-theme="green">
                                <div class="green"></div>
                            </li>
                            <li data-theme="orange">
                                <div class="orange"></div>
                            </li>
                            <li data-theme="blush">
                                <div class="blush"></div>
                            </li>
                        </ul>
                    </div>
                    <div class="card">
                        <h6>Account Settings</h6>
                        <ul class="setting-list list-unstyled">
                            <li>
                                <div class="checkbox">
                                    <input id="checkbox5" type="checkbox" checked="" />
                                    <label for="checkbox5">Offline</label>
                                </div>
                            </li>
                            <li>
                                <div class="checkbox">
                                    <input id="checkbox6" type="checkbox" checked="" />
                                    <label for="checkbox6">Location Permission</label>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="card theme-light-dark">
                        <h6>Left Menu</h6>
                        <button class="t-light btn btn-default btn-simple btn-round btn-block">
                            Light
                        </button>
                        <button class="t-dark btn btn-default btn-round btn-block">
                            Dark
                        </button>
                        <button class="m_img_btn btn btn-primary btn-round btn-block">
                            Sidebar Image
                        </button>
                    </div>
                    <div class="card">
                        <h6>Information Summary</h6>
                        <div class="row m-b-20">
                            <div class="col-7">
                                <small class="displayblock">MEMORY USAGE</small>
                                <h5 class="m-b-0 h6">512</h5>
                            </div>
                            <div class="col-5">
                                <div class="sparkline" data-type="bar" data-width="97%" data-height="25px"
                                    data-bar-Width="5" data-bar-Spacing="3" data-bar-Color="#00ced1">
                                    8,7,9,5,6,4,6,8
                                </div>
                            </div>
                        </div>
                        <div class="row m-b-20">
                            <div class="col-7">
                                <small class="displayblock">CPU USAGE</small>
                                <h5 class="m-b-0 h6">90%</h5>
                            </div>
                            <div class="col-5">
                                <div class="sparkline" data-type="bar" data-width="97%" data-height="25px"
                                    data-bar-Width="5" data-bar-Spacing="3" data-bar-Color="#F15F79">
                                    6,5,8,2,6,4,6,4
                                </div>
                            </div>
                        </div>
                        <div class="row m-b-20">
                            <div class="col-7">
                                <small class="displayblock">DAILY TRAFFIC</small>
                                <h5 class="m-b-0 h6">25 142</h5>
                            </div>
                            <div class="col-5">
                                <div class="sparkline" data-type="bar" data-width="97%" data-height="25px"
                                    data-bar-Width="5" data-bar-Spacing="3" data-bar-Color="#78b83e">
                                    7,5,8,7,4,2,6,5
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-7">
                                <small class="displayblock">DISK USAGE</small>
                                <h5 class="m-b-0 h6">60.10%</h5>
                            </div>
                            <div class="col-5">
                                <div class="sparkline" data-type="bar" data-width="97%" data-height="25px"
                                    data-bar-Width="5" data-bar-Spacing="3" data-bar-Color="#457fca">
                                    7,5,2,5,6,7,6,4
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane right_chat stretchLeft" id="chat">
                <div class="slim_scroll">
                    <div class="card">
                        <div class="search">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Search..." />
                                <span class="input-group-addon">
                                    <i class="zmdi zmdi-search"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <h6>Recent</h6>
                        <ul class="list-unstyled">
                            <li class="online">
                                <a href="javascript:void(0);">
                                    <div class="media">
                                        <img class="media-object" src="{{ asset('assets/images/xs/avatar4.jpg') }}"
                                            alt="" />
                                        <div class="media-body">
                                            <span class="name">Sophia</span>
                                            <span class="message">There are many variations
                                                of passages of Lorem Ipsum
                                                available</span>
                                            <span class="badge badge-outline status"></span>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li class="online">
                                <a href="javascript:void(0);">
                                    <div class="media">
                                        <img class="media-object" src="{{ asset('assets/images/xs/avatar5.jpg') }}"
                                            alt="" />
                                        <div class="media-body">
                                            <span class="name">Grayson</span>
                                            <span class="message">All the Lorem Ipsum
                                                generators on the</span>
                                            <span class="badge badge-outline status"></span>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li class="offline">
                                <a href="javascript:void(0);">
                                    <div class="media">
                                        <img class="media-object" src="{{ asset('assets/images/xs/avatar2.jpg') }}"
                                            alt="" />
                                        <div class="media-body">
                                            <span class="name">Isabella</span>
                                            <span class="message">Contrary to popular belief,
                                                Lorem Ipsum</span>
                                            <span class="badge badge-outline status"></span>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li class="me">
                                <a href="javascript:void(0);">
                                    <div class="media">
                                        <img class="media-object" src="{{ asset('assets/images/xs/avatar1.jpg') }}"
                                            alt="" />
                                        <div class="media-body">
                                            <span class="name">John</span>
                                            <span class="message">It is a long established
                                                fact that a reader</span>
                                            <span class="badge badge-outline status"></span>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li class="online">
                                <a href="javascript:void(0);">
                                    <div class="media">
                                        <img class="media-object" src="{{ asset('assets/images/xs/avatar3.jpg') }}"
                                            alt="" />
                                        <div class="media-body">
                                            <span class="name">Alexander</span>
                                            <span class="message">Richard McClintock, a Latin
                                                professor</span>
                                            <span class="badge badge-outline status"></span>
                                        </div>
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="card">
                        <h6>Contacts</h6>
                        <ul class="list-unstyled">
                            <li class="offline inlineblock">
                                <a href="javascript:void(0);">
                                    <div class="media">
                                        <img class="media-object" src="{{ asset('assets/images/xs/avatar10.jpg') }}"
                                            alt="" />
                                        <div class="media-body">
                                            <span class="badge badge-outline status"></span>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li class="offline inlineblock">
                                <a href="javascript:void(0);">
                                    <div class="media">
                                        <img class="media-object" src="{{ asset('assets/images/xs/avatar6.jpg') }}"
                                            alt="" />
                                        <div class="media-body">
                                            <span class="badge badge-outline status"></span>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li class="offline inlineblock">
                                <a href="javascript:void(0);">
                                    <div class="media">
                                        <img class="media-object" src="{{ asset('assets/images/xs/avatar7.jpg') }}"
                                            alt="" />
                                        <div class="media-body">
                                            <span class="badge badge-outline status"></span>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li class="offline inlineblock">
                                <a href="javascript:void(0);">
                                    <div class="media">
                                        <img class="media-object" src="{{ asset('assets/images/xs/avatar8.jpg') }}"
                                            alt="" />
                                        <div class="media-body">
                                            <span class="badge badge-outline status"></span>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li class="offline inlineblock">
                                <a href="javascript:void(0);">
                                    <div class="media">
                                        <img class="media-object" src="{{ asset('assets/images/xs/avatar9.jpg') }}"
                                            alt="" />
                                        <div class="media-body">
                                            <span class="badge badge-outline status"></span>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li class="online inlineblock">
                                <a href="javascript:void(0);">
                                    <div class="media">
                                        <img class="media-object" src="{{ asset('assets/images/xs/avatar5.jpg') }}"
                                            alt="" />
                                        <div class="media-body">
                                            <span class="badge badge-outline status"></span>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li class="offline inlineblock">
                                <a href="javascript:void(0);">
                                    <div class="media">
                                        <img class="media-object" src="{{ asset('assets/images/xs/avatar4.jpg') }}"
                                            alt="" />
                                        <div class="media-body">
                                            <span class="badge badge-outline status"></span>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li class="offline inlineblock">
                                <a href="javascript:void(0);">
                                    <div class="media">
                                        <img class="media-object" src="{{ asset('assets/images/xs/avatar3.jpg') }}"
                                            alt="" />
                                        <div class="media-body">
                                            <span class="badge badge-outline status"></span>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li class="online inlineblock">
                                <a href="javascript:void(0);">
                                    <div class="media">
                                        <img class="media-object" src="{{ asset('assets/images/xs/avatar2.jpg') }}"
                                            alt="" />
                                        <div class="media-body">
                                            <span class="badge badge-outline status"></span>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li class="offline inlineblock">
                                <a href="javascript:void(0);">
                                    <div class="media">
                                        <img class="media-object" src="{{ asset('assets/images/xs/avatar1.jpg') }}"
                                            alt="" />
                                        <div class="media-body">
                                            <span class="badge badge-outline status"></span>
                                        </div>
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="tab-pane slideLeft" id="activity">
                <div class="slim_scroll">
                    <div class="card user_activity">
                        <h6>Recent Activity</h6>
                        <div class="streamline b-accent">
                            <div class="sl-item">
                                <img class="user rounded-circle" src="{{ asset('assets/images/xs/avatar4.jpg') }}"
                                    alt="" />
                                <div class="sl-content">
                                    <h5 class="m-b-0">Admin Birthday</h5>
                                    <small>Jan 21
                                        <a href="javascript:void(0);" class="text-info">Sophia</a>.</small>
                                </div>
                            </div>
                            <div class="sl-item">
                                <img class="user rounded-circle" src="{{ asset('assets/images/xs/avatar5.jpg') }}"
                                    alt="" />
                                <div class="sl-content">
                                    <h5 class="m-b-0">Add New Contact</h5>
                                    <small>30min ago
                                        <a href="javascript:void(0);">Alexander</a>.</small>
                                    <small><strong>P:</strong>
                                        +264-625-2323</small>
                                    <small><strong>E:</strong>
                                        maryamamiri@gmail.com</small>
                                </div>
                            </div>
                            <div class="sl-item">
                                <img class="user rounded-circle" src="{{ asset('assets/images/xs/avatar6.jpg') }}"
                                    alt="" />
                                <div class="sl-content">
                                    <h5 class="m-b-0">Code Change</h5>
                                    <small>Today
                                        <a href="javascript:void(0);">Grayson</a>.</small>
                                    <small>The standard chunk of Lorem Ipsum
                                        used since the 1500s is
                                        reproduced</small>
                                </div>
                            </div>
                            <div class="sl-item">
                                <img class="user rounded-circle" src="{{ asset('assets/images/xs/avatar7.jpg') }}"
                                    alt="" />
                                <div class="sl-content">
                                    <h5 class="m-b-0">New Email</h5>
                                    <small>45min ago
                                        <a href="javascript:void(0);" class="text-info">Fidel Tonn</a>.</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <h6>Recent Attachments</h6>
                        <ul class="list-unstyled activity">
                            <li>
                                <a href="javascript:void(0)">
                                    <i class="zmdi zmdi-collection-pdf l-blush"></i>
                                    <div class="info">
                                        <h4>info_258.pdf</h4>
                                        <small>2MB</small>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="javascript:void(0)">
                                    <i class="zmdi zmdi-collection-text l-amber"></i>
                                    <div class="info">
                                        <h4>newdoc_214.doc</h4>
                                        <small>900KB</small>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="javascript:void(0)">
                                    <i class="zmdi zmdi-image l-parpl"></i>
                                    <div class="info">
                                        <h4>MG_4145.jpg</h4>
                                        <small>5.6MB</small>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="javascript:void(0)">
                                    <i class="zmdi zmdi-image l-parpl"></i>
                                    <div class="info">
                                        <h4>MG_4100.jpg</h4>
                                        <small>5MB</small>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="javascript:void(0)">
                                    <i class="zmdi zmdi-collection-text l-amber"></i>
                                    <div class="info">
                                        <h4>Reports_end.doc</h4>
                                        <small>780KB</small>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="javascript:void(0)">
                                    <i class="zmdi zmdi-videocam l-turquoise"></i>
                                    <div class="info">
                                        <h4>movie2018.MKV</h4>
                                        <small>750MB</small>
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </aside>
    <!-- Chat-launcher -->


    <!-- Jquery Core Js -->
    <script src="{{ asset('assets/bundles/libscripts.bundle.js') }}"></script>
    <!-- Lib Scripts Plugin Js ( jquery.v3.2.1, Bootstrap4 js) -->
    <script src="{{ asset('assets/bundles/vendorscripts.bundle.js') }}"></script>
    <!-- slimscroll, waves Scripts Plugin Js -->

    <script src="{{ asset('assets/bundles/morrisscripts.bundle.js') }}"></script>
    <!-- Morris Plugin Js -->
    <script src="{{ asset('assets/bundles/jvectormap.bundle.js') }}"></script>
    <!-- JVectorMap Plugin Js -->
    <script src="{{ asset('assets/bundles/knob.bundle.js') }}"></script>
    <!-- Jquery Knob, Count To, Sparkline Js -->

    <script src="{{ asset('assets/bundles/mainscripts.bundle.js') }}"></script>
    <script src="{{ asset('assets/js/pages/index.js') }}"></script>

    <!-- Jquery DataTable Plugin Js -->
    <script src="{{ asset('assets/bundles/datatablescripts.bundle.js') }}"></script>

    <script src="{{ asset('assets/js/pages/tables/jquery-datatable.js') }}"></script>
</body>

</html>
