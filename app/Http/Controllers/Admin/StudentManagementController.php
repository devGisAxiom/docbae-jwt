<?php

namespace App\Http\Controllers\Admin;

use Helper;
use App\Models\Grade;
use App\Models\Member;
use App\Models\BloodGroup;
use Illuminate\Http\Request;
use App\Models\RegistrationId;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use App\Helpers\CustomHelper;



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

            $unique_id  = Helper::GenerateUniqueId();

            $member                  = new Member();
            $member->user_type       = 2;
            $member->patient_id      = $institute_id;
            $member->grade_id        = $request->grade_id;
            $member->blood_group_id  = $request->blood_group_id;
            $member->name            = $request->name;
            $member->mobile          = $request->mobile ?? "";
            $member->image           = $profile ?? "";
            $member->age             = $request->age;
            $member->gender          = $request->gender;
            $member->status          = 1;
            $member->unique_id       = $unique_id;
            $member->save();


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
                'age'              => $request->age,
                'gender'           => $request->gender,
                'status'           => 1,


            ]);

        return redirect()->route('student.list');
    }

    public function DeleteStudent($id)
    {
        Member::findOrFail($id)->update([

            'status'    => 2,

        ]);

        return redirect()->route('student.list');

    }
}
