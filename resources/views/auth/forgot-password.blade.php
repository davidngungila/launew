<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recovery | LAU Paradise Adventure</title>
    <link rel="icon" type="image/png" href="{{ asset('lau-adventuress-logo.png') }}">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@300;400;500;600;700;800&family=Playfair+Display:wght@700;900&display=swap" rel="stylesheet">
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Manrope', sans-serif; }
        .font-serif { font-family: 'Playfair Display', serif; }
        
        .glass { 
            background: rgba(255, 255, 255, 0.1); 
            backdrop-filter: blur(20px); 
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .bg-safari {
            background-image: url('https://res.cloudinary.com/dmqdm8gfk/image/upload/v1766042771/8-Days-Tanzania-holiday-Wildebeest-migration-1536x1018_gyndkw.jpg');
            background-size: cover;
            background-position: center;
        }

        .shimmer {
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.05), transparent);
            background-size: 200% 100%;
            animation: shimmer 3s infinite;
        }
        @keyframes shimmer {
            0% { background-position: -200% 0; }
            100% { background-position: 200% 0; }
        }
    </style>
</head>
<body x-data="{ loading: true }" x-init="setTimeout(() => loading = false, 1500)" class="bg-slate-950 min-h-screen flex items-center justify-center p-4 relative overflow-hidden">
    
    <!-- Background Layer -->
    <div class="absolute inset-0 z-0 bg-safari scale-110 blur-[2px] opacity-30"></div>
    <div class="absolute inset-0 z-0 bg-gradient-to-b from-slate-950/90 via-slate-950/70 to-slate-950"></div>

    <!-- Splash Screen -->
    <div x-show="loading" 
         x-transition:leave="transition ease-in duration-500" 
         x-transition:leave-start="opacity-100 scale-100" 
         x-transition:leave-end="opacity-0 scale-110" 
         class="fixed inset-0 z-50 flex flex-col items-center justify-center bg-slate-950">
        <div class="w-16 h-16 border-2 border-emerald-500/20 border-t-emerald-500 rounded-full animate-spin"></div>
    </div>

    <!-- Container -->
    <div x-show="!loading" 
         x-transition:enter="transition ease-out duration-1000 delay-200" 
         x-transition:enter-start="opacity-0 translate-y-8 blur-md" 
         x-transition:enter-end="opacity-100 translate-y-0 blur-0"
         class="relative z-10 w-full max-w-[400px]">
        
        <!-- Header -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-14 h-14 bg-emerald-500/10 rounded-2xl mb-6 border border-emerald-500/20 shadow-xl shadow-emerald-500/10">
                <i class="ph-bold ph-key-return text-2xl text-emerald-500"></i>
            </div>
            <h1 class="text-2xl font-serif text-white mb-2">Account Recovery</h1>
            <p class="text-slate-500 font-bold text-[9px] uppercase tracking-[0.3em]">Restore your access to paradise</p>
        </div>

        <!-- Card -->
        <div class="glass rounded-[2rem] p-8 shadow-2xl relative overflow-hidden">
            <div class="shimmer absolute inset-0 pointer-events-none"></div>

            @if(session('status'))
                <div class="mb-6 p-4 bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 rounded-xl text-[10px] font-bold uppercase tracking-widest text-center">
                    {{ session('status') }}
                </div>
            @else
                <p class="text-slate-400 text-xs mb-8 text-center leading-relaxed">
                    Enter your email address below and we'll send you a secure link to reset your credentials.
                </p>

                <form action="{{ route('password.email') }}" method="POST" class="space-y-4">
                    @csrf
                    <div class="relative">
                        <i class="ph ph-envelope absolute left-5 top-1/2 -translate-y-1/2 text-slate-500"></i>
                        <input type="email" name="email" required 
                               class="w-full bg-white/5 border border-white/10 rounded-xl pl-12 pr-4 py-4 text-sm text-white placeholder:text-slate-600 focus:ring-1 focus:ring-emerald-500 transition-all outline-none" 
                               placeholder="Registered Email">
                    </div>

                    <button type="submit" class="group relative w-full py-4 bg-emerald-600 text-white font-black text-[11px] uppercase tracking-[0.2em] rounded-xl hover:bg-emerald-500 transition-all shadow-lg shadow-emerald-900/20">
                        Send Recovery Link
                    </button>
                </form>
            @endif
        </div>

        <!-- Footer -->
        <div class="mt-8 text-center">
            <a href="/login" class="text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] hover:text-emerald-500 transition-colors flex items-center justify-center gap-2">
                <i class="ph ph-arrow-left"></i> Back to Login
            </a>
        </div>
    </div>
</body>
</html>
