<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifying Access | LAU Paradise Adventure</title>
    <link rel="icon" type="image/png" href="{{ asset('lau-adventuress-logo.png') }}">
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@300;400;500;600;700;800&family=Playfair+Display:wght@700;900&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Manrope', sans-serif; }
        .font-serif { font-family: 'Playfair Display', serif; }
        .bg-safari {
            background-image: url('https://res.cloudinary.com/dmqdm8gfk/image/upload/v1766042771/8-Days-Tanzania-holiday-Wildebeest-migration-1536x1018_gyndkw.jpg');
            background-size: cover;
            background-position: center;
        }
        .glass {
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(18px);
            border: 1px solid rgba(255, 255, 255, 0.15);
        }
    </style>
</head>
<body class="bg-slate-950 min-h-screen flex items-center justify-center p-4 relative overflow-hidden">
    <div class="absolute inset-0 z-0 bg-safari scale-110 blur-[2px] opacity-35"></div>
    <div class="absolute inset-0 z-0 bg-gradient-to-b from-slate-950/85 via-slate-950/60 to-slate-950"></div>

    <div class="relative z-10 w-full max-w-[520px]">
        <div class="glass rounded-[2rem] p-10 shadow-2xl relative overflow-hidden text-center">
            <div class="text-white text-2xl font-serif mb-2">Securing Your Session</div>
            <div class="text-slate-400 font-bold text-[10px] uppercase tracking-[0.35em] mb-8">OTP Verified</div>

            <div class="w-full bg-white/10 rounded-full h-3 overflow-hidden mb-4">
                <div id="bar" class="h-3 bg-emerald-500 rounded-full" style="width:0%"></div>
            </div>

            <div class="text-white font-black tracking-[0.25em] text-sm">
                <span id="pct">0</span>%
            </div>

            <div class="mt-6 text-slate-500 text-xs font-bold">
                Redirecting to dashboard...
            </div>
        </div>

        <div class="mt-8 text-center">
            <p class="text-[9px] font-black text-slate-600 uppercase tracking-[0.4em]">
                &copy; {{ date('Y') }} LAU PARADISE
            </p>
        </div>
    </div>

    <script>
        (function () {
            const redirectUrl = @json($redirect ?? url('/admin/dashboard'));
            let p = 0;
            const pct = document.getElementById('pct');
            const bar = document.getElementById('bar');

            const timer = setInterval(() => {
                p += 2;
                if (p > 100) p = 100;
                pct.innerText = String(p);
                bar.style.width = p + '%';
                if (p >= 100) {
                    clearInterval(timer);
                    window.location.href = redirectUrl;
                }
            }, 30);
        })();
    </script>
</body>
</html>
