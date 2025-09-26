<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function admin() 
    { 
        return view('admin.dashboard');
    }

    public function crm() 
    { 
        return view('admin.dashboard');
    }

    public function doctor() 
    { 
        return view('admin.dashboard');
    }

    public function patient() 
    { 
        return view('admin.dashboard');
    }

    public function lab() 
    { 
        return view('dashboards.lab'); 
    }

}
