@extends('layouts.index')

@section('layouts')
@php
    $pengaturanAwal = [
        'notifikasiPush' => true,
        'notifikasiEmail' => false,
        'suaraNotifikasi' => true,
        'getar' => false,
        'pratinjauPesan' => true,
        'mahasiswaBaru' => true,
        'dosenBaru' => false,
        'operatorBaru' => false,
        'loginPerangkatBaru' => false,
        'jadwalMasukSemua' => true,
        'laporanHarianOtomatis' => false,
        'gangguanSistem' => true,
        'pengumumanSistem' => false,
        'frekuensi' => 'mingguan',
    ];
@endphp

<div class="pb-8" x-data="{ pengaturan: {{ Illuminate\Support\Js::from($pengaturanAwal) }} }">
    <div class="relative overflow-hidden rounded-b-[28px] bg-gradient-to-br from-[#8B5CF6] via-[#7C3AED] to-[#6D28D9] px-5 pb-16 pt-5 text-center">
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
            <p class="font-inter text-xs font-bold uppercase tracking-wide text-[#2653EB]">Aktivitas Pengguna</p>
            <p class="mb-1 font-inter text-xs text-slate-500">Notifikasi terkait perubahan pengguna</p>

            <div class="divide-y divide-slate-100">
                <div class="flex items-center justify-between py-3">
                    <div>
                        <p class="font-inter text-sm font-medium text-black">Mahasiswa Baru</p>
                        <p class="font-inter text-xs text-slate-400">Mahasiswa baru ditambahkan</p>
                    </div>
                    <label class="relative inline-flex shrink-0 cursor-pointer items-center">
                        <input type="checkbox" name="mahasiswa_baru" x-model="pengaturan.mahasiswaBaru" class="peer sr-only">
                        <div class="h-6 w-11 rounded-full bg-slate-200 transition-colors peer-checked:bg-[#2653EB]"></div>
                        <div class="absolute left-1 h-4 w-4 rounded-full bg-white transition-transform peer-checked:translate-x-5"></div>
                    </label>
                </div>
                <div class="flex items-center justify-between py-3">
                    <div>
                        <p class="font-inter text-sm font-medium text-black">Dosen Baru</p>
                        <p class="font-inter text-xs text-slate-400">Dosen baru ditambahkan</p>
                    </div>
                    <label class="relative inline-flex shrink-0 cursor-pointer items-center">
                        <input type="checkbox" name="dosen_baru" x-model="pengaturan.dosenBaru" class="peer sr-only">
                        <div class="h-6 w-11 rounded-full bg-slate-200 transition-colors peer-checked:bg-[#2653EB]"></div>
                        <div class="absolute left-1 h-4 w-4 rounded-full bg-white transition-transform peer-checked:translate-x-5"></div>
                    </label>
                </div>
                <div class="flex items-center justify-between py-3">
                    <div>
                        <p class="font-inter text-sm font-medium text-black">Operator Baru</p>
                        <p class="font-inter text-xs text-slate-400">Operator baru ditambahkan</p>
                    </div>
                    <label class="relative inline-flex shrink-0 cursor-pointer items-center">
                        <input type="checkbox" name="operator_baru" x-model="pengaturan.operatorBaru" class="peer sr-only">
                        <div class="h-6 w-11 rounded-full bg-slate-200 transition-colors peer-checked:bg-[#2653EB]"></div>
                        <div class="absolute left-1 h-4 w-4 rounded-full bg-white transition-transform peer-checked:translate-x-5"></div>
                    </label>
                </div>
                <div class="flex items-center justify-between py-3">
                    <div>
                        <p class="font-inter text-sm font-medium text-black">Login dari perangkat baru</p>
                        <p class="font-inter text-xs text-slate-400">Deteksi login dari lokasi & perangkat baru</p>
                    </div>
                    <label class="relative inline-flex shrink-0 cursor-pointer items-center">
                        <input type="checkbox" name="login_perangkat_baru" x-model="pengaturan.loginPerangkatBaru" class="peer sr-only">
                        <div class="h-6 w-11 rounded-full bg-slate-200 transition-colors peer-checked:bg-[#2653EB]"></div>
                        <div class="absolute left-1 h-4 w-4 rounded-full bg-white transition-transform peer-checked:translate-x-5"></div>
                    </label>
                </div>
            </div>
        </div>

        <div class="mb-5 rounded-2xl bg-white p-5 shadow-[0px_4px_16px_0px_#0F172A14]">
            <p class="font-inter text-xs font-bold uppercase tracking-wide text-[#2653EB]">AKTIVITAS BIMBINGAN</p>
            <p class="mb-1 font-inter text-xs text-slate-500">Ringkasan aktivitas bimbingan di seluruh sistem</p>

            <div class="divide-y divide-slate-100">
                <div class="flex items-center justify-between py-3">
                    <div>
                        <p class="font-inter text-sm font-medium text-black">Jadwal Masuk (Semua)</p>
                        <p class="font-inter text-xs text-slate-400">Ada pengajuan jadwal baru yang masuk</p>
                    </div>
                    <label class="relative inline-flex shrink-0 cursor-pointer items-center">
                        <input type="checkbox" name="jadwal_masuk_semua" x-model="pengaturan.jadwalMasukSemua" class="peer sr-only">
                        <div class="h-6 w-11 rounded-full bg-slate-200 transition-colors peer-checked:bg-[#2653EB]"></div>
                        <div class="absolute left-1 h-4 w-4 rounded-full bg-white transition-transform peer-checked:translate-x-5"></div>
                    </label>
                </div>
                <div class="flex items-center justify-between py-3">
                    <div>
                        <p class="font-inter text-sm font-medium text-black">Laporan Harian Otomatis</p>
                        <p class="font-inter text-xs text-slate-400">Rekap harian bimbingan </p>
                    </div>
                    <label class="relative inline-flex shrink-0 cursor-pointer items-center">
                        <input type="checkbox" name="laporan_harian_otomatis" x-model="pengaturan.laporanHarianOtomatis" class="peer sr-only">
                        <div class="h-6 w-11 rounded-full bg-slate-200 transition-colors peer-checked:bg-[#2653EB]"></div>
                        <div class="absolute left-1 h-4 w-4 rounded-full bg-white transition-transform peer-checked:translate-x-5"></div>
                    </label>
                </div>
            </div>
        </div>

        <div class="mb-5 rounded-2xl bg-white p-5 shadow-[0px_4px_16px_0px_#0F172A14]">
            <p class="font-inter text-xs font-bold uppercase tracking-wide text-[#2653EB]">NOTIFIKASI SISTEM</p>
            <p class="mb-1 font-inter text-xs text-slate-500">Alat teknis dan keamanan sistem AGS</p>

            <div class="divide-y divide-slate-100">
                <div class="flex items-center justify-between py-3">
                    <div>
                        <p class="font-inter text-sm font-medium text-black">Error/Gangguan Sistem</p>
                        <p class="font-inter text-xs text-slate-400">Alert jika ada gangguan kritis pada sistem</p>
                    </div>
                    <label class="relative inline-flex shrink-0 cursor-pointer items-center">
                        <input type="checkbox" name="gangguan_sistem" x-model="pengaturan.gangguanSistem" class="peer sr-only">
                        <div class="h-6 w-11 rounded-full bg-slate-200 transition-colors peer-checked:bg-[#2653EB]"></div>
                        <div class="absolute left-1 h-4 w-4 rounded-full bg-white transition-transform peer-checked:translate-x-5"></div>
                    </label>
                </div>
                <div class="flex items-center justify-between py-3">
                    <div>
                        <p class="font-inter text-sm font-medium text-black">Pengumuman Sistem</p>
                        <p class="font-inter text-xs text-slate-400">Pembaruan, pemeliharaan atau rilis fitur baru</p>
                    </div>
                    <label class="relative inline-flex shrink-0 cursor-pointer items-center">
                        <input type="checkbox" name="pengumuman_sistem" x-model="pengaturan.pengumumanSistem" class="peer sr-only">
                        <div class="h-6 w-11 rounded-full bg-slate-200 transition-colors peer-checked:bg-[#2653EB]"></div>
                        <div class="absolute left-1 h-4 w-4 rounded-full bg-white transition-transform peer-checked:translate-x-5"></div>
                    </label>
                </div>
            </div>
        </div>

        <div class="mb-5 rounded-2xl bg-white p-5 shadow-[0px_4px_16px_0px_#0F172A14]">
            <p class="font-inter text-xs font-bold uppercase tracking-wide text-[#2653EB]">FREKUENSI LAPORAN</p>
            <p class="mb-1 font-inter text-xs text-slate-500">Pilih cara menerima notifikasi</p>

            <div class="divide-y divide-slate-100">
                <label class="flex cursor-pointer items-start gap-3 py-4">
                    <input type="radio" name="frekuensi" value="harian" x-model="pengaturan.frekuensi" class="peer sr-only">
                    <span class="relative mt-0.5 flex h-6 w-6 shrink-0 items-center justify-center rounded-full border-2 transition-colors"
                        :class="pengaturan.frekuensi === 'harian' ? 'border-[#8B5CF6]' : 'border-slate-200'">
                        <span class="h-3 w-3 rounded-full bg-[#8B5CF6] transition-opacity"
                            :class="pengaturan.frekuensi === 'harian' ? 'opacity-100' : 'opacity-0'"></span>
                    </span>
                    <span>
                        <span class="block font-inter text-sm font-semibold text-black">Harian</span>
                        <span class="block font-inter text-xs text-slate-400">Laporan terkirim setiap hari pukul 07:00</span>
                    </span>
                </label>

                <label class="flex cursor-pointer items-start gap-3 py-4">
                    <input type="radio" name="frekuensi" value="mingguan" x-model="pengaturan.frekuensi" class="peer sr-only">
                    <span class="relative mt-0.5 flex h-6 w-6 shrink-0 items-center justify-center rounded-full border-2 transition-colors"
                        :class="pengaturan.frekuensi === 'mingguan' ? 'border-[#8B5CF6]' : 'border-slate-200'">
                        <span class="h-3 w-3 rounded-full bg-[#8B5CF6] transition-opacity"
                            :class="pengaturan.frekuensi === 'mingguan' ? 'opacity-100' : 'opacity-0'"></span>
                    </span>
                    <span>
                        <span class="block font-inter text-sm font-semibold text-black">Mingguan</span>
                        <span class="block font-inter text-xs text-slate-400">Laporan terkirim setiap senin pukul 07:00</span>
                    </span>
                </label>

                <label class="flex cursor-pointer items-start gap-3 py-4">
                    <input type="radio" name="frekuensi" value="bulanan" x-model="pengaturan.frekuensi" class="peer sr-only">
                    <span class="relative mt-0.5 flex h-6 w-6 shrink-0 items-center justify-center rounded-full border-2 transition-colors"
                        :class="pengaturan.frekuensi === 'bulanan' ? 'border-[#8B5CF6]' : 'border-slate-200'">
                        <span class="h-3 w-3 rounded-full bg-[#8B5CF6] transition-opacity"
                            :class="pengaturan.frekuensi === 'bulanan' ? 'opacity-100' : 'opacity-0'"></span>
                    </span>
                    <span>
                        <span class="block font-inter text-sm font-semibold text-black">Bulanan</span>
                        <span class="block font-inter text-xs text-slate-400">Laporan terkirim setiap tanggal 1 pukul 07:00</span>
                    </span>
                </label>
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