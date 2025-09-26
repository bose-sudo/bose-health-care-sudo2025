<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\PatientAudit;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class PatientAuditController extends Controller
{
    public function index(Request $request, $patient_id)
    {
        
        $credentials = $request->only('email', 'password');
        
        if (!Auth::attempt($credentials)) {
            return response()->json(['message' => 'Invalid email or password'], 401);
        }
        $user = Auth::user();

        // $patient_id = Patient::where('patient_id', $patient_unique_id)
        //         ->pluck('id')
        //         ->first();

        if ($user->role !== 'Admin') {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $audits = PatientAudit::where('patient_unique_id', $patient_id)
            ->with('user:id,name,email')
            ->orderBy('created_at', 'desc')
            ->get();

        if ($audits->isEmpty()) {
            return response()->json(['message' => 'No audit history found'], 404);
        }

        return response()->json([
            'patient_id' => $patient_id,
            'audits'     => $audits
        ]);
    }
}
