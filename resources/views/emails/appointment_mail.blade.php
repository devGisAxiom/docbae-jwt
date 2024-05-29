<!DOCTYPE html>
<html>

@php
    $invitation = App\Models\Invitation::where('id', $invitation_id)->get();

    foreach ($invitation as $value) {
        $doctor_id = $value->doctor_id;
        $patient_id = $value->patient_id;
        $member_id = $value->member_id;
        $meeting_date = $value->meeting_date;
        $meeting_time = $value->meeting_time;
    }

    $doctor_first_name = App\Models\Doctor::where('id', $doctor_id)->pluck('first_name')->first();
    $doctor_last_name = App\Models\Doctor::where('id', $doctor_id)->pluck('last_name')->first();
    $patient_name = App\Models\Patient::where('id', $patient_id)->pluck('name')->first();
    $member_name = App\Models\Member::where('id', $member_id)->pluck('name')->first();
    $doctor_name = $doctor_first_name . '' . $doctor_last_name;

@endphp


<body>
    <p>Dear {{ $doctor_name }},
    <p>
    <p> You have a new appointment.</p>

    <b>APPOINTMENT DETAILS</b>

    <p>User : {{ $patient_name }} </p>
    <p>Patient Name: {{ $member_name }} </p>
    <p>meeting Date: {{ $meeting_date }} </p>
    <p>meeting Time: {{ $meeting_time }} </p>


    <p>Thank you for your dedication to patient care.</p>

</body>

</html>
