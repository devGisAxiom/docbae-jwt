@include('templates.header')

<style>
    .checkbox-container {
        display: flex;
        gap: 10px;
    }

    .checkbox {
        display: flex;
        align-items: center;
    }
</style>

@php
    $helath_card_id = App\Models\HealthCardDetails::where('student_id', Request()->id)
        ->pluck('id')
        ->first();
    if ($helath_card_id != null) {
        $helath_card = App\Models\HealthCardDetails::findOrFail($helath_card_id);
    }
@endphp

<link href="../assets/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css"
    rel="stylesheet" />
<link href="../assets/plugins/bootstrap-select/css/bootstrap-select.css" rel="stylesheet" />
<!-- Custom Css -->
<section class="content">
    <div class="block-header">
        <div class="row">
            <div class="col-lg-5 col-md-5 col-sm-12">
                <h2>
                    Add health card
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
                        Students
                    </li>
                    <li class="breadcrumb-item active"> Add health card
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="container-fluid">

        <div class="row clearfix">
            <div class="col-md-12">
                <div class="card">
                    <div class="header">
                        <h2 style="text-align: center"><strong>SCHOOL HEALTH CARD</strong> </h2>
                    </div>

                    <form action="{{ route('student.save-health-card', ['id' => $student->id]) }}" method="post">
                        @csrf

                        <div class="body">
                            <div class="row clearfix">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="name"
                                            style="margin-left: 10px; font-size: 12px; font-weight:600">Student
                                            Name</label>
                                        <input type="text" class="form-control" name="name"
                                            placeholder="Student Name" value="{{ $student->name }}" readonly>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label style="margin-left: 10px; font-size: 12px; font-weight:600">Grade</label>

                                        <input type="text" class="form-control" name="name"
                                            placeholder="Student Name" value="{{ $student->grade->grade }}" readonly>

                                        {{-- <select class="form-control show-tick">
                                            @foreach ($grades as $item)
                                                <option value={{ $item->id }}
                                                    @if ($item->id == $student->grade_id) selected='selected' @endif>
                                                    {{ $item->grade }}</option>
                                            @endforeach
                                        </select> --}}
                                    </div>
                                </div>
                            </div>

                            <div class="row clearfix">
                                <div class="col-sm-6">
                                    <label style="margin-left: 10px; font-size: 12px; font-weight:600">Dob</label>

                                    <div class="input-group">
                                        <input type="text" class="form-control"
                                            placeholder="Please choose date & time..." value="{{ $student->dob }}"
                                            readonly>
                                    </div>
                                </div>
                                {{-- <div class="col-sm-3">
                                    <div class="form-group">
                                        <label style="margin-left: 10px; font-size: 12px; font-weight:600">Age</label>
                                        <input type="number" class="form-control" name="age"
                                            value="{{ $student->age }}" placeholder="Age">
                                    </div>
                                </div> --}}

                                @php
                                    if ($student->gender == 0) {
                                        $gender = 'female';
                                    } else {
                                        $gender = 'male';
                                    }
                                @endphp
                                <div class="col-sm-3">
                                    <label style="margin-left: 10px; font-size: 12px; font-weight:600">Gender</label>
                                    <input type="text" class="form-control" name="gender" placeholder="Student Name"
                                        value="{{ $gender }}" readonly>
                                    {{-- <select class="form-control show-tick">
                                        <option value="1"
                                            @if ($student->gender == 1) selected='selected' @endif>Male</option>
                                        <option value="0"
                                            @if ($student->gender == 0) selected='selected' @endif>Female</option>

                                    </select> --}}
                                </div>
                                <div class="col-sm-3">
                                    <label style="margin-left: 10px; font-size: 12px; font-weight:600">Blood
                                        Group</label>
                                    <input type="text" class="form-control"
                                        value="{{ $student->blood_group->blood_types }}" readonly>
                                    {{-- <select class="form-control show-tick">
                                        @foreach ($blood_groups as $item)
                                            <option value={{ $item->id }}
                                                @if ($item->id == $student->blood_group_id) selected='selected' @endif>
                                                {{ $item->blood_types }}</option>
                                        @endforeach
                                    </select> --}}
                                </div>
                            </div>

                            <div class="row clearfix">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label
                                            for="fathers_name"style="margin-left: 10px; font-size: 12px; font-weight:600">Father's
                                            Name</label>
                                        <input type="text" class="form-control" name="fathers_name"
                                            placeholder="Father's Name"
                                            @if ($helath_card_id != null) value="{{ $helath_card->fathers_name }}" @endif
                                            required>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label style="margin-left: 10px; font-size: 12px; font-weight:600">Father's
                                            Occupation
                                        </label>
                                        <input type="text" class="form-control" name="fathers_occupation"
                                            placeholder="Father's Occupation"
                                            @if ($helath_card_id != null) value="{{ $helath_card->fathers_occupation }}" @endif
                                            required>
                                    </div>
                                </div>
                            </div>

                            <div class="row clearfix">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label style="margin-left: 10px; font-size: 12px; font-weight:600">Mother's
                                            Name</label>
                                        <input type="text" class="form-control" name="mothers_name"
                                            placeholder="Mothers's Name"
                                            @if ($helath_card_id != null) value="{{ $helath_card->mothers_name }}" @endif
                                            required>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label style="margin-left: 10px; font-size: 12px; font-weight:600">Mother's
                                            Occupation
                                        </label>
                                        <input type="text" class="form-control" name="mothers_occupation"
                                            placeholder="Mother's Occupation"
                                            @if ($helath_card_id != null) value="{{ $helath_card->mothers_occupation }}" @endif
                                            required>
                                    </div>
                                </div>
                            </div>

                            <div class="row clearfix">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label style="margin-left: 10px; font-size: 12px; font-weight:600">Mobile
                                            Number
                                        </label>
                                        <input type="number" class="form-control" name="mobile"
                                            placeholder="mobile number" value="{{ $student->mobile }}" readonly>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label style="margin-left: 10px; font-size: 12px; font-weight:600">Additional
                                            Mobile Number
                                        </label>
                                        <input type="number" class="form-control" name="additional_mobile"
                                            placeholder="additional mobile number"
                                            @if ($helath_card_id != null) value="{{ $helath_card->additional_mobile }}" @endif>
                                    </div>
                                </div>
                            </div>

                            <div class="row clearfix">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label style="margin-left: 10px; font-size: 12px; font-weight:600">Email
                                        </label>
                                        <input type="text" class="form-control" name="email"
                                            placeholder="email"
                                            @if ($helath_card_id != null) value="{{ $helath_card->email }}" @endif
                                            required>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label style="margin-left: 10px; font-size: 12px; font-weight:600">Pincode
                                        </label>
                                        <input type="number" class="form-control" name="pincode"
                                            placeholder="pincode"
                                            @if ($helath_card_id != null) value="{{ $helath_card->pincode }}" @endif
                                            required>
                                    </div>
                                </div>
                            </div>

                            <div class="row clearfix">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label style="margin-left: 10px; font-size: 12px; font-weight:600">Name
                                            & Address of Family Physician
                                        </label>
                                        <textarea class="form-control" type="text" name="family_physician_details"
                                            placeholder="Name & Address of Family Physician">  @if ($helath_card_id != null)
{{ $helath_card->family_physician_details }}
@endif </textarea>

                                    </div>
                                </div>
                            </div>

                            <div class="row clearfix">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label style="margin-left: 10px; font-size: 12px; font-weight:600">Physician
                                            Phone
                                        </label>
                                        <input type="number" class="form-control" name="physician_phone"
                                            placeholder="physician phone"
                                            @if ($helath_card_id != null) value="{{ $helath_card->physician_phone }}" @endif>
                                    </div>
                                </div>


                                @php
                                    $histories = ['jaundice', 'allergies', 'blood-transaction'];
                                    $implants = ['dental-implants', 'branches', 'spectacles'];
                                    $hepatitis = ['1st-dose', '2st-dose', '3rd-dose'];
                                    $typhoid_given_on = ['1st(5Yr.)', 'IV(8.)', 'VII(11Yr.)', 'X(14Yr.)'];
                                    $tetanus_given_on = ['10yrs or Class VI', '15yrs or Class XI'];

                                    if ($helath_card_id != null) {
                                        $history_var = json_decode($helath_card->past_history, true);
                                        $implants_var = json_decode($helath_card->any_implant_accessories, true);
                                        $hepatitis_var = json_decode($helath_card->hepatitis_given_on, true);
                                        $typhoid_var = json_decode($helath_card->typhoid_given_on, true);
                                        $tetanus_var = json_decode($helath_card->tetanus_given_on, true);
                                    }

                                @endphp



                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label style="margin-left: 10px; font-size: 12px; font-weight:600">Past History
                                        </label>
                                        <div class="checkbox-container">
                                            @foreach ($histories as $index => $history)
                                                <div class="checkbox">
                                                    <input id="past_history{{ $index }}" type="checkbox"
                                                        name="past_history[]" value="{{ $history }}"
                                                        @if ($helath_card_id != null) @if (in_array($history, $history_var)) checked @endif
                                                        @endif>
                                                    <label
                                                        for="past_history{{ $index }}">{{ ucfirst(str_replace('-', ' ', $history)) }}</label>
                                                </div>
                                            @endforeach
                                        </div>

                                        {{-- <div class="checkbox-container">
                                            <div class="checkbox">
                                                <input id="past_history" type="checkbox" value="jaundice">
                                                <label for="past_history">
                                                    Jaundice
                                                </label>
                                            </div>
                                            <div class="checkbox">
                                                <input id="past_history1" type="checkbox" value="allergies">
                                                <label for="past_history1">Allergies</label>
                                            </div>
                                            <div class="checkbox">
                                                <input id="past_history2" type="checkbox" value="blood-transaction">
                                                <label for="past_history2">Blood Transaction</label>
                                            </div>
                                        </div> --}}
                                    </div>
                                </div>
                            </div>

                            <div class="row clearfix">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label style="margin-left: 10px; font-size: 12px; font-weight:600">
                                            Remarks
                                        </label>
                                        <textarea class="form-control" type="text" name="remarks" placeholder="remarks">  @if ($helath_card_id != null) {{ $helath_card->remarks }} @endif </textarea>

                                    </div>
                                </div>
                            </div>

                            <div class="row clearfix">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label style="margin-left: 10px; font-size: 12px; font-weight:600">
                                            Any major illness or operation in past
                                        </label>
                                        <textarea class="form-control" type="text" name="past_medical_history">   @if ($helath_card_id != null){{ $helath_card->past_medical_history }} @endif
                                        </textarea>

                                    </div>
                                </div>
                            </div>

                            <div class="row clearfix">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label style="margin-left: 10px; font-size: 12px; font-weight:600">
                                            Using any implant or accessories
                                        </label>


                                        <div class="checkbox-container">
                                            @foreach ($implants as $index => $item)
                                                <div class="checkbox">
                                                    <input id="any_implant_accessories{{ $index }}"
                                                        type="checkbox" name="any_implant_accessories[]"
                                                        value="{{ $item }}"
                                                        @if ($helath_card_id != null) @if (in_array($item, $implants_var)) checked @endif
                                                        @endif>
                                                    <label
                                                        for="any_implant_accessories{{ $index }}">{{ ucfirst(str_replace('-', ' ', $item)) }}</label>
                                                </div>
                                            @endforeach
                                        </div>


                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label style="margin-left: 10px; font-size: 12px; font-weight:600">Rt and Lt or
                                            Lens
                                            No
                                        </label>
                                        <input type="text" class="form-control" name="rt_and_lt"
                                            placeholder="Rt or Lens No"
                                            @if ($helath_card_id != null) value="{{ $helath_card->rt_and_lt }}" @endif>
                                    </div>
                                </div>
                            </div>

                            <h2 style="color:black; font-size:15px"><strong>Vaccination Status</strong> </h2>


                            <div class="row clearfix">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label style="margin-left: 10px; font-size: 12px; font-weight:600">
                                            Hepatitis-B given on
                                        </label>

                                        <div class="checkbox-container">
                                            @foreach ($hepatitis as $index => $item)
                                                <div class="checkbox">
                                                    <input id="hepatitis_given_on{{ $index }}" type="checkbox"
                                                        name="hepatitis_given_on[]" value="{{ $item }}"
                                                        @if ($helath_card_id != null) @if (in_array($item, $hepatitis_var)) checked @endif
                                                        @endif>
                                                    <label
                                                        for="hepatitis_given_on{{ $index }}">{{ ucfirst(str_replace('-', ' ', $item)) }}</label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>


                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label style="margin-left: 10px; font-size: 12px; font-weight:600">
                                            Typhoid given on Class
                                        </label>
                                        <div class="checkbox-container">

                                            @foreach ($typhoid_given_on as $index => $item)
                                                <div class="checkbox">
                                                    <input id="typhoid_given_on{{ $index }}" type="checkbox"
                                                        name="typhoid_given_on[]" value="{{ $item }}"
                                                        @if ($helath_card_id != null) @if (in_array($item, $typhoid_var)) checked @endif
                                                        @endif>
                                                    <label
                                                        for="typhoid_given_on{{ $index }}">{{ ucfirst(str_replace('-', ' ', $item)) }}</label>
                                                </div>
                                            @endforeach
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <div class="row clearfix">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label style="margin-left: 10px; font-size: 12px; font-weight:600"> D.T.& Polio
                                            Booster given on ( To be given at the age of 5 yrs or class 1st.)
                                        </label>
                                        <div class="checkbox-container">
                                            <div class="radio">
                                                <input name="dt_polio_booster_given" id="1" type="radio"
                                                    @if ($helath_card_id != null) @if ($helath_card->dt_polio_booster_given == '1') checked='checked' @endif
                                                    @endif>
                                                <label for="1">Yes</label>
                                            </div>
                                            <div class="radio">
                                                <input name="dt_polio_booster_given" id="0" type="radio"
                                                    @if ($helath_card_id != null) @if ($helath_card->dt_polio_booster_given == '0') checked='checked' @endif
                                                    @endif>
                                                <label for="0">No</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label style="margin-left: 10px; font-size: 12px; font-weight:600">
                                            Tetanus given on
                                        </label>
                                        <div class="checkbox-container">
                                            @foreach ($tetanus_given_on as $index => $item)
                                                <div class="checkbox">
                                                    <input id="tetanus_given_on{{ $index }}" type="checkbox"
                                                        name="tetanus_given_on[]" value="{{ $item }}"
                                                        @if ($helath_card_id != null) @if (in_array($item, $tetanus_var)) checked @endif
                                                        @endif>
                                                    <label
                                                        for="tetanus_given_on{{ $index }}">{{ ucfirst(str_replace('-', ' ', $item)) }}</label>
                                                </div>
                                            @endforeach

                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row clearfix">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label style="margin-left: 12px; font-size: 12px; font-weight:600">
                                            Present complaint(if any)
                                        </label>
                                        <textarea class="form-control" type="text" name="present_complaint"> @if ($helath_card_id != null) {{ $helath_card->present_complaint }} @endif
</textarea>

                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label style="margin-left: 10px; font-size: 12px; font-weight:600">
                                            Current Medication(if any)
                                        </label>
                                        <textarea class="form-control" type="text" name="current_medication">  @if ($helath_card_id != null) {{ $helath_card->current_medication }} @endif
</textarea>

                                    </div>
                                </div>
                            </div>

                            <br>

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



<script src="assets/bundles/libscripts.bundle.js"></script> <!-- Bootstrap JS and jQuery v3.2.1 -->
<script src="assets/bundles/vendorscripts.bundle.js"></script> <!-- slimscroll, waves Scripts Plugin Js -->
<script>
    $.fn.selectpicker.Constructor.DEFAULTS.iconBase = 'zmdi';
    $.fn.selectpicker.Constructor.DEFAULTS.tickIcon = 'zmdi-check';
</script>
<script src="../assets/plugins/momentjs/moment.js"></script> <!-- Moment Plugin Js -->
<script src="../assets/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js"></script>

<script src="assets/bundles/mainscripts.bundle.js"></script><!-- Custom Js -->
<script>
    $(function() {
        //Datetimepicker plugin
        $('.datetimepicker').bootstrapMaterialDatePicker({
            format: 'dddd DD MMMM YYYY - HH:mm',
            clearButton: true,
            weekStart: 1
        });
    });
</script>

@include('templates.footer')
