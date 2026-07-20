@extends('layouts.index')

@section('layouts')
    <div class="flex flex-col" x-data="{
        activeTab: 'mahasiswa',
        fileName: null,
        onFileChange(event) {
            const file = event.target.files[0];
            this.fileName = file ? file.name : null;
        }
    }">
        <div
            class="relative overflow-hidden rounded-b-[32px] bg-gradient-to-br from-[#1D4ED8] to-[#2563EB] px-6 pb-8 pt-10">
            <div class="mb-5 flex h-14 w-14 items-center justify-center rounded-2xl bg-white/15">
                <svg class="h-7 w-7 text-white/35" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 3 1 8.5l11 5.5 9-4.5V17h2V8.5L12 3Z" />
                    <path d="M5 10.9V15c0 1.7 3.1 4 7 4s7-2.3 7-4v-4.1l-7 3.5-7-3.5Z" />
                </svg>
            </div>
            <h1 class="font-['Plus_Jakarta_Sans'] text-3xl font-extrabold text-white">
                Import Data Akademik
            </h1>
            <p class="mt-1 text-sm text-blue-100">
                Import data Mahasiswa dan Dosen untuk memulai AGS
            </p>
        </div>
        <form method="POST" action="" enctype="multipart/form-data"
            class="flex-1 px-6 pt-6">
            @csrf
            <input type="hidden" name="tipe_data" :value="activeTab">
            <div class="rounded-2xl border border-slate-100 bg-white p-5 shadow-[0px_8px_32px_0px_#00000014]">
                <div x-show="activeTab === 'mahasiswa'" x-cloak>
                    <div class="flex items-center gap-3">
                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-blue-50">
                            <svg class="h-5 w-5 text-blue-600" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="1.8">
                                <circle cx="12" cy="8" r="4" />
                                <path d="M4 20c0-4 3.6-7 8-7s8 3 8 7" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-bold text-slate-800">Data Mahasiswa</p>
                            <p class="text-xs text-slate-500">Informasi Akademik seluruh Mahasiswa aktif</p>
                        </div>
                    </div>
                </div>
                <div x-show="activeTab === 'dosen'" x-cloak>
                    <div class="flex items-center gap-3">
                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-blue-50">
                            <svg class="h-5 w-5 text-blue-600" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="1.8">
                                <rect x="3" y="4" width="18" height="14" rx="2" />
                                <path d="M8 21h8M12 18v3" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-bold text-slate-800">Data Dosen</p>
                            <p class="text-xs text-slate-500">Informasi Akademik seluruh Dosen aktif</p>
                        </div>
                    </div>
                </div>
                <label for="file_import"
                    class="mt-5 flex cursor-pointer flex-col items-center justify-center rounded-xl border-2 border-dashed border-slate-200 bg-slate-50 px-4 py-8 text-center transition hover:border-blue-300 hover:bg-blue-50/40">
                    <span class="mb-3 flex h-10 w-10 items-center justify-center rounded-xl bg-blue-100">
                        <svg class="h-5 w-5 text-blue-600" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="1.8">
                            <path d="M12 16V4M12 4 7 9M12 4l5 5" />
                            <path d="M4 16v3a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-3" />
                        </svg>
                    </span>
                    <template x-if="!fileName">
                        <div>
                            <p class="text-sm font-medium text-slate-700">Ketuk untuk memilih file</p>
                            <p class="mt-1 text-xs text-slate-400">.xlsx/.csv</p>
                        </div>
                    </template>
                    <template x-if="fileName">
                        <div>
                            <p class="max-w-[220px] truncate text-sm font-medium text-blue-700" x-text="fileName"></p>
                            <p class="mt-1 text-xs text-slate-400">Ketuk untuk mengganti file</p>
                        </div>
                    </template>
                    <input type="file" id="file_import" name="file_import" accept=".xlsx,.csv" class="hidden"
                        @change="onFileChange($event)">
                </label>
                @error('file_import')
                    <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                @enderror
                <button type="submit"
                    class="mt-5 w-full rounded-xl bg-blue-600 py-3.5 text-sm font-semibold text-white shadow-[0px_8px_32px_0px_#00000040] transition hover:bg-blue-700 active:bg-blue-800">
                    Import Data
                </button>
            </div>
            <div class="mt-4 grid grid-cols-2 gap-3">
                <button type="button" @click="activeTab = 'mahasiswa'; fileName = null"
                    class="flex items-center justify-center gap-2 rounded-xl border-2 py-3 text-sm font-semibold transition"
                    :class="activeTab === 'mahasiswa' ? 'border-blue-600 text-blue-600' : 'border-slate-200 text-slate-400'">
                    <span class="flex h-4 w-4 items-center justify-center rounded-full border-2 transition"
                        :class="activeTab === 'mahasiswa' ? 'border-blue-600 bg-blue-600' : 'border-slate-300'">
                        <span class="h-1.5 w-1.5 rounded-full bg-white" x-show="activeTab === 'mahasiswa'"></span>
                    </span>
                    Data Mahasiswa
                </button>
                <button type="button" @click="activeTab = 'dosen'; fileName = null"
                    class="flex items-center justify-center gap-2 rounded-xl border-2 py-3 text-sm font-semibold transition"
                    :class="activeTab === 'dosen' ? 'border-blue-600 text-blue-600' : 'border-slate-200 text-slate-400'">
                    <span class="flex h-4 w-4 items-center justify-center rounded-full border-2 transition"
                        :class="activeTab === 'dosen' ? 'border-blue-600 bg-blue-600' : 'border-slate-300'">
                        <span class="h-1.5 w-1.5 rounded-full bg-white" x-show="activeTab === 'dosen'"></span>
                    </span>
                    Data Dosen
                </button>
            </div>
        </form>
        <div class="flex-1"></div>
        <div class="px-6 pb-8 pt-10">
            <button type="button" onclick="document.querySelector('form').requestSubmit()"
                class="w-full rounded-xl bg-blue-600 py-3.5 text-sm font-semibold text-white shadow-[0px_8px_32px_0px_#00000040] transition hover:bg-blue-700 active:bg-blue-800">
                Aktivasi dengan Data
            </button>
            <p class="mt-4 text-center text-sm text-slate-600">
                Lewati import data?
                <a href="{{ route('mahasiswa.beranda.index') }}" class="font-semibold text-blue-600 hover:text-blue-700">
                    Lewati
                </a>
            </p>
        </div>
    </div>
</div>
@endsection
