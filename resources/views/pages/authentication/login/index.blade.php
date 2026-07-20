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
            Selamat Datang
        </h1>
        <p class="mt-1 text-sm text-blue-100">
            Masuk Ke Academic Guidance System
        </p>
    </div>
    <form method="GET" action="{{ route("mahasiswa.beranda.index") }}" class="flex-1 px-6 pt-8" x-data="{ showPassword: false, remember: false }">
        @csrf
        <div class="mb-5">
            <label for="id_pengguna" class="mb-2 block text-sm font-semibold text-slate-800">
                ID Pengguna
            </label>
            <div class="relative">
                <span class="pointer-events-none absolute inset-y-0 left-3 flex items-center text-slate-400">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="1.8">
                        <circle cx="12" cy="8" r="4" />
                        <path d="M4 20c0-4 3.6-7 8-7s8 3 8 7" />
                    </svg>
                </span>
                <input type="text" id="id_pengguna" name="id_pengguna" value="{{ old('id_pengguna') }}"
                    placeholder="Masukkan ID/NIM/NIP" required autofocus
                    class="w-full rounded-xl border border-slate-200 bg-white py-3.5 pl-11 pr-4 text-sm text-slate-800 placeholder:text-slate-400 focus:border-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-100">
            </div>
            @error('id_pengguna')
                <p class="mt-1.5 text-xs text-red-600">error</p>
            @enderror
        </div>
        <div class="mb-4">
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
                    placeholder="Masukkan Kata Sandi" required
                    class="w-full rounded-xl border border-slate-200 bg-white py-3.5 pl-11 pr-11 text-sm text-slate-800 placeholder:text-slate-400 focus:border-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-100">
                <button type="button" @click="showPassword = !showPassword"
                    class="absolute inset-y-0 right-3 flex items-center text-slate-400 hover:text-slate-600"
                    :aria-label="showPassword ? 'Sembunyikan kata sandi' : 'Tampilkan kata sandi'">
                    {{-- Eye open --}}
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
                <p class="mt-1.5 text-xs text-red-600">error</p>
            @enderror
        </div>
        <div class="mb-6 flex items-center justify-between">
            <label class="flex cursor-pointer items-center gap-2 select-none">
                    <span class="relative flex h-5 w-5 items-center justify-center">
                        <input
                            type="checkbox"
                            name="remember"
                            x-model="remember"
                            class="peer h-5 w-5 appearance-none rounded-md border-2 border-slate-300 bg-white transition checked:border-blue-600 checked:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-100"
                        >
                        <svg
                            class="pointer-events-none absolute h-3 w-3 text-white opacity-0 peer-checked:opacity-100"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="3"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                        >
                            <path d="M5 13l4 4L19 7" />
                        </svg>
                    </span>
                <span class="text-sm text-slate-700">Ingat Saya</span>
            </label>
            <a href="#"
                class="text-sm font-semibold text-blue-600 hover:text-blue-700">
                Lupa Kata Sandi?
            </a>
        </div>
        <button type="submit"
            class="w-full rounded-xl bg-blue-600 py-3.5 text-sm font-semibold text-white shadow-[0px_8px_32px_0px_#00000040] transition hover:bg-blue-700 active:bg-blue-800">
            Masuk
        </button>
        <a href="{{ route('operator.daftar') }}"
            class="mt-3 flex w-full items-center justify-center gap-2 rounded-xl border-2 border-blue-600 py-3.5 text-sm font-semibold text-blue-600 transition hover:bg-blue-50">
            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                <path d="M12 2 4 5v6c0 5 3.4 8.7 8 11 4.6-2.3 8-6 8-11V5l-8-3Z" />
            </svg>
            Daftar sebagai Operator
        </a>
    </form>
</div> 
@endsection
