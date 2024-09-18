<?php

namespace App\Http\Controllers\Api;

use App\Models\Doctor;
use App\Models\Status;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StatusController extends Controller
{
    public function GetAllStatus(Request $request)
    {
        $users  = $request->user();

        if($users != null){

            $status = Status::where('is_deleted', '<>', 1)->get();

            if ($status!=null) {

            return response()->json(['response' => 'success', 'status' => $status]);

        } else{

            return response()->json(['response' => 'failed', 'status' => []]);
            }
        } else {

            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }

    public function UpdateDoctorStatus(Request $request)
    {
        $users  = $request->user();

        if($users != null){

            $doctor_id = $users['id'];
            $status    = $request->status;

            $doctor     = Doctor::where('id', $doctor_id)->where('status',  1)->exists();
            $status_id  = Status::where('id', $status)->where('status', 1)->exists();

            if ($doctor_id != null && $status != null) {

                if ($doctor == 1 && $status_id == 1) {

                Doctor::findOrFail($request->doctor_id)->update([

                        'status'  => $status,

                    ]);

                    return response()->json(['response' => 'success']);


                } else {

                    return response()->json(['response' => 'false']);
                }

            } else {

                return response()->json(['response' => 'failed', 'message' => "please enter the details"]);
            }
        } else {

            return response()->json(['error' => 'Unauthorized'], 401);
        }

    }
}
