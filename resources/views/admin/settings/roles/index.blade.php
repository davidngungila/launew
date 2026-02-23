@extends('layouts.admin')

@section('content')
<div class="max-w-7xl mx-auto space-y-8 pb-20">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight">Role Permissions</h1>
            <p class="text-slate-500 font-medium">Manage roles and their permissions</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="bg-white border border-slate-100 rounded-2xl shadow-sm p-8">
            <h3 class="text-xs font-black uppercase tracking-[0.2em] text-slate-400 mb-6">Create Role</h3>
            <form action="{{ route('admin.settings.roles.store') }}" method="POST" class="space-y-4">
                @csrf
                <div class="space-y-1">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest pl-1">Role Name</label>
                    <input name="name" required class="w-full px-5 py-3 bg-slate-50 border border-slate-100 rounded-xl text-sm font-bold text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500">
                </div>
                <button type="submit" class="w-full py-3 bg-emerald-600 text-white font-black text-[10px] uppercase tracking-widest rounded-xl hover:bg-emerald-700 transition-all">Create</button>
            </form>
        </div>

        <div class="lg:col-span-2 space-y-6">
            @foreach($roles as $role)
                <div class="bg-white border border-slate-100 rounded-2xl shadow-sm p-8">
                    <form action="{{ route('admin.settings.roles.update', $role->id) }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                            <div class="space-y-1">
                                <div class="text-xs font-black uppercase tracking-[0.2em] text-slate-400">Role</div>
                                <input name="name" value="{{ old('name', $role->name) }}" class="w-full px-5 py-3 bg-slate-50 border border-slate-100 rounded-xl text-sm font-black text-slate-900">
                            </div>
                            <button type="submit" class="px-6 py-3 bg-slate-900 text-white font-black text-[10px] uppercase tracking-widest rounded-xl hover:bg-slate-800 transition-all">Save</button>
                        </div>

                        <div>
                            <div class="text-xs font-black uppercase tracking-[0.2em] text-slate-400 mb-4">Permissions</div>
                            @if($permissions->count() === 0)
                                <div class="text-sm font-bold text-slate-500">No permissions defined yet.</div>
                            @else
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                    @foreach($permissions as $perm)
                                        <label class="flex items-center gap-3 px-4 py-3 bg-slate-50 border border-slate-100 rounded-xl">
                                            <input type="checkbox" name="permission_ids[]" value="{{ $perm->id }}" {{ $role->permissions->contains('id', $perm->id) ? 'checked' : '' }}>
                                            <span class="text-[10px] font-black uppercase tracking-widest text-slate-700">{{ $perm->name }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </form>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
