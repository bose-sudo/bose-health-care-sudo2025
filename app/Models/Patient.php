<?php

// app/Models/Patient.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class Patient extends Model
{
    protected $fillable = [
        'patient_id',
        'user_id',
        'first_name',
        'last_name',
        'date_of_birth',
        'gender',
        'phone_number',
        'patient_email',
        'address',
        'emergency_contact_name',
        'emergency_contact_phone',
        'insurance_details',
    ];

    protected static function booted()
    {
        static::created(function ($patient) {
            Patient::logAudit($patient, 'created', null, $patient->getAttributes());
        });

        static::updated(function ($patient) {
            Patient::logAudit($patient, 'updated', $patient->getOriginal(), $patient->getChanges());
        });

        static::deleted(function ($patient) {
            Patient::logAudit($patient, 'deleted', $patient->getOriginal(), null);
        });
    }

    protected static function logAudit($patient, $action, $oldValues, $newValues)
    {
        \App\Models\PatientAudit::create([
            'user_id'    => Auth::id() ?? null,
            'patient_id' => $patient->id,
            'patient_unique_id' => $patient->patient_id,
            'action'     => $action,
            'old_values' => $oldValues ? json_encode($oldValues) : null,
            'new_values' => $newValues ? json_encode($newValues) : null,
            'ip_address' => request()->ip(),
        ]);
    }

    public function user() 
    { 
        return $this->belongsTo(User::class); 
    }

    public function appointments() 
    { 
        return $this->hasMany(Appointment::class); 
    }
}
