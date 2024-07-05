<?php

namespace App\Http\Controllers\Api;

use App\Models\Patient;
use App\Models\Member;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\HealthCardDetails;

class InstitutionController extends Controller
{

    public function ListStudents(Request $request)
    {
        $institute_id     = $request->institute_id;

        if($institute_id != null){

            $institution_exists = Patient::where('user_type',2)->where('id', $institute_id)->where('status','<>',2)->exists();

            if($institution_exists == 1){

                $list_students = Member::with('blood_group','grade')->where('patient_id',$institute_id)->where('status', '<>', 2)->get();

                    return response()->json(['response' => 'success', 'result' => $list_students]);

            } else {
                return response()->json(['response' => 'failed', 'message' => 'institution not exist']);

            }
        } else {
            return response()->json(['response' => 'failed', 'message' => 'please enter the required details']);

        }
    }

    public function GetHealthCardWithQrcode(Request $request)
    {
        $user_id     = $request->user_id;
        $phone       = $request->phone;
        $check_phone = Member::where('user_type',2)->where('mobile',$phone)->exists();


    }
}
