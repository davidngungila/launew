@extends('layouts.admin')

@section('content')
<div class="max-w-5xl mx-auto space-y-8 pb-20">
    <div class="flex items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight">Register New User</h1>
            <p class="text-slate-500 font-medium">Create a new account and assign roles</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.settings.users.index') }}" class="px-5 py-2.5 bg-white border border-slate-200 text-slate-700 font-bold rounded-xl hover:bg-slate-50 transition-all shadow-sm">Back to List</a>
        </div>
    </div>

    <div class="bg-white border border-slate-100 rounded-2xl shadow-sm p-8">
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

            <div class="md:col-span-2 flex items-center justify-end gap-4">
                <a href="{{ route('admin.settings.users.index') }}" class="px-6 py-3 text-slate-500 font-black text-[10px] uppercase tracking-widest hover:text-slate-700 transition-colors">Cancel</a>
                <button type="submit" class="px-6 py-3 bg-emerald-600 text-white font-black text-[10px] uppercase tracking-widest rounded-xl hover:bg-emerald-700 transition-all">Create User</button>
            </div>
        </form>
    </div>
</div>
@endsection
