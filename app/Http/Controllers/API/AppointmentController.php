<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;

class AppointmentController extends Controller
{
    
    public function store(Request $request)
    {
        
        $credentials = $request->only('email', 'password');
        if (!Auth::attempt($credentials)) {
            return response()->json(['message' => 'Invalid email or password'], 401);
        }
        $user = Auth::user();
        if (!in_array($user->role, ['Admin', 'CRM Agent'])) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $validator = Validator::make($request->all(), [
            'patient_id'        => 'required|exists:patients,id',
            'doctor_id'         => 'required|exists:doctors,id',
            'appointment_date'  => 'required|date',
            'appointment_time'  => 'required',
            'notes'             => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        
        $exists = Appointment::where('doctor_id', $request->doctor_id)
            ->where('appointment_date', $request->appointment_date)
            ->where('appointment_time', $request->appointment_time)
            ->exists();

        if ($exists) {
            return response()->json(['message' => 'Doctor not available at this time'], 409);
        }

        $appointment = Appointment::create($validator->validated());
        return response()->json(['message' => 'Appointment Scheduled', 'data' => $appointment], 201);
    }

    public function index(Request $request)
    {
        $credentials = $request->only('email', 'password');
        if (!Auth::attempt($credentials)) {
            return response()->json(['message' => 'Invalid email or password'], 401);
        }
        $user = Auth::user();
        if (!in_array($user->role, ['Admin', 'CRM Agent'])) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $appointments = Appointment::with(['patient','doctor'])->get();
        return response()->json($appointments);
    }

    
    public function patientAppointments(Request $request, $patient_unique_id)
    {
        $credentials = $request->only('email', 'password');
        if (!Auth::attempt($credentials)) {
            return response()->json(['message' => 'Invalid email or password'], 401);
        }
        $user = Auth::user();

        $patient_id = Patient::where('patient_id', $patient_unique_id)
                ->pluck('id')
                ->first();

        if ($user->role === 'Patient') {
            $appointments = Appointment::where('patient_id', $patient_id)
                ->where('patient_id', $user->patient->id ?? 0)
                ->with('patient')
                ->get();
            return response()->json($appointments);
        } elseif ($user->role === 'Doctor') {
            $appointments = Appointment::where('patient_id', $patient_id)
                ->where('doctor_id', $user->doctor->id ?? 0)
                ->with('doctor')
                ->get();
            return response()->json($appointments);
        } elseif (!in_array($user->role, ['Admin', 'CRM Agent', 'Patient'])) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $appointments = Appointment::with('doctor')
            ->where('patient_id', $patient_id)
            ->get();
        return response()->json($appointments);
    }


    public function doctorAppointments(Request $request, $doctor_unique_id)
    {
        $credentials = $request->only('email', 'password');
        if (!Auth::attempt($credentials)) {
            return response()->json(['message' => 'Invalid email or password'], 401);
        }
        $user = Auth::user();

        $doctor_id = Doctor::where('doctor_id', $doctor_unique_id)
                ->pluck('id')
                ->first();

        if ($user->role === 'Doctor' && $user->doctor->id !== (int)$doctor_id) {
            return response()->json(['message' => 'Forbidden'], 403);
        } elseif (!in_array($user->role, ['Admin', 'CRM Agent', 'Doctor'])) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $appointments = Appointment::with('patient')
            ->where('doctor_id', $doctor_id)
            ->get();
        return response()->json($appointments);
    }

    
    public function update(Request $request, $id)
    {
        $credentials = $request->only('email', 'password');
        if (!Auth::attempt($credentials)) {
            return response()->json(['message' => 'Invalid email or password'], 401);
        }
        $user = Auth::user();

        $appointment = Appointment::find($id);
        if (!$appointment) {
            return response()->json(['message' => 'Appointment not found'], 404);
        }

        if ($user->role === 'Doctor' && $appointment->doctor_id !== $user->doctor->id) {
            return response()->json(['message' => 'Forbidden'], 403);
        } elseif (!in_array($user->role, ['Admin', 'CRM Agent', 'Doctor'])) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $validator = Validator::make($request->all(), [
            'appointment_date'  => 'sometimes|required|date',
            'appointment_time'  => 'sometimes|required',
            'status'            => 'sometimes|required|in:Scheduled,Confirmed,Completed,Cancelled,No-Show',
            'notes'             => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        
        if ($request->has('appointment_date') && $request->has('appointment_time')) {
            $exists = Appointment::where('doctor_id', $appointment->doctor_id)
                ->where('appointment_date', $request->appointment_date)
                ->where('appointment_time', $request->appointment_time)
                ->where('id', '!=', $id)
                ->exists();

            if ($exists) {
                return response()->json(['message' => 'Doctor not available at this time'], 409);
            }
        }

        $appointment->update($validator->validated());
        return response()->json(['message' => 'Appointment Updated', 'data' => $appointment]);
    }

    
    public function destroy(Request $request, $id)
    {
        $credentials = $request->only('email', 'password');
        if (!Auth::attempt($credentials)) {
            return response()->json(['message' => 'Invalid email or password'], 401);
        }
        $user = Auth::user();
        if (!in_array($user->role, ['Admin', 'CRM Agent'])) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $appointment = Appointment::find($id);
        if (!$appointment) {
            return response()->json(['message' => 'Appointment not found'], 404);
        }

        $appointment->delete();
        return response()->json(['message' => 'Appointment Cancelled']);
    }
}
