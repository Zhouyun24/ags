@extends('layouts.index')

@section('layouts')
@php
    $lebarChart = 320;
    $tinggiChart = 140;
    $nilaiMax = 36; // sesuai grid label 0-36
    $jumlahBulan = count($sesiPerBulan ?? []);
    $jarakX = $jumlahBulan > 1 ? $lebarChart / ($jumlahBulan - 1) : 0;

    $titikKoordinat = [];
    $i = 0;
    if (isset($sesiPerBulan)) {
        foreach ($sesiPerBulan as $bulan => $nilai) {
            $x = round($i * $jarakX, 1);
            $y = round($tinggiChart - ($nilai / $nilaiMax) * $tinggiChart, 1);
            $titikKoordinat[] = ['bulan' => $bulan, 'nilai' => $nilai, 'x' => $x, 'y' => $y];
            $i++;
        }
    }
    $garisPolyline = collect($titikKoordinat)->map(fn($t) => "{$t['x']},{$t['y']}")->implode(' ');
@endphp

<div class="pb-5">
    <div class="relative overflow-hidden rounded-b-[20px] bg-gradient-to-br from-[#8B5CF6] via-[#7C3AED] to-[#6D28D9] px-5 pb-6 pt-5">
        <div class="flex items-center justify-between gap-3">
            <div>
                <h1 class="font-jakarta text-xl font-extrabold text-white">Monitoring</h1>
                <p class="mt-1 font-inter text-xs text-white">Periode: {{ $periode ?? date('Y') }}</p>
            </div>
            <a href=""
                class="flex shrink-0 items-center gap-1.5 rounded-lg border border-white/40 bg-white/10 px-4 py-2.5 font-inter text-xs font-semibold text-white hover:bg-white/20">
                <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M12 15V3m0 12-4-4m4 4 4-4" />
                    <path d="M3 17v2a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-2" />
                </svg>
                Ekspor
            </a>
        </div>
    </div>

    <div class="px-5 pt-6">
        <div class="mb-6 grid grid-cols-2 gap-4">
            <a href="{{ route('operator.monitoring.jadwal') }}" class="rounded-xl bg-white p-4 shadow-[0px_4px_16px_0px_#0F172A14] hover:bg-slate-50 transition cursor-pointer">
                <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-[#2653EB]/15">
                    <svg class="h-5 w-5 text-[#2653EB]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <path d="M4 5.5A2.5 2.5 0 0 1 6.5 3H12v18H6.5A2.5 2.5 0 0 1 4 18.5v-13Z" />
                        <path d="M20 5.5A2.5 2.5 0 0 0 17.5 3H12v18h5.5a2.5 2.5 0 0 0 2.5-2.5v-13Z" />
                    </svg>
                </span>
                <p class="mt-3 font-jakarta text-2xl font-extrabold text-[#2653EB]">{{ $ringkasan['jumlahBimbingan'] ?? 0 }}</p>
                <p class="mt-1 font-inter text-xs text-slate-500">Jumlah bimbingan bulan ini</p>
            </a>
            <a href="{{ route('operator.monitoring.hasil') }}" class="rounded-xl bg-white p-4 shadow-[0px_4px_16px_0px_#0F172A14] hover:bg-slate-50 transition cursor-pointer">
                <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-[#16A34A]/15">
                    <svg class="h-5 w-5 text-[#16A34A]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <path d="M23 6l-9.5 9.5-5-5L1 18" />
                        <path d="M17 6h6v6" />
                    </svg>
                </span>
                <p class="mt-3 font-jakarta text-2xl font-extrabold text-[#16A34A]">{{ $ringkasan['tingkatKehadiran'] ?? 0 }}%</p>
                <p class="mt-1 font-inter text-xs text-slate-500">Tingkat kehadiran</p>
            </a>
            <a href="{{ route('operator.monitoring.penilaian') }}" class="rounded-xl bg-white p-4 shadow-[0px_4px_16px_0px_#0F172A14] hover:bg-slate-50 transition cursor-pointer">
                <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-[#F59E0B]/15">
                    <svg class="h-5 w-5 text-[#F59E0B]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <path d="m12 2 3.1 6.3 6.9 1-5 4.9 1.2 6.9L12 17.8l-6.2 3.3 1.2-6.9-5-4.9 6.9-1L12 2Z" />
                    </svg>
                </span>
                <p class="mt-3 font-jakarta text-2xl font-extrabold text-[#F59E0B]">{{ number_format($ringkasan['rataSkor'] ?? 0, 1) }}</p>
                <p class="mt-1 font-inter text-xs text-slate-500">Rata - rata skor</p>
            </a>
            <div class="rounded-xl bg-white p-4 shadow-[0px_4px_16px_0px_#0F172A14]">
                <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-[#DC2626]/15">
                    <svg class="h-5 w-5 text-[#DC2626]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <circle cx="12" cy="12" r="9" />
                        <path d="M12 7v5l3 3" />
                    </svg>
                </span>
                <p class="mt-3 font-jakarta text-2xl font-extrabold text-[#DC2626]">{{ $ringkasan['belumDitinjau'] ?? 0 }}</p>
                <p class="mt-1 font-inter text-xs text-slate-500">Belum ditinjau</p>
            </div>
        </div>

        <div class="mb-6 rounded-xl bg-white p-4 shadow-[0px_4px_16px_0px_#0F172A14]">
            <h2 class="mb-4 font-inter font-semibold text-[13px] text-black">Sesi Bimbingan per Bulan</h2>
            <div class="flex gap-2">
                <div class="flex flex-col justify-between py-1 font-inter text-[10px] text-slate-400">
                    <span>36</span>
                    <span>27</span>
                    <span>18</span>
                    <span>9</span>
                    <span>0</span>
                </div>
                <div class="flex-1 overflow-x-auto">
                    <svg viewBox="0 0 {{ $lebarChart }} {{ $tinggiChart }}" class="h-[140px] w-full" preserveAspectRatio="none">
                        {{-- garis grid horizontal --}}
                        @foreach ([0, 0.25, 0.5, 0.75, 1] as $rasio)
                            <line
                                x1="0" x2="{{ $lebarChart }}"
                                y1="{{ $tinggiChart * $rasio }}" y2="{{ $tinggiChart * $rasio }}"
                                stroke="#E2E8F0" stroke-width="1"
                            />
                        @endforeach

                        <polyline
                            points="{{ $garisPolyline }}"
                            fill="none"
                            stroke="#2653EB"
                            stroke-width="2.5"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                        />

                        @foreach ($titikKoordinat as $titik)
                            <circle cx="{{ $titik['x'] }}" cy="{{ $titik['y'] }}" r="4" fill="#2653EB" />
                        @endforeach
                    </svg>
                    <div class="mt-1 flex justify-between px-1 font-inter text-[10px] text-slate-400">
                        @foreach ($titikKoordinat as $titik)
                            <span>{{ $titik['bulan'] }}</span>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <div class="mb-3 flex items-center justify-between">
            <h2 class="font-inter font-semibold text-[13px] text-black">Log Aktivitas</h2>
            <a href="" class="flex items-center gap-1 font-inter text-[11px] font-semibold text-blue-600 hover:text-blue-700">
                Lihat Semua
                <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <path d="M9 6l6 6-6 6" />
                </svg>
            </a>
        </div>

        @if (isset($aktivitasTerbaru) && count($aktivitasTerbaru))
            <div class="mb-6 rounded-xl bg-white shadow-[0px_4px_16px_0px_#0F172A14]">
                @foreach ($aktivitasTerbaru as $aktivitas)
                    <div class="flex items-start gap-3 px-4 py-4 {{ !$loop->last ? 'border-b border-slate-100' : '' }}">
                        <span class="mt-1.5 h-2 w-2 shrink-0 rounded-full {{ $aktivitas->dot }}"></span>
                        <div>
                            <p class="font-inter text-[13px] font-semibold text-black">
                                {{ $aktivitas->judul }}
                                @if ($aktivitas->sorot)
                                    <span class="{{ $aktivitas->sorot_color }}">{{ $aktivitas->sorot }}</span>
                                @endif
                            </p>
                            <p class="mt-0.5 font-inter text-xs text-slate-500">{!! $aktivitas->keterangan !!}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="mb-6 rounded-xl bg-white py-10 text-center shadow-[0px_4px_16px_0px_#0F172A14]">
                <p class="font-inter text-sm text-slate-400">Belum ada aktivitas terbaru.</p>
            </div>
        @endif
    </div>
</div>
@endsection
