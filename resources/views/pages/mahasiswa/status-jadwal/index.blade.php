@extends('layouts.index')

@section('layouts')
@php
    $jadwal ??= collect([
        (object) [
            'topik' => 'Topik Diskusi',
            'dosen' => 'Nama Dosen, Gelar',
            'tanggal' => 'DD/MM/YYYY',
            'jam' => 'HH.MM WIB',
            'status' => 'disetujui',
        ],
        (object) [
            'topik' => 'Topik Diskusi',
            'dosen' => 'Nama Dosen, Gelar',
            'tanggal' => 'DD/MM/YYYY',
            'jam' => 'HH.MM WIB',
            'status' => 'ditolak',
        ],
        (object) [
            'topik' => 'Topik Diskusi',
            'dosen' => 'Nama Dosen, Gelar',
            'tanggal' => 'DD/MM/YYYY',
            'jam' => 'HH.MM WIB',
            'status' => 'disetujui',
        ],
        (object) [
            'topik' => 'Topik Diskusi',
            'dosen' => 'Nama Dosen, Gelar',
            'tanggal' => 'DD/MM/YYYY',
            'jam' => 'HH.MM WIB',
            'status' => 'menunggu',
        ],
    ]);

    $jumlahMenunggu = $jadwal->where('status', 'menunggu')->count();
    $jumlahDitolak = $jadwal->where('status', 'ditolak')->count();
    $jumlahDisetujui = $jadwal->where('status', 'disetujui')->count();
@endphp

<div x-data="{ activeTab: 'semua' }" class="pb-8">
    <div class="relative overflow-hidden bg-gradient-to-tl from-[#2563ED] via-[#2251E3] to-[#1D4ED8] px-5 min-h-[106px] flex flex-col justify-center">
        <h1 class="font-jakarta text-xl font-extrabold text-white">Status Jadwal</h1>
        <p class="mt-1 font-inter text-xs text-white">{{ $jadwal->count() }} Jadwal Tercatat</p>
    </div>
    <div class="px-5 pt-5">
        <div class="mb-5 flex gap-4 overflow-x-auto pb-5 [-ms-overflow-style:none] [scrollbar-width:none] [&::-webkit-scrollbar]:hidden">
            <button type="button" @click="activeTab = 'semua'"
                :class="activeTab === 'semua' ? 'bg-[#2653EB] text-white' : 'bg-white text-black border border-slate-200'"
                class="shrink-0 rounded-[20px] px-4 py-2 font-inter text-xs transition-colors shadow-[0px_4px_16px_0px_#0F172A14]">
                Semua ({{ $jadwal->count() }})
            </button>
            <button type="button" @click="activeTab = 'menunggu'"
                :class="activeTab === 'menunggu' ? 'bg-[#2653EB] text-white' : 'bg-white text-black border border-slate-200'"
                class="shrink-0 rounded-[20px] px-4 py-2 font-inter text-xs transition-colors shadow-[0px_4px_16px_0px_#0F172A14]">
                Menunggu ({{ $jumlahMenunggu }})
            </button>
            <button type="button" @click="activeTab = 'ditolak'"
                :class="activeTab === 'ditolak' ? 'bg-[#2653EB] text-white' : 'bg-white text-black border border-slate-200'"
                class="shrink-0 rounded-[20px] px-4 py-2 font-inter text-xs transition-colors shadow-[0px_4px_16px_0px_#0F172A14]">
                Ditolak ({{ $jumlahDitolak }})
            </button>
            <button type="button" @click="activeTab = 'disetujui'"
                :class="activeTab === 'disetujui' ? 'bg-[#2653EB] text-white' : 'bg-white text-black border border-slate-200'"
                class="shrink-0 rounded-[20px] px-4 py-2 font-inter text-xs transition-colors shadow-[0px_4px_16px_0px_#0F172A14]">
                Disetujui ({{ $jumlahDisetujui }})
            </button>
        </div>
        <h2 class="mb-3 font-inter text-[13px] font-semibold text-black" x-text="{
            semua: 'Semua Jadwal',
            menunggu: 'Jadwal Menunggu',
            ditolak: 'Jadwal Ditolak',
            disetujui: 'Jadwal Disetujui',
        }[activeTab]">
            Semua Jadwal
        </h2>
        <div class="space-y-4">
            @foreach ($jadwal as $item)
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
                    ][$item->status];
                @endphp
                <div x-show="activeTab === 'semua' || activeTab === '{{ $item->status }}'"
                    class="rounded-xl bg-white p-4 shadow-[0px_4px_16px_0px_#0F172A14]">
                    <div class="flex items-start justify-between">
                        <div class="flex items-start gap-3">
                            <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl {{ $statusConfig['icon_bg'] }}">
                                <svg class="h-5 w-5 {{ $statusConfig['icon_color'] }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                    <rect x="3" y="4" width="18" height="17" rx="2" />
                                    <path d="M3 9h18M8 2v4M16 2v4" />
                                </svg>
                            </span>
                            <div>
                                <p class="font-jakarta text-xl font-extrabold text-black">{{ $item->topik }}</p>
                                <p class="mt-0.5 font-inter text-xs text-black">{{ $item->dosen }}</p>
                            </div>
                        </div>
                        <span class="inline-flex shrink-0 items-center gap-1 rounded-xl {{ $statusConfig['badge_bg'] }} px-3 py-1 font-inter text-[10px] font-medium {{ $statusConfig['badge_text'] }}">
                            @if ($item->status === 'disetujui')
                                <svg class="h-3 w-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                                    <path d="M5 13l4 4L19 7" />
                                </svg>
                            @elseif ($item->status === 'ditolak')
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
                    <div class="mt-3 flex items-center gap-4 border-t border-slate-100 pt-3 font-inter text-[11px] text-slate-500">
                        <span class="flex items-center gap-1.5">
                            <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                <rect x="3" y="4" width="18" height="17" rx="2" />
                                <path d="M3 9h18M8 2v4M16 2v4" />
                            </svg>
                            {{ $item->tanggal }}
                        </span>
                        <span class="flex items-center gap-1.5">
                            <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                <circle cx="12" cy="12" r="9" />
                                <path d="M12 7v5l3 3" />
                            </svg>
                            {{ $item->jam }}
                        </span>
                    </div>
                </div>
            @endforeach
        </div>
        <div x-show="
            (activeTab === 'menunggu' && {{ $jumlahMenunggu }} === 0) ||
            (activeTab === 'ditolak' && {{ $jumlahDitolak }} === 0) ||
            (activeTab === 'disetujui' && {{ $jumlahDisetujui }} === 0)
        " class="rounded-xl bg-white py-10 text-center shadow-[0px_4px_16px_0px_#0F172A14]">
            <p class="font-inter text-sm text-slate-400">Tidak ada jadwal untuk kategori ini</p>
        </div>
    </div>

    @if (session('success'))
        <div x-data="{ showSuccess: true }">
            <div x-show="showSuccess" x-cloak
                class="fixed inset-0 z-50 flex items-end justify-center bg-black/40 px-5 pb-8 sm:items-center"
                @click.self="showSuccess = false">
                <div x-show="showSuccess"
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 translate-y-4"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    class="w-full max-w-sm rounded-2xl bg-white p-6 text-center shadow-xl">
                    <span class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-[#DCFCE7]">
                        <svg class="h-6 w-6 text-[#16A34A]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                            <path d="M5 13l4 4L19 7" />
                        </svg>
                    </span>
                    <p class="mt-4 font-jakarta text-base font-extrabold text-black">Berhasil</p>
                    <p class="mt-1 font-inter text-xs text-slate-500">{{ session('success') }}</p>
                    <button type="button" @click="showSuccess = false"
                        class="mt-5 w-full rounded-lg bg-[#16A34A] py-3 font-inter text-sm font-semibold text-white hover:opacity-90">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection