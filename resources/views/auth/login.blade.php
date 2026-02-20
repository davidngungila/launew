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
        <div class="text-center mb-8">
            <h2 class="text-2xl font-serif text-white mb-1">Access</h2>
            <p class="text-slate-500 font-bold text-[9px] uppercase tracking-[0.3em]">LAU Paradise Security</p>
        </div>

        <!-- Form Card -->
        <div class="glass rounded-[2rem] p-8 shadow-2xl relative overflow-hidden max-w-[360px] mx-auto">
            @if($errors->any())
                <div class="mb-6 p-3 bg-red-500/10 border border-red-500/20 text-red-200 rounded-xl text-[9px] font-bold uppercase tracking-widest text-center">
                    Invalid Credentials
                </div>
            @endif

            <form action="{{ route('login') }}" method="POST" class="space-y-4">
                @csrf
                <div class="relative">
                    <i class="ph ph-user absolute left-5 top-1/2 -translate-y-1/2 text-slate-500"></i>
                    <input type="email" name="email" required 
                           class="w-full bg-white/5 border border-white/10 rounded-xl pl-12 pr-4 py-3.5 text-sm text-white focus:ring-1 focus:ring-emerald-500 transition-all outline-none" 
                           placeholder="Email Address">
                </div>

                <div class="relative">
                    <i class="ph ph-lock absolute left-5 top-1/2 -translate-y-1/2 text-slate-500"></i>
                    <input type="password" name="password" required 
                           class="w-full bg-white/5 border border-white/10 rounded-xl pl-12 pr-4 py-3.5 text-sm text-white focus:ring-1 focus:ring-emerald-500 transition-all outline-none" 
                           placeholder="Passphrase">
                </div>

                <div class="flex items-center justify-between px-1 text-[10px]">
                    <label class="flex items-center gap-2 cursor-pointer text-slate-400 hover:text-slate-200 transition-colors">
                        <input type="checkbox" name="remember" class="w-4 h-4 rounded-md bg-white/5 border-white/10 text-emerald-600 focus:ring-0">
                        Remember
                    </label>
                    <a href="{{ route('password.request') }}" class="text-slate-600 hover:text-emerald-500 transition-colors">Recovery</a>
                </div>

                <button type="submit" class="w-full py-4 bg-emerald-600 text-white font-black text-[11px] uppercase tracking-[0.2em] rounded-xl hover:bg-emerald-500 transition-all shadow-lg shadow-emerald-900/20">
                    Verify & Enter
                </button>
            </form>
        </div>

        <!-- Footer -->
        <div class="mt-8 text-center">
            <p class="text-[9px] font-black text-slate-600 uppercase tracking-[0.4em]">
                &copy; {{ date('Y') }} LAU PARADISE
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
