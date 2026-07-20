@extends('layouts.index')

@section('layouts')
<div id="splash-screen" class="relative flex min-h-dvh w-full flex-col items-center justify-center overflow-hidden bg-gradient-to-b from-[#1D4ED8] via-[#2563EB] to-[#60A5FA]">
    <div class="pointer-events-none absolute left-[250px] -top-[120px] h-[340px] w-[340px] rounded-full bg-white/10"></div>
    <div class="pointer-events-none absolute -left-[93px] top-[585px] h-[240px] w-[240px] rounded-full bg-white/10"></div>
    <div class="relative z-10 flex flex-col items-center px-8 text-center">
        <div class="mb-6 flex h-[100px] w-[100px] items-center justify-center rounded-[30px] bg-white/15 shadow-[0px_8px_32px_0px_#00000040] border border-[#FFFFFF38] backdrop-blur-sm">
            <svg class="h-[50px] w-[50px] text-white/35" viewBox="0 0 24 24" fill="currentColor">
                <path d="M12 3 1 8.5l11 5.5 9-4.5V17h2V8.5L12 3Z" />
                <path d="M5 10.9V15c0 1.7 3.1 4 7 4s7-2.3 7-4v-4.1l-7 3.5-7-3.5Z" />
            </svg>
        </div>
        <h1 class="text-4xl font-extrabold tracking-wide text-white">
            AGS
        </h1>
        <p class="mt-1 text-xs font-semibold tracking-[0.2em] text-blue-100">
            ACADEMIC GUIDANCE SYSTEM
        </p>
        <svg class="mt-10 h-20 w-56 text-white/25" viewBox="0 0 220 90" fill="currentColor">
            <polygon points="110,4 210,32 10,32" />
            <rect x="14" y="38" width="14" height="40" />
            <rect x="50" y="38" width="14" height="40" />
            <rect x="86" y="38" width="14" height="40" />
            <rect x="122" y="38" width="14" height="40" />
            <rect x="158" y="38" width="14" height="40" />
            <rect x="6" y="80" width="200" height="8" />
        </svg>
        <p class="mt-4 text-sm text-blue-100">
            Sistem Bimbingan Akademik Terpadu
        </p>
        <div class="mt-8 w-56">
            <div class="h-1.5 w-full overflow-hidden rounded-full bg-white/25">
                <div id="splash-progress-bar"
                    class="h-full w-0 rounded-full bg-white transition-all duration-300 ease-out"></div>
            </div>
            <p id="splash-status" class="mt-3 text-xs text-blue-100">
                Memuat Aplikasi...
            </p>
        </div>
    </div>
</div>

<script>
    (function() {
        const bar = document.getElementById('splash-progress-bar');
        const status = document.getElementById('splash-status');
        const splash = document.getElementById('splash-screen');
        
        const redirectUrl = "{{ $redirectUrl ?? url('/mahasiswa/beranda') }}";

        let progress = 0;

        const interval = setInterval(() => {
            progress += Math.random() * 18 + 7;

            if (progress >= 100) {
                progress = 100;
                clearInterval(interval);
                status.textContent = 'Aplikasi siap digunakan';

                setTimeout(() => {
                    splash.classList.add('transition-opacity', 'duration-500', 'opacity-0');
                    setTimeout(() => {
                        window.location.href = redirectUrl;
                    }, 500);
                }, 400);
            }

            bar.style.width = progress + '%';
        }, 350);
    })();
</script>
@endsection
