@include('templates.header')


<section class="content">
    <div class="block-header">
        <div class="row">
            <div class="col-lg-5 col-md-5 col-sm-12">
                <h2>
                    Add Student
                    <small>Welcome to Docbae</small>
                </h2>
            </div>
            <div class="col-lg-7 col-md-7 col-sm-12 text-right">

                <ul class="breadcrumb float-md-right">
                    <li class="breadcrumb-item">
                        <a href="index.html"><i class="zmdi zmdi-home"></i> Docbae</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="javascript:void(0);">Students</a>
                    </li>
                    <li class="breadcrumb-item active">Add Student</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="container-fluid">

        <div class="row clearfix">
            <div class="col-md-12">
                <div class="card">

                    <form action="{{ route('student.save') }}" method="post" enctype="multipart/form-data">
                        @csrf

                        <div class="body">
                            <div class="row clearfix">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label style="margin-left: 10px; font-size: 12px; font-weight:600 ">Name</label>
                                        <input type="text" class="form-control" name="name"
                                            placeholder="Student Name" value="{{ old('name', '') }}" required>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label
                                            style="margin-left: 10px; font-size: 12px; font-weight:600 ">Mobile</label>
                                        <input class="form-control" name="mobile" placeholder="Mobile"
                                            value="{{ old('mobile', '') }}" type="text" pattern="[1-9]{1}[0-9]{9}"
                                            required>
                                    </div>
                                </div>
                            </div>

                            <div class="row clearfix">

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="label-class"
                                            style="margin-left: 10px; font-size: 12px; font-weight:600 ">DOB</label>
                                        <input type="date" class="form-control" name="dob"
                                            value="{{ old('dob', '') }}" required>
                                    </div>


                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label
                                            style="margin-left: 10px; font-size: 12px; font-weight:600 ">Image</label>
                                        <input type="file" class="form-control datetimepicker" name="image"
                                            placeholder="Image" required>
                                    </div>
                                </div>

                            </div>

                            <div class="row clearfix">

                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label class="label-class"
                                            style="margin-left: 10px; font-size: 12px; font-weight:600 ">Address</label>
                                        <textarea name="address" placeholder="address" class="form-control" required></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="row clearfix">

                                <div class="col-sm-6">
                                    <label style="margin-left: 10px; font-size: 12p; font-weight:600x ">Gender</label>
                                    <select class="form-control show-tick" name="gender" required>
                                        <option value="">- Gender -</option>
                                        <option value="1">Male</option>
                                        <option value="0">Female</option>
                                    </select>
                                </div>

                                <div class="col-sm-6">
                                    <label style="margin-left: 10px; font-size: 12px; font-weight:600 ">Grade</label>
                                    <select class="form-control show-tick" name="grade_id" required>
                                        <option value="">- Grade -</option>
                                        @foreach ($grades as $item)
                                            <option value={{ $item->id }}>{{ $item->grade }}</option>
                                        @endforeach
                                    </select>
                                </div>

                            </div>
                            <br>

                            <div class="row clearfix">

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="label-class"
                                            style="margin-left: 10px; font-size: 12px; font-weight:600 ">Height</label>
                                        <input type="number" class="form-control" name="height"
                                            value="{{ old('height', '') }}" placeholder="height in cm" required>
                                    </div>


                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="label-class"
                                            style="margin-left: 10px; font-size: 12px; font-weight:600 ">Weight</label>
                                        <input type="number" class="form-control" name="weight"
                                            value="{{ old('weight', '') }}" placeholder="weight" required>
                                    </div>
                                </div>

                            </div>


                            <div class="row clearfix">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label style="margin-left: 10px; font-size: 12px; font-weight:600 ">Blood
                                            Group</label>
                                        <select class="form-control show-tick" name="blood_group_id" required>
                                            <option value="">- Blood Group -</option>

                                            @foreach ($blood_groups as $item)
                                                <option value="{{ $item->id }}">{{ $item->blood_types }}</option>
                                            @endforeach

                                        </select>
                                        @if ($errors->has('blood_group_id'))
                                            <span class="text-danger">{{ $errors->first('blood_group_id') }}</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-sm-6">

                                    <div class="form-group">
                                        <label class="label-class"
                                            style="margin-left: 10px; font-size: 12px; font-weight:600 ">LMP</label>
                                        <input type="date" class="form-control" name="lmp"
                                            value="{{ old('lmp', '') }}">
                                    </div>
                                </div>

                            </div>


                            <div class="row clearfix">

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
