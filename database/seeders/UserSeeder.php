<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Doctor;
use App\Models\Patient;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'Admin'
        ]);

        User::create([
            'name' => 'CRM Agent',
            'email' => 'crm@example.com',
            'password' => Hash::make('password'),
            'role' => 'CRM Agent'
        ]);

        $patientUser = User::create([
            'name' => 'John Doe',
            'email' => 'patient@example.com',
            'password' => Hash::make('password'),
            'role' => 'Patient',
        ]);

        Patient::create([
            'user_id' => $patientUser->id,
            'patient_id' => 'P001',
            'first_name' => 'John',
            'last_name' => 'Doe',
            'date_of_birth' => '1990-01-01',
            'gender' => 'Male',
            'phone_number' => '1234567890',
            'patient_email' => 'patient@example.com',
            'address' => 'Kolkata',
        ]);

        $doctorUser = User::create([
            'name' => 'Dr. Roy',
            'email' => 'doctor@example.com',
            'password' => Hash::make('password'),
            'role' => 'Doctor',
        ]);

        Doctor::create([
            'doctor_id'     => 'D001',
            'user_id'       => $doctorUser->id,
            'first_name'    => 'Dr.',
            'last_name'     => 'Roy',
            'specialization'=> 'Cardiology',
            'phone'         => '9876543210',
            'email'         => 'doctor@example.com',
        ]);

        User::create([
            'name' => 'Lab Manager',
            'email' => 'lab@example.com',
            'password' => Hash::make('password'),
            'role' => 'Lab Manager'
        ]);
    }
}
