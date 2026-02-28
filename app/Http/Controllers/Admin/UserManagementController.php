<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Services\EmailService;

class UserManagementController extends Controller
{
    public function index()
    {
        $users = User::query()->with('roles')->orderBy('name')->paginate(20);
        $roles = Role::query()->orderBy('name')->get();

        return view('admin.settings.users.index', compact('users', 'roles'));
    }

    public function create()
    {
        $roles = Role::query()->orderBy('name')->get();

        return view('admin.settings.users.create', compact('roles'));
    }

    public function show(User $user)
    {
        $user->load('roles');
        $roles = Role::query()->orderBy('name')->get();

        return view('admin.settings.users.show', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'role_ids' => 'array',
            'role_ids.*' => 'integer|exists:roles,id',
        ]);

        $user->roles()->sync($validated['role_ids'] ?? []);

        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'user.roles.updated',
            'subject_type' => User::class,
            'subject_id' => $user->id,
            'properties' => [
                'role_ids' => $validated['role_ids'] ?? [],
            ],
            'ip_address' => $request->ip(),
            'user_agent' => substr((string) $request->userAgent(), 0, 1024),
        ]);

        return back()->with('success', 'User roles updated');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'role_ids' => 'array',
            'role_ids.*' => 'integer|exists:roles,id',
        ]);

        $user = User::query()->create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        $user->roles()->sync($validated['role_ids'] ?? []);

        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'user.created',
            'subject_type' => User::class,
            'subject_id' => $user->id,
            'properties' => [
                'email' => $user->email,
                'role_ids' => $validated['role_ids'] ?? [],
            ],
            'ip_address' => $request->ip(),
            'user_agent' => substr((string) $request->userAgent(), 0, 1024),
        ]);

        return redirect()->route('admin.settings.users.show', $user)->with('success', 'User registered successfully');
    }

    public function resetPassword(Request $request, User $user)
    {
        $password = Str::random(12);
        $user->forceFill(['password' => Hash::make($password)])->save();

        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'user.password.reset',
            'subject_type' => User::class,
            'subject_id' => $user->id,
            'properties' => [
                'email' => $user->email,
            ],
            'ip_address' => $request->ip(),
            'user_agent' => substr((string) $request->userAgent(), 0, 1024),
        ]);

        $html = view('emails.system.password-reset', [
            'subject' => 'Your password has been reset',
            'heading' => 'Password Reset',
            'subheading' => 'A new password has been generated for your account.',
            'email' => $user->email,
            'name' => $user->name,
            'new_password' => $password,
            'website_url' => config('app.url'),
        ])->render();

        $email = new EmailService();
        $sent = $email->send($user->email, 'Your password has been reset', $html);

        if (!$sent) {
            return back()->with('error', 'Password reset, but email failed to send: ' . ($email->getLastError() ?: 'unknown error'));
        }

        return back()->with('success', 'New password generated and emailed to user.');
    }

    public function resetPasswordBulk(Request $request)
    {
        $validated = $request->validate([
            'user_ids' => 'array',
            'user_ids.*' => 'integer|exists:users,id',
            'all' => 'nullable|boolean',
        ]);

        $q = User::query();
        if (!empty($validated['all'])) {
            $users = $q->orderBy('id')->get();
        } else {
            $ids = $validated['user_ids'] ?? [];
            $users = $q->whereIn('id', $ids)->orderBy('id')->get();
        }

        if ($users->count() === 0) {
            return back()->with('error', 'No users selected.');
        }

        $email = new EmailService();
        $sentCount = 0;

        foreach ($users as $u) {
            $password = Str::random(12);
            $u->forceFill(['password' => Hash::make($password)])->save();

            ActivityLog::create([
                'user_id' => auth()->id(),
                'action' => 'user.password.reset',
                'subject_type' => User::class,
                'subject_id' => $u->id,
                'properties' => [
                    'email' => $u->email,
                    'bulk' => true,
                ],
                'ip_address' => $request->ip(),
                'user_agent' => substr((string) $request->userAgent(), 0, 1024),
            ]);

            $html = view('emails.system.password-reset', [
                'subject' => 'Your password has been reset',
                'heading' => 'Password Reset',
                'subheading' => 'A new password has been generated for your account.',
                'email' => $u->email,
                'name' => $u->name,
                'new_password' => $password,
                'website_url' => config('app.url'),
            ])->render();

            if ($email->send($u->email, 'Your password has been reset', $html)) {
                $sentCount++;
            }
        }

        return back()->with('success', 'Passwords reset for ' . $users->count() . ' user(s). Emails sent: ' . $sentCount . '.');
    }
}
