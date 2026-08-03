@extends('layouts.index')

@section('layouts')
@php
    $dosen ??= (object) [
        'nama' => 'Nama Dosen, Gelar',
        'prodi' => 'Informatika',
        'ketersediaan' => 'Senin - Jum\'at',
    ];
    $slotTersedia ??= ['09:00', '10:00', '11:00', '14:00', '15:00', '16:00'];
    $slotTerpilih ??= '10:00';
@endphp

<div x-data="{ selectedSlot: '{{ $slotTerpilih }}' }" class="pb-8">
    <div class="relative overflow-hidden bg-gradient-to-tl from-[#2563ED] via-[#2251E3] to-[#1D4ED8] px-5 min-h-[106px] flex flex-col justify-center">
        <h1 class="font-jakarta text-xl font-extrabold text-white">Ajukan Bimbingan</h1>
        <p class="mt-1 font-inter text-xs text-white">Pilih Jadwal yang sesuai dengan Dosen Pembimbing</p>
    </div>
    <div class="px-5 pt-6">
        <div class="mb-6 flex items-center gap-3 rounded-xl bg-white p-4 shadow-[0px_4px_16px_0px_#0F172A14]">
            <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-[6px] bg-[#2653EB]">
                <svg class="h-5 w-5 text-white" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 3 1 8.5l11 5.5 9-4.5V17h2V8.5L12 3Z" />
                    <path d="M5 10.9V15c0 1.7 3.1 4 7 4s7-2.3 7-4v-4.1l-7 3.5-7-3.5Z" />
                </svg>
            </span>
            <div>
                <p class="font-inter text-xs text-black">Dosen Pembimbing</p>
                <p class="font-jakarta text-xl font-extrabold text-black">{{ $dosen->nama }}</p>
                <p class="font-inter text-xs text-black">
                    {{ $dosen->prodi }} &bull; Tersedia: {{ $dosen->ketersediaan }}
                </p>
            </div>
        </div>
        <form action="{{ route('mahasiswa.ajukan-bimbingan.store') ?? '' }}" method="POST">
            @csrf
            <input type="hidden" name="waktu" x-model="selectedSlot">
            <div class="mb-5">
                <label class="mb-2 block font-inter text-[13px] font-semibold text-black">Topik Bimbingan</label>
                <div class="relative">
                    <span class="pointer-events-none absolute inset-y-0 left-3 flex items-center text-slate-400">
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                            <path d="M4 5.5A2.5 2.5 0 0 1 6.5 3H12v18H6.5A2.5 2.5 0 0 1 4 18.5v-13Z" />
                            <path d="M20 5.5A2.5 2.5 0 0 0 17.5 3H12v18h5.5a2.5 2.5 0 0 0 2.5-2.5v-13Z" />
                        </svg>
                    </span>
                    <input type="text" name="topik" placeholder="Contoh: Konsultasi Bab II"
                        class="w-full rounded-lg border border-slate-200 bg-white py-3 pl-10 pr-3 font-inter text-sm text-black placeholder:text-slate-400 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500">
                </div>
                @error('topik')
                    <p class="mt-1.5 font-inter text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-5 grid grid-cols-2 gap-4">
                <div>
                    <label class="mb-2 block font-inter text-[13px] font-semibold text-black">Tanggal</label>
                    <div class="relative">
                        <span class="pointer-events-none absolute inset-y-0 left-3 flex items-center text-slate-400">
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                <rect x="3" y="4" width="18" height="17" rx="2" />
                                <path d="M3 9h18M8 2v4M16 2v4" />
                            </svg>
                        </span>
                        <input type="text" name="tanggal" placeholder="DD/MM/YYYY"
                            onfocus="(this.type='date')" onblur="if(!this.value){this.type='text'}"
                            class="w-full rounded-lg border border-slate-200 bg-white py-3 pl-10 pr-3 font-inter text-sm text-black placeholder:text-slate-400 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500">
                    </div>
                    @error('tanggal')
                        <p class="mt-1.5 font-inter text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="mb-2 block font-inter text-[13px] font-semibold text-black">Waktu</label>
                    <div class="relative">
                        <span class="pointer-events-none absolute inset-y-0 left-3 flex items-center text-slate-400">
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                <circle cx="12" cy="12" r="9" />
                                <path d="M12 7v5l3 3" />
                            </svg>
                        </span>
                        <input type="text" name="waktu_manual" x-model="selectedSlot" readonly
                            class="w-full cursor-not-allowed rounded-lg border border-slate-200 bg-white py-3 pl-10 pr-3 font-inter text-sm text-black focus:outline-none">
                    </div>
                </div>
            </div>
            <div class="mb-6">
                <label class="mb-2 block font-inter text-[13px] font-semibold text-black">Slot Tersedia</label>
                <div class="grid grid-cols-4 gap-3">
                    @foreach ($slotTersedia as $slot)
                        <button type="button" @click="selectedSlot = '{{ $slot }}'"
                            :class="selectedSlot === '{{ $slot }}'
                                ? 'border-blue-600 bg-blue-50 text-blue-600'
                                : 'border-slate-200 bg-white text-black'"
                            class="rounded-lg border py-2.5 font-inter text-sm font-medium transition-colors">
                            {{ $slot }}
                        </button>
                    @endforeach
                </div>
                @error('waktu')
                    <p class="mt-1.5 font-inter text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>
            <div class="grid grid-cols-2 gap-4">
                <a href="{{ url()->previous() }}"
                    class="flex items-center justify-center rounded-lg border border-blue-600 py-3 font-inter text-sm font-semibold text-blue-600 hover:bg-blue-50">
                    Batal
                </a>
                <button type="submit"
                    class="flex items-center justify-center rounded-lg bg-gradient-to-br from-[#2563ED] via-[#2251E3] to-[#1D4ED8] py-3 font-inter text-sm font-semibold text-white hover:opacity-90">
                    Ajukan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection