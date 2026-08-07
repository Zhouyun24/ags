@extends('layouts.index')

@section('layouts')
@php
    $daftarJadwal = collect([
        [
            'id' => 1,
            'namaMhs' => 'Nama Mhs',
            'nim' => '10124257',
            'topik' => 'Topik diskusi',
            'namaDosen' => 'Nama Dosen',
            'nip' => 'NIP',
            'tanggal' => 'DD/MM/YYYY',
            'jam' => 'HH/MM WIB',
            'status' => 'disetujui',
            'urlHapus' => route('operator.kelola-jadwal.index'),
        ],
        [
            'id' => 2,
            'namaMhs' => 'Nama Mhs Lain',
            'nim' => '10124999',
            'topik' => 'Topik diskusi lain',
            'namaDosen' => 'Nama Dosen Lain',
            'nip' => 'NIP',
            'tanggal' => 'DD/MM/YYYY',
            'jam' => 'HH/MM WIB',
            'status' => 'menunggu',
            'urlHapus' => route('operator.kelola-jadwal.index'),
        ],
    ]);
@endphp

<div
    class="pb-5"
    x-data='{
        cari: "",
        daftar: @json($daftarJadwal),
        modalHapus: false,
        targetId: null,
        targetNama: "",
        targetUrl: "",
        get hasil() {
            const kataKunci = this.cari.trim().toLowerCase();
            if (kataKunci === "") return [];
            return this.daftar.filter((item) =>
                item.nim.toLowerCase().includes(kataKunci) ||
                item.nip.toLowerCase().includes(kataKunci) ||
                item.namaMhs.toLowerCase().includes(kataKunci) ||
                item.namaDosen.toLowerCase().includes(kataKunci)
            );
        },
        bukaModalHapus(id, nama, url) {
            this.targetId = id;
            this.targetNama = nama;
            this.targetUrl = url;
            this.modalHapus = true;
        },
        tutupModalHapus() {
            this.modalHapus = false;
        },
    }'
>
    <div class="relative overflow-hidden bg-gradient-to-br from-[#8B5CF6] via-[#7C3AED] to-[#6D28D9] px-5 pb-12 pt-10">
        <h1 class="font-jakarta text-xl font-extrabold text-white">Manajemen Jadwal</h1>
        <p class="mt-1 font-inter text-xs text-white">Kelola Jadwal Berdasarkan Pengguna</p>
    </div>

    <div class="px-5 pt-6">
        <div class="mb-6 flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-3 shadow-[0px_4px_16px_0px_#0F172A14]">
            <input
                type="text"
                x-model="cari"
                placeholder="Cari NIM/NIP atau Nama Mahasiswa/Dosen"
                class="w-full border-none font-inter text-xs text-black placeholder:text-slate-400 focus:outline-none focus:ring-0"
            />
            <svg class="h-4 w-4 shrink-0 text-black" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2">
                <circle cx="11" cy="11" r="7" />
                <path d="m21 21-4.3-4.3" />
            </svg>
        </div>

        <div x-show="cari.trim() === ''" class="flex flex-col items-center pt-16 text-center">
            <svg class="h-16 w-16 text-slate-300" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                <circle cx="11" cy="11" r="7" />
                <path d="m21 21-4.3-4.3" />
            </svg>
            <p class="mt-4 max-w-[240px] font-inter text-sm text-slate-400">
                Masukkan NIM/NIP atau nama mahasiswa/dosen yang akan dikelola.
            </p>
        </div>

        <div x-show="cari.trim() !== '' && hasil.length === 0" class="flex flex-col items-center pt-16 text-center">
            <svg class="h-16 w-16 text-slate-300" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                <circle cx="11" cy="11" r="7" />
                <path d="m21 21-4.3-4.3" />
            </svg>
            <p class="mt-4 max-w-[240px] font-inter text-sm text-slate-400">
                Tidak ditemukan data untuk "<span x-text="cari"></span>".
            </p>
        </div>

        <div class="flex flex-col gap-4">
            <template x-for="jadwal in hasil" :key="jadwal.id">
                <div class="rounded-2xl bg-white p-4 shadow-[0px_4px_16px_0px_#0F172A14]">
                    <div class="flex items-start justify-between">
                        <div class="flex items-start gap-3">
                            <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-[#7C3AED]/15">
                                <svg class="h-6 w-6 text-[#7C3AED]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                                    <circle cx="12" cy="7" r="4" />
                                </svg>
                            </span>
                            <div>
                                <p class="font-jakarta text-base font-extrabold text-black" x-text="jadwal.namaMhs"></p>
                                <p class="font-inter text-xs text-slate-500">
                                    <span x-text="jadwal.topik"></span> &bull; <span x-text="jadwal.nim"></span>
                                </p>
                                <p class="font-inter text-xs font-semibold text-[#2653EB]">
                                    <span x-text="jadwal.namaDosen"></span>, <span x-text="jadwal.nip"></span>
                                </p>
                            </div>
                        </div>
                        <span
                            :class="{
                                'bg-[#DCFCE7] text-[#16A34A]': jadwal.status === 'disetujui',
                                'bg-[#FEE2E2] text-[#DC2626]': jadwal.status === 'ditolak',
                                'bg-[#FEF3C7] text-[#F59E0B]': jadwal.status === 'menunggu',
                            }"
                            class="inline-flex shrink-0 items-center gap-1 whitespace-nowrap rounded-xl px-2.5 py-1 font-inter text-[10px]"
                        >
                            <svg x-show="jadwal.status === 'disetujui'" class="h-3 w-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                                <path d="M5 13l4 4L19 7" />
                            </svg>
                            <svg x-show="jadwal.status === 'ditolak'" class="h-3 w-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                                <path d="M6 6l12 12M18 6 6 18" />
                            </svg>
                            <svg x-show="jadwal.status === 'menunggu'" class="h-3 w-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                <circle cx="12" cy="12" r="9" />
                                <path d="M12 7v5l3 3" />
                            </svg>
                            <span x-text="jadwal.status === 'disetujui' ? 'Disetujui' : (jadwal.status === 'ditolak' ? 'Ditolak' : 'Menunggu')"></span>
                        </span>
                    </div>

                    {{-- Tanggal & jam --}}
                    <div class="mt-4 flex items-center gap-4 rounded-lg bg-[#E0E7FF]/60 px-3 py-2.5">
                        <span class="flex items-center gap-1.5 font-inter text-xs text-slate-700">
                            <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                <rect x="3" y="4" width="18" height="17" rx="2" />
                                <path d="M3 9h18M8 2v4M16 2v4" />
                            </svg>
                            <span x-text="jadwal.tanggal"></span>
                        </span>
                        <span class="flex items-center gap-1.5 font-inter text-xs text-slate-700">
                            <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                <circle cx="12" cy="12" r="9" />
                                <path d="M12 7v5l3 3" />
                            </svg>
                            <span x-text="jadwal.jam"></span>
                        </span>
                    </div>

                    <button
                        type="button"
                        @click="bukaModalHapus(jadwal.id, jadwal.namaMhs, jadwal.urlHapus)"
                        class="mt-4 flex w-full items-center justify-center rounded-lg bg-[#DC2626] py-2.5 font-inter text-sm font-semibold text-white hover:bg-[#B91C1C]"
                    >
                        Hapus
                    </button>
                </div>
            </template>
        </div>
    </div>

    <div
        x-show="modalHapus"
        x-cloak
        x-transition:enter="transition-opacity ease-out duration-200"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition-opacity ease-in duration-150"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        @click.self="tutupModalHapus()"
        @keydown.escape.window="tutupModalHapus()"
        class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/50 px-6"
    >
        <div
            x-show="modalHapus"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95"
            class="w-full max-w-sm rounded-2xl bg-white p-5 shadow-xl"
        >
            <div class="flex flex-col items-center text-center">
                <span class="flex h-12 w-12 items-center justify-center rounded-full bg-[#FEE2E2]">
                    <svg class="h-6 w-6 text-[#DC2626]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M12 9v4M12 17h.01" />
                        <path d="M10.29 3.86 1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0Z" />
                    </svg>
                </span>
                <p class="mt-3 font-jakarta text-base font-extrabold text-black">Hapus Jadwal Bimbingan?</p>
                <p class="mt-1 font-inter text-xs text-slate-500">
                    Jadwal bimbingan <span class="font-semibold text-black" x-text="targetNama"></span> akan dihapus secara permanen dan tidak dapat dikembalikan.
                </p>
            </div>

            <div class="mt-5 grid grid-cols-2 gap-3">
                <button
                    type="button"
                    @click="tutupModalHapus()"
                    class="flex items-center justify-center rounded-lg border border-slate-200 py-2.5 font-inter text-sm font-semibold text-black hover:bg-slate-50"
                >
                    Batal
                </button>
                <form method="POST" :action="targetUrl">
                    @csrf
                    @method('DELETE')
                    <button
                        type="submit"
                        class="flex w-full items-center justify-center rounded-lg bg-[#DC2626] py-2.5 font-inter text-sm font-semibold text-white hover:bg-[#B91C1C]"
                    >
                        Ya, Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection