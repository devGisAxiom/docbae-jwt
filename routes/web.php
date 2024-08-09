<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\DoctorsController;
use App\Http\Controllers\Admin\PatientsController;
use App\Http\Controllers\Admin\InstituteController;
use App\Http\Controllers\Admin\DepartmentController;
use App\Http\Controllers\Admin\StudentManagementController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('/welcome', [AdminController::class, 'welcome'])->name('welcome');

Route::get('/download', [StudentManagementController::class, 'Download'])->name('download');

Route::get('/', [AdminController::class, 'LoginView'])->name('login.view');
Route::post('/login', [AdminController::class, 'Login'])->name('login.get');
// Route::get('/register', [AdminController::class, 'Register'])->name('register.view');
// Route::post('/store', [AdminController::class, 'Store'])->name('register.store');
Route::get('/get-otp', [AdminController::class, 'GetOtp'])->name('otp.get');
Route::post('/submit-otp', [AdminController::class, 'SubmitOtp'])->name('otp.submit');
Route::get('/prescriptionPdf', [AdminController::class, 'PrescriptionPdf']);
Route::get('/404', [AdminController::class, 'ErrorPage'])->name('error');

// student health card
Route::get('/health-card', [StudentManagementController::class, 'HealthCard'])->name('healthcard');


Route::get('/logout', [AdminController::class, 'Logout'])->name('logout');

Route::prefix('admin')->middleware(['admin'])->group(function () {
   Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    // Doctors

    Route::controller(DoctorsController::class)->group(function () {

        Route::get('/doctors', 'Doctors')->name('doctors.all');
        Route::get('/doctors-schedule-list', 'DoctorScheduleList')->name('doctors.schedule_list');
        Route::get('/doctor-profile', 'DoctorProfile')->name('doctors.profile');
        Route::get('/verify-doctor', 'VerifyDoctor')->name('doctors.verify');
        Route::get('/reject-doctor', 'RejectDoctor')->name('doctors.reject');
        Route::post('/update-fee/{id}', 'UpdateFee')->name('fee.update');
        Route::get('/new-applicants', 'NewApplicants')->name('doctors.new');
        Route::get('/edit-schedule', 'EditSchedule')->name('schedule.edit');
        Route::post('/update-schedule/{id}', 'UpdateSchedule')->name('schedule.update');
        Route::get('/delete-doctor', 'DeleteDoctor')->name('doctors.delete');

    });

    // Reports

    Route::controller(ReportController::class)->group(function () {

        Route::get('/appointment-report', 'AppointmentReport')->name('report.appointment');
        Route::get('/payment-report', 'PaymentReport')->name('report.payment');
        Route::post('/payment-release', 'PaymentRelease')->name('report.payment-release');
        Route::get('/appointment-history', 'AppointmentHistory')->name('report.appointment-history');

    });

     // Doctors

     Route::get('/patients', [PatientsController::class, 'Patients'])->name('Patients.all');
     Route::get('/view-patient', [PatientsController::class, 'ViewPatients'])->name('Patient.view');
     Route::get('/invitations', [PatientsController::class, 'Appointments'])->name('appointment.list');
     Route::get('/view-appointment', [PatientsController::class, 'ViewAppointments'])->name('appointment.view');

    //  emergency call
    Route::get('/emergency-call', [PatientsController::class, 'EmergencyCall'])->name('Patients.emergency-call');

    // Specialities
    Route::get('/specialities', [DepartmentController::class, 'Speciality'])->name('department.speciality');
    Route::get('/add-speciality', [DepartmentController::class, 'AddSpeciality'])->name('speciality.add');
    Route::post('/save-speciality', [DepartmentController::class, 'StoreSpeciality'])->name('speciality.save');
    Route::get('/edit-speciality', [DepartmentController::class, 'EditSpeciality'])->name('speciality.edit');
    Route::post('/update-speciality/{id}', [DepartmentController::class, 'UpdateSpeciality'])->name('speciality.update');
    Route::get('/delete-speciality/{id}', [DepartmentController::class, 'DeleteSpeciality'])->name('speciality.delete');

    // Super Specialities
    Route::get('/super-specialities', [DepartmentController::class, 'SuperSpeciality'])->name('department.super_speciality');
    Route::get('/add-super-speciality', [DepartmentController::class, 'AddSuperSpeciality'])->name('super_speciality.add');
    Route::post('/save-super-speciality', [DepartmentController::class, 'StoreSuperSpeciality'])->name('super_speciality.save');
    Route::get('/edit-super-speciality', [DepartmentController::class, 'EditSuperSpeciality'])->name('super_speciality.edit');
    Route::post('/update-super-speciality/{id}', [DepartmentController::class, 'UpdateSuperSpeciality'])->name('super_speciality.update');
    Route::get('/delete-super-speciality/{id}', [DepartmentController::class, 'DeleteSuperSpeciality'])->name('super_speciality.delete');

    Route::get('/departments', [DepartmentController::class, 'Department'])->name('department.list');
    Route::get('/add-department', [DepartmentController::class, 'AddDepartment'])->name('department.add');
    Route::post('/save-department', [DepartmentController::class, 'StoreDepartment'])->name('department.save');
    Route::get('/edit-department', [DepartmentController::class, 'EditDepartment'])->name('department.edit');
    Route::post('/update-department/{id}', [DepartmentController::class, 'UpdateDepartment'])->name('department.update');
    Route::get('/delete-department/{id}', [DepartmentController::class, 'DeleteDepartment'])->name('department.delete');

    // institute

    Route::get('/institutes', [InstituteController::class, 'Institutes'])->name('institute.list');
    Route::get('/add-institute', [InstituteController::class, 'AddInstitute'])->name('institute.add');
    Route::post('/save-institute', [InstituteController::class, 'SaveInstitute'])->name('institute.save');
    Route::get('/edit-institute', [InstituteController::class, 'EditInstitute'])->name('institute.edit');
    Route::post('/update-institute/{id}', [InstituteController::class, 'UpdateInstitute'])->name('institute.update');
    Route::get('/delete-institute/{id}', [InstituteController::class, 'DeleteInstitute'])->name('institute.delete');


    // settings
    Route::get('/settings', [AdminController::class, 'Settings'])->name('settings');
    Route::get('/edit-settings', [AdminController::class, 'EditSettings'])->name('settings.edit');
    Route::post('/update-settings/{id}', [AdminController::class, 'UpdateSettings'])->name('settings.update');

});

Route::prefix('institute')->middleware(['admin'])->group(function () {

    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('institute.dashboard');

       // Student Management
       Route::get('/students', [StudentManagementController::class, 'StudentList'])->name('student.list');
       Route::get('/add-student', [StudentManagementController::class, 'AddStudent'])->name('student.add');
       Route::post('/save-student', [StudentManagementController::class, 'SaveStudent'])->name('student.save');
       Route::get('/edit-student', [StudentManagementController::class, 'EditStudent'])->name('student.edit');
       Route::post('/update-student/{id}', [StudentManagementController::class, 'UpdateStudent'])->name('student.update');
       Route::get('/delete-student/{id}', [StudentManagementController::class, 'DeleteStudent'])->name('student.delete');

       // Health Card
       Route::get('/add-health-card', [StudentManagementController::class, 'AddHealthCard'])->name('student.add-health-card');
       Route::post('/save-health-card/{id}', [StudentManagementController::class, 'SaveHealthCard'])->name('student.save-health-card');
       Route::get('/scan-health-card/{id}', [StudentManagementController::class, 'ScanHealthCard'])->name('student.scan-health-card');
       Route::get('/download-health-card/{id}', [StudentManagementController::class, 'DownlodHealthcard'])->name('download-health-card');


       Route::get('/invitations', [PatientsController::class, 'Appointments'])->name('institute.appointment.list');

        Route::controller(ReportController::class)->group(function () {

        Route::get('/appointment-history', 'IntitutesAppointmentReport')->name('institute.appointment-history');

        //  emergency call
        Route::get('/emergency-call', [PatientsController::class, 'EmergencyCall'])->name('institute.emergency-call');

    });
});
