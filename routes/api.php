<?php

use App\Http\Controllers\API\PatientController;
use App\Http\Controllers\API\AppointmentController;
use App\Http\Controllers\API\PatientAuditController;
// use Illuminate\Support\Facades\Route;

// Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/patients',[PatientController::class,'index']);
    Route::post('/patients',[PatientController::class,'store']);
    Route::get('/patients/{patient_id}',[PatientController::class,'show']);
    Route::match(['put','patch'],'/patients/{patient_id}',[PatientController::class,'update']);
    Route::delete('/patients/{patient_id}',[PatientController::class,'destroy']);
// });

Route::post('/appointments', [AppointmentController::class, 'store']);
Route::get('/appointments', [AppointmentController::class, 'index']);
Route::get('/appointments/patient/{patient_id}', [AppointmentController::class, 'patientAppointments']);
Route::get('/appointments/doctor/{doctor_id}', [AppointmentController::class, 'doctorAppointments']);
Route::put('/appointments/{id}', [AppointmentController::class, 'update']);
Route::delete('/appointments/{id}', [AppointmentController::class, 'destroy']);


Route::get('/patients/{patient_id}/audits', [PatientAuditController::class, 'index']);


