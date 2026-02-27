<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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
}
