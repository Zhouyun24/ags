@extends('layouts.index')

@section('layouts')
@php
    $pengaturanAwal ??= [
        'notifikasiPush' => true,
        'notifikasiEmail' => false,
        'permintaanBaru' => true,
        'pengingatJadwal' => false,
        'suaraNotifikasi' => true,
        'getar' => false,
        'pratinjauPesan' => true,
    ];
@endphp

<div class="pb-8" x-data="{ pengaturan: {{ Illuminate\Support\Js::from($pengaturanAwal) }} }">
    <div class="relative overflow-hidden rounded-b-[28px] bg-gradient-to-br from-[#22C55E] via-[#16A34A] to-[#15803D] px-5 pb-16 pt-5 text-center">
        <h1 class="font-jakarta text-xl font-extrabold text-white">Pengaturan Notifikasi</h1>
        <p class="mt-1 font-inter text-xs text-blue-100">Kelola bagaimana Anda ingin menerima notifikasi</p>
    </div>

    <form method="POST" action="" class="relative px-7 z-10">
        @csrf
        @method('PUT')

        <div class="-mt-12 mb-5 rounded-2xl bg-white p-5 shadow-[0px_4px_16px_0px_#0F172A14]">
            <p class="font-inter text-xs font-bold uppercase tracking-wide text-[#2653EB]">Saluran Notifikasi</p>
            <p class="mb-1 font-inter text-xs text-slate-500">Pilih cara menerima notifikasi</p>

            <div class="divide-y divide-slate-100">
                <div class="flex items-center justify-between py-3">
                    <div>
                        <p class="font-inter text-sm font-medium text-black">Notifikasi Push</p>
                        <p class="font-inter text-xs text-slate-400">Tampilkan di layar & bilah status</p>
                    </div>
                    <label class="relative inline-flex shrink-0 cursor-pointer items-center">
                        <input type="checkbox" name="notifikasi_push" x-model="pengaturan.notifikasiPush" class="peer sr-only">
                        <div class="h-6 w-11 rounded-full bg-slate-200 transition-colors peer-checked:bg-[#2653EB]"></div>
                        <div class="absolute left-1 h-4 w-4 rounded-full bg-white transition-transform peer-checked:translate-x-5"></div>
                    </label>
                </div>
                <div class="flex items-center justify-between py-3">
                    <div>
                        <p class="font-inter text-sm font-medium text-black">Notifikasi Email</p>
                        <p class="font-inter text-xs text-slate-400">Tampilkan di layar & bilah status</p>
                    </div>
                    <label class="relative inline-flex shrink-0 cursor-pointer items-center">
                        <input type="checkbox" name="notifikasi_email" x-model="pengaturan.notifikasiEmail" class="peer sr-only">
                        <div class="h-6 w-11 rounded-full bg-slate-200 transition-colors peer-checked:bg-[#2653EB]"></div>
                        <div class="absolute left-1 h-4 w-4 rounded-full bg-white transition-transform peer-checked:translate-x-5"></div>
                    </label>
                </div>
            </div>
        </div>

        <div class="mb-5 rounded-2xl bg-white p-5 shadow-[0px_4px_16px_0px_#0F172A14]">
            <p class="font-inter text-xs font-bold uppercase tracking-wide text-[#2653EB]">Jenis Notifikasi Bimbingan</p>
            <p class="mb-1 font-inter text-xs text-slate-500">Pilih cara menerima notifikasi</p>

            <div class="divide-y divide-slate-100">
                <div class="flex items-center justify-between py-3">
                    <div>
                        <p class="font-inter text-sm font-medium text-black">Permintaan Baru</p>
                        <p class="font-inter text-xs text-slate-400">Ada mahasiswa mengajukan jadwal</p>
                    </div>
                    <label class="relative inline-flex shrink-0 cursor-pointer items-center">
                        <input type="checkbox" name="permintaan_baru" x-model="pengaturan.permintaanBaru" class="peer sr-only">
                        <div class="h-6 w-11 rounded-full bg-slate-200 transition-colors peer-checked:bg-[#2653EB]"></div>
                        <div class="absolute left-1 h-4 w-4 rounded-full bg-white transition-transform peer-checked:translate-x-5"></div>
                    </label>
                </div>
                <div class="flex items-center justify-between py-3">
                    <div>
                        <p class="font-inter text-sm font-medium text-black">Pengingat Jadwal</p>
                        <p class="font-inter text-xs text-slate-400">Ingatkan 1 jam sebelum sesi bimbingan</p>
                    </div>
                    <label class="relative inline-flex shrink-0 cursor-pointer items-center">
                        <input type="checkbox" name="pengingat_jadwal" x-model="pengaturan.pengingatJadwal" class="peer sr-only">
                        <div class="h-6 w-11 rounded-full bg-slate-200 transition-colors peer-checked:bg-[#2653EB]"></div>
                        <div class="absolute left-1 h-4 w-4 rounded-full bg-white transition-transform peer-checked:translate-x-5"></div>
                    </label>
                </div>
            </div>
        </div>

        <div class="mb-6 rounded-2xl bg-white p-5 shadow-[0px_4px_16px_0px_#0F172A14]">
            <p class="font-inter text-xs font-bold uppercase tracking-wide text-[#2653EB]">Suara & Tampilan</p>
            <p class="mb-1 font-inter text-xs text-slate-500">Pilih cara menerima notifikasi</p>

            <div class="divide-y divide-slate-100">
                <div class="flex items-center justify-between py-3">
                    <div>
                        <p class="font-inter text-sm font-medium text-black">Suara Notifikasi</p>
                        <p class="font-inter text-xs text-slate-400">Mainkan suara saat ada notifikasi masuk</p>
                    </div>
                    <label class="relative inline-flex shrink-0 cursor-pointer items-center">
                        <input type="checkbox" name="suara_notifikasi" x-model="pengaturan.suaraNotifikasi" class="peer sr-only">
                        <div class="h-6 w-11 rounded-full bg-slate-200 transition-colors peer-checked:bg-[#2653EB]"></div>
                        <div class="absolute left-1 h-4 w-4 rounded-full bg-white transition-transform peer-checked:translate-x-5"></div>
                    </label>
                </div>
                <div class="flex items-center justify-between py-3">
                    <div>
                        <p class="font-inter text-sm font-medium text-black">Getar</p>
                        <p class="font-inter text-xs text-slate-400">Getar saat ada notifikasi masuk</p>
                    </div>
                    <label class="relative inline-flex shrink-0 cursor-pointer items-center">
                        <input type="checkbox" name="getar" x-model="pengaturan.getar" class="peer sr-only">
                        <div class="h-6 w-11 rounded-full bg-slate-200 transition-colors peer-checked:bg-[#2653EB]"></div>
                        <div class="absolute left-1 h-4 w-4 rounded-full bg-white transition-transform peer-checked:translate-x-5"></div>
                    </label>
                </div>
                <div class="flex items-center justify-between py-3">
                    <div>
                        <p class="font-inter text-sm font-medium text-black">Pratinjau Pesan</p>
                        <p class="font-inter text-xs text-slate-400">Tampilkan isi pesan di layar kunci</p>
                    </div>
                    <label class="relative inline-flex shrink-0 cursor-pointer items-center">
                        <input type="checkbox" name="pratinjau_pesan" x-model="pengaturan.pratinjauPesan" class="peer sr-only">
                        <div class="h-6 w-11 rounded-full bg-slate-200 transition-colors peer-checked:bg-[#2653EB]"></div>
                        <div class="absolute left-1 h-4 w-4 rounded-full bg-white transition-transform peer-checked:translate-x-5"></div>
                    </label>
                </div>
            </div>
        </div>

        <button type="submit"
            class="mb-6 flex w-full items-center justify-center rounded-lg bg-[#2653EB] py-3.5 font-inter text-sm font-semibold text-white hover:bg-[#1D4ED8]">
            Simpan Pengaturan
        </button>
    </form>
</div>
@endsection