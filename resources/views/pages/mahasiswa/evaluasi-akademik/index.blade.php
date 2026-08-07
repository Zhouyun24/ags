@extends('layouts.index')

@section('layouts')
@php
    // --- Hitung lingkaran skor keseluruhan (circular progress) ---
    $radius = 70;
    $circumference = 2 * pi() * $radius;
    $persenSkor = $skorMaks > 0 ? $skorKeseluruhan / $skorMaks : 0;
    $strokeOffset = $circumference * (1 - $persenSkor);

    // --- Hitung titik-titik grafik tren (SVG line chart) ---
    $chartWidth = 320;
    $chartHeight = 140;
    $paddingLeft = 30;
    $paddingRight = 12;
    $paddingBottom = 20;
    $paddingTop = 10;

    $minY = 1;
    $maxY = 5;
    $rangeY = $maxY - $minY;

    $labels = array_keys($trenPerkembangan);
    $values = array_values($trenPerkembangan);
    $count = count($values);

    $plotWidth = $chartWidth - $paddingLeft - $paddingRight;
    $plotHeight = $chartHeight - $paddingBottom - $paddingTop;

    $points = [];
    $polylinePoints = '';

    if ($count >= 2) {
        foreach ($values as $i => $val) {
            $x = $paddingLeft + ($i / ($count - 1)) * $plotWidth;
            $y = $paddingTop + (1 - (($val - $minY) / $rangeY)) * $plotHeight;
            $points[] = [$x, $y];
        }

        $polylinePoints = collect($points)->map(fn($p) => "{$p[0]},{$p[1]}")->implode(' ');
    }
@endphp

<div class="pb-8">
    <div class="relative overflow-hidden bg-gradient-to-tl from-[#2563ED] via-[#2251E3] to-[#1D4ED8] px-5 pb-12 pt-10 min-h-[106px] flex flex-col justify-center">
        <h1 class="font-jakarta text-xl font-extrabold text-white">Evaluasi Akademik</h1>
        <p class="mt-1 font-inter text-xs text-white">
            {{ $mahasiswa->nama }} &bull; Semester {{ $mahasiswa->semester }}
        </p>
    </div>
    <div class="px-5 pt-6">
        <div class="mb-5 flex flex-col items-center rounded-2xl bg-gradient-to-br from-[#2563ED] via-[#2251E3] to-[#1D4ED8] p-6 shadow-[0px_4px_16px_0px_#0F172A14]">
            <p class="font-inter text-sm text-white">Skor Keseluruhan</p>
            <div class="relative my-4 flex h-[160px] w-[160px] items-center justify-center">
                <svg class="h-full w-full -rotate-90" viewBox="0 0 160 160">
                    <circle cx="80" cy="80" r="{{ $radius }}" fill="none" stroke="rgba(255,255,255,0.25)" stroke-width="8" />
                    <circle cx="80" cy="80" r="{{ $radius }}" fill="none" stroke="white" stroke-width="8"
                        stroke-linecap="round"
                        stroke-dasharray="{{ $circumference }}"
                        stroke-dashoffset="{{ $strokeOffset }}" />
                </svg>
                <div class="absolute flex flex-col items-center">
                    <span class="font-jakarta text-4xl font-extrabold text-white">{{ number_format($skorKeseluruhan, 1) }}</span>
                    <span class="font-inter text-xs text-white/80">dari {{ number_format($skorMaks, 1) }}</span>
                </div>
            </div>
            <span class="inline-flex items-center gap-1.5 rounded-full bg-white/20 px-4 py-1.5 font-inter text-xs font-semibold text-white">
                <svg class="h-3.5 w-3.5 text-yellow-300" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 2l2.9 6.26L22 9.27l-5 4.87L18.2 21 12 17.27 5.8 21 7 14.14l-5-4.87 7.1-1.01L12 2z" />
                </svg>
                {{ $labelSkor }}
            </span>
        </div>
        <div class="mb-5 grid grid-cols-2 gap-4">
            <div class="rounded-xl bg-white p-4 shadow-[0px_4px_16px_0px_#0F172A14]">
                <span class="mb-3 flex h-9 w-9 items-center justify-center rounded-lg bg-[#16A34A]/15">
                    <svg class="h-5 w-5 text-[#16A34A]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                        <circle cx="9" cy="7" r="4" />
                        <path d="M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75" />
                    </svg>
                </span>
                <p class="font-inter text-xs text-black/75">Partisipasi</p>
                <p class="font-jakarta text-2xl font-extrabold text-[#16A34A]">{{ number_format($skor['partisipasi'], 1) }}</p>
                <div class="mt-2 h-[6px] w-full overflow-hidden rounded-full bg-slate-100">
                    <div class="h-full rounded-full bg-[#16A34A]" style="width: {{ ($skor['partisipasi'] / 5) * 100 }}%"></div>
                </div>
            </div>
            <div class="rounded-xl bg-white p-4 shadow-[0px_4px_16px_0px_#0F172A14]">
                <span class="mb-3 flex h-9 w-9 items-center justify-center rounded-lg bg-[#2653EB]/15">
                    <svg class="h-5 w-5 text-[#2653EB]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <path d="M4 5.5A2.5 2.5 0 0 1 6.5 3H12v18H6.5A2.5 2.5 0 0 1 4 18.5v-13Z" />
                        <path d="M20 5.5A2.5 2.5 0 0 0 17.5 3H12v18h5.5a2.5 2.5 0 0 0 2.5-2.5v-13Z" />
                    </svg>
                </span>
                <p class="font-inter text-xs text-black/75">Pemahaman</p>
                <p class="font-jakarta text-2xl font-extrabold text-[#2653EB]">{{ number_format($skor['pemahaman'], 1) }}</p>
                <div class="mt-2 h-[6px] w-full overflow-hidden rounded-full bg-slate-100">
                    <div class="h-full rounded-full bg-[#2653EB]" style="width: {{ ($skor['pemahaman'] / 5) * 100 }}%"></div>
                </div>
            </div>
        </div>
        @if (count($trenPerkembangan) >= 2)
            <div class="rounded-xl bg-white p-4 shadow-[0px_4px_16px_0px_#0F172A14]">
                <p class="mb-3 font-inter text-sm font-semibold text-black">Tren Perkembangan</p>
                <svg viewBox="0 0 {{ $chartWidth }} {{ $chartHeight + 20 }}" class="w-full">
                    @foreach ([5, 4, 3, 2, 1] as $gridVal)
                        @php
                            $gridY = $paddingTop + (1 - (($gridVal - $minY) / $rangeY)) * $plotHeight;
                        @endphp
                        <line x1="{{ $paddingLeft }}" y1="{{ $gridY }}" x2="{{ $chartWidth }}" y2="{{ $gridY }}"
                            stroke="#F1F5F9" stroke-width="1" />
                        <text x="0" y="{{ $gridY + 3 }}" font-size="9" fill="#94A3B8" font-family="Inter, sans-serif">
                            {{ $gridVal }}
                        </text>
                    @endforeach
                    <polyline points="{{ $polylinePoints }}" fill="none" stroke="#2653EB" stroke-width="2.5"
                        stroke-linecap="round" stroke-linejoin="round" />
                    @foreach ($points as $i => $p)
                        <circle cx="{{ $p[0] }}" cy="{{ $p[1] }}" r="3.5"
                            fill="white" stroke="#2653EB" stroke-width="2.5" />
                    @endforeach
                    @foreach ($labels as $i => $label)
                        <text x="{{ $points[$i][0] }}" y="{{ $chartHeight + 15 }}" font-size="9" fill="#94A3B8"
                            text-anchor="middle" font-family="Inter, sans-serif">
                            {{ $label }}
                        </text>
                    @endforeach
                </svg>
            </div>
        @else
            <div class="rounded-xl bg-white py-10 text-center shadow-[0px_4px_16px_0px_#0F172A14]">
                <p class="font-inter text-sm text-slate-400">Belum cukup data untuk menampilkan tren.</p>
            </div>
        @endif
    </div>
</div>
@endsection