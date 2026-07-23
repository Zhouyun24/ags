@extends('layouts.index')

@section('layouts')
<div class="flex flex-col min-h-screen bg-slate-50 pb-10">
    {{-- Header Dosen --}}
    <div class="relative overflow-hidden rounded-b-[32px] bg-gradient-to-br from-[#1D4ED8] to-[#2563EB] px-6 pb-12 pt-10 text-white">
        <div class="flex items-center justify-between">
            <div>
                <span class="inline-block rounded-full bg-white/20 px-3 py-1 text-xs font-semibold text-blue-100">
                    Dosen Pembimbing Akademik
                </span>
                <h1 class="mt-2 font-['Plus_Jakarta_Sans'] text-2xl font-extrabold">
                    Selamat Datang, {{ Auth::user()->nama ?? 'Dosen PA' }}
                </h1>
                <p class="mt-1 text-xs text-blue-100">
                    Sistem Bimbingan Akademik (AGS)
                </p>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" 
                    class="flex items-center gap-2 rounded-xl bg-red-500/80 px-4 py-2.5 text-xs font-semibold text-white shadow-md transition hover:bg-red-600 active:bg-red-700">
                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                        <path d="M16 17l5-5-5-5M21 12H9" />
                    </svg>
                    Keluar
                </button>
            </form>
        </div>
    </div>

    {{-- Content --}}
    <div class="px-6 -mt-6">
        <div class="rounded-2xl bg-white p-6 shadow-sm border border-slate-100">
            <h2 class="font-bold text-slate-800 text-base mb-4">Menu Utama Dosen</h2>
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                <a href="{{ route('dosen.persetujuan-jadwal.index') }}" 
                    class="flex items-center gap-4 rounded-xl border border-slate-100 p-4 transition hover:bg-blue-50/50 hover:border-blue-200">
                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-blue-100 text-blue-600">
                        <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="3" y="4" width="18" height="17" rx="2" />
                            <path d="M3 9h18M8 2v4M16 2v4" />
                        </svg>
                    </div>
                    <div>
                        <p class="font-semibold text-slate-800 text-sm">Persetujuan Jadwal</p>
                        <p class="text-xs text-slate-500">Setujui pengajuan bimbingan mahasiswa</p>
                    </div>
                </a>

                <a href="{{ route('dosen.evaluasi-mahasiswa.index') }}" 
                    class="flex items-center gap-4 rounded-xl border border-slate-100 p-4 transition hover:bg-blue-50/50 hover:border-blue-200">
                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-green-100 text-green-600">
                        <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" />
                            <path d="M22 4 12 14.01l-3-3" />
                        </svg>
                    </div>
                    <div>
                        <p class="font-semibold text-slate-800 text-sm">Evaluasi Mahasiswa</p>
                        <p class="text-xs text-slate-500">Lihat & catat evaluasi mahasiswa</p>
                    </div>
                </a>
            </div>

            {{-- Tombol Keluar Utama Dosen --}}
            <div class="mt-8 pt-6 border-t border-slate-100">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" 
                        class="w-full flex items-center justify-center gap-2 rounded-xl border border-red-200 bg-red-50 py-3.5 text-sm font-semibold text-red-600 transition hover:bg-red-100">
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                            <path d="M16 17l5-5-5-5M21 12H9" />
                        </svg>
                        Keluar dari Akun Dosen
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
