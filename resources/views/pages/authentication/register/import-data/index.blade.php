@extends('layouts.index')

@section('layouts')
<div
    class="flex min-h-screen flex-col pb-8"
    x-data="{
        activeTab: 'mahasiswa',
        status: {
            mahasiswa: { fileName: '', imported: false },
            dosen: { fileName: '', imported: false },
        },
        get current() {
            return this.status[this.activeTab];
        },
        pilihFile(event) {
            const file = event.target.files[0];
            if (file) {
                this.status[this.activeTab].fileName = file.name;
                this.status[this.activeTab].imported = false;
            }
            event.target.value = '';
        },
        hapusFile() {
            this.status[this.activeTab].fileName = '';
            this.status[this.activeTab].imported = false;
        },
        importData() {
            if (!this.current.fileName || this.current.imported) return;
            // TODO: ganti dengan proses import sesungguhnya (axios/fetch ke endpoint import)
            this.status[this.activeTab].imported = true;
        },
    }"
>
    <div class="relative overflow-hidden rounded-b-[28px] bg-gradient-to-br from-[#2563ED] via-[#2251E3] to-[#1D4ED8] px-6 pb-8 pt-8">
        <span class="flex h-12 w-12 items-center justify-center rounded-xl bg-white/20">
            <svg class="h-6 w-6 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                <path d="M22 10v6M2 10l10-5 10 5-10 5-10-5Z" />
                <path d="M6 12v5c0 1.1 2.7 2 6 2s6-.9 6-2v-5" />
            </svg>
        </span>
        <h1 class="mt-4 font-jakarta text-2xl font-extrabold text-white">Import Data Akademik</h1>
        <p class="mt-1 font-inter text-xs text-white">Import data Mahasiswa dan Dosen untuk memulai AGS</p>
    </div>

    <div class="flex-1 px-6 pt-6">
        <div class="mb-6 rounded-2xl bg-white p-5 shadow-[0px_4px_16px_0px_#0F172A14]">
            <div class="flex items-center gap-3">
                <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#2653EB]/15">
                    <svg class="h-5 w-5 text-[#2653EB]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                        <circle cx="12" cy="7" r="4" />
                    </svg>
                </span>
                <p class="font-jakarta text-base font-extrabold text-black" x-text="activeTab === 'mahasiswa' ? 'Data Mahasiswa' : 'Data Dosen'"></p>
            </div>
            <p class="mt-2 font-inter text-xs text-slate-500" x-text="activeTab === 'mahasiswa' ? 'Informasi Akademik seluruh Mahasiswa aktif' : 'Informasi Akademik seluruh Dosen aktif'"></p>

            <input type="file" x-ref="fileInput" accept=".xlsx,.csv" class="hidden" @change="pilihFile($event)" />

            <button
                type="button"
                x-show="!current.fileName"
                @click="$refs.fileInput.click()"
                class="mt-4 flex w-full flex-col items-center justify-center gap-3 rounded-xl border-2 border-dashed border-slate-200 bg-[#F8FAFC] py-8"
            >
                <span class="flex h-10 w-10 items-center justify-center rounded-lg bg-[#E0E7FF]">
                    <svg class="h-5 w-5 text-[#2653EB]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M12 15V3m0 12-4-4m4 4 4-4" />
                        <path d="M3 17v2a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-2" />
                    </svg>
                </span>
                <span class="font-inter text-sm text-black">Ketuk untuk memilih file</span>
                <span class="font-inter text-xs text-slate-400">.xlsx/.csv</span>
            </button>

            <div x-show="current.fileName" class="relative mt-4 flex flex-col items-center justify-center gap-3 rounded-xl border-2 border-dashed border-slate-200 bg-[#F8FAFC] py-8">
                <button
                    type="button"
                    @click="hapusFile()"
                    class="absolute right-3 top-3 flex h-6 w-6 items-center justify-center rounded-full text-slate-400 hover:bg-slate-100 hover:text-slate-600"
                    aria-label="Hapus file"
                >
                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2">
                        <path d="M6 6l12 12M18 6 6 18" />
                    </svg>
                </button>
                <svg class="h-8 w-8 text-[#93A5FD]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                    <path d="M14 3H7a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V8l-5-5Z" />
                    <path d="M14 3v5h5" />
                </svg>
                <div class="w-full border-t border-slate-200"></div>
                <span class="px-4 text-center font-inter text-xs text-slate-500" x-text="current.fileName"></span>
            </div>

            <button
                type="button"
                @click="importData()"
                :disabled="!current.fileName || current.imported"
                :class="current.imported ? 'bg-[#93A5FD] cursor-not-allowed' : (current.fileName ? 'bg-[#2653EB] hover:bg-[#1D4ED8]' : 'bg-[#93A5FD] cursor-not-allowed')"
                class="mt-4 flex w-full items-center justify-center rounded-lg py-3 font-inter text-sm font-semibold text-white transition-colors"
            >
                <span x-show="!current.fileName" x-cloak>Import Data</span>
                <span x-show="current.fileName && !current.imported" x-cloak>Impor Data</span>
                <span x-show="current.imported" x-cloak>Data telah diimpor!</span>
            </button>
        </div>

        <div class="mb-8 grid grid-cols-2 gap-3">
            <button
                type="button"
                @click="activeTab = 'mahasiswa'"
                :class="status.mahasiswa.imported
                    ? 'bg-[#2653EB] border-[#2653EB] text-white'
                    : (activeTab === 'mahasiswa' ? 'bg-white border-[#2653EB] text-[#2653EB]' : 'bg-white border-[#2653EB] text-[#2653EB]')"
                class="flex items-center justify-center gap-2 rounded-full border py-2.5 font-inter text-sm font-semibold"
            >
                <span
                    :class="status.mahasiswa.imported ? 'border-white' : 'border-[#2653EB]'"
                    class="flex h-4 w-4 shrink-0 items-center justify-center rounded-full border-2"
                >
                    <svg x-show="status.mahasiswa.imported" x-cloak class="h-3 w-3 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                        <path d="M5 13l4 4L19 7" />
                    </svg>
                    <span x-show="!status.mahasiswa.imported && activeTab === 'mahasiswa'" x-cloak class="h-2 w-2 rounded-full bg-[#2653EB]"></span>
                </span>
                Data Mahasiswa
            </button>
            <button
                type="button"
                @click="activeTab = 'dosen'"
                :class="status.dosen.imported
                    ? 'bg-[#2653EB] border-[#2653EB] text-white'
                    : 'bg-white border-[#2653EB] text-[#2653EB]'"
                class="flex items-center justify-center gap-2 rounded-full border py-2.5 font-inter text-sm font-semibold"
            >
                <span
                    :class="status.dosen.imported ? 'border-white' : 'border-[#2653EB]'"
                    class="flex h-4 w-4 shrink-0 items-center justify-center rounded-full border-2"
                >
                    <svg x-show="status.dosen.imported" x-cloak class="h-3 w-3 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                        <path d="M5 13l4 4L19 7" />
                    </svg>
                    <span x-show="!status.dosen.imported && activeTab === 'dosen'" x-cloak class="h-2 w-2 rounded-full bg-[#2653EB]"></span>
                </span>
                Data Dosen
            </button>
        </div>

        <div class="mt-auto">
            <a href=""
                class="flex w-full items-center justify-center rounded-lg bg-[#2653EB] py-3.5 font-inter text-sm font-semibold text-white hover:bg-[#1D4ED8]">
                Aktivasi dengan Data
            </a>
            <p class="mt-4 text-center font-inter text-xs text-slate-500">
                Lewati import data?
                <a href="{{ route('operator.beranda.index') }}" class="font-semibold text-[#2653EB] hover:underline">Lewati</a>
            </p>
        </div>
    </div>
</div>
@endsection