@include('templates.header')

<section class="content">
    <div class="block-header">
        <div class="row">
            <div class="col-lg-5 col-md-5 col-sm-12">
                <h2>Settings
                </h2>
            </div>
            <div class="col-lg-7 col-md-7 col-sm-12 text-right">

                <ul class="breadcrumb float-md-right">
                    <li class="breadcrumb-item"><i class="zmdi zmdi-home"></i> Docbae</li>
                    <li class="breadcrumb-item">Settings</li>
                    <li class="breadcrumb-item active">Settings</li>
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
                                        <th>Id</th>
                                        <th>Consultation Fee</th>
                                        <th>Commission Percentage</th>
                                        <th>Payment Type</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $i = 1;   @endphp
                                    @foreach ($settings as $item)
                                        @php
                                            if ($item->payment_type == 1) {
                                                $payment_type = 'Weekly';
                                            } else {
                                                $payment_type = 'Monthly';
                                            }
                                        @endphp
                                        <tr>
                                            <td>{{ $i++ }} </td>
                                            <td>{{ $item->consultation_fee }}</td>
                                            <td>{{ $item->commission_percentage }} %</td>
                                            <td>{{ $payment_type }}</td>
                                            <td>
                                                <a href="{{ route('settings.edit', ['id' => $item['id']]) }}"> <i
                                                        class="material-icons">edit</i></a>

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
