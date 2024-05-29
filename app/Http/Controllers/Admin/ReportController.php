<?php

namespace App\Http\Controllers\Admin;

use App\Models\Grade;
use App\Models\Doctor;
use App\Models\Invitation;
use Illuminate\Http\Request;
use App\Models\DoctorPayment;
use App\Models\PaymentHistory;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;

class ReportController extends Controller
{
    public function AppointmentReport(Request $request)
    {

        $today        = Carbon::now()->format('Y:m:d');;
        $start_date   = $request->start_date;
        $end_date     = $request->end_date;
        $doctor_id    = $request->doctor_id;

        if($start_date != null && $end_date != null){

            if($doctor_id != null){

                $appointments  = Invitation::with('patient','members','doctor')->where('doctor_id',$doctor_id)->whereDate('meeting_date', '>=', $start_date)->whereDate('meeting_date', '<=', $end_date)->where('fund_released',0)->where('status',2)->get();

            } else {

                $appointments  = Invitation::with('patient','members','doctor')->whereDate('meeting_date', '>=', $start_date)->whereDate('meeting_date', '<=', $end_date)->where('fund_released',0)->where('status',2)->get();

            }

        }else if($start_date != null ){

            if($doctor_id != null){

                $appointments  = Invitation::with('patient','members','doctor')->where('doctor_id',$doctor_id)->whereDate('meeting_date', '=', $start_date)->where('fund_released',0)->where('status',2)->get();
            } else {

                $appointments  = Invitation::with('patient','members','doctor')->whereDate('meeting_date', '=', $start_date)->where('status',2)->where('fund_released',0)->get();
            }

        } else {
            if($doctor_id != null){

                 $appointments  = Invitation::with('patient','members','doctor')->where('doctor_id',$doctor_id)->where('fund_released',0)->where('status',2)->get();

            } else {
                $appointments  = Invitation::with('patient','members','doctor')->where('fund_released',0)->where('status',2)->get();
            }
        }

        $doctors = Doctor::where('status','<>',2)->where('is_verified',1)->OrderBy('id','desc')->get();

        return view('reports.appointment_report', compact('appointments','doctors'));
    }

    public function PaymentReport()
    {
        $doctor_payments  = DoctorPayment::with('doctor')->orderBy('id','desc')->get();

        return view('reports.payment_report', compact('doctor_payments'));
    }

    public function PaymentRelease(Request $request)
    {
        $appointments  = Invitation::where('status',2)->where('fund_released',0)->pluck('id');
        $doctors       = Invitation::where('fund_released', 0)->where('status', 2)->get()->unique('doctor_id');

        foreach ($doctors as $doctor){

            $consultation_fee = Invitation::where('doctor_id', $doctor->doctor_id)->where('fund_released', 0)->where('status', 2)->select('doctor_id', 'doctors_fee')->get();

                $doctors_fee = 0;
                foreach ($consultation_fee as $value) {
                    $doctors_fee += $value->doctors_fee;
                }

            DoctorPayment::insert([

                'doctor_id'    => $doctor->doctor_id,
                'total_amount' => $doctors_fee,
                'date'         => Carbon::now('Asia/Kolkata'),
            ]);

        }

        foreach($appointments as $item){

            PaymentHistory::insert([

                'invitation_id' => $item,
                'date'          => Carbon::now('Asia/Kolkata'),

            ]);

            Invitation::findOrFail($item)->update([

                'fund_released'  => 1,
                'released_date'  => Carbon::now('Asia/Kolkata'),

            ]);

        }

        return redirect()->back();

    }

    public function AppointmentHistory(Request $request)
    {
        $today        = Carbon::now()->format('Y:m:d');;
        $start_date   = $request->start_date;
        $end_date     = $request->end_date;
        $doctor_id    = $request->doctor_id;

        if($start_date != null && $end_date != null){

            if($doctor_id != null){

                $appointments  = Invitation::with('patient','members','doctor')->where('doctor_id',$doctor_id)->whereDate('meeting_date', '>=', $start_date)->whereDate('meeting_date', '<=', $end_date)->where('fund_released',1)->where('status',2)->get();

            } else {

                $appointments  = Invitation::with('patient','members','doctor')->whereDate('meeting_date', '>=', $start_date)->whereDate('meeting_date', '<=', $end_date)->where('fund_released',1)->where('status',2)->get();

            }

        }else if($start_date != null ){

            if($doctor_id != null){

                $appointments  = Invitation::with('patient','members','doctor')->where('doctor_id',$doctor_id)->whereDate('meeting_date', '=', $start_date)->where('fund_released',1)->where('status',2)->get();
            } else {

                $appointments  = Invitation::with('patient','members','doctor')->whereDate('meeting_date', '=', $start_date)->where('status',2)->where('fund_released',1)->get();
            }

        } else {
            if($doctor_id != null){

                 $appointments  = Invitation::with('patient','members','doctor')->where('doctor_id',$doctor_id)->where('fund_released',1)->where('status',2)->get();

            } else {
                $appointments  = Invitation::with('patient','members','doctor')->where('fund_released',1)->where('status',2)->get();
            }
        }

        $doctors = Doctor::where('status','<>',2)->where('is_verified',1)->OrderBy('id','desc')->get();

        return view('reports.appointment_history', compact('appointments','doctors'));

    }

    public function IntitutesAppointmentReport(Request $request)
    {
        $user         = session()->get('user');
        $user_id      = $user->id;
        $today        = Carbon::now()->format('Y:m:d');;
        $start_date   = $request->start_date;
        $end_date     = $request->end_date;
        $doctor_id    = $request->doctor_id;
        $grade_id     = $request->grade_id;

        $doctors = Doctor::where('status','<>',2)->where('is_verified',1)->OrderBy('id','desc')->get();
        $grades  = Grade::get();

        if($start_date != null && $end_date != null){

            if($doctor_id != null){

                $appointments  = Invitation::with('patient','members','doctor')->where('user_type',2)->where('patient_id',$user_id)->where('doctor_id',$doctor_id)->whereDate('meeting_date', '>=', $start_date)->whereDate('meeting_date', '<=', $end_date)->where('status',2)->get();

            } else {

                $appointments  = Invitation::with('patient','members','doctor')->where('user_type',2)->where('patient_id',$user_id)->whereDate('meeting_date', '>=', $start_date)->whereDate('meeting_date', '<=', $end_date)->where('status',2)->get();

            }

        }else if($start_date != null ){

            if($doctor_id != null){

                $appointments  = Invitation::with('patient','members','doctor')->where('user_type',2)->where('patient_id',$user_id)->where('doctor_id',$doctor_id)->whereDate('meeting_date', '=', $start_date)->where('status',2)->get();
            } else {

                $appointments  = Invitation::with('patient','members','doctor')->where('user_type',2)->where('patient_id',$user_id)->whereDate('meeting_date', '=', $start_date)->where('status',2)->get();
            }

        } else {

                $appointments  = Invitation::with('patient','members','doctor')->where('user_type',2)->where('patient_id',$user_id)->where('status',2)->get();
        }

        return view('reports.institutes_appointment_report',compact('appointments','doctors','grades'));
    }
}
