<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>School Health Card</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        .container {
            border: 1px solid #000;
            padding: 40px;
            max-width: 800px;
            margin: auto;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header img {
            max-height: 50px;
        }

        .section {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .left,
        .right {
            width: 48%;
        }

        .section h2 {
            border-bottom: 1px solid #000;
            padding-bottom: 5px;
        }

        .section label {
            display: block;
            margin-bottom: 10px;
        }

        .input-group-inline {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .input-group-inline label {
            margin-right: 10px;
        }

        .input-group-inline label:last-child {
            margin-right: 0;
        }

        .label-head {
            font-weight: 600;
        }
    </style>
</head>

@php
    $check_gender = 0;

    if ($student->gender == 0) {
        $check_gender = 'F';
    } else {
        $check_gender = 'M';
    }
    $blood_group = App\Models\BloodGroup::where('id', $student->blood_group_id)
        ->pluck('blood_types')
        ->first();
    $grade = App\Models\Grade::where('id', $student->grade_id)
        ->pluck('grade')
        ->first();

    $histories = ['jaundice', 'allergies', 'blood-transaction'];
    $implants = ['dental-implants', 'branches', 'spectacles'];
    $hepatitis = ['1st-dose', '2st-dose', '3rd-dose'];
    $typhoid_given_on = ['1st(5Yr.)', 'IV(8.)', 'VII(11Yr.)', 'X(14Yr.)'];
    $tetanus_given_on = ['10yrs or Class VI', '15yrs or Class XI'];

    $history_var = json_decode($details->past_history, true);
    $implants_var = json_decode($details->any_implant_accessories, true);
    $hepatitis_var = json_decode($details->hepatitis_given_on, true);
    $typhoid_var = json_decode($details->typhoid_given_on, true);
    $tetanus_var = json_decode($details->tetanus_given_on, true);

@endphp

<body>

    <div class="container">
        <div class="header">
            {{-- <img src="wellnexus.png" alt="Wellnexus"> --}}
            <img src="assets/images/docbae.jpeg" width="50" alt="docbae" />

            <h1>SCHOOL HEALTH CARD</h1>
        </div>

        <div class="section">
            <div class="left">
                <label><b>Name</b> <span style="padding-left: 94px"> {{ $student->name }} </span> </label>
                <label><b>DOB</b> <span style="padding-left: 100px"> {{ $student->dob }}
                    </span></label>
                <label> <b>Father's Name</b> <span style="padding-left: 30px"> {{ $details->fathers_name }}
                    </span></label>
                <label> <b>Mother's Name</b> <span
                        style="padding-left: 26px">{{ $details->mothers_name }}</span></label>
                <label> <b>Mailing Address </b> <span style="padding-left: 20px">{{ $details->email }}</span> </label>
                <label> <b>Mobile 1 </b> <span style="padding-left: 78px">{{ $student->mobile }}</span></label>
            </div>
            <div class="right">
                <label> <b>Age</b> <span style="padding-left:80px">{{ $student->age }}</span>
                    <span style="font-weight:600; padding-left:50px">Sex</span> <span
                        style="padding-left:30px">{{ $check_gender }}</span></label>
                <label> <b>Blood Group</b> <span style="padding-left:10px"> {{ $blood_group }} </span>
                    <span style="font-weight:600; padding-left:50px">Class</span> <span
                        style="padding-left:12px">{{ $grade }}</span></label>

                <label><span style="font-weight: 600">Father's Occupation </span> <span
                        style="padding-left: 30px">{{ $details->fathers_occupation }}</span> </label>
                <label><span style="font-weight: 600">Mother's Occupation </span> <span
                        style="padding-left: 25px">{{ $details->mothers_occupation }}</span> </label>
                <label><span style="font-weight: 600">Pincode </span> <span
                        style="padding-left: 120px">{{ $details->pincode }}</span>
                </label>
                <label><b>Mobile 2</b> <span style="padding-left: 120px">{{ $details->additional_mobile }}</span>
                </label>
            </div>
        </div>


        <div> <label class="label-head">Name and address of family physician : </label>
            <label style="padding-left: 10px"> {{ $details->family_physician_details }} &nbsp;&nbsp;&nbsp;
                <b>Phone:</b> &nbsp;
                {{ $details->physician_phone }}</label>
        </div>

        <br>
        <div>
            <label class="label-head">Past History</label> &nbsp;
            @foreach ($histories as $index => $history)
                <label> <input id="past_history{{ $index }}" type="checkbox" name="past_history[]"
                        value="{{ $history }}" @if (in_array($history, $history_var)) checked @endif>
                    {{ ucfirst(str_replace('-', ' ', $history)) }}</label> &nbsp;
                &nbsp;
            @endforeach

        </div>
        <br>

        <div> <label class="label-head">Remarks : </label>
            <label style="padding-left: 30px"> {{ $details->remarks }}</label>
        </div>
        <br>
        <div> <label class="label-head">Any Major illness or operations in the past : </label>
            <label style="padding-left: 20px">{{ $details->past_medical_history }} </label>
        </div>
        <br>

        <div>
            <label class="label-head">Using any implant accessories</label> &nbsp;

            @foreach ($implants as $index => $item)
                <label> <input id="any_implant_accessories{{ $index }}" type="checkbox"
                        name="any_implant_accessories[]" value="{{ $item }}"
                        @if (in_array($item, $implants_var)) checked @endif>
                    {{ ucfirst(str_replace('-', ' ', $item)) }}</label> &nbsp;
                &nbsp;
            @endforeach

            <label> <b>Rt or Lt :</b> {{ $details->rt_and_lt }}<label>

        </div>
        <p style="font-size: 16px; font-weight:800">Vaccination Status</p style="font-size: 16px; font-weight:800">

        <div>
            <label class="label-head">Hepatitis B given on</label>

            @foreach ($hepatitis as $index => $item)
                <label style="padding-left: 60px"> <input id="hepatitis_given_on{{ $index }}" type="checkbox"
                        name="hepatitis_given_on[]" value="{{ $item }}"
                        @if (in_array($item, $hepatitis_var)) checked @endif>
                    {{ ucfirst(str_replace('-', ' ', $item)) }}</label> &nbsp;
                &nbsp;
            @endforeach
        </div>
        <br>

        <div>
            <label class="label-head">Typhoid given on class</label>

            @foreach ($typhoid_given_on as $index => $item)
                <label style="padding-left: 40px"> <input id="hepatitis_given_on{{ $index }}" type="checkbox"
                        name="hepatitis_given_on[]" value="{{ $item }}"
                        @if (in_array($item, $typhoid_var)) checked @endif>
                    {{ ucfirst(str_replace('-', ' ', $item)) }}</label> &nbsp;
                &nbsp;
            @endforeach

        </div> <br>

        <div>
            <label class="label-head">D.T.& Polio Booster given </label>
            <label style="padding-left: 20px"><input type="checkbox"> Yes</label> &nbsp; &nbsp;
            <label><input type="checkbox"> No</label> &nbsp; &nbsp;
        </div> <br>

        <div>
            <label class="label-head">Tetanus given on</label> &nbsp; &nbsp; &nbsp;

            @foreach ($tetanus_given_on as $index => $item)
                <label style="padding-left: 58px"> <input id="hepatitis_given_on{{ $index }}" type="checkbox"
                        name="hepatitis_given_on[]" value="{{ $item }}"
                        @if (in_array($item, $tetanus_var)) checked @endif>
                    {{ ucfirst(str_replace('-', ' ', $item)) }}</label> &nbsp;
                &nbsp;
            @endforeach
        </div>
        <br>
        <div> <label class="label-head">Present Complaint(If Any) : </label><label style="padding-left: 20px">
                {{ $details->present_complaint }} </label>

        </div>
        <br>

        <div> <label class="label-head">Current Medication(If Any) : </label> <label style="padding-left: 20px">
                {{ $details->current_medication }} </label>

        </div>
        <br>


    </div>

</body>

</html>
