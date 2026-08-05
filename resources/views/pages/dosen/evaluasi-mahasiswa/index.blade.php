@php
    $jumlahMenunggu = $jadwal->where('status', 'menunggu')->count();
    $jumlahDitolak = $jadwal->where('status', 'ditolak')->count();
    $jumlahselesai = $jadwal->where('status', 'disetujui')->count();
@endphp

@extends('layouts.index')

@section('layouts')
    <div x-data="{ activeTab: 'semua' }" class="pb-8">

        <div class="flex flex-col min-h-screen bg-slate-50 pb-10">

            <div class="overflow-hidden bg-[#10b981] px-6 pb-12 pt-10 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="font-['Plus_Jakarta_Sans'] text-2xl font-extrabold">
                            Evaluasi Mahasiwa
                        </h1>
                        <p class="mt-1 text-sm text-emerald-50">
                            Kelola nilai perkembangan Mahasiswa
                        </p>
                    </div>
                </div>
            </div>

            <div class="px-5 pt-5 flex flex-col items-center">

                <div
                    class="mb-2 flex gap-4 overflow-x-auto pb-5 [-ms-overflow-style:none] [scrollbar-width:none] [&::-webkit-scrollbar]:hidden">
                    <button type="button" @click="activeTab = 'semua'"
                        :class="activeTab === 'semua' ? 'bg-[#2653EB] text-white' :
                            'bg-white text-black border border-slate-200'"
                        class="shrink-0 rounded-[20px] px-4 py-2 font-inter text-xs transition-colors shadow-[0px_4px_16px_0px_#0F172A14]">
                        Semua ({{ $jadwal->count() }})
                    </button>
                    <button type="button" @click="activeTab = 'menunggu'"
                        :class="activeTab === 'menunggu' ? 'bg-[#2653EB] text-white' :
                            'bg-white text-black border border-slate-200'"
                        class="shrink-0 rounded-[20px] px-4 py-2 font-inter text-xs transition-colors shadow-[0px_4px_16px_0px_#0F172A14]">
                        Menunggu ({{ $jumlahMenunggu }})
                    </button>
                    <button type="button" @click="activeTab = 'disetujui'"
                        :class="activeTab === 'disetujui' ? 'bg-[#2653EB] text-white' :
                            'bg-white text-black border border-slate-200'"
                        class="shrink-0 rounded-[20px] px-4 py-2 font-inter text-xs transition-colors shadow-[0px_4px_16px_0px_#0F172A14]">
                        Selesai ({{ $jumlahselesai }})
                    </button>
                </div>

                <div class="mb-4 relative w-full max-w-md">
                    <input type="text" placeholder="Cari NIM atau Nama Mahasiswa"
                        class="w-full rounded-full bg-gray-100 py-2 pl-5 pr-12 text-sm text-gray-700 placeholder:text-gray-400 shadow-md outline-none transition-all duration-200 focus:bg-white focus:ring-2 focus:ring-blue-400" />

                    <button type="submit"
                        class="absolute right-4 top-1/2 -translate-y-1/2 text-black transition hover:scale-110">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M21 21l-4.35-4.35m1.85-5.15a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </button>
                </div>

                @forelse ($jadwal as $item)
                    <div x-show="activeTab === 'semua' || activeTab === '{{ $item->status }}'"
                    class="mt-4 w-full max-w-sm rounded-2xl bg-[#F7F9FC] p-5 shadow-md">

                        <div class="flex items-start justify-between">
                            <div class="flex gap-3">
                                <div class="flex h-11 w-11 items-center justify-center rounded-lg bg-[#DDE5FF]">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-[#4B5FD6]" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M15 19v-1a3 3 0 00-3-3H8a3 3 0 00-3 3v1m10-10a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                </div>

                                <div>
                                    <h2 class="text-2xl font-bold text-gray-900">
                                        {{ $item->nama }}
                                    </h2>

                                    <p class="text-sm text-gray-500">
                                        {{ $item->topik }} • {{ $item->nim }}
                                    </p>
                                </div>
                            </div>

                            <span @class([
                                'rounded-full px-3 py-1 text-xs font-medium',
                                'bg-[#FFF1DD] text-[#F59E0B]' => $item->status === 'menunggu',
                                'bg-[#DCFCE7] text-[#16A34A]' => $item->status === 'disetujui',
                            ])>
                                @if ($item->status === 'disetujui')
                                    ✅ Selesai
                                @elseif ($item->status === 'menunggu')
                                    ⏱ Menunggu
                                @endif
                            </span>
                        </div>

                        <div class="mt-5 flex gap-3">

                            <div
                                class="flex flex-1 items-center gap-2 rounded-md bg-[#DDE3FF] px-3 py-2 text-sm text-gray-700">
                                📅
                                <span> {{ $item->tanggal }} </span>
                            </div>

                            <div
                                class="flex flex-1 items-center gap-2 rounded-md bg-[#DDE3FF] px-3 py-2 text-sm text-gray-700">
                                🕒
                                <span> {{ $item->jam }} </span>
                            </div>

                        </div>

                        <div class="mt-6 grid grid-cols-3 gap-4">

                            <div class="rounded-xl bg-white py-4 text-center shadow-md">
                                <h3 class="text-3xl font-bold text-green-600">{{ $item->partisipasi }}</h3>
                                <p class="mt-1 text-xs text-gray-600">
                                    Partisipasi
                                </p>
                            </div>

                            <div class="rounded-xl bg-white py-4 text-center shadow-md">
                                <h3 class="text-3xl font-bold text-blue-600">{{ $item->pemahaman }}</h3>
                                <p class="mt-1 text-xs text-gray-600">
                                    Pemahaman
                                </p>
                            </div>

                            <div class="rounded-xl bg-white py-4 text-center shadow-md">
                                <h3 class="text-3xl font-bold text-orange-500">{{ $item->keseluruhan }}</h3>
                                <p class="mt-1 text-xs text-gray-600">
                                    Keseluruhan
                                </p>
                            </div>

                        </div>

                        <div class="mt-6 flex justify-end">
                            @if ($item->status === 'menunggu')
                                <a href="{{ route('dosen.penilaian.create', $item->id_hasil) }}"
                                    class="rounded-xl border px-10 py-3 font-semibold transition border-orange-400 text-orange-500 hover:bg-orange-500 hover:text-white">
                                    Isi Hasil
                                </a>
                            @else
                                <a href="{{ route('dosen.penilaian.edit', $item->id_perkembangan) }}"
                                    class="rounded-xl border px-10 py-3 font-semibold transition border-green-500 text-green-600 hover:bg-green-500 hover:text-white">
                                    Edit
                                </a>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="mt-4 w-full max-w-sm rounded-xl bg-white py-10 text-center shadow-[0px_4px_16px_0px_#0F172A14]">
                        <p class="font-inter text-sm text-slate-400">Belum ada hasil bimbingan untuk dinilai.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
    </div>
@endsection
