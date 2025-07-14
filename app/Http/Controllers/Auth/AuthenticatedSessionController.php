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
    // Authentification
    $request->authenticate();
    $request->session()->regenerate();

    $user = Auth::user();

    // Vérifie si c’est la première connexion
    if (is_null($user->last_login_at)) {
        session()->flash('first_time_login', true);
    }

    // Mise à jour du champ last_login_at
    $user->update([
        'last_login_at' => now(),
    ]);

    // Redirection selon le rôle
    return match ($user->role) {
        'admin' => redirect()->route('admin_simple'),
        'super_admin' => redirect()->route('superadmin'),
        'rh' => redirect()->route('rh_dashboard'),
        'chef_projet' => redirect()->route('chef_projet.dashboard'),
        default => redirect()->route('dashboard'),
    };
}

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
