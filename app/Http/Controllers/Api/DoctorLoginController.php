<?php

namespace App\Http\Controllers\Api;

use App\Models\Doctor;
use Illuminate\Http\Request;
use App\Models\DoctorOtpHistory;
use App\Http\Controllers\Controller;

class DoctorLoginController extends Controller
{
    public function CheckPhone(Request $request)
    {
        $mobile = $request->input("mobile");

        if($mobile != null){

            $user   = Doctor::where('mobile', $mobile)->where('is_deleted','<>', 1)->exists();

            if($user == 0) {

                return response()->json(['user_exists' => 'false']);

            } else {

                $user_id      = Doctor::where('mobile', $mobile)->pluck('id')->first();
                // $doctor       = Doctor::where('id', $user_id)->first();

                $otp          = new DoctorOtpHistory();
                $otp->user_id = $user_id;
                $otp->otp     = random_int(1000, 9999);
                $otp->save();

                return response()->json(['user_exists' => 'true', 'otp'=> $otp]);
            }

        } else {

            return response()->json(['response' => 'failed', 'message' => "please enter phone number"  ]);

        }

    }

    public function DoctorLogin(Request $request)
    {
        $otp      = $request->input("otp");
        $user_otp = DoctorOtpHistory::where('otp', $otp)->where('is_used','<>', 1)->exists();

        if($otp != null) {

            if($user_otp == 1) {

                $user_id    = DoctorOtpHistory::where('otp', $otp)->pluck('user_id')->first();
                $doctor_id  = Doctor::where('id', $user_id)->where('is_deleted','<>', 1)->exists();
                $id         = DoctorOtpHistory::where('otp', $otp)->pluck('id')->first();

                if($doctor_id == 1){

                    $user   = Doctor::where('id', $user_id)->where('is_deleted','<>', 1)->get();

                    DoctorOtpHistory::findOrFail($id)->update([

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

    public function DoctorRegister(Request $request)
    {

        if( $request->first_name != null && $request->last_name != null && $request->mobile != null ){

         $mobile = Doctor::where('mobile', $request->mobile)->where('is_deleted','<>', 1)->exists();

            if($mobile == 0){

                if($request->file('image')!= null){
                    $file       = $request->file('image');
                    $filename   = $file->getClientOriginalName();
                    $request->image->move(public_path('Images/Doctor'),$filename);
                    $path       = "public/Images/Doctor/$filename";
                }
                else{
                    $filename = "";
                }

                $doctor             = new Doctor();
                $doctor->first_name = $request->first_name;
                $doctor->last_name  = $request->last_name;
                $doctor->email      = $request->email?? "";
                $doctor->mobile     = $request->mobile ;
                $doctor->image      = $filename;
                $doctor->save();

                $otp          = new DoctorOtpHistory();
                $otp->user_id = $doctor->id;
                $otp->otp     = random_int(1000, 9999);
                $otp->save();

                return response()->json(['user_created' => 'true', 'otp'=> $otp]);

            } else {

                 return response()->json(['response' => 'failed', 'message' => "number exists" ]);
                //  return response()->json(['number_exists' => 'true']);

            }

        } else {

            return response()->json(['response' => 'failed', 'message' => "please enter the details"  ]);

        }
    }

    public function UpdateDoctorInfo(Request $request)
    {
        if( $request->id != null ){

            $user = Doctor::where('id', $request->id)->where('is_deleted','<>',1)->exists();
            if($user == 1) {

                $doctor     =  Doctor::findOrFail($request->id);
                $first_name = $doctor->first_name;
                $last_name  = $doctor->last_name;
                $email      = $doctor->email;
                $image      = $doctor->image;
                $mobile     = $doctor->mobile;

                if(request()->hasFile('image') && request('image') != ''){

                    $imagePath = public_path('Images/Doctor/'.$doctor->image);

                    if($doctor->image != null){
                        unlink($imagePath);
                    }

                    $file       = $request->file('image');
                    $filename   = $file->getClientOriginalName();
                    $request->image->move(public_path('Images/Doctor'),$filename);
                    $path       = "public/Images/Doctor/$filename";
                }

                Doctor::findOrFail($request->id)->update([

                    'first_name'  => $request->first_name ?? $first_name,
                    'last_name'   => $request->last_name ?? $last_name,
                    'email'       => $request->email ?? $email,
                    'mobile'      => $request->mobile ?? $mobile,
                    'image'       => $filename?? $image,

                ]);

                $updated_info = Doctor::findOrFail($request->id);

                 return response()->json(['response' => 'success', 'user'=> $updated_info]);

            } else {

                 return response()->json(['user_exists' => 'false']);

            }
        } else {

            return response()->json(['response' => 'failed', 'message' => "please enter the details"  ]);

        }

    }

    public function ViewDoctorsProfile(Request $request)
    {
        if( $request->id != null ) {

            $user = Doctor::where('id', $request->id)->where('is_deleted','<>',1)->exists();
            if($user == 1) {

                $doctor     =  Doctor::findOrFail($request->id);
                return response()->json(['user_view' => 'true', 'user'=> $doctor]);

            } else {

                return response()->json(['user_exists' => 'false']);

            }
        } else {

            return response()->json(['response' => 'failed', 'message' => "please enter id"  ]);

        }
    }
}
