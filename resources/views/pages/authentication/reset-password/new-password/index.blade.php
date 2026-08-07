@extends('layouts.index')

@section('layouts')
<div
    class="flex min-h-screen flex-col"
    x-data="{
        tampilkanSandi: false,
        tampilkanKonfirmasi: false,
    }"
>
    <div class="relative overflow-hidden rounded-b-[28px] bg-gradient-to-br from-[#2563ED] via-[#2251E3] to-[#1D4ED8] px-6 pb-8 pt-8">
        <span class="flex h-12 w-12 items-center justify-center rounded-xl bg-white/20">
            <svg class="h-6 w-6 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                <path d="M22 10v6M2 10l10-5 10 5-10 5-10-5Z" />
                <path d="M6 12v5c0 1.1 2.7 2 6 2s6-.9 6-2v-5" />
            </svg>
        </span>
        <h1 class="mt-4 font-jakarta text-2xl font-extrabold text-white">Lupa Kata Sandi</h1>
        <p class="mt-1 font-inter text-xs text-white">Masukkan email untuk menerima kode OTP</p>
    </div>

    <div class="flex-1 px-6 pt-10">
        <div class="flex justify-center">
            <span class="flex h-14 w-14 items-center justify-center rounded-full bg-[#E0E7FF]">
                <svg class="text-[#2653EB]" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-key-icon lucide-key">
                    <path d="m15.5 7.5 2.3 2.3a1 1 0 0 0 1.4 0l2.1-2.1a1 1 0 0 0 0-1.4L19 4"/>
                    <path d="m21 2-9.6 9.6"/>
                    <circle cx="7.5" cy="15.5" r="5.5"/>
                </svg>
            </span>
        </div>

        <form @submit.prevent="window.location.href = '{{ route('login') }}'" class="mt-8">
            <input type="hidden" name="token" value="{{ $token ?? request('token') }}" />
            <input type="hidden" name="email" value="{{ $email ?? request('email') }}" />

            <label for="password" class="mb-1.5 block font-inter text-sm font-semibold text-black">Kata Sandi Baru</label>
            <div class="flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-3.5 shadow-[0px_4px_16px_0px_#0F172A14] focus-within:border-[#2653EB]">
                <svg class="h-4 w-4 shrink-0 text-slate-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                    <rect x="4" y="10" width="16" height="10" rx="2" />
                    <path d="M8 10V7a4 4 0 0 1 8 0v3" />
                </svg>
                <input
                    :type="tampilkanSandi ? 'text' : 'password'"
                    id="password"
                    name="password"
                    placeholder="Minimal 8 karakter"
                    class="w-full border-none font-inter text-sm text-black placeholder:text-slate-400 focus:outline-none focus:ring-0"
                    minlength="8"
                    required
                />
                <button type="button" @click="tampilkanSandi = !tampilkanSandi" class="shrink-0 text-slate-400 hover:text-slate-600">
                    <svg x-show="!tampilkanSandi" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7-11-7-11-7Z" />
                        <circle cx="12" cy="12" r="3" />
                    </svg>
                    <svg x-show="tampilkanSandi" x-cloak class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <path d="M17.94 17.94A10.94 10.94 0 0 1 12 19c-7 0-11-7-11-7a21.6 21.6 0 0 1 5.06-5.94M9.9 4.24A10.94 10.94 0 0 1 12 5c7 0 11 7 11 7a21.6 21.6 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24" />
                        <path d="M1 1l22 22" />
                    </svg>
                </button>
            </div>
            @error('password')
                <p class="mt-1.5 font-inter text-[11px] text-[#DC2626]">{{ $message }}</p>
            @enderror

            <label for="password_confirmation" class="mb-1.5 mt-4 block font-inter text-sm font-semibold text-black">Konfirmasi Kata Sandi</label>
            <div class="flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-3.5 shadow-[0px_4px_16px_0px_#0F172A14] focus-within:border-[#2653EB]">
                <svg class="h-4 w-4 shrink-0 text-slate-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                    <rect x="4" y="10" width="16" height="10" rx="2" />
                    <path d="M8 10V7a4 4 0 0 1 8 0v3" />
                </svg>
                <input
                    :type="tampilkanKonfirmasi ? 'text' : 'password'"
                    id="password_confirmation"
                    name="password_confirmation"
                    placeholder="Ulangi kata sandi baru"
                    class="w-full border-none font-inter text-sm text-black placeholder:text-slate-400 focus:outline-none focus:ring-0"
                    minlength="8"
                    required
                />
                <button type="button" @click="tampilkanKonfirmasi = !tampilkanKonfirmasi" class="shrink-0 text-slate-400 hover:text-slate-600">
                    <svg x-show="!tampilkanKonfirmasi" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7-11-7-11-7Z" />
                        <circle cx="12" cy="12" r="3" />
                    </svg>
                    <svg x-show="tampilkanKonfirmasi" x-cloak class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <path d="M17.94 17.94A10.94 10.94 0 0 1 12 19c-7 0-11-7-11-7a21.6 21.6 0 0 1 5.06-5.94M9.9 4.24A10.94 10.94 0 0 1 12 5c7 0 11 7 11 7a21.6 21.6 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24" />
                        <path d="M1 1l22 22" />
                    </svg>
                </button>
            </div>
            @error('password_confirmation')
                <p class="mt-1.5 font-inter text-[11px] text-[#DC2626]">{{ $message }}</p>
            @enderror

            <button
                type="submit"
                class="mt-6 flex w-full items-center justify-center rounded-lg bg-[#2653EB] py-3.5 font-inter text-sm font-semibold text-white hover:bg-[#1D4ED8]"
            >
                Simpan Kata Sandi Baru
            </button>
        </form>
    </div>
</div>
@endsection