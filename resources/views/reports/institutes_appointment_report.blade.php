@include('templates.header')


<section class="content">
    <div class="block-header">
        <div class="row">
            <div class="col-lg-5 col-md-5 col-sm-12">
                <h2>
                    Appointment History
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
                    <li class="breadcrumb-item active">Appointment History</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="row clearfix">
        <div class="col-sm-12">
            <div class="card">
                <div class="header">

                    <div class="body">
                        <form action="{{ route('institute.appointment-history') }}">

                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>Start Date</th>
                                            <th>End Date </th>
                                            <th>Fund Released On </th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
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

                    </div>

                </div>
                <hr>

                <div class="body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Patient </th>
                                    <th>Grade</th>
                                    <th>Meeting Date</th>
                                    <th>Meeting Time</th>
                                    <th>Doctor</th>
                                    <th>Consultation Fee</th>

                                </tr>
                            </thead>
                            <tbody>
                                @php $i = 1; @endphp
                                @foreach ($appointments as $item)
                                    <tr>
                                        <td>{{ $i++ }} </td>
                                        <td>{{ $item->members->name }} </td>
                                        <td>{{ $item->members->grade_id }} </td>
                                        <td>{{ $item->meeting_date }}</td>
                                        <td>{{ $item->meeting_time }}</td>
                                        <td>{{ $item->doctor->first_name }} {{ $item->doctor->last_name }}</td>
                                        <td>{{ $item->consultation_fee }} </td>

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
