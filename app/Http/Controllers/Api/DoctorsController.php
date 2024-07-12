<?php

namespace App\Http\Controllers\Api;

use DateTime;
use Dompdf\Dompdf;
use App\Models\Doctor;
use App\Models\Member;
use GuzzleHttp\Client;
use App\Models\ChatBox;
use App\Models\Patient;
use App\Models\Student;
use App\Models\Settings;
use App\Mail\WelcomeMail;
use App\Models\Attachment;
use App\Models\Department;
use App\Models\Invitation;
use App\Models\OtpHistory;
use App\Models\Speciality;
use Carbon\CarbonInterval;
use App\Models\Institution;
use App\Models\MeetingInfo;
use App\Models\MeetingNotes;
use App\Models\PatientFiles;
use Illuminate\Http\Request;
use App\Mail\AppointmentMail;
use App\Models\MeetingDetails;
use Illuminate\Support\Carbon;
use App\Models\DoctorSchedules;
use App\Models\SuperSpeciality;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use App\Models\MeetingPrescription;
use App\Http\Controllers\Controller;
use App\Models\ReassignedInvitation;
use Illuminate\Support\Facades\Mail;



class DoctorsController extends Controller
{
    public function GetAvailableSchedule(Request $request)
    {
        $doctor_id        = $request->doctor_id;
        $available_time   = $request->available_time;
        $date             = $request->date;
        $day              = Carbon::parse($date)->format('D');

        if ($day == 'Mon') $week = 1;
        else if ($day == 'Tue') $week = 2;
        else if ($day == 'Wed') $week = 3;
        else if ($day == 'Thu') $week = 4;
        else if ($day == 'Fri') $week = 5;
        else if ($day == 'Sat') $week = 6;
        else if ($day == 'Sun') $week = 7;

        $slotes_available  = DoctorSchedules::where('doctor_id', $doctor_id)->where('available_time', $available_time)->where('day_of_week',$week)->where('status','<>',2)->select('time_from','time_to','duration')->exists();

        if($slotes_available == 1) {

            $slotes_added  = DoctorSchedules::where('doctor_id', $doctor_id)->where('available_time', $available_time)->where('day_of_week',$week)->where('status','<>',2)->select('time_from','time_to','duration')->get();

                $timeSlotes = array();

            foreach($slotes_added as $slotes) {

                    $timeFrom      = Carbon::parse($slotes->time_from);
                    $timeTo        = Carbon::parse($slotes->time_to);
                    $timeFrom_hour = $timeFrom->hour;
                    $timeTo_hour   = $timeTo->hour;
                    $timeDiff      = $timeTo_hour - $timeFrom_hour;
                    $timeHour      = $timeDiff * 60;
                    $duration      = $slotes->duration;
                    $total_slotes  = $timeHour / $duration;

                $i = 0;
                $interval          = CarbonInterval::minutes($duration);
                $formattedDuration = $interval->cascade()->format('%H:%I:%S');

                $interval1          = CarbonInterval::minutes($timeFrom_hour);
                $formattedDuration1 = $interval1->cascade()->format('%H:%I:%S');

                $new_slotes = Carbon::createFromTimeString($timeFrom);
                $newTime       = $new_slotes;
                $new_slotes    = $newTime->format('H:i:s');
                array_push($timeSlotes, $new_slotes);

                while($i < $total_slotes - 1 ) {


                    $originalTime  = Carbon::createFromTimeString($new_slotes);
                    $newTime       = $originalTime->addMinutes($duration);
                    $new_slotes    = $newTime->format('H:i:s');

                    array_push($timeSlotes, $new_slotes);
                    $i++;

                }

            }

            $invitations = Invitation::where('doctor_id', $doctor_id)->where('meeting_date',$date)->where('available_time', $available_time)->pluck('meeting_time')->toArray();

            if(!empty($invitations))
            {
                $array1 = array_diff($timeSlotes, $invitations);

                $array2 = array_diff($invitations, $timeSlotes);

                $available_slotes = array_merge($array1, $array2);

                return response()->json(['response' => 'success', 'total_slotes' => $timeSlotes,'available_slotes' => $available_slotes]);

            } else {

                return response()->json(['response' => 'success', 'total_slotes' => $timeSlotes, 'available_slotes' => $timeSlotes]);

            }

        } else {

            return response()->json(['response' => 'failed', 'message' => 'Not available']);
        }

    }

    public function checkPhoneNumber(Request $request)
    {
        $mobile        = $request->mobile;
        $user_type     = $request->user_type;

        if($user_type == 0) {

            $mobile_exists = Doctor::where('mobile', $request->mobile)->where('status', 1)->exists();

            if ($mobile_exists == 1) {

                $user_id  = Doctor::where('mobile', $request->mobile)->where('status', 1)->pluck('id')->first();

            } else {

                $user_id = 0;
            }

        } else if($user_type == 1){

            $mobile_exists = Patient::where('mobile', $request->mobile)->where('status', '<>', 2)->exists();

            if ($mobile_exists == 1) {

                $user_id  = Patient::where('mobile', $request->mobile)->where('status', '<>', 2)->pluck('id')->first();
            } else {

                $user_id = 0;
            }
        }else {

            return response()->json(['response' => 'failed', 'message' => 'check user type']);

        }

        if ($mobile != null && $user_type != null) {

            $client  = new \GuzzleHttp\Client();
            $mobile  = $request->mobile;
            $otp     = random_int(1000, 9999);
            $value   = " ".$otp." ";

            $var            = new OtpHistory();
            $var->user_id   = $user_id;
            $var->user_type = $user_type;
            $var->mobile    = $mobile;
            $var->otp       = $otp;
            $var->save();

            $response      = $client->request('GET', 'https://sapteleservices.com/SMS_API/sendsms.php?apikey=95702791-6d88-11ee-a4f5-e29d2b69142c&mobile=' .$mobile. '&sendername=WELLNX&message=Dear user,' .$value. ' is your DocBae verification code.WELLNEXUS HEALTH SCIENCE LLP&routetype=1&tid=1607100000000300481');


                return response()->json(['response' => 'success']);

        } else {

            return response()->json(['response' => 'failed']);
        }
    }

    public function UserExist(Request $request)
    {
        $mobile    = $request->mobile;
        $otp       = $request->otp;
        $user_type = $request->user_type;

        if ($otp != null && $mobile != null && $user_type != null) {

            if ($user_type == 0) {

                $user_otp = OtpHistory::where('otp', $otp)->where('is_used', '<>', 1)->exists();

                if ($user_otp == 1) {

                    $user_id    = OtpHistory::where('otp', $otp)->pluck('user_id')->first();
                    $doctor_id  = Doctor::where('id', $user_id)->where('status', 1)->exists();
                    $id         = OtpHistory::where('otp', $otp)->pluck('id')->first();

                    if ($doctor_id == 1) {

                        $user   = Doctor::where('id', $user_id)->where('status', 1)->get();

                        OtpHistory::findOrFail($id)->update([

                            'is_used'  => 1,

                        ]);

                        return response()->json(['otp_status' => 'true', 'user_exist' => 'true',  'user_id' => $user_id]);
                    } else {

                        return response()->json(['otp_status' => 'true','user_exist' => 'false']);
                    }
                } else {

                    return response()->json(['opt_status' => 'false']);
                }

            } else if($user_type == 1){

                $user_otp = OtpHistory::where('otp', $otp)->where('is_used', '<>', 1)->exists();

                if ($user_otp == 1) {

                    $user_id    = OtpHistory::where('otp', $otp)->pluck('user_id')->first();
                    $patient_id = Patient::where('id', $user_id)->where('status', '<>', 2)->exists();
                    $id         = OtpHistory::where('otp', $otp)->pluck('id')->first();

                    if ($patient_id == 1) {

                        $user   = Patient::where('id', $user_id)->where('status', '<>', 2)->get();

                        OtpHistory::findOrFail($id)->update([

                            'is_used'  => 1,

                        ]);

                        return response()->json(['otp_status' => 'true', 'user_exist' => 'true',  'user_id' => $user_id]);

                    } else {

                        return response()->json(['otp_status' => 'true','user_exist' => 'false']);
                    }
                } else {

                    return response()->json(['opt_status' => 'false']);
                }
            }


        } else {

            return response()->json(['response' => 'failed']);
        }
    }

    public function DoctorRegister(Request $request)
    {
        $mobile = Doctor::where('mobile', $request->mobile)->where('status', 1)->exists();
        $type   = $request->type;
        $first_name = $request->first_name;
        $last_name  = $request->last_name;

        if ($mobile == 0) {

            if($type == 0){
                $department_name = "General medicine";
            } else {
                $department_name = $request->department_name;
            }

            if ($request->file('mbbs_registration_certificate') != null) {
                $file       = $request->file('mbbs_registration_certificate');
                $mbbs_certificate   = $file->getClientOriginalName();
                $request->mbbs_registration_certificate->move(public_path('Images/Doctor/Certificates'), $mbbs_certificate);
                $path       = "public/Images/Doctor/Certificates/$mbbs_certificate";
            } else {
                $mbbs_certificate = "";
            }

            if ($request->file('additional_registration_certificate') != null) {
                $file       = $request->file('additional_registration_certificate');
                $registration_certificate   = $file->getClientOriginalName();
                $request->additional_registration_certificate->move(public_path('Images/Doctor/Certificates'), $registration_certificate);
                $path       = "public/Images/Doctor/Certificates/$registration_certificate";
            } else {
                $registration_certificate = "";
            }

            if ($request->file('degree_certificate') != null) {
                $file       = $request->file('degree_certificate');
                $degree     = $file->getClientOriginalName();
                $request->degree_certificate->move(public_path('Images/Doctor/Certificates'), $degree);
                $path       = "public/Images/Doctor/Certificates/$degree";
            } else {
                $degree = "";
            }

            if ($request->file('pg_certificate') != null) {
                $file       = $request->file('pg_certificate');
                $pg         = $file->getClientOriginalName();
                $request->pg_certificate->move(public_path('Images/Doctor/Certificates'), $pg);
                $path       = "public/Images/Doctor/Certificates/$pg";
            } else {
                $pg = "";
            }

            if ($request->file('attachment') != null) {
                $file       = $request->file('attachment');
                $doc_attachment = $file->getClientOriginalName();
                $request->attachment->move(public_path('Images/Doctor/Certificates'), $doc_attachment);
                $path       = "public/Images/Doctor/Certificates/$doc_attachment";
            } else {
                $doc_attachment = "";
            }

            if ($request->file('profile_pic') != null) {
                $file       = $request->file('profile_pic');
                $profile   = $file->getClientOriginalName();
                $request->profile_pic->move(public_path('Images/Doctor/Profile_picture'), $profile);
                $path       = "public/Images/Doctor/Profile_picture/$profile";
            }

            if ($request->file('experience_file') != null) {
                $file         = $request->file('experience_file');
                $experience   = $file->getClientOriginalName();
                $request->experience_file->move(public_path('Images/Doctor/Certificates'), $experience);
                $path          = "public/Images/Doctor/Certificates/$experience";
            } else {
                $experience = "";
            }


            $doctor                                               = new Doctor();
            $doctor->type                                         = $request->type;
            $doctor->first_name                                   = $request->first_name;
            $doctor->last_name                                    = $request->last_name ?? "";
            $doctor->mobile                                       = $request->mobile;
            $doctor->dob                                          = $request->dob;
            $doctor->email                                        = $request->email;
            $doctor->gender                                       = $request->gender;
            $doctor->profile_pic                                  = $profile ?? "";
            $doctor->address                                      = $request->address;
            $doctor->location                                     = $request->location;
            $doctor->state                                        = $request->state ?? "";
            $doctor->mbbs_registration_certificate                = $mbbs_certificate ?? "";
            $doctor->mbbs_certificate_number                      = $request->mbbs_certificate_number ?? "";
            $doctor->year_of_passing_out_mbbs                     = $request->year_of_passing_out_mbbs ?? 0;
            $doctor->additional_registration_certificate          = $registration_certificate ?? "";
            $doctor->additional_registration_certificate_number   = $request->additional_registration_certificate_number ?? "";
            $doctor->degree_certificate                           = $degree ?? "";
            $doctor->year_of_passing_out_degree                   = $request->year_of_passing_out_degree ?? 0;
            $doctor->registration_council                         = $request->registration_council ?? "";
            $doctor->pg_certificate                               = $pg ?? "";
            $doctor->pg_certificate_number                        = $request->pg_certificate_number ?? 0;
            $doctor->year_of_passing_out_pg                       = $request->year_of_passing_out_pg ?? 0;
            $doctor->institution                                  = $request->institution ?? "";
            $doctor->experience_if_any                            = $request->experience_if_any ?? 0;
            $doctor->department_name                              = $department_name ?? "";
            $doctor->attachment                                   = $doc_attachment ?? "";
            $doctor->experience_file                              = $experience ?? "";
            $doctor->save();

            // Mail::to($request->email)->send(new WelcomeMail($first_name, $last_name));


            return response()->json(['Doctor Register' => 'success', 'user' => $doctor]);
        } else {

            return response()->json(['response' => 'failed', 'message' => "number exists"]);
        }
    }

    public function UpdateDoctorProfile(Request $request)
    {
        if ($request->id != null) {

            $user   = Doctor::where('id', $request->id)->where('status', 1)->exists();

            if ($user == 1) {

                $check_mobile = Doctor::where('id','<>', $request->id)->where('mobile',$request->mobile)->where('status', 1)->exists();

                if($check_mobile == 0){

                    $doctor = Doctor::findOrFail($request->id);

                    if ($request->file('mbbs_registration_certificate') != null) {

                        if($doctor->mbbs_registration_certificate != null){

                             $imagePath = public_path('Images/Doctor/Certificates/'.$doctor->mbbs_registration_certificate);
                             unlink($imagePath);
                        }

                        $file       = $request->file('mbbs_registration_certificate');
                        $mbbs_certificate   = $file->getClientOriginalName();
                        $request->mbbs_registration_certificate->move(public_path('Images/Doctor/Certificates'), $mbbs_certificate);
                        $path       = "public/Images/Doctor/Certificates/$mbbs_certificate";
                    } else {
                        $mbbs_certificate = $doctor->mbbs_registration_certificate;
                    }

                    if ($request->file('additional_registration_certificate') != null) {

                        if($doctor->additional_registration_certificate != null){
                             $imagePath = public_path('Images/Doctor/Certificates/'.$doctor->additional_registration_certificate);
                             unlink($imagePath);
                        }

                        $file       = $request->file('additional_registration_certificate');
                        $registration_certificate   = $file->getClientOriginalName();
                        $request->additional_registration_certificate->move(public_path('Images/Doctor/Certificates'), $registration_certificate);
                        $path       = "public/Images/Doctor/Certificates/$registration_certificate";
                    } else {
                        $registration_certificate = $doctor->registration_certificate;
                    }

                    if ($request->file('degree_certificate') != null) {

                        if($doctor->degree_certificate != null){
                             $imagePath = public_path('Images/Doctor/Certificates/'.$doctor->degree_certificate);
                             unlink($imagePath);
                        }

                        $file       = $request->file('degree_certificate');
                        $degree     = $file->getClientOriginalName();
                        $request->degree_certificate->move(public_path('Images/Doctor/Certificates'), $degree);
                        $path       = "public/Images/Doctor/Certificates/$degree";
                    } else {
                        $degree = $doctor->degree_certificate;
                    }

                    if ($request->file('pg_certificate') != null) {

                        if($doctor->pg_certificate != null){
                             $imagePath = public_path('Images/Doctor/Certificates/'.$doctor->pg_certificate);
                             unlink($imagePath);
                        }

                        $file       = $request->file('pg_certificate');
                        $pg         = $file->getClientOriginalName();
                        $request->pg_certificate->move(public_path('Images/Doctor/Certificates'), $pg);
                        $path       = "public/Images/Doctor/Certificates/$pg";
                    } else {
                        $pg = $doctor->pg_certificate;
                    }

                    if ($request->file('attachment') != null) {

                        if($doctor->attachment != null){

                            $imagePath = public_path('Images/Doctor/Certificates/'.$doctor->attachment);
                            unlink($imagePath);
                        }

                        $file       = $request->file('attachment');
                        $doc_attachment = $file->getClientOriginalName();
                        $request->attachment->move(public_path('Images/Doctor/Certificates'), $doc_attachment);
                        $path       = "public/Images/Doctor/Certificates/$doc_attachment";
                    } else {
                        $doc_attachment = $doctor->attachment;
                    }

                    if ($request->file('profile_pic') != null) {

                        if($doctor->profile_pic != null){

                            $imagePath = public_path('Images/Doctor/Profile_picture/'.$doctor->profile_pic);
                            unlink($imagePath);
                        }

                        $file       = $request->file('profile_pic');
                        $profile   = $file->getClientOriginalName();
                        $request->profile_pic->move(public_path('Images/Doctor/Profile_picture'), $profile);
                        $path       = "public/Images/Doctor/Profile_picture/$profile";
                    }else {
                        $profile = $doctor->profile_pic;
                    }

                    if ($request->file('experience_file') != null) {

                        if($doctor->experience_file != null){

                            $imagePath = public_path('Images/Doctor/Certificates/'.$doctor->experience_file);
                            unlink($imagePath);
                        }

                        $file         = $request->file('experience_file');
                        $experience   = $file->getClientOriginalName();
                        $request->experience_file->move(public_path('Images/Doctor/Certificates'), $experience);
                        $path          = "public/Images/Doctor/Certificates/$experience";
                    } else {
                        $experience = $doctor->experience_file;
                    }


                Doctor::findOrFail($request->id)->update([

                    'type'                                       => $request->type ?? $doctor->type,
                    'first_name'                                 => $request->first_name ?? $doctor->first_name,
                    'last_name'                                  => $request->last_name ?? $doctor->last_name,
                    'mobile'                                     => $request->mobile ?? $doctor->mobile,
                    'gender'                                     => $request->gender ?? $doctor->gender,
                    'email'                                      => $request->email ?? $doctor->email,
                    'dob'                                        => $request->dob ?? $doctor->dob,
                    'profile_pic'                                => $profile ?? "",
                    'address'                                    => $request->address ?? $doctor->address,
                    'location'                                   => $request->location ?? $doctor->location,
                    'state'                                      => $request->state ?? $doctor->state,
                    'mbbs_registration_certificate'              => $mbbs_certificate ?? "",
                    'mbbs_certificate_number'                    => $request->mbbs_certificate_number ?? $doctor->mbbs_certificate_number,
                    'year_of_passing_out_mbbs'                   => $request->year_of_passing_out_mbbs ?? $doctor->year_of_passing_out_mbbs,
                    'additional_registration_certificate'        => $registration_certificate?? "",
                    'additional_registration_certificate_number' => $request->additional_registration_certificate_number ?? $doctor->additional_registration_certificate_number,
                    'degree_certificate'                         => $degree ?? "",
                    'year_of_passing_out_degree'                 => $request->year_of_passing_out_degree ?? $doctor->year_of_passing_out_degree,
                    'registration_council'                       => $request->registration_council ?? $doctor->registration_council,
                    'pg_certificate'                             => $pg ?? "",
                    'pg_certificate_number'                      => $request->pg_certificate_number ?? $doctor->pg_certificate_number,
                    'year_of_passing_out_pg'                     => $request->year_of_passing_out_pg ?? $doctor->year_of_passing_out_pg,
                    'institution'                                => $request->institution ?? $doctor->pg_certificate_number,
                    'experience_if_any'                          => $request->experience_if_any ??  $doctor->experience_if_any,
                    'department_name'                            => $request->department_name  ?? $doctor->department_name,
                    'attachment'                                 => $doc_attachment ?? "",
                    'experience_file'                            => $experience ?? "",

                ]);

                $result = Doctor::findOrFail($request->id);

                return response()->json(['response' => 'success', 'result' => $result]);
              }else {

                return response()->json(['response' => 'failed', 'message' => "Mobile number exists"]);
            }

            } else {

                return response()->json(['response' => 'failed', 'message' => "user does not exist"]);
            }

        }else {

            return response()->json(['response' => 'failed', 'message' => "please enter the details"]);
        }

    }

    public function ViewDoctorsProfile(Request $request)
    {
        if ($request->id != null) {

            $user = Doctor::where('id', $request->id)->where('status',1)->exists();

            if ($user == 1) {

                $is_verified = Doctor::where('id', $request->id)->where('is_verified', 1)->where('status', 1)->exists();
                $doctor     =  Doctor::findOrFail($request->id);

                if($is_verified == 1){

                     return response()->json(['user_verification' => 'true', 'user' => $doctor]);

                } else {

                    return response()->json(['user_verification' => 'false','user' => $doctor]);

                }

            } else {

                return response()->json(['response' => 'failed','user_exists' => 'false']);
            }
        } else {

            return response()->json(['response' => 'failed', 'message' => "please enter id"]);
        }
    }

    public function GetAllDoctors(Request $request)
    {
        $doctors = Doctor::where('status', 1)->where('is_verified',1)->get();

        // $doctors = DB::table('departments')
        //     ->join('doctors', 'departments.id', '=', 'doctors.department_id')
        //     ->select('doctors.*', 'departments.department')
        //     ->where('doctors.status', '<>', 2)
        //     ->where('doctors.is_verified',1)
        //     ->get();

            return response()->json(['response' => 'success', 'result' => $doctors]);

    }

    public function SearchDoctor(Request $request)
    {
        $search_text      = $request->input("search_text");
        $department_name  = $request->input("department_name");

        if ($search_text) {

            if($department_name == null){

                $result = Doctor::where('status', 1)
                    ->where('is_verified', 1)
                    ->where('first_name', 'like', '%' . $search_text . '%')
                    // ->orWhere('last_name', 'like', '%' . $search_text . '%')
                    ->orWhere('mobile', 'like', '%' . $search_text . '%')
                    // ->get();
                    ->paginate(5);
                } else {
                    $result = Doctor::where('status', 1)
                    ->where('is_verified', 1)
                    ->where('department_name', $department_name)
                    ->where('first_name', 'like', '%' . $search_text . '%')
                    ->orWhere('mobile', 'like', '%' . $search_text . '%')
                    ->paginate(5);
                }

            if (!$result->isEmpty()) {
                return response()->json(['response' => 'success', 'result' => $result]);
            } else {

                return response()->json(['response' => 'failed', 'message' => 'No user found']);
            }
        } else {

            return response()->json(['response' => 'failed', 'message' => "please enter text"]);
        }
    }

    public function UpdateDoctorSchedule(Request $request)
    {

        $doctor_id    = $request->doctor_id;
        $schedule_id  = $request->schedule_id;
        $doctor       = Doctor::where('id', $doctor_id)->exists();

        if ($doctor == 1) {

            $schedulesARR = $request->schedules;

            if ($schedule_id == null) {

                // insert doctor schedule
                foreach ($schedulesARR as $schedules) {

                    if ($schedules['day_of_week'] != 0  && $schedules['time_from'] != 0 && $schedules['time_to'] != 0) {

                        $check = DoctorSchedules::where('doctor_id',$doctor_id)->where('available_time',$schedules['available_time'])->where('day_of_week',$schedules['day_of_week'])->where('time_from',$schedules['time_from'])->where('time_to',$schedules['time_to'])->where('status','<>',2)->exists();

                        $check_available_time =  DoctorSchedules::where('doctor_id',$doctor_id)->where('available_time',$schedules['available_time'])->where('day_of_week',$schedules['day_of_week'])->where('status','<>',2)->exists();

                        if($check == 0 && $check_available_time == 0){

                            $doctor_schedules =  DoctorSchedules::insert([

                                'doctor_id'      => $doctor_id,
                                'available_time' => $schedules['available_time'],
                                'day_of_week'    => $schedules['day_of_week'],
                                'time_from'      => $schedules['time_from'],
                                'time_to'        => $schedules['time_to'],
                                'duration'       => $schedules['duration'],
                            ]);

                            $DoctorSchedules = DoctorSchedules::where('doctor_id', $doctor_id)->orderBy('id','desc')->where('status', '<>', 2)->get();

                            return response()->json(['response' => 'success', 'result' => $DoctorSchedules]);

                        } else {
                             return response()->json(['response' => 'failed', 'message' => 'schedule exists']);

                        }
                    }
                }

            } else {

                // update doctor schedule
                foreach ($schedulesARR as $schedules) {
                    if ($schedules['day_of_week'] != 0  && $schedules['time_from'] != 0 && $schedules['time_to'] != 0) {

                        DoctorSchedules::findOrFail($schedule_id)->update([

                            'doctor_id'      => $doctor_id,
                            'available_time' => $schedules['available_time'],
                            'day_of_week'    => $schedules['day_of_week'],
                            'time_from'      => $schedules['time_from'],
                            'time_to'        => $schedules['time_to'],
                            'duration'       => $schedules['duration'],

                        ]);

                        $DoctorSchedules = DoctorSchedules::findOrFail($schedule_id);

                        return response()->json(['response' => 'success', 'result' => $DoctorSchedules]);
                    } else {

                        return response()->json(['response' => 'failed']);
                    }
                }
            }
        } else {

            return response()->json(['response' => 'failed']);
        }
    }

    public function GetDoctorScheduleDetails(Request $request)
    {
        $doctor_id       = $request->doctor_id;
        $DoctorSchedules = DoctorSchedules::where('doctor_id', $doctor_id)->where('status', '<>', 2)->exists();

        if ($doctor_id != null) {
            if ($DoctorSchedules == 1) {

                $DoctorSchedules = DoctorSchedules::where('doctor_id', $doctor_id)->where('status', '<>', 2)->get();

                return response()->json(['response' => 'success', 'result' => $DoctorSchedules]);
            } else {

                return response()->json(['response' => 'failed', 'message' =>'schedule not found']);
            }
        } else {

            return response()->json(['response' => 'failed']);
        }
    }

    public function DeleteDoctorSchedules(Request $request)
    {
        $schedule_id       = $request->schedule_id;
        $DoctorSchedules = DoctorSchedules::where('id', $schedule_id)->where('status', '<>', 2)->exists();

        if ($schedule_id != null) {

            if ($DoctorSchedules == 1) {

                DoctorSchedules::findOrFail($schedule_id)->update([

                    'status' => 2,
                ]);

                // DoctorSchedules::where('id', $schedule_id)->delete();

                $schedule_list = DoctorSchedules::where('status', '<>', 2)->get();

                return response()->json(['response' => 'success','result' => $schedule_list]);
            } else {

                return response()->json(['response' => 'failed', 'message' => 'id does not exist']);
            }
        } else {

            return response()->json(['response' => 'failed']);
        }
    }

    public function NewInvitationRequest(Request $request)
    {
        $doctor_id        = $request->doctor_id;
        $patient_id       = $request->patient_id;
        $meeting_date     = $request->meeting_date;
        $meeting_time     = $request->meeting_time;
        $member_id        = $request->member_id;
        $user_type        = $request->user_type;
        $transaction_id   = $request->transaction_id;
        $available_time   = $request->available_time;


        if($doctor_id != null && $patient_id != null && $meeting_date != null && $meeting_time != null && $available_time != null)
        {
            $doctor    = Doctor::where('id', $doctor_id)->where('status', 1)->exists();
            $patient   = Patient::where('id', $patient_id)->where('status', '<>', 2)->exists();

            if ($doctor == 1 && $patient == 1)
            {
                $consultation_fee = Doctor::where('id', $doctor_id)->pluck('consultation_fee')->first();
                if($consultation_fee != null){

                    $fee                   = $consultation_fee;
                    $commission_percentage =  Doctor::where('id', $doctor_id)->pluck('commission_percentage')->first();
                    $amount                = ($fee * $commission_percentage)/100;
                    $doctors_fee           = $fee - $amount;

                } else {
                    $fee                   = Settings::pluck('consultation_fee')->first();
                    $commission_percentage = Settings::pluck('commission_percentage')->first();
                    $amount                = ($fee * $commission_percentage)/100;
                    $doctors_fee           = $fee - $amount;

                }

                $day   = Carbon::parse($meeting_date)->format('D');
                $time  = Carbon::parse($meeting_time)->format('H:i:s');

                if ($day == 'Mon') $week = 1;
                else if ($day == 'Tue') $week = 2;
                else if ($day == 'Wed') $week = 3;
                else if ($day == 'Thu') $week = 4;
                else if ($day == 'Fri') $week = 5;
                else if ($day == 'Sat') $week = 6;
                else if ($day == 'Sun') $week = 7;

                $doctor_schedules = DoctorSchedules::where('doctor_id', $doctor_id)->where('day_of_week', $week)->where('status','<>',2)->where('available_time',$available_time)->exists();

                if($doctor_schedules == 1){

                    $time_from = DoctorSchedules::where('doctor_id', $doctor_id)->where('available_time',$available_time)->where('day_of_week', $week)->pluck('time_from')->first();

                    $time_to   = DoctorSchedules::where('doctor_id', $doctor_id)->where('available_time',$available_time)->where('day_of_week', $week)->where('status','<>',2)->where('time_from','=',$time_from)->pluck('time_to')->first();

                    $time_checkARR = array();

                    if ($time >= $time_from && $time < $time_to) {

                        array_push($time_checkARR, '1');
                    } else {
                        array_push($time_checkARR, '0');
                    }

                    if (in_array('0', $time_checkARR)) {

                        return response()->json(['response' => 'failed',  'message' => "Schedule Not Available"]);

                    } else {

                        $check_availability = Invitation::where('meeting_date',$meeting_date)->where('meeting_time',$meeting_time)->where('doctor_id',$doctor_id)->exists();

                        if($member_id != null){

                            if($user_type == 1){

                                $member_exists = Member::where('user_type',1)->where('id',$member_id)->where('patient_id',$patient_id)->where('status','<>',2)->exists();

                                $var   = $member_id;

                            }else if( $user_type == 2) {

                                $member_exists = Member::where('user_type',2)->where('id',$member_id)->where('patient_id',$patient_id)->where('status','<>',2)->exists();

                                $var   = $member_id;
                            }else {
                                return response()->json(['response' => 'failed',  'message' => "enter a valid user type"]);

                            }

                            if($member_exists == 0){

                                 return response()->json(['response' => 'failed',  'message' => "member does not exist"]);

                            }

                        } else if($member_id == null){

                            return response()->json(['response' => 'failed',  'message' => "please enter member id"]);

                        }

                        if($check_availability == 0){

                            $invitation                       = new Invitation();
                            $invitation->user_type             = $user_type;
                            $invitation->patient_id            = $patient_id;
                            $invitation->member_id             = $var;
                            $invitation->doctor_id             = $doctor_id;
                            $invitation->meeting_date          = $meeting_date;
                            $invitation->meeting_time          = $meeting_time;
                            $invitation->available_time        = $available_time;
                            $invitation->transaction_id        = $transaction_id ?? 0;
                            $invitation->consultation_fee      = $fee ?? 0;
                            $invitation->commission_percentage = $commission_percentage ?? 0;
                            $invitation->commission_amount     = $amount ?? 0;
                            $invitation->doctors_fee           = $doctors_fee ?? 0;
                            $invitation->created_at            = Carbon::now('Asia/Kolkata');
                            $invitation->save();

                            $email_id     = Doctor::where('id',$doctor_id)->pluck('email')->first();

                            $invitation_id = $invitation->id;

                            // Mail::to($email_id)->send(new AppointmentMail($invitation_id));

                            return response()->json(['response' => 'success',  'invitation' => $invitation]);

                        } else {

                            return response()->json(['schedule_exist' => 'true',  'message' => "Slot is not available"]);
                        }

                    }
                } else {

                    return response()->json(['schedule_exist' => 'false']);

                }

            } else {
                return response()->json(['user_exist' => 'false']);

            }

        } else {

            return response()->json(['response' => 'failed', 'message' => 'please enter the required fields']);
        }
    }

    public function CreateEmergencyCall(Request $request)
    {
        // print_r("hii");
        // exit;

        $dateTime         = Carbon::now('Asia/Kolkata');
        $patient_id       = $request->patient_id;
        $meeting_date     = $dateTime->toDateString();
        $meeting_time     = $dateTime->toTimeString();
        $member_id        = $request->member_id;

        if($patient_id != null && $member_id != null )
        {
            $patient   = Patient::where('id', $patient_id)->where('status', '<>', 2)->exists();

            if($patient == 1){

                $member_exists = Member::where('user_type',2)->where('id',$member_id)->where('patient_id',$patient_id)->where('status','<>',2)->exists();

                if($member_exists == 1){

                    $invitation                       = new Invitation();
                    $invitation->user_type             = 2;
                    $invitation->patient_id            = $patient_id;
                    $invitation->member_id             = $member_id;
                    $invitation->doctor_id             = $doctor_id ?? 0;
                    $invitation->meeting_date          = $meeting_date;
                    $invitation->meeting_time          = $meeting_time;
                    $invitation->available_time        = 0;
                    $invitation->status                = 3;
                    $invitation->emergency_call        = 1;
                    $invitation->created_at            = Carbon::now('Asia/Kolkata');
                    $invitation->save();

                    return response()->json(['response' => 'success',  'invitation' => $invitation]);

                } else {
                    return response()->json(['response' => 'failed', 'message' => 'member does not exist']);
                }

            } else {
                return response()->json(['response' => 'failed', 'message' => 'patient does not exist']);
            }


        } else {

            return response()->json(['response' => 'failed', 'message' => 'please enter the required fields']);
        }
    }

    public function GetEmergencyCall(Request $request)
    {
        // $emergency_calls = Invitation::where('emergency_call',1)->where('status',0)->select('id','user_type','patient_id','member_id','meeting_date','meeting_time','created_at','status')->get();

        $emergency_calls = DB::table('invitations')
                        ->join('patients', 'invitations.patient_id', '=', 'patients.id')
                        ->join('members', 'invitations.member_id', '=', 'members.id')
                        ->select('invitations.id as invitation_id', 'invitations.patient_id as institute_id','invitations.member_id as   patient_id_id','invitations.meeting_date','invitations.meeting_time','invitations.status','invitations.created_at','patients.name as institute_name', 'patients.mobile as institute_mobile','patients.profile_pic as institute_image', 'members.name as patient_name', 'members.age as patient_age','members.image as patient_image')
                        ->where('invitations.emergency_call',1)
                        ->where('invitations.status',3)
                        ->get();

        return response()->json(['response' => 'success', 'result' => $emergency_calls ]);

    }

    public function updateEmergencyCall(Request $request)
    {
        $invitation_id = $request->invitation_id;
        $user_type     = $request->user_type;
        $doctor_id     = $request->doctor_id;

        if($invitation_id != null && $user_type != null){

            $invitation   = Invitation::where('id', $invitation_id)->exists();

            if($invitation == 1){

                if($user_type == 0){

                    if($doctor_id != null){

                        $doctor_exists = Doctor::where('id',$doctor_id)->where('status', 1)->where('is_verified',1)->exists();

                        if($doctor_exists == 1){

                            Invitation::where('id',$invitation_id)->update([

                                'status'    => 1,
                                'doctor_id' => $doctor_id,

                            ]);

                            $emergency_calls = DB::table('invitations')
                            ->join('patients', 'invitations.patient_id', '=', 'patients.id')
                            ->join('members', 'invitations.member_id', '=', 'members.id')
                            ->select('invitations.id as invitation_id','invitations.doctor_id', 'invitations.patient_id as institute_id','invitations.member_id as   patient_id_id','invitations.meeting_date','invitations.meeting_time','invitations.status','invitations.created_at','patients.name as institute_name', 'patients.mobile as institute_mobile','patients.profile_pic as institute_image', 'members.name as patient_name', 'members.age as patient_age','members.image as patient_image')
                            ->where('invitations.id',$invitation_id)
                            ->get();

                            return response()->json(['response' => 'success','emergency_calls' => $emergency_calls]);

                        } else {

                            return response()->json(['response' => 'failed', 'message' => 'user does not exist']);
                        }

                    } else {
                         return response()->json(['response' => 'failed', 'message' => 'please enter doctor_id']);
                    }

                } else if($user_type == 2){

                    Invitation::where('id',$invitation_id)->update([

                        'status'    => 4,

                    ]);

                    $emergency_calls = DB::table('invitations')
                                        ->join('patients', 'invitations.patient_id', '=', 'patients.id')
                                        ->join('members', 'invitations.member_id', '=', 'members.id')
                                        ->select('invitations.id as invitation_id','invitations.doctor_id', 'invitations.patient_id as institute_id','invitations.member_id as   patient_id_id','invitations.meeting_date','invitations.meeting_time','invitations.status','invitations.created_at','patients.name as institute_name', 'patients.mobile as institute_mobile','patients.profile_pic as institute_image', 'members.name as patient_name', 'members.age as patient_age','members.image as patient_image')
                                        ->where('invitations.id',$invitation_id)
                                        ->get();

                    return response()->json(['response' => 'success','emergency_calls' => $emergency_calls]);


                } else {
                    return response()->json(['response' => 'failed', 'message' => 'please enter a valid user type']);
                }

            } else {

                return response()->json(['response' => 'failed', 'message' => 'invitation does not exist']);
            }
        } else {

            return response()->json(['response' => 'failed', 'message' => 'please enter the required fields']);
        }

    }

    public function GetAppointmentList(Request $request)
    {
        $user_id    = $request->user_id;
        $user_type  = $request->user_type;
        $date       = $request->date;

        if ($user_id != null && $user_type != null) {

            if($user_type == 0) {
                $user  = Doctor::where('id', $user_id)->where('status', 1)->exists();

                if($date != null){

                // $department_id   = Doctor::where('id',$user_id)->pluck('department_id')->first();
                // $department_name = Department::pluck('department')->first();

                $invitation = Invitation::with('patient','members','doctor')->whereDate('meeting_date', $date)->where('doctor_id', $user_id)->where('status', 0)->get();
                } else {
                    $invitation = Invitation::with('patient','members','doctor')->where('doctor_id', $user_id)->where('status', 0)->get();

                }


            }
            // else if($user_type == 1) {
            //     $user  = Patient::where('id', $user_id)->where('status', '<>',2)->exists();

            //     if($date != null){

            //         $invitation = Invitation::with('patient','family_member','doctor')->whereDate('meeting_date', $date)->where('patient_id', $user_id)->where('status', 0)->get();
            //     }else {

            //         $invitation = Invitation::with('patient','family_member','doctor')->where('patient_id', $user_id)->where('status', 0)->get();
            //     }
            // }

            else {
                $user  = Patient::where('id', $user_id)->where('status', '<>',2)->exists();

                if($date != null){

                    $invitation = Invitation::with('patient','members','doctor')->whereDate('meeting_date', $date)->where('patient_id', $user_id)->where('status', 0)->get();
                }else {

                    $invitation = Invitation::with('patient','members','doctor')->where('patient_id', $user_id)->where('status', 0)->get();
                }
            }

            if ($user == 1) {

                if (!$invitation->isEmpty()) {

                    return response()->json(['response' => 'success',  'invitations' => $invitation, ]);
                }else {

                    return response()->json(['response' => 'failed',  'message' => 'Not found any invitations']);

                }
            } else {

                return response()->json(['user_exists' => 'false']);
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


    // specialities

    public function DepartmentList()
    {
        $departments = Department::where('status','<>',2)->select('id','department')->OrderBy('id','desc')->get();

        return response()->json(['response' => 'success', 'result' => $departments]);

    }


    public function DoctorDashboard(Request $request)
    {
        $doctor_id = $request->doctor_id;
        $date = Carbon::now()->format('Y-m-d');

        if ($doctor_id != null) {
            $date = new DateTime('today');

            $todays_appointments        = Invitation::where('doctor_id', $doctor_id)->where('meeting_date',$date)->where('status',0)->get();
            $todays_appointment_count   = Invitation::where('doctor_id', $doctor_id)->where('meeting_date',$date)->where('status',0)->where('status',0)->count('id');
            $upcoming_appointment_count = Invitation::where('doctor_id', $doctor_id)->where('meeting_date', '>' ,$date)->count('id');

            $todays_appointment_count   = Invitation::where('doctor_id', $doctor_id)->where('meeting_date',$date)->where('status',0)->count('id');
            $total_appointment_count   = Invitation::where('doctor_id', $doctor_id)->where('meeting_date', '>=' ,$date)->where('status', 0)->count('id');
            $appointment_history_count   = Invitation::where('doctor_id', $doctor_id)->where('status', 2)->count('id');


            return response()->json(['response' => 'success','todays_appointments' =>$todays_appointments, 'todays_appointment_count'=>$todays_appointment_count, 'upcoming_appointment_count' => $upcoming_appointment_count, 'total_appointment_count' => $total_appointment_count,'appointment_history_count' => $appointment_history_count]);

        } else{

            return response()->json(['response' => 'failed', 'result' => 'please enter doctor id']);
        }
    }

    public function CreateMeeting(Request $request)
    {
        $invitation_id = $request->invitation_id;
        $meeting_id    = $request->meeting_id;
        $token         = $request->token;

        if($invitation_id != null && $meeting_id!= null && $token != null){

            $meeting_details                = new MeetingDetails();
            $meeting_details->invitation_id = $invitation_id;
            $meeting_details->meeting_id    = $meeting_id ?? "";
            $meeting_details->token         = $token ?? "";
            $meeting_details->created_at    =Carbon::now('Asia/Kolkata');
            $meeting_details->save();

            return response()->json(['response' => 'success', 'result' => $meeting_details]);

        } else {

            return response()->json(['response' => 'failed', 'message' => 'please enter the required fields']);

        }

    }

    public function UpdateMeetingStatus(Request $request)
    {
        // 0= started, 1-accepted, 2-end

        $invitation_id = $request->invitation_id;
        $status        = $request->status;

        if($invitation_id != null && $status != null){

            $invitation_exists = MeetingDetails::where('invitation_id',$invitation_id)->where('status','<>',2)->exists();

            if($invitation_exists == 1){

                MeetingDetails::where('invitation_id', $invitation_id)->update([

                    'status' => $status,

                ]);

                if($status == 2){

                    Invitation::findOrFail($invitation_id)->update([

                        'status' => $status,
                    ]);
                }

                $meeting_details = MeetingDetails::where('invitation_id', $invitation_id)->get();

                return response()->json(['response' => 'success', 'result' => $meeting_details]);
            } else {

             return response()->json(['response' => 'failed', 'message' => 'invitation not found']);
            }

        } else {

            return response()->json(['response' => 'failed', 'message' => 'please enter the required fields']);

        }

    }

    public function GetConsultationFee(Request $request)
    {
        $doctor_id = $request->doctor_id;

        if($doctor_id != null ){

            $doctor_exists = Doctor::where('id',$doctor_id)->where('status',1)->where('is_verified',1)->exists();

            if($doctor_exists == 1){

                $consultation_fee = Doctor::where('id', $doctor_id)->pluck('consultation_fee')->first();

                if($consultation_fee != null){

                    $fee  = $consultation_fee;

                } else {

                    $fee  = Settings::pluck('consultation_fee')->first();
                }
                return response()->json(['response' => 'success', 'consultation fee' => $fee]);

            } else {

                return response()->json(['response' => 'failed', 'message' => 'user not found']);
            }

        } else {
            return response()->json(['response' => 'failed', 'message' => 'please enter doctor id']);

        }

    }

    public function AddPrescription(Request $request)
    {
        $data = [
            'chief_complaints'    => $request->chief_complaints,
            'diagnosis'           => $request->diagnosis,
            'points_from_history' => $request->points_from_history,
            'lab_findings'        => $request->lab_findings,
            'investigations'      => $request->investigations,
            'instructions'        => $request->instructions,
            'notes'               => $request->notes,
        ];

        $isEmpty = empty(array_filter($data, function ($value) {
            return !empty($value);
        }));

        $meeting_id = $request->meeting_id;

        $prescriptionARR = $request->prescriptions;

        if($meeting_id != null)
        {
            $check_id = MeetingDetails::where('id',$meeting_id)->exists();

            if($check_id == 1){

                $check_info = MeetingInfo::where('meeting_id',$meeting_id)->exists();

                if($check_info == 0){

                    $invitation_id = MeetingDetails::where('id',$meeting_id)->pluck('invitation_id')->first();

                    if (!$isEmpty) {

                        $meeting_info                      = new MeetingInfo();
                        $meeting_info->meeting_id          = $meeting_id;
                        $meeting_info->invitation_id       = $invitation_id;
                        $meeting_info->chief_complaints    = $request->chief_complaints ?? "";
                        $meeting_info->diagnosis           = $request->diagnosis?? "";
                        $meeting_info->points_from_history = $request->points_from_history?? "";
                        $meeting_info->lab_findings        = $request->lab_findings?? "";
                        $meeting_info->investigations      = $request->investigations?? "";
                        $meeting_info->instructions        = $request->instructions?? "";
                        $meeting_info->notes               = $request->notes?? "";
                        $meeting_info->status              = 1;
                        $meeting_info->created_at          = Carbon::now('Asia/Kolkata');
                        $meeting_info->save();

                    }

                    else {

                     return response()->json(['response' => 'failed']);

                    }
                }

                $meeting_info_id  = MeetingInfo::where('meeting_id',$meeting_id)->pluck('id')->first();
                $invitation_id    = MeetingInfo::where('meeting_id',$meeting_id)->pluck('invitation_id')->first();

                if($meeting_info_id == 1){

                    Invitation::where('id',$invitation_id)->update([

                        'follow_up'  => $request->follow_up,

                    ]);

                    foreach ($prescriptionARR as $prescription) {

                        if ($prescription['medicine_name'] != 0  && $prescription['drug_form'] != 0 && $prescription['strength'] != 0 && $prescription['duration'] != 0) {

                                MeetingPrescription::insert([

                                    'meeting_info_id'  => $meeting_info_id,
                                    'medicine_name'    => $prescription['medicine_name'],
                                    'drug_form'        => $prescription['drug_form'],
                                    'strength'         => $prescription['strength'],
                                    'duration'         => $prescription['duration'],
                                ]);

                        } else {
                        return response()->json(['response' => 'failed', 'message' => 'please enter required fields']);
                        }
                    }
                }

                $meeting_information = MeetingInfo::where('meeting_id',$meeting_id)->get();
                $prescriptions       = MeetingPrescription::where('meeting_info_id',$meeting_info_id)->get();

                return response()->json(['response' => 'success', 'meeting_info'=>$meeting_information, 'prescriptions' => $prescriptions ]);

            } else {

                return response()->json(['response' => 'failed','message' =>'meeting_id does not exist']);
            }

        } else {

            return response()->json(['response' => 'failed', 'message' => 'please enter required fields']);
        }

    }

    public function DeletePrescription(Request $request)
    {
        $prescription_id = $request->id;
        $check_id        = MeetingPrescription::where('id', $prescription_id)->exists();

        if($check_id == 1)
        {
            MeetingPrescription::where('id',$prescription_id)->delete();

            return response()->json(['response' => 'success']);

        } else {

            return response()->json(['response' => 'failed','message' =>'id does not exist']);

        }


    }

    public function ViewPrescription(Request $request)
    {
        $meeting_id = $request->meeting_id;

        if($meeting_id != null){

            $check_id = MeetingInfo::where('meeting_id',$meeting_id)->exists();

            if($check_id == 1){

                $meeting_info_id     = MeetingInfo::where('meeting_id',$meeting_id)->pluck('id')->first();
                $meeting_information = MeetingInfo::where('id',$meeting_info_id)->get();
                $prescriptions       = MeetingPrescription::where('meeting_info_id',$meeting_info_id)->get();

                return response()->json(['response' => 'success','meeting_information' => $meeting_information, 'prescriptions' => $prescriptions]);

            }else {
                return response()->json(['response' => 'failed','message' =>'meeting_id does not exist']);
            }

        }  else {

            return response()->json(['response' => 'failed', 'message' => 'please enter meeting_id']);
        }

    }

    public function FileUpload(Request $request)
    {
        $patient_id = $request->patient_id;
        $meeting_id = $request->meeting_id;

        if($meeting_id != null && $patient_id != null){

              $check_patient = Patient::where('id',$patient_id)->where('status','<>',2)->exists();

              if($check_patient == 1){

                 $check_meeting_id = MeetingDetails::where('id',$meeting_id)->exists();

                 if($check_meeting_id == 1){

                    if ($request->file('file_name') != null) {

                        $file       = $request->file('file_name');
                        $file_uploads  = $file->getClientOriginalName();
                        $request->file_name->move(public_path('Images/Patients/File_Uploads'), $file_uploads);
                        $path       = "public/Images/Patients/File_Uploads/$file_uploads";
                    }else {
                        $file_uploads = "";
                    }

                    PatientFiles::insert([

                        'meeting_id'      => $meeting_id,
                        'patient_id'      => $patient_id,
                        'file_name'       => $file_uploads,
                        'file_description'=> $request->file_description ?? "",
                        'status'          => 1,
                        'created_at'      => Carbon::now('Asia/Kolkata'),
                    ]);

                    $files = PatientFiles::where('meeting_id',$meeting_id)->orderBy('id','desc')->get();

                    return response()->json(['response' => 'success','result' => $files]);


                 }else {

                    return response()->json(['response' => 'failed','message' =>'meeting does not exist']);

                  }

              } else {

                return response()->json(['response' => 'failed','message' =>'patient does not exist']);

              }

        } else {

            return response()->json(['response' => 'failed', 'message' => 'please enter required fields']);
        }

    }

    public function ViewFiles(Request $request)
    {
        $meeting_id = $request->meeting_id;

        if($meeting_id != null ){

            $check_meeting_id = MeetingDetails::where('id',$meeting_id)->exists();

            if($check_meeting_id == 1){

                $files = PatientFiles::where('meeting_id',$meeting_id)->orderBy('id','desc')->get();

                return response()->json(['response' => 'success','result' => $files]);

            } else {

                return response()->json(['response' => 'failed','message' =>'meeting does not exist']);
            }

        }else {
            return response()->json(['response' => 'failed', 'message' => 'please enter required fields']);
        }
    }

    public function MeetingHistory(Request $request)
    {
        $user_id   = $request->user_id;
        $user_type = $request->user_type;


        if($user_id != null && $user_type != null){

            if($user_type == 0){
                $check_user_id = Doctor::where('id',$user_id)->where('status',1)->exists();
            } else {
                $check_user_id = Patient::where('id',$user_id)->where('status',1)->exists();
            }

            if($check_user_id == 1){

            if($user_type == 0){

                $meeting_history = DB::table('invitations')
                                 ->join('patients', 'invitations.patient_id', '=', 'patients.id')
                                 ->join('members', 'invitations.member_id', '=', 'members.id')
                                 ->select('invitations.id as invitation_id','invitations.user_type','invitations.meeting_date','invitations.meeting_time','invitations.patient_id','invitations.member_id','invitations.doctor_id','members.name','members.age','members.gender','members.image','patients.profile_pic','patients.user_type')
                                 ->where('invitations.doctor_id','=',$user_id)
                                 ->where('invitations.status','=',2)
                                 ->get();

            } else {

                $meeting_history = DB::table('invitations')
                                ->join('patients', 'invitations.patient_id', '=', 'patients.id')
                                ->join('doctors', 'doctors.id', '=', 'invitations.doctor_id')
                                ->join('members', 'invitations.member_id', '=', 'members.id')
                                ->select('invitations.id as invitation_id','invitations.user_type','invitations.meeting_date','invitations.meeting_time','invitations.patient_id','invitations.member_id','invitations.doctor_id','members.name','members.age','members.gender','members.image','patients.profile_pic','patients.user_type','doctors.first_name','doctors.last_name','doctors.profile_pic as doctor_image','doctors.department_name')
                                ->where('invitations.patient_id','=',$user_id)
                                ->where('invitations.status','=',2)
                                ->get();

            }
                return response()->json(['response' => 'success','result' => $meeting_history]);

            }else {

                return response()->json(['response' => 'failed','message' =>'user does not exist']);
            }

        }else {
            return response()->json(['response' => 'failed', 'message' => 'please enter required fields']);
        }
    }

    public function DepartmentWiseFilter(Request $request)
    {
        $department_name = $request->department_name;

        if($department_name != null) {

            $check_department = Department::where('department',$department_name)->where('status',1)->exists();

            if($check_department == 1){

                $doctors = Doctor::where('department_name',$department_name)->where('status', '<>', 2)->where('is_verified',1)->get();

                return response()->json(['response' => 'success','result' => $doctors]);

            } else {

                return response()->json(['response' => 'failed','message' =>'id does not exist']);
            }

        }else {

            $doctors = Doctor::where('status', '<>', 2)->where('is_verified',1)->get();

            return response()->json(['response' => 'success','result' => $doctors]);

        }

    }

    public function InvitationDetails(Request $request)
    {
        $invitation_id = $request->invitation_id;

        if($invitation_id != null){

            $check_id = Invitation::where('id',$invitation_id)->exists();

            if($check_id == 1){

                $meeting_details = Invitation::with('doctor','patient','members')->where('id',$invitation_id)->get();

                return response()->json(['response' => 'success','result' => $meeting_details]);

            } else {

                return response()->json(['response' => 'failed','message' =>'id does not exist']);
            }

        }else {

            return response()->json(['response' => 'failed', 'message' => 'please enter required fields']);
        }

    }

    public function GeneratePDF(Request $request)
    {
        $invitation_id   = $request->invitation_id;

        if($invitation_id != null){

            $check_invitation = Invitation::where('id',$invitation_id)->exists();

            if($check_invitation == 1){

                $meeting_details = Invitation::where('id',$invitation_id)->get();

                foreach($meeting_details as $item){

                    $doctor_id  = $item->doctor_id;
                    $patient_id = $item->patient_id;
                    $member_id  = $item->member_id;

                }

                $meeting_info_id = MeetingInfo::where('invitation_id',$invitation_id)->pluck('id')->first();
                $notes           = MeetingNotes::where('meeting_info_id',$meeting_info_id)->pluck('notes');

                $doctor  = Doctor::where('id',$doctor_id)->get();
                $patient = Patient::where('id',$patient_id)->get();
                $member  = Member::where('id',$member_id)->get();
                $invitation = Invitation::where('id', $invitation_id)->get();
                $meeting_info = MeetingInfo::where('invitation_id', $invitation_id)->get();


                $data = ['notes'=> $notes, 'doctor'=> $doctor, 'patient'=> $patient, 'member'=> $member, 'invitation' =>$invitation, 'meeting_info'=>$meeting_info];
                $pdf = PDF::loadView('pdf.prescription', $data);
                return $pdf->download('prescription.pdf');
            } else {

                 return response()->json(['response' => 'failed', 'message' => 'Invitation does not exist']);
            }
        }else {

            return response()->json(['response' => 'failed']);

        }

    }

    public function GetFollowupDays(Request $request)
    {
        $doctor_id    = $request->doctor_id;
        $check_doctor = Doctor::where('id',$doctor_id)->where('is_verified',1)->where('status',1)->exists();
        if($check_doctor == 1)
        {
            $followup_days = 0;
            $days          = Doctor::where('id',$doctor_id)->pluck('followup_days')->first();

            if($days != null){

                 $followup_days = $days;

            }else {
                $days = Settings::pluck('followup_days')->first();
                $followup_days = $days;
            }
            return response()->json(['response' => 'success', 'result' => $followup_days]);

        } else {
            return response()->json(['response' => 'failed', 'message' => 'User does not exist']);
        }
    }

    public function ChangeFollowupdays(Request $request)
    {
        $doctor_id       = $request->doctor_id;
        $followup_days   = $request->followup_days;

        if($doctor_id != null && $followup_days != null)
        {
            Doctor::findOrFail($doctor_id)->update([

                'followup_days' => $followup_days,
            ]);

            return response()->json(['response' => 'success']);

        } else {
            return response()->json(['response' => 'failed', 'message' => 'please enter required fields']);
        }
    }

    public function MeetingChats(Request $request)
    {
        $invitation_id = $request->invitation_id;
        $user_type     = $request->user_type;
        $user_id       = $request->user_id;
        $type          = $request->type;
        $messages      = $request->messages;
        $file_name     = $request->file_name;

        if ($request->file('file_name') != null) {

            $file       = $request->file('file_name');
            $files   = $file->getClientOriginalName();
            $request->file_name->move(public_path('Images/chat'), $files);
            $path       = "public/Images/chat/$files";
        }

        // if($messages != null){
        //     $type = "0";

        // }else if($file_name != null){
        //     $type = "1";
        // }

        if($invitation_id != null && $user_type != null && $user_id != null && $type != null && ($messages != null || $file_name!= null )){

            $check_invitation_id = Invitation::where('id',$invitation_id)->where('status',2)->exists();

            if($check_invitation_id == 1) {

                $check_user = "";

                if($user_type == 0){
                    $check_user = Invitation::where('doctor_id',$user_id)->exists();

                } else if($user_type == 1 || $user_type ==2){
                    $check_user = Invitation::where('patient_id',$user_id)->exists();
                }else {
                    return response()->json(['response' => 'failed', 'message' => 'check user type']);
                }

                // print_r($check_user);
                // exit;

                if($check_user == 1){

                    ChatBox::insert([

                        'invitation_id' => $request->invitation_id,
                        'user_type'     => $request->user_type,
                        'user_id'       => $request->user_id,
                        'type'          => $request->type,
                        'messages'      => $request->messages ?? "",
                        'file_name'     => $files ?? "",
                        'created_at'    => Carbon::now('Asia/kolkata'),
                    ]);

                    $chats = ChatBox::where('invitation_id',$invitation_id)->orderBy('id','desc')->get();

                    return response()->json(['response' => 'success', 'result' => $chats ]);

                } else {

                    return response()->json(['response' => 'failed', 'message' => 'check user id']);
                }

            } else {
                return response()->json(['response' => 'failed', 'message' => 'invitation does not exist']);
            }
        }   else {
            return response()->json(['response' => 'failed', 'message' => 'please enter required fields']);
        }
    }


}
