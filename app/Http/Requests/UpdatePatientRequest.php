<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\Patient;

class UpdatePatientRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $patient = Patient::where('patient_id',$this->route('patient_id'))->first();

        return [
            'first_name' => ['sometimes','string','max:255'],
            'last_name' => ['sometimes','string','max:255'],
            'date_of_birth' => ['nullable','date'],
            'gender' => ['nullable', Rule::in(['Male','Female','Other'])],
            'phone_number' => ['sometimes','string', Rule::unique('patients','phone_number')->ignore($patient?->id)],
            'email' => ['nullable','email', Rule::unique('patients','email')->ignore($patient?->id)],
            'address' => ['nullable','string'],
            'emergency_contact_name' => ['nullable','string'],
            'emergency_contact_phone' => ['nullable','string'],
            'insurance_details' => ['nullable','array'],
        ];
    }

    protected function prepareForValidation()
    {
        if ($this->filled('insurance_details') && is_string($this->insurance_details)) {
            $decoded = json_decode($this->insurance_details,true);
            if (json_last_error() === JSON_ERROR_NONE) {
                $this->merge(['insurance_details'=>$decoded]);
            }
        }
    }
}
