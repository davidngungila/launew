<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTP Verification | LAU Paradise Adventure</title>
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
    </style>
</head>
<body class="bg-slate-950 min-h-screen flex items-center justify-center p-4 relative overflow-hidden">
    <div class="absolute inset-0 z-0 bg-safari scale-110 blur-[2px] opacity-40"></div>
    <div class="absolute inset-0 z-0 bg-gradient-to-b from-slate-950/80 via-slate-950/60 to-slate-950"></div>

    <div class="relative z-10 w-full max-w-[440px]">
        <div class="text-center mb-8">
            <h2 class="text-2xl font-serif text-white mb-1">Verify OTP</h2>
            <p class="text-slate-500 font-bold text-[9px] uppercase tracking-[0.3em]">Sent to {{ $email ?? '' }}</p>
        </div>

        <div class="glass rounded-[2rem] p-8 shadow-2xl relative overflow-hidden max-w-[360px] mx-auto">
            @if($errors->any())
                <div class="mb-6 p-3 bg-red-500/10 border border-red-500/20 text-red-200 rounded-xl text-[9px] font-bold uppercase tracking-widest text-center">
                    {{ $errors->first() }}
                </div>
            @endif

            @if(session('status'))
                <div class="mb-6 p-3 bg-emerald-500/10 border border-emerald-500/20 text-emerald-200 rounded-xl text-[9px] font-bold uppercase tracking-widest text-center">
                    {{ session('status') }}
                </div>
            @endif

            <form action="{{ route('login.otp.verify') }}" method="POST" class="space-y-4">
                @csrf
                <div class="relative">
                    <i class="ph ph-shield-check absolute left-5 top-1/2 -translate-y-1/2 text-slate-500"></i>
                    <input type="text" name="otp" required autocomplete="one-time-code"
                           class="w-full bg-white/5 border border-white/10 rounded-xl pl-12 pr-4 py-3.5 text-sm text-white focus:ring-1 focus:ring-emerald-500 transition-all outline-none tracking-[0.35em] font-black"
                           placeholder="Enter OTP">
                </div>

                <button type="submit" class="w-full py-4 bg-emerald-600 text-white font-black text-[11px] uppercase tracking-[0.2em] rounded-xl hover:bg-emerald-500 transition-all shadow-lg shadow-emerald-900/20">
                    Verify & Continue
                </button>
            </form>

            <form action="{{ route('login.otp.resend') }}" method="POST" class="mt-4">
                @csrf
                <button type="submit" class="w-full py-3 bg-white/5 border border-white/10 text-white/80 font-black text-[10px] uppercase tracking-[0.2em] rounded-xl hover:bg-white/10 transition-all">
                    Resend OTP
                </button>
            </form>

            <div class="mt-6 text-center">
                <a href="{{ route('login') }}" class="text-slate-500 hover:text-emerald-500 transition-colors text-[10px] font-bold uppercase tracking-widest">Back to Login</a>
            </div>
        </div>

        <div class="mt-8 text-center">
            <p class="text-[9px] font-black text-slate-600 uppercase tracking-[0.4em]">
                &copy; {{ date('Y') }} LAU PARADISE
            </p>
        </div>
    </div>
</body>
</html>
