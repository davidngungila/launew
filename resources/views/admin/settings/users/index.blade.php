@extends('layouts.admin')

@section('content')
<div class="max-w-7xl mx-auto space-y-8 pb-20">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight">User Management</h1>
            <p class="text-slate-500 font-medium">Assign roles and control access</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.settings.users.create') }}" class="px-6 py-3 bg-emerald-600 text-white font-black text-[10px] uppercase tracking-widest rounded-xl hover:bg-emerald-700 transition-all shadow-lg shadow-emerald-500/20">Register New User</a>
        </div>
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
                        <th class="text-right px-8 py-4 text-[10px] font-black uppercase tracking-widest text-slate-400">Actions</th>
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
                                    <div class="inline-flex items-center gap-2">
                                        <a href="{{ route('admin.settings.users.show', $user->id) }}" class="px-4 py-2 bg-white border border-slate-200 rounded-xl text-[10px] font-black uppercase tracking-widest text-slate-600 hover:bg-slate-50 transition-all">View More</a>
                                        <button type="submit" class="px-5 py-3 bg-emerald-600 text-white font-black text-[10px] uppercase tracking-widest rounded-xl hover:bg-emerald-700 transition-all">Save</button>
                                    </div>
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
