<?php

namespace App\Http\Controllers\Api;

use DateTime;
use App\Models\Patient;
use App\Models\Student;
use App\Models\BloodGroup;
use App\Models\Invitation;
use App\Models\Member;
use Illuminate\Http\Request;
use App\Models\MeetingDetails;
use App\Models\RegistrationId;
use Illuminate\Support\Carbon;
use App\Models\PatientOtpHistory;
use App\Http\Controllers\Controller;
use App\Models\FamilyMemberRelation;
use Helper;


class PatientsController extends Controller
{

    public function __construct()
    {
        Helper::GenerateUniqueId();
    }

    public function PatientRegister(Request $request)
    {
         $mobile = Patient::where('mobile', $request->mobile)->where('status','<>', 2)->exists();

            if($mobile == 0){

                if ($request->file('profile_pic') != null) {
                    $file       = $request->file('profile_pic');
                    $pic   = $file->getClientOriginalName();
                    $destination1 = $request->profile_pic->move(public_path('Images/Patients/Profile_picture'), $pic);
                    $path1      = "public/Images/Patients/Profile_picture/$pic";

                }

                $patient                 = new Patient();
                $patient->user_type      = 1;
                $patient->name           = $request->name;
                $patient->age            = $request->age ?? 0;
                $patient->gender         = $request->gender ?? 0;
                $patient->blood_group_id = $request->blood_group_id;
                $patient->mobile         = $request->mobile;
                $patient->location       = $request->location ?? "";
                $patient->email          = $request->email ?? "";
                $patient->profile_pic    = $pic ?? "";
                $patient->save();

                $unique_id = Helper::GenerateUniqueId();

                RegistrationId::insert([

                    'patient_id'    => $patient->id,
                    'member_id'     => $patient->id,
                    'user_type'     => 1,
                    'unique_id'     => $unique_id,
                    'created_at'    => Carbon::now('Asia/Kolkata'),

                ]);

                Member::insert([

                    'user_type'       => 1,
                    'patient_id'      => $patient->id,
                    'name'            => $request->name,
                    'age'             => $request->age ?? 0,
                    'gender'          => $request->gender ?? "",
                    'relationship_id' => 7,
                    'blood_group_id'  => $request->blood_group_id,
                    'image'           => $pic ?? "",
                    'status'          => 1,
                    'unique_id'     => $unique_id,

                ]);

                return response()->json(['response' => 'success', 'result'=> $patient]);

            } else {

                return response()->json(['response' => 'failed', 'message' => 'mobile number already used']);
            }

    }

    public function UpdatePatientInfo(Request $request)
    {
        if( $request->id != null ){

            $user   = Patient::where('id', $request->id)->where('status','<>',2)->exists();
            $mobile = Patient::where('id','<>',$request->id)->where('mobile', $request->mobile)->where('status', '<>', 2)->exists();

            if($mobile == 0){

                if($user == 1) {
                    $user     =  Patient::findOrFail($request->id);

                    if($request->file('profile_pic')!= null){

                        $imagePath = public_path('Images/Patients/Profile_picture/'.$user->profile_pic);

                        if($user->profile_pic != null){
                            unlink($imagePath);
                        }

                        $file       = $request->file('profile_pic');
                        $pic   = $file->getClientOriginalName();
                        $request->profile_pic->move(public_path('Images/Patients/Profile_picture'), $pic);
                        $path       = "public/Images/Patients/Profile_picture/$pic";
                    }

                    Patient::findOrFail($request->id)->update([

                        'name'        => $request->name ?? $user->name,
                        'mobile'      => $request->mobile ?? $user->mobile,
                        'location'    => $request->location ?? $user->location,
                        'email'       => $request->email ?? $user->email,
                        'profile_pic' => $pic ?? $user->profile_pic,

                    ]);


                    $updated_info = Patient::where('id',$request->id)->select('name','mobile','location','email','profile_pic')->get();

                    return response()->json(['response' => 'success', 'result'=> $updated_info]);

                } else {

                    return response()->json(['response' => 'failed', 'message' => 'user does not exist']);

                }
            } else {

                return response()->json(['response' => 'failed', 'message' => "phone number exists"]);
            }
        } else {

            return response()->json(['response' => 'failed', 'message' => "please enter the details"  ]);

        }

    }

    public function ViewPatientsProfile(Request $request)
    {
        if( $request->id != null ) {

            $user = Patient::where('id', $request->id)->where('status','<>',2)->exists();
            if($user == 1) {

                $user  =  Patient::findOrFail($request->id);

                return response()->json(['response' => 'true', 'result'=> $user]);

            } else {

                return response()->json(['response' => 'failed','message' =>'user does not exist']);

            }
        } else {

            return response()->json(['response' => 'failed', 'message' => "please enter id"  ]);

        }
    }

    public function GetAllPatientsInvitationList(Request $request)
    {
        $patient_id     = $request->patient_id;

        if ($patient_id != null) {

            $patient    = Patient::where('id', $patient_id)->where('is_deleted', '<>', 1)->exists();

            if ($patient == 1 ) {

                $patient_invitation = Invitation::where('patient_id', $patient_id)->where('status','<>', 3)->exists();

                if($patient_invitation == 1){

                   $patientInvitation = Invitation::where('patient_id', $patient_id)->where('status','<>', 3)->get();

                   return response()->json(['response' => 'success',  'invitations' => $patientInvitation]);

                } else {

                  return response()->json(['response' => 'failed','message' => 'invitation not found']);

                }

            }else {

                return response()->json(['user_exists' => 'false']);

            }

        } else {

            return response()->json(['response' => 'failed']);

        }
    }

    public function AddFamilyMembers(Request $request)
    {
        $patient_id       = $request->patient_id;
        $name             = $request->name;
        $age              = $request->age;
        $gender           = $request->gender;
        $relationship_id  = $request->relationship_id;
        $blood_group_id   = $request->blood_group_id;

        if($patient_id != null && $name != null && $age != null && $gender != null && $relationship_id != null && $blood_group_id != null) {

            if ($request->file('image') != null) {
                $file       = $request->file('image');
                $profile   = $file->getClientOriginalName();
                $request->image->move(public_path('Images/Patients/FamilyMembers'), $profile);
                $path       = "public/Images/Patients/FamilyMembers/$profile";
            }

            $patient_exists = Patient::where('id', $patient_id)->where('status','<>',2)->exists();

            $unique_id      = Helper::GenerateUniqueId();

            if($patient_exists == 1){

                $family_member = new Member();
                $family_member->user_type       = 1;
                $family_member->patient_id      = $patient_id;
                $family_member->name            = $name;
                $family_member->age             = $age;
                $family_member->gender          = $gender;
                $family_member->relationship_id = $relationship_id;
                $family_member->blood_group_id  = $blood_group_id;
                $family_member->image           = $profile ?? "";
                $family_member->status          = 1;
                $family_member->unique_id       = $unique_id;
                $family_member->save();

                RegistrationId::insert([

                    'patient_id'    => $patient_id,
                    'member_id'     => $family_member->id,
                    'user_type'     => 1,
                    'unique_id'     => $unique_id,
                    'created_at'    => Carbon::now('Asia/Kolkata'),
                ]);

                 return response()->json(['response' => 'success']);

            } else {

                   return response()->json(['response' => 'failed', 'message' => 'user not exist']);
            }


        } else {
            return response()->json(['response' => 'failed', 'message' => 'please enter the required fields']);

        }

    }

    public function ListFamilyMembers(Request $request)
    {
        $patient_id     = $request->patient_id;

        if($patient_id != null){

            $patient_exists = Patient::where('id', $patient_id)->where('status','<>',2)->exists();
            if($patient_exists == 1){

                $family_members = Member::where('patient_id',$patient_id)->where('status', '<>', 2)->get();

                    return response()->json(['response' => 'success', 'result' => $family_members]);

            } else {
                return response()->json(['response' => 'failed', 'message' => 'user not exist']);

            }
        } else {
            return response()->json(['response' => 'failed', 'message' => 'please enter the required details']);

        }
    }


    public function ListDropDowns()
    {
        $blood_groups    = BloodGroup::get();
        $family_relation = FamilyMemberRelation::where('id','<>',7)->get();

        return response()->json(['response' => 'success', 'blood_group' => $blood_groups, 'family_relation' => $family_relation ]);

    }

    public function UpdateFamilyMembers(Request $request)
    {
        if( $request->id != null ){

            $user   = Member::where('id', $request->id)->where('status','<>',2)->exists();

            if($user == 1) {
                $user     =  Member::findOrFail($request->id);

                if($request->file('image')!= null){

                    $imagePath = public_path('Images/Patients/FamilyMembers/'.$user->image);

                    if($user->image != null){
                        unlink($imagePath);
                    }

                    if ($request->file('image') != null) {
                        $file      = $request->file('image');
                        $profile   = $file->getClientOriginalName();
                        $request->image->move(public_path('Images/Patients/FamilyMembers'), $profile);
                        $path       = "public/Images/Patients/FamilyMembers/$profile";
                    }
                }


                Member::findOrFail($request->id)->update([

                    'patient_id'      => $request->patient_id ?? $user->patient_id,
                    'name'            => $request->name ?? $user->name,
                    'age'             => $request->age?? $user->age,
                    'gender'          => $request->gender ?? $user->gender,
                    'relationship_id' => $request->relationship_id ?? $user->relationship_id,
                    'blood_group_id'  => $request->blood_group_id ?? $user->blood_group_id,
                    'image'           => $profile ?? $user->image,


                ]);

                $updated_info   = Member::where('id', $request->id)->get();

                return response()->json(['response' => 'success', 'result'=> $updated_info]);

            } else {

                return response()->json(['response' => 'failed', 'message' => 'user does not exist']);
            }

        } else {

            return response()->json(['response' => 'failed', 'message' => "please enter the details"  ]);

        }

    }

    public function DeleteFamilyMember(Request $request)
    {
        $id            = $request->id;
        $family_member = Member::where('id', $id)->where('status', '<>', 2)->exists();

        if ($id != null) {

            if ($family_member == 1) {

                Member::findOrFail($id)->update([

                    'status' => 2,
                ]);

                return response()->json(['response' => 'success']);
            } else {

                return response()->json(['response' => 'failed', 'message' => 'id does not exist']);
            }
        } else {

            return response()->json(['response' => 'failed']);
        }
    }

    public function MeetingDetails(Request $request)
    {
        $invitation_id = $request->invitation_id;

        if($invitation_id != null){

            $meeting_details = MeetingDetails::where('invitation_id', $invitation_id)->get();

            return response()->json(['response' => 'success', 'result'=>$meeting_details]);

        } else {
            return response()->json(['response' => 'failed', 'message' => 'please enter the required fields']);

        }

    }

    public function PatientsDashboard(Request $request)
    {
        $patient_id = $request->patient_id;
        // $user_type  = $request->user_type;
        $date       = Carbon::now()->format('Y-m-d');

        if ($patient_id != null) {

            $check_id = Patient::where('id',$patient_id)->where('status','<>',2)->exists();

            if($check_id == 1){

                $date = new DateTime('today');

                $todays_appointment_count   = Invitation::where('patient_id', $patient_id)->where('meeting_date',$date)->where('status',0)->where('status',0)->count('id');

                $total_appointment_count   = Invitation::where('patient_id', $patient_id)->where('meeting_date', '>=' ,$date)->where('status', 0)->count('id');

                // if($user_type == 1){

                     $members_count = Member::where('patient_id',$patient_id)->where('status','<>',2)->count('id');
                // } else {

                //     $members_count = Student::where('institute_id',$patient_id)->where('status','<>',2)->count('id');

                // }

                return response()->json(['response' => 'success','todays_appointment_count'=>$todays_appointment_count, 'total_appointment_count' => $total_appointment_count,'members_count' => $members_count]);

            } else {

                return response()->json(['response' => 'failed', 'result' => 'user does not exist']);
            }

        } else{

            return response()->json(['response' => 'failed', 'result' => 'please enter patient id']);
        }
    }

    public function PatientStatus(Request $request)
    {
        $patient_id = $request->patient_id;

        if ($patient_id != null) {

            $check_id = Patient::where('id',$patient_id)->where('status','<>',2)->exists();

            if($check_id == 1){

                Patient::where('id',$patient_id)->update([

                    'active' => $request->active,
                ]);

                $status = Patient::where('id',$patient_id)->select('active','id')->get();

                return response()->json(['response' => 'success','result'=>$status]);


            } else {

                return response()->json(['response' => 'failed', 'result' => 'user does not exist']);
            }


        }else{

            return response()->json(['response' => 'failed', 'result' => 'please enter patient id']);
        }


    }



}
