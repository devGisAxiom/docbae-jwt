<?php

namespace App\Http\Controllers\Api;

use Helper;
use DateTime;
use App\Models\Member;
use App\Models\Patient;
use App\Models\Student;
use App\Models\BloodGroup;
use App\Models\Invitation;
use Illuminate\Http\Request;
use App\Models\MeetingDetails;
use App\Models\MembersMapping;
use App\Models\RegistrationId;
use Illuminate\Support\Carbon;
use App\Models\PatientOtpHistory;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\FamilyMemberRelation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class PatientsController extends Controller
{
    public function __construct()
    {
        Helper::GenerateUniqueId();

        $this->middleware('auth:api', ['except' => ['PatientRegister','checkPhoneNumber','UserExist']]);
    }

    public function me()
    {
        return response()->json($this->guard()->user());
    }

    public function refresh()
    {
        return $this->respondWithToken(Auth::refresh());
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => Auth::factory()->getTTL() * 60
        ]);
    }

    public function guard()
    {
        return Auth::guard();
    }


    // public function __construct()
    // {
    //     Helper::GenerateUniqueId();
    // }

    public function PatientRegister(Request $request)
    {

         $mobile       = Patient::where('mobile', $request->mobile)->where('status','<>', 2)->exists();

            if($mobile == 0){

                if ($request->file('profile_pic') != null) {
                    $file       = $request->file('profile_pic');
                    $pic   = $file->getClientOriginalName();
                    $destination1 = $request->profile_pic->move(public_path('Images/Patients/Profile_picture'), $pic);
                    $path1      = "public/Images/Patients/Profile_picture/$pic";

                }
                // passing blood type name
                $blood_type = $request->blood_group_id;

                $blood_type_id = BloodGroup::where('blood_types',$blood_type)->pluck('id')->first();

                $dateOfBirth = Carbon::parse($request->dob);
                $age = $dateOfBirth->age;

                $patient                 = new Patient();
                $patient->user_type      = 1;
                $patient->name           = $request->name;
                $patient->dob            = $request->dob ?? "";
                $patient->gender         = $request->gender ?? 0;
                $patient->blood_group_id = $blood_type_id;
                $patient->mobile         = $request->mobile;
                $patient->password       = Hash::make($request->mobile);
                $patient->address        = $request->address ?? "";
                $patient->height         = $request->height;
                $patient->weight         = $request->weight;
                $patient->lmp            = $request->lmp;
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
                    'dob'             => $request->dob ?? "",
                    'gender'          => $request->gender ?? "",
                    'relationship_id' => 7,
                    'blood_group_id'  => $blood_type_id,
                    'image'           => $pic ?? "",
                    'address'         => $request->address ?? "",
                    'height'          => $request->height,
                    'weight'          => $request->weight,
                    'lmp'             => $request->lmp,
                    'status'          => 1,
                    'unique_id'       => $unique_id,

                ]);

                $check_mobile = Member::where('mobile',$request->mobile)->exists();

                if($check_mobile == 1) {

                   $student_id   = Member::where('mobile',$request->mobile)->pluck('id')->first();
                   $institute_id = Member::where('mobile',$request->mobile)->pluck('patient_id')->first();
                   $gender       = Member::where('mobile',$request->mobile)->pluck('gender')->first();
                   if($gender == 0){
                         $relationship_id = 3;
                    }else {
                        $relationship_id = 4;
                    }

                   $ParentIdArray  = [];
                   array_push ($ParentIdArray, $patient->id);
                   array_push($ParentIdArray, $institute_id);

                   foreach($ParentIdArray as $item){

                       MembersMapping::insert([

                           'patient_id'    => $item,
                           'member_id'     => $student_id,
                           'status'        => 1,
                       ]);
                   }

                   Member::where('id',$student_id)->update([

                        'parent_id'       => $patient->id,
                        'relationship_id' => $relationship_id,

                   ]);

                }

                return response()->json(['response' => 'success', 'result'=> $patient]);

            } else {

                return response()->json(['response' => 'failed', 'message' => 'mobile number already used']);
            }

    }

    public function UpdatePatientInfo(Request $request)
    {
        $users  = $request->user();

        if($users != null){

            $id     = $users['id'];

            if( $id != null ){

                $user   = Patient::where('id', $id)->where('user_type',1)->where('status','<>',2)->exists();
                $mobile = Patient::where('id','<>',$id)->where('user_type',1)->where('mobile', $request->mobile)->where('status', '<>', 2)->exists();

                if($mobile == 0){

                    if($user == 1) {
                        $user     =  Patient::findOrFail($id);

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

                        $dateOfBirth = Carbon::parse($request->dob);
                        $age         = $dateOfBirth->age;

                        if($request->blood_group_id != null){
                            $blood_type = $request->blood_group_id;
                            $blood_type_id = BloodGroup::where('blood_types',$blood_type)->pluck('id')->first();
                        }


                        Patient::findOrFail($id)->update([

                            'name'           => $request->name ?? $user->name,
                            'dob'            => $request->dob ?? $user->dob,
                            'gender'         => $request->gender ?? $user->gender,
                            'mobile'         => $request->mobile ?? $user->mobile,
                            'address'        => $request->address ?? $user->address,
                            'height'         => $request->height ?? $user->height,
                            'weight'         => $request->weight ?? $user->weight,
                            'lmp'            => $request->lmp ?? $user->lmp,
                            'email'          => $request->email ?? $user->email,
                            'blood_group_id' => $blood_type_id ?? $user->blood_group_id,
                            'profile_pic'    => $pic ?? $user->profile_pic,

                        ]);

                        Member::where('patient_id',$request->id)->update([

                            'name'            => $request->name ?? $user->name,
                            'dob'             => $request->dob ?? $user->dob,
                            'gender'          => $request->gender ?? $user->gender,
                            'relationship_id' => 7,
                            'blood_group_id'  => $blood_type_id ?? $user->blood_group_id,
                            'image'           => $pic ?? $user->profile_pic,
                            'address'         => $request->address ?? $user->address,
                            'height'          => $request->height ?? $user->height,
                            'weight'          => $request->weight ?? $user->weight,
                            'lmp'             => $request->lmp ?? $user->lmp,

                        ]);


                        $updated_info = Patient::where('id',$id)->select('name','dob','mobile','address','email','profile_pic','blood_group_id','height','weight','lmp')->get();

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
        }else {

            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }

    public function ViewPatientsProfile(Request $request)
    {
        $users  = $request->user();

        if($users != null){

            $id  = $users['id'];

            if( $id != null ) {

                $user = Patient::where('id', $id)->where('status','<>',2)->exists();
                if($user == 1) {

                    // $user  =  Patient::findOrFail($request->id);

                    $userCollection =  Patient::where('id',$id)->get()
                                ->map(function ($user) {
                                    $dob = $user->dob;
                                    $age = Carbon::parse($dob)->age;
                                    $user->age = $age;
                                    return $user;
                                });

                if ($userCollection->isNotEmpty()) {
                    $user = $userCollection->first();
                }

                    return response()->json(['response' => 'true', 'result'=> $user]);

                } else {

                    return response()->json(['response' => 'failed','message' =>'user does not exist']);

                }
            } else {

                return response()->json(['response' => 'failed', 'message' => "please enter id"  ]);
            }
        }else {

            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }

    public function GetAllPatientsInvitationList(Request $request)
    {
        $users  = $request->user();

        if($users != null){

            $patient_id     = $users['id'];

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
        }else {

            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }

    public function AddFamilyMembers(Request $request)
    {
        $users  = $request->user();

        if($users != null){

            $patient_id       = $users['id'];
            $name             = $request->name;
            $dob              = $request->dob;
            $gender           = $request->gender;

            $blood_type      = $request->blood_group_id;
            $relationship    = $request->relationship_id;

            $blood_type_id = BloodGroup::where('blood_types',$blood_type)->pluck('id')->first();
            $relation_id   = FamilymemberRelation::where('relation',$relationship)->pluck('id')->first();

            if($patient_id != null && $name != null && $dob != null && $gender != null && $relationship != null && $blood_type != null) {

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
                    $family_member->dob             = $dob;
                    $family_member->gender          = $gender;
                    $family_member->address         = $request->address ?? "";
                    $family_member->height          = $request->height ?? 0;
                    $family_member->weight          = $request->weight ?? 0;
                    $family_member->lmp             = $request->lmp;
                    $family_member->relationship_id = $relation_id;
                    $family_member->blood_group_id  = $blood_type_id;
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
        }else {

            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }

    public function ListFamilyMembers(Request $request)
    {
        $users  = $request->user();

        if($users != null){

            $patient_id     = $users['id'];

            if($patient_id != null){

                $patient_exists = Patient::where('id', $patient_id)->where('status','<>',2)->exists();
                if($patient_exists == 1){

                $family_members = Member::where('patient_id',$patient_id)->where('status', '<>', 2)->get()
                                ->map(function ($family_members) {
                                    $dob = $family_members->dob;
                                    $age = Carbon::parse($dob)->age;
                                    $family_members->age = $age;

                                    return $family_members;
                                });

                        return response()->json(['response' => 'success', 'result' => $family_members]);

                } else {
                    return response()->json(['response' => 'failed', 'message' => 'user not exist']);

                }
            } else {
                return response()->json(['response' => 'failed', 'message' => 'please enter the required details']);

            }
        }else {

            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }


    public function ListDropDowns(Request $request)
    {
        $users  = $request->user();

        if($users != null){

            $blood_groups    = BloodGroup::get();
            $family_relation = FamilyMemberRelation::where('id','<>',7)->get();

            return response()->json(['response' => 'success', 'blood_group' => $blood_groups, 'family_relation' => $family_relation ]);
        }else {

            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }

    public function UpdateFamilyMembers(Request $request)
    {
        $users  = $request->user();

        if($users != null){

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

                    $blood_type      = $request->blood_group_id;
                    $relationship    = $request->relationship_id;

                    if($blood_type != null){
                        $blood_type_id = BloodGroup::where('blood_types',$blood_type)->pluck('id')->first();
                    }

                    if($relationship != null){
                        $relation_id   = FamilymemberRelation::where('relation',$relationship)->pluck('id')->first();
                    }

                    Member::findOrFail($request->id)->update([

                        'patient_id'      => $user->patient_id,
                        'name'            => $request->name ?? $user->name,
                        'dob'             => $request->dob?? $user->dob,
                        'gender'          => $request->gender ?? $user->gender,
                        'relationship_id' => $relation_id ?? $user->relationship_id,
                        'blood_group_id'  => $blood_type_id ?? $user->blood_group_id,
                        'image'           => $profile ?? $user->image,
                        'address'         => $request->address ?? $user->address,
                        'height'          => $request->height ?? $user->height,
                        'weight'          => $request->weight ?? $user->weight,
                        'lmp'             => $request->lmp ?? $user->lmp,

                    ]);

                    $updated_info   = Member::where('id', $request->id)->get();

                    return response()->json(['response' => 'success', 'result'=> $updated_info]);

                } else {

                    return response()->json(['response' => 'failed', 'message' => 'user does not exist']);
                }

            } else {

                return response()->json(['response' => 'failed', 'message' => "please enter the details"  ]);

            }
        }else {

            return response()->json(['error' => 'Unauthorized'], 401);
        }

    }

    public function DeleteFamilyMember(Request $request)
    {
        $users  = $request->user();

        if($users != null){

            $id            = $request->id;
            $family_member = Member::where('id', $id)->where('status', '<>', 2)->exists();

            $map_exists    = Member::where('id',$id)->where('parent_id','<>',0)->exists();

            if ($id != null) {

                if ($family_member == 1) {

                    Member::findOrFail($id)->update([

                        'status' => 2,
                    ]);

                    if($map_exists == 1){

                        $parent_id    = Member::where('id',$id)->pluck('parent_id')->first();

                        MembersMapping::findOrFail($parent_id)->update([

                            'status'    => 2,

                        ]);
                    }


                    return response()->json(['response' => 'success']);
                } else {

                    return response()->json(['response' => 'failed', 'message' => 'id does not exist']);
                }
            } else {

                return response()->json(['response' => 'failed']);
            }
        }else {

            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }

    // common
    public function MeetingDetails(Request $request)
    {

        $users  = $request->user();

        if($users != null){

            $invitation_id = $request->invitation_id;

            if($invitation_id != null){

                $meeting_details = MeetingDetails::where('invitation_id', $invitation_id)->get();

                return response()->json(['response' => 'success', 'result'=>$meeting_details]);

            } else {
                return response()->json(['response' => 'failed', 'message' => 'please enter the required fields']);

            }
        } else {

            return response()->json(['error' => 'Unauthorized'], 401);
        }


    }

    public function PatientsDashboard(Request $request)
    {
        $users  = $request->user();

        if($users != null){

            $patient_id = $users['id'];
            $date       = Carbon::now()->format('Y-m-d');

            if ($patient_id != null) {

                $check_id = Patient::where('id',$patient_id)->where('status','<>',2)->exists();

                if($check_id == 1){

                    $date = new DateTime('today');

                    $todays_appointment_count   = Invitation::where('patient_id', $patient_id)->where('meeting_date',$date)->where('status',0)->where('status',0)->count('id');

                    $total_appointment_count   = Invitation::where('patient_id', $patient_id)->where('meeting_date', '>=' ,$date)->where('status', 0)->count('id');

                    $followup_count = Invitation::where('patient_id',$patient_id)->where('follow_up',1)->where('follow_up_date','>=',$date)->count();

                    // if($user_type == 1){

                        $members_count = Member::where('patient_id',$patient_id)->where('status','<>',2)->count('id');
                    // } else {

                    //     $members_count = Student::where('institute_id',$patient_id)->where('status','<>',2)->count('id');

                    // }

                    return response()->json(['response' => 'success','todays_appointment_count'=>$todays_appointment_count, 'total_appointment_count' => $total_appointment_count,'members_count' => $members_count,'followup_count'=>$followup_count]);

                } else {

                    return response()->json(['response' => 'failed', 'result' => 'user does not exist']);
                }

            } else{

                return response()->json(['response' => 'failed', 'result' => 'please enter patient id']);
            }
        }else {

            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }

    public function PatientStatus(Request $request)
    {
        $users  = $request->user();

        if($users != null){

            $patient_id = $users['id'];

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
        }else {

            return response()->json(['error' => 'Unauthorized'], 401);
        }

    }

    public function PendingFollowup(Request $request)
    {
        $users  = $request->user();

        if($users != null){

            $date        = now()->toDateString();
            $patient_id  = $users['id'];

            if ($patient_id != null) {

                $check_invitation = Invitation::where('patient_id',$patient_id)->where('status',2)->exists();

                if($check_invitation == 1){

                    $patients_followup = Invitation::where('patient_id',$patient_id)->where('follow_up',1)->where('follow_up_date','>=',$date)->select('id','user_type','patient_id','member_id','doctor_id','meeting_date','meeting_time','follow_up','follow_up_date')->get();

                    return response()->json(['response' => 'success','result'=>$patients_followup]);
                }else {

                    return response()->json(['response' => 'failed', 'result' => 'No appointments were found for this patient']);
                }

            } else{

                return response()->json(['response' => 'failed', 'result' => 'please enter patient id']);
            }
        }else {

            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }

}
