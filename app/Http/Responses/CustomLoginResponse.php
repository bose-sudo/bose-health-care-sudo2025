<?php

namespace App\Http\Responses;

use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;

class CustomLoginResponse implements LoginResponseContract
{
    public function toResponse($request)
    {
        $user = $request->user();

        // Role wise redirect
        switch ($user->role) {
            case 'Admin':
                return redirect()->intended('/admin/dashboard');
            case 'CRM Agent':
                return redirect()->intended('/crm/dashboard');
            case 'Doctor':
                return redirect()->intended('/doctor/dashboard');
            case 'Patient':
                return redirect()->intended('/patient/dashboard');
            case 'Lab Manager':
                return redirect()->intended('/lab/dashboard');
            default:
                return redirect()->intended('/dashboard');
        }
    }
}
