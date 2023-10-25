<?php

namespace App\Http\Controllers\Api;

use App\Models\Patient;
use Illuminate\Http\Request;
use App\Models\PatientOtpHistory;
use App\Http\Controllers\Controller;

class PatientLoginController extends Controller
{
    public function CheckPhone(Request $request)
    {
        $mobile = $request->input("mobile");

        if($mobile != null){

            $user   = Patient::where('mobile', $mobile)->where('is_deleted','<>', 1)->exists();

            if($user == 0) {

                return response()->json(['user_exists' => 'false']);

            } else {

                $user_id      = Patient::where('mobile', $mobile)->pluck('id')->first();

                $otp          = new PatientOtpHistory();
                $otp->user_id = $user_id;
                $otp->otp     = random_int(1000, 9999);
                $otp->save();

                return response()->json(['user_exists' => 'true', 'otp'=> $otp]);
            }

        } else {

            return response()->json(['response' => 'failed', 'message' => "please enter phone number"  ]);

        }

    }

    public function PatientLogin(Request $request)
    {
        $otp      = $request->input("otp");
        $user_otp = PatientOtpHistory::where('otp', $otp)->where('is_used','<>', 1)->exists();

        if($otp != null) {

            if($user_otp == 1) {

                $user_id    = PatientOtpHistory::where('otp', $otp)->pluck('user_id')->first();
                $patient_id = Patient::where('id', $user_id)->where('is_deleted','<>', 1)->exists();
                $id         = PatientOtpHistory::where('otp', $otp)->pluck('id')->first();

                if($patient_id == 1){

                    $user   = Patient::where('id', $user_id)->where('is_deleted','<>', 1)->get();

                    PatientOtpHistory::findOrFail($id)->update([

                        'is_used'  => 1 ,

                    ]);

                    return response()->json(['response' => 'User created success', 'user'=> $user]);

                }

            } else {

                return response()->json(['response' => 'failed', 'message' => "check your otp"  ]);
            }

        } else {

            return response()->json(['response' => 'failed', 'message' => "please enter otp"  ]);
        }

    }

    public function PatientRegister(Request $request)
    {

        if( $request->first_name != null && $request->last_name != null && $request->mobile != null ){

         $mobile = Patient::where('mobile', $request->mobile)->where('is_deleted','<>', 1)->exists();

            if($mobile == 0){

                $patient             = new Patient();
                $patient->first_name = $request->first_name;
                $patient->last_name  = $request->last_name;
                $patient->mobile     = $request->mobile ;
                $patient->save();

                $otp          = new PatientOtpHistory();
                $otp->user_id = $patient->id;
                $otp->otp     = random_int(1000, 9999);
                $otp->save();

                return response()->json(['user_created' => 'true', 'otp'=> $otp]);

            } else {

                 return response()->json(['response' => 'failed', 'message' => "number exists" ]);
            }

        } else {

            return response()->json(['response' => 'failed', 'message' => "please enter the details"  ]);

        }
    }

    public function UpdatePatientInfo(Request $request)
    {
        if( $request->id != null ){

            $user = Patient::where('id', $request->id)->where('is_deleted','<>',1)->exists();

            if($user == 1) {

                $doctor     =  Patient::findOrFail($request->id);
                $first_name = $doctor->first_name;
                $last_name  = $doctor->last_name;
                $mobile     = $doctor->mobile;

                Patient::findOrFail($request->id)->update([

                    'first_name'  => $request->first_name ?? $first_name,
                    'last_name'   => $request->last_name ?? $last_name,
                    'mobile'      => $request->mobile ?? $mobile,

                ]);

                $updated_info = Patient::findOrFail($request->id);

                 return response()->json(['response' => 'success', 'user'=> $updated_info]);

            } else {

                 return response()->json(['user_exists' => 'false']);

            }
        } else {

            return response()->json(['response' => 'failed', 'message' => "please enter the details"  ]);

        }

    }

    public function ViewPatientsProfile(Request $request)
    {
        if( $request->id != null ) {

            $user = Patient::where('id', $request->id)->where('is_deleted','<>',1)->exists();
            if($user == 1) {

                $doctor     =  Patient::findOrFail($request->id);

                return response()->json(['user_view' => 'true', 'user'=> $doctor]);

            } else {

                return response()->json(['user_exists' => 'false']);

            }
        } else {

            return response()->json(['response' => 'failed', 'message' => "please enter id"  ]);

        }
    }

}
