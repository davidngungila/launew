@extends('layouts.admin')

@section('content')
<div class="max-w-4xl mx-auto space-y-8">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight">Account Settings</h1>
            <p class="text-slate-500 font-medium">Manage your personal information and profile picture</p>
        </div>
        <div class="flex items-center gap-4">
            @if(session('success'))
                <div class="px-4 py-2 bg-emerald-50 text-emerald-600 text-[10px] font-black uppercase tracking-widest rounded-xl border border-emerald-100 animate-bounce">
                    {{ session('success') }}
                </div>
            @endif
            <button form="settings-form" class="px-5 py-2.5 bg-emerald-600 text-white font-bold rounded-xl hover:bg-emerald-700 transition-all shadow-lg shadow-emerald-500/20 flex items-center gap-2">
                <i class="ph ph-floppy-disk"></i>
                Save Changes
            </button>
        </div>
    </div>

    <form id="settings-form" action="{{ route('admin.account-settings.update') }}" method="POST" enctype="multipart/form-data" class="space-y-8 pb-10">
        @csrf
        
        <!-- Profile Picture Section -->
        <div class="bg-white p-10 rounded-[2.5rem] border border-slate-100 shadow-sm flex flex-col md:flex-row items-center gap-10">
            <div class="relative group">
                <div class="w-40 h-40 rounded-[2.5rem] bg-emerald-50 border-4 border-white shadow-2xl overflow-hidden relative">
                    <img id="avatar-preview" src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=10b981&color=fff&size=512" class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center cursor-pointer" onclick="document.getElementById('avatar-input').click()">
                        <i class="ph ph-camera text-white text-3xl"></i>
                    </div>
                </div>
                <input type="file" id="avatar-input" name="profile_image" class="hidden" accept="image/*" onchange="previewImage(this)">
                <button type="button" class="absolute -bottom-2 -right-2 w-10 h-10 bg-white border border-slate-100 rounded-xl shadow-xl flex items-center justify-center text-slate-400 hover:text-emerald-500 transition-all" onclick="document.getElementById('avatar-input').click()">
                    <i class="ph ph-pencil-simple text-xl"></i>
                </button>
            </div>
            <div class="flex-grow space-y-4 text-center md:text-left">
                <h3 class="text-xl font-black text-slate-900 tracking-tight">Your Profile Avatar</h3>
                <p class="text-sm text-slate-500 font-medium leading-relaxed max-w-md mx-auto md:ml-0">Update your account picture. This will be visible to other team members in the dashboard and logs.</p>
                <div class="flex items-center justify-center md:justify-start gap-3">
                    <span class="text-[10px] font-black uppercase tracking-widest text-slate-300">Supported formats: JPG, PNG, WEBP</span>
                </div>
            </div>
        </div>

        <!-- Personal Info Section -->
        <div class="bg-white p-10 rounded-[2.5rem] border border-slate-100 shadow-sm space-y-8">
            <h3 class="text-xl font-black text-slate-900 flex items-center gap-3">
                 <i class="ph ph-user-circle text-emerald-500"></i>
                 Personal Information
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="space-y-1">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest pl-1">Full Name</label>
                    <input type="text" name="name" class="w-full px-5 py-3 bg-slate-50 border border-slate-100 rounded-2xl text-sm font-bold text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 transition-all" value="{{ auth()->user()->name }}">
                </div>
                <div class="space-y-1">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest pl-1">Email Address</label>
                    <input type="email" name="email" class="w-full px-5 py-3 bg-slate-50 border border-slate-100 rounded-2xl text-sm font-bold text-slate-900" value="{{ auth()->user()->email }}">
                </div>
                <div class="space-y-1">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest pl-1">Phone Number</label>
                    <input type="text" name="phone" class="w-full px-5 py-3 bg-slate-50 border border-slate-100 rounded-2xl text-sm font-bold text-slate-900" value="+255 683 163 219">
                </div>
                <div class="space-y-1">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest pl-1">Location / Timezone</label>
                    <input type="text" name="location" class="w-full px-5 py-3 bg-slate-50 border border-slate-100 rounded-2xl text-sm font-bold text-slate-900" value="Moshi, Tanzania (GMT+3)">
                </div>
            </div>
        </div>

        <!-- Security Section -->
        <div class="bg-white p-10 rounded-[2.5rem] border border-slate-100 shadow-sm space-y-8">
            <h3 class="text-xl font-black text-slate-900 flex items-center gap-3">
                 <i class="ph ph-lock text-emerald-500"></i>
                 Security & Password
            </h3>
            <div class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="space-y-1">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest pl-1">Current Password</label>
                        <input type="password" name="current_password" class="w-full px-5 py-3 bg-slate-50 border border-slate-100 rounded-2xl text-sm font-bold text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 transition-all" placeholder="••••••••">
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="space-y-1">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest pl-1">New Password</label>
                        <input type="password" name="new_password" class="w-full px-5 py-3 bg-slate-50 border border-slate-100 rounded-2xl text-sm font-bold text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 transition-all" placeholder="Minimum 8 characters">
                    </div>
                    <div class="space-y-1">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest pl-1">Confirm New Password</label>
                        <input type="password" name="new_password_confirmation" class="w-full px-5 py-3 bg-slate-50 border border-slate-100 rounded-2xl text-sm font-bold text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 transition-all" placeholder="Repeat new password">
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    function previewImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('avatar-preview').src = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection
