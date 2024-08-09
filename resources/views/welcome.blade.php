<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        div {
            position: relative;
            background-color: whitesmoke;
            width: 90%;
            max-width: 800px;
            height: 100%;
            margin: 20px auto;
            border: 1px solid #000;
            padding: 20px;
            box-sizing: border-box;
            line-height: 1
        }

        .header {
            font-size: 16px;
            font-weight: 700;
            text-align: left;
        }

        .header p {
            margin: 5px 0;
        }

        .date {
            position: absolute;
            top: 20px;
            right: 20px;
            font-size: 14px;
            font-weight: 600;
        }

        table,
        th,
        td {
            border: 1px solid black;
        }

        @media (max-width: 600px) {
            div {
                width: 100%;
                margin: 10px;
                padding: 15px;
                height: 100%;
            }

            .header {
                font-size: 14px;
            }

            .date {
                top: 10px;
                right: 10px;
                font-size: 12px;
            }

            table,
            th,
            td {
                border: 1px solid black;
            }

        }
    </style>
</head>


@php
    foreach ($doctor as $value) {
        $first_name = strtoupper($value->first_name);
        $last_name = strtoupper($value->last_name);
        $department_name = strtoupper($value->department_name);
        $address = strtoupper($value->address);
        $doctor_id = $value->id;
        $mobile = $value->mobile;
        $email = $value->email;
        $certificate_number = $value->mbbs_certificate_number;
    }

    foreach ($invitation as $value) {
        $date = $value->meeting_date;
    }

    $meeting_date = Carbon\Carbon::parse($date)->format('F j, Y');

    foreach ($patient as $value) {
        $phone = $value->mobile;
    }

    foreach ($member as $value) {
        $name = $value->name;
        $gender = $value->gender;
        $unique_id = $value->unique_id;
        $user_type = $value->user_type;
        $patient_id = $value->patient_id;
        $dob = Carbon\Carbon::parse($value->dob);
        $age = $dob->age;
    }

    $institute_name = App\Models\Patient::where('id', $patient_id)->pluck('name')->first();

    $check_gender = 0;

    if ($gender == 0) {
        $check_gender = 'female';
    } else {
        $check_gender = 'male';
    }

    foreach ($meeting_info as $value) {
        $chief_complaints = $value->chief_complaints;
        $diagnosis = $value->diagnosis;
        $points_from_history = $value->points_from_history;
        $lab_findings = $value->lab_findings;
        $investigations = $value->investigations;
        $instructions = $value->instructions;
        $meeting_info_id = $value->id;
    }

    $prescription = App\Models\MeetingPrescription::where('meeting_info_id', $meeting_info_id)->get();
    $i = 1;

@endphp

<body>
    <div>

        <img src="assets/images/docbae.jpeg" width="50" alt="docbae" style="align-content: center" />

        <p class="date">
            <?php echo date('Y-m-d'); ?>
        </p>
        <span class="header">
            <p>DR. {{ $first_name }} {{ $last_name }} </p>
            <p>{{ $department_name }}</p>
            <p>{{ $certificate_number }}</p>
            <p>{{ $address }}</p>
            <p>{{ $mobile }}</p>
        </span>
        <hr>

        <span>
            <p><b>Date of consultation :</b> {{ $meeting_date }}</p>
            @if ($user_type == 2)
                <p><b>Institution Name :</b> {{ $institute_name }}</p>
            @endif

            <p style="text-align:left;">
                <b> Patient Name :</b> {{ $name }}
                <span style="float:right; padding-right:70px">
                    <b> Age :</b> {{ $age }}
                </span>
            </p>

            <p style="text-align:left;">
                <b> Address :</b> Kakkanad House
                <span style="float:right; padding-right:20px">
                    <b> Height : </b>157cm
                </span>
            </p>

            <p style="text-align:left;">
                <b> Weight :</b> 55 kg
                <span style="float:right; padding-right:65px">
                    <b> Lmp : </b>15
                </span>
            </p>
        </span>
        <hr>
        <span>
            @if ($chief_complaints != null)
                <p>
                    <b>Chief Complaints </b>
                </p>
                <p>
                    {{ $chief_complaints }}
                </p>
            @endif

            @if ($diagnosis != null)
                <p>
                    <b>Diagnosis </b>
                </p>
                <p>
                    {{ $diagnosis }}
                </p>
            @endif
            @if ($points_from_history != null)
                <p style="text-align:left;">
                    <b>Relevant Points from history </b>
                </p>
                <p>
                    {{ $points_from_history }}
                </p>
            @endif

            @if ($lab_findings != null)
                <p style="text-align:left;">
                    <b>Lab findings </b>
                </p>
                <p>
                    {{ $lab_findings }}
                </p>
            @endif

            @if ($investigations != null)
                <p style="text-align:left;">
                    <b>Suggested Investigation </b>
                </p>
                <p>
                    {{ $investigations }}
                </p>
            @endif


            <hr>

            <p> <b>MEDICINE DETAILS</b> </p>

            <table style="width:100%">
                <tr>
                    <th>Medicine</th>
                    <th>Drug Form</th>
                    <th>Strength</th>
                    <th>Duration</th>
                </tr>
                @foreach ($prescription as $item)
                    <tr>
                        <td>{{ $item->medicine_name }}</td>
                        <td>{{ $item->drug_form }}</td>
                        <td>{{ $item->strength }}</td>
                        <td>{{ $item->duration }}</td>
                    </tr>
                @endforeach

                <tr>

                </tr>
            </table>
            @if ($instructions != null)
                <p style="text-align:left;">
                    <b>Special Instructions </b>
                </p>
                <p>
                    {{ $instructions }}
                </p>
            @endif
        </span>
    </div>
</body>

</html>
