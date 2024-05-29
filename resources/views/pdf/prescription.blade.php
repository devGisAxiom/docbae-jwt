<!DOCTYPE html>
<html lang="en">

<head>
    <title>Docbae - prescription</title>
    <style>
        .doctor {
            background-color: white;
            width: auto;
            margin: auto;
            text-align: center;
        }

        div {
            background-color: white;
            width: auto;
            margin: auto;
            padding-top: 10px;
        }

        .dots {
            display: inline-block;
            border-bottom: 1px dotted black;
            width: 400px;
            /* Adjust the width as needed */
            vertical-align: middle;
            padding-left: 10px;

        }
    </style>
</head>

@php
    foreach ($doctor as $value) {
        $first_name = $value->first_name;
        $last_name = $value->last_name;
        $department_name = $value->department_name;
        $doctor_id = $value->id;
        $mobile = $value->mobile;
    }

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
        $check_gender = 'F';
    } else {
        $check_gender = 'M';
    }

@endphp

<body>
    <div>
        <div class="doctor">
            <img src="assets/images/docbae.jpeg" width="50" alt="docbae" />
            <p><b>Dr.{{ $first_name }} {{ $last_name }} </b></p>
            <p style="color: green;"><b>{{ strtoupper($department_name) }}</b></p>
            <p>Phone: {{ $mobile }}</p>
            <hr>
        </div>

        <p style="padding-left: 150px;">Patient Id <span style="padding-left:42px;">:</span> <span
                class="dots">{{ $unique_id }}</span>
        </p>
        <p style="padding-left: 150px;">Name<span style="padding-left:70px;">:</span> <span
                class="dots">{{ $name }}</span></p>
        {{-- <p style="padding-left: 150px;">Address<span style="padding-left:55px;">:</span> <span
                class="dots">Anjilimoottil House</span>
        </p> --}}
        <p style="padding-left: 150px;">Age<span style="padding-left:80px;">:</span><span class="dots">
                {{ $age }}</span></p>
        <p style="padding-left: 150px;">Phone<span style="padding-left:68px;">:</span> <span
                class="dots">{{ $phone }}</span></p>

        <br>

        <h3 style="padding-left: 150px;">PRESCRIPTION</h3>

        <ul style="padding-left: 160px;padding-right: 80px;">
            @foreach ($notes as $item)
                <li>{{ $item }}</li>
            @endforeach

        </ul>
        <br><br><br>

        <p style="text-align:left;padding-left: 100px;">
            {{ Illuminate\Support\Carbon::now('Asia/Kolkata')->format('l, F j, Y') }}
            <span style="float:right;padding-right: 100px;">
                {{ Illuminate\Support\Carbon::now('Asia/Kolkata')->format('h:i A') }}
            </span>
        </p>
        <br><br><br>

    </div>
</body>

</html>
