@include('templates.header')


<section class="content">
    <div class="block-header">
        <div class="row">
            <div class="col-lg-5 col-md-5 col-sm-12">
                <h2>
                    Payment Report
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
                    <li class="breadcrumb-item active">Payment Report</li>
                </ul>
            </div>
        </div>
    </div>


    <div class="row clearfix">
        <div class="col-sm-12">
            <div class="card">
                {{-- <div class="header">

                    <div class="body">
                        <form action="{{ route('report.payment') }}">

                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>Doctor</th>
                                            <th>Start Date</th>
                                            <th>End Date </th>
                                            <th>Fund Released On </th>
                                            <th>Filter</th>
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
                                            <th><input type="date" name="fund_released_on" id="fund_released_on"
                                                    class="form-control" value="{{ Request()->fund_released_on }}"
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
                <hr> --}}

                <div class="body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Doctor</th>
                                    <th>Payment </th>
                                    <th>Payment Released On</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $i = 1; @endphp
                                @foreach ($doctor_payments as $item)
                                    <tr>
                                        <td>{{ $i++ }} </td>
                                        <td>{{ $item->doctor->first_name }} {{ $item->doctor->last_name }}</td>
                                        <td>{{ $item->total_amount }} </td>
                                        <td>{{ $item->date }}</td>

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
