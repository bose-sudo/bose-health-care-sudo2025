<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    if (!auth()->check()) {
        return redirect('/login');
    }

    $user = auth()->user();

    $redirectMap = [
        'Admin'       => '/admin/dashboard',
        'CRM Agent'   => '/crm/dashboard',
        'Doctor'      => '/doctor/dashboard',
        'Patient'     => '/patient/dashboard',
        'Lab Manager' => '/lab/dashboard',
    ];

    foreach ($redirectMap as $role => $route) {
        if ($user->hasRole($role)) {
            return redirect()->intended($route);
        }
    }

    return redirect('/dashboard');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin Routes
Route::middleware(['auth', 'role:Admin'])->group(function () {
    Route::get('/admin/dashboard', [DashboardController::class, 'admin'])->name('admin.dashboard');
});

// CRM Agent Routes
Route::middleware(['auth','role:CRM Agent'])->group(function(){
    Route::get('/crm/dashboard', [DashboardController::class, 'crm'])->name('crm.dashboard');
});

// Doctor Routes
Route::middleware(['auth','role:Doctor'])->group(function(){
    Route::get('/doctor/dashboard', [DashboardController::class, 'doctor'])->name('doctor.dashboard');
});

// Patient Routes
Route::middleware(['auth','role:Patient'])->group(function(){
    Route::get('/patient/dashboard', [DashboardController::class, 'patient'])->name('patient.dashboard');
});

// Lab Manager Routes
Route::middleware(['auth','role:Lab Manager'])->group(function(){
    Route::get('/lab/dashboard', [DashboardController::class, 'lab'])->name('lab.dashboard');
});




require __DIR__.'/auth.php';
