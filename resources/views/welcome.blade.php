<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prescription Template</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-color: #f0f0f0;
        }

        .container {
            width: 100%;
            max-width: 800px;
            margin: 40px;
            /* padding: 20px; */
            background-color: #ffffff;
            box-shadow: 0 0 0 2px rgb(227, 220, 220);
            /* padding-left: 60px; */

            /* Simulating a border with a box shadow */
        }

        .header {
            text-align: LEFT;
            padding-left: 80px;
            padding-top: 20px;
            padding-bottom: 20px;
            border-bottom: 2px solid #f4e9e9;
            background-color: rgba(209, 203, 203, 0.845)
        }

        .header h1 {
            margin: 0;
            font-size: 24px;
        }

        .header p {
            margin: 5px 0;
            font-size: 14px;
        }

        table {
            width: 100%;
            /* border-collapse: collapse; */
        }


        td.divider {
            border-left: 1px solid black;
            padding-left: 20px
        }

        strong {
            font-size: 16px
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
        $age = $value->age;
        $unique_id = $value->unique_id;
    }

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
    <div class="container">
        <div class="header">
            <p style="font-size: 18px; font-weight:800"> {{ $first_name }} {{ $last_name }} </p>
            <p>MBBS </p>
            <p> {{ $certificate_number }}</p>
            <p>{{ $address }}</p>
            <p>{{ $mobile }} </p>
            <p> {{ $email }}</p>
        </div>

        <div>

            <p style="text-align:left; padding-left:80px;font-size:16px; font-weight:900">
                <strong> Date of consultation</strong>

                {{-- <span style="float:right;padding-right:230px">
                    <strong>Prescription Date</strong>
                </span> --}}
            </p>

            <p style="text-align:left;padding-left:80px;line-height: .1; font-size:14px">
                {{ $meeting_date }}
                {{-- <span style="float:right;padding-right:230px">
                    November 8, 2021
                </span> --}}
            </p>
        </div>

        <span style="line-height: 2">
            <div>
                {{-- <p style="text-align:left; padding-left:80px;font-weight:800">Patient Information</p> --}}
                <p style="text-align:left; padding-left:80px">
                    <strong>Name</strong>

                    <span style="float:right;padding-right:330px">
                        <strong>Age</strong>
                    </span>
                </p>

                <p style="text-align:left;padding-left:80px;line-height: .1; font-size:14px">
                    {{ $name }}
                    <span style="float:right;padding-right:340px;font-size:14px">
                        {{ $age }}
                    </span>
                </p>
            </div>
            <span style="line-height: 2">


                <div>
                    <p style="text-align:left; padding-left:80px">
                        <strong>Gender</strong>

                        <span style="float:right;padding-right:310px">
                            <strong>Height</strong>
                        </span>
                    </p>

                    <p style="text-align:left;padding-left:80px;line-height: .1;font-size:14px;">
                        {{ $check_gender }}
                        <span style="float:right;padding-right:333px;font-size:14px">
                            155
                        </span>
                    </p>
                </div>
                <span style="line-height: 2">

                    <div>
                        <p style="text-align:left; padding-left:80px">
                            <strong>Address</strong>

                            <span style="float:right;padding-right:305px">
                                <strong>Weight</strong>
                            </span>
                        </p>

                        <p style="text-align:left;padding-left:80px;line-height: .1;font-size:14px">
                            1372 Payne Street, Richlands, VA <br>

                            <span style="float:right;padding-right:325px;font-size:14px">
                                50kg
                            </span>
                        </p>
                    </div>
                    <span style="line-height: 2">

                        <div>
                            <p style="text-align:left; padding-left:80px;font-size:14px">
                                Poomala

                                <span style="float:right;padding-right:325px;">
                                    <strong>LMP</strong>
                                </span>
                            </p>

                            <p style="text-align:left;padding-left:100px;line-height: .1;">


                                <span style="float:right;padding-right:335px;font-size:14px">
                                    123
                                </span>
                            </p>
                        </div>
                        <hr style="margin:30px 40px 0 40px;">
                        {{-- <hr style="margin: 20px 0 0;"> --}}

                        <div style="padding:0px 20px 0px 60px;margin-top:0px">
                            <div style="margin: 0; padding: 0;">
                                <style>
                                    .left-column {
                                        border-right: 1px solid black;
                                        /* padding-left: 80px; */
                                    }

                                    .right-column {
                                        padding-right: 150px;
                                        padding-left: 20px
                                    }

                                    #prescription_head {
                                        line-height: 1;
                                        /* padding-left: 12px; */
                                        font-size: 12px;
                                        font-weight: 800;
                                    }

                                    #description {
                                        line-height: 1;
                                        /* padding-left: 10px; */
                                        font-size: 14px;
                                        font-family: Arial, sans-serif;
                                    }

                                    table {
                                        width: 100%;
                                    }

                                    td {
                                        vertical-align: top;
                                    }
                                </style>

                                <table>
                                    <tr>
                                        <td class="left-column">
                                            <strong id="prescription_head">CHIEF COMPLAINTS</strong>
                                            <div id="description">
                                                <p> {{ $chief_complaints }} </p>
                                            </div>
                                        </td>
                                        <td class="right-column">
                                            <strong id="prescription_head">DIAGNOSIS</strong>
                                            <div id="description">
                                                <p> {{ $diagnosis }} </p>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="left-column">
                                            <strong id="prescription_head">RELEVANT POINTS FROM HISTORY</strong>
                                            <div id="description">
                                                <p> {{ $points_from_history }} </p>
                                            </div>
                                        </td>
                                        <td class="right-column" rowspan="3">
                                            <strong id="prescription_head">PRESCRIPTIONS</strong>
                                            <div id="description">

                                                @foreach ($prescription as $item)
                                                    @php
                                                        $medicine_name = strtoupper($item->medicine_name);
                                                        $drug_form = $item->drug_form;
                                                        $strength = $item->strength;
                                                        $duration = $item->duration;

                                                    @endphp
                                                    <p>{{ $i++ }}. {{ $medicine_name }}</p>
                                                    <p>{{ $drug_form }}, {{ $strength }}, {{ $duration }}
                                                    </p>
                                                @endforeach

                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="left-column">
                                            <strong id="prescription_head">EXAMINATION / LAB FINDINGS</strong>
                                            <div id="description">
                                                <p> {{ $lab_findings }} </p>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="left-column">
                                            <strong id="prescription_head">SUGGESTED INVESTIGATIONS</strong>
                                            <div id="description">
                                                <p> {{ $investigations }} </p>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </div>

                            <hr style="margin:20px; margin-top:0">

                            <p style="padding-left: 16px;font-size:12px;font-weight:800;padding-bottom:80px">SPECIAL
                                INSTRUCTIONS</p>

                            <p> {{ $instructions }} </p>

                            <hr style="margin:20px; margin-top:0">



                        </div>



    </div>
</body>

</html>
