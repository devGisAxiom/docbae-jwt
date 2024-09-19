<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\StatusController;
use App\Http\Controllers\Api\DoctorsController;
use App\Http\Controllers\Api\PatientsController;
use App\Http\Controllers\Api\InstitutionController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// doctor - auth


  // DOCTOR LOGIN

  Route::get('/checkPhone', [DoctorsController::class,'checkPhoneNumber']);
  Route::post('/userExist', [DoctorsController::class,'UserExist']);

  // DOCTOR REGISTER
  Route::post('/doctorRegister', [DoctorsController::class,'DoctorRegister']);

  // PATIENT REGISTER
  Route::post('/patientRegister', [PatientsController::class,'PatientRegister']);



Route::group([

    'middleware' => 'api',
    'namespace' => 'App\Http\Controllers',
    'prefix' => 'doctor-auth'

], function ($router) {

    Route::post('/login', [DoctorsController::class,'Login']);
    // Route::post('/refresh', [DoctorsController::class,'refresh']);
    // Route::post('/me', [DoctorsController::class,'me']);

    Route::post('/viewDoctorProfile', [DoctorsController::class,'ViewDoctorsProfile']);

    Route::post('/updateDoctorSchedule', [DoctorsController::class,'UpdateDoctorSchedule']);

    Route::post('/getDoctorScheduleDetails', [DoctorsController::class,'GetDoctorScheduleDetails']);

    Route::post('/deleteDoctorSchedules', [DoctorsController::class,'DeleteDoctorSchedules']);

    // GET ALL EMERGENCY CALL
    Route::post('/getEmergencyCall', [DoctorsController::class,'GetEmergencyCall']);

    Route::post('/updateEmergencyCall', [DoctorsController::class,'updateEmergencyCall']);

    // GET APPOINTMENTS -COMMON
    Route::post('/getAppointmentList', [DoctorsController::class,'GetAppointmentList']);

    // GET TODAYS DOCTOR INVITATION LIST
    Route::post('/getTodaysDoctorInvitationList', [DoctorsController::class,'GetTodaysDoctorInvitationList']);

    Route::post('/doctorDashboard', [DoctorsController::class,'DoctorDashboard']);

    Route::post('/createMeeting', [DoctorsController::class,'CreateMeeting']);

    Route::post('/updateMeetingStatus', [DoctorsController::class,'UpdateMeetingStatus']);

    Route::post('/getConsultationFee', [DoctorsController::class,'GetConsultationFee']);

    Route::post('/addPrescription', [DoctorsController::class,'AddPrescription']);

    Route::post('/deletePrescription', [DoctorsController::class,'DeletePrescription']);

    // VIEW NOTES - COMMON
    Route::post('/viewPrescription', [DoctorsController::class,'ViewPrescription']);

    Route::post('/viewFiles', [DoctorsController::class,'ViewFiles']);

    // MEETING HISTORY - COMMON
    Route::post('/meetingHistory', [DoctorsController::class,'MeetingHistory']);

    // INVITATION DETAILS - COMMON
    Route::post('/invitationDetails', [DoctorsController::class,'InvitationDetails']);

    // GET FOLLOWUP DAYS
    Route::post('/getFollowupDays', [DoctorsController::class,'GetFollowupDays']);

    // CHANGE FOLLOWUP DAYS
    Route::post('/changeFollowupdays', [DoctorsController::class,'ChangeFollowupdays']);

    // CHAT - COMMON
    Route::post('/meetingChats', [DoctorsController::class,'MeetingChats']);

    Route::post('/updateDoctorProfile', [DoctorsController::class,'UpdateDoctorProfile']);

    Route::post('/listDropDowns', [PatientsController::class,'ListDropDowns']);

    //MEETING DETAILS - COMMON

    Route::post('/meetingDetails', [PatientsController::class,'MeetingDetails']);

    // STATUS
    Route::post('/getAllStatus', [StatusController::class,'GetAllStatus']);

    // UPDATE DOCTOR STATUS
    Route::post('/updateDoctorStatus', [StatusController::class,'UpdateDoctorStatus']);


});

// patient - auth

Route::group([

    'middleware' => 'api',
    'namespace' => 'App\Http\Controllers',
    'prefix' => 'patient-auth'

], function ($router) {

    Route::post('/viewPatientsProfile', [PatientsController::class,'ViewPatientsProfile']);

    Route::post('/updatePatientInfo', [PatientsController::class,'UpdatePatientInfo']);

    Route::post('/addFamilyMembers', [PatientsController::class,'AddFamilyMembers']);

    Route::post('/listFamilyMembers', [PatientsController::class,'ListFamilyMembers']);

    Route::post('/updateFamilyMembers', [PatientsController::class,'UpdateFamilyMembers']);

    Route::post('/deleteFamilyMember', [PatientsController::class,'DeleteFamilyMember']);

    Route::post('/patientsDashboard', [PatientsController::class,'PatientsDashboard']);

    Route::post('/patientStatus', [PatientsController::class,'PatientStatus']);

    Route::get('/pendingFollowup', [PatientsController::class,'PendingFollowup']);

    Route::post('/listDropDowns', [PatientsController::class,'ListDropDowns']);

    Route::post('/departments', [DoctorsController::class,'DepartmentList']);

    Route::get('/generatePDF', [DoctorsController::class,'GeneratePDF']);

    Route::post('/getAvailableSchedule', [DoctorsController::class,'GetAvailableSchedule']);

    Route::post('/getAllDoctors', [DoctorsController::class,'GetAllDoctors']);

    Route::post('/searchDoctor', [DoctorsController::class,'SearchDoctor']);

    Route::post('/newInvitationRequest', [DoctorsController::class,'NewInvitationRequest']);

    Route::post('/createEmergencyCall', [DoctorsController::class,'CreateEmergencyCall']);

    Route::post('/FileUpload', [DoctorsController::class,'FileUpload']);

    Route::post('/departmentWiseFilter', [DoctorsController::class,'DepartmentWiseFilter']);

    //MEETING DETAILS - COMMON
    Route::post('/meetingDetails', [PatientsController::class,'MeetingDetails']);

     // CHAT - COMMON
     Route::post('/meetingChats', [DoctorsController::class,'MeetingChats']);

     // MEETING HISTORY - COMMON
    Route::post('/meetingHistory', [DoctorsController::class,'MeetingHistory']);

    // INVITATION DETAILS - COMMON
    Route::post('/invitationDetails', [DoctorsController::class,'InvitationDetails']);

    // VIEW NOTES - COMMON
    Route::post('/viewPrescription', [DoctorsController::class,'ViewPrescription']);

    // GET APPOINTMENTS -COMMON
     Route::post('/getAppointmentList', [DoctorsController::class,'GetAppointmentList']);

    // GET AVAILABLE DOCTORS
    Route::post('/getAvailableDoctors', [DoctorsController::class,'GetAvailableDoctors']);

    // student
    Route::post('/listStudents', [InstitutionController::class,'ListStudents']);

    // INSTITUTION
     Route::get('/getHealthCard', [InstitutionController::class,'GetHealthCard']);

    //  INSTITUTION
    Route::get('/getStudentProfile', [InstitutionController::class,'GetStudentProfile']);


});






