# Laravel Patient Management CRM

## Project Overview
This is a simple Patient Management CRM built with **Laravel 11**.  
It includes:
- Patient CRUD operations
- User authentication with roles (Admin, CRM Agent)
- Audit trail for patient records
- API endpoints with Postman collection
- Simple UI using AdminLTE theme

---

## Live Application
- You can access the live application at: 

`http://127.0.0.1:8000/admin/dashboard`

`http://127.0.0.1:8000/login`



---

## API Endpoints

## task 2::Patient Management

`(POST) http://127.0.0.1:8000/api/patients`

- **Body:**
```json
{
  "email": "crm@example.com",       // login email
  "password": "password",          // login password
  "first_name": "John",
  "last_name": "Doe",
  "date_of_birth": "1990-05-15",
  "gender": "Male",
  "phone_number": "9876221210",
  "patient_email": "john.doe@example.com",
  "address": "123 Street, City",
  "emergency_contact_name": "Jane Doe",
  "emergency_contact_phone": "9876500000",
  "insurance_details": "policy_number INS12345 provider ABC Insurance"
}
** ```

## GET

`(GET) http://127.0.0.1:8000/api/patients`


- **Body:**
```json
{
  "email": "crm@example.com",       // login email
  "password": "password",          // login password
}

----------------------------------------------------

`(GET) http://127.0.0.1:8000/api/patients?q=9876221210 //q= [phone_number / firstname / last_name]`

body::
{
  "email": "crm@example.com",       // login email
  "password": "password",          // login password
}
-----------------------------------------------------

`( PUT / PATCH ) http://127.0.0.1:8000/api/patients/e89701d3-6eed-4727-9364-668ffac0e445`

body::
{
  "email": "crm@example.com",       // login email
  "password": "password",          // login password
  "address": "458 Street, City",
}
------------------------------------------------------

`( DELETE ) http://127.0.0.1:8000/api/patients/e89701d3-6eed-4727-9364-668ffac0e445`

body::
{
  "email": "crm@example.com",       // login email
  "password": "password",          // login password
}
-------------------------------------------------------

`##Task3: Appointment Scheduling`

`( POST ) http://127.0.0.1:8000/api/appointments`

body::
{
  "email": "admin@example.com",
  "password": "password",
  "patient_id": 1,
  "doctor_id": 1,
  "appointment_date": "2025-09-28",
  "appointment_time": "10:30:00",
  "notes": "First appointment for checkup"
}

--------------------------------------------------------

`( GET ) http://127.0.0.1:8000/api/appointments`

body::
{
  "email": "crm@example.com",       // login email
  "password": "password",          // login password
}

--------------------------------------------------------

`( GET ) http://127.0.0.1:8000/api/appointments/patient/P001`

body::
{
  "email": "crm@example.com",       // login email
  "password": "password",          // login password
}

{
  "email": "patient@example.com",       // login email
  "password": "password"          // login password
}

{
  "email": "doctor@example.com",       // login email
  "password": "password"          // login password
}

--------------------------------------------------------

`( GET ) http://127.0.0.1:8000/api/appointments/doctor/D001`

body::
{
  "email": "crm@example.com",       // login email
  "password": "password",          // login password
}

{
  "email": "doctor@example.com",       // login email
  "password": "password"          // login password
}

---------------------------------------------------------

( PUT ) http://127.0.0.1:8000/api/appointments/2

{
  "email": "doctor@example.com",       // login email
  "password": "password"          // login password
}

----------------------------------------------------------


`( DELETE ) http://127.0.0.1:8000/api/appointments/2`

{
  "email": "doctor@example.com",       // login email
  "password": "password"          // login password
}

----------------------------------------------------------

`##Task 4:: Audit Trail for Patient Records`

`http://127.0.0.1:8000/api/patients/P-DAQA/audits`

{
  "email": "admin@example.com",       // login email
  "password": "password"         // login password
}

----------------------------------------------------------

## Requirements
- PHP >= 8.1
- Composer
- MySQL or MariaDB
- Node.js & npm (for assets if needed)

---

## Installation Steps


1. Clone the repository:

```bash
git clone https://github.com/<YOUR_USERNAME>/<REPO_NAME>.git
cd <REPO_NAME>

composer install

php artisan migrate

php artisan key:generate

php artisan migrate

php artisan db:seed --class=UserSeeder

php artisan serve



