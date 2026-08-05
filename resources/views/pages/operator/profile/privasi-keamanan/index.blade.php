@extends('layouts.index')

@section('layouts')
@php
    $skorKeamanan ??= 72;
    $skorMaks ??= 100;
    $levelKeamanan ??= 'Sedang'; // Lemah | Sedang | Kuat
    $deskripsiSaran ??= 'Aktifkan Login Biometrik untuk meningkatkan skor keamanan akun Anda.';

    $pengaturan ??= [
        'autentikasi_2fa' => true,
        'login_biometrik' => false,
        'logout_otomatis' => true,
    ];

    $sesiAktif ??= collect([
        (object) [
            'id' => 1,
            'platform' => 'Web',
            'sistem_operasi' => 'Windows 11',
            'lokasi' => 'Jakarta, Indonesia',
            'waktu' => 'Aktif sekarang',
            'perangkat_ini' => true,
        ],
        (object) [
            'id' => 2,
            'platform' => 'Web',
            'sistem_operasi' => 'Android 14',
            'lokasi' => 'Bandung, Indonesia',
            'waktu' => '2 hari lalu',
            'perangkat_ini' => false,
        ],
        (object) [
            'id' => 3,
            'platform' => 'Web',
            'sistem_operasi' => 'macOS Sonoma',
            'lokasi' => 'Surabaya, Indonesia',
            'waktu' => '5 hari lalu',
            'perangkat_ini' => false,
        ],
    ]);

    $levelColor = match ($levelKeamanan) {
        'Kuat' => 'text-[#16A34A]',
        'Sedang' => 'text-[#2653EB]',
        default => 'text-[#DC2626]',
    };
@endphp

<div x-data="{
        settings: {{ Illuminate\Support\Js::from($pengaturan) }},
        sesiList: {{ $sesiAktif->map(fn($s) => [
            'id' => $s->id,
            'platform' => $s->platform,
            'sistem_operasi' => $s->sistem_operasi,
            'lokasi' => $s->lokasi,
            'waktu' => $s->waktu,
            'perangkat_ini' => $s->perangkat_ini,
        ])->values()->toJson() }},
        sesiUntukHapus: null,
        hapusSesi(id) {
            this.sesiList = this.sesiList.filter(s => s.id !== id);
            this.sesiUntukHapus = null;
            // TODO: panggil endpoint backend untuk logout sesi tsb, misal:
            // fetch(`/profil/sesi/${id}`, { method: 'DELETE', headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' } });
        },
    }" class="pb-8">

    {{-- Header --}}
    <div class="relative overflow-hidden rounded-b-[28px] bg-gradient-to-br from-[#8B5CF6] via-[#7C3AED] to-[#6D28D9] px-5 pb-16 pt-5 text-center">
        <h1 class="font-jakarta text-xl font-extrabold text-white">Privasi &amp; Keamanan</h1>
        <p class="mt-1 font-inter text-xs text-blue-100">Jaga keamanan akun dan data Anda</p>
    </div>

    <form action="" method="POST" class="px-5 relative z-10">
        @csrf
        @method('PUT')

        {{-- Skor Keamanan Akun --}}
        <div class="-mt-12 mb-5 rounded-2xl bg-white p-5 shadow-[0px_4px_16px_0px_#0F172A14]">
            <div class="flex items-start gap-3 rounded-xl bg-[#EFF3FF] p-4">
                <span class="flex h-14 w-14 shrink-0 flex-col items-center justify-center rounded-xl bg-[#2653EB]">
                    <span class="font-jakarta text-lg font-extrabold leading-none text-white">{{ $skorKeamanan }}</span>
                    <span class="font-inter text-[9px] leading-none text-blue-100">/{{ $skorMaks }}</span>
                </span>
                <div>
                    <p class="font-inter text-sm font-semibold text-black">
                        Keamanan Akun: <span class="{{ $levelColor }}">{{ $levelKeamanan }}</span>
                    </p>
                    <p class="mt-1 font-inter text-xs text-slate-500">{{ $deskripsiSaran }}</p>
                </div>
            </div>
        </div>

        {{-- Autentikasi --}}
        <div class="mb-5 rounded-2xl bg-white p-5 shadow-[0px_4px_16px_0px_#0F172A14]">
            <p class="font-inter text-xs font-bold uppercase tracking-wide text-[#2653EB]">Autentikasi</p>

            <div class="mt-4 divide-y divide-slate-100">
                <div class="flex items-center justify-between py-4">
                    <div class="flex items-center gap-3 pr-4">
                        <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-[#2653EB]/15">
                            <svg class="h-5 w-5 text-[#2653EB]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                <path d="M12 3l7 3v6c0 4.5-3 8-7 9-4-1-7-4.5-7-9V6l7-3Z" />
                            </svg>
                        </span>
                        <div>
                            <p class="font-inter text-sm font-semibold text-black">Autentikasi 2 Faktor</p>
                            <p class="font-inter text-xs text-slate-400">Lapisan keamanan tambahan via OTP email</p>
                        </div>
                    </div>
                    <button type="button" role="switch" :aria-checked="settings.autentikasi_2fa"
                        @click="settings.autentikasi_2fa = !settings.autentikasi_2fa"
                        :class="settings.autentikasi_2fa ? 'bg-[#2653EB]' : 'bg-slate-200'"
                        class="relative h-6 w-11 shrink-0 rounded-full transition-colors">
                        <span :class="settings.autentikasi_2fa ? 'translate-x-5' : 'translate-x-0.5'"
                            class="absolute top-0.5 h-5 w-5 rounded-full bg-white shadow transition-transform"></span>
                    </button>
                    <input type="hidden" name="autentikasi_2fa" :value="settings.autentikasi_2fa ? 1 : 0">
                </div>

                <div class="flex items-center justify-between py-4">
                    <div class="flex items-center gap-3 pr-4">
                        <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-[#16A34A]/15">
                            <svg class="h-5 w-5 text-[#16A34A]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                <circle cx="12" cy="8" r="4" />
                                <path d="M4 20c0-4 3.5-6 8-6s8 2 8 6" />
                            </svg>
                        </span>
                        <div>
                            <p class="font-inter text-sm font-semibold text-black">Login Biometrik</p>
                            <p class="font-inter text-xs text-slate-400">Gunakan sidik jari / wajah untuk masuk</p>
                        </div>
                    </div>
                    <button type="button" role="switch" :aria-checked="settings.login_biometrik"
                        @click="settings.login_biometrik = !settings.login_biometrik"
                        :class="settings.login_biometrik ? 'bg-[#2653EB]' : 'bg-slate-200'"
                        class="relative h-6 w-11 shrink-0 rounded-full transition-colors">
                        <span :class="settings.login_biometrik ? 'translate-x-5' : 'translate-x-0.5'"
                            class="absolute top-0.5 h-5 w-5 rounded-full bg-white shadow transition-transform"></span>
                    </button>
                    <input type="hidden" name="login_biometrik" :value="settings.login_biometrik ? 1 : 0">
                </div>

                <div class="flex items-center justify-between py-4">
                    <div class="flex items-center gap-3 pr-4">
                        <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-[#F59E0B]/15">
                            <svg class="h-5 w-5 text-[#F59E0B]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                <circle cx="12" cy="12" r="9" />
                                <path d="M12 7v5l3 3" />
                            </svg>
                        </span>
                        <div>
                            <p class="font-inter text-sm font-semibold text-black">Logout Otomatis</p>
                            <p class="font-inter text-xs text-slate-400">Ingatkan 1 jam sebelum sesi bimbingan</p>
                        </div>
                    </div>
                    <button type="button" role="switch" :aria-checked="settings.logout_otomatis"
                        @click="settings.logout_otomatis = !settings.logout_otomatis"
                        :class="settings.logout_otomatis ? 'bg-[#2653EB]' : 'bg-slate-200'"
                        class="relative h-6 w-11 shrink-0 rounded-full transition-colors">
                        <span :class="settings.logout_otomatis ? 'translate-x-5' : 'translate-x-0.5'"
                            class="absolute top-0.5 h-5 w-5 rounded-full bg-white shadow transition-transform"></span>
                    </button>
                    <input type="hidden" name="logout_otomatis" :value="settings.logout_otomatis ? 1 : 0">
                </div>
            </div>
        </div>

        {{-- Sesi Aktif --}}
        <div class="mb-6 rounded-2xl bg-white p-5 shadow-[0px_4px_16px_0px_#0F172A14]">
            <p class="font-inter text-xs font-bold uppercase tracking-wide text-[#2653EB]">Sesi Aktif (Maks 3)</p>

            <div class="mt-4 divide-y divide-slate-100">
                <template x-for="sesi in sesiList" :key="sesi.id">
                    <div class="flex items-center justify-between gap-3 py-4">
                        <div class="flex min-w-0 items-center gap-3">
                            <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg"
                                :class="sesi.perangkat_ini ? 'bg-[#16A34A]/15' : 'bg-slate-100'">
                                <svg class="h-5 w-5" :class="sesi.perangkat_ini ? 'text-[#16A34A]' : 'text-slate-400'"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                    <circle cx="12" cy="12" r="3" />
                                    <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 1 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 1 1-2.83-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 1 1 2.83-2.83l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 1 1 2.83 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1Z" />
                                </svg>
                            </span>
                            <div class="min-w-0">
                                <p class="truncate font-inter text-sm font-semibold text-black"
                                    x-text="sesi.platform + ' • ' + sesi.sistem_operasi"></p>
                                <p class="truncate font-inter text-xs text-slate-400"
                                    x-text="sesi.lokasi + ' • ' + sesi.waktu"></p>
                            </div>
                        </div>

                        <span x-show="sesi.perangkat_ini"
                            class="shrink-0 whitespace-nowrap rounded-full bg-[#DCFCE7] px-2.5 py-1 font-inter text-[10px] font-semibold text-[#16A34A]">
                            Perangkat Ini
                        </span>
                        <button x-show="!sesi.perangkat_ini" type="button"
                            @click="sesiUntukHapus = sesi.id"
                            class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-red-50 text-red-500 hover:bg-red-100">
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                <path d="M6 6l12 12M18 6L6 18" />
                            </svg>
                        </button>
                    </div>
                </template>

                <p x-show="sesiList.length === 0" class="py-4 text-center font-inter text-xs text-slate-400">
                    Tidak ada sesi aktif lain
                </p>
            </div>
        </div>

        {{-- Tombol Simpan --}}
        <button type="submit"
            class="w-full rounded-2xl bg-gradient-to-br from-[#8B5CF6] via-[#7C3AED] to-[#6D28D9] py-3.5 font-inter text-sm font-semibold text-white hover:opacity-90">
            Simpan Pengaturan
        </button>
    </form>

    {{-- Modal Konfirmasi Hapus Sesi --}}
    <div x-show="sesiUntukHapus !== null" x-cloak
        class="fixed inset-0 z-50 flex items-end justify-center bg-black/40 px-5 pb-8 sm:items-center"
        @click.self="sesiUntukHapus = null">
        <div x-show="sesiUntukHapus !== null"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 translate-y-4"
            x-transition:enter-end="opacity-100 translate-y-0"
            class="w-full max-w-sm rounded-2xl bg-white p-6 text-center shadow-xl">
            <span class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-red-50">
                <svg class="h-6 w-6 text-red-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                    <circle cx="12" cy="12" r="9" />
                    <path d="M12 8v5M12 16h.01" />
                </svg>
            </span>
            <p class="mt-4 font-jakarta text-base font-extrabold text-black">Akhiri sesi ini?</p>
            <p class="mt-1 font-inter text-xs text-slate-500">Perangkat tersebut akan otomatis logout dari akun Anda.</p>

            <div class="mt-5 grid grid-cols-2 gap-3">
                <button type="button" @click="sesiUntukHapus = null"
                    class="rounded-lg border border-slate-200 py-3 font-inter text-sm font-semibold text-black hover:bg-slate-50">
                    Batal
                </button>
                <button type="button" @click="hapusSesi(sesiUntukHapus)"
                    class="rounded-lg bg-red-600 py-3 font-inter text-sm font-semibold text-white hover:bg-red-700">
                    Ya, Akhiri
                </button>
            </div>
        </div>
    </div>
</div>
@endsection
