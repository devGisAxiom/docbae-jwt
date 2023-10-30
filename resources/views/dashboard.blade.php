@include('templates.header')

<div class="main-content">

    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-transparent">
                        <h4 class="mb-sm-0">Analytics</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboards</a></li>
                                <li class="breadcrumb-item active">Analytics</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-xxl-5">
                    <div class="d-flex flex-column h-100">
                        <div class="row h-100">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body p-0">
                                        <div class="alert alert-primary border-0 rounded-0 rounded-top m-0 d-flex align-items-center" role="alert">
                                            <i data-feather="alert-triangle" class="text-primary me-2 icon-sm"></i>
                                            <div class="flex-grow-1 text-truncate">
                                                Your free trial expired in <b>17</b> days.
                                            </div>
                                            <div class="flex-shrink-0">
                                                <a href="pages-pricing.html" class="text-reset text-decoration-underline"><b>Upgrade</b></a>
                                            </div>
                                        </div>

                                        <div class="row align-items-end">
                                            <div class="col-sm-8">
                                                <div class="p-3">
                                                    <p class="fs-16 lh-base">Upgrade your plan from a <span class="fw-semibold">Free trial</span>, to ‘Premium Plan’ <i class="mdi mdi-arrow-right"></i></p>
                                                    <div class="mt-3">
                                                        <a href="pages-pricing.html" class="btn btn-primary">Upgrade Account!</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="px-3">
                                                    <img src="assets/images/user-illustarator-2.png" class="img-fluid" alt="">
                                                </div>
                                            </div>
                                        </div>
                                    </div> <!-- end card-body-->
                                </div>
                            </div> <!-- end col-->
                        </div> <!-- end row-->

                        <div class="row">
                            <div class="col-md-6">
                                <div class="card card-animate">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between">
                                            <div>
                                                <p class="fw-medium text-muted mb-0">Users</p>
                                                <h2 class="mt-4 ff-secondary fw-semibold"><span class="counter-value" data-target="28.05">0</span>k</h2>
                                                <p class="mb-0 text-muted"><span class="badge bg-light text-success mb-0"> <i class="ri-arrow-up-line align-middle"></i> 16.24 % </span> vs. previous month</p>
                                            </div>
                                            <div>
                                                <div class="avatar-sm flex-shrink-0">
                                                    <span class="avatar-title bg-primary-subtle rounded-circle fs-2">
                                                        <i data-feather="users" class="text-primary"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- end card body -->
                                </div> <!-- end card-->
                            </div> <!-- end col-->

                            <div class="col-md-6">
                                <div class="card card-animate">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between">
                                            <div>
                                                <p class="fw-medium text-muted mb-0">Sessions</p>
                                                <h2 class="mt-4 ff-secondary fw-semibold"><span class="counter-value" data-target="97.66">0</span>k</h2>
                                                <p class="mb-0 text-muted"><span class="badge bg-light text-danger mb-0"> <i class="ri-arrow-down-line align-middle"></i> 3.96 % </span> vs. previous month</p>
                                            </div>
                                            <div>
                                                <div class="avatar-sm flex-shrink-0">
                                                    <span class="avatar-title bg-primary-subtle rounded-circle fs-2">
                                                        <i data-feather="activity" class="text-primary"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- end card body -->
                                </div> <!-- end card-->
                            </div> <!-- end col-->
                        </div> <!-- end row-->

                        <div class="row">
                            <div class="col-md-6">
                                <div class="card card-animate">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between">
                                            <div>
                                                <p class="fw-medium text-muted mb-0">Avg. Visit Duration</p>
                                                <h2 class="mt-4 ff-secondary fw-semibold"><span class="counter-value" data-target="3">0</span>m
                                                    <span class="counter-value" data-target="40">0</span>sec
                                                </h2>
                                                <p class="mb-0 text-muted"><span class="badge bg-light text-danger mb-0"> <i class="ri-arrow-down-line align-middle"></i> 0.24 % </span> vs. previous month</p>
                                            </div>
                                            <div>
                                                <div class="avatar-sm flex-shrink-0">
                                                    <span class="avatar-title bg-primary-subtle rounded-circle fs-2">
                                                        <i data-feather="clock" class="text-primary"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- end card body -->
                                </div> <!-- end card-->
                            </div> <!-- end col-->

                            <div class="col-md-6">
                                <div class="card card-animate">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between">
                                            <div>
                                                <p class="fw-medium text-muted mb-0">Bounce Rate</p>
                                                <h2 class="mt-4 ff-secondary fw-semibold"><span class="counter-value" data-target="33.48">0</span>%</h2>
                                                <p class="mb-0 text-muted"><span class="badge bg-light text-success mb-0"> <i class="ri-arrow-up-line align-middle"></i> 7.05 % </span> vs. previous month</p>
                                            </div>
                                            <div>
                                                <div class="avatar-sm flex-shrink-0">
                                                    <span class="avatar-title bg-primary-subtle rounded-circle fs-2">
                                                        <i data-feather="external-link" class="text-primary"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- end card body -->
                                </div> <!-- end card-->
                            </div> <!-- end col-->
                        </div> <!-- end row-->
                    </div>
                </div> <!-- end col-->


            </div> <!-- end row-->

        </div>
        <!-- container-fluid -->
    </div>
    <!-- End Page-content -->
</div>

@include('templates.footer')
