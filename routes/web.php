<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;

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

// Route::get('/', function () {
//     return view('dashboard');
// });

Route::get('/',[AdminController::class,'LoginView'])->name('login.view');
Route::post('/login',[AdminController::class,'Login'])->name('login');

Route::get('/dashboard',[AdminController::class,'Dashboard'])->name('dashboard');


