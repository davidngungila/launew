@extends('layouts.admin')

@section('content')
<div class="max-w-7xl mx-auto space-y-8 pb-20">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight">User Details</h1>
            <p class="text-slate-500 font-medium">View profile summary and manage roles</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.settings.users.index') }}" class="px-5 py-2.5 bg-white border border-slate-200 text-slate-700 font-bold rounded-xl hover:bg-slate-50 transition-all shadow-sm">Back</a>
            <a href="{{ route('admin.settings.users.create') }}" class="px-5 py-2.5 bg-emerald-600 text-white font-bold rounded-xl hover:bg-emerald-700 transition-all shadow-lg shadow-emerald-500/20">Register New</a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="bg-white border border-slate-100 rounded-2xl shadow-sm p-8">
            <div class="text-[10px] font-black uppercase tracking-widest text-slate-400">User</div>
            <div class="mt-4 text-xl font-black text-slate-900">{{ $user->name }}</div>
            <div class="mt-1 text-sm font-bold text-slate-600">{{ $user->email }}</div>
            <div class="mt-6 grid grid-cols-2 gap-4">
                <div class="bg-slate-50 border border-slate-100 rounded-xl p-4">
                    <div class="text-[10px] font-black uppercase tracking-widest text-slate-400">ID</div>
                    <div class="mt-2 text-sm font-black text-slate-900">#{{ $user->id }}</div>
                </div>
                <div class="bg-slate-50 border border-slate-100 rounded-xl p-4">
                    <div class="text-[10px] font-black uppercase tracking-widest text-slate-400">Created</div>
                    <div class="mt-2 text-sm font-black text-slate-900">{{ $user->created_at?->format('Y-m-d') }}</div>
                </div>
            </div>
            <div class="mt-4 bg-slate-50 border border-slate-100 rounded-xl p-4">
                <div class="text-[10px] font-black uppercase tracking-widest text-slate-400">Email Verified</div>
                <div class="mt-2 text-sm font-black {{ $user->email_verified_at ? 'text-emerald-700' : 'text-slate-700' }}">{{ $user->email_verified_at ? $user->email_verified_at->format('Y-m-d H:i') : 'No' }}</div>
            </div>
        </div>

        <div class="lg:col-span-2 bg-white border border-slate-100 rounded-2xl shadow-sm p-8">
            <div class="flex items-center justify-between gap-4 mb-6">
                <h3 class="text-xs font-black uppercase tracking-[0.2em] text-slate-400">Roles</h3>
            </div>

            <form action="{{ route('admin.settings.users.update', $user->id) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <div class="flex flex-wrap gap-2">
                    @foreach($roles as $role)
                        <label class="inline-flex items-center gap-2 px-3 py-2 bg-slate-50 border border-slate-100 rounded-xl">
                            <input type="checkbox" name="role_ids[]" value="{{ $role->id }}" {{ $user->roles->contains('id', $role->id) ? 'checked' : '' }}>
                            <span class="text-[10px] font-black uppercase tracking-widest text-slate-600">{{ $role->name }}</span>
                        </label>
                    @endforeach
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="px-6 py-3 bg-emerald-600 text-white font-black text-[10px] uppercase tracking-widest rounded-xl hover:bg-emerald-700 transition-all">Save Roles</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
