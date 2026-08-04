@extends('layouts.index')

@section('layouts')
<div class="flex flex-col min-h-screen bg-slate-50 pb-10">
    <div class="bg-[#10b981] px-6 pb-6 pt-10 text-white">
        <h1 class="font-['Plus_Jakarta_Sans'] text-2xl font-bold">
            Hasil Bimbingan
        </h1>
        <p class="mt-1 text-sm text-emerald-50">
            Kelola catatan dan rekomendasi bimbingan
        </p>
    </div>

    <div class="px-6 mt-6 w-full max-w-md mx-auto">
        <form class="space-y-6">
            <div class="rounded-xl border border-[#60a5fa] bg-[#e0e7ff] p-4 shadow-sm">
                <div class="flex items-center gap-4">
                    <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-xl bg-[#2563eb] text-white">
                        <svg class="h-7 w-7" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"></path>
                            <circle cx="12" cy="7" r="4"></circle>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-bold text-slate-900 text-[15px]">Nama Mahasiswa</h3>
                        <div class="text-[13px] text-slate-500 mt-0.5 leading-tight">
                            <p>NIM: 10124257 &bull; Sesi ke-n</p>
                            <p>DD/MM/YYYY &bull; HH/MM WIB</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="space-y-2">
                <label class="block text-[15px] font-bold text-slate-900">Topik Diskusi</label>
                <div class="relative">
                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4">
                        <svg class="h-5 w-5 text-slate-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"></path>
                            <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"></path>
                        </svg>
                    </div>
                    <input type="text" class="block w-full rounded-2xl border border-slate-200 bg-white py-3.5 pl-11 pr-4 text-sm text-slate-500 placeholder:text-slate-400 focus:border-[#10b981] focus:outline-none focus:ring-1 focus:ring-[#10b981]" placeholder="Topik Diskusi (dimuat langsung tapi bisa diedit)">
                </div>
            </div>

            <div class="space-y-2">
                <label class="block text-[15px] font-bold text-slate-900">Catatan Bimbingan</label>
                <textarea rows="5" class="block w-full rounded-2xl border border-slate-200 bg-white p-4 text-sm text-slate-700 placeholder:text-slate-400 focus:border-[#10b981] focus:outline-none focus:ring-1 focus:ring-[#10b981] resize-none" placeholder="Tuliskan catatan lengkap..."></textarea>
            </div>

            <div class="space-y-2">
                <label class="block text-[15px] font-bold text-slate-900">Rekomendasi</label>
                <textarea rows="5" class="block w-full rounded-2xl border border-slate-200 bg-white p-4 text-sm text-slate-700 placeholder:text-slate-400 focus:border-[#10b981] focus:outline-none focus:ring-1 focus:ring-[#10b981] resize-none" placeholder="Tuliskan rekomendasi untuk mahasiswa..."></textarea>
            </div>

            <div class="grid grid-cols-2 gap-4 pt-2">
                <a href="{{ route('dosen.hasil-bimbingan.index') }}" class="rounded-xl border border-[#2563eb] bg-white flex justify-center items-center text-[15px] font-bold text-[#2563eb] transition hover:bg-blue-50">
                    Batal
                </a>
                <button type="submit" class="rounded-xl bg-[#10b981] py-3.5 text-[15px] font-bold text-white transition hover:bg-emerald-600">
                    Isi Hasil
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
