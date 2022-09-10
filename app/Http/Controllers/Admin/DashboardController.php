<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function redirectToDashboard()
    {
        return redirect()->route('admin.dashboard.index');
    }

    public function index()
    {
        return view('admin.dashboard.index');
    }
}
