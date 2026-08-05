@extends('layouts.index')

@section('layouts')
<div class="flex min-h-screen flex-col">
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
                <svg class="h-7 w-7 text-[#2653EB]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                    <rect x="3" y="5" width="18" height="14" rx="2" />
                    <path d="m3 7 9 6 9-6" />
                </svg>
            </span>
        </div>

        <form method="POST" action="" class="mt-8">
            @csrf

            <label for="email" class="mb-1.5 block font-inter text-sm font-semibold text-black">Alamat Email</label>
            <div class="flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-3.5 shadow-[0px_4px_16px_0px_#0F172A14] focus-within:border-[#2653EB]">
                <svg class="h-4 w-4 shrink-0 text-slate-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                    <rect x="3" y="5" width="18" height="14" rx="2" />
                    <path d="m3 7 9 6 9-6" />
                </svg>
                <input
                    type="email"
                    id="email"
                    name="email"
                    value="{{ old('email') }}"
                    placeholder="nama@universitas.ac.id"
                    class="w-full border-none font-inter text-sm text-black placeholder:text-slate-400 focus:outline-none focus:ring-0"
                    required
                    autofocus
                />
            </div>
            @error('email')
                <p class="mt-1.5 font-inter text-[11px] text-[#DC2626]">{{ $message }}</p>
            @enderror

            <p class="mt-2 font-inter text-xs text-slate-500">Kode OTP dikirimkan ke email yang terdaftar di sistem AGS</p>

            <button
                type="submit"
                class="mt-4 flex w-full items-center justify-center gap-2 rounded-lg bg-[#2653EB] py-3.5 font-inter text-sm font-semibold text-white hover:bg-[#1D4ED8]"
            >
                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="m3 3 18 9-18 9 4-9-4-9Z" />
                </svg>
                Kirim Kode OTP
            </button>
        </form>
    </div>
</div>
@endsection