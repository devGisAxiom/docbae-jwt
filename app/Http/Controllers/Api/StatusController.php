<?php

namespace App\Http\Controllers\Api;

use App\Models\Doctor;
use App\Models\Status;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StatusController extends Controller
{
    public function GetAllStatus()
    {
        $status = Status::where('is_deleted', '<>', 1)->get();

        if ($status!=null) {

           return response()->json(['response' => 'success', 'status' => $status]);

       } else{

        return response()->json(['response' => 'failed', 'status' => []]);
    }
    }

    public function UpdateDoctorStatus(Request $request)
    {
        $id     = $request->input("id");
        $status = $request->input("status");

        $doctor     = Doctor::where('id', $id)->where('is_deleted', '<>', 1)->exists();
        $status_id  = Status::where('id', $status)->where('is_deleted', '<>', 1)->exists();

        if ($id != null && $status != null) {

            if ($doctor == 1 && $status_id == 1) {

               Doctor::findOrFail($request->id)->update([

                    'status'  => $status,

                ]);

                return response()->json(['response' => 'success']);


            } else {

                return response()->json(['response' => 'false']);
            }

        } else {

            return response()->json(['response' => 'failed', 'message' => "please enter the details"]);
        }


    }
}
