@extends('layouts.index')

@section('layouts')

@php
    $mahasiswa = (object) [
        'id' => 1,
        'nama' => 'Nama Mhs',
        'nim' => '10125698',
        'program_studi' => 'Prodi',
        'semester' => '5',
        'dosenPa' => 'Nama Dosen, Gelar',
        'email' => 'email@email.com',
        'nomor_telepon' => '0987654321',
    ];
@endphp

<div class="pb-5">
    <div class="relative overflow-hidden bg-gradient-to-br from-[#22C55E] via-[#16A34A] to-[#15803D] px-5 pb-12 pt-10">
        <div class="flex items-center gap-3">
            <a href="{{ route('dosen.daftar-mahasiswa.index') }}"
                class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-white/20 text-white hover:bg-white/30">
                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <path d="M15 6l-6 6 6 6" />
                </svg>
            </a>
            <div>
                <h1 class="font-jakarta text-xl font-extrabold text-white">Detail Mahasiswa</h1>
                <p class="mt-1 font-inter text-xs text-white">Informasi lengkap data mahasiswa</p>
            </div>
        </div>
    </div>

    <div class="px-5 pt-6">
        <div class="mb-6 flex items-center gap-3 rounded-xl border border-[#DDD6FE] bg-[#EDE9FE]/50 p-4">
            <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-[#22C55E]">
                <svg class="h-6 w-6 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                    <circle cx="12" cy="7" r="4" />
                </svg>
            </span>
            <div>
                <p class="font-jakarta text-base font-extrabold text-black">{{ $mahasiswa->nama }}</p>
                <p class="font-inter text-xs text-slate-500">{{ $mahasiswa->program_studi }} &bull; Semester {{ $mahasiswa->semester }}</p>
            </div>
        </div>

        <div class="mb-6 flex flex-col divide-y divide-slate-100 rounded-2xl bg-white p-5 shadow-[0px_4px_16px_0px_#0F172A14]">
            <div class="py-3 first:pt-0">
                <p class="font-inter text-xs text-slate-500">NIM</p>
                <p class="mt-1 font-inter text-sm font-semibold text-black">{{ $mahasiswa->nim }}</p>
            </div>
            <div class="py-3 first:pt-0">
                <p class="font-inter text-xs text-slate-500">Nama Lengkap</p>
                <p class="mt-1 font-inter text-sm font-semibold text-black">{{ $mahasiswa->nama }}</p>
            </div>
            <div class="py-3">
                <p class="font-inter text-xs text-slate-500">Email</p>
                <p class="mt-1 font-inter text-sm font-semibold text-black">{{ $mahasiswa->email }}</p>
            </div>
            <div class="py-3">
                <p class="font-inter text-xs text-slate-500">Nomor Telepon</p>
                <p class="mt-1 font-inter text-sm font-semibold text-black">{{ $mahasiswa->nomor_telepon ?? '-' }}</p>
            </div>
            <div class="py-3">
                <p class="font-inter text-xs text-slate-500">Program Studi</p>
                <p class="mt-1 font-inter text-sm font-semibold text-black">{{ $mahasiswa->program_studi }}</p>
            </div>
            <div class="py-3 last:pb-0">
                <p class="font-inter text-xs text-slate-500">Semester</p>
                <p class="mt-1 font-inter text-sm font-semibold text-black">Semester {{ $mahasiswa->semester }}</p>
            </div>
        </div>

        <div class="mb-6 flex flex-col">
            <a href="{{ route('dosen.daftar-mahasiswa.index') }}"
                class="flex items-center justify-center rounded-lg border border-slate-200 py-3 font-inter text-sm font-semibold text-black hover:bg-slate-50">
                Kembali
            </a>
        </div>
    </div>
</div>
@endsection
