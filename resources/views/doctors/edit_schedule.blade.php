@include('templates.header')

<section class="content">
    <div class="block-header">
        <div class="row">
            <div class="col-lg-5 col-md-5 col-sm-12">
                <h2>
                    Edit Schedule
                    <small>Welcome to Docbae</small>
                </h2>
            </div>
            <div class="col-lg-7 col-md-7 col-sm-12 text-right">

                <ul class="breadcrumb float-md-right">
                    <li class="breadcrumb-item">
                        </i> Docbae
                    </li>

                    <li class="breadcrumb-item active">Edit Schedule</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="card">
                    <br>
                    <form action="{{ route('schedule.update', ['id' => $schedules->id]) }}" method="post">

                        @csrf

                        <div class="body">
                            <div class="row clearfix">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="name"
                                            style="margin-left: 10px; font-size: 12px; font-weight:600">Doctor
                                            Name</label>
                                        <input type="text" class="form-control"
                                            value="{{ $schedules->doctor->first_name }} {{ $schedules->doctor->last_name }}"
                                            readonly>
                                    </div>
                                </div>
                                <div class="col-sm-6"><label
                                        style="margin-left: 10px; font-size: 12px; font-weight:600">Day</label>
                                    <select class="form-control show-tick" name="day_of_week">
                                        <option value="">- Day -</option>
                                        <option value="1"
                                            @if ($schedules->day_of_week == 1) selected='selected' @endif>
                                            Monday</option>
                                        <option value="2"
                                            @if ($schedules->day_of_week == 2) selected='selected' @endif>
                                            Tuesday</option>
                                        <option value="3"
                                            @if ($schedules->day_of_week == 3) selected='selected' @endif>
                                            Wednesday</option>
                                        <option value="4"
                                            @if ($schedules->day_of_week == 4) selected='selected' @endif>
                                            Thursday</option>
                                        <option value="5"
                                            @if ($schedules->day_of_week == 5) selected='selected' @endif>
                                            Friday</option>
                                        <option value="6"
                                            @if ($schedules->day_of_week == 6) selected='selected' @endif>
                                            saturday</option>
                                        <option value="7"
                                            @if ($schedules->day_of_week == 7) selected='selected' @endif>
                                            Sunday</option>

                                    </select>
                                </div>
                            </div>
                            <br>
                            <div class="row clearfix">
                                <div class="col-sm-6">
                                    <label style="margin-left: 10px; font-size: 12px; font-weight:600">Available
                                        Time</label>
                                    <select class="form-control show-tick" name="available_time">
                                        <option value="">- Day -</option>
                                        <option value="0"
                                            @if ($schedules->available_time == 0) selected='selected' @endif>
                                            Morning</option>
                                        <option value="1"
                                            @if ($schedules->available_time == 1) selected='selected' @endif>
                                            Afternoon</option>
                                        <option value="2"
                                            @if ($schedules->available_time == 2) selected='selected' @endif>
                                            Evening</option>

                                    </select>
                                </div>


                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label style="margin-left: 10px; font-size: 12px; font-weight:600">
                                            Time From</label>

                                        <input type="time" class="form-control" name="time_from"
                                            value="{{ $schedules->time_from }}">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label style="margin-left: 10px; font-size: 12px; font-weight:600">
                                            Time To</label>
                                        <input type="time" class="form-control" name="time_to"
                                            value="{{ $schedules->time_to }}">
                                    </div>
                                </div>


                                <div class="col-sm-6" style="padding-top: 10px">
                                    <div class="form-group">
                                        <label style="margin-left: 10px; font-size: 12px; font-weight:600">
                                            Duration (In minutes)</label>

                                        <select class="form-control show-tick" name="duration">
                                            <option value="">- Duration -</option>
                                            <option value="5"
                                                @if ($schedules->duration == 5) selected='selected' @endif>
                                                05 </option>
                                            <option value="10"
                                                @if ($schedules->duration == 10) selected='selected' @endif>
                                                10 </option>
                                            <option value="15"
                                                @if ($schedules->duration == 15) selected='selected' @endif>
                                                15 </option>
                                            <option value="20"
                                                @if ($schedules->duration == 20) selected='selected' @endif>
                                                20
                                            </option>
                                            <option value="30"
                                                @if ($schedules->duration == 30) selected='selected' @endif>
                                                30
                                            </option>

                                        </select>
                                    </div>
                                </div>


                                <div class="col-sm-12" style="padding-top: 10px">
                                    <button type="submit" class="btn btn-primary btn-round">Submit</button>
                                </div>
                            </div>
                        </div>

                    </form>

                </div>
            </div>
        </div>

    </div>
</section>
