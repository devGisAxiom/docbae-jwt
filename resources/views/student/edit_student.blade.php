@include('templates.header')

<section class="content">
    <div class="block-header">
        <div class="row">
            <div class="col-lg-5 col-md-5 col-sm-12">
                <h2>
                    Edit Student
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
                        <a href="index.html"><i class="zmdi zmdi-home"></i> Docbae</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="javascript:void(0);">Students</a>
                    </li>
                    <li class="breadcrumb-item active">Edit Student</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="container-fluid">

        <div class="row clearfix">
            <div class="col-md-12">
                <div class="card">
                    <div class="header">
                        {{-- <h2><strong>Registration</strong> Information </h2> --}}
                    </div>

                    <form action="{{ route('student.update', ['id' => $student->id]) }}" method="post"
                        enctype="multipart/form-data">
                        @csrf

                        <div class="body">
                            <div class="row clearfix">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="name"
                                            style="margin-left: 10px; font-size: 12px; font-weight:600">Student
                                            Name</label>
                                        <input type="text" class="form-control" name="name"
                                            placeholder="Student Name" value="{{ $student->name }}" required>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label
                                            style="margin-left: 10px; font-size: 12px; font-weight:600">Mobile</label>
                                        <input type="text" class="form-control" name="mobile" placeholder="Mobile"
                                            value="{{ $student->mobile }}">
                                    </div>
                                </div>
                            </div>

                            <div class="row clearfix">

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label style="margin-left: 10px; font-size: 12px; font-weight:600">DOB</label>
                                        <input type="date" class="form-control" name="dob"
                                            value="{{ $student->dob }}" placeholder="Age" required>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <label style="margin-left: 10px; font-size: 12px; font-weight:600">Gender</label>
                                    <select class="form-control show-tick" name="gender" required>
                                        <option value="">- Gender -</option>
                                        <option value="1"
                                            @if ($student->gender == 1) selected='selected' @endif>Male</option>
                                        <option value="0"
                                            @if ($student->gender == 0) selected='selected' @endif>Female</option>
                                    </select>
                                </div>

                            </div>

                            <div class="row clearfix">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label style="margin-left: 10px; font-size: 12px; font-weight:600">Blood
                                            Group</label>
                                        <select class="form-control show-tick" name="blood_group_id" required>
                                            <option value="">- Blood Group -</option>

                                            @foreach ($blood_groups as $item)
                                                <option value={{ $item->id }}
                                                    @if ($item->id == $student->blood_group_id) selected='selected' @endif>
                                                    {{ $item->blood_types }}</option>
                                            @endforeach

                                        </select>
                                        @if ($errors->has('blood_group_id'))
                                            <span class="text-danger">{{ $errors->first('blood_group_id') }}</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <label style="margin-left: 10px; font-size: 12px; font-weight:600">Grade</label>
                                    <select class="form-control show-tick" name="grade_id" required>
                                        <option value="">- Grade -</option>
                                        @foreach ($grades as $item)
                                            <option value={{ $item->id }}
                                                @if ($item->id == $student->grade_id) selected='selected' @endif>
                                                {{ $item->grade }}</option>
                                        @endforeach
                                    </select>
                                </div>

                            </div>
                            <br>

                            <div class="row clearfix">

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="logo"
                                            style="margin-left: 10px; font-size: 12px; font-weight:600">Image</label>
                                        <input type="file" class="form-control" name="image" placeholder="Image">

                                        @if ($student->image != null)
                                            <img style="margin-left:12px; margin-top: 15px; width: 80px; height: 80px"
                                                src="{{ asset('Images/Institution/Student/' . $student->image) }}">
                                        @endif
                                    </div>
                                </div>


                            </div>


                            <div class="row clearfix">

                                <div class="col-sm-12">
                                    <button type="submit" class="btn btn-primary btn-round"
                                        id="submit_button">Update</button>
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
