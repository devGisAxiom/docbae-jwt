<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\StatusController;
use App\Http\Controllers\Api\DoctorsController;
use App\Http\Controllers\Api\PatientsController;

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
Route::post('/checkPhone', [DoctorsController::class,'CheckPhone']);
Route::post('/doctorLogin', [DoctorsController::class,'DoctorLogin']);
Route::post('/doctorRegister', [DoctorsController::class,'DoctorRegister']);
Route::post('/updateDoctorInfo', [DoctorsController::class,'UpdateDoctorInfo']);
Route::post('/viewDoctorsProfile', [DoctorsController::class,'ViewDoctorsProfile']);

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

// GET ALL PATIENTS INVITATION LIST
Route::post('/getAllDoctorsInvitationList', [DoctorsController::class,'GetAllDoctorsInvitationList']);

// UPDATE DOCTOR INVITATION STATUS
Route::post('/updateDoctorsInvitationStatus', [DoctorsController::class,'UpdateDoctorsInvitationStatus']);

// GET TODAYS DOCTOR INVITATION LIST
Route::post('/getTodaysDoctorInvitationList', [DoctorsController::class,'GetTodaysDoctorInvitationList']);

// REASSIGN INVITATIONS
Route::post('/reassignInvitation', [DoctorsController::class,'ReassignInvitation']);

// GET ALL PATIENTS INVITATION LIST
Route::post('/getAllPatientsInvitationList', [PatientsController::class,'GetAllPatientsInvitationList']);


// PATIENT LOGIN
Route::post('/checkPatientsPhone', [PatientsController::class,'CheckPatientsPhone']);
Route::post('/patientLogin', [PatientsController::class,'PatientLogin']);
Route::post('/patientRegister', [PatientsController::class,'PatientRegister']);
Route::post('/updatePatientInfo', [PatientsController::class,'UpdatePatientInfo']);
Route::post('/viewPatientsProfile', [PatientsController::class,'ViewPatientsProfile']);

// STATUS
Route::post('/getAllStatus', [StatusController::class,'GetAllStatus']);

// UPDATE DOCTOR STATUS
Route::post('/updateDoctorStatus', [StatusController::class,'UpdateDoctorStatus']);



