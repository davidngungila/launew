<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gateway | LAU SAFARIS</title>
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Manrope', sans-serif; overflow: hidden; }
        .dot-pulse {
            display: flex;
            gap: 6px;
        }
        .dot {
            width: 8px;
            height: 8px;
            background-color: #3b82f6;
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
            width: 200px;
            height: 4px;
            background: #f1f5f9;
            border-radius: 10px;
            overflow: hidden;
            position: relative;
        }
        .progress-fill {
            position: absolute;
            height: 100%;
            background: #3b82f6;
            width: 30%;
            animation: move-progress 2s infinite linear;
        }
        @keyframes move-progress {
            0% { left: -30%; }
            100% { left: 100%; }
        }
    </style>
</head>
<body x-data="{ loading: true }" x-init="setTimeout(() => loading = false, 2500)" class="bg-white min-h-screen flex items-center justify-center p-6">
    
    <!-- Splash Screen -->
    <template x-if="loading">
        <div x-transition:leave="transition ease-in duration-500" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95" 
             class="flex flex-col items-center text-center">
            
            <div class="mb-8 relative flex items-center justify-center">
                 <div class="w-20 h-20 rounded-full border-4 border-blue-50 flex items-center justify-center relative shadow-sm">
                    <i class="ph-fill ph-circles-three-plus text-3xl text-blue-500"></i>
                 </div>
            </div>

            <h1 class="text-2xl font-black text-slate-800 tracking-tight mb-2">Setting up your safari experience...</h1>
            <p class="text-blue-500 font-bold text-xs mb-8">Curating the best adventures for you</p>

            <div class="progress-line mb-6">
                <div class="progress-fill"></div>
            </div>

            <div class="dot-pulse">
                <div class="dot"></div>
                <div class="dot"></div>
                <div class="dot"></div>
            </div>
        </div>
    </template>

    <!-- Login Form (Becomes visible after loading) -->
    <div x-show="!loading" x-transition:enter="transition ease-out duration-700 delay-500" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0"
         class="w-full max-w-sm flex flex-col items-center">
        
        <div class="mb-10 text-center">
            <h2 class="text-2xl font-black text-slate-900 tracking-tight mb-2">Secure Gateway</h2>
            <p class="text-slate-400 font-bold text-[10px] uppercase tracking-[0.2em]">Unlock your administrative empire</p>
        </div>

        <div class="w-full">
            @if($errors->any())
                <div class="mb-6 p-4 bg-red-50 text-red-600 rounded-2xl text-[10px] font-black uppercase tracking-widest border border-red-100 text-center">
                    {{ $errors->first() }}
                </div>
            @endif

            <form action="{{ route('login') }}" method="POST" class="space-y-4">
                @csrf
                <div class="relative">
                    <input type="email" name="email" required 
                           class="w-full bg-slate-50 border border-slate-100 rounded-2xl px-6 py-4 text-sm font-bold text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all placeholder:text-slate-300" 
                           placeholder="Enter registered email">
                </div>

                <div class="relative">
                    <input type="password" name="password" required 
                           class="w-full bg-slate-50 border border-slate-100 rounded-2xl px-6 py-4 text-sm font-bold text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all placeholder:text-slate-300" 
                           placeholder="Security passphrase">
                </div>

                <div class="flex items-center justify-between px-2">
                    <label class="flex items-center gap-2 cursor-pointer group">
                        <input type="checkbox" name="remember" class="w-4 h-4 rounded text-blue-600 border-slate-200 focus:ring-blue-500">
                        <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest group-hover:text-slate-600 transition-colors">Keep Session Active</span>
                    </label>
                </div>

                <button type="submit" class="w-full py-5 bg-slate-900 text-white font-black text-xs uppercase tracking-[0.2em] rounded-2xl shadow-2xl shadow-slate-900/10 hover:bg-blue-600 transition-all duration-500 mt-4">
                    Access Dashboard
                </button>
            </form>
            
            <div class="mt-12 flex flex-col items-center gap-6">
                <div class="flex items-center gap-4">
                    <div class="w-1.5 h-1.5 rounded-full bg-slate-100"></div>
                    <div class="w-1.5 h-1.5 rounded-full bg-slate-100"></div>
                    <div class="w-1.5 h-1.5 rounded-full bg-slate-100"></div>
                </div>
                <p class="text-[9px] font-black text-slate-300 uppercase tracking-[0.3em]">
                    &copy; {{ date('Y') }} LAU SECURE GATEWAY
                </p>
            </div>
        </div>
    </div>
</body>
</html>
