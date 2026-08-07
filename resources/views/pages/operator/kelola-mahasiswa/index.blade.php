@extends('layouts.index')

@section('layouts')
@php
    $jumlahMahasiswa = $mahasiswas->count();
@endphp

<div
    class="pb-5"
    x-data="{
        cari: '',
        modalHapus: false,
        targetId: null,
        targetNama: '',
        targetUrl: '',
        bukaModalHapus(id, nama, url) {
            this.targetId = id;
            this.targetNama = nama;
            this.targetUrl = url;
            this.modalHapus = true;
        },
        tutupModalHapus() {
            this.modalHapus = false;
        },
    }"
>
    <div class="relative overflow-hidden bg-gradient-to-br from-[#8B5CF6] via-[#7C3AED] to-[#6D28D9] px-5 pb-12 pt-10">
        <div class="flex items-start justify-between gap-3">
            <div>
                <h1 class="font-jakarta text-xl font-extrabold text-white">Manajemen Mahasiswa</h1>
                <p class="mt-1 font-inter text-xs text-white">{{ $jumlahMahasiswa }} Mahasiswa terdaftar</p>
            </div>
            <a href="{{ route('operator.kelola-mahasiswa.create') }}"
                class="flex shrink-0 items-center gap-1.5 rounded-lg bg-[#2653EB] px-4 py-2.5 font-inter text-xs font-semibold text-white shadow-[0px_4px_12px_0px_#00000030] hover:bg-[#1D4ED8]">
                <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <path d="M12 5v14M5 12h14" />
                </svg>
                Mahasiswa
            </a>
        </div>
    </div>

    <div class="px-5 pt-6">
        <div class="mb-6 flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-3 shadow-[0px_4px_16px_0px_#0F172A14]">
            <input
                type="text"
                x-model="cari"
                placeholder="Cari NIM atau Nama Mahasiswa"
                class="w-full border-none font-inter text-xs text-black placeholder:text-slate-400 focus:outline-none focus:ring-0"
            />
            <svg class="h-4 w-4 text-black" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2">
                <circle cx="11" cy="11" r="7" />
                <path d="m21 21-4.3-4.3" />
            </svg>
        </div>

        <div class="flex flex-col gap-4">
            @forelse ($mahasiswas as $mhs)
                <div x-show="cari === '' || '{{ strtolower($mhs->nim . ' ' . ($mhs->pengguna->nama ?? '')) }}'.includes(cari.toLowerCase())" class="mb-4 rounded-xl border border-slate-100 bg-white p-4 shadow-[0px_4px_16px_0px_#0F172A14]">
                    <div class="mb-4 flex items-start gap-4">
                        <img src="{{ $mhs->pengguna?->foto_profil ? asset('storage/' . $mhs->pengguna->foto_profil) : 'https://ui-avatars.com/api/?name=' . urlencode($mhs->pengguna?->nama ?? 'M') . '&background=random' }}"
                            alt="Profile" class="h-[52px] w-[52px] rounded-full object-cover">
                        <div class="flex-1">
                            <h2 class="font-jakarta text-base font-extrabold text-black">{{ $mhs->pengguna?->nama ?? '-' }}</h2>
                            <p class="font-inter text-sm text-slate-500">{{ $mhs->nim }}</p>
                        </div>
                    </div>

                    <div class="mb-4 grid grid-cols-2 gap-4 rounded-lg bg-slate-50 p-3">
                        <div>
                            <p class="mb-1 font-inter text-[10px] text-slate-400">Program Studi</p>
                            <p class="font-inter text-xs font-semibold text-black">{{ $mhs->program_studi }}</p>
                        </div>
                        <div>
                            <p class="mb-1 font-inter text-[10px] text-slate-400">Semester</p>
                            <p class="font-inter text-xs font-semibold text-black">Semester {{ $mhs->semester }}</p>
                        </div>
                        <div class="col-span-2 border-t border-slate-200 pt-3">
                            <p class="mb-1 font-inter text-[10px] text-slate-400">Dosen Pembimbing Akademik</p>
                            <p class="font-inter text-xs font-semibold text-black">{{ $mhs->dosenPA?->pengguna?->nama ?? 'Belum Ditentukan' }}</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-3 gap-2">
                        <a href="{{ route('operator.kelola-mahasiswa.show', $mhs->nim) }}"
                            class="flex w-full items-center justify-center gap-1.5 rounded-lg border border-[#2653EB] py-2.5 font-inter text-xs font-semibold text-[#2653EB] transition hover:bg-blue-50">
                            Lihat Profil
                        </a>
                        <a href="{{ route('operator.kelola-mahasiswa.edit', $mhs->nim) }}"
                            class="flex w-full items-center justify-center gap-1.5 rounded-lg border border-[#16A34A] py-2.5 font-inter text-xs font-semibold text-[#16A34A] transition hover:bg-green-50">
                            Edit
                        </a>
                        <button type="button" @click="bukaModalHapus('{{ $mhs->nim }}', '{{ addslashes($mhs->pengguna?->nama ?? '') }}', '{{ route('operator.kelola-mahasiswa.destroy', $mhs->nim) }}')"
                            class="flex w-full items-center justify-center gap-1.5 rounded-lg border border-[#DC2626] py-2.5 font-inter text-xs font-semibold text-[#DC2626] transition hover:bg-red-50">
                            Hapus
                        </button>
                    </div>
                </div>
            @empty
                <div class="rounded-xl bg-white py-10 text-center shadow-[0px_4px_16px_0px_#0F172A14]">
                    <p class="font-inter text-sm text-slate-400">Belum ada data mahasiswa.</p>
                </div>
            @endforelse
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
                <p class="mt-3 font-jakarta text-base font-extrabold text-black">Hapus Data Mahasiswa?</p>
                <p class="mt-1 font-inter text-xs text-slate-500">
                    Data mahasiswa <span class="font-semibold text-black" x-text="targetNama"></span> akan dihapus secara permanen dan tidak dapat dikembalikan.
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
