@extends('layouts.index')

@section('layouts')
@php
    $jamSekarang ??= now()->hour;
    $sapaan =
        $jamSekarang < 11
            ? 'Selamat Pagi'
            : ($jamSekarang < 15
                ? 'Selamat Siang'
                : ($jamSekarang < 18
                    ? 'Selamat Sore'
                    : 'Selamat Malam'));
@endphp
<div class="pb-5">
    <div class="relative overflow-hidden rounded-b-[20px] bg-gradient-to-br from-[#2563ED] via-[#2251E3] to-[#1D4ED8] px-5 pb-6 pt-5">
        <div class="flex items-start justify-between">
            <div class="flex flex-col justify-between">
                <p class="font-inter text-xs text-white">{{ $sapaan }},</p>
                <h1 class="font-jakarta text-xl font-extrabold text-white">
                    {{ $mahasiswa->nama }}
                </h1>
                <p class="font-inter text-xs text-white">
                    NIM: {{ $mahasiswa->nim }} &bull; {{ $mahasiswa->prodi }} &bull; Sem {{ $mahasiswa->semester }}
                </p>
            </div>
            <div class="w-[60px] h-[60px] flex flex-col justify-center items-center rounded-lg bg-white/25 shadow-[0px_0px_4px_0px_#00000040]">
                <span class="text-lg font-bold text-white">{{ $sesiTerpakai }}/{{ $sesiTotal }}</span>
                <span class="text-[10px] text-blue-100">Sesi</span>
            </div>
        </div>
        <div class="mt-5 rounded-lg bg-white/20 p-4 shadow-[0px_0px_4px_0px_#00000040]">
            <div class="flex items-center justify-between">
                <span class="font-inter text-xs text-white">Progress Bimbingan</span>
                <span class="font-inter text-xs font-extrabold text-white">{{ $progressBimbingan }} %</span>
            </div>
            <div class="mt-2 h-[6px] w-full overflow-hidden rounded-full bg-white/25">
                <div class="h-full rounded-full bg-white/80" style="width: {{ $progressBimbingan }}%"></div>
            </div>
            <p class="mt-2 font-inter text-[10px] text-white">Dosen: {{ $dosenPa }}</p>
        </div>
    </div>
    <div class="px-5 pt-6">
        <div class="mb-3 flex items-center justify-between">
            <h2 class="font-inter font-semibold text-[13px] text-black">Bimbingan Mendatang</h2>
            {{-- <a href="{{ route('bimbingan.index') }}" class="flex items-center gap-1 text-sm font-semibold text-blue-600 hover:text-blue-700"> --}}
            <a href="{{ route('mahasiswa.status-jadwal.index') }}" class="flex items-center gap-1 font-inter text-[11px] font-semibold text-blue-600 hover:text-blue-700">
                Lihat Semua
                <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <path d="M9 6l6 6-6 6" />
                </svg>
            </a>
        </div>
        {{-- <a href="{{ $bimbinganMendatang->url }}" class="mb-6 block rounded-2xl bg-gradient-to-br from-blue-700 to-blue-600 p-5"> --}}
        @if ($bimbinganMendatang)
            <a href="{{ route('mahasiswa.status-jadwal.index') }}" class="mb-6 block rounded-2xl bg-gradient-to-br from-[#2563ED] via-[#2251E3] to-[#1D4ED8] p-5">
                <div class="flex items-start justify-between">
                    <div class="flex flex-col items-start justify-between">
                        <span class="inline-flex items-center gap-1 rounded-xl bg-[#DCFCE7] px-3 py-1 font-inter text-[10px] text-[#16A34A]">
                            <svg class="h-3 w-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                                <path d="M5 13l4 4L19 7" />
                            </svg>
                            {{ $bimbinganMendatang->status }}
                        </span>
                        <p class="mt-3 font-jakarta text-lg font-extrabold text-white">
                            {{ $bimbinganMendatang->topik }}
                        </p>
                        <p class="font-inter text-xs text-white">{{ $bimbinganMendatang->dosen }}</p>
                        <div class="mt-3 flex items-center gap-4 text-[10px] text-white">
                            <span class="flex items-center gap-1.5">
                                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                    <rect x="3" y="4" width="18" height="17" rx="2" />
                                    <path d="M3 9h18M8 2v4M16 2v4" />
                                </svg>
                                {{ $bimbinganMendatang->tanggal }}
                            </span>
                            <span class="flex items-center gap-1.5">
                                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                    <circle cx="12" cy="12" r="9" />
                                    <path d="M12 7v5l3 3" />
                                </svg>
                                {{ $bimbinganMendatang->jam }}
                            </span>
                        </div>
                    </div>
                    <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-white/25">
                        <svg class="h-4 w-4 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2.5">
                            <path d="M9 6l6 6-6 6" />
                        </svg>
                    </span>
                </div>
            </a>
        @else
            <div class="mb-6 rounded-xl bg-white py-10 text-center shadow-[0px_4px_16px_0px_#0F172A14]">
                <p class="font-inter text-sm text-slate-400">Belum ada bimbingan mendatang.</p>
            </div>
        @endif
        <h2 class="mb-3 font-inter font-semibold text-[13px] text-black">Skor Perkembangan</h2>
        <div class="mb-6 grid grid-cols-3 gap-7">
            <div class="rounded-lg bg-white min-w-[100px] min-h-[70px] flex flex-col justify-center items-center shadow-[0px_4px_16px_0px_#0F172A14]">
                <p class="font-jakarta text-2xl font-extrabold text-[#16A34A]">{{ number_format($skor['partisipasi'], 1) }}</p>
                <p class="mt-1 font-inter text-xs text-black">Partisipasi</p>
            </div>
            <div class="rounded-lg bg-white min-w-[100px] min-h-[70px] flex flex-col justify-center items-center shadow-[0px_4px_16px_0px_#0F172A14]">
                <p class="font-jakarta text-2xl font-extrabold text-[#2653EB]">{{ number_format($skor['pemahaman'], 1) }}</p>
                <p class="mt-1 font-inter text-xs text-black">Pemahaman</p>
            </div>
            <div class="rounded-lg bg-white min-w-[100px] min-h-[70px] flex flex-col justify-center items-center shadow-[0px_4px_16px_0px_#0F172A14]">
                <p class="font-jakarta text-2xl font-extrabold text-[#F59E0B]">{{ number_format($skor['keseluruhan'], 1) }}</p>
                <p class="mt-1 font-inter text-xs text-black">Keseluruhan</p>
            </div>
        </div>
        <h2 class="mb-3 font-inter font-semibold text-[13px] text-black">Aksi Cepat</h2>
        <div class="mb-6 grid grid-cols-3 gap-7">
            {{-- <a href="{{ route('bimbingan.create') }}" class="flex flex-col items-center gap-2 rounded-2xl border border-slate-100 bg-white py-5 shadow-sm hover:bg-slate-50"> --}}
            <a href="{{ route('mahasiswa.ajukan-bimbingan.index') }}"
                class="flex flex-col items-center justify-center gap-2 rounded-lg bg-white min-w-[100px] min-h-[120px] shadow-[0px_4px_16px_0px_#0F172A14]">
                <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#2653EB]/15">
                    <svg class="h-6 w-6 text-[#2653EB]" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <path d="M12 5v14M5 12h14" />
                    </svg>
                </span>
                <span class="font-inter text-center text-xs text-black">Ajukan<br>Bimbingan</span>
            </a>
            {{-- <a href="{{ route('bimbingan.riwayat') }}" class="flex flex-col items-center gap-2 rounded-2xl border border-slate-100 bg-white py-5 shadow-sm hover:bg-slate-50"> --}}
            <a href="{{ route('mahasiswa.riwayat-bimbingan.index') }}"
                class="flex flex-col items-center justify-center gap-2 rounded-lg bg-white min-w-[100px] min-h-[120px] shadow-[0px_4px_16px_0px_#0F172A14]">
                <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#16A34A]/15">
                    <svg class="h-6 w-6 text-[#16A34A]" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="1.8">
                        <path d="M4 5.5A2.5 2.5 0 0 1 6.5 3H12v18H6.5A2.5 2.5 0 0 1 4 18.5v-13Z" />
                        <path d="M20 5.5A2.5 2.5 0 0 0 17.5 3H12v18h5.5a2.5 2.5 0 0 0 2.5-2.5v-13Z" />
                    </svg>
                </span>
                <span class="font-inter text-center text-xs text-black">Riwayat<br>Bimbingan</span>
            </a>
            {{-- <a href="{{ route('evaluasi.index') }}" class="flex flex-col items-center gap-2 rounded-2xl border border-slate-100 bg-white py-5 shadow-sm hover:bg-slate-50"> --}}
            <a href="{{ route('mahasiswa.evaluasi-akademik.index') }}"
                class="flex flex-col items-center justify-center gap-2 rounded-lg bg-white min-w-[100px] min-h-[120px] shadow-[0px_4px_16px_0px_#0F172A14]">
                <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#F59E0B]/15">
                    <svg class="h-6 w-6 text-[#F59E0B]" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <path d="M5 20V10M12 20V4M19 20v-7" />
                    </svg>
                </span>
                <span class="font-inter text-center text-xs text-black">Evaluasi<br>Akademik</span>
            </a>
        </div>
        <div class="mb-3 flex items-center justify-between">
            <h2 class="font-inter font-semibold text-[13px] text-black">Bimbingan Terakhir</h2>
            <a href="{{ route('mahasiswa.riwayat-bimbingan.index') }}" class="flex items-center gap-1 font-inter text-[11px] font-semibold text-blue-600 hover:text-blue-700">
                Lihat Semua
                <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <path d="M9 6l6 6-6 6" />
                </svg>
            </a>
        </div>
        @if ($bimbinganTerakhir)
            @php
                $statusConfig = [
                    'disetujui' => [
                        'label' => 'Disetujui',
                        'icon_bg' => 'bg-[#16A34A]/15',
                        'icon_color' => 'text-[#16A34A]',
                        'badge_bg' => 'bg-[#DCFCE7]',
                        'badge_text' => 'text-[#16A34A]',
                    ],
                    'ditolak' => [
                        'label' => 'Ditolak',
                        'icon_bg' => 'bg-[#DC2626]/15',
                        'icon_color' => 'text-[#DC2626]',
                        'badge_bg' => 'bg-[#FEE2E2]',
                        'badge_text' => 'text-[#DC2626]',
                    ],
                    'menunggu' => [
                        'label' => 'Menunggu',
                        'icon_bg' => 'bg-[#F59E0B]/15',
                        'icon_color' => 'text-[#F59E0B]',
                        'badge_bg' => 'bg-[#FEF3C7]',
                        'badge_text' => 'text-[#F59E0B]',
                    ],
                ][$bimbinganTerakhir->status];
            @endphp
            <div class="rounded-xl bg-white min-w-[350px] min-h-[120px] shadow-[0px_4px_16px_0px_#0F172A14] p-4">
                <div class="flex items-start justify-between">
                    <div class="flex items-start gap-3">
                        <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#2653EB]/15">
                            <svg class="h-6 w-6 text-[#2653EB]" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="1.8">
                                <path d="M4 5.5A2.5 2.5 0 0 1 6.5 3H12v18H6.5A2.5 2.5 0 0 1 4 18.5v-13Z" />
                                <path d="M20 5.5A2.5 2.5 0 0 0 17.5 3H12v18h5.5a2.5 2.5 0 0 0 2.5-2.5v-13Z" />
                            </svg>
                        </span>
                        <div>
                            <p class="font-inter text-[13px] font-semibold text-black">{{ $bimbinganTerakhir->judul }}</p>
                            <p class="mt-1 font-inter text-xs font-light text-black">Deskripsi</p>
                            <p class="font-inter text-xs font-light text-black">{{ $bimbinganTerakhir->catatan }}</p>
                            <span class="mt-2 inline-flex items-center gap-1 rounded-xl {{ $statusConfig['badge_bg'] }} px-2.5 py-1 text-[10px] {{ $statusConfig['badge_text'] }}">
                                @if ($bimbinganTerakhir->status === 'disetujui')
                                    <svg class="h-3 w-3" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="3">
                                        <path d="M5 13l4 4L19 7" />
                                    </svg>
                                @elseif ($bimbinganTerakhir->status === 'ditolak')
                                    <svg class="h-3 w-3" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="3">
                                        <path d="M6 6l12 12M18 6L6 18" />
                                    </svg>
                                @else
                                    <svg class="h-3 w-3" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2.5">
                                        <circle cx="12" cy="12" r="9" />
                                        <path d="M12 7v5l3 3" />
                                    </svg>
                                @endif
                                {{ $statusConfig['label'] }}
                            </span>
                        </div>
                    </div>
                    <span class="font-inter whitespace-nowrap text-[10px] text-black">{{ $bimbinganTerakhir->tanggal }}</span>
                </div>
            </div>
        @else
            <div class="rounded-xl bg-white py-10 text-center shadow-[0px_4px_16px_0px_#0F172A14]">
                <p class="font-inter text-sm text-slate-400">Belum ada riwayat bimbingan.</p>
            </div>
        @endif
    </div>
</div>
@endsection
