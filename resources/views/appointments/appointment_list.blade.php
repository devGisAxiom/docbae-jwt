@include('templates.header')

<section class="content">
    <div class="block-header">
        <div class="row">
            <div class="col-lg-5 col-md-5 col-sm-12">
                <h2>
                    All Invitations
                    <small>Welcome to Docbae</small>
                </h2>
            </div>
            <div class="col-lg-7 col-md-7 col-sm-12 text-right">

                <ul class="breadcrumb float-md-right">
                    <li class="breadcrumb-item">
                        </i> Docbae
                    </li>

                    <li class="breadcrumb-item active">All Invitations</li>
                </ul>
            </div>
        </div>
    </div>

    @php
        $user = session()->get('user');
        $user_id = $user->id;
        $user_type = $user->user_type;
    @endphp

    <div class="row clearfix">
        <div class="col-sm-12">
            <div class="card">
                <div class="header">

                    <div class="row row-sm ml-4">

                        @if ($user_type == 0)
                            <form action="{{ route('appointment.list') }}">
                            @else
                                <form action="{{ route('institute.appointment.list') }}">
                        @endif


                        <div class="row pb-4">
                            <div class="col-xl-4">
                                <label>start Date: </label>
                                <input type="date" name="start_date" id="sdate" class="form-control"
                                    value="{{ Request()->start_date }}">
                            </div>
                            <div class="col-xl-4">
                                <label>End Date: </label>
                                <input type="date" name="end_date" id="edate" class="form-control"
                                    value="{{ Request()->end_date }}">
                            </div>
                            <div class="col-xl-4 pt-4">
                                <button type="submit" id="filter" class="btn btn-primary"
                                    style="margin: 2px">Filter</button>
                            </div>
                        </div>
                        </form>
                    </div>

                </div>


                <div class="body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Name</th>
                                    <th>Meeting Date</th>
                                    <th>Meeting Time</th>
                                    <th>Doctor</th>
                                    {{-- <th>View</th> --}}
                                </tr>
                            </thead>
                            <tbody>
                                @php $i = 1; @endphp
                                @foreach ($appointments as $item)
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
                                        <td>{{ $name }} </td>
                                        <td>{{ $item->meeting_date }}</td>
                                        <td>{{ $item->meeting_time }}</td>
                                        <td>{{ $item->doctor->first_name }} {{ $item->doctor->last_name }}</td>
                                        {{-- <td> <a href="{{ route('appointment.view', ['id' => $item['id']]) }}"><i
                                                    class="material-icons">visibility</i> </a></td> --}}

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
