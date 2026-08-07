@extends('layouts.index')

@section('layouts')
@php
    $user ??= (object) [
        'nama' => 'Nama Pengguna',
        'role' => 'Dosen PA',
        'foto' => null,
        'email' => 'dosen@universitas.ac.id',
        'telepon' => '08xxxxxxxxxx',
        'nip' => '10124257',
        'prodi' => 'Teknik Informatika (TI)',
    ];
@endphp

<div x-data="{ showLogoutConfirm: false }" class="pb-8">

    <div class="relative overflow-hidden rounded-b-[28px] bg-gradient-to-br from-[#22C55E] via-[#16A34A] to-[#15803D] px-5 pb-16 pt-5 text-center">
        <h1 class="font-jakarta text-xl font-extrabold text-white">Profil Saya</h1>
        <p class="mt-1 font-inter text-xs text-blue-100">Kelola Informasi akun Anda</p>
    </div>

    <div class="relative px-7 z-10">
        @if (session('success'))
            <div class="-mt-8 mb-4 rounded-xl bg-emerald-500 p-3.5 text-center font-inter text-xs font-medium text-white shadow-md">
                {{ session('success') }}
            </div>
        @endif

        <div class="-mt-12 mb-5 flex flex-col items-center rounded-2xl bg-white p-6 shadow-[0px_4px_16px_0px_#0F172A14]">
            <div class="relative">
                <div class="flex h-20 w-20 items-center justify-center overflow-hidden rounded-full bg-[#22C55E] ring-4 ring-blue-100">
                    @if ($user->foto)
                        <img src="{{ $user->foto }}" alt="{{ $user->nama }}" class="h-full w-full object-cover">
                    @else
                        <svg class="h-9 w-9 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                            <circle cx="12" cy="8" r="4" />
                            <path d="M4 20c0-4 3.5-6 8-6s8 2 8 6" />
                        </svg>
                    @endif
                </div>
                <label for="upload-foto"
                    class="absolute -bottom-1 -right-1 flex h-7 w-7 cursor-pointer items-center justify-center rounded-full bg-[#22C55E] ring-2 ring-white hover:bg-blue-700">
                    <svg class="h-3.5 w-3.5 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M4 7h3l2-2h6l2 2h3v13H4V7Z" />
                        <circle cx="12" cy="13" r="3.5" />
                    </svg>
                    <input id="upload-foto" type="file" accept="image/*" class="hidden">
                </label>
            </div>
            <p class="mt-4 font-jakarta text-lg font-extrabold text-black">{{ $user->nama }}</p>
            <p class="font-inter text-xs text-slate-500">{{ $user->role }}</p>
        </div>

        <div class="mb-5 rounded-2xl bg-white p-5 shadow-[0px_4px_16px_0px_#0F172A14]">
            <p class="mb-3 font-inter text-sm font-semibold text-black">Informasi Pengguna</p>

            <div class="divide-y divide-slate-100">
                <div class="flex items-center justify-between py-3">
                    <span class="font-inter text-xs text-slate-400">Email</span>
                    <span class="font-inter text-xs font-medium text-black">{{ $user->email }}</span>
                </div>
                <div class="flex items-center justify-between py-3">
                    <span class="font-inter text-xs text-slate-400">Nomor Telepon</span>
                    <span class="font-inter text-xs font-medium text-black">{{ $user->telepon }}</span>
                </div>
                <div class="flex items-center justify-between py-3">
                    <span class="font-inter text-xs text-slate-400">NIP</span>
                    <span class="font-inter text-xs font-medium text-black">{{ $user->nip }}</span>
                </div>
                <div class="flex items-center justify-between py-3">
                    <span class="font-inter text-xs text-slate-400">Program Studi</span>
                    <span class="font-inter text-xs font-medium text-black">{{ $user->prodi }}</span>
                </div>
            </div>
        </div>

        <div class="mb-5 rounded-2xl bg-white p-2 shadow-[0px_4px_16px_0px_#0F172A14]">
            <a href="{{ route('dosen.profile.ubah-kata-sandi.index') }}"
                class="flex items-center gap-3 border-b border-slate-100 px-3 py-4 hover:bg-slate-50">
                <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-[#2653EB]/15">
                    <svg class="h-[18px] w-[18px] text-[#2653EB]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <rect x="5" y="11" width="14" height="9" rx="2" />
                        <path d="M8 11V7a4 4 0 0 1 8 0v4" />
                    </svg>
                </span>
                <span class="flex-1 font-inter text-sm text-black">Ubah Kata Sandi</span>
                <svg class="h-4 w-4 text-slate-300" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <path d="M9 6l6 6-6 6" />
                </svg>
            </a>
            <a href="{{ route('dosen.profile.pengaturan-notifikasi.index') }}"
                class="flex items-center gap-3 border-b border-slate-100 px-3 py-4 hover:bg-slate-50">
                <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-[#2653EB]/15">
                    <svg class="h-[18px] w-[18px] text-[#2653EB]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <path d="M18 8a6 6 0 1 0-12 0c0 7-3 9-3 9h18s-3-2-3-9" />
                        <path d="M13.7 21a2 2 0 0 1-3.4 0" />
                    </svg>
                </span>
                <span class="flex-1 font-inter text-sm text-black">Pengaturan Notifikasi</span>
                <svg class="h-4 w-4 text-slate-300" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <path d="M9 6l6 6-6 6" />
                </svg>
            </a>
            <a href="{{ route('dosen.profile.privasi-keamanan.index') }}"
                class="flex items-center gap-3 px-3 py-4 hover:bg-slate-50">
                <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-[#2653EB]/15">
                    <svg class="h-[18px] w-[18px] text-[#2653EB]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <path d="M12 3l7 3v6c0 4.5-3 8-7 9-4-1-7-4.5-7-9V6l7-3Z" />
                    </svg>
                </span>
                <span class="flex-1 font-inter text-sm text-black">Privasi &amp; Keamanan</span>
                <svg class="h-4 w-4 text-slate-300" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <path d="M9 6l6 6-6 6" />
                </svg>
            </a>
        </div>

        <button type="button" @click="showLogoutConfirm = true"
            class="w-full rounded-2xl border border-red-200 bg-red-50 py-3.5 font-inter text-sm font-semibold text-red-600 hover:bg-red-100">
            Keluar
        </button>
    </div>

    <div x-show="showLogoutConfirm" x-cloak
        class="fixed inset-0 z-50 flex items-end justify-center bg-black/40 px-5 pb-8 sm:items-center"
        @click.self="showLogoutConfirm = false">
        <div x-show="showLogoutConfirm"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 translate-y-4"
            x-transition:enter-end="opacity-100 translate-y-0"
            class="w-full max-w-sm rounded-2xl bg-white p-6 text-center shadow-xl">
            <span class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-red-50">
                <svg class="h-6 w-6 text-red-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                    <path d="M16 17l5-5-5-5M21 12H9" />
                </svg>
            </span>
            <p class="mt-4 font-jakarta text-base font-extrabold text-black">Keluar dari akun?</p>
            <p class="mt-1 font-inter text-xs text-slate-500">Anda perlu login kembali untuk mengakses akun ini.</p>

            <div class="mt-5 grid grid-cols-2 gap-3">
                <button type="button" @click="showLogoutConfirm = false"
                    class="rounded-lg border border-slate-200 py-3 font-inter text-sm font-semibold text-black hover:bg-slate-50">
                    Batal
                </button>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="w-full rounded-lg bg-red-600 py-3 font-inter text-sm font-semibold text-white hover:bg-red-700">
                        Ya, Keluar
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection