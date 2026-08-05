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

    $dosen ??= (object) [
        'nama' => '',
        'nip' => '',
        'prodi' => '',
    ];

    $today = now()->format('d/m/Y');
    $jadwalMendatangColl = collect($jadwalMendatang ?? []);
    $itemHariIni = $jadwalMendatangColl->firstWhere('tanggal', $today);

    $ringkasan = [
        'pending' => $statistik->jadwalMenunggu ?? 0,
        'hariIni' => $jadwalMendatangColl->where('tanggal', $today)->count(),
        'mahasiswa' => $statistik->totalMahasiswa ?? 0,
        'selesai' => collect($mahasiswas ?? [])->sum('total_sesi'),
    ];

    $permintaanMenunggu = $statistik->jadwalMenunggu ?? 0;

    $jadwalHariIni = $itemHariIni
        ? (object) [
            'judul' => $itemHariIni->mahasiswa ?? '',
            'topik' => $itemHariIni->topik ?? '',
            'jam' => $itemHariIni->jam ?? '',
            'status' => 'disetujui',
        ]
        : null;
@endphp

<div class="pb-5">
    <div class="relative overflow-hidden rounded-b-[20px] bg-gradient-to-br from-[#22C55E] via-[#16A34A] to-[#15803D] px-5 pb-6 pt-5">
        <div class="flex flex-col justify-between">
            <p class="font-inter text-xs text-white">{{ $sapaan }},</p>
            <h1 class="font-jakarta text-xl font-extrabold text-white">
                {{ $dosen->nama }}
            </h1>
            <p class="font-inter text-xs text-white">
                NIP: {{ $dosen->nip }} &bull; {{ $dosen->prodi }}
            </p>
        </div>

        <div class="mt-5 grid grid-cols-4 gap-2">
            <div class="flex flex-col items-center justify-center rounded-lg bg-white/20 py-3 shadow-[0px_0px_4px_0px_#00000040]">
                <svg class="h-4 w-4 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="9" />
                    <path d="M12 8v4l3 2" />
                </svg>
                <span class="mt-1 font-jakarta text-lg font-extrabold text-white">{{ $ringkasan['pending'] }}</span>
                <span class="font-inter text-[10px] text-white">Pending</span>
            </div>
            <div class="flex flex-col items-center justify-center rounded-lg bg-white/20 py-3 shadow-[0px_0px_4px_0px_#00000040]">
                <svg class="h-4 w-4 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                    <rect x="3" y="4" width="18" height="17" rx="2" />
                    <path d="M3 9h18M8 2v4M16 2v4" />
                </svg>
                <span class="mt-1 font-jakarta text-lg font-extrabold text-white">{{ $ringkasan['hariIni'] }}</span>
                <span class="font-inter text-[10px] text-white">Hari Ini</span>
            </div>
            <div class="flex flex-col items-center justify-center rounded-lg bg-white/20 py-3 shadow-[0px_0px_4px_0px_#00000040]">
                <svg class="h-4 w-4 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                    <path d="M17 20v-2a4 4 0 0 0-4-4H7a4 4 0 0 0-4 4v2" />
                    <circle cx="10" cy="7" r="4" />
                    <path d="M23 20v-2a4 4 0 0 0-3-3.87" />
                    <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                </svg>
                <span class="mt-1 font-jakarta text-lg font-extrabold text-white">{{ $ringkasan['mahasiswa'] }}</span>
                <span class="font-inter text-[10px] text-white">Mahasiswa</span>
            </div>
            <div class="flex flex-col items-center justify-center rounded-lg bg-white/20 py-3 shadow-[0px_0px_4px_0px_#00000040]">
                <svg class="h-4 w-4 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <circle cx="12" cy="12" r="9" />
                    <path d="M8 12.5l2.5 2.5L16 9" />
                </svg>
                <span class="mt-1 font-jakarta text-lg font-extrabold text-white">{{ $ringkasan['selesai'] }}</span>
                <span class="font-inter text-[10px] text-white">Selesai</span>
            </div>
        </div>
    </div>

    <div class="px-5 pt-6">
        @if ($permintaanMenunggu > 0)
            <a href="{{ route('dosen.persetujuan-jadwal.index') }}"
                class="mb-6 flex items-center justify-between rounded-2xl border border-[#F0D9A8] bg-[#FDF3E0] p-4">
                <div class="flex items-center gap-3">
                    <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#F59E0B]/15">
                        <svg class="h-5 w-5 text-[#F59E0B]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M12 9v4M12 17h.01" />
                            <path d="M10.29 3.86 1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0Z" />
                        </svg>
                    </span>
                    <div>
                        <p class="font-inter text-[13px] font-semibold text-black">{{ $permintaanMenunggu }} Permintaan Menunggu</p>
                        <p class="font-inter text-xs text-slate-500">Ketuk untuk meninjau jadwal bimbingan</p>
                    </div>
                </div>
                <svg class="h-4 w-4 shrink-0 text-[#F59E0B]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <path d="M9 6l6 6-6 6" />
                </svg>
            </a>
        @endif

        <div class="mb-3 flex items-center justify-between">
            <h2 class="font-inter font-semibold text-[13px] text-black">Jadwal Hari Ini</h2>
            <a href="{{ route('dosen.persetujuan-jadwal.index') }}" class="flex items-center gap-1 font-inter text-[11px] font-semibold text-blue-600 hover:text-blue-700">
                Lihat Semua
                <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <path d="M9 6l6 6-6 6" />
                </svg>
            </a>
        </div>

        @if ($jadwalHariIni)
            @php
                $statusConfig = [
                    'disetujui' => [
                        'label' => 'Disetujui',
                        'badge_bg' => 'bg-[#DCFCE7]',
                        'badge_text' => 'text-[#16A34A]',
                    ],
                    'ditolak' => [
                        'label' => 'Ditolak',
                        'badge_bg' => 'bg-[#FEE2E2]',
                        'badge_text' => 'text-[#DC2626]',
                    ],
                    'menunggu' => [
                        'label' => 'Menunggu',
                        'badge_bg' => 'bg-[#FEF3C7]',
                        'badge_text' => 'text-[#F59E0B]',
                    ],
                ][$jadwalHariIni->status];
            @endphp
            <div class="mb-6 rounded-xl bg-white min-h-[80px] shadow-[0px_4px_16px_0px_#0F172A14] p-4">
                <div class="flex items-start justify-between">
                    <div class="flex items-start gap-3">
                        <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#16A34A]/15">
                            <svg class="h-5 w-5 text-[#16A34A]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                                <circle cx="12" cy="7" r="4" />
                            </svg>
                        </span>
                        <div>
                            <p class="font-inter text-[13px] font-semibold text-black">{{ $jadwalHariIni->judul }}</p>
                            <p class="font-inter text-xs text-slate-500">{{ $jadwalHariIni->topik }}</p>
                            <span class="mt-2 inline-flex items-center gap-1 rounded-xl {{ $statusConfig['badge_bg'] }} px-2.5 py-1 text-[10px] {{ $statusConfig['badge_text'] }}">
                                @if ($jadwalHariIni->status === 'disetujui')
                                    <svg class="h-3 w-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                                        <path d="M5 13l4 4L19 7" />
                                    </svg>
                                @elseif ($jadwalHariIni->status === 'ditolak')
                                    <svg class="h-3 w-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                                        <path d="M6 6l12 12M18 6L6 18" />
                                    </svg>
                                @else
                                    <svg class="h-3 w-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                        <circle cx="12" cy="12" r="9" />
                                        <path d="M12 7v5l3 3" />
                                    </svg>
                                @endif
                                {{ $statusConfig['label'] }}
                            </span>
                        </div>
                    </div>
                    <span class="font-inter whitespace-nowrap text-[13px] font-semibold text-[#16A34A]">{{ $jadwalHariIni->jam }}</span>
                </div>
            </div>
        @else
            <div class="mb-6 rounded-xl bg-white py-10 text-center shadow-[0px_4px_16px_0px_#0F172A14]">
                <p class="font-inter text-sm text-slate-400">Belum ada jadwal hari ini.</p>
            </div>
        @endif

        <h2 class="mb-3 font-inter font-semibold text-[13px] text-black">Aksi Cepat</h2>
        <div class="mb-6 grid grid-cols-2 gap-4">
            <a href="{{ route('dosen.persetujuan-jadwal.index') }}"
                class="flex items-center gap-3 rounded-xl bg-white min-h-[80px] px-4 shadow-[0px_4px_16px_0px_#0F172A14]">
                <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#16A34A]/15">
                    <svg class="h-5 w-5 text-[#16A34A]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <path d="M9 5H7a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-2" />
                        <rect x="9" y="3" width="6" height="4" rx="1" />
                        <path d="M9 13l2 2 4-4" />
                    </svg>
                </span>
                <span class="font-inter text-xs text-black">Setujui<br>Jadwal</span>
            </a>
            <a href="{{ route('dosen.hasil-bimbingan.index') }}"
                class="flex items-center gap-3 rounded-xl bg-white min-h-[80px] px-4 shadow-[0px_4px_16px_0px_#0F172A14]">
                <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#2653EB]/15">
                    <svg class="h-5 w-5 text-[#2653EB]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <path d="M14 3H7a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V8l-5-5Z" />
                        <path d="M14 3v5h5" />
                        <path d="M9 13h6M9 17h6" />
                    </svg>
                </span>
                <span class="font-inter text-xs text-black">Hasil<br>Bimbingan</span>
            </a>
            <a href="{{ route('dosen.evaluasi-mahasiswa.index') }}"
                class="flex items-center gap-3 rounded-xl bg-white min-h-[80px] px-4 shadow-[0px_4px_16px_0px_#0F172A14]">
                <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#F59E0B]/15">
                    <svg class="h-5 w-5 text-[#F59E0B]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M5 20V10M12 20V4M19 20v-7" />
                    </svg>
                </span>
                <span class="font-inter text-xs text-black">Evaluasi<br>Mahasiswa</span>
            </a>
            <a href=""
                class="flex items-center gap-3 rounded-xl bg-white min-h-[80px] px-4 shadow-[0px_4px_16px_0px_#0F172A14]">
                <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#9333EA]/15">
                    <svg class="h-5 w-5 text-[#9333EA]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <path d="M17 20v-2a4 4 0 0 0-4-4H7a4 4 0 0 0-4 4v2" />
                        <circle cx="10" cy="7" r="4" />
                        <path d="M23 20v-2a4 4 0 0 0-3-3.87" />
                        <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                    </svg>
                </span>
                <span class="font-inter text-xs text-black">Daftar<br>Mahasiswa</span>
            </a>
        </div>
    </div>
</div>
@endsection