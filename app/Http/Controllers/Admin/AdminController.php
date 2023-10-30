<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function Dashboard()
    {
        return view('dashboard');
    }

    public function LoginView()
    {
        return view('login');
    }
}
