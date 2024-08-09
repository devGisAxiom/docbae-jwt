@include('templates.header')

<section class="content">
    <div class="block-header">
        <div class="row">
            <div class="col-lg-5 col-md-5 col-sm-12">
                <h2>
                    Doctors Schedules
                    <small>Welcome to Docbae</small>
                </h2>
            </div>
            <div class="col-lg-7 col-md-7 col-sm-12 text-right">

                <ul class="breadcrumb float-md-right">
                    <li class="breadcrumb-item">
                        </i> Docbae
                    </li>
                    <li class="breadcrumb-item">
                        Doctors Schedules
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="row clearfix">
        <div class="col-sm-12">
            <div class="card">
                <div class="header">
                    <h2><strong>Social</strong> Media</h2>

                </div>
                <div class="body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Name</th>
                                    <th>Day</th>
                                    <th>Time From</th>
                                    <th>Time To</th>
                                    <th>Action</th>

                                </tr>
                            </thead>
                            <tbody>

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

                                        $TimeFrom = Carbon\Carbon::createFromFormat('H:i:s', $item->time_from);
                                        $check_TimeFrom = $TimeFrom->format('A');
                                        $time_to = Carbon\Carbon::createFromFormat('H:i:s', $item->time_to);
                                        $check_time_to = $time_to->format('A');

                                        // if ($item->available_time == '0') {
                                        //     $availability = 'AM';
                                        // } elseif ($item->available_time == '1') {
                                        //     $availability = 'PM';
                                        // } elseif ($item->available_time == '2') {
                                        //     $availability = 'PM';
                                        // }

                                    @endphp


                                    <tr>
                                        <td>
                                            @if ($item->profile_pic == null)
                                                <img src="{{ asset('assets/images/doctors/user.jpg') }}"
                                                    class="img-fluid" alt="profile-image"
                                                    style="width: 50px; height:50px;" />
                                            @else
                                                <img src="{{ asset('Images/Doctor/Profile_picture/' . $item->profile_pic) }}"
                                                    style="width: 180px; height:180px;" class="img-fluid"
                                                    alt="profile-image" />
                                            @endif
                                        </td>
                                        <td><span class="list-name">{{ $item->doctor->first_name }}
                                                {{ $item->doctor->last_name }}<span>
                                        </td>
                                        <td> <span class="text-muted">{{ $week }}</span></td>
                                        <td>{{ $item->time_from }} {{ $check_TimeFrom }} </td>
                                        <td> {{ $item->time_to }} {{ $check_time_to }} </td>
                                        <td> <a href="{{ route('schedule.edit', ['id' => $item['id']]) }}"> <i
                                                    class="material-icons">edit</i></a> </td>


                                    </tr>
                                @endforeach


                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- @include('templates.footer') --}}
