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

// DOCTOR LOGIN

Route::get('/checkPhone', [DoctorsController::class,'checkPhoneNumber']);
Route::post('/userExist', [DoctorsController::class,'UserExist']);
Route::post('/doctorRegister', [DoctorsController::class,'DoctorRegister']);
// Route::post('/updateDoctorInfo', [DoctorsController::class,'UpdateDoctorInfo']);
Route::post('/viewDoctorProfile', [DoctorsController::class,'ViewDoctorsProfile']);
Route::post('/departments', [DoctorsController::class,'DepartmentList']);
Route::post('/updateDoctorProfile', [DoctorsController::class,'UpdateDoctorProfile']);
Route::post('/doctorDashboard', [DoctorsController::class,'DoctorDashboard']);
Route::post('/getAvailableSchedule', [DoctorsController::class,'GetAvailableSchedule']);

Route::get('/generatePDF', [DoctorsController::class,'GeneratePDF']);


// DEPARTMENT WISE FILTER
Route::post('/departmentWiseFilter', [DoctorsController::class,'DepartmentWiseFilter']);


// GET CONSULTATION FEE
Route::post('/getConsultationFee', [DoctorsController::class,'GetConsultationFee']);


// GET ALL DOCTORS
Route::post('/getAllDoctors', [DoctorsController::class,'GetAllDoctors']);

// GET ALL DOCTORS
Route::post('/updateDoctorSchedule', [DoctorsController::class,'UpdateDoctorSchedule']);

// GET DOCTOR SCHEDULES
Route::post('/getDoctorScheduleDetails', [DoctorsController::class,'GetDoctorScheduleDetails']);

// DELETE DOCTOR SCHEDULES
Route::post('/deleteDoctorSchedules', [DoctorsController::class,'DeleteDoctorSchedules']);

// SEARCH DOCTOR
Route::post('/searchDoctor', [DoctorsController::class,'SearchDoctor']);

// NEW INVITATION
Route::post('/newInvitationRequest', [DoctorsController::class,'NewInvitationRequest']);

// CREATE EMERGENCY CALL
Route::post('/createEmergencyCall', [DoctorsController::class,'CreateEmergencyCall']);

// GET ALL EMERGENCY CALL
Route::post('/getEmergencyCall', [DoctorsController::class,'GetEmergencyCall']);

Route::post('/updateEmergencyCall', [DoctorsController::class,'updateEmergencyCall']);

// GET APPOINTMENTS
Route::post('/getAppointmentList', [DoctorsController::class,'GetAppointmentList']);

// UPDATE DOCTOR INVITATION STATUS
Route::post('/updateDoctorsInvitationStatus', [DoctorsController::class,'UpdateDoctorsInvitationStatus']);

// GET TODAYS DOCTOR INVITATION LIST
Route::post('/getTodaysDoctorInvitationList', [DoctorsController::class,'GetTodaysDoctorInvitationList']);

// REASSIGN INVITATIONS
Route::post('/reassignInvitation', [DoctorsController::class,'ReassignInvitation']);

// CREATE MEETING
Route::post('/createMeeting', [DoctorsController::class,'CreateMeeting']);

// UPDATE MEETING STATUS
Route::post('/updateMeetingStatus', [DoctorsController::class,'UpdateMeetingStatus']);

// ADD PRESCRIPTION
Route::post('/addPrescription', [DoctorsController::class,'AddPrescription']);

Route::post('/deletePrescription', [DoctorsController::class,'DeletePrescription']);

// VIEW NOTES
Route::post('/viewPrescription', [DoctorsController::class,'ViewPrescription']);

// ADD PRESCRIPTION
// Route::post('/addPrescription', [DoctorsController::class,'AddPrescription']);

// VIEW PRESCRIPTION
// Route::post('/viewPrescription', [DoctorsController::class,'ViewPrescription']);

// PATIENTS FILE UPLOAD
Route::post('/FileUpload', [DoctorsController::class,'FileUpload']);

Route::post('/viewFiles', [DoctorsController::class,'ViewFiles']);

// MEETING HISTORY
Route::post('/meetingHistory', [DoctorsController::class,'MeetingHistory']);

// MEETING DETAILS
Route::post('/invitationDetails', [DoctorsController::class,'InvitationDetails']);

// GET FOLLOWUP DAYS
Route::post('/getFollowupDays', [DoctorsController::class,'GetFollowupDays']);

// CHANGE FOLLOWUP DAYS
Route::post('/changeFollowupdays', [DoctorsController::class,'ChangeFollowupdays']);

// CHAT
Route::post('/meetingChats', [DoctorsController::class,'MeetingChats']);



// PATIENT LOGIN
Route::post('/checkPatientsPhone', [PatientsController::class,'CheckPatientsPhone']);
Route::post('/patientLogin', [PatientsController::class,'PatientLogin']);
Route::post('/patientRegister', [PatientsController::class,'PatientRegister']);
Route::post('/updatePatientInfo', [PatientsController::class,'UpdatePatientInfo']);
Route::post('/viewPatientsProfile', [PatientsController::class,'ViewPatientsProfile']);
Route::post('/patientsDashboard', [PatientsController::class,'PatientsDashboard']);

// PATIENT ACTIVE STATUS
Route::post('/patientStatus', [PatientsController::class,'PatientStatus']);

//GET PATIENT FOLLOWPS
Route::get('/pendingFollowup', [PatientsController::class,'PendingFollowup']);

// Add family members
Route::post('/addFamilyMembers', [PatientsController::class,'AddFamilyMembers']);
Route::post('/listFamilyMembers', [PatientsController::class,'ListFamilyMembers']);
Route::post('/updateFamilyMembers', [PatientsController::class,'UpdateFamilyMembers']);
Route::post('/deleteFamilyMember', [PatientsController::class,'DeleteFamilyMember']);
Route::post('/listDropDowns', [PatientsController::class,'ListDropDowns']);

// MEETING DETAILS
Route::post('/meetingDetails', [PatientsController::class,'MeetingDetails']);

// student
Route::post('/listStudents', [InstitutionController::class,'ListStudents']);

// add family members

// STATUS
Route::post('/getAllStatus', [StatusController::class,'GetAllStatus']);

// UPDATE DOCTOR STATUS
Route::post('/updateDoctorStatus', [StatusController::class,'UpdateDoctorStatus']);

// INSTITUTION
Route::post('/institutionProfile', [InstitutionController::class,'InstitutionProfile']);

// INSTITUTION
Route::get('/getHealthCard', [InstitutionController::class,'GetHealthCard']);

// INSTITUTION
Route::get('/getStudentProfile', [InstitutionController::class,'GetStudentProfile']);

// GET AVAILABLE DOCTORS
Route::post('/getAvailableDoctors', [DoctorsController::class,'GetAvailableDoctors']);


// GET DOCTOR TIME SLOTS
Route::post('/getDoctorTimeslote', [DoctorsController::class,'GetDoctorTimeslote']);


