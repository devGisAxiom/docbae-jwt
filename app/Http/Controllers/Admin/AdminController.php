<?php

namespace App\Http\Controllers\Admin;

use Dompdf\Dompdf;
use App\Models\Admin;
use App\Models\Doctor;
use App\Models\Member;
use App\Models\Patient;
use App\Models\Settings;
use App\Models\Invitation;
use App\Models\OtpHistory;
use App\Models\MeetingInfo;
use App\Models\MeetingNotes;
use Illuminate\Http\Request;
use App\Models\MeetingDetails;
use Illuminate\Support\Carbon;
use App\Models\DoctorSchedules;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\HealthCardDetails;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Session;

class AdminController extends Controller
{
    public function Dashboard()
    {
        $doctors_count     = Doctor::where('status','<>',2)->where('is_verified',1)->count('id');
        $patients_count    = Patient::where('status','<>',2)->where('user_type',1)->count('id');
        $invitations      = Invitation::with('patient','members','doctor')->orderBy('id','desc')->where('emergency_call',0)->limit(5)->where('status',2)->get();

        // dd($appointments->toArray());

        $day    = Carbon::now()->format('D');

        if ($day == 'Mon') $week = 1;
        else if ($day == 'Tue') $week = 2;
        else if ($day == 'Wed') $week = 3;
        else if ($day == 'Thu') $week = 4;
        else if ($day == 'Fri') $week = 5;
        else if ($day == 'Sat') $week = 6;
        else if ($day == 'Sun') $week = 7;

        $schedules  = DoctorSchedules::with('doctor')->where('day_of_week',$week)->where('status','<>',2)->get();

        $otp_session = session()->get('otp_session', []);

        if(Session::has('otp_session'))
        {
            $otp_session = session()->forget('otp_session');

        }


        return view('dashboard', compact('doctors_count','patients_count','schedules','invitations'));
    }

    public function LoginView()
    {
        return view('admin.login');
    }

    public function Login(Request $request)
    {

        if($request->user_type == 0) {
            $user = Admin::where('user_name', $request->user_name)->exists();

            if($user == 1){

                $user_result = Admin::where('user_name', $request->user_name)->first();

                $decrypt_password = Crypt::decrypt($user_result->password);

                if ($request->password != $decrypt_password){

                    return back()->with('error','Invalid Email Or Password');

                }
                else{

                    $request->session()->put('user', $user_result);

                    $user = session()->get('user');

                    return redirect()->route('admin.dashboard')->with('message', 'Login Successfully');

                }
            }

            else {
                return back()->with('message','User does not exist');
            }

        } else {

            $client  = new \GuzzleHttp\Client();
            $mobile  = $request->mobile;
            $check_phone = Patient::where('mobile', $mobile)->where('status','<>',2)->exists();

            if($check_phone == 1){

                // $phone   = Patient::where('mobile', $mobile)->where('status','<>',2)->pluck('mobile')->first();
                $user_id = Patient::where('mobile', $mobile)->where('status','<>',2)->pluck('id')->first();

                $otp     = random_int(1000, 9999);
                $value   = " ".$otp." ";

                $var              = new OtpHistory();
                $var->user_id     = $user_id;
                $var->user_type   = 2;
                $var->device_type = 1;
                $var->mobile      = $mobile;
                $var->otp         = $otp;
                $var->save();

                $response      = $client->request('GET', 'https://sapteleservices.com/SMS_API/sendsms.php?apikey=95702791-6d88-11ee-a4f5-e29d2b69142c&mobile=' .$mobile. '&sendername=WELLNX&message=Dear user,' .$value. ' is your DocBae verification code.WELLNEXUS HEALTH SCIENCE LLP&routetype=1&tid=1607100000000300481');

                $otp_session    = session()->get('otp_session', []);

                $otp_session[$user_id] = [

                    "mobile"  => $mobile,
                    "otp"     => $otp,

                ];

              session()->put('otp_session', $otp_session);


                return redirect()->route('otp.get');
            } else {

                return redirect()->back();
            }

        }
    }

    public function GetOtp()
    {

        return view('admin.get_otp');
    }

    public function SubmitOtp(Request $request)
    {

        $otp_session = session()->get('otp_session', []);

        foreach ($otp_session as $item) {

            $mobile = $item['mobile'];

            $otp = $item['otp'];
        }
        if($otp == $request->otp) {

            $id  = OtpHistory::where('otp', $otp)->pluck('id')->first();
            // $id  = OtpHistory::where('otp', '1920')->pluck('id')->first();
            // $mobile = '8590018965';
            OtpHistory::findOrFail($id)->update([

                'is_used'  => 1,

            ]);

            $institute = Patient::where('mobile', $mobile)->where('status','<>',2)->first();

            $user = $request->session()->put('user', $institute);

             return redirect()->route('institute.dashboard');


        } else {

            return redirect()->back();
        }

    }



    // public function Register()
    // {
    //     return view('admin.register');
    // }

    // public function Store(Request $request)
    // {
    //     Admin::insert([

    //         'first_name' => $request->first_name,
    //         'last_name'  => $request->last_name,
    //         'role'       => 0,
    //         'user_name'  => $request->user_name,
    //         'password'   =>Crypt::encrypt($request->password),
    //         ]);

    //     return redirect()->route('admin.dashboard');

    // }

    public function Logout(Request $request)
    {
        Session::flush();
        return redirect()->route('login.view')->with('error','Logout Successfully');

    }

    public function Settings()
    {
        $settings = Settings::get();

        return view('settings.list', compact('settings'));
    }

    public function EditSettings(Request $request)
    {
        $id       = $request->id;
        $settings = Settings::findOrFail($id);

        return view('settings.edit', compact('settings'));
    }

    public function UpdateSettings(Request $request, $id)
    {
        Settings::findOrFail($id)->update([

            'consultation_fee'      => $request->consultation_fee,
            'commission_percentage' => $request->commission_percentage,
            'payment_type'          => $request->payment_type,
            'followup_days'         => $request->followup_days,

        ]);

        return redirect()->route('settings');
    }
    public function PrescriptionPdf()
    {
         return view('pdf.prescription');
    }

    public function welcome()
    {
        $invitation_id   = 2;

        if($invitation_id != null){

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

        }

        return view('welcome', compact('doctor','patient','member','invitation','meeting_info'));
    }

    public function HealthCard(Request $request)
    {
        $id         = $request->id;
        $student    = Member::findOrFail($id);
        $details_id = HealthCardDetails::where('student_id',$id)->pluck('id')->first();
        $details    = HealthCardDetails::findOrFail($details_id);

        return view('pdf.student_health_card', compact('student','details'));
    }
}
