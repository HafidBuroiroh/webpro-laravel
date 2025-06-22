<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function dashboard(){
        return view('backend.dashboard');
    }

    public function vendordashboard(){
        return view('vendor.dashboard');
    }
}
