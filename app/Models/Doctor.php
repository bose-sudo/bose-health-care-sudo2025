<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Doctor extends Model
{
    protected $fillable = ['doctor_id','user_id','first_name','last_name','specialization','phone','email'];

    protected static function booted()
    {
        static::creating(function ($doctor) {
            if (empty($doctor->doctor_id)) {
                do {
                    $uid = 'DOC-' . strtoupper(Str::random(8));
                } while (self::where('doctor_id', $uid)->exists());
                $doctor->doctor_id = $uid;
            }
        });
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

