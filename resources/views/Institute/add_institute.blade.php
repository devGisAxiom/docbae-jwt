@include('templates.header')


<section class="content">
    <div class="block-header">
        <div class="row">
            <div class="col-lg-5 col-md-5 col-sm-12">
                <h2>
                    Add institute
                    <small>Welcome to Docbae</small>
                </h2>
            </div>
            <div class="col-lg-7 col-md-7 col-sm-12 text-right">
                <button class="btn btn-white btn-icon btn-round d-none d-md-inline-block float-right m-l-10"
                    type="button">
                    <i class="zmdi zmdi-plus"></i>
                </button>
                <ul class="breadcrumb float-md-right">
                    <li class="breadcrumb-item">
                        <i class="zmdi zmdi-home"></i> Docbae
                    </li>
                    <li class="breadcrumb-item">
                        Institutes
                    </li>
                    <li class="breadcrumb-item active">Add institute</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="container-fluid">

        <div class="row clearfix">
            <div class="col-md-12">
                <div class="card">
                    <div class="header">
                        <h2><strong>Registration</strong> Information </h2>
                    </div>

                    <form action="{{ route('institute.save') }}" method="post" enctype="multipart/form-data">
                        @csrf

                        <div class="body">
                            <div class="row clearfix">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="name"
                                            placeholder="Institute Name" value="{{ old('name', '') }}" required>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="mobile" placeholder="Mobile"
                                            value="{{ old('mobile', '') }}" required>
                                        @if ($errors->has('mobile'))
                                            <span class="text-danger">{{ $errors->first('mobile') }}</span>
                                        @endif

                                        <div>
                                            <span class="text-danger" id="check-mobile"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row clearfix">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="location"
                                            value="{{ old('location', '') }}" placeholder="Location" required>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="email" placeholder="Email"
                                            value="{{ old('email', '') }}" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row clearfix">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <select class="form-control show-tick" name="institution_type_id">
                                            <option>- Institution Type -</option>

                                            @foreach ($institution_types as $item)
                                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                                            @endforeach

                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">

                                        <select class="form-control show-tick" name="institution_sub_type_id">
                                            <option value="">- Institution Sub Type -</option>
                                            @foreach ($institution_sub_types as $item)
                                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                                            @endforeach
                                        </select>

                                    </div>
                                </div>
                            </div>

                            <div class="row clearfix">


                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="logo" style="margin-left: 10px; font-size: 12px ">Logo</label>
                                        <input type="file" class="form-control" name="profile_pic"
                                            placeholder="Logo">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="Authorization Letter"
                                            style="margin-left: 10px; font-size: 12px">Authorization
                                            Letter</label>
                                        <input type="file" class="form-control" name="authorization_letter"
                                            placeholder="Authorization Letter">
                                    </div>
                                </div>
                            </div>

                            <div class="row clearfix">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="no_of_participants"
                                            placeholder="Number of participants"
                                            value="{{ old('no_of_participants', '') }}">
                                    </div>
                                </div>

                                <div class="col-sm-12">
                                    <button type="submit" class="btn btn-primary btn-round"
                                        id="submit_button">Submit</button>
                                    {{-- <button class="btn btn-default btn-round btn-simple">Cancel</button> --}}
                                </div>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

</section>
</body>



@include('templates.footer')
