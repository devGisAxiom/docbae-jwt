<?php

namespace App\Http\Controllers\Admin;

use Helper;
use App\Models\Grade;
use App\Models\Member;
use App\Models\Patient;
use App\Models\BloodGroup;
use Illuminate\Http\Request;
use App\Helpers\CustomHelper;
use App\Models\MembersMapping;
use App\Models\RegistrationId;
use Illuminate\Support\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\HealthCardDetails;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use SimpleSoftwareIO\QrCode\Facades\QrCode;



class StudentManagementController extends Controller
{

    public function StudentList()
    {
        $user         = session()->get('user');
        $institute_id = $user->id;

        $students = Member::with('grade')->where('patient_id',$institute_id)->where('status','<>',2)->get();

        return view('student.list_student', compact('students'));
    }

    public function AddStudent()
    {
        $blood_groups = BloodGroup::get();
        $grades       = Grade::get();

        return view('student.add_student', compact('blood_groups','grades'));
    }

    public function SaveStudent(Request $request)
    {
        $user         = session()->get('user');
        $institute_id = $user->id;

        if ($request->file('image') != null) {

            $file       = $request->file('image');
            $profile   = $file->getClientOriginalName();
            $request->image->move(public_path('Images/Institution/Student'), $profile);
            $path       = "public/Images/Institution/Student/$profile";
        }

            $unique_id   = Helper::GenerateUniqueId();

            $check_phone = Patient::where('mobile',$request->mobile)->where('status',1)->exists();

            if($check_phone == 1){

                $patient_id  = Patient::where('mobile',$request->mobile)->where('status',1)->pluck('id')->first();
                $parent_id   = $patient_id;

                if($request->gender == 0){
                    $relationship_id = 3;
                }else {
                    $relationship_id = 4;
                }

            }

            $member                  = new Member();
            $member->user_type       = 2;
            $member->patient_id      = $institute_id;
            $member->parent_id       = $parent_id ?? 0;
            $member->grade_id        = $request->grade_id;
            $member->blood_group_id  = $request->blood_group_id;
            $member->relationship_id = $relationship_id ?? 0;
            $member->name            = $request->name;
            $member->mobile          = $request->mobile ?? "";
            $member->image           = $profile ?? "";
            $member->dob             = $request->dob;
            $member->gender          = $request->gender;
            $member->address         = $request->address ?? "";
            $member->height          = $request->height ?? 0;
            $member->weight          = $request->weight ?? 0;
            $member->lmp             = $request->lmp;
            $member->status          = 1;
            $member->unique_id       = $unique_id;
            $member->save();

            if($check_phone == 1){

                $ParentIdArray  = [];
                array_push ($ParentIdArray, $patient_id);
                array_push($ParentIdArray, $institute_id);

                foreach($ParentIdArray as $item){

                    MembersMapping::insert([

                        'patient_id'    => $item,
                        'member_id'     => $member->id,
                        'status'        => 1,
                    ]);
                }
            }

            RegistrationId::insert([

                'patient_id'    => $institute_id,
                'member_id'     => $member->id,
                'user_type'     => 2,
                'unique_id'     => $unique_id,
                'created_at'    => Carbon::now('Asia/Kolkata'),

            ]);

            return redirect()->route('student.list');
    }

    public function EditStudent(Request $request)
    {
        $id           = $request->id;
        $blood_groups = BloodGroup::get();
        $grades       = Grade::get();
        $student      = Member::findOrFail($id);

        return view('student.edit_student', compact('student','blood_groups','grades'));
    }

    public function UpdateStudent(Request $request, $id)
    {
        // dd($request->dob);

        $student = Member::findOrFail($id);

        if($request->file('image')!= null){

            $imagePath = public_path('Images/Institution/Student/'.$student->image);

            if($student->image != null){
                unlink($imagePath);
            }

            if ($request->file('image') != null) {
                $file       = $request->file('image');
                $profile   = $file->getClientOriginalName();
                $request->image->move(public_path('Images/Institution/Student'), $profile);
                $path       = "public/Images/Institution/Student/$profile";
            }
        }

         Member::findOrFail($id)->update([

                'grade_id'         => $request->grade_id,
                'blood_group_id'   => $request->blood_group_id,
                'name'             => $request->name,
                'mobile'           => $request->mobile ?? "",
                'image'            => $profile ?? $student->image,
                'dob'              => $request->dob,
                'gender'           => $request->gender,
                'address'          => $request->address ?? "",
                'height'           => $request->height ?? 0,
                'weight'           => $request->weight ?? 0,
                'lmp'              => $request->lmp,
                'status'           => 1,


            ]);

        return redirect()->route('student.list');
    }

    public function DeleteStudent($id)
    {
        $patient_id = Member::where('id',$id)->pluck('patient_id')->first();
        $map_exists = MembersMapping::where('patient_id',$patient_id)->exists();

        Member::findOrFail($id)->update([

            'status'    => 2,

        ]);

        if($map_exists == 1){

            $map_id     = MembersMapping::where('patient_id',$patient_id)->pluck('id')->first();

            MembersMapping::findOrFail($map_id)->update([

                'status'    => 2,

            ]);
        }

        return redirect()->route('student.list');

    }

    public function AddHealthCard(Request $request)
    {
        $id           = $request->id;
        $student      = Member::findOrFail($id);

        return view('student.add_health_card', compact('student'));
    }

    public function HealthCard(Request $request)
    {
        $id         = $request->id;
        $student    = Member::findOrFail($id);
        $details_id = HealthCardDetails::where('student_id',$id)->pluck('id')->first();
        $details    = HealthCardDetails::findOrFail($details_id);

        return view('student.student_health_card', compact('student','details'));
    }

    public function SaveHealthCard(Request $request)
    {

        $id = $request->id;

        $past_history = $request->past_history;
        $past_historyArr = [];

        if(isset($past_history)){

            foreach($past_history as $x => $val){
                array_push($past_historyArr, $val);
            }
            $past_historyArr1 = json_encode($past_historyArr);

        }

        $any_implant_accessories = $request->any_implant_accessories;
        $any_implant_accessoriesArr = [];

        if(isset($any_implant_accessories)){

            foreach($any_implant_accessories as $x => $val){
                array_push($any_implant_accessoriesArr, $val);
            }
            $any_implant_accessoriesArr1 = json_encode($any_implant_accessoriesArr);

        }

        $hepatitis_given_on = $request->hepatitis_given_on;
        $hepatitis_given_onArr = [];

        if(isset($hepatitis_given_on)){

            foreach($hepatitis_given_on as $x => $val){
                array_push($hepatitis_given_onArr, $val);
            }
            $hepatitis_given_onArr1 = json_encode($hepatitis_given_onArr);

        }

        $typhoid_given_on = $request->typhoid_given_on;
        $typhoid_given_onArr = [];

        if(isset($typhoid_given_on)){

            foreach($typhoid_given_on as $x => $val){
                array_push($typhoid_given_onArr, $val);
            }
            $typhoid_given_onArr1 = json_encode($typhoid_given_onArr);

        }

        $tetanus_given_on = $request->tetanus_given_on;
        $tetanus_given_onArr = [];

        if(isset($tetanus_given_on)){

            foreach($tetanus_given_on as $x => $val){
                array_push($tetanus_given_onArr, $val);
            }
            $tetanus_given_onArr1 = json_encode($tetanus_given_onArr);

        }

        if($request->dt_polio_booster_given == "on"){
            $dt_polio_booster_given = 1 ;
        }else {
            $dt_polio_booster_given = 0 ;
        }

        $institute_id = Member::where('id',$request->id)->pluck('patient_id')->first();

        $helath_card = HealthCardDetails::where('student_id',$request->id)->exists();

        // qrcode
        $url = "http://3.110.159.138/docbae/public/health-card?id=" . $id;
        $qrCode = QrCode::size(200)->generate($id);

        $path = 'qr-codes/';
        $filename = 'qr-code-' . $id . '.svg';

        Storage::disk('public')->put($path . $filename, $qrCode);

        $publicUrl = asset('storage/' . $path . $filename);


        if($helath_card == 0){

            HealthCardDetails::insert([

                'student_id'               => $request->id,
                'institute_id'             => $institute_id,
                'fathers_name'             => $request->fathers_name,
                'fathers_occupation'       => $request->fathers_occupation,
                'mothers_name'             => $request->mothers_name,
                'mothers_occupation'       => $request->mothers_occupation,
                'email'                    => $request->email,
                'pincode'                  => $request->pincode,
                'additional_mobile'        => $request->additional_mobile ?? "",
                'family_physician_details' => $request->family_physician_details ?? "",
                'physician_phone'          => $request->physician_phone ?? "",
                'past_history'             => $past_historyArr1 ?? "",
                'remarks'                  => $request->remarks ?? "",
                'past_medical_history'     => $request->past_medical_history ?? "",
                'any_implant_accessories'  => $any_implant_accessoriesArr1 ?? "",
                'rt_and_lt'                => $request->rt_and_lt ?? "",
                'hepatitis_given_on'       => $hepatitis_given_onArr1 ?? "",
                'typhoid_given_on'         => $typhoid_given_onArr1 ?? "",
                'tetanus_given_on'         => $tetanus_given_onArr1 ?? "",
                'dt_polio_booster_given'   => $dt_polio_booster_given ?? "",
                'present_complaint'        => $request->present_complaint ?? "",
                'current_medication'       => $request->current_medication ?? "",
                'qrcode'                   => $filename ?? "",
                'created_at'               => Carbon::now('asia/kolkata'),

            ]);
        }else {

            $helath_card_id = HealthCardDetails::where('student_id',$request->id)->pluck('id')->first();
            $helath_card    = HealthCardDetails::findOrFail($helath_card_id);

            HealthCardDetails::findOrFail($helath_card_id)->update([

                'student_id'               => $request->id,
                'institute_id'             => $institute_id,
                'fathers_name'             => $request->fathers_name,
                'fathers_occupation'       => $request->fathers_occupation,
                'mothers_name'             => $request->mothers_name,
                'mothers_occupation'       => $request->mothers_occupation,
                'email'                    => $request->email,
                'pincode'                  => $request->pincode,
                'additional_mobile'        => $request->additional_mobile ?? 0,
                'family_physician_details' => $request->family_physician_details ?? "",
                'physician_phone'          => $request->physician_phone ?? "",
                'past_history'             => $past_historyArr1 ?? "",
                'remarks'                  => $request->remarks ?? "",
                'past_medical_history'     => $request->past_medical_history ?? "",
                'any_implant_accessories'  => $any_implant_accessoriesArr1 ?? "",
                'rt_and_lt'                => $request->rt_and_lt ?? "",
                'hepatitis_given_on'       => $hepatitis_given_onArr1 ?? "",
                'typhoid_given_on'         => $typhoid_given_onArr1 ?? "",
                'tetanus_given_on'         => $tetanus_given_onArr1 ?? "",
                'dt_polio_booster_given'   => $dt_polio_booster_given,
                'present_complaint'        => $request->present_complaint ?? "",
                'current_medication'       => $request->current_medication ?? "",
                // 'qrcode'                   => $filename ?? "",
                'created_at'               => Carbon::now('asia/kolkata'),

            ]);
        }

        return redirect()->route('student.list');
    }



    public function ScanHealthCard(Request $request)
    {
        $id      = $request->id;
        $student = Member::with('patient')->findOrFail($id);

        return view('student.scan-health-card',compact('student'));
    }

    // public function DownlodHealthcard(Request $request)
    // {
    //     $id        = $request->id;
    //     $student      = Member::with('patient')->findOrFail($id);
    //     $data   = ['student' => $student,  'image_path' => public_path('assets/Images/health-card/Health_card_Front.jpg')];

    //     $pdf = Pdf::setOptions(['defaultFont' => 'sans-serif'])->loadView('pdf.download_health_card', $data);

    //     return $pdf->download('download_health_card.pdf');

    // }

    public function DownlodHealthcard(Request $request)
    {

        $id      = $request->id;
        $student = Member::with('patient')->findOrFail($id);
        $image   = $student->image;
        $qrcode = HealthCardDetails::where('student_id', $student->id)
        ->pluck('qrcode')
        ->first();

        $data = [

            'image_path' => public_path('assets/images/Health_card_Front.jpg'),
            'profile_pic' => public_path('Images/Institution/Student/'.$image),
            'qr_code' => "http://3.110.159.138/docbae/storage/app/public/qr-codes/" . $qrcode,
            'image_path1' => public_path('assets/images/Health_card_Back.jpg'),
            'student' => $student,

        ];

        $pdf = PDF::loadView('pdf.download_health_card', $data);
        return $pdf->download('download_health_card.pdf');

    }


}
