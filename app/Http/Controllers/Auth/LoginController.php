<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $user = $request->user();
            $isStaff = $user && method_exists($user, 'hasAnyRole')
                ? $user->hasAnyRole([
                    'System Administrator',
                    'Booking Manager',
                    'Travel Consultant',
                    'Tour Operator',
                    'Finance Officer',
                ])
                : false;

            return redirect()->intended($isStaff ? '/admin/dashboard' : '/client/dashboard');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
