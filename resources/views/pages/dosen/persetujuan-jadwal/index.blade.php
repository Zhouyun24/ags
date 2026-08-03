@extends('layouts.index')

@section('layouts')
<div class="flex flex-col min-h-screen bg-slate-50 pb-10">
    {{-- Header Section --}}
    <div class="overflow-hidden bg-[#10b981] px-6 pb-12 pt-10 text-white">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="font-['Plus_Jakarta_Sans'] text-2xl font-extrabold">
                    Persetujuan Jadwal
                </h1>
                <p class="mt-1 text-sm text-emerald-50">
                    X Jadwal Menunggu
                </p>
            </div>
        </div>
    </div>

    {{-- Content --}}
    <div class="px-6 mt-6">
        <div class="space-y-4 max-w-md mx-auto">
            {{-- Schedule Card --}}
            <div class="rounded-2xl bg-white p-5 shadow-sm border border-slate-100">
                <div class="flex items-start justify-between mb-4">
                    <div class="flex items-center gap-3">
                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-blue-100 text-blue-600">
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                <circle cx="12" cy="7" r="4"></circle>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-bold text-slate-900 text-base">Nama Mhs</h3>
                            <p class="text-sm text-slate-500">Topik diskusi • 10124257</p>
                        </div>
                    </div>
                    <span class="inline-flex items-center gap-1 rounded-full bg-orange-50 px-2.5 py-1 text-xs font-medium text-orange-600 border border-orange-100">
                        <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"></circle>
                            <polyline points="12 6 12 12 16 14"></polyline>
                        </svg>
                        Menunggu
                    </span>
                </div>

                {{-- Date/Time Box --}}
                <div class="mb-5 flex flex-wrap items-center gap-6 rounded-xl bg-indigo-50/50 p-3 text-sm text-slate-700 border border-indigo-100/50">
                    <div class="flex items-center gap-2">
                        <svg class="h-4 w-4 text-slate-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                            <line x1="16" y1="2" x2="16" y2="6"></line>
                            <line x1="8" y1="2" x2="8" y2="6"></line>
                            <line x1="3" y1="10" x2="21" y2="10"></line>
                        </svg>
                        <span class="font-medium">DD/MM/YYYY</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <svg class="h-4 w-4 text-slate-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"></circle>
                            <polyline points="12 6 12 12 16 14"></polyline>
                        </svg>
                        <span class="font-medium">HH/MM WIB</span>
                    </div>
                </div>

                {{-- Action Buttons --}}
                <div class="grid grid-cols-2 gap-3">
                    <button class="rounded-xl border border-red-300 bg-white py-2.5 text-sm font-semibold text-red-500 transition hover:bg-red-50">
                        Tolak
                    </button>
                    <button class="rounded-xl bg-[#10b981] py-2.5 text-sm font-semibold text-white transition hover:bg-emerald-600">
                        Setujui
                    </button>
                </div>
            </div>
            
            
        </div>
    </div>
</div>
@endsection
