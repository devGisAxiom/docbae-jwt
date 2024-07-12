<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<style>
    body {
        background-color: black;
        font-family: Arial, Helvetica, sans-serif;
    }

    .center {
        display: block;
        margin-left: auto;
        margin-right: auto;
        padding: 80px;
    }

    .container {
        position: relative;
        text-align: center;
        color: white;
    }

    .top-left {
        position: absolute;
        top: 26%;
        left: 48%;
        border-bottom: 2px solid skyblue;
        padding-bottom: 2px;
        /* Adjust the padding to increase space */
    }

    p {
        position: absolute;
        top: 40%;
        left: 35%;
        color: black
    }

    .top-right {
        position: absolute;
        right: 16px;
    }

    .bottom-right {
        position: absolute;
        bottom: 18%;
        right: 37%;
    }

    .profile-pic {
        position: absolute;
        top: 19%;
        left: 35%;
    }

    .btn {
        position: absolute;
        top: 2%;
        right: 20%;
        color: white;
        background: skyblue;
        width: 100px;
        height: 30px;
        border: 2px solid skyblue;
    }
</style>

<body>

    @php
        $qrcode = App\Models\HealthCardDetails::where('student_id', $student->id)
            ->pluck('qrcode')
            ->first();
    @endphp
    <div class="container">

        <a href="{{ route('download-health-card', ['id' => $student->id]) }}">
            <button type="button" class="btn" type="submit"> Download<i class="fa fa-download"
                    aria-hidden="true"></i></button>
        </a>
        <div class="profile-pic">
            <img src="{{ asset('Images/Institution/Student/' . $student->image) }}" style="width: 70px; height: 70px">
        </div>
        <img src="{{ asset('Images/health-card/Health_card_Front.jpg') }}" alt="Trulli" width="500" height="333"
            class="center">

        <div class="top-left">Health Card</div>
        <div>
            <p style="top: 38%;">Institution <span style="padding-left: 20px">:</span>&nbsp;
                {{ $student->patient->name }}
            </p>
            <p style="top: 44%;">Name <span style="padding-left: 45px">:</span>&nbsp; {{ $student->name }} </p>
            <p style="top: 50%;">Age <span style="padding-left: 59px">:</span>&nbsp; {{ $student->age }} </p>
            <p style="top: 56%;">Card No <span style="padding-left: 27px">:</span>&nbsp; {{ $student->unique_id }} </p>
            <p style="top: 62%;">Validity <span style="padding-left: 37px">:</span>&nbsp; 10-12-2024 </p>
        </div>

        <div class="bottom-right">
            <img src="{{ asset('http://127.0.0.1:5500/storage/app/public/qr-codes/' . $qrcode) }}"
                style="width: 50px; height:50px">
        </div>
        {{-- <div class="centered">Centered</div>  --}}
    </div>

</body>

</html>
