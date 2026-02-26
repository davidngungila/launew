<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\OtpLogin;
use App\Models\User;
use App\Services\EmailService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class OtpLoginController extends Controller
{
    public function show(Request $request)
    {
        $userId = (int) $request->session()->get('otp_login_user_id', 0);
        if (!$userId) {
            return redirect()->route('login');
        }

        $user = User::query()->find($userId);
        if (!$user) {
            $request->session()->forget('otp_login_user_id');
            return redirect()->route('login');
        }

        return view('auth.otp', [
            'email' => $user->email,
        ]);
    }

    public function verifyLink(Request $request)
    {
        $token = (string) $request->query('token', '');
        if ($token === '') {
            return redirect()->route('login');
        }

        $otpLogin = OtpLogin::query()->where('verify_token', $token)->orderByDesc('id')->first();
        if (!$otpLogin) {
            return redirect()->route('login')->withErrors(['email' => 'Invalid OTP link. Please login again.']);
        }

        if (now()->greaterThan($otpLogin->expires_at)) {
            return redirect()->route('login')->withErrors(['email' => 'OTP link expired. Please login again.']);
        }

        $user = User::query()->find((int) $otpLogin->user_id);
        if (!$user) {
            return redirect()->route('login');
        }

        $otpLogin->delete();

        $remember = (bool) $request->session()->get('otp_login_remember', false);
        $redirect = (string) $request->session()->get('otp_login_redirect', '/admin/dashboard');

        $request->session()->forget(['otp_login_user_id', 'otp_login_remember', 'otp_login_redirect', 'otp_login_auto']);

        Auth::login($user, $remember);
        $request->session()->regenerate();

        $request->session()->put('otp_login_redirect_after', $redirect);

        return redirect()->route('login.otp.splash');
    }

    public function splash(Request $request)
    {
        $redirect = (string) $request->session()->get('otp_login_redirect_after', '/admin/dashboard');
        $request->session()->forget('otp_login_redirect_after');

        return view('auth.otp-splash', [
            'redirect' => $redirect,
        ]);
    }

    public function verify(Request $request)
    {
        $userId = (int) $request->session()->get('otp_login_user_id', 0);
        if (!$userId) {
            return redirect()->route('login');
        }

        $validated = $request->validate([
            'otp' => ['required', 'string', 'min:4', 'max:10'],
        ]);

        $otpLogin = OtpLogin::query()
            ->where('user_id', $userId)
            ->orderByDesc('id')
            ->first();

        if (!$otpLogin) {
            return back()->withErrors(['otp' => 'OTP session not found. Please login again.']);
        }

        if (now()->greaterThan($otpLogin->expires_at)) {
            return back()->withErrors(['otp' => 'OTP expired. Please request a new code.']);
        }

        if (($otpLogin->attempts ?? 0) >= 5) {
            return back()->withErrors(['otp' => 'Too many attempts. Please request a new code.']);
        }

        $otpLogin->increment('attempts');

        $otp = preg_replace('/\s+/', '', (string) $validated['otp']);
        if (!Hash::check($otp, (string) $otpLogin->otp_hash)) {
            return back()->withErrors(['otp' => 'Invalid OTP.']);
        }

        $user = User::query()->find($userId);
        if (!$user) {
            return redirect()->route('login');
        }

        $otpLogin->delete();
        $remember = (bool) $request->session()->get('otp_login_remember', false);
        $redirect = (string) $request->session()->get('otp_login_redirect', '/admin/dashboard');

        $request->session()->forget(['otp_login_user_id', 'otp_login_remember', 'otp_login_redirect', 'otp_login_auto']);

        Auth::login($user, $remember);
        $request->session()->regenerate();

        $request->session()->put('otp_login_redirect_after', $redirect);
        return redirect()->route('login.otp.splash');
    }

    public function resend(Request $request)
    {
        $userId = (int) $request->session()->get('otp_login_user_id', 0);
        if (!$userId) {
            return redirect()->route('login');
        }

        $user = User::query()->find($userId);
        if (!$user) {
            $request->session()->forget('otp_login_user_id');
            return redirect()->route('login');
        }

        $latest = OtpLogin::query()->where('user_id', $userId)->orderByDesc('id')->first();
        if ($latest && $latest->sent_at && now()->diffInSeconds($latest->sent_at) < 60) {
            return back()->withErrors(['otp' => 'Please wait before requesting a new code.']);
        }

        $otp = (string) random_int(100000, 999999);
        $token = bin2hex(random_bytes(24));

        OtpLogin::query()->where('user_id', $userId)->delete();

        OtpLogin::query()->create([
            'user_id' => $userId,
            'otp_hash' => Hash::make($otp),
            'verify_token' => $token,
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
            'verify_url' => route('login.otp.verify_link', ['token' => $token]),
        ])->render();

        $sent = $service->send($user->email, 'LAU OTP Login Code', $html);

        if (!$sent) {
            return back()->withErrors(['otp' => 'Failed to send OTP email. ' . ($service->getLastError() ?? '')]);
        }

        return back()->with('status', 'A new OTP has been sent.');
    }
}
