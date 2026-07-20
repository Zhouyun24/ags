@extends('layouts.index')

@section('layouts')
<div class="flex flex-col">
    <div class="relative overflow-hidden rounded-b-[32px] bg-gradient-to-br from-[#1D4ED8] to-[#2563EB] px-6 pb-8 pt-10">
        <div class="mb-5 flex h-14 w-14 items-center justify-center rounded-2xl bg-white/15">
            <svg class="h-7 w-7 text-white/35" viewBox="0 0 24 24" fill="currentColor">
                <path d="M12 3 1 8.5l11 5.5 9-4.5V17h2V8.5L12 3Z" />
                <path d="M5 10.9V15c0 1.7 3.1 4 7 4s7-2.3 7-4v-4.1l-7 3.5-7-3.5Z" />
            </svg>
        </div>
        <h1 class="font-['Plus_Jakarta_Sans'] text-3xl font-extrabold text-white">
            Daftar Operator
        </h1>
        <p class="mt-1 text-sm text-blue-100">
            Isi data untuk mendaftar sebagai Operator sistem AGS
        </p>
    </div>
    {{-- <form method="POST" action="" class="flex-1 px-6 pt-8" x-data="{ showPassword: false, showConfirmPassword: false }"> --}}
        {{-- @csrf --}}
    <div class="flex-1 px-6 pt-8" x-data="{ showPassword: false, showConfirmPassword: false }">
        <div class="mb-5">
            <label for="nama_lengkap" class="mb-2 block text-sm font-semibold text-slate-800">
                Nama Lengkap
            </label>
            <div class="relative">
                <span class="pointer-events-none absolute inset-y-0 left-3 flex items-center text-slate-400">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="1.8">
                        <circle cx="12" cy="8" r="4" />
                        <path d="M4 20c0-4 3.6-7 8-7s8 3 8 7" />
                    </svg>
                </span>
                <input type="text" id="nama_lengkap" name="nama_lengkap" value="{{ old('nama_lengkap') }}"
                    placeholder="Nama sesuai identitas resmi" required autofocus
                    class="w-full rounded-xl border border-slate-200 bg-white py-3.5 pl-11 pr-4 text-sm text-slate-800 placeholder:text-slate-400 focus:border-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-100">
            </div>
            @error('nama_lengkap')
                <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-5">
            <label for="email" class="mb-2 block text-sm font-semibold text-slate-800">
                Email Institusi
            </label>
            <div class="relative">
                <span class="pointer-events-none absolute inset-y-0 left-3 flex items-center text-slate-400">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="1.8">
                        <rect x="3" y="5" width="18" height="14" rx="2" />
                        <path d="m3 7 9 6 9-6" />
                    </svg>
                </span>
                <input type="email" id="email" name="email" value="{{ old('email') }}"
                    placeholder="nama@universitas.ac.id" required
                    class="w-full rounded-xl border border-slate-200 bg-white py-3.5 pl-11 pr-4 text-sm text-slate-800 placeholder:text-slate-400 focus:border-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-100">
            </div>
            @error('email')
                <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-5">
            <label for="nomor_telepon" class="mb-2 block text-sm font-semibold text-slate-800">
                Nomor Telepon
            </label>
            <div class="relative">
                <span class="pointer-events-none absolute inset-y-0 left-3 flex items-center text-slate-400">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="1.8">
                        <path
                            d="M4 4h4l2 5-2.5 1.5a11 11 0 0 0 5 5L14 13l5 2v4a2 2 0 0 1-2 2C9.6 21 3 14.4 3 6a2 2 0 0 1 1-2Z" />
                    </svg>
                </span>
                <input type="tel" id="nomor_telepon" name="nomor_telepon" value="{{ old('nomor_telepon') }}"
                    placeholder="08xxxxxxxxxx" required
                    class="w-full rounded-xl border border-slate-200 bg-white py-3.5 pl-11 pr-4 text-sm text-slate-800 placeholder:text-slate-400 focus:border-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-100">
            </div>
            @error('nomor_telepon')
                <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-5">
            <label for="nama_institusi" class="mb-2 block text-sm font-semibold text-slate-800">
                Nama Institusi
            </label>
            <div class="relative">
                <span class="pointer-events-none absolute inset-y-0 left-3 flex items-center text-slate-400">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="1.8">
                        <path d="M12 3 2 8l10 5 10-5-10-5Z" />
                        <path d="M6 10.5V15c0 1.7 2.7 3.5 6 3.5s6-1.8 6-3.5v-4.5" />
                    </svg>
                </span>
                <input type="text" id="nama_institusi" name="nama_institusi" value="{{ old('nama_institusi') }}"
                    placeholder="Universitas/Sekolah Tinggi" required
                    class="w-full rounded-xl border border-slate-200 bg-white py-3.5 pl-11 pr-4 text-sm text-slate-800 placeholder:text-slate-400 focus:border-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-100">
            </div>
            @error('nama_institusi')
                <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-5">
            <label for="password" class="mb-2 block text-sm font-semibold text-slate-800">
                Kata Sandi
            </label>
            <div class="relative">
                <span class="pointer-events-none absolute inset-y-0 left-3 flex items-center text-slate-400">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="1.8">
                        <rect x="5" y="10" width="14" height="10" rx="2" />
                        <path d="M8 10V7a4 4 0 0 1 8 0v3" />
                    </svg>
                </span>
                <input :type="showPassword ? 'text' : 'password'" id="password" name="password"
                    placeholder="Minimal 8 Karakter" required minlength="8"
                    class="w-full rounded-xl border border-slate-200 bg-white py-3.5 pl-11 pr-11 text-sm text-slate-800 placeholder:text-slate-400 focus:border-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-100">
                <button type="button" @click="showPassword = !showPassword"
                    class="absolute inset-y-0 right-3 flex items-center text-slate-400 hover:text-slate-600"
                    :aria-label="showPassword ? 'Sembunyikan kata sandi' : 'Tampilkan kata sandi'">
                    <svg x-show="!showPassword" class="h-5 w-5" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="1.8">
                        <path d="M1.5 12S5 5 12 5s10.5 7 10.5 7-3.5 7-10.5 7S1.5 12 1.5 12Z" />
                        <circle cx="12" cy="12" r="3" />
                    </svg>
                    <svg x-show="showPassword" x-cloak class="h-5 w-5" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="1.8">
                        <path d="M3 3l18 18" />
                        <path
                            d="M10.6 5.1A10.9 10.9 0 0 1 12 5c7 0 10.5 7 10.5 7a15.5 15.5 0 0 1-3.4 4.3M6.6 6.6C3.7 8.4 1.5 12 1.5 12s3.5 7 10.5 7c1.4 0 2.6-.2 3.7-.6" />
                        <path d="M9.9 9.9a3 3 0 0 0 4.2 4.2" />
                    </svg>
                </button>
            </div>
            @error('password')
                <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-6">
            <label for="password_confirmation" class="mb-2 block text-sm font-semibold text-slate-800">
                Konfirmasi Kata Sandi
            </label>
            <div class="relative">
                <span class="pointer-events-none absolute inset-y-0 left-3 flex items-center text-slate-400">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="1.8">
                        <rect x="5" y="10" width="14" height="10" rx="2" />
                        <path d="M8 10V7a4 4 0 0 1 8 0v3" />
                    </svg>
                </span>
                <input :type="showConfirmPassword ? 'text' : 'password'" id="password_confirmation"
                    name="password_confirmation" placeholder="Ulangi Kata Sandi" required minlength="8"
                    class="w-full rounded-xl border border-slate-200 bg-white py-3.5 pl-11 pr-11 text-sm text-slate-800 placeholder:text-slate-400 focus:border-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-100">
                <button type="button" @click="showConfirmPassword = !showConfirmPassword"
                    class="absolute inset-y-0 right-3 flex items-center text-slate-400 hover:text-slate-600"
                    :aria-label="showConfirmPassword ? 'Sembunyikan kata sandi' : 'Tampilkan kata sandi'">
                    <svg x-show="!showConfirmPassword" class="h-5 w-5" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="1.8">
                        <path d="M1.5 12S5 5 12 5s10.5 7 10.5 7-3.5 7-10.5 7S1.5 12 1.5 12Z" />
                        <circle cx="12" cy="12" r="3" />
                    </svg>
                    <svg x-show="showConfirmPassword" x-cloak class="h-5 w-5" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="1.8">
                        <path d="M3 3l18 18" />
                        <path
                            d="M10.6 5.1A10.9 10.9 0 0 1 12 5c7 0 10.5 7 10.5 7a15.5 15.5 0 0 1-3.4 4.3M6.6 6.6C3.7 8.4 1.5 12 1.5 12s3.5 7 10.5 7c1.4 0 2.6-.2 3.7-.6" />
                        <path d="M9.9 9.9a3 3 0 0 0 4.2 4.2" />
                    </svg>
                </button>
            </div>
            @error('password_confirmation')
                <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
            @enderror
        </div>
        {{-- <button type="submit" class="flex w-full items-center justify-center gap-2 rounded-xl bg-blue-600 py-3.5 text-sm font-semibold text-white shadow-[0px_8px_32px_0px_#00000040] transition hover:bg-blue-700 active:bg-blue-800">
            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                <path d="M12 2 4 5v6c0 5 3.4 8.7 8 11 4.6-2.3 8-6 8-11V5l-8-3Z" />
            </svg>
            Daftar Sekarang
        </button> --}}
        <a href="{{ route('operator.import-data') }}" class="flex w-full items-center justify-center gap-2 rounded-xl bg-blue-600 py-3.5 text-sm font-semibold text-white shadow-[0px_8px_32px_0px_#00000040] transition hover:bg-blue-700 active:bg-blue-800">
            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                <path d="M12 2 4 5v6c0 5 3.4 8.7 8 11 4.6-2.3 8-6 8-11V5l-8-3Z" />
            </svg>
            Daftar Sekarang
        </a>
        <p class="mt-4 pb-8 text-center text-sm text-slate-600">
            Sudah punya akun?
            <a href="{{ route('login') }}" class="font-semibold text-blue-600 hover:text-blue-700">
                Masuk
            </a>
        </p>
    </div>
</div>    
@endsection
