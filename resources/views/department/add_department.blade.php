@include('templates.header')

<section class="content">
    <div class="block-header">
        <div class="row">
            <div class="col-lg-7 col-md-5 col-sm-12">
                <h2>Docbae
                    <small class="text-muted">Welcome to DocBae</small>
                </h2>
            </div>
            <div class="col-lg-5 col-md-7 col-sm-12">
                <ul class="breadcrumb float-md-right">
                    <li class="breadcrumb-item"><i class="zmdi zmdi-home"></i> Docbae</li>
                    <li class="breadcrumb-item"> Department</li>
                    <li class="breadcrumb-item active">Add Department</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="card">
                    <div class="header">
                        <h2><strong>Add</strong> Department</h2>
                        <ul class="header-dropdown">
                            <li class="remove">
                                <a role="button" class="boxs-close"><i class="zmdi zmdi-close"></i></a>
                            </li>
                        </ul>
                    </div>


                    <form action="{{ route('department.save') }}" method="POST">

                        @csrf
                        <div class="body">
                            <div class="row clearfix">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="department"
                                            placeholder="Department Name" required>
                                    </div>
                                </div>
                            </div>

                            <br><br>
                            <div class="row clearfix">
                                <div class="col-sm-12">
                                    <button type="submit" class="btn btn-primary btn-round">Submit</button>
                                    {{-- <button type="submit" class="btn btn-default btn-round btn-simple">Cancel</button> --}}
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
