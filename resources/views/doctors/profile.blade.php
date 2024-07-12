@include('templates.header')

<section class="content">
    <div class="block-header">
        <div class="row">
            <div class="col-lg-5 col-md-5 col-sm-12">
                <h2>
                    All Doctors
                    <small>Welcome to Docbae</small>
                </h2>
            </div>
            <div class="col-lg-7 col-md-7 col-sm-12 text-right">

                <ul class="breadcrumb float-md-right">
                    <li class="breadcrumb-item">
                        </i> Docbae
                    </li>

                    <li class="breadcrumb-item active"> Doctor Profile</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-4 col-md-12">
                <div class="card profile-header">
                    <div class="body text-center">
                        <div class="profile-image">
                            @if ($doctor->profile_pic == null)
                                <img src="{{ asset('assets/images/doctors/user.jpg') }}"
                                    style="width: 180px; height:180px;" alt="" />
                            @else
                                <img src="{{ asset('Images/Doctor/Profile_picture/' . $doctor->profile_pic) }}"
                                    style="width: 180px; height:180px;" alt="">
                            @endif

                        </div>

                        @php
                            use Carbon\Carbon;
                            $dateOfBirth = Carbon::parse($doctor->dob);
                            $age = $dateOfBirth->age;
                        @endphp
                        <div>
                            <br>
                            <h6 class="m-b-0"><strong> {{ $doctor->first_name }} </strong> {{ $doctor->last_name }}
                                <span> ( {{ $age }} ) </span>
                            </h6>
                            <span class="job_post">{{ $doctor->department_name }}</span>
                            <p style="font-weight:500"> {{ $doctor->mobile }} </p>

                            <p>{{ $doctor->address }} <br>{{ $doctor->location }} , {{ $doctor->state }} </p>
                        </div>

                        @if ($doctor->is_verified == 0)
                            <div>
                                <a class="btn btn-primary btn-round"
                                    href="{{ route('doctors.verify', ['id' => $doctor['id']]) }}"
                                    onclick="Verify(event)"> Accept </a>
                                <a class="btn btn-primary btn-round btn-simple"
                                    href="{{ route('doctors.reject', ['id' => $doctor['id']]) }}"
                                    onclick="Reject(event)"> Reject </a>
                            </div>
                        @elseif($doctor->is_verified == 1)
                            <div>
                                <button class="btn btn-success btn-round">Verified ✔</button>

                                <a class="btn btn-danger btn-round"
                                    href="{{ route('doctors.delete', ['id' => $doctor['id']]) }}"
                                    onclick="Reject(event)"> Deactivate </a>

                            </div>
                            {{-- <button class="btn btn-success btn-round">Verified ✔</button> --}}
                        @endif
                    </div>
                </div>

                @if (!$schedules->isEmpty())

                    <div class="card">
                        <div class="body">
                            <div class="workingtime">
                                <h6>Working Time</h6>

                                @foreach ($schedules as $item)
                                    @php

                                        if ($item->day_of_week == '1') {
                                            $week = 'Monday';
                                        } elseif ($item->day_of_week == '2') {
                                            $week = 'Tuesday';
                                        } elseif ($item->day_of_week == '3') {
                                            $week = 'Wednesday';
                                        } elseif ($item->day_of_week == '4') {
                                            $week = 'Thursday';
                                        } elseif ($item->day_of_week == '5') {
                                            $week = 'Friday';
                                        } elseif ($item->day_of_week == '6') {
                                            $week = 'Saturday';
                                        } elseif ($item->day_of_week == '7') {
                                            $week = 'Sunday';
                                        }

                                        if ($item->available_time == '0') {
                                            $availability = 'AM';
                                        } elseif ($item->available_time == '1') {
                                            $availability = 'PM';
                                        } elseif ($item->available_time == '2') {
                                            $availability = 'PM';
                                        }

                                    @endphp

                                    <small class="text-muted"> {{ $week }} </small>
                                    <p>{{ $item->time_from }} {{ $availability }} - {{ $item->time_to }}
                                        {{ $availability }}</p>
                                    <hr>
                                @endforeach

                            </div>
                        </div>
                    </div>

                @endif


                {{-- <div class="card">
                    <ul class="nav nav-tabs">
                        <li class="nav-item"><a class="nav-link active" data-toggle="tab"
                                href="#Followers">Followers</a></li>
                        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#friends">Friends</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane body active" id="Followers">
                            <ul class="right_chat list-unstyled">
                                <li class="online">
                                    <a href="javascript:void(0);">
                                        <div class="media">
                                            <img class="media-object " src="../assets/images/xs/avatar4.jpg"
                                                alt="">
                                            <div class="media-body">
                                                <span class="name">Chris Fox</span>
                                                <span class="message">Designer, Blogger</span>
                                                <span class="badge badge-outline status"></span>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <li class="online">
                                    <a href="javascript:void(0);">
                                        <div class="media">
                                            <img class="media-object " src="../assets/images/xs/avatar5.jpg"
                                                alt="">
                                            <div class="media-body">
                                                <span class="name">Joge Lucky</span>
                                                <span class="message">Java Developer</span>
                                                <span class="badge badge-outline status"></span>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <li class="offline">
                                    <a href="javascript:void(0);">
                                        <div class="media">
                                            <img class="media-object " src="../assets/images/xs/avatar2.jpg"
                                                alt="">
                                            <div class="media-body">
                                                <span class="name">Isabella</span>
                                                <span class="message">CEO, Thememakker</span>
                                                <span class="badge badge-outline status"></span>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <li class="offline">
                                    <a href="javascript:void(0);">
                                        <div class="media">
                                            <img class="media-object " src="../assets/images/xs/avatar1.jpg"
                                                alt="">
                                            <div class="media-body">
                                                <span class="name">Folisise Chosielie</span>
                                                <span class="message">Art director, Movie Cut</span>
                                                <span class="badge badge-outline status"></span>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <li class="online">
                                    <a href="javascript:void(0);">
                                        <div class="media">
                                            <img class="media-object " src="../assets/images/xs/avatar3.jpg"
                                                alt="">
                                            <div class="media-body">
                                                <span class="name">Alexander</span>
                                                <span class="message">Writter, Mag Editor</span>
                                                <span class="badge badge-outline status"></span>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="tab-pane body" id="friends">
                            <ul class="new_friend_list list-unstyled row">
                                <li class="col-lg-4 col-md-2 col-sm-6 col-4">
                                    <a href="#">
                                        <img src="../assets/images/sm/avatar1.jpg" class="img-thumbnail"
                                            alt="User Image">
                                        <h6 class="users_name">Jackson</h6>
                                        <small class="join_date">Today</small>
                                    </a>
                                </li>
                                <li class="col-lg-4 col-md-2 col-sm-6 col-4">
                                    <a href="#">
                                        <img src="../assets/images/sm/avatar2.jpg" class="img-thumbnail"
                                            alt="User Image">
                                        <h6 class="users_name">Aubrey</h6>
                                        <small class="join_date">Yesterday</small>
                                    </a>
                                </li>
                                <li class="col-lg-4 col-md-2 col-sm-6 col-4">
                                    <a href="#">
                                        <img src="../assets/images/sm/avatar3.jpg" class="img-thumbnail"
                                            alt="User Image">
                                        <h6 class="users_name">Oliver</h6>
                                        <small class="join_date">08 Nov</small>
                                    </a>
                                </li>
                                <li class="col-lg-4 col-md-2 col-sm-6 col-4">
                                    <a href="#">
                                        <img src="../assets/images/sm/avatar4.jpg" class="img-thumbnail"
                                            alt="User Image">
                                        <h6 class="users_name">Isabella</h6>
                                        <small class="join_date">12 Dec</small>
                                    </a>
                                </li>
                                <li class="col-lg-4 col-md-2 col-sm-6 col-4">
                                    <a href="#">
                                        <img src="../assets/images/sm/avatar1.jpg" class="img-thumbnail"
                                            alt="User Image">
                                        <h6 class="users_name">Jacob</h6>
                                        <small class="join_date">12 Dec</small>
                                    </a>
                                </li>
                                <li class="col-lg-4 col-md-2 col-sm-6 col-4">
                                    <a href="#">
                                        <img src="../assets/images/sm/avatar5.jpg" class="img-thumbnail"
                                            alt="User Image">
                                        <h6 class="users_name">Matthew</h6>
                                        <small class="join_date">17 Dec</small>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div> --}}
            </div>
            <div class="col-lg-8 col-md-12">
                <div class="card">
                    <ul class="nav nav-tabs">
                        <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#about">About</a>
                        </li>
                        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#documents">Documents</a></li>
                        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#fee">Settings</a></li>

                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane body active" id="about">

                            <h6>Qualifications</h6>
                            <hr>
                            <ul class="list-unstyled">

                                <p style="font-size: 16px; font-weight:900">Certificates</p style="font-size: 16px">

                                @if ($doctor->year_of_passing_out_degree != null)
                                    <li>
                                        <p><strong>Year Of Passing Out Degree:</strong>
                                            {{ $doctor->year_of_passing_out_degree }} </p>
                                    </li>
                                @endif

                                @if ($doctor->registration_council != null)
                                    <li>
                                        <p><strong>Registration Council :</strong> {{ $doctor->registration_council }}
                                        </p>
                                    </li>
                                @endif

                                @if ($doctor->year_of_passing_out_mbbs != null)
                                    <li>
                                        <p><strong>Year Of Passing Out MBBS:</strong>
                                            {{ $doctor->year_of_passing_out_mbbs }}</p>
                                    </li>
                                @endif

                                @if ($doctor->mbbs_certificate_number != null)
                                    <li>
                                        <p><strong>MBBS Certificate Number:</strong>
                                            {{ $doctor->mbbs_certificate_number }}</p>
                                    </li>
                                @endif

                                @if ($doctor->year_of_passing_out_pg != null)
                                    <li>
                                        <p><strong>Year Of Passing Out PG:</strong>
                                            {{ $doctor->year_of_passing_out_pg }}</p>
                                    </li>
                                @endif

                                @if ($doctor->pg_certificate_number != 0)
                                    <li>
                                        <p><strong>PG Certificate Number:</strong>
                                            {{ $doctor->pg_certificate_number }}</p>
                                    </li>
                                @endif


                                @if ($doctor->institution != null)
                                    <li>
                                        <p><strong>Institution:</strong>
                                            {{ $doctor->institution }}</p>
                                    </li>
                                @endif

                                @if ($doctor->additional_registration_certificate_number != null)
                                    <li>
                                        <p><strong>Additional Registration Certificate Number :</strong>
                                            {{ $doctor->additional_registration_certificate_number }}</p>
                                    </li>
                                @endif

                                {{-- @php
                                    if ($doctor->gender == 0) {
                                        $gender = 'Female';
                                    } else {
                                        $gender = 'Male';
                                    }
                                @endphp

                                <li>
                                    <p><strong>Gender:</strong> {{ $gender }}</p>
                                </li> --}}
                                @if ($doctor->experience_if_any != 0)
                                    <li>
                                        <p><strong>Experience If Any :</strong> {{ $doctor->experience_if_any }} </p>
                                    </li>
                                @endif


                            </ul>
                            <br>
                            {{-- <h6>Specialities</h6>
                            <hr>
                            <ul class="list-unstyled specialties">
                                <li>Mole checks and monitoring</li>
                                <li>Clinical Neurophysiology</li>
                            </ul> --}}
                        </div>
                        <div class="tab-pane body" id="documents">
                            <div class="tab-content">
                                <div class="tab-pane active" id="doc">
                                    <div class="row clearfix">

                                        @if ($doctor->mbbs_registration_certificate != null)
                                            <div class="col-lg-3 col-md-4 col-sm-12">
                                                <div class="card">
                                                    <div class="file">
                                                        <a href="javascript:void(0);">

                                                            <div class="icon">
                                                                <i class="zmdi zmdi-file-text"></i>
                                                            </div>
                                                            <div class="file-name">
                                                                <p class="m-b-5 text-muted">

                                                                    <a
                                                                        href="{{ asset('Images/Doctor/Certificates/' . $doctor->mbbs_registration_certificate) }}">{{ $doctor->mbbs_registration_certificate }}</a>
                                                                </p>

                                                            </div>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif

                                        @if ($doctor->additional_registration_certificate != null)
                                            <div class="col-lg-3 col-md-4 col-sm-12">
                                                <div class="card">
                                                    <div class="file">
                                                        <a href="javascript:void(0);">

                                                            <div class="icon">
                                                                <i class="zmdi zmdi-file-text"></i>
                                                            </div>
                                                            <div class="file-name">
                                                                <p class="m-b-5 text-muted">
                                                                    <a
                                                                        href="{{ asset('Images/Doctor/Certificates/' . $doctor->additional_registration_certificate) }}">{{ $doctor->additional_registration_certificate }}</a>
                                                                </p>

                                                            </div>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif

                                        @if ($doctor->degree_certificate != null)
                                            <div class="col-lg-3 col-md-4 col-sm-12">
                                                <div class="card">
                                                    <div class="file">
                                                        <a href="javascript:void(0);">

                                                            <div class="icon">
                                                                <i class="zmdi zmdi-file-text"></i>
                                                            </div>
                                                            <div class="file-name">
                                                                <p class="m-b-5 text-muted">
                                                                    <a
                                                                        href="{{ asset('Images/Doctor/Certificates/' . $doctor->degree_certificate) }}">{{ $doctor->degree_certificate }}</a>
                                                                </p>

                                                            </div>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif

                                        @if ($doctor->pg_certificate != null)
                                            <div class="col-lg-3 col-md-4 col-sm-12">
                                                <div class="card">
                                                    <div class="file">
                                                        <a href="javascript:void(0);">

                                                            <div class="icon">
                                                                <i class="zmdi zmdi-file-text"></i>
                                                            </div>
                                                            <div class="file-name">
                                                                <p class="m-b-5 text-muted">
                                                                    <a
                                                                        href="{{ asset('Images/Doctor/Certificates/' . $doctor->pg_certificate) }}">{{ $doctor->pg_certificate }}</a>
                                                                </p>

                                                            </div>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif

                                        @if ($doctor->experience_file != null)
                                            <div class="col-lg-3 col-md-4 col-sm-12">
                                                <div class="card">
                                                    <div class="file">
                                                        <a href="javascript:void(0);">

                                                            <div class="icon">
                                                                <i class="zmdi zmdi-file-text"></i>
                                                            </div>
                                                            <div class="file-name">
                                                                <p class="m-b-5 text-muted">
                                                                    <a
                                                                        href="{{ asset('Images/Doctor/Certificates/' . $doctor->experience_file) }}">{{ $doctor->experience_file }}</a>
                                                                </p>

                                                            </div>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif

                                        @if ($doctor->attachment != null)
                                            <div class="col-lg-3 col-md-4 col-sm-12">
                                                <div class="card">
                                                    <div class="file">
                                                        <a href="javascript:void(0);">

                                                            <div class="icon">
                                                                <i class="zmdi zmdi-file-text"></i>
                                                            </div>
                                                            <div class="file-name">
                                                                <p class="m-b-5 text-muted">
                                                                    <a
                                                                        href="{{ asset('Images/Doctor/Certificates/' . $doctor->attachment) }}">{{ $doctor->attachment }}</a>
                                                                </p>

                                                            </div>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif



                                    </div>
                                </div>

                            </div>
                        </div>
                        @php

                            if ($doctor->consultation_fee != 0) {
                                $fee = $doctor->consultation_fee;
                                $commission = $doctor->commission_percentage;
                                $amount = ($fee * $commission) / 100;
                            } else {
                                $fee = App\Models\Settings::pluck('consultation_fee')->first();
                                $commission = App\Models\Settings::pluck('commission_percentage')->first();
                                $amount = ($fee * $commission) / 100;
                            }

                            if ($doctor->followup_days != 0) {
                                $followup = $doctor->followup_days;
                            } else {
                                $followup = App\Models\Settings::pluck('followup_days')->first();
                            }

                        @endphp

                        <div class="tab-pane body" id="fee">

                            <h6>UPDATE CONSULTATION FEE</h6>
                            <hr>

                            <form action="{{ route('fee.update', ['id' => $doctor->id]) }}" method="post">
                                @csrf

                                <div class="row clearfix">
                                    <div class="col-lg-6 col-md-12">
                                        <div class="form-group">
                                            <label>Consultation Fee</label>
                                            <input type="number" name="consultation_fee" class="form-control"
                                                placeholder="Consultation Fee" value="{{ $fee }}">
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-12">
                                        <div class="form-group">
                                            <label>Commission percentage</label>
                                            <input type="number" class="form-control" name="commission_percentage"
                                                placeholder="Commission percentage" value="{{ $commission }}">
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-12">
                                        <div class="form-group">
                                            <label>Commission Amount</label>
                                            <input type="number" class="form-control" name="commission_amount"
                                                placeholder="Commission amount" value="{{ $amount }}" readonly>
                                        </div>
                                    </div>
                                </div>


                                <br>

                                <h6 style="padding-left: 10px">SET EMERGENCY</h6>
                                <hr>
                                <div class="row clearfix">

                                    <div class="col-lg-6 col-md-12">
                                        <div class="checkbox">
                                            <input id="checkbox" type="checkbox" name="emergency"
                                                {{ $doctor->emergency == 1 ? 'checked' : '' }}>
                                            <label for="checkbox">
                                                Emergency Doctor
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-12">

                                        <div class="form-group">
                                            <label>Followup Days</label>
                                            <input type="number" class="form-control" name="followup_days"
                                                value="{{ $followup }}">
                                        </div>
                                    </div>
                                </div>


                                <div class="col-md-12">
                                    <button class="btn btn-primary btn-round" type="submit">Save Changes</button>
                                </div>
                        </div>
                        </form>

                    </div>
                </div>
            </div>


        </div>
    </div>
    </div>
</section>


<script>
    function Verify(ev) {
        ev.preventDefault();
        var urlToRedirect = ev.currentTarget.getAttribute('href');
        console.log('urlToredirect');
        swal({
                title: `Do you want to Verify ?`,
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    window.location.href = urlToRedirect;
                }
            });
    }
</script>


<script>
    function Reject(ev) {
        ev.preventDefault();
        var urlToRedirect = ev.currentTarget.getAttribute('href');
        console.log('urlToredirect');
        swal({
                title: `Do you want to Reject ?`,
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    window.location.href = urlToRedirect;
                }
            });
    }
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.0/sweetalert.min.js"></script>

{{-- @include('templates.footer') --}}
