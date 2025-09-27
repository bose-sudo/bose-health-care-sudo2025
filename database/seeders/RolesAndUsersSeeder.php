<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Patient;
use App\Models\Doctor;
use Spatie\Permission\Models\Role;

class RolesAndUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // create roles
        $roles = ['Admin','CRM Agent','Doctor','Patient','Lab Manager'];
        foreach ($roles as $r) { Role::firstOrCreate(['name' => $r]); }

        // create Admin
        $admin = User::firstOrCreate(['email'=>'admin@example.com'], [
            'name' => 'Admin User',
            'password'=>bcrypt('password'),
            'role' => 'Admin'
        ]);
        $admin->assignRole('Admin');

        // CRM Agent
        $crm = User::firstOrCreate(['email'=>'crm@example.com'], [
            'name'=>'CRM Agent',
            'password'=>bcrypt('password'),
            'role' => 'CRM Agent'
        ]);
        $crm->assignRole('CRM Agent');

        // Doctor
        $docUser = User::firstOrCreate(['email'=>'doctor@example.com'], [
            'name'=>'Dr. John',
            'password'=>bcrypt('password'),
            'role' => 'Doctor',
        ]);
        $docUser->assignRole('Doctor');

        // create a doctor record and link
        $doctor = Doctor::create([
            'doctor_id'     => 'D001',
            'user_id' => $docUser->id,
            'first_name' => 'John',
            'last_name' => 'Doe',
            'specialization' => 'Cardiology',
            'email' => 'doctor@example.com'
        ]);

        // Patient
        $patientUser = User::firstOrCreate(['email'=>'patient@example.com'], [
            'name'=>'Patient One',
            'password'=>bcrypt('password'),
            'role' => 'Patient',
        ]);
        $patientUser->assignRole('Patient');

        $patient = Patient::create([
            'user_id' => $patientUser->id,
            'patient_id' => 'P001',
            'first_name' => 'Patient',
            'last_name' => 'One',
            'phone_number' => '9876543210',
            'patient_email' => 'patient@example.com',
        ]);

        // Lab Manager
        $lab = User::firstOrCreate(['email'=>'lab@example.com'], [
            'name'=>'Lab Manager',
            'password'=>bcrypt('password'),
            'role' => 'Lab Manager'
        ]);
        $lab->assignRole('Lab Manager');
    }
}

