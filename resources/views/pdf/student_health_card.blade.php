<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>School Health Card</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .container {
            border: 1px solid #000;
            padding: 30px;
            max-width: 800px;
            margin: auto;
            box-sizing: border-box;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header img {
            max-height: 50px;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
            margin-bottom: 10px;
        }

        .info-left {
            width: 48%;
        }

        .info-center {
            width: 40%;
            text-align: left;
        }

        .label-head {
            font-weight: 600;
        }

        @media (max-width: 600px) {
            .container {
                padding: 20px 10px 20px 20px;
            }

            .info-left,
            .info-center {
                width: 100%;
                text-align: left;
            }
        }
    </style>
</head>

<body>
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

    <div class="container">
        <div class="header">
            <img src="assets/images/docbae.jpeg" width="50" alt="docbae" />
            <h1>SCHOOL HEALTH CARD</h1>
        </div>

        <div class="info-row">
            <div class="info-left">
                <label><b>Name:</b> {{ $student->name }}</label>
            </div>
            <div class="info-center">
                <label><b>Age:</b> {{ $student->age }}</label>
            </div>
        </div>

        <div class="info-row">
            <div class="info-left">
                <label><b>DOB:</b> {{ $student->dob }}</label>
            </div>
            <div class="info-center">
                <label><b>Class:</b> {{ $grade }}</label>
            </div>
        </div>

        <div class="info-row">
            <div class="info-left">
                <label><b>Blood Group:</b> {{ $blood_group }}</label>
            </div>
            <div class="info-center">
                <label><b>Gender:</b> {{ $check_gender }}</label>
            </div>
        </div>

        <div class="info-row">
            <div class="info-left">
                <label><b>Father:</b> {{ $details->fathers_name }}</label>
            </div>
            <div class="info-center">
                <label><b>Occupation:</b> {{ $details->fathers_occupation }}</label>
            </div>
        </div>

        <div class="info-row">
            <div class="info-left">
                <label><b>Mother:</b> {{ $details->mothers_name }}</label>
            </div>
            <div class="info-center">
                <label><b>Occupation:</b> {{ $details->mothers_occupation }}</label>
            </div>
        </div>

        <div class="info-row">
            <div class="info-left">
                <label><b>Mobile 1:</b> {{ $student->mobile }}</label>
            </div>
            <div class="info-center">
                <label><b>Mobile 2:</b> {{ $details->additional_mobile }}</label>
            </div>
        </div>

        <div class="info-row">
            <div class="info-left">
                <label><b>Pincode:</b> {{ $details->pincode }}</label>
            </div>
            <div class="info-center">
                <label><b>Email:</b> {{ $details->email }}</label>
            </div>
        </div>

        <br><br>

        <div>
            <label class="label-head">Name and address of family physician:</label>
            <label style="padding-left: 10px"> {{ $details->family_physician_details }}</label>
        </div>
        <br>
        <div>
            <label class="label-head">Physician Phone:</label>
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
