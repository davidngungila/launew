<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;

class RolePermissionController extends Controller
{
    public function index()
    {
        $roles = Role::query()->with('permissions')->orderBy('name')->get();
        $permissions = Permission::query()->orderBy('name')->get();

        return view('admin.settings.roles.index', compact('roles', 'permissions'));
    }

    public function storeRole(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:roles,name',
        ]);

        Role::create(['name' => $validated['name']]);

        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'role.created',
            'subject_type' => Role::class,
            'properties' => ['name' => $validated['name']],
            'ip_address' => $request->ip(),
            'user_agent' => substr((string) $request->userAgent(), 0, 1024),
        ]);

        return back()->with('success', 'Role created');
    }

    public function updateRole(Request $request, Role $role)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:roles,name,' . $role->id,
            'permission_ids' => 'array',
            'permission_ids.*' => 'integer|exists:permissions,id',
        ]);

        $role->update(['name' => $validated['name']]);
        $role->permissions()->sync($validated['permission_ids'] ?? []);

        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'role.updated',
            'subject_type' => Role::class,
            'subject_id' => $role->id,
            'properties' => [
                'name' => $validated['name'],
                'permission_ids' => $validated['permission_ids'] ?? [],
            ],
            'ip_address' => $request->ip(),
            'user_agent' => substr((string) $request->userAgent(), 0, 1024),
        ]);

        return back()->with('success', 'Role updated');
    }
}
