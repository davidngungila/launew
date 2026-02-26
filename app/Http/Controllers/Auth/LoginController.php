<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\OtpLogin;
use App\Models\User;
use App\Services\EmailService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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

        $remember = (bool) $request->boolean('remember');

        $user = User::query()->where('email', $credentials['email'])->first();
        $isStaff = false;
        if ($user) {
            if ($user->email === 'admin@lauparadise.com') {
                $isStaff = true;
            } elseif (method_exists($user, 'hasAnyRole')) {
                $isStaff = $user->hasAnyRole([
                    'System Administrator',
                    'Admin / General Manager',
                    'Booking Manager',
                    'Travel Consultant',
                    'Tour Operator',
                    'Finance Officer',
                    'Accountant',
                    'Marketing Officer',
                    'Sales Officer',
                    'Operations Manager',
                    'Driver / Guide',
                    'External Agent',
                    'Branch Manager',
                    'IT Support',
                ]);
            }
        }

        if ($isStaff) {
            if (!$user || !Hash::check($credentials['password'], (string) $user->password)) {
                return back()->withErrors([
                    'email' => 'The provided credentials do not match our records.',
                ])->onlyInput('email');
            }

            $otp = (string) random_int(100000, 999999);

            OtpLogin::query()->where('user_id', $user->id)->delete();
            OtpLogin::query()->create([
                'user_id' => $user->id,
                'otp_hash' => Hash::make($otp),
                'expires_at' => now()->addMinutes(10),
                'attempts' => 0,
                'sent_at' => now(),
                'ip_address' => $request->ip(),
                'user_agent' => substr((string) $request->userAgent(), 0, 1024),
            ]);

            $service = new EmailService();
            $html = view('emails.system.otp', [
                'subject' => 'Your OTP Code',
                'heading' => 'Login Verification Code',
                'subheading' => 'Use this one-time code to complete your staff login',
                'logo_url' => url('lau-adventuress-logo.png'),
                'website_url' => config('app.url'),
                'support_email' => config('mail.from.address'),
                'otp' => $otp,
                'email' => $user->email,
                'expires_minutes' => 10,
            ])->render();

            $sent = $service->send($user->email, 'LAU OTP Login Code', $html);
            if (!$sent) {
                return back()->withErrors([
                    'email' => 'Failed to send OTP email. ' . ($service->getLastError() ?? ''),
                ])->onlyInput('email');
            }

            $request->session()->put('otp_login_user_id', $user->id);
            $request->session()->put('otp_login_remember', $remember);
            $request->session()->put('otp_login_redirect', '/admin/dashboard');

            return redirect()->route('login.otp')->with('status', 'OTP sent to your email.');
        }

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            return redirect()->intended('/client/dashboard');
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
