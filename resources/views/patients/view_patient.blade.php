@include('templates.header')

<section class="content profile-page">
    <div class="block-header">
        <div class="row">
            <div class="col-lg-7 col-md-5 col-sm-12">
                <h2>Patient Profile
                    <small>Welcome to DocBae</small>
                </h2>
            </div>
            <div class="col-lg-5 col-md-7 col-sm-12">

                <ul class="breadcrumb float-md-right">
                    <li class="breadcrumb-item"><i class="zmdi zmdi-home"></i> DocBae</li>
                    <li class="breadcrumb-item">Patients</li>
                    <li class="breadcrumb-item active">View Profile</li>
                </ul>
            </div>
        </div>
    </div>


    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-4 col-md-12">
                <div class="card profile-header">
                    <div class="body text-center">

                        @if ($patient->profile_pic == null)
                            <div class="profile-image"> <img src="{{ asset('assets/images/patients/user.jpg') }}"
                                    alt="">
                            </div>
                        @else
                            <div class="profile-image"> <img
                                    src="{{ asset('Images/Patients/Profile_picture/' . $patient->profile_pic) }}"
                                    alt="" style="width: 180px; height:180px"> </div>
                        @endif

                        <div>
                            <h4 class="m-b-0"><strong>{{ $patient->name }} </strong> </h4>
                            <p>{{ $patient->location }}<br> {{ $patient->mobile }}<br> {{ $patient->email }}</p>
                        </div>

                    </div>
                </div>

                @if (!$family_members->isEmpty())

                    <div class="card">
                        <ul class="nav nav-tabs">
                            <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#Followers">Family
                                    Members</a></li>
                            {{-- <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#friends">Friends</a></li> --}}
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane body active" id="Followers">
                                <ul class="right_chat list-unstyled">

                                    @foreach ($family_members as $item)
                                        @php
                                            $dateOfBirth = Carbon\Carbon::parse($item->dob);
                                            $age = $dateOfBirth->age;
                                        @endphp
                                        <li class="online">
                                            <a href="javascript:void(0);">
                                                <div class="media">

                                                    @if ($item->image == null)
                                                        <img src="{{ asset('assets/images/patients/user.jpg') }}"
                                                            alt="Avatar" style="width: 60px; height: 60px;">
                                                    @elseif ($item->relationship_id == 7)
                                                        <img src="{{ asset('Images/Patients/Profile_picture/' . $patient->profile_pic) }}"
                                                            alt="" style="width: 60px; height:60px">
                                                    @else
                                                        <img src="{{ asset('Images/Patients/FamilyMembers/' . $item->image) }}"alt="Avatar"
                                                            style="width: 60px; height: 60px;">
                                                    @endif
                                                    &nbsp;&nbsp;
                                                    <div class="media-body">
                                                        <span class="name">{{ $item->name }} ({{ $age }})
                                                        </span>
                                                        <span class="relation"> {{ $item->member->relation }} </span>
                                                        <br>
                                                        <span
                                                            class="blood_relation">{{ $item->blood_group->blood_types }}
                                                        </span>
                                                    </div>
                                                </div>
                                            </a>
                                        </li>
                                    @endforeach


                                </ul>
                            </div>

                        </div>
                    </div>
                @endif

            </div>

            <div class="col-lg-8 col-md-12">
                <div class="card">
                    <ul class="nav nav-tabs">
                        <li class="nav-item"><a class="nav-link active" data-toggle="tab"
                                href="#about">Appointments</a>
                        </li>
                        {{-- <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#Account">Account</a></li> --}}
                    </ul>

                    <div class="tab-content">
                        <div class="tab-pane body active" id="about">
                            <div class="table-responsive">
                                <table
                                    class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Meeting Date</th>
                                            <th>Meeting Time </th>
                                            <th>Doctor</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $i = 1;
                                        @endphp
                                        @foreach ($appointment as $item)
                                            <tr>
                                                <td> {{ $i++ }} </td>
                                                <td>
                                                    @if ($item->member_id != null)
                                                        {{ $item->members->name }}
                                                    @else
                                                        {{ $item->patient->name }}
                                                    @endif
                                                </td>
                                                <td>{{ $item->meeting_date }}</td>
                                                <td>{{ $item->meeting_time }}</td>
                                                <td>{{ $item->doctor->first_name }} {{ $item->doctor->last_name }}
                                                </td>
                                            </tr>
                                        @endforeach


                                    </tbody>
                                </table>
                            </div>
                            <hr>


                        </div>
                        <div class="tab-pane body" id="Account">
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="Username">
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control" placeholder="Current Password">
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control" placeholder="New Password">
                            </div>
                            <button class="btn btn-info btn-round">Save Changes</button>
                            <hr>
                            <div class="row clearfix">
                                <div class="col-lg-6 col-md-12">
                                    <div class="form-group">
                                        <input type="text" class="form-control" placeholder="First Name">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-12">
                                    <div class="form-group">
                                        <input type="text" class="form-control" placeholder="Last Name">
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-12">
                                    <div class="form-group">
                                        <input type="text" class="form-control" placeholder="City">
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-12">
                                    <div class="form-group">
                                        <input type="text" class="form-control" placeholder="E-mail">
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-12">
                                    <div class="form-group">
                                        <input type="text" class="form-control" placeholder="Country">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group m-b-10">
                                        <textarea rows="4" class="form-control no-resize" placeholder="Address Line 1"></textarea>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="checkbox">
                                        <input id="procheck2" type="checkbox">
                                        <label for="procheck2">New task notifications</label>
                                    </div>
                                    <div class="checkbox">
                                        <input id="procheck3" type="checkbox">
                                        <label for="procheck3">New friend request notifications</label>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <button class="btn btn-primary btn-round">Save Changes</button>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>
</section>


{{-- @include('templates.footer') --}}
