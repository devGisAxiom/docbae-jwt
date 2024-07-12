<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<style>
    body {
        background-color: black;
        font-family: Arial, Helvetica, sans-serif;
    }

    .bottom-right {
        position: absolute;
        bottom: 62%;
        right: 25%;
    }

    .profile-pic {
        position: absolute;
        top: 9%;
        left: 17%;
    }
</style>

<body>

    <div class="container" style=" display: block; margin-left: auto; margin-right: auto; padding: 80px;">


        <img src="{{ $image_path }}" width="500" height="333" class="center"
            style=" position: absolute; text-align: center; color: white;">

        <div class="profile-pic">
            <img src="{{ $profile_pic }}" style="width: 70px; height: 70px">
        </div>
        <div style=" position: absolute;top:13%;color:white;right:45%;border-bottom: 2px solid skyblue;">Health Card
        </div>

        <p style="position: absolute; color:black; top: 20%; left:15%">Institution <span
                style="padding-left: 10px">:</span>&nbsp; {{ $student->patient->name }}</p>
        <p style="position: absolute; color:black; top: 22%; left:15%">Name <span
                style="padding-left: 35px">:</span>&nbsp; {{ $student->name }}</p>
        <p style="position: absolute; color:black; top: 24%; left:15%">Age <span
                style="padding-left: 49px">:</span>&nbsp; {{ $student->age }}</p>
        <p style="position: absolute; color:black; top: 26%; left:15%">Card No <span
                style="padding-left: 17px">:</span>&nbsp; {{ $student->unique_id }}</p>
        <p style="position: absolute; color:black; top: 28%; left:15%">Validity <span
                style="padding-left: 24px">:</span>&nbsp; 1234</p>



        <div class="bottom-right">
            <img src="{{ $qr_code }}" style="width: 50px; height:50px;">
        </div>
    </div>

</body>

</html>
