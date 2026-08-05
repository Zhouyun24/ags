@extends('layouts.index')

@section('layouts')
@php
    $email = $email ?? 'nama@universitas.ac.id';
    $durasiOtpDetik = 60;
@endphp

<div
    class="flex min-h-screen flex-col"
    x-data="{
        kode: ['', '', '', '', '', ''],
        sisaDetik: {{ $durasiOtpDetik }},
        timer: null,
        get waktuFormat() {
            const menit = Math.floor(this.sisaDetik / 60).toString().padStart(2, '0');
            const detik = (this.sisaDetik % 60).toString().padStart(2, '0');
            return `${menit}:${detik}`;
        },
        get kodeLengkap() {
            return this.kode.join('');
        },
        mulaiTimer() {
            clearInterval(this.timer);
            this.timer = setInterval(() => {
                if (this.sisaDetik > 0) {
                    this.sisaDetik--;
                } else {
                    clearInterval(this.timer);
                }
            }, 1000);
        },
        isiKode(index, event) {
            const nilai = event.target.value.replace(/[^0-9]/g, '');
            this.kode[index] = nilai.slice(-1);
            if (nilai && index < 5) {
                this.$refs['digit' + (index + 1)].focus();
            }
        },
        hapusKode(index, event) {
            if (event.key === 'Backspace' && !this.kode[index] && index > 0) {
                this.$refs['digit' + (index - 1)].focus();
            }
        },
    }"
    x-init="mulaiTimer()"
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
        <div class="flex flex-col items-center text-center">
            <span class="flex h-14 w-14 items-center justify-center rounded-full bg-[#DCFCE7]">
                <svg class="h-7 w-7 text-[#16A34A]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <circle cx="12" cy="12" r="9" />
                    <path d="m8.5 12.5 2.5 2.5 4.5-5" />
                </svg>
            </span>
            <p class="mt-3 font-jakarta text-base font-extrabold text-black">Email Terkirim!</p>
            <p class="mt-1 font-inter text-xs text-slate-500">
                Kode OTP telah dikirim ke <span class="font-semibold text-black">{{ $email }}</span>
            </p>
            <p class="font-inter text-xs text-slate-500">Periksa kotak masuk atau folder spam</p>
        </div>

        <form method="POST" action="" class="mt-6">
            @csrf
            <input type="hidden" name="email" value="{{ $email }}" />
            <input type="hidden" name="otp" :value="kodeLengkap" />

            <div class="flex justify-center gap-2">
                @for ($i = 0; $i < 6; $i++)
                    <input
                        type="text"
                        inputmode="numeric"
                        maxlength="1"
                        x-ref="digit{{ $i }}"
                        x-model="kode[{{ $i }}]"
                        @input="isiKode({{ $i }}, $event)"
                        @keydown="hapusKode({{ $i }}, $event)"
                        class="h-12 w-11 rounded-lg border border-slate-200 text-center font-jakarta text-lg font-bold text-black focus:border-[#2653EB] focus:outline-none focus:ring-1 focus:ring-[#2653EB]"
                    />
                @endfor
            </div>
            @error('otp')
                <p class="mt-2 text-center font-inter text-[11px] text-[#DC2626]">{{ $message }}</p>
            @enderror

            <p class="mt-3 text-center font-inter text-xs text-slate-500">
                Kode berlaku selama <span class="font-semibold text-black" x-text="waktuFormat"></span> menit
            </p>

            <button
                type="submit"
                :disabled="kodeLengkap.length < 6"
                :class="kodeLengkap.length < 6 ? 'bg-[#93A5FD] cursor-not-allowed' : 'bg-[#2653EB] hover:bg-[#1D4ED8]'"
                class="mt-4 flex w-full items-center justify-center rounded-lg py-3.5 font-inter text-sm font-semibold text-white transition-colors"
            >
                Verifikasi
            </button>
        </form>

        <form method="POST" action="" class="mt-4 text-center">
            @csrf
            <input type="hidden" name="email" value="{{ $email }}" />
            <button
                type="submit"
                x-bind:disabled="sisaDetik > 0"
                x-on:click="sisaDetik = {{ $durasiOtpDetik }}; mulaiTimer()"
                :class="sisaDetik > 0 ? 'text-slate-400 cursor-not-allowed' : 'text-[#2653EB] hover:underline'"
                class="font-inter text-xs font-semibold"
            >
                Kirim ulang kode
            </button>
        </form>
    </div>
</div>
@endsection