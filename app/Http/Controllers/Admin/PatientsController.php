<?php

namespace App\Http\Controllers\Admin;

use App\Models\Patient;
use App\Models\Invitation;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;

class PatientsController extends Controller
{
    public function Patients()
    {
        $patients = Patient::where('user_type', 1)->where('status','<>',2)->get();

        return view('patients.all_patients', compact('patients'));
    }

    public function ViewPatients(Request $request)
    {
        $id = $request->id;

        $patient = Patient::findOrFail($id);

        $appointment     = Invitation::with('patient','members','doctor')->where('patient_id',$id)->where('status',2)->orderBy('id','desc')->get();
        $family_members  = Member::with('blood_group','member')->where('patient_id', $id)->where('status',1)->get();

        return view('patients.view_patient', compact('patient','appointment','family_members'));

    }

    public function Appointments(Request $request)
    {
        $user      = session()->get('user');
        $user_id   = $user->id;
        $user_type = $user->user_type;


        $today        = Carbon::now()->format('Y:m:d');;
        $start_date   = $request->start_date;
        $end_date     = $request->end_date;


        if($start_date != null && $end_date != null){

            $appointments  = Invitation::with('patient','members','doctor')->whereDate('meeting_date', '>=', $start_date)->whereDate('meeting_date', '<=', $end_date)->where('status',0)->where('emergency_call',0)->limit(4)->get();

            if($user_type == 2){

                $appointments  = Invitation::with('patient','doctor','members')->where('patient_id',$user_id)->whereDate('meeting_date', '>=', $start_date)->whereDate('meeting_date', '<=', $end_date)->where('emergency_call',0)->where('status',0)->get();
            }

        }else if($start_date != null ){

            $appointments  = Invitation::with('patient','members','doctor')->whereDate('meeting_date', '=', $start_date)->where('emergency_call',0)->where('status',0)->get();

            if($user_type == 2){

                $appointments  = Invitation::with('patient','doctor','members')->where('patient_id',$user_id)->whereDate('meeting_date', '=', $start_date)->where('emergency_call',0)->where('status',0)->get();

            }

        } else {

            $appointments  = Invitation::with('patient','members','doctor')->where('emergency_call',0)->where('status',0)->get();

            if($user_type == 2){

                $appointments  = Invitation::with('patient','doctor','members')->where('patient_id',$user_id)->where('emergency_call',0)->where('status',0)->get();
            }

        }

        return view('appointments.appointment_list', compact('appointments'));
    }

    public function ViewAppointments(Request $request)
    {
        $id = $request->id;
        $appointment = Invitation::with('patient','members','doctor')->findOrFail($id);

        return view('appointments.view_appointment', compact('appointment'));
    }

    public function EmergencyCall(Request $request)
    {

        $user      = session()->get('user');
        $user_id   = $user->id;
        $user_type = $user->user_type;


        $today        = Carbon::now()->format('Y:m:d');;
        $start_date   = $request->start_date;
        $end_date     = $request->end_date;


        if($start_date != null && $end_date != null){

            $appointments  = Invitation::with('patient','members','doctor')->whereDate('meeting_date', '>=', $start_date)->whereDate('meeting_date', '<=', $end_date)->where('doctor_id','<>',0)->where('status',2)->where('emergency_call',1)->get();

            if($user_type == 2){

                $appointments  = Invitation::with('patient','doctor','members')->where('patient_id',$user_id)->whereDate('meeting_date', '>=', $start_date)->whereDate('meeting_date', '<=', $end_date)->where('doctor_id','<>',0)->where('emergency_call',1)->where('status',2)->get();
            }

        }else if($start_date != null ){

            $appointments  = Invitation::with('patient','members','doctor')->whereDate('meeting_date', '=', $start_date)->where('doctor_id','<>',0)->where('emergency_call',1)->where('status',2)->get();

            if($user_type == 2){

                $appointments  = Invitation::with('patient','doctor','members')->where('patient_id',$user_id)->whereDate('meeting_date', '=', $start_date)->where('doctor_id','<>',0)->where('emergency_call',1)->where('status',2)->get();

            }

        } else {

            $appointments  = Invitation::with('patient','doctor','members')->where('doctor_id','<>',0)->where('emergency_call',1)->where('status',2)->get();

            if($user_type == 2){

                $appointments  = Invitation::with('patient','doctor','members')->where('patient_id',$user_id)->where('doctor_id','<>',0)->where('emergency_call',1)->where('status',2)->get();
            }
        }

        return view('appointments.emergency_call', compact('appointments'));
    }


}
