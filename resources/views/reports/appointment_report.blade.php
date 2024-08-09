@include('templates.header')

<section class="content">
    <div class="block-header">
        <div class="row">
            <div class="col-lg-5 col-md-5 col-sm-12">
                <h2>
                    Appointment Report
                    <small>Welcome to Docbae</small>
                </h2>
            </div>
            <div class="col-lg-7 col-md-7 col-sm-12 text-right">

                <ul class="breadcrumb float-md-right">
                    <li class="breadcrumb-item">
                        </i> Docbae
                    </li>
                    <li class="breadcrumb-item">
                        Reports
                    </li>
                    <li class="breadcrumb-item active">Appointment Report</li>
                </ul>
            </div>
        </div>
    </div>

    @php
        // $payment_type = App\Models\Settings::pluck('payment_type')->first();
        $released_date = App\Models\PaymentHistory::orderBy('id', 'desc')->pluck('date')->first();

    @endphp



    <div class="row clearfix">
        <div class="col-sm-12">
            <div class="card">
                <div class="header">
                    <div class="header">

                        {{-- <form action="{{ route('report.payment-release') }}" method="post">
                            @csrf --}}

                        <p style="text-align:left;font-weight:600">
                            @if ($released_date != null)
                                Last payment released on : {{ $released_date }}
                            @endif

                            @if (!$appointments->isEmpty())
                                <span style="float:right;">
                                    <button type="submit" class="btn btn-danger" style="margin: 2px"
                                        data-toggle="modal" data-target="#addevent">
                                        <b>Release Fund</b></button>
                                </span>
                            @endif

                        </p>

                        {{-- @if (Request()->start_date != null && Request()->end_date != null)
                                <ul class="header-dropdown">
                                    <li class="remove">
                                        <input type="hidden" value="0" name="payment_type">

                                        <input type="hidden" value={{ Request()->start_date }} name="start_date">
                                        <input type="hidden" value={{ Request()->end_date }} name="end_date">
                                        <button type="submit" class="btn btn-danger" style="margin: 2px">
                                            <b>Release Fund</b></button>
                                    </li>
                                </ul>
                            @else
                                @if ($payment_type == 1)
                                    @if (\Carbon\Carbon::now()->isTuesday())
                                        <ul class="header-dropdown">
                                            <li class="remove">
                                                <input type="hidden" value="1" name="payment_type">

                                                <button type="submit" class="btn btn-danger" style="margin: 2px">
                                                    <b>Release Fund</b></button>
                                            </li>
                                        </ul>
                                    @endif
                                @endif

                                @if ($payment_type == 2)
                                    @if (\Carbon\Carbon::now()->day == 2)
                                        <ul class="header-dropdown">
                                            <li class="remove">
                                                <input type="hidden" value="2" name="payment_type">

                                                <button type="submit" class="btn btn-danger" style="margin: 2px">
                                                    <b>Release Fund</b></button>
                                            </li>
                                        </ul>
                                    @endif
                                @endif
                            @endif --}}

                        {{-- </form> --}}

                    </div>
                    {{-- <br> --}}
                    {{--
                    <div class="body">
                        <form action="{{ route('report.appointment') }}">

                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>Doctor</th>
                                            <th>Start Date</th>
                                            <th>End Date </th>
                                            <th>Filter </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <th><select class="form-control show-tick" name="doctor_id">
                                                    <option value="">- Doctors -</option>
                                                    @foreach ($doctors as $item)
                                                        <option value="{{ $item->id }}">{{ $item->first_name }}
                                                        </option>
                                                    @endforeach
                                                </select></th>
                                            <th><input type="date" name="start_date" id="sdate"
                                                    class="form-control" value="{{ Request()->start_date }}"
                                                    style="padding-top: 20px"></th>
                                            <th><input type="date" name="end_date" id="edate"
                                                    class="form-control" value="{{ Request()->end_date }}"
                                                    style="padding-top: 20px"></th>
                                            <th><button type="submit" id="filter" class="btn btn-primary"
                                                    style="margin: 2px">Filter</button></th>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </form>

                    </div> --}}

                </div>
                <hr>

                <div class="body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Type</th>
                                    <th>Patient </th>
                                    <th>Meeting Date</th>
                                    <th>Meeting Time</th>
                                    <th>Doctor</th>
                                    <th>Consultation Fee</th>
                                    <th>Commission</th>
                                    {{-- <th>Action</th> --}}
                                </tr>
                            </thead>
                            <tbody>
                                @php $i = 1; @endphp
                                @foreach ($appointments as $item)
                                    @php
                                        $user_type = $item->user_type;

                                        if ($item->member_id != null) {
                                            $name = $item->members->name;
                                        }

                                        if ($item->user_type == 1) {
                                            $type = 'family';
                                        } else {
                                            $type = 'institute';
                                        }

                                    @endphp
                                    <tr>
                                        <td>{{ $i++ }} </td>
                                        <td>{{ $type }} </td>
                                        <td>{{ $name }} </td>
                                        <td>{{ $item->meeting_date }}</td>
                                        <td>{{ $item->meeting_time }}</td>
                                        <td>{{ $item->doctor->first_name }} {{ $item->doctor->last_name }}</td>
                                        <td>{{ $item->consultation_fee }} </td>
                                        <td>{{ $item->commission_amount }}</td>
                                        {{-- <td></td> --}}

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

{{-- modal --}}

@php
    $invitations = App\Models\Invitation::with('doctor')
        ->where('doctor_id', '<>', 0)
        ->where('fund_released', 0)
        ->where('status', 2)
        ->get()
        ->unique('doctor_id');

@endphp

<div class="modal fade" id="addevent" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            {{-- <div class="modal-header">
                <h4 class="title" id="defaultModalLabel">Add Event</h4>
            </div> --}}

            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-striped m-b-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th></th>
                                <th>Name</th>
                                {{-- <th>Date</th> --}}
                                <th>Fund</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $i=1;   @endphp
                            @foreach ($invitations as $item)
                                @php
                                    $consultation_fee = App\Models\Invitation::where('doctor_id', $item->doctor_id)
                                        ->where('fund_released', 0)
                                        ->where('status', 2)
                                        ->select('doctor_id', 'doctors_fee')
                                        ->get();

                                    $doctors_fee = 0;
                                    foreach ($consultation_fee as $value) {
                                        $doctors_fee += $value->doctors_fee;
                                    }

                                    $profile_pic = App\Models\Doctor::where('id', $item->doctor_id)
                                        ->pluck('profile_pic')
                                        ->first();

                                    $first_name = App\Models\Doctor::where('id', $item->doctor_id)
                                        ->pluck('first_name')
                                        ->first();
                                    $last_name = App\Models\Doctor::where('id', $item->doctor_id)
                                        ->pluck('last_name')
                                        ->first();

                                @endphp
                                <tr>
                                    <td>{{ $i++ }}</td>
                                    <td>
                                        @if ($profile_pic != null)
                                            <img src="{{ asset('Images/Doctor/Profile_picture/' . $profile_pic) }}"
                                                alt="Avatar" class="rounded-circle" style="width: 35px; height:35px">
                                        @else
                                            <img src="{{ asset('assets/images/patients/user.jpg') }}"
                                                style="width: 40px; height: 40px" alt="Avatar"
                                                class="rounded-circle" />
                                        @endif

                                    </td>
                                    <td>{{ $first_name }} {{ $last_name }}</td>
                                    {{-- <td>
                                        @if ($item->released_date != null)
                                            {{ $item->released_date }}
                                        @else
                                            ------
                                        @endif
                                    </td> --}}
                                    <td><span class="badge badge-danger">₹{{ $doctors_fee }}</span> </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>

                <hr>
            </div>
            <form action="{{ route('report.payment-release') }}" method="post">
                @csrf

                <input type="hidden" name="payment_type" value="1">
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-round waves-effect">Submit</button>
                    <button type="button" class="btn btn-simple btn-round waves-effect"
                        data-dismiss="modal">CLOSE</button>
                </div>
        </div>
        </form>

    </div>
</div>
