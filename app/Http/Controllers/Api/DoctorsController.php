<?php

namespace App\Http\Controllers\Api;

use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Invitation;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\DoctorSchedules;
use App\Models\DoctorOtpHistory;
use App\Http\Controllers\Controller;
use App\Models\ReassignedInvitation;

class DoctorsController extends Controller
{
    public function CheckPhone(Request $request)
    {
        $mobile = $request->input("mobile");

        if ($mobile != null) {

            $user   = Doctor::where('mobile', $mobile)->where('is_deleted', '<>', 1)->exists();

            if ($user == 0) {

                return response()->json(['user_exists' => 'false']);
            } else {

                $user_id      = Doctor::where('mobile', $mobile)->pluck('id')->first();
                // $doctor       = Doctor::where('id', $user_id)->first();

                $otp          = new DoctorOtpHistory();
                $otp->user_id = $user_id;
                $otp->otp     = random_int(1000, 9999);
                $otp->save();

                return response()->json(['user_exists' => 'true', 'otp' => $otp]);
            }
        } else {

            return response()->json(['response' => 'failed', 'message' => "please enter phone number"]);
        }
    }

    public function DoctorLogin(Request $request)
    {
        $otp      = $request->input("otp");
        $user_otp = DoctorOtpHistory::where('otp', $otp)->where('is_used', '<>', 1)->exists();

        if ($otp != null) {

            if ($user_otp == 1) {

                $user_id    = DoctorOtpHistory::where('otp', $otp)->pluck('user_id')->first();
                $doctor_id  = Doctor::where('id', $user_id)->where('is_deleted', '<>', 1)->exists();
                $id         = DoctorOtpHistory::where('otp', $otp)->pluck('id')->first();

                if ($doctor_id == 1) {

                    $user   = Doctor::where('id', $user_id)->where('is_deleted', '<>', 1)->get();

                    DoctorOtpHistory::findOrFail($id)->update([

                        'is_used'  => 1,

                    ]);

                    return response()->json(['User Login' => 'success', 'user_id' => $user_id]);
                }
            } else {

                return response()->json(['response' => 'failed', 'message' => "check your otp"]);
            }
        } else {

            return response()->json(['response' => 'failed', 'message' => "please enter otp"]);
        }
    }

    public function DoctorRegister(Request $request)
    {

        if ($request->first_name != null && $request->last_name != null && $request->mobile != null) {

            $mobile = Doctor::where('mobile', $request->mobile)->where('is_deleted', '<>', 1)->exists();

            if ($mobile == 0) {

                if ($request->file('image') != null) {
                    $file       = $request->file('image');
                    $filename   = $file->getClientOriginalName();
                    $request->image->move(public_path('Images/Doctor'), $filename);
                    $path       = "public/Images/Doctor/$filename";
                } else {
                    $filename = "";
                }

                $doctor             = new Doctor();
                $doctor->first_name = $request->first_name;
                $doctor->last_name  = $request->last_name;
                $doctor->email      = $request->email ?? "";
                $doctor->mobile     = $request->mobile;
                $doctor->image      = $filename;
                $doctor->save();

                $otp          = new DoctorOtpHistory();
                $otp->user_id = $doctor->id;
                $otp->otp     = random_int(1000, 9999);
                $otp->save();

                return response()->json(['user_created' => 'true', 'otp' => $otp]);
            } else {

                return response()->json(['response' => 'failed', 'message' => "number exists"]);
                //  return response()->json(['number_exists' => 'true']);

            }
        } else {

            return response()->json(['response' => 'failed', 'message' => "please enter the details"]);
        }
    }

    public function UpdateDoctorInfo(Request $request)
    {
        if ($request->id != null) {

            $user   = Doctor::where('id', $request->id)->where('is_deleted', '<>', 1)->exists();
            $mobile = Doctor::where('id', '<>', $request->id)->where('mobile', $request->mobile)->where('is_deleted', '<>', 1)->exists();

            if ($mobile == 0) {

                if ($user == 1) {

                    $doctor     =  Doctor::findOrFail($request->id);
                    $first_name = $doctor->first_name;
                    $last_name  = $doctor->last_name;
                    $email      = $doctor->email;
                    $image      = $doctor->image;
                    $mobile     = $doctor->mobile;

                    if (request()->hasFile('image') && request('image') != '') {

                        $imagePath = public_path('Images/Doctor/' . $doctor->image);

                        if ($doctor->image != null) {
                            unlink($imagePath);
                        }

                        $file       = $request->file('image');
                        $filename   = $file->getClientOriginalName();
                        $request->image->move(public_path('Images/Doctor'), $filename);
                        $path       = "public/Images/Doctor/$filename";
                    }

                    Doctor::findOrFail($request->id)->update([

                        'first_name'  => $request->first_name ?? $first_name,
                        'last_name'   => $request->last_name ?? $last_name,
                        'email'       => $request->email ?? $email,
                        'mobile'      => $request->mobile ?? $mobile,
                        'image'       => $filename ?? $image,

                    ]);

                    $updated_info = Doctor::findOrFail($request->id);

                    return response()->json(['response' => 'success', 'user' => $updated_info]);
                } else {

                    return response()->json(['user_exists' => 'false']);
                }
            } else {

                return response()->json(['response' => 'failed', 'message' => "phone number exists"]);
            }
        } else {

            return response()->json(['response' => 'failed', 'message' => "please enter the details"]);
        }
    }

    public function ViewDoctorsProfile(Request $request)
    {
        if ($request->id != null) {

            $user = Doctor::where('id', $request->id)->where('is_deleted', '<>', 1)->exists();
            if ($user == 1) {

                $doctor     =  Doctor::findOrFail($request->id);
                return response()->json(['user_view' => 'true', 'user' => $doctor]);
            } else {

                return response()->json(['user_exists' => 'false']);
            }
        } else {

            return response()->json(['response' => 'failed', 'message' => "please enter id"]);
        }
    }

    public function GetAllDoctors(Request $request)
    {
        $doctors = Doctor::where('is_deleted', '<>', 1)->get();

        if ($doctors != null) {

            return response()->json(['response' => 'success', 'doctors' => $doctors]);
        } else {

            return response()->json(['response' => 'failed', 'doctors' => []]);
        }
    }

    public function SearchDoctor(Request $request)
    {
        // $doctor_id     = $request->input("doctor_id");
        $search_text   = $request->input("search_text");

        if ($search_text) {

            $result = Doctor::where('is_deleted', '<>', 1)
                // ->where('id', $doctor_id)
                ->where('first_name', 'like', '%' . $search_text . '%')
                ->orWhere('last_name', 'like', '%' . $search_text . '%')
                ->orWhere('mobile', 'like', '%' . $search_text . '%')
                ->get();

            if (!$result->isEmpty()) {
                return response()->json(['response' => 'success', 'result' => $result]);
            } else {

                return response()->json(['response' => 'failed']);
            }
        } else {

            return response()->json(['response' => 'failed', 'message' => "please enter text"]);
        }
    }

    public function UpdateDoctorSchedule(Request $request)
    {

        // $schedulesARR = [[
        //     'day_of_week' => 2,
        //     'time_from' => 10,
        //     'time_to' => 11

        // ]
        // ];
        $doctor_id    = $request->doctor_id;
        $schedule_id  = $request->schedule_id;
        $doctor       = Doctor::where('id', $doctor_id)->where('is_deleted', '<>', 1)->exists();

        if ($doctor == 1) {

            $schedulesARR = $request->schedules;

            if ($schedule_id == null) {

                // insert doctor schedule

                foreach ($schedulesARR as $schedules) {
                    if ($schedules['day_of_week'] != 0  && $schedules['time_from'] != 0 && $schedules['time_to'] != 0) {

                        $doctor_schedules =  DoctorSchedules::insert([

                            'doctor_id'      => $doctor_id,
                            'day_of_week'    => $schedules['day_of_week'],
                            'time_from'      => $schedules['time_from'],
                            'time_to'        => $schedules['time_to'],

                        ]);
                    }

                    // return response()->json(['response' => 'success']);
                    // } else {

                    //     return response()->json(['response' => 'failed']);
                }
                return response()->json(['response' => 'success']);
            } else {

                // update doctor schedule
                foreach ($schedulesARR as $schedules) {
                    if ($schedules['day_of_week'] != 0  && $schedules['time_from'] != 0 && $schedules['time_to'] != 0) {

                        DoctorSchedules::findOrFail($schedule_id)->update([

                            'doctor_id'      => $doctor_id,
                            'day_of_week'    => $schedules['day_of_week'],
                            'time_from'      => $schedules['time_from'],
                            'time_to'        => $schedules['time_to'],


                        ]);

                        return response()->json(['response' => 'success']);
                    } else {

                        return response()->json(['response' => 'failed']);
                    }
                }
            }
        } else {

            return response()->json(['user_exists' => 'false']);
        }
    }

    public function GetDoctorScheduleDetails(Request $request)
    {
        $doctor_id       = $request->doctor_id;
        $DoctorSchedules = DoctorSchedules::where('doctor_id', $doctor_id)->where('is_deleted', '<>', 1)->exists();

        if ($doctor_id != null) {
            if ($DoctorSchedules == 1) {

                $DoctorSchedules = DoctorSchedules::where('doctor_id', $doctor_id)->select('id', 'doctor_id', 'day_of_week', 'time_from', 'time_to')->where('is_deleted', '<>', 1)->get();

                return response()->json(['response' => 'success', 'result' => $DoctorSchedules]);
            } else {

                return response()->json(['user_exists' => 'false']);
            }
        } else {

            return response()->json(['response' => 'failed']);
        }
    }

    public function DeleteDoctorSchedules(Request $request)
    {
        $schedule_id       = $request->schedule_id;
        $DoctorSchedules = DoctorSchedules::where('id', $schedule_id)->where('is_deleted', '<>', 1)->exists();

        if ($schedule_id != null) {

            if ($DoctorSchedules == 1) {

                DoctorSchedules::findOrFail($schedule_id)->update([

                    'is_deleted'      => 1,
                ]);

                return response()->json(['response' => 'success']);
            } else {

                return response()->json(['response' => 'failed', 'response' => 'id does not exist']);
            }
        } else {

            return response()->json(['response' => 'failed']);
        }
    }

    public function NewInvitationRequest(Request $request)
    {


        $doctor_id     = $request->doctor_id;
        $patient_id    = $request->patient_id;
        $meeting_time  = $request->meeting_time;

        // $meeting_time  = "2023-10-30 12:00:00";

        if ($doctor_id != null && $patient_id != null && $meeting_time != null) {

            $doctor    = Doctor::where('id', $doctor_id)->where('is_deleted', '<>', 1)->exists();
            $patient   = Patient::where('id', $patient_id)->where('is_deleted', '<>', 1)->exists();

            if ($doctor == 1 && $patient == 1) {

                $day           = Carbon::parse($meeting_time)->format('D');
                $time          = Carbon::parse($meeting_time)->format('H:i:s');

                if ($day == 'Mon') $week = 1;
                else if ($day == 'Tue') $week = 2;
                else if ($day == 'Wed') $week = 3;
                else if ($day == 'Thu') $week = 4;
                else if ($day == 'Fri') $week = 5;
                else if ($day == 'Sat') $week = 6;
                else if ($day == 'Sun') $week = 7;

                // CHECKING IF DOCTOR IS AVAILABLE

                $doctor_schedules = DoctorSchedules::where('doctor_id', $doctor_id)->where('day_of_week', $week)->where('is_deleted', '<>', 1)->exists();

                if ($doctor_schedules == 1) {

                    $time_from = DoctorSchedules::where('doctor_id', $doctor_id)->where('day_of_week', $week)->where('is_deleted', '<>', 1)->pluck('time_from')->first();
                    $time_to   = DoctorSchedules::where('doctor_id', $doctor_id)->where('day_of_week', $week)->where('is_deleted', '<>', 1)->pluck('time_to')->first();
                    $time_checkARR = array();

                    if ($time > $time_from && $time < $time_to) {

                        array_push($time_checkARR, '1');
                    } else {
                        array_push($time_checkARR, '0');
                    }

                    if (in_array('0', $time_checkARR)) {

                        return response()->json(['response' => 'failed',  'message' => "Doctor Not Available"]);
                    } else {
                        $invitation               = new Invitation();
                        $invitation->patient_id   = $patient_id;
                        $invitation->doctor_id    = $doctor_id;
                        $invitation->meeting_time = $meeting_time;
                        $invitation->save();

                        return response()->json(['response' => 'success',  'invitation' => $invitation]);
                    }
                } else {
                    return response()->json(['response' => 'failed',  'message' => "No schedules found"]);
                }
            } else {

                return response()->json(['user_exists' => 'false']);
            }
        } else {

            return response()->json(['response' => 'failed']);
        }
    }

    public function GetAllDoctorsInvitationList(Request $request)
    {
        $doctor_id     = $request->doctor_id;

        if ($doctor_id != null) {

            $doctor    = Doctor::where('id', $doctor_id)->where('is_deleted', '<>', 1)->exists();

            if ($doctor == 1) {

                $doctor_invitation = Invitation::where('doctor_id', $doctor_id)->where('status', '<>', 3)->exists();

                if ($doctor_invitation == 1) {

                    $doctorInvitation = Invitation::where('doctor_id', $doctor_id)->where('status', '<>', 3)->get();

                    return response()->json(['response' => 'success',  'invitations' => $doctorInvitation]);
                } else {

                    return response()->json(['response' => 'failed', 'message' => 'invitation not found']);
                }
            } else {

                return response()->json(['user_exists' => 'false']);
            }
        } else {

            return response()->json(['response' => 'failed']);
        }
    }

    public function UpdateDoctorsInvitationStatus(Request $request)
    {

        $doctor_id     = $request->doctor_id;
        $patient_id    = $request->patient_id;
        $invitation_id = $request->invitation_id;
        $status        = $request->status;


        if ($doctor_id != null && $patient_id != null && $invitation_id != null && $status != null) {

            $doctor       = Doctor::where('id', $doctor_id)->where('is_deleted', '<>', 1)->exists();
            $patient      = Patient::where('id', $patient_id)->where('is_deleted', '<>', 1)->exists();

            if ($doctor == 1 && $patient == 1) {

                $invitation   = Invitation::where('id', $invitation_id)->where('doctor_id', $doctor_id)->where('patient_id', $patient_id)->where('status', '<>', 3)->exists();

                if ($invitation == 1) {

                    Invitation::findOrFail($invitation_id)->update([

                        'status'      => $status,
                    ]);

                    return response()->json(['response' => 'success']);
                } else {

                    return response()->json(['response' => 'failed', 'message' => 'invitation not found']);
                }
            } else {

                return response()->json(['user_exist' => 'false']);
            }
        } else {

            return response()->json(['response' => 'failed']);
        }
    }

    public function GetTodaysDoctorInvitationList(Request $request)
    {
        $doctor_id  = $request->doctor_id;
        $date_from  = Carbon::now()->format('Y:m:d');
        $date_to    = $date_from . " 23:59:59";

        if ($doctor_id != null) {

            $doctor       = Invitation::where('doctor_id', $doctor_id)->where('status', '<>', 3)->exists();

            if ($doctor == 1) {

                $todays_invitations   = Invitation::where('doctor_id', $doctor_id)->whereDate('meeting_time', '>=', $date_from)->whereDate('meeting_time', '<=', $date_to)->where('status', '<>', 3)->get();

                return response()->json(['response' => 'success',  'todays_invitations' => $todays_invitations]);
            } else {

                return response()->json(['response' => 'failed']);
            }
        } else {

            return response()->json(['response' => 'failed']);
        }
    }

    public function ReassignInvitation(Request $request)
    {
        $doctor_id     = $request->doctor_id;
        $invitation_id = $request->invitation_id;
        $reassigned_to = $request->reassigned_to;

        if ($doctor_id != null && $invitation_id != null && $reassigned_to != null) {

            $doctor      = Doctor::where('id', $reassigned_to)->where('is_deleted', '<>', 1)->exists();
            $invitation  = Invitation::where('id', $invitation_id)->where('doctor_id', $doctor_id)->where('status', '<>', 3)->exists();

            if ($invitation == 1) {

                if($doctor == 1){

                    Invitation::findOrFail($invitation_id)->update([

                        'doctor_id'      => $reassigned_to,
                    ]);

                    ReassignedInvitation::insert([

                        'doctor_id'      => $doctor_id,
                        'reassigned_to'  => $reassigned_to,
                        'invitation_id'  => $invitation_id,
                        'date_time'      => Carbon::now(),

                    ]);
                }  else {

                    return response()->json(['user_exist' => 'false']);
                }

                return response()->json(['response' => 'success', "message" => "Doctor updated successfully"]);

            } else {

                return response()->json(['response' => 'failed', "message" => "Something went wrong"]);
            }
        } else {

            return response()->json(['response' => 'failed']);
        }
    }
}
