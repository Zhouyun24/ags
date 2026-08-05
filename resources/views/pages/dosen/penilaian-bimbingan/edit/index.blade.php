@extends('layouts.index')

@section('layouts')
<div class="pb-5" x-data="{
        partisipasi: {{ $penilaian->skor_keaktifan }},
        pemahaman: {{ $penilaian->skor_pemahaman }},
        get keseluruhan() {
            return (((this.partisipasi + this.pemahaman) / 2) || 0).toFixed(1);
        }
    }">
    {{-- ================= HEADER ================= --}}
    <div class="relative overflow-hidden rounded-b-[20px] bg-gradient-to-br from-[#22C55E] via-[#16A34A] to-[#15803D] px-5 pb-6 pt-5">
        <h1 class="font-jakarta text-xl font-extrabold text-white">Evaluasi Mahasiswa</h1>
        <p class="mt-1 font-inter text-xs text-white">Kelola nilai perkembangan Mahasiswa</p>
    </div>

    <div class="px-5 pt-6">
        <form method="POST" action="{{ route('dosen.penilaian.update', $penilaian->id_perkembangan) }}">
            @csrf
            @method('PATCH')

            {{-- ================= INFO MAHASISWA ================= --}}
            <div class="mb-6 flex items-center gap-3 rounded-xl border border-[#C7D2FE] bg-[#E0E7FF]/50 p-4">
                <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-[#2653EB]">
                    <svg class="h-6 w-6 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                        <circle cx="12" cy="7" r="4" />
                    </svg>
                </span>
                <div>
                    <p class="font-inter text-sm font-semibold text-black">{{ $penilaian->hasilBimbingan?->jadwal_bimbingan?->mahasiswa?->pengguna?->nama ?? '-' }}</p>
                    <p class="font-inter text-xs text-slate-500">
                        NIM: {{ $penilaian->hasilBimbingan?->jadwal_bimbingan?->nim ?? '-' }}
                    </p>
                    <p class="font-inter text-xs text-slate-500">{{ $penilaian->hasilBimbingan?->jadwal_bimbingan?->tanggal_jadwal ? \Illuminate\Support\Carbon::parse($penilaian->hasilBimbingan->jadwal_bimbingan->tanggal_jadwal)->format('d/m/Y') : '-' }} &bull; {{ $penilaian->hasilBimbingan?->jadwal_bimbingan?->jam_jadwal ? \Illuminate\Support\Carbon::parse($penilaian->hasilBimbingan->jadwal_bimbingan->jam_jadwal)->format('H.i') . ' WIB' : '-' }}</p>
                </div>
            </div>

            {{-- ================= FORM SKOR ================= --}}
            <div class="mb-6 rounded-2xl bg-white p-5 shadow-[0px_4px_16px_0px_#0F172A14]">
                {{-- Partisipasi --}}
                <p class="font-inter text-sm text-black">Partisipasi</p>
                <div class="mt-2 h-[6px] w-full overflow-hidden rounded-full bg-slate-200">
                    <div class="h-full rounded-full bg-[#2653EB] transition-all duration-200"
                        :style="`width: ${(partisipasi / 5) * 100}%`"></div>
                </div>
                <div class="mt-3 flex items-center gap-2">
                    <template x-for="nilai in [1, 2, 3, 4, 5]" :key="nilai">
                        <button
                            type="button"
                            @click="partisipasi = nilai"
                            :class="partisipasi === nilai ? 'bg-[#2653EB] text-white' : 'bg-[#E0E7FF] text-[#2653EB]'"
                            class="flex h-9 w-9 items-center justify-center rounded-lg font-inter text-sm font-semibold transition-colors"
                            x-text="nilai"
                        ></button>
                    </template>
                    <input type="hidden" name="skor_keaktifan" x-model="partisipasi" />
                    <div class="ml-auto flex h-9 w-16 items-center justify-center rounded-lg border-2 border-[#2653EB]">
                        <span class="font-jakarta text-sm font-extrabold text-[#2653EB]" x-text="partisipasi.toFixed(1)"></span>
                    </div>
                </div>
                @error('skor_keaktifan')
                    <p class="mt-1.5 font-inter text-xs text-red-500">{{ $message }}</p>
                @enderror

                {{-- Pemahaman --}}
                <p class="mt-6 font-inter text-sm text-black">Pemahaman</p>
                <div class="mt-2 h-[6px] w-full overflow-hidden rounded-full bg-slate-200">
                    <div class="h-full rounded-full bg-[#2653EB] transition-all duration-200"
                        :style="`width: ${(pemahaman / 5) * 100}%`"></div>
                </div>
                <div class="mt-3 flex items-center gap-2">
                    <template x-for="nilai in [1, 2, 3, 4, 5]" :key="nilai">
                        <button
                            type="button"
                            @click="pemahaman = nilai"
                            :class="pemahaman === nilai ? 'bg-[#2653EB] text-white' : 'bg-[#E0E7FF] text-[#2653EB]'"
                            class="flex h-9 w-9 items-center justify-center rounded-lg font-inter text-sm font-semibold transition-colors"
                            x-text="nilai"
                        ></button>
                    </template>
                    <input type="hidden" name="skor_pemahaman" x-model="pemahaman" />
                    <div class="ml-auto flex h-9 w-16 items-center justify-center rounded-lg border-2 border-[#2653EB]">
                        <span class="font-jakarta text-sm font-extrabold text-[#2653EB]" x-text="pemahaman.toFixed(1)"></span>
                    </div>
                </div>
                @error('skor_pemahaman')
                    <p class="mt-1.5 font-inter text-xs text-red-500">{{ $message }}</p>
                @enderror

                {{-- Skor Keseluruhan --}}
                <div class="mt-6 rounded-xl bg-[#2653EB] py-6 text-center">
                    <p class="font-inter text-xs text-blue-100">Skor Keseluruhan</p>
                    <p class="mt-1 font-jakarta text-4xl font-extrabold text-white" x-text="keseluruhan"></p>
                    <p class="mt-1 font-inter text-[11px] text-blue-100">dari 5.0</p>
                    <input type="hidden" name="keseluruhan" x-model="keseluruhan" />
                </div>
            </div>

            {{-- ================= TOMBOL AKSI ================= --}}
            <div class="mb-6 grid grid-cols-2 gap-3">
                <a href="{{ route('dosen.evaluasi-mahasiswa.index') }}"
                    class="flex items-center justify-center rounded-lg border border-[#2653EB] py-3 font-inter text-sm font-semibold text-[#2653EB] hover:bg-[#2653EB]/5">
                    Batal
                </a>
                <button type="submit"
                    class="flex items-center justify-center rounded-lg bg-[#16A34A] py-3 font-inter text-sm font-semibold text-white hover:bg-[#15803D]">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>

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
</div>
@endsection