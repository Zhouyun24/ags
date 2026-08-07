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

    $manajemen = [
        [
            'label' => 'Mahasiswa',
            'deskripsi' => 'Kelola Data',
            'jumlah' => $ringkasan['mahasiswa'],
            'route' => 'operator.kelola-mahasiswa.index',
            'icon_bg' => 'bg-[#2653EB]/15',
            'icon_color' => 'text-[#2653EB]',
            'jumlah_color' => 'text-[#2653EB]',
            'icon' => 'users',
        ],
        [
            'label' => 'Dosen',
            'deskripsi' => 'Kelola Data',
            'jumlah' => $ringkasan['dosen'],
            'route' => 'operator.kelola-dosen.index',
            'icon_bg' => 'bg-[#16A34A]/15',
            'icon_color' => 'text-[#16A34A]',
            'jumlah_color' => 'text-[#16A34A]',
            'icon' => 'graduation-cap',
        ],
        [
            'label' => 'Operator',
            'deskripsi' => 'Kelola Data',
            'jumlah' => $ringkasan['operator'],
            'route' => 'operator.kelola-operator.index',
            'icon_bg' => 'bg-[#7C3AED]/15',
            'icon_color' => 'text-[#7C3AED]',
            'jumlah_color' => 'text-[#7C3AED]',
            'icon' => 'shield',
        ],
        [
            'label' => 'Monitoring',
            'deskripsi' => 'Kelola Data',
            'jumlah' => null,
            'route' => 'operator.monitoring.index',
            'icon_bg' => 'bg-[#F59E0B]/15',
            'icon_color' => 'text-[#F59E0B]',
            'jumlah_color' => 'text-[#F59E0B]',
            'icon' => 'chart',
        ],
    ];

@endphp

<div class="pb-5" x-data="{ showEksporModal: {{ (session('error_export') || $errors->any()) ? 'true' : 'false' }} }">
    <div class="relative overflow-hidden rounded-b-[20px] bg-gradient-to-br from-[#8B5CF6] via-[#7C3AED] to-[#6D28D9] px-5 pb-6 pt-5">
        <div class="flex flex-col justify-between">
            <p class="font-inter text-xs text-white">{{ $sapaan }},</p>
            <h1 class="font-jakarta text-xl font-extrabold text-white">
                {{ $operator->nama }}
            </h1>
            <p class="font-inter text-xs text-white">
                {{ $operator->idOperator }} &bull; {{ $operator->institusi }}
            </p>
        </div>

        <div class="mt-5 grid grid-cols-2 gap-3">
            <div class="flex items-center gap-3 rounded-lg bg-white/15 p-4 shadow-[0px_0px_4px_0px_#00000040]">
                <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-white/20">
                    <svg class="h-5 w-5 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <path d="M17 20v-2a4 4 0 0 0-4-4H7a4 4 0 0 0-4 4v2" />
                        <circle cx="10" cy="7" r="4" />
                        <path d="M23 20v-2a4 4 0 0 0-3-3.87" />
                        <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                    </svg>
                </span>
                <div>
                    <p class="font-jakarta text-lg font-extrabold text-white">{{ $ringkasan['mahasiswa'] }}</p>
                    <p class="font-inter text-[10px] text-white">Total Mahasiswa</p>
                </div>
            </div>
            <div class="flex items-center gap-3 rounded-lg bg-white/15 p-4 shadow-[0px_0px_4px_0px_#00000040]">
                <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-white/20">
                    <svg class="h-5 w-5 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <path d="m22 10-10-5L2 10l10 5 10-5Z" />
                        <path d="M6 12v5c0 1.1 2.7 2 6 2s6-.9 6-2v-5" />
                    </svg>
                </span>
                <div>
                    <p class="font-jakarta text-lg font-extrabold text-white">{{ $ringkasan['dosen'] }}</p>
                    <p class="font-inter text-[10px] text-white">Total Dosen</p>
                </div>
            </div>
            <div class="flex items-center gap-3 rounded-lg bg-white/15 p-4 shadow-[0px_0px_4px_0px_#00000040]">
                <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-white/20">
                    <svg class="h-5 w-5 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <rect x="3" y="4" width="18" height="17" rx="2" />
                        <path d="M3 9h18M8 2v4M16 2v4" />
                    </svg>
                </span>
                <div>
                    <p class="font-jakarta text-lg font-extrabold text-white">{{ $ringkasan['jadwalAktif'] }}</p>
                    <p class="font-inter text-[10px] text-white">Jadwal Aktif</p>
                </div>
            </div>
            <div class="flex items-center gap-3 rounded-lg bg-white/15 p-4 shadow-[0px_0px_4px_0px_#00000040]">
                <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-white/20">
                    <svg class="h-5 w-5 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <circle cx="12" cy="12" r="9" />
                        <path d="M8 12.5l2.5 2.5L16 9" />
                    </svg>
                </span>
                <div>
                    <p class="font-jakarta text-lg font-extrabold text-white">{{ $ringkasan['sesiSelesai'] }}</p>
                    <p class="font-inter text-[10px] text-white">Sesi Selesai</p>
                </div>
            </div>
        </div>
    </div>

    <div class="px-5 pt-6">
        <h2 class="mb-3 font-inter font-semibold text-[13px] text-black">Manajemen Sistem</h2>
        <div class="mb-6 grid grid-cols-2 gap-4">
            @foreach ($manajemen as $item)
                <a href="{{ Route::has($item['route']) ? route($item['route']) : '#' }}"
                    class="rounded-xl bg-white p-4 shadow-[0px_4px_16px_0px_#0F172A14]">
                    <div class="flex items-start justify-between">
                        <span class="flex h-10 w-10 items-center justify-center rounded-xl {{ $item['icon_bg'] }}">
                            <svg class="h-5 w-5 {{ $item['icon_color'] }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                @switch($item['icon'])
                                    @case('users')
                                        <path d="M17 20v-2a4 4 0 0 0-4-4H7a4 4 0 0 0-4 4v2" />
                                        <circle cx="10" cy="7" r="4" />
                                        <path d="M23 20v-2a4 4 0 0 0-3-3.87" />
                                        <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                                        @break

                                    @case('graduation-cap')
                                        <path d="m22 10-10-5L2 10l10 5 10-5Z" />
                                        <path d="M6 12v5c0 1.1 2.7 2 6 2s6-.9 6-2v-5" />
                                        @break

                                    @case('shield')
                                        <path d="M12 3 4 6v6c0 5 3.4 8.7 8 9 4.6-.3 8-4 8-9V6l-8-3Z" />
                                        @break

                                    @case('chart')
                                        <path d="M5 20V10M12 20V4M19 20v-7" />
                                        @break
                                @endswitch
                            </svg>
                        </span>
                        @if (!is_null($item['jumlah']))
                            <span class="font-jakarta text-lg font-extrabold {{ $item['jumlah_color'] }}">{{ $item['jumlah'] }}</span>
                        @endif
                    </div>
                    <p class="mt-3 font-inter text-sm font-semibold text-black">{{ $item['label'] }}</p>
                    <p class="font-inter text-xs text-slate-500">{{ $item['deskripsi'] }}</p>
                </a>
            @endforeach
        </div>

        <div class="mb-3 flex items-center justify-between">
            <h2 class="font-inter font-semibold text-[13px] text-black">Aktivitas Terbaru</h2>
            <button type="button" @click="showEksporModal = true"
                class="flex items-center gap-1 font-inter text-[11px] font-semibold text-blue-600 hover:text-blue-700">
                Lihat Semua
                <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <path d="M9 6l6 6-6 6" />
                </svg>
            </button>
        </div>

            <div x-show="showEksporModal" x-cloak
                class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 px-5"
                @click.self="showEksporModal = false">
                <div x-show="showEksporModal"
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 translate-y-4"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    class="w-full max-w-sm rounded-2xl bg-white p-6 shadow-xl">
                    <form action="{{ route('operator.monitoring.export') }}" method="GET">
                        <p class="font-inter text-sm text-black">Ekspor untuk melihat log aktivitas lebih lanjut</p>

                        <div class="mt-5">
                            <p class="font-inter text-sm font-semibold text-black">
                                Pilih Periode
                                <span class="font-normal text-xs text-slate-400">(*Periode yang dipilih hanya bisa di tahun yang sama)</span>
                            </p>
                        </div>

                        @if (session('error_export') || $errors->any())
                            <div class="mt-4 rounded-lg bg-red-50 p-3 text-sm text-red-600">
                                {{ session('error_export') ?? $errors->first() }}
                            </div>
                        @endif

                        <div class="mt-4">
                            <label class="mb-1.5 block font-inter text-sm font-semibold text-black">Dari</label>
                            <div class="relative">
                                <svg class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                    <rect x="3" y="5" width="18" height="16" rx="2" />
                                    <path d="M8 3v4M16 3v4M3 10h18" />
                                </svg>
                                <input type="date" name="dari"
                                    class="w-full rounded-lg bg-slate-100 py-3 pl-10 pr-3 font-inter text-sm text-slate-400 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-[#2653EB]"
                                    placeholder="DD/MM/YYYY" required>
                            </div>
                        </div>

                        <div class="mt-4">
                            <label class="mb-1.5 block font-inter text-sm font-semibold text-black">Sampai</label>
                            <div class="relative">
                                <svg class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                    <rect x="3" y="5" width="18" height="16" rx="2" />
                                    <path d="M8 3v4M16 3v4M3 10h18" />
                                </svg>
                                <input type="date" name="sampai"
                                    class="w-full rounded-lg bg-slate-100 py-3 pl-10 pr-3 font-inter text-sm text-slate-400 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-[#2653EB]"
                                    placeholder="DD/MM/YYYY" required>
                            </div>
                        </div>

                        <div class="mt-6 grid grid-cols-2 gap-3">
                            <button type="button" @click="showEksporModal = false"
                                class="rounded-full border border-[#2653EB] py-3 font-inter text-sm font-semibold text-[#2653EB] hover:bg-blue-50">
                                Batal
                            </button>
                            <button type="submit" @click="showEksporModal = false"
                                class="w-full rounded-full bg-[#2653EB] py-3 font-inter text-sm font-semibold text-white hover:bg-blue-700">
                                Ekspor
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        @if (count($aktivitasTerbaru))
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
