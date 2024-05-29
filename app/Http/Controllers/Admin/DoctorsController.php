<?php

namespace App\Http\Controllers\Admin;

use App\Models\Doctor;
use App\Models\Speciality;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\DoctorSchedules;

class DoctorsController extends Controller
{
    public function Doctors()
    {
        $doctors = Doctor::where('status',1)->where('is_verified',1)->OrderBy('id','desc')->get();

        return view('doctors.all_doctors', compact('doctors'));
    }
    public function NewApplicants()
    {
        $doctors = Doctor::where('status','<>',2)->where('is_verified', 0)->OrderBy('id','desc')->get();

        return view('doctors.new_applicants', compact('doctors'));
    }

    public function DoctorScheduleList()
    {
        $schedules = DoctorSchedules::where('status','<>',2)->get();

        return view('doctors.schedule_list', compact('schedules'));
    }

    public function EditSchedule(Request $request)
    {
        $schedules = DoctorSchedules::findOrFail($request->id);

        return view('doctors.edit_schedule', compact('schedules'));
    }

    public function UpdateSchedule(Request $request, $id)
    {
        DoctorSchedules::findOrFail($id)->update([

            'day_of_week'    => $request->day_of_week,
            'available_time' => $request->available_time,
            'time_from'      => $request->time_from,
            'time_to'        => $request->time_to,
            'duration'       => $request->duration,

        ]);

        return redirect()->route('doctors.schedule_list');
    }

    public function DoctorProfile(Request $request)
    {
        $id      = $request->id;
        $doctor  = Doctor::findOrFail($id);

        $schedules = DoctorSchedules::where('doctor_id', $id)->where('status','<>',2)->get();

        return view('doctors.profile', compact('doctor','schedules'));
    }

    public function VerifyDoctor(Request $request)
    {
        $id = $request->id;

        Doctor::findOrFail($id)->update([

            'is_verified' => 1,
        ]);

        return redirect()->back();
    }

    public function RejectDoctor(Request $request)
    {
        $id = $request->id;

        Doctor::findOrFail($id)->update([

            'is_verified' => 2,
        ]);

        return redirect()->route('doctors.all');
    }

    public function DeleteDoctor(Request $request)
    {
        $id = $request->id;

        Doctor::findOrFail($id)->update([

            'status' => 0,
        ]);

        return redirect()->route('doctors.all');
    }

    public function UpdateFee(Request $request, $id)
    {
       $consultation_fee      =  $request->consultation_fee;
       $commission_percentage =  $request->commission_percentage;
       $percentage = ($consultation_fee * $commission_percentage)/100;

        Doctor::findOrFail($id)->update([

            'consultation_fee'      => $consultation_fee,
            'commission_percentage' => $commission_percentage,
            'commission_amount'     => $percentage,
        ]);

        return redirect()->back();
    }




}
