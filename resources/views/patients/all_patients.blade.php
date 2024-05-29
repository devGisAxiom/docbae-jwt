@include('templates.header')

<section class="content">
    <div class="block-header">
        <div class="row">
            <div class="col-lg-5 col-md-5 col-sm-12">
                <h2>All Patients
                </h2>
            </div>
            <div class="col-lg-7 col-md-7 col-sm-12 text-right">

                <ul class="breadcrumb float-md-right">
                    <li class="breadcrumb-item"></i> Docbae</li>
                    <li class="breadcrumb-item active">All Patients</li>
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
                                        <th>Age</th>
                                        <th>Address</th>
                                        <th>Mobile</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $i = 1;   @endphp
                                    @foreach ($patients as $item)
                                        <tr>
                                            <td>{{ $i++ }} </td>
                                            <td>
                                                @if ($item->profile_pic == null)
                                                    <img src="{{ asset('assets/images/patients/user.jpg') }}"
                                                        style="width: 40px; height: 40px" alt="Avatar"
                                                        class="rounded-circle" />
                                                @else
                                                    <img src="{{ asset('Images/Patients/Profile_picture/' . $item->profile_pic) }}"
                                                        style="width: 40px; height: 40px" alt="Avatar"
                                                        class="rounded-circle" />
                                                @endif
                                            </td>

                                            <td> {{ $item->name }}</td>
                                            <td>34</td>
                                            <td> {{ $item->location }}</td>
                                            <td> {{ $item->mobile }} </td>

                                            <td>
                                                <a href="{{ route('Patient.view', ['id' => $item['id']]) }}">
                                                    <i class="material-icons">visibility</i></a>
                                                &nbsp;&nbsp;&nbsp;&nbsp;

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
