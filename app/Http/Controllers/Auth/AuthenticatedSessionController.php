<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        $user = $request->user();

        // Role wise redirect
        if ($user->hasRole('Admin')) {
            return redirect()->intended('/admin/dashboard');
        } elseif ($user->hasRole('CRM Agent')) {
            return redirect()->intended('/crm/dashboard');
        } elseif ($user->hasRole('Doctor')) {
            return redirect()->intended('/doctor/dashboard');
        } elseif ($user->hasRole('Patient')) {
            return redirect()->intended('/patient/dashboard');
        } elseif ($user->hasRole('Lab Manager')) {
            return redirect()->intended('/lab/dashboard');
        } else {
            return redirect()->intended('/dashboard');
        }

        // return redirect()->intended(route('dashboard', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
