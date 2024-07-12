@include('templates.header')

<section class="content">
    <div class="block-header">
        <div class="row">
            <div class="col-lg-5 col-md-5 col-sm-12">
                <h2>All Students
                </h2>
            </div>
            <div class="col-lg-7 col-md-7 col-sm-12 text-right">

                <ul class="breadcrumb float-md-right">
                    <li class="breadcrumb-item"><a href="index.html"><i class="zmdi zmdi-home"></i> Docbae</a></li>
                    <li class="breadcrumb-item active">All Students</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <!-- Basic Examples -->
        <div class="row clearfix">
            <div class="col-lg-12">
                <div class="card">
                    <div class="header">
                        <ul class="header-dropdown">
                            <li class="remove">
                                <a href="{{ route('student.add') }}"><i class="material-icons">add</i></a>
                            </li>

                        </ul>
                    </div>

                    <div class="body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                <thead>
                                    <tr>
                                        <th>Sl No</th>
                                        <th>Image</th>
                                        <th> Name</th>
                                        <th>Grade</th>
                                        <th style="text-align: center">Health Card</th>
                                        <th>Qrcode</th>
                                        <th style="text-align: center">Scan</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $i = 1;   @endphp
                                    @foreach ($students as $item)
                                        @php
                                            $check_id = App\Models\HealthCardDetails::where(
                                                'student_id',
                                                $item->id,
                                            )->exists();

                                            $qrcode = App\Models\HealthCardDetails::where('student_id', $item->id)
                                                ->pluck('qrcode')
                                                ->first();

                                        @endphp
                                        <tr>
                                            <td>{{ $i++ }} </td>
                                            <td><img src="{{ asset('Images/Institution/Student/' . $item->image) }}"
                                                    style="width: 40px; height: 40px" alt="Avatar"
                                                    class="rounded-circle"></td>
                                            <td> {{ $item->name }}</td>
                                            <td> {{ $item->grade->grade }} </td>


                                            <td style="text-align: center">
                                                @if ($check_id == 1)
                                                    <a href="{{ route('healthcard', ['id' => $item['id']]) }}">
                                                        <i class="material-icons">visibility</i></a>
                                                @endif

                                            </td>
                                            <td>
                                                <img src="{{ asset('http://127.0.0.1:5500/storage/app/public/qr-codes/' . $qrcode) }}"
                                                    style="width: 50px; height:50px">

                                            </td>

                                            <td style="text-align: center"> <a
                                                    href="{{ route('student.scan-health-card', ['id' => $item['id']]) }}">
                                                    <i class="material-icons">settings_overscan</i></a></td>

                                            <td>
                                                <a href="{{ route('student.add-health-card', ['id' => $item['id']]) }}">
                                                    <i class="material-icons">add</i></a> &nbsp;&nbsp;&nbsp;&nbsp;
                                                <a href="{{ route('student.edit', ['id' => $item['id']]) }}">
                                                    <i class="material-icons">edit</i></a> &nbsp;&nbsp;&nbsp;&nbsp;
                                                <a href="{{ route('student.delete', $item->id) }}"
                                                    onclick="myDelete(event)"> <i
                                                        class="material-icons">delete_forever</i></a>
                                            </td>

                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    function myDelete(ev) {
        ev.preventDefault();
        var urlToRedirect = ev.currentTarget.getAttribute('href');
        console.log('urlToredirect');
        swal({
                title: `Do you want to Delete ?`,
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
<script type="text/javascript"></script>



{{-- @include('templates.footer') --}}
