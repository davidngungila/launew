<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Secure Access | LAU Paradise Adventure</title>
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

        .dot-pulse {
            display: flex;
            gap: 6px;
        }
        .dot {
            width: 8px;
            height: 8px;
            background-color: #10b981;
            border-radius: 50%;
            animation: pulse 1.4s infinite ease-in-out both;
        }
        .dot:nth-child(1) { animation-delay: -0.32s; }
        .dot:nth-child(2) { animation-delay: -0.16s; }
        @keyframes pulse {
            0%, 80%, 100% { transform: scale(0); opacity: 0.3; }
            40% { transform: scale(1); opacity: 1; }
        }

        .progress-line {
            width: 240px;
            height: 2px;
            background: rgba(255,255,255,0.1);
            border-radius: 10px;
            overflow: hidden;
            position: relative;
        }
        .progress-fill {
            position: absolute;
            height: 100%;
            background: #10b981;
            width: 30%;
            animation: move-progress 2s infinite linear;
        }
        @keyframes move-progress {
            0% { left: -30%; }
            100% { left: 100%; }
        }

        .bg-safari {
            background-image: url('https://res.cloudinary.com/dmqdm8gfk/image/upload/v1766042771/8-Days-Tanzania-holiday-Wildebeest-migration-1536x1018_gyndkw.jpg');
            background-size: cover;
            background-position: center;
        }
    </style>
</head>
<body x-data="{ loading: true }" x-init="setTimeout(() => loading = false, 2000)" class="bg-slate-950 min-h-screen flex items-center justify-center p-4 relative overflow-hidden">
    
    <!-- Background Layer -->
    <div class="absolute inset-0 z-0 bg-safari scale-110 blur-[2px] opacity-40"></div>
    <div class="absolute inset-0 z-0 bg-gradient-to-b from-slate-950/80 via-slate-950/60 to-slate-950"></div>

    <!-- Animated Elements -->
    <div class="absolute top-[-10%] left-[-10%] w-[40%] h-[40%] bg-emerald-500/10 rounded-full blur-[120px] animate-pulse"></div>
    <div class="absolute bottom-[-10%] right-[-10%] w-[40%] h-[40%] bg-emerald-900/20 rounded-full blur-[120px] animate-pulse" style="animation-delay: 1s;"></div>

    <!-- Splash Screen -->
    <div x-show="loading" 
         x-transition:leave="transition ease-in duration-700" 
         x-transition:leave-start="opacity-100 scale-100" 
         x-transition:leave-end="opacity-0 scale-110" 
         class="fixed inset-0 z-50 flex flex-col items-center justify-center bg-slate-950">
        
        <div class="mb-12 relative">
            <div class="w-24 h-24 rounded-full border border-emerald-500/30 flex items-center justify-center animate-spin-slow">
                <i class="ph-bold ph-airplane-takeoff text-4xl text-emerald-500"></i>
            </div>
            <div class="absolute inset-0 w-24 h-24 rounded-full border-t-2 border-emerald-500 animate-spin"></div>
        </div>

        <h1 class="text-3xl font-serif text-white mb-4 tracking-tight">LAU Paradise Adventure</h1>
        <p class="text-emerald-500 font-bold text-[10px] uppercase tracking-[0.4em] mb-12">Authentic Safaris & Expeditions</p>

        <div class="progress-line mb-8">
            <div class="progress-fill"></div>
        </div>

        <div class="dot-pulse">
            <div class="dot"></div>
            <div class="dot"></div>
            <div class="dot"></div>
        </div>
    </div>

    <!-- Login Container -->
    <div x-show="!loading" 
         x-transition:enter="transition ease-out duration-1000 delay-300" 
         x-transition:enter-start="opacity-0 translate-y-12 blur-md" 
         x-transition:enter-end="opacity-100 translate-y-0 blur-0"
         class="relative z-10 w-full max-w-[440px]">
        
        <!-- Identity -->
        <div class="text-center mb-10">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-emerald-500/10 rounded-2xl mb-6 border border-emerald-500/20 shadow-xl shadow-emerald-500/10">
                <i class="ph-fill ph-shield-checkered text-3xl text-emerald-500"></i>
            </div>
            <h2 class="text-3xl font-serif text-white mb-2 leading-tight">Member Access</h2>
            <p class="text-slate-400 font-bold text-[10px] uppercase tracking-[0.3em]">Guardian of the Paradise Adventures</p>
        </div>

        <!-- Form Card -->
        <div class="glass rounded-[2.5rem] p-10 shadow-2xl overflow-hidden relative group">
            <div class="absolute inset-0 bg-gradient-to-br from-emerald-500/[0.05] to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-1000"></div>
            
            @if($errors->any())
                <div class="mb-8 p-4 bg-red-500/10 border border-red-500/20 text-red-200 rounded-2xl text-[10px] font-bold uppercase tracking-widest text-center">
                    <i class="ph ph-warning-circle mr-2"></i> {{ $errors->first() }}
                </div>
            @endif

            <form action="{{ route('login') }}" method="POST" class="space-y-6 relative z-10">
                @csrf
                <div class="space-y-2">
                    <label class="text-[10px] font-black text-emerald-500 uppercase tracking-widest ml-1">Identity</label>
                    <div class="relative group/input">
                        <i class="ph ph-user absolute left-5 top-1/2 -translate-y-1/2 text-slate-500 group-focus-within/input:text-emerald-500 transition-colors"></i>
                        <input type="email" name="email" required 
                               class="w-full bg-white/5 border border-white/10 rounded-2xl pl-14 pr-6 py-4 text-sm font-medium text-white placeholder:text-slate-600 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white/10 transition-all outline-none" 
                               placeholder="Email Address">
                    </div>
                </div>

                <div class="space-y-2">
                    <div class="flex items-center justify-between ml-1">
                        <label class="text-[10px] font-black text-emerald-500 uppercase tracking-widest">Passphrase</label>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-[9px] font-bold text-slate-500 uppercase hover:text-emerald-500 transition-colors">Lost Access?</a>
                        @endif
                    </div>
                    <div class="relative group/input">
                        <i class="ph ph-lock-key absolute left-5 top-1/2 -translate-y-1/2 text-slate-500 group-focus-within/input:text-emerald-500 transition-colors"></i>
                        <input type="password" name="password" required 
                               class="w-full bg-white/5 border border-white/10 rounded-2xl pl-14 pr-6 py-4 text-sm font-medium text-white placeholder:text-slate-600 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white/10 transition-all outline-none" 
                               placeholder="••••••••">
                    </div>
                </div>

                <div class="flex items-center justify-between px-1">
                    <label class="flex items-center gap-3 cursor-pointer group/check">
                        <div class="relative flex items-center">
                            <input type="checkbox" name="remember" class="peer appearance-none w-5 h-5 rounded-lg bg-white/5 border border-white/10 checked:bg-emerald-600 checked:border-emerald-600 transition-all cursor-pointer">
                            <i class="ph ph-check absolute inset-0 text-white text-xs flex items-center justify-center opacity-0 peer-checked:opacity-100 transition-opacity"></i>
                        </div>
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest group-hover/check:text-slate-200 transition-colors">Keep Session Active</span>
                    </label>
                </div>

                <button type="submit" class="group relative w-full py-5 bg-emerald-600 overflow-hidden text-white font-black text-xs uppercase tracking-[0.3em] rounded-2xl shadow-xl shadow-emerald-600/20 hover:bg-emerald-500 transition-all duration-500">
                    <span class="relative z-10 flex items-center justify-center gap-2">
                        Enter Gateway <i class="ph-bold ph-arrow-right group-hover:translate-x-1 transition-transform"></i>
                    </span>
                    <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/10 to-transparent -translate-x-full group-hover:translate-x-full transition-transform duration-1000"></div>
                </button>
            </form>
        </div>

        <!-- Footer -->
        <div class="mt-12 text-center space-y-6">
            <div class="flex items-center justify-center gap-6">
                <a href="/" class="text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] hover:text-emerald-500 transition-colors flex items-center gap-2">
                    <i class="ph ph-house"></i> Return Home
                </a>
                <span class="w-1 h-1 rounded-full bg-slate-700"></span>
                <a href="/contact" class="text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] hover:text-emerald-500 transition-colors flex items-center gap-2">
                    <i class="ph ph-info"></i> Support
                </a>
            </div>
            <p class="text-[9px] font-black text-slate-600 uppercase tracking-[0.4em]">
                &copy; {{ date('Y') }} LAU Paradise Adventure System
            </p>
        </div>
    </div>

    @if(session('status'))
        <div class="fixed bottom-10 right-10 z-50 animate-bounce">
            <div class="bg-emerald-600 text-white px-6 py-3 rounded-2xl font-bold text-xs shadow-2xl">
                {{ session('status') }}
            </div>
        </div>
    @endif
</body>
</html>
