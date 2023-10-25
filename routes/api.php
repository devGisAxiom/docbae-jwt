<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\DoctorLoginController;
use App\Http\Controllers\Api\PatientLoginController;

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
Route::post('/checkPhone', [DoctorLoginController::class,'CheckPhone']);
Route::post('/doctorLogin', [DoctorLoginController::class,'DoctorLogin']);
Route::post('/doctorRegister', [DoctorLoginController::class,'DoctorRegister']);
Route::post('/updateDoctorInfo', [DoctorLoginController::class,'UpdateDoctorInfo']);
Route::post('/viewDoctorsProfile', [DoctorLoginController::class,'ViewDoctorsProfile']);

// PATIENT LOGIN
Route::post('/checkPatientsPhone', [PatientLoginController::class,'CheckPatientsPhone']);
Route::post('/patientLogin', [PatientLoginController::class,'PatientLogin']);
Route::post('/patientRegister', [PatientLoginController::class,'PatientRegister']);
Route::post('/updatePatientInfo', [PatientLoginController::class,'UpdatePatientInfo']);
Route::post('/viewPatientsProfile', [PatientLoginController::class,'ViewPatientsProfile']);

