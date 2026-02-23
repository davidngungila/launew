@extends('layouts.admin')

@section('content')
<div class="max-w-7xl mx-auto space-y-8 pb-20">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight">User Management</h1>
            <p class="text-slate-500 font-medium">Assign roles and control access</p>
        </div>
    </div>

    <div class="bg-white border border-slate-100 rounded-2xl shadow-sm p-8">
        <div class="flex items-center justify-between gap-4 mb-6">
            <h3 class="text-xs font-black uppercase tracking-[0.2em] text-slate-400">Register New User</h3>
        </div>

        <form action="{{ route('admin.settings.users.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @csrf
            <div class="space-y-1">
                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest pl-1">Full Name</label>
                <input name="name" value="{{ old('name') }}" required class="w-full px-5 py-3 bg-slate-50 border border-slate-100 rounded-xl text-sm font-bold text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500">
            </div>
            <div class="space-y-1">
                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest pl-1">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required class="w-full px-5 py-3 bg-slate-50 border border-slate-100 rounded-xl text-sm font-bold text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500">
            </div>
            <div class="space-y-1">
                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest pl-1">Password</label>
                <input type="password" name="password" required class="w-full px-5 py-3 bg-slate-50 border border-slate-100 rounded-xl text-sm font-bold text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500">
            </div>
            <div class="space-y-1">
                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest pl-1">Confirm Password</label>
                <input type="password" name="password_confirmation" required class="w-full px-5 py-3 bg-slate-50 border border-slate-100 rounded-xl text-sm font-bold text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500">
            </div>
            <div class="md:col-span-2">
                <div class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-3 pl-1">Assign Roles</div>
                <div class="flex flex-wrap gap-2">
                    @foreach($roles as $role)
                        <label class="inline-flex items-center gap-2 px-3 py-2 bg-slate-50 border border-slate-100 rounded-xl">
                            <input type="checkbox" name="role_ids[]" value="{{ $role->id }}" {{ collect(old('role_ids', []))->contains($role->id) ? 'checked' : '' }}>
                            <span class="text-[10px] font-black uppercase tracking-widest text-slate-600">{{ $role->name }}</span>
                        </label>
                    @endforeach
                </div>
            </div>
            <div class="md:col-span-2 flex justify-end">
                <button type="submit" class="px-6 py-3 bg-emerald-600 text-white font-black text-[10px] uppercase tracking-widest rounded-xl hover:bg-emerald-700 transition-all">Register User</button>
            </div>
        </form>
    </div>

    <div class="bg-white border border-slate-100 rounded-2xl shadow-sm overflow-hidden">
        <div class="px-8 py-6 border-b border-slate-50 flex items-center justify-between">
            <h3 class="text-xs font-black uppercase tracking-[0.2em] text-slate-400">Users</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead>
                    <tr class="bg-slate-50">
                        <th class="text-left px-8 py-4 text-[10px] font-black uppercase tracking-widest text-slate-400">Name</th>
                        <th class="text-left px-8 py-4 text-[10px] font-black uppercase tracking-widest text-slate-400">Email</th>
                        <th class="text-left px-8 py-4 text-[10px] font-black uppercase tracking-widest text-slate-400">Roles</th>
                        <th class="text-right px-8 py-4 text-[10px] font-black uppercase tracking-widest text-slate-400">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                        <tr class="border-t border-slate-50">
                            <td class="px-8 py-5">
                                <div class="font-black text-slate-900">{{ $user->name }}</div>
                                <div class="text-xs text-slate-400 font-bold">#{{ $user->id }}</div>
                            </td>
                            <td class="px-8 py-5">
                                <div class="text-sm font-bold text-slate-700">{{ $user->email }}</div>
                            </td>
                            <td class="px-8 py-5">
                                <form action="{{ route('admin.settings.users.update', $user->id) }}" method="POST" class="flex flex-wrap gap-2 items-center">
                                    @csrf
                                    @method('PUT')
                                    @foreach($roles as $role)
                                        <label class="inline-flex items-center gap-2 px-3 py-2 bg-slate-50 border border-slate-100 rounded-xl">
                                            <input type="checkbox" name="role_ids[]" value="{{ $role->id }}" {{ $user->roles->contains('id', $role->id) ? 'checked' : '' }}>
                                            <span class="text-[10px] font-black uppercase tracking-widest text-slate-600">{{ $role->name }}</span>
                                        </label>
                                    @endforeach
                            </td>
                            <td class="px-8 py-5 text-right">
                                    <button type="submit" class="px-5 py-3 bg-emerald-600 text-white font-black text-[10px] uppercase tracking-widest rounded-xl hover:bg-emerald-700 transition-all">Save</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="px-8 py-6 border-t border-slate-50">
            {{ $users->links() }}
        </div>
    </div>
</div>
@endsection
