<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\InstitutionType;
use App\Models\InstitutionSubType;
use App\Http\Controllers\Controller;
use App\Models\Patient;

class InstituteController extends Controller
{


    public function Institutes()
    {
        $user      = session()->get('user');
        $user_type = $user->user_type;
        $mobile    = $user->mobile;

        if ($user_type == 2) {

            $institutions = Patient::where('user_type', 2)->where('mobile',$mobile)->where('status','<>',2)->get();

        } else {

            $institutions = Patient::where('user_type', 2)->where('status','<>',2)->get();

        }

        return view('Institute.list_institute', compact('institutions'));
    }

    public function AddInstitute()
    {
        $institution_types     = InstitutionType::get();
        $institution_sub_types = InstitutionSubType::get();

        return view('Institute.add_institute', compact('institution_types','institution_sub_types'));
    }

    public function SaveInstitute(Request $request)
    {


        $validatedData = $request->validate([

            'mobile' => 'required|min:10|digits:10|unique:patients,mobile',
        ]);

        if ($request->profile_pic!= null) {

            $file  = $request->profile_pic;
            $pic   = $file->getClientOriginalName();
            $request->profile_pic->move(public_path('Images/Institution/Profile_picture'), $pic);
            $path       = "public/Images/Institution/Profile_picture/$pic";

        }

        if ($request->authorization_letter!= null) {

            $file  = $request->authorization_letter;
            $letter   = $file->getClientOriginalName();
            $request->authorization_letter->move(public_path('Images/Institution/Authorization_letter'), $letter);
            $path       = "public/Images/Institution/Authorization_letter/$letter";

        }
        // die();

        Patient::insert([

            'name'                  => $request->name,
            'user_type'             => 2,
            'mobile'                => $request->mobile,
            'location'              => $request->location,
            'email'                 => $request->email,
            'no_of_participants'    => $request->no_of_participants ?? 0,
            'authorization_letter'  => $letter ?? "",
            'profile_pic'           => $pic ?? "",
            'institution_type'      => $request->institution_type_id ?? 0,
            'institution_sub_type'  => $request->institution_sub_type_id ?? 0,

        ]);

        return redirect()->route('institute.list');
    }

    public function EditInstitute(Request $request)
    {
        $id = $request->id;

        $institution_types     = InstitutionType::get();
        $institution_sub_types = InstitutionSubType::get();

        $institute = Patient::findOrFail($id);

        return view('Institute.edit_institute', compact('institution_types','institution_sub_types','institute'));
    }

    public function UpdateInstitute(Request $request, $id)
    {

        $institute  =  Patient::findOrFail($request->id);

        $check_number = Patient::where('mobile', $request->mobile)->where('id','<>',$id)->exists();

        if($check_number == 1){

            $validatedData = $request->validate([

                'mobile' => 'required|min:10|digits:10|unique:patients,mobile',
            ]);
        }

        if($request->file('profile_pic')!= null){

            $imagePath = public_path('Images/Institution/Profile_picture/'.$institute->profile_pic);

            if($institute->profile_pic != null){
                unlink($imagePath);
            }

            $file       = $request->file('profile_pic');
            $pic   = $file->getClientOriginalName();
            $request->profile_pic->move(public_path('Images/Institution/Profile_picture'), $pic);
            $path       = "public/Images/Institution/Profile_picture/$pic";
        }

        if($request->file('authorization_letter')!= null){

            $imagePath = public_path('Images/Institution/Authorization_letter/'.$institute->profile_pic);

            if($institute->authorization_letter != null){
                unlink($imagePath);
            }

            $file  = $request->authorization_letter;
            $letter   = $file->getClientOriginalName();
            $request->authorization_letter->move(public_path('Images/Institution/Authorization_letter'), $letter);
            $path       = "public/Images/Institution/Authorization_letter/$letter";
        }

        Patient::findOrFail($id)->update([

            'name'                  => $request->name,
            'mobile'                => $request->mobile,
            'location'              => $request->location,
            'email'                 => $request->email,
            'no_of_participants'    => $request->no_of_participants ?? 0,
            'authorization_letter'  => $letter ?? $institute->authorization_letter,
            'profile_pic'           => $pic ?? $institute->profile_pic,
            'institution_type'      => $request->institution_type_id ?? 0,
            'institution_sub_type'  => $request->institution_sub_type_id ?? 0,

        ]);

        return redirect()->route('institute.list');
    }

    public function DeleteInstitute($id)
    {
        Patient::findOrFail($id)->update([

            'status'     => 2,
        ]);

        return redirect()->back();
    }
}
