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

### Admin Login cradential

`email - admin@example.com`
`password - password`

`email - crm@example.com`
`password - password`

`email - patient@example.com`
`password - password`

`email - doctor@example.com`
`password - password`

`email - lab@example.com`
`password - password`

---

## API Endpoints

## task 2::Patient Management

`(POST) http://127.0.0.1:8000/api/patients`

- **Body**
```js
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
```


`(GET) http://127.0.0.1:8000/api/patients`


- **Body:**
```js
{
  "email": "crm@example.com",       // login email
  "password": "password",          // login password
}
```

`(GET) http://127.0.0.1:8000/api/patients?q=9876221210 //q= [phone_number / firstname / last_name]`

- **body**
```js
{
  "email": "crm@example.com",       // login email
  "password": "password",          // login password
}
```

`( PUT / PATCH ) http://127.0.0.1:8000/api/patients/P-6OGI`

- **body**
```js
{
  "email": "crm@example.com",       // login email
  "password": "password",          // login password
  "address": "458 Street, City",
}
```

`( DELETE ) http://127.0.0.1:8000/api/patients/P-6OGI`

- **body**
```js
{
  "email": "crm@example.com",       // login email
  "password": "password",          // login password
}
```

## Task3: Appointment Scheduling
`Schedule a new appointment`

`( POST ) http://127.0.0.1:8000/api/appointments`

- **body**
```js
{
  "email": "admin@example.com",
  "password": "password",
  "patient_id": 1, //primary key
  "doctor_id": 1, //primary key
  "appointment_date": "2025-09-28",
  "appointment_time": "10:30:00",
  "notes": "First appointment for checkup"
}

```
`List all appointments`

`( GET ) http://127.0.0.1:8000/api/appointments`

- **body**
```js
{
  "email": "crm@example.com",       // login email
  "password": "password",          // login password
}

```
`List appointments for a speciffic patient`

`( GET ) http://127.0.0.1:8000/api/appointments/patient/P001`

- **body**
```js
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

```

`( GET ) http://127.0.0.1:8000/api/appointments/doctor/D001`

- **body**
```js
{
  "email": "crm@example.com",       // login email
  "password": "password",          // login password
}

{
  "email": "doctor@example.com",       // login email
  "password": "password"          // login password
}
```

`( PUT ) http://127.0.0.1:8000/api/appointments/2`
- **body**
```js
{
  "email": "doctor@example.com",       // login email
  "password": "password"          // login password
}
```


`( DELETE ) http://127.0.0.1:8000/api/appointments/2`
- **body**
```js
{
  "email": "doctor@example.com",       // login email
  "password": "password"          // login password
}
```

## Task 4:: Audit Trail for Patient Records

`http://127.0.0.1:8000/api/patients/P-DAQA/audits`

- **body**
```js

{
  "email": "admin@example.com",       // login email
  "password": "password"         // login password
}
```
---

## Task 5: Azure Deployment Knowledge & Documentation

`1. If you are using Azure SQL Server, then`

`DB_CONNECTION=sqlsrv`
`DB_HOST=your-sql-server.database.windows.net`
`DB_PORT=1433`
`DB_DATABASE=your_database`
`DB_USERNAME=your_username`
`DB_PASSWORD=your_password`


`2. then Azure Storage (for file uploads)`

`install this packege - composer require microsoft/azure-storage-blob`

`3. .env`

AZURE_STORAGE_NAME=your_storage_account
AZURE_STORAGE_KEY=your_storage_key
AZURE_STORAGE_CONTAINER=your_container_name




---

## Requirements
- PHP >= 8.1
- Composer
- MySQL
- Node.js & npm (for assets if needed)

---

## Installation Steps


1. Clone the repository:

```bash
git clone https://github.com/<YOUR_USERNAME>/<REPO_NAME>.git
cd <REPO_NAME>

composer install

php artisan key:generate

php artisan migrate

php artisan db:seed --class=UserSeeder

php artisan serve



