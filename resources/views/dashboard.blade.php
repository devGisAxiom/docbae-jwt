@include('templates.header')


<section class="content home">
    <div class="block-header">
        <div class="row">
            <div class="col-lg-5 col-md-5 col-sm-12">
                <h2>Dashboard
                    <small>Welcome to DocBae</small>
                </h2>
            </div>
            <div class="col-lg-7 col-md-7 col-sm-12 text-right">

                <ul class="breadcrumb float-md-right">
                    <li class="breadcrumb-item"><a href=""><i class="zmdi zmdi-home"></i> DocBae</a></li>
                    <li class="breadcrumb-item active">Dashboard</li>
                </ul>
            </div>
        </div>
    </div>


    <div class="container-fluid">

        @php
            $month = Illuminate\Support\Carbon::now()->format('M');
            $year = Illuminate\Support\Carbon::now()->format('Y');
            $day = Illuminate\Support\Carbon::now()->format('D');
            $date = Illuminate\Support\Carbon::now()->format('d');

            $user = session()->get('user');
            $user_id = $user->id;
            $user_type = $user->user_type;
            $user_name = $user->name;
            $profile_pic = $user->profile_pic;

            if ($user_type == 0) {
                $appointment_count = App\Models\Invitation::where('status', 2)
                    ->where('emergency_call', 0)
                    ->where('doctor_id', '<>', 0)
                    ->count('id');
                $invitations_count = App\Models\Invitation::where('status', 0)
                    ->where('emergency_call', 0)
                    ->where('doctor_id', '<>', 0)
                    ->count('id');
            } else {
                $appointment_count = App\Models\Invitation::where('patient_id', $user_id)
                    ->where('doctor_id', '<>', 0)
                    ->where('status', 2)
                    ->count('id');
                $invitations_count = App\Models\Invitation::where('patient_id', $user_id)
                    ->where('doctor_id', '<>', 0)
                    ->where('status', 0)
                    ->where('emergency_call', 0)
                    ->count('id');
            }

        @endphp

        {{-- @if (session('success'))
            <div id="auto-hide-success" class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        @if (session('error'))
            <div id="auto-hide-error" class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif --}}


        <div class="row clearfix">

            @if ($user_type == 2)

                @php
                    $students_count = App\Models\Member::where('user_type', 2)
                        ->where('patient_id', $user_id)
                        ->where('status', 1)
                        ->count('id');
                @endphp
                <div class="col-lg-4 col-md-12">
                    <div class="card member-card">
                        <div class="header l-coral">
                            <h4 class="m-t-10">{{ $user_name }}</h4>

                        </div>
                        <div class="member-img">
                            <img src="{{ asset('Images/Institution/Profile_picture/' . $profile_pic) }}"
                                class="rounded-circle" alt="profile-image">
                        </div>
                        <div class="body">
                            <strong>{{ $user->email }}</strong> <br>
                            <strong>{{ $user->mobile }}</strong> <br>
                            <address>{{ $user->location }}</address>
                            <hr>
                            {{-- <div class="row">
                                <div class="col-4">
                                    <h5>37</h5>
                                    <small>Visit</small>
                                </div>
                                <div class="col-4">
                                    <h5>5</h5>
                                    <small>Surgery</small>
                                </div>
                                <div class="col-4">
                                    <h5>1,256$</h5>
                                    <small>Spent</small>
                                </div>
                            </div> --}}
                        </div>
                    </div>
                </div>
            @else
                <div class="col-lg-4 col-md-12">
                    <div class="card">
                        <div class="header">
                            <h2><strong>Dr.</strong> Schedules : &nbsp;<strong>{{ $date }} {{ $day }}
                                    {{ $month }} </strong>
                            </h2>
                            <ul class="header-dropdown">
                                <li class="remove">
                                    <a role="button" class="boxs-close"><i class="zmdi zmdi-close"></i></a>
                                </li>
                            </ul>
                        </div>
                        <div class="body">
                            <div class="new_timeline">
                                <div class="header">
                                    <div class="pw_img">
                                        <img class="img-fluid" src="{{ asset('assets/images/image4.jpg') }}"
                                            alt="About the image">
                                    </div>
                                </div>
                                <ul>
                                    @foreach ($schedules as $item)
                                        @php
                                            $time_from = Illuminate\Support\Carbon::createFromFormat(
                                                'H:i:s',
                                                $item->time_from,
                                            )->format('h:i A');

                                            $time_to = Illuminate\Support\Carbon::createFromFormat(
                                                'H:i:s',
                                                $item->time_to,
                                            )->format('h:i A');
                                        @endphp
                                        <li>
                                            {{-- <h5>Notifications: {{ Helper::GenerateUniqueId() }} </h5> --}}

                                            <div class="bullet green"></div>
                                            <div class="time">{{ $time_from }} - {{ $time_to }}</div>
                                            <div class="desc">
                                                <h3 style="font-weight: 500"> {{ $item->doctor->first_name }}
                                                    {{ $item->doctor->last_name }}
                                                </h3>
                                            </div>
                                        </li>
                                    @endforeach


                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <div class="col-lg-8 col-md-12">
                <div class="row clearfix">

                    @if ($user_type == 0)
                        <div class="col-lg-4 col-md-6">
                            <a href="{{ route('doctors.all') }}">
                                <div class="card top_counter">
                                    <div class="body">
                                        <div class="icon xl-slategray"><i class="zmdi zmdi-account"></i> </div>
                                        <div class="content">
                                            <div class="text">Doctors</div>
                                            <h5 class="number">{{ $doctors_count }}</h5>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-lg-4 col-md-6">
                            <a href="{{ route('Patients.all') }}">
                                <div class="card top_counter">
                                    <div class="body">
                                        <div class="icon xl-slategray"><i class="zmdi zmdi-account"></i> </div>
                                        <div class="content">
                                            <div class="text">Patients</div>
                                            <h5 class="number">{{ $patients_count }}</h5>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endif

                    @if ($user_type == 2)
                        <div class="col-lg-4 col-md-6">
                            <a href="{{ route('student.list') }}">
                                <div class="card top_counter">
                                    <div class="body">
                                        <div class="icon xl-slategray"><i class="zmdi zmdi-account"></i> </div>
                                        <div class="content">
                                            <div class="text">Students</div>
                                            <h5 class="number">{{ $students_count }}</h5>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endif

                    <div class="col-lg-4 col-md-6">

                        @if ($user_type == 0)
                            <a href="{{ route('report.appointment-history') }}">
                            @else
                                <a href="{{ route('institute.appointment-history') }}">
                        @endif


                        <div class="card top_counter">
                            <div class="body">
                                <div class="icon xl-slategray"><i class="zmdi zmdi-bug"></i> </div>
                                <div class="content">
                                    <div class="text">Appointments</div>
                                    <h5 class="number">{{ $appointment_count }}</h5>
                                </div>
                            </div>
                        </div>
                        </a>
                    </div>

                    <div class="col-lg-4 col-md-6">
                        @if ($user_type == 0)
                            <a href="{{ route('appointment.list') }}">
                            @else
                                <a href="{{ route('institute.appointment.list') }}">
                        @endif

                        <div class="card top_counter">
                            <div class="body">
                                <div class="icon xl-slategray"><i class="zmdi zmdi-bug"></i> </div>
                                <div class="content">
                                    <div class="text">Invitations</div>
                                    <h5 class="number">{{ $invitations_count }}</h5>
                                </div>
                            </div>
                        </div>
                        </a>
                    </div>
                </div>
                <div class="card visitors-map">
                    @if ($user_type == 0)

                        <div class="body">
                            <div class="card patient_list">
                                <div class="header">
                                    <h2><strong>New</strong> Invitations</h2>

                                </div>
                                <div class="body">
                                    <div class="table-responsive">
                                        <table class="table table-striped m-b-0">
                                            <thead>
                                                <tr>
                                                    <th>Id</th>
                                                    <th>Name</th>
                                                    <th>Meeting Date</th>
                                                    <th>Meeting Time</th>
                                                    <th>Doctor</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php $i = 1; @endphp
                                                @foreach ($invitations as $item)
                                                    @php
                                                        $user_type = $item->user_type;
                                                        if ($item->member_id != null) {
                                                            $name = $item->members->name;
                                                        } elseif ($item->member_id == null && $user_type == 1) {
                                                            $name = $item->patient->name;
                                                        }

                                                    @endphp
                                                    <tr>
                                                        <td> {{ $i++ }} </td>
                                                        <td> {{ $name }} </td>
                                                        <td>{{ $item->meeting_date }}</td>
                                                        <td>{{ $item->meeting_time }}</td>
                                                        <td>{{ $item->doctor->first_name }}
                                                            {{ $item->doctor->last_name }}
                                                        </td>

                                                    </tr>
                                                @endforeach


                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                </div>
            </div>
        </div>


    </div>
</section>
