@extends('layouts.index')

@section('layouts')
@php
    $pengaturan ??= [
        'push_layar' => true,
        'push_bilah_status' => false,
        'jadwal_disetujui' => true,
        'jadwal_ditolak' => false,
        'pengingat_jadwal' => true,
        'hasil_bimbingan' => true,
        'evaluasi_baru' => true,
        'suara_notifikasi' => true,
        'getar' => false,
        'pratinjau_pesan' => true,
    ];
@endphp

<div x-data="{ settings: {{ Illuminate\Support\Js::from($pengaturan) }} }" class="pb-8">

    {{-- Header --}}
    <div class="relative overflow-hidden rounded-b-[28px] bg-gradient-to-br from-[#2563ED] via-[#2251E3] to-[#1D4ED8] px-5 pb-16 pt-5 text-center">
        <h1 class="font-jakarta text-xl font-extrabold text-white">Pengaturan Notifikasi</h1>
        <p class="mt-1 font-inter text-xs text-blue-100">Kelola bagaimana Anda ingin menerima notifikasi</p>
    </div>

    <form action="" method="POST" class="px-5">
        @csrf
        @method('PUT')

        {{-- Saluran Notifikasi --}}
        <div class="-mt-12 mb-5 rounded-2xl bg-white p-5 shadow-[0px_4px_16px_0px_#0F172A14]">
            <p class="font-inter text-xs font-bold uppercase tracking-wide text-[#2653EB]">Saluran Notifikasi</p>
            <p class="mt-0.5 font-inter text-xs text-slate-400">Pilih cara menerima notifikasi</p>

            <div class="mt-4 divide-y divide-slate-100">
                <div class="flex items-center justify-between py-4">
                    <div class="pr-4">
                        <p class="font-inter text-sm font-semibold text-black">Notifikasi Push</p>
                        <p class="font-inter text-xs text-slate-400">Tampilkan di layar &amp; bilah status</p>
                    </div>
                    <button type="button" role="switch" :aria-checked="settings.push_layar"
                        @click="settings.push_layar = !settings.push_layar"
                        :class="settings.push_layar ? 'bg-[#2653EB]' : 'bg-slate-200'"
                        class="relative h-6 w-11 shrink-0 rounded-full transition-colors">
                        <span :class="settings.push_layar ? 'translate-x-5' : 'translate-x-0.5'"
                            class="absolute top-0.5 h-5 w-5 rounded-full bg-white shadow transition-transform"></span>
                    </button>
                    <input type="hidden" name="push_layar" :value="settings.push_layar ? 1 : 0">
                </div>

                <div class="flex items-center justify-between py-4">
                    <div class="pr-4">
                        <p class="font-inter text-sm font-semibold text-black">Notifikasi Email</p>
                        <p class="font-inter text-xs text-slate-400">Tampilkan di layar &amp; bilah status</p>
                    </div>
                    <button type="button" role="switch" :aria-checked="settings.push_bilah_status"
                        @click="settings.push_bilah_status = !settings.push_bilah_status"
                        :class="settings.push_bilah_status ? 'bg-[#2653EB]' : 'bg-slate-200'"
                        class="relative h-6 w-11 shrink-0 rounded-full transition-colors">
                        <span :class="settings.push_bilah_status ? 'translate-x-5' : 'translate-x-0.5'"
                            class="absolute top-0.5 h-5 w-5 rounded-full bg-white shadow transition-transform"></span>
                    </button>
                    <input type="hidden" name="push_bilah_status" :value="settings.push_bilah_status ? 1 : 0">
                </div>
            </div>
        </div>

        {{-- Jenis Notifikasi Bimbingan --}}
        <div class="mb-5 rounded-2xl bg-white p-5 shadow-[0px_4px_16px_0px_#0F172A14]">
            <p class="font-inter text-xs font-bold uppercase tracking-wide text-[#2653EB]">Jenis Notifikasi Bimbingan</p>
            <p class="mt-0.5 font-inter text-xs text-slate-400">Pilih cara menerima notifikasi</p>

            <div class="mt-4 divide-y divide-slate-100">
                <div class="flex items-center justify-between py-4">
                    <div class="pr-4">
                        <p class="font-inter text-sm font-semibold text-black">Jadwal Disetujui</p>
                        <p class="font-inter text-xs text-slate-400">Dosen menyetujui permintaan bimbingan Anda</p>
                    </div>
                    <button type="button" role="switch" :aria-checked="settings.jadwal_disetujui"
                        @click="settings.jadwal_disetujui = !settings.jadwal_disetujui"
                        :class="settings.jadwal_disetujui ? 'bg-[#2653EB]' : 'bg-slate-200'"
                        class="relative h-6 w-11 shrink-0 rounded-full transition-colors">
                        <span :class="settings.jadwal_disetujui ? 'translate-x-5' : 'translate-x-0.5'"
                            class="absolute top-0.5 h-5 w-5 rounded-full bg-white shadow transition-transform"></span>
                    </button>
                    <input type="hidden" name="jadwal_disetujui" :value="settings.jadwal_disetujui ? 1 : 0">
                </div>

                <div class="flex items-center justify-between py-4">
                    <div class="pr-4">
                        <p class="font-inter text-sm font-semibold text-black">Jadwal Ditolak</p>
                        <p class="font-inter text-xs text-slate-400">Dosen menolak permintaan bimbingan Anda</p>
                    </div>
                    <button type="button" role="switch" :aria-checked="settings.jadwal_ditolak"
                        @click="settings.jadwal_ditolak = !settings.jadwal_ditolak"
                        :class="settings.jadwal_ditolak ? 'bg-[#2653EB]' : 'bg-slate-200'"
                        class="relative h-6 w-11 shrink-0 rounded-full transition-colors">
                        <span :class="settings.jadwal_ditolak ? 'translate-x-5' : 'translate-x-0.5'"
                            class="absolute top-0.5 h-5 w-5 rounded-full bg-white shadow transition-transform"></span>
                    </button>
                    <input type="hidden" name="jadwal_ditolak" :value="settings.jadwal_ditolak ? 1 : 0">
                </div>

                <div class="flex items-center justify-between py-4">
                    <div class="pr-4">
                        <p class="font-inter text-sm font-semibold text-black">Pengingat Jadwal</p>
                        <p class="font-inter text-xs text-slate-400">Ingatkan 1 jam sebelum sesi bimbingan</p>
                    </div>
                    <button type="button" role="switch" :aria-checked="settings.pengingat_jadwal"
                        @click="settings.pengingat_jadwal = !settings.pengingat_jadwal"
                        :class="settings.pengingat_jadwal ? 'bg-[#2653EB]' : 'bg-slate-200'"
                        class="relative h-6 w-11 shrink-0 rounded-full transition-colors">
                        <span :class="settings.pengingat_jadwal ? 'translate-x-5' : 'translate-x-0.5'"
                            class="absolute top-0.5 h-5 w-5 rounded-full bg-white shadow transition-transform"></span>
                    </button>
                    <input type="hidden" name="pengingat_jadwal" :value="settings.pengingat_jadwal ? 1 : 0">
                </div>

                <div class="flex items-center justify-between py-4">
                    <div class="pr-4">
                        <p class="font-inter text-sm font-semibold text-black">Hasil Bimbingan</p>
                        <p class="font-inter text-xs text-slate-400">Dosen menambahkan catatan bimbingan</p>
                    </div>
                    <button type="button" role="switch" :aria-checked="settings.hasil_bimbingan"
                        @click="settings.hasil_bimbingan = !settings.hasil_bimbingan"
                        :class="settings.hasil_bimbingan ? 'bg-[#2653EB]' : 'bg-slate-200'"
                        class="relative h-6 w-11 shrink-0 rounded-full transition-colors">
                        <span :class="settings.hasil_bimbingan ? 'translate-x-5' : 'translate-x-0.5'"
                            class="absolute top-0.5 h-5 w-5 rounded-full bg-white shadow transition-transform"></span>
                    </button>
                    <input type="hidden" name="hasil_bimbingan" :value="settings.hasil_bimbingan ? 1 : 0">
                </div>

                <div class="flex items-center justify-between py-4">
                    <div class="pr-4">
                        <p class="font-inter text-sm font-semibold text-black">Evaluasi Baru</p>
                        <p class="font-inter text-xs text-slate-400">Hasil evaluasi akademik tersedia</p>
                    </div>
                    <button type="button" role="switch" :aria-checked="settings.evaluasi_baru"
                        @click="settings.evaluasi_baru = !settings.evaluasi_baru"
                        :class="settings.evaluasi_baru ? 'bg-[#2653EB]' : 'bg-slate-200'"
                        class="relative h-6 w-11 shrink-0 rounded-full transition-colors">
                        <span :class="settings.evaluasi_baru ? 'translate-x-5' : 'translate-x-0.5'"
                            class="absolute top-0.5 h-5 w-5 rounded-full bg-white shadow transition-transform"></span>
                    </button>
                    <input type="hidden" name="evaluasi_baru" :value="settings.evaluasi_baru ? 1 : 0">
                </div>
            </div>
        </div>

        {{-- Suara & Tampilan --}}
        <div class="mb-6 rounded-2xl bg-white p-5 shadow-[0px_4px_16px_0px_#0F172A14]">
            <p class="font-inter text-xs font-bold uppercase tracking-wide text-[#2653EB]">Suara &amp; Tampilan</p>
            <p class="mt-0.5 font-inter text-xs text-slate-400">Pilih cara menerima notifikasi</p>

            <div class="mt-4 divide-y divide-slate-100">
                <div class="flex items-center justify-between py-4">
                    <div class="pr-4">
                        <p class="font-inter text-sm font-semibold text-black">Suara Notifikasi</p>
                        <p class="font-inter text-xs text-slate-400">Mainkan suara saat ada notifikasi masuk</p>
                    </div>
                    <button type="button" role="switch" :aria-checked="settings.suara_notifikasi"
                        @click="settings.suara_notifikasi = !settings.suara_notifikasi"
                        :class="settings.suara_notifikasi ? 'bg-[#2653EB]' : 'bg-slate-200'"
                        class="relative h-6 w-11 shrink-0 rounded-full transition-colors">
                        <span :class="settings.suara_notifikasi ? 'translate-x-5' : 'translate-x-0.5'"
                            class="absolute top-0.5 h-5 w-5 rounded-full bg-white shadow transition-transform"></span>
                    </button>
                    <input type="hidden" name="suara_notifikasi" :value="settings.suara_notifikasi ? 1 : 0">
                </div>

                <div class="flex items-center justify-between py-4">
                    <div class="pr-4">
                        <p class="font-inter text-sm font-semibold text-black">Getar</p>
                        <p class="font-inter text-xs text-slate-400">Getar saat ada notifikasi masuk</p>
                    </div>
                    <button type="button" role="switch" :aria-checked="settings.getar"
                        @click="settings.getar = !settings.getar"
                        :class="settings.getar ? 'bg-[#2653EB]' : 'bg-slate-200'"
                        class="relative h-6 w-11 shrink-0 rounded-full transition-colors">
                        <span :class="settings.getar ? 'translate-x-5' : 'translate-x-0.5'"
                            class="absolute top-0.5 h-5 w-5 rounded-full bg-white shadow transition-transform"></span>
                    </button>
                    <input type="hidden" name="getar" :value="settings.getar ? 1 : 0">
                </div>

                <div class="flex items-center justify-between py-4">
                    <div class="pr-4">
                        <p class="font-inter text-sm font-semibold text-black">Pratinjau Pesan</p>
                        <p class="font-inter text-xs text-slate-400">Tampilkan isi pesan di layar kunci</p>
                    </div>
                    <button type="button" role="switch" :aria-checked="settings.pratinjau_pesan"
                        @click="settings.pratinjau_pesan = !settings.pratinjau_pesan"
                        :class="settings.pratinjau_pesan ? 'bg-[#2653EB]' : 'bg-slate-200'"
                        class="relative h-6 w-11 shrink-0 rounded-full transition-colors">
                        <span :class="settings.pratinjau_pesan ? 'translate-x-5' : 'translate-x-0.5'"
                            class="absolute top-0.5 h-5 w-5 rounded-full bg-white shadow transition-transform"></span>
                    </button>
                    <input type="hidden" name="pratinjau_pesan" :value="settings.pratinjau_pesan ? 1 : 0">
                </div>
            </div>
        </div>

        {{-- Tombol Simpan --}}
        <button type="submit"
            class="w-full rounded-2xl bg-gradient-to-br from-[#2563ED] via-[#2251E3] to-[#1D4ED8] py-3.5 font-inter text-sm font-semibold text-white hover:opacity-90">
            Simpan Pengaturan
        </button>
    </form>
</div>
@endsection