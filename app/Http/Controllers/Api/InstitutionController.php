<?php

namespace App\Http\Controllers\Api;

use Zxing\QrReader;
use App\Models\Member;
use App\Models\Patient;
use Illuminate\Http\Request;
use App\Models\HealthCardDetails;
use Spatie\Browsershot\Browsershot;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;

class InstitutionController extends Controller
{

    public function ListStudents(Request $request)
    {
        $institute_id     = $request->institute_id;

        if($institute_id != null){

            $institution_exists = Patient::where('user_type',2)->where('id', $institute_id)->where('status','<>',2)->exists();

            if($institution_exists == 1){

                // $list_students = Member::with('blood_group','grade')->where('patient_id',$institute_id)->where('status', '<>', 2)->get();

                $list_students = Member::with('blood_group', 'grade')
                ->where('patient_id', $institute_id)
                ->where('status', '<>', 2)
                ->select('*', DB::raw('TIMESTAMPDIFF(YEAR, dob, CURDATE()) AS age'))
                ->get();

                    return response()->json(['response' => 'success', 'result' => $list_students]);

            } else {
                return response()->json(['response' => 'failed', 'message' => 'institution not exist']);

            }
        } else {
            return response()->json(['response' => 'failed', 'message' => 'please enter the required details']);

        }
    }

    public function GetHealthCard(Request $request)
    {
        $student_id   = $request->student_id;
        $mobile       = $request->mobile;

        $patient_exists   = Patient::where('mobile',$mobile)->where('status',1)->exists();

        if($patient_exists ==1){

            $user_type   = Patient::where('mobile',$mobile)->where('status',1)->pluck('user_type')->first();

            if($user_type == 1){

                $check_phone = Member::where('user_type',2)->where('id',$student_id)->where('mobile',$mobile)->exists();

                if($check_phone ==  1){

                    $url = "http://3.110.159.138/docbae/public/health-card?id=" . $student_id;
                    return Redirect::to($url);
                }else {

                    $url = "http://3.110.159.138/docbae/public/404";
                    return Redirect::to($url);
                }
            }else {

                $institute_id = Patient::where('user_type',2)->where('mobile',$mobile)->pluck('id')->first();
                $student      = Member::where('patient_id',$institute_id)->where('id',$student_id)->where('status',1)->exists();
                if($student == 1){

                    $url = "http://3.110.159.138/docbae/public/health-card?id=" . $student_id;
                    return Redirect::to($url);
                } else {

                    $url = "http://3.110.159.138/docbae/public/404";
                    return Redirect::to($url);
                }
            }

        } else {
            return response()->json(['response' => 'failed', 'message' => 'Phone number does not exist']);
        }


    }

    public function GetStudentProfile(Request $request)
    {
        $student_id   = $request->student_id;
        $mobile       = $request->mobile;

        if($student_id != null)
        {
            $institute_id = Patient::where('user_type',2)->where('mobile',$mobile)->pluck('id')->first();

            $student = Member::where('patient_id',$institute_id)->where('id',$student_id)->where('status',1)->exists();

            if($student == 1)
            {
              $student = Member::where('user_type',2)->where('id',$student_id)->where('status',1)->get();

              return response()->json(['response' => 'success', 'result' => $student]);

            } else {
                return response()->json(['response' => 'failed', 'message' => 'user not exist']);
            }

        } else {
            return response()->json(['response' => 'failed', 'message' => 'please enter the required details']);
        }

    }

}
