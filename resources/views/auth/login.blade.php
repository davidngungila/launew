<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0, user-scalable=yes">
    <title>Secure Access | LAU Paradise Adventure</title>
    <link rel="icon" type="image/png" href="{{ asset('lau-adventuress-logo.png') }}">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@300;400;500;600;700;800&family=Playfair+Display:wght@700;900&display=swap" rel="stylesheet">
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Google Analytics -->
    @include('partials.google-analytics')
    <style>
        body { 
            font-family: 'Manrope', sans-serif;
            overscroll-behavior: none;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }
        .font-serif { font-family: 'Playfair Display', serif; }
        
        /* Performance optimizations */
        .glass { 
            background: rgba(255, 255, 255, 0.08); 
            backdrop-filter: blur(16px); 
            border: 1px solid rgba(255, 255, 255, 0.15);
            -webkit-backdrop-filter: blur(16px);
            transform: translateZ(0);
            will-change: transform;
        }

        /* Optimized animations */
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
            transform: translateZ(0);
        }
        .dot:nth-child(1) { animation-delay: -0.32s; }
        .dot:nth-child(2) { animation-delay: -0.16s; }
        @keyframes pulse {
            0%, 80%, 100% { transform: scale(0) translateZ(0); opacity: 0.3; }
            40% { transform: scale(1) translateZ(0); opacity: 1; }
        }

        .progress-line {
            width: 240px;
            height: 2px;
            background: rgba(255,255,255,0.1);
            border-radius: 10px;
            overflow: hidden;
            position: relative;
            transform: translateZ(0);
        }
        .progress-fill {
            position: absolute;
            height: 100%;
            background: #10b981;
            width: 30%;
            animation: move-progress 2s infinite linear;
            transform: translateZ(0);
        }
        @keyframes move-progress {
            0% { left: -30%; }
            100% { left: 100%; }
        }

        .bg-safari {
            background-image: url('https://res.cloudinary.com/dmqdm8gfk/image/upload/v1766042771/8-Days-Tanzania-holiday-Wildebeest-migration-1536x1018_gyndkw.jpg');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            transform: scale(1.1);
        }

        /* Responsive improvements */
        @media (min-width: 768px) {
            .login-container {
                max-width: 520px;
            }
        }
        
        @media (min-width: 1024px) {
            .login-container {
                max-width: 600px;
            }
        }

        @media (max-width: 640px) {
            .glass {
                padding: 1.5rem;
                margin: 0 1rem;
            }
            body {
                padding: 1rem;
            }
        }

        /* Touch optimizations */
        input, button, a, label {
            touch-action: manipulation;
            -webkit-tap-highlight-color: transparent;
        }

        /* Focus improvements */
        input:focus {
            outline: 2px solid #10b981;
            outline-offset: 2px;
        }

        /* Loading spinner optimization */
        .animate-spin-slow {
            animation: spin 3s linear infinite;
            transform: translateZ(0);
        }
        @keyframes spin {
            from { transform: rotate(0deg) translateZ(0); }
            to { transform: rotate(360deg) translateZ(0); }
        }
    </style>
</head>
<body x-data="{ loading: true }" x-init="setTimeout(() => loading = false, 1500)" class="bg-slate-950 min-h-screen flex items-center justify-center p-4 md:p-6 lg:p-8 relative overflow-hidden">
    
    <!-- Background Layer -->
    <div class="absolute inset-0 z-0 bg-safari opacity-45"></div>
    <div class="absolute inset-0 z-0 bg-gradient-to-b from-slate-950/85 via-slate-950/70 to-slate-950"></div>

    <!-- Animated Elements -->
    <div class="absolute top-[-5%] left-[-5%] w-[30%] h-[30%] md:w-[40%] md:h-[40%] bg-emerald-500/8 rounded-full blur-[100px] md:blur-[120px] animate-pulse"></div>
    <div class="absolute bottom-[-5%] right-[-5%] w-[30%] h-[30%] md:w-[40%] md:h-[40%] bg-emerald-900/15 rounded-full blur-[100px] md:blur-[120px] animate-pulse" style="animation-delay: 1s;"></div>

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
         x-transition:enter="transition ease-out duration-800 delay-200" 
         x-transition:enter-start="opacity-0 translate-y-8 blur-sm" 
         x-transition:enter-end="opacity-100 translate-y-0 blur-0"
         class="relative z-10 w-full max-w-[480px] md:max-w-[520px] lg:max-w-[600px] login-container">
        
        <!-- Identity -->
        <div class="text-center mb-8 md:mb-10">
            <h2 class="text-3xl md:text-4xl lg:text-5xl font-serif text-white mb-2">Access</h2>
            <p class="text-slate-500 font-bold text-[10px] md:text-[11px] uppercase tracking-[0.3em]">LAU Paradise Security</p>
        </div>

        <!-- Form Card -->
        <div class="glass rounded-[2rem] md:rounded-[2.5rem] p-6 md:p-8 lg:p-10 shadow-2xl relative overflow-hidden max-w-[400px] md:max-w-[480px] lg:max-w-[520px] mx-auto">
            @if($errors->any())
                <div class="mb-6 p-3 bg-red-500/10 border border-red-500/20 text-red-200 rounded-xl text-[9px] font-bold uppercase tracking-widest text-center">
                    Invalid Credentials
                </div>
            @endif

            <form action="{{ route('login') }}" method="POST" class="space-y-4">
                @csrf
                <div class="relative">
                    <i class="ph ph-user absolute left-5 top-1/2 -translate-y-1/2 text-slate-500 text-lg md:text-xl"></i>
                    <input type="email" name="email" required 
                           class="w-full bg-white/5 border border-white/10 rounded-xl pl-14 pr-4 py-4 md:py-5 text-sm md:text-base text-white focus:ring-2 focus:ring-emerald-500/50 transition-all outline-none placeholder:text-slate-500" 
                           placeholder="Email Address">
                </div>

                <div class="relative">
                    <i class="ph ph-lock absolute left-5 top-1/2 -translate-y-1/2 text-slate-500 text-lg md:text-xl"></i>
                    <input type="password" name="password" required 
                           class="w-full bg-white/5 border border-white/10 rounded-xl pl-14 pr-4 py-4 md:py-5 text-sm md:text-base text-white focus:ring-2 focus:ring-emerald-500/50 transition-all outline-none placeholder:text-slate-500" 
                           placeholder="Passphrase">
                </div>

                <div class="flex items-center justify-between px-1 text-xs md:text-sm">
                    <label class="flex items-center gap-2 cursor-pointer text-slate-400 hover:text-slate-200 transition-colors">
                        <input type="checkbox" name="remember" class="w-4 h-4 md:w-5 md:h-5 rounded-md bg-white/5 border-white/10 text-emerald-600 focus:ring-2 focus:ring-emerald-500/50">
                        <span class="font-medium">Remember</span>
                    </label>
                    <a href="{{ route('password.request') }}" class="text-slate-600 hover:text-emerald-500 transition-colors font-medium">Recovery</a>
                </div>

                <button type="submit" class="w-full py-4 md:py-5 bg-emerald-600 text-white font-black text-xs md:text-sm uppercase tracking-[0.2em] rounded-xl hover:bg-emerald-500 transition-all duration-300 shadow-lg shadow-emerald-900/20 hover:shadow-emerald-900/30 transform hover:scale-[1.02] active:scale-[0.98]">
                    Verify & Enter
                </button>
            </form>
        </div>

        <!-- Footer -->
        <div class="mt-8 md:mt-10 text-center">
            @if(app()->environment('local'))
                <p class="text-[9px] text-emerald-500 mb-2">
                    💻 Development: Use OTP <code class="bg-emerald-500/20 px-2 py-1 rounded">123456</code> or add <code class="bg-emerald-500/20 px-2 py-1 rounded">?dev_bypass=1</code>
                </p>
            @endif
            <p class="text-[10px] md:text-[11px] font-black text-slate-600 uppercase tracking-[0.4em]">
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
