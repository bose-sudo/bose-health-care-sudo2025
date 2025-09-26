<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class PatientController extends Controller
{
    
    public function index(Request $request): JsonResponse
    {
        $credentials = $request->only('email', 'password');

        if (!Auth::attempt($credentials)) {
            return response()->json(['message' => 'Invalid email or password'], 401);
        }

        $user = Auth::user();

        
        if (!in_array($user->role, ['Admin', 'CRM Agent'])) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $q = $request->query('q');
        $query = Patient::query();

        if ($q) {
            $query->where('first_name', 'like', "%$q%")
                  ->orWhere('last_name', 'like', "%$q%")
                  ->orWhere('phone_number', 'like', "%$q%");
        }

        $patients = $query->latest()->paginate(15);
        return response()->json($patients);
    }

    
    public function store(Request $request): JsonResponse
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
            'first_name'              => 'required|string|max:100',
            'last_name'               => 'required|string|max:100',
            'date_of_birth'           => 'required|date',
            'gender'                  => 'required|in:Male,Female,Other',
            'phone_number'            => 'required|string|max:20|unique:patients,phone_number',
            'patient_email'           => 'nullable|email|unique:patients,email',
            'address'                 => 'nullable|string',
            'emergency_contact_name'  => 'nullable|string|max:100',
            'emergency_contact_phone' => 'nullable|string|max:20',
            'insurance_details'       => 'nullable',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data = $validator->validated();
        $data['patient_id'] = 'P-' . strtoupper(Str::random(4));

        $patient = Patient::create($data);

        return response()->json(['message' => 'Patient created', 'data' => $patient], 201);
    }

    public function show(Request $request, string $patient_id): JsonResponse
    {
        $patienthas = Patient::where('patient_id', $patient_id)->first();

        if (!$patienthas) {
            return response()->json(['message' => 'No patient found with this ID'], 404);
        }

        $patient = Patient::where('patient_id', $patient_id)->firstOrFail();
        $credentials = $request->only('email', 'password');

        if (!Auth::attempt($credentials)) {
            return response()->json(['message' => 'Invalid email or password'], 401);
        }

        $user = Auth::user();

        if (in_array($user->role, ['Admin', 'CRM Agent', 'Doctor'])) {
           
        } elseif ($user->role === 'Patient') {
            if ($patient->user_id !== $user->id) {
                return response()->json(['message' => 'Forbidden'], 403);
            }
        } else {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        return response()->json(['data' => $patient]);
    }

    
    public function update(Request $request, string $patient_id): JsonResponse
    {
        $credentials = $request->only('email', 'password');

        if (!Auth::attempt($credentials)) {
            return response()->json(['message' => 'Invalid email or password'], 401);
        }

        $user = Auth::user();

        
        if (!in_array($user->role, ['Admin', 'CRM Agent'])) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $patienthas = Patient::where('patient_id', $patient_id)->first();

        if (!$patienthas) {
            return response()->json(['message' => 'No patient found with this ID'], 404);
        }

        $patient = Patient::where('patient_id', $patient_id)->firstOrFail();

        $validator = Validator::make($request->all(), [
            'first_name'              => 'sometimes|required|string|max:100',
            'last_name'               => 'sometimes|required|string|max:100',
            'date_of_birth'           => 'sometimes|required|date',
            'gender'                  => 'sometimes|required|in:Male,Female,Other',
            'phone_number'            => 'sometimes|required|string|max:20|unique:patients,phone_number,' . $patient->id,
            'patient_email'           => 'nullable|email|unique:patients,email,' . $patient->id,
            'address'                 => 'nullable|string',
            'emergency_contact_name'  => 'nullable|string|max:100',
            'emergency_contact_phone' => 'nullable|string|max:20',
            'insurance_details'       => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $patient->update($validator->validated());

        return response()->json(['message' => 'Patient updated', 'data' => $patient]);
    }

    public function destroy(Request $request, string $patient_id): JsonResponse
    {
        $credentials = $request->only('email', 'password');

        if (!Auth::attempt($credentials)) {
            return response()->json(['message' => 'Invalid email or password'], 401);
        }
        
        $user = Auth::user();

        
        if (!in_array($user->role, ['Admin', 'CRM Agent'])) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $patienthas = Patient::where('patient_id', $patient_id)->first();

        if (!$patienthas) {
            return response()->json(['message' => 'No patient found with this ID'], 404);
        }

        $patient = Patient::where('patient_id', $patient_id)->firstOrFail();
        $patient->delete();

        return response()->json(['message' => 'Patient deleted']);
    }
}
