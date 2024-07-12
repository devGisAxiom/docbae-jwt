<?php

namespace App\Http\Controllers\Api;

use Zxing\QrReader;
use App\Models\Member;
use App\Models\Patient;
use Illuminate\Http\Request;
use App\Models\HealthCardDetails;
use Spatie\Browsershot\Browsershot;
use App\Http\Controllers\Controller;

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

    public function GetHealthCard(Request $request)
    {
        $student_id   = $request->student_id;
        $mobile       = $request->mobile;
        // $phone       = "111111";

        $check_phone = Member::where('user_type',2)->where('id',$student_id)->where('mobile',$mobile)->exists();

        if($check_phone ==  1){

            return redirect()->route('healthcard', ['id' => $student_id]);
        }else {
            return redirect()->route('error');
        }


    }

    public function HealthCard(Request $request)
    {
        // $user_id     = $request->user_id;
        // $phone       = $request->phone;
        $phone       = "111111";

        // $check_phone = Member::where('user_type', 2)->where('mobile',$phone)->exists();

        $filePath = storage_path('app/public/qr-codes/qr-code-7.svg');
        $pngPath = storage_path('app/public/qr-codes/qr-code-7.png');

        // Browsershot::html("<img src='{$filePath}' />")
         Browsershot::html("<img src='{$filePath}' style='background: transparent;' />")
        ->setScreenshotType('png')
        ->save($pngPath);

        $filePath = storage_path('app/public/qr-codes/qr-code-7.png');
        $qrReader = new QrReader($filePath);
        $qrCodeContent = $qrReader->text();

        $check_phone = Member::where('user_type',2)->where('id',$qrCodeContent)->pluck('mobile')->first();

        if($phone == $check_phone){

            // $url = "http://localhost:8000/health-card?id=" . $qrCodeContent;
            $url = "http://localhost:8000/health-card?id=7";

            return redirect()->route('healthcard', ['id' => $qrCodeContent]);
        }else {
            return redirect()->route('error');
        }

        dd($qrCodeContent);
        if (file_exists($filePath)) {
            unlink($filePath);
        }


    }
}
