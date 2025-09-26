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
            'name'=>'Admin User',
            'password'=>bcrypt('password'),
        ]);
        $admin->assignRole('Admin');

        // CRM Agent
        $crm = User::firstOrCreate(['email'=>'crm@example.com'], [
            'name'=>'CRM Agent',
            'password'=>bcrypt('password'),
        ]);
        $crm->assignRole('CRM Agent');

        // Doctor
        $docUser = User::firstOrCreate(['email'=>'doctor@example.com'], [
            'name'=>'Dr. John',
            'password'=>bcrypt('password'),
        ]);
        $docUser->assignRole('Doctor');

        // create a doctor record and link
        $doctor = Doctor::create([
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
        ]);
        $patientUser->assignRole('Patient');

        $patient = Patient::create([
            'user_id' => $patientUser->id,
            'first_name' => 'Patient',
            'last_name' => 'One',
            'phone_number' => '9876543210',
            'email' => 'patient@example.com',
        ]);

        // Lab Manager
        $lab = User::firstOrCreate(['email'=>'lab@example.com'], [
            'name'=>'Lab Manager',
            'password'=>bcrypt('password'),
        ]);
        $lab->assignRole('Lab Manager');
    }
}

