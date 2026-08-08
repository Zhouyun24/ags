<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Academic Guidance System</title>
        
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&display=swap" rel="stylesheet">
        
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>

    @php
        $role = \Illuminate\Support\Facades\Auth::user()?->role;
        $roleMap = [
            1 => 'operator',
            2 => 'mahasiswa',
            3 => 'dosen',
        ];

        $namaKomponenNavbar = 'organism.' . ($roleMap[$role] ?? 'mahasiswa') . '.navbar';
        $namaKomponenSidebar = 'organism.' . ($roleMap[$role] ?? 'mahasiswa') . '.sidebar';
    @endphp 

    <body class="font-inter antialiased">
        <div class="mx-auto min-h-dvh w-full bg-slate-50" x-data="{ open: false }">
            @if(!isset($navbarVisibility) || $navbarVisibility == 1)   
                <x-dynamic-component :component="$namaKomponenNavbar" />
            @endif
            @if(!isset($sidebarVisibility) || $sidebarVisibility == 1)
                <x-dynamic-component :component="$namaKomponenSidebar" />
            @endif
            @yield("layouts")

            @if (session('success'))
                <div x-data="{ showSuccess: true }">
                    <div x-show="showSuccess" x-cloak
                        class="fixed inset-0 z-50 flex items-end justify-center bg-black/40 px-5 pb-8 sm:items-center"
                        @click.self="showSuccess = false">
                        <div x-show="showSuccess"
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 translate-y-4"
                            x-transition:enter-end="opacity-100 translate-y-0"
                            class="w-full max-w-sm rounded-2xl bg-white p-6 text-center shadow-xl">
                            <span class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-[#DCFCE7]">
                                <svg class="h-6 w-6 text-[#16A34A]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                                    <path d="M5 13l4 4L19 7" />
                                </svg>
                            </span>
                            <p class="mt-4 font-jakarta text-base font-extrabold text-black">Berhasil</p>
                            <p class="mt-1 font-inter text-xs text-slate-500">{{ session('success') }}</p>
                            <button type="button" @click="showSuccess = false"
                                class="mt-5 w-full rounded-lg bg-[#16A34A] py-3 font-inter text-sm font-semibold text-white hover:opacity-90">
                                Tutup
                            </button>
                        </div>
                    </div>
                </div>
            @endif

            @if (session('error'))
                <div x-data="{ showError: true }">
                    <div x-show="showError" x-cloak
                        class="fixed inset-0 z-50 flex items-end justify-center bg-black/40 px-5 pb-8 sm:items-center"
                        @click.self="showError = false">
                        <div x-show="showError"
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 translate-y-4"
                            x-transition:enter-end="opacity-100 translate-y-0"
                            class="w-full max-w-sm rounded-2xl bg-white p-6 text-center shadow-xl">
                            <span class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-[#FEE2E2]">
                                <svg class="h-6 w-6 text-[#DC2626]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                                    <path d="M6 6l12 12M18 6 6 18" />
                                </svg>
                            </span>
                            <p class="mt-4 font-jakarta text-base font-extrabold text-black">Gagal</p>
                            <p class="mt-1 font-inter text-xs text-slate-500">{{ session('error') }}</p>
                            <button type="button" @click="showError = false"
                                class="mt-5 w-full rounded-lg bg-[#DC2626] py-3 font-inter text-sm font-semibold text-white hover:opacity-90">
                                Tutup
                            </button>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </body>
</html>
