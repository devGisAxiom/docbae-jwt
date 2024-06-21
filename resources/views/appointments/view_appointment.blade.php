@include('templates.header')

<style>
    .body {
        margin: 20px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    th,
    td {
        border: 1px solid #000;
        padding: 4px;
        /* Reduced padding */
        text-align: left;
    }

    th {
        /* background-color: #f2f2f2; */
        font-size: 12px;
        /* Reduced font size */
        width: 200px;
        /* Reduced width */
    }
</style>
<section class="content">
    <div class="block-header">
        <div class="row">
            <div class="col-lg-5 col-md-5 col-sm-12">
                <h2>
                    View Appointment
                    <small>Welcome to Docbae</small>
                </h2>
            </div>
            <div class="col-lg-7 col-md-7 col-sm-12 text-right">

                <ul class="breadcrumb float-md-right">
                    <li class="breadcrumb-item">
                        </i> Docbae
                    </li>

                    <li class="breadcrumb-item active">View Appointment</li>
                </ul>
            </div>
        </div>
    </div>

    @php
        $user_type = $appointment->user_type;
        $blood_group = App\Models\BloodGroup::where('id', $appointment->members->blood_group_id)
            ->pluck('blood_types')
            ->first();
        if ($user_type == 1) {
            $user = 'Family';
            $name = 'PATIENT NAME';
        } else {
            $user = 'Institute';
            $name = 'INSTITUTE NAME';
            $grade = App\Models\Grade::where('id', $appointment->members->grade_id)
                ->pluck('grade')
                ->first();
        }
    @endphp
    <div class="row clearfix">
        <div class="col-sm-12">
            <div class="card">
                <div class="header">


                    <div class="body">
                        <div>
                            <table class="table table-bordered table-striped table-hover ">
                                <tr>
                                    <th colspan="2" style="text-align: center;font-size:15px">PATIENT DETAILS</th>
                                </tr>
                                <tr>
                                    <th>PATIENT TYPE</th>
                                    <td>{{ $user }} : &nbsp; {{ $appointment->patient->name }}</td>
                                </tr>
                                <tr>
                                    <th>PATIENT</th>
                                    <td>{{ $appointment->members->name }}</td>
                                </tr>
                                <tr>
                                    <th>PATIENT ID</th>
                                    <td>{{ $appointment->members->unique_id }}</td>
                                </tr>
                                @if ($user_type == 2)
                                    <tr>
                                        <th>GRADE</th>
                                        <td>{{ $grade }}</td>
                                    </tr>
                                @endif

                                <tr>
                                    <th>PHONE</th>
                                    <td>{{ $appointment->patient->mobile }}</td>

                                </tr>
                                <tr>
                                    <th>AGE</th>
                                    <td>{{ $appointment->members->age }}</td>

                                </tr>
                                <tr>
                                    <th>BLOOD GROUP</th>
                                    <td>{{ $blood_group }}</td>

                                </tr>

                            </table>

                            <br>
                            <table class="table table-bordered table-striped table-hover ">
                                <tr>
                                    <th colspan="2" style="text-align: center;font-size:15px">APPOINTMENT DETAILS
                                    </th>
                                </tr>
                                <tr>
                                    <th>MEETING DATE</th>
                                    <td>{{ $appointment->meeting_date }}</td>
                                </tr>
                                <tr>
                                    <th>MEETING TIME</th>
                                    <td>{{ $appointment->meeting_time }}</td>
                                </tr>
                                <tr>
                                    <th>DOCTOR</th>
                                    <td>{{ $appointment->doctor->first_name }} {{ $appointment->doctor->last_name }}
                                    </td>
                                </tr>
                                @if ($appointment->doctor->consultation_fee != 0)
                                    <tr>
                                        <th>CONSULTATION FEE</th>
                                        <td>{{ $appointment->doctor->consultation_fee }}</td>
                                    </tr>
                                @endif

                            </table>
                        </div>
                    </div>

                    {{-- <div class="body">
                        <P style="text-align: center;font-size:15px;font-weight:900">PRESCRIPTION</P>

                    </div> --}}

                </div>
            </div>
        </div>
</section>
