<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>School Health Card</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0px;
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
            flex-wrap: wrap;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .left,
        .right {
            width: 40%;
            box-sizing: border-box;
        }

        .section h2 {
            border-bottom: 1px solid #000;
            padding-bottom: 5px;
        }

        .section label {
            display: block;
            margin-bottom: 10px;
            font-size: 14px;
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

        @media (max-width: 600px) {
            body {
                font-family: Arial, sans-serif;
                /* margin: 10px; */
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
                flex-wrap: wrap;
                justify-content: space-between;
                margin-bottom: 20px;
            }

            .left,
            .right {
                width: 40%;
                box-sizing: border-box;
            }

            .section h2 {
                border-bottom: 1px solid #000;
                padding-bottom: 5px;
            }

            .section label {
                display: block;
                margin-bottom: 10px;
                font-size: 14px;
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
        }
    </style>
</head>

@php
    $check_gender = $student->gender == 0 ? 'F' : 'M';
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
            <img src="assets/images/docbae.jpeg" width="50" alt="docbae" />
            <h1>SCHOOL HEALTH CARD</h1>
        </div>

        <div class="section">
            <div class="left">
                <label><b>Name</b> <span style="padding-left: 60px"> {{ $student->name }} </span> </label>
                <label><b>DOB</b> <span style="padding-left: 90px"> {{ $student->dob }} </span></label>
                <label><b>Father's Name</b> <span style="padding-left: 24px"> {{ $details->fathers_name }}
                    </span></label>
                <label><b>Mother's Name</b> <span style="padding-left: 20px">{{ $details->mothers_name }}</span></label>
                <label><b>Mobile 1</b> <span style="padding-left: 65px">{{ $student->mobile }}</span></label>
                <label><b>Pincode</b> <span style="padding-left: 66px">{{ $details->pincode }}</span> </label>

            </div>
            <div class="right">
                <label><b>Age</b> <span style="padding-left: 20px">{{ $student->age }}</span>
                    <span style="font-weight:600; padding-left:22px">Sex</span> <span
                        style="padding-left:30px">{{ $check_gender }}</span></label>
                <label><b>Class</b> <span style="padding-left: 10px"> {{ $grade }} </span>
                    <span style="font-weight:600; padding-left:20px">Blood Group</span> <span
                        style="padding-left:12px">{{ $blood_group }}</span></label>
                <label><span style="font-weight: 600">Occupation</span> <span
                        style="padding-left: 10px">{{ $details->fathers_occupation }}</span> </label>
                <label><span style="font-weight: 600"> Occupation</span> <span
                        style="padding-left: 8px">{{ $details->mothers_occupation }}</span> </label>
                <label><b>Mobile 2</b> <span
                        style="padding-left: 30px">{{ $details->additional_mobile }}</span></label>
                <label><span style="font-weight: 600">Email</span> <span
                        style="padding-left: 10px">{{ $details->email }}</span></label>
            </div>
        </div>

        <div>
            <label class="label-head">Name and address of family physician:</label>
            <label style="padding-left: 10px"> {{ $details->family_physician_details }}</label>
        </div>
        <br>
        <div>
            <label class="label-head">physician Phone:</label>
            <label style="padding-left: 10px"> {{ $details->physician_phone }}</label>
        </div>

        <br>

        <div>
            <label class="label-head">Past History</label> &nbsp;
            @foreach ($histories as $index => $history)
                <label><input id="past_history{{ $index }}" type="checkbox" name="past_history[]"
                        value="{{ $history }}" @if (in_array($history, $history_var)) checked @endif>
                    {{ ucfirst(str_replace('-', ' ', $history)) }}</label> &nbsp;
            @endforeach
        </div>

        <div style="padding-top: 5px">
            <label class="label-head">Remarks:</label>
            <label style="padding-left: 30px"> {{ $details->remarks }}</label>
        </div>
        <br>

        <div>
            <label class="label-head">Any Major illness or operations in the past:</label>
            <label style="padding-left: 20px">{{ $details->past_medical_history }}</label>
        </div>
        <br>

        <div>
            <label class="label-head">Using any implant accessories:</label> &nbsp;
            @foreach ($implants as $index => $item)
                <label><input id="any_implant_accessories{{ $index }}" type="checkbox"
                        name="any_implant_accessories[]" value="{{ $item }}"
                        @if (in_array($item, $implants_var)) checked @endif>
                    {{ ucfirst(str_replace('-', ' ', $item)) }}</label> &nbsp;
            @endforeach
            <label><b>Rt or Lt:</b> {{ $details->rt_and_lt }}</label>
        </div>
        <p style="font-size: 16px; font-weight:800">Vaccination Status</p>

        <div>
            <label class="label-head">Hepatitis B given on:</label>
            @foreach ($hepatitis as $index => $item)
                <label style="padding-left: 48px"><input id="hepatitis_given_on{{ $index }}" type="checkbox"
                        name="hepatitis_given_on[]" value="{{ $item }}"
                        @if (in_array($item, $hepatitis_var)) checked @endif>
                    {{ ucfirst(str_replace('-', ' ', $item)) }}</label>
            @endforeach
        </div>
        <br>

        <div>
            <label class="label-head">Typhoid given on class:</label>
            @foreach ($typhoid_given_on as $index => $item)
                <label style="padding-left: 26px"><input id="typhoid_given_on{{ $index }}" type="checkbox"
                        name="typhoid_given_on[]" value="{{ $item }}"
                        @if (in_array($item, $typhoid_var)) checked @endif>
                    {{ ucfirst(str_replace('-', ' ', $item)) }}</label>
            @endforeach
        </div>
        <br>

        <div>
            <label class="label-head">D.T. & Polio Booster given:</label>
            <label style="padding-left: 2px"><input type="checkbox"> Yes</label>
            <label><input type="checkbox"> No</label>
        </div>
        <br>

        <div>
            <label class="label-head">Tetanus given on:</label>
            @foreach ($tetanus_given_on as $index => $item)
                <label style="padding-left: 70px"><input id="tetanus_given_on{{ $index }}" type="checkbox"
                        name="tetanus_given_on[]" value="{{ $item }}"
                        @if (in_array($item, $tetanus_var)) checked @endif>
                    {{ ucfirst(str_replace('-', ' ', $item)) }}</label>
            @endforeach
        </div>
        <br>

        <div>
            <label class="label-head">Present Complaint (If Any):</label>
            <label style="padding-left: 20px"> {{ $details->present_complaint }} </label>
        </div>
        <br>

        <div>
            <label class="label-head">Current Medication (If Any):</label>
            <label style="padding-left: 20px"> {{ $details->current_medication }} </label>
        </div>
        <br>
    </div>

</body>

</html>
