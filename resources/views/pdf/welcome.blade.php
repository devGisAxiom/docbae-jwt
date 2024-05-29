<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prescription</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }

        .logo {
            float: left;
        }

        .date {
            float: right;
        }

        .application-name {
            text-align: center;
        }

        .patient-info,
        .doctor-info {
            float: left;
            width: 50%;
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
    <div class="container">
        <div class="logo">
            <img src="assets/images/docbae.jpeg" width="30" alt="docbae" />
        </div>
        <div class="date">
            <p>Date:{{ Illuminate\Support\Carbon::now('Asia/Kolkata')->format('l, F j, Y h:i A') }}</p>
        </div>
        {{-- <div class="application-name">
            <h1>Docbae</h1>
        </div> --}}
        <br><br>
        <div class="patient-info">
            <h2>Patient Information:</h2>
            <p>Registration Id: {{ $unique_id }}</p>
            <p>Name: {{ $name }}</p>
            <p>Age: {{ $age }}</p>
            <p>Phone: {{ $phone }}</p>
        </div>
        <div class="doctor-info">
            <h2>Doctor Information:</h2>
            <p>Registration Id :{{ $doctor_id }}</p>
            <p>Name: {{ $first_name }} {{ $last_name }}</p>
            <p>Speciality: {{ $department_name }}</p>
            <p>Phone: {{ $mobile }}</p>
        </div>
        <div class="prescription-details">
            <h2>Prescription Details:</h2>
            @foreach ($notes as $item)
                <p>{{ $item }}</p>
            @endforeach
        </div>
    </div>
</body>

</html>
