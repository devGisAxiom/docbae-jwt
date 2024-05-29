@include('templates.header')

<section class="content">
    <div class="block-header">
        <div class="row">
            <div class="col-lg-7 col-md-5 col-sm-12">
                <h2>Super Speciality
                    <small class="text-muted">Welcome to DocBae</small>
                </h2>
            </div>
            <div class="col-lg-5 col-md-7 col-sm-12">
                <ul class="breadcrumb float-md-right">
                    <li class="breadcrumb-item"><i class="zmdi zmdi-home"></i> Docbae</li>
                    <li class="breadcrumb-item"> Super Speciality</li>
                    <li class="breadcrumb-item active">Edit Super Speciality</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="card">
                    <div class="header">
                        <ul class="header-dropdown">
                            <li class="remove">
                                <a role="button" class="boxs-close"><i class="zmdi zmdi-close"></i></a>
                            </li>
                        </ul>
                    </div>


                    <form action="{{ route('super_speciality.update', ['id' => $super_speciality->id]) }}"
                        method="POST">

                        @csrf
                        <div class="body">
                            <div class="row clearfix">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label style="margin-left: 10px; font-size: 14px; font-weight:500 "> Super
                                            Speciality</label>
                                        <input type="text" class="form-control" name="super_speciality"
                                            placeholder="Super Speciality Name"
                                            value="{{ $super_speciality->super_speciality }}" required>
                                    </div>
                                </div>
                            </div>

                            <br><br>
                            <div class="row clearfix">
                                <div class="col-sm-12">
                                    <button type="submit" class="btn btn-primary btn-round">Update</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
