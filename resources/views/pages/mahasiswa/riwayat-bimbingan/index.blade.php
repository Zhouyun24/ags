@extends('layouts.index')

@section('layouts')
@php
    $riwayat ??= collect([
        (object) [
            'topik' => 'Topik Diskusi',
            'tanggal' => 'DD MM YYYY',
            'status' => 'Disetujui',
            'catatan' => 'Perbaiki latar belakang dan rumusan masalah agar lebih spesifik.',
            'rekomendasi' => 'Baca jurnal referensi dan perbaiki dalam satu minggu.',
        ],
        (object) [
            'topik' => 'Topik Diskusi',
            'tanggal' => 'DD MM YYYY',
            'status' => 'Disetujui',
            'catatan' => 'Catatan Bimbingan/Arahan Akademik.',
            'rekomendasi' => 'Rekomendasi Dosen Pembimbing.',
        ],
        (object) [
            'topik' => 'Topik Diskusi',
            'tanggal' => 'DD MM YYYY',
            'status' => 'Disetujui',
            'catatan' => 'Catatan Bimbingan/Arahan Akademik.',
            'rekomendasi' => 'Rekomendasi Dosen Pembimbing.',
        ],
    ]);
@endphp

<div x-data="{ openIndex: 0 }" class="pb-8">
    <div class="relative overflow-hidden bg-gradient-to-tl from-[#2563ED] via-[#2251E3] to-[#1D4ED8] px-5 min-h-[106px] flex flex-col justify-center">
        <h1 class="font-jakarta text-xl font-extrabold text-white">Riwayat Bimbingan</h1>
        <p class="mt-1 font-inter text-xs text-white">{{ $riwayat->count() }} Sesi Tercatat</p>
    </div>
    <div class="px-5 pt-6">
        <div class="relative">
            <div class="absolute bottom-4 left-[19px] top-4 w-[2px] bg-blue-100"></div>
            <div class="space-y-5">
                @foreach ($riwayat as $index => $item)
                    <div class="relative flex gap-4">
                        <span class="relative z-10 flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-[#2653EB] shadow-[0px_0px_0px_4px_#F0F5FF]">
                            <svg class="h-4 w-4 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                <path d="M4 5.5A2.5 2.5 0 0 1 6.5 3H12v18H6.5A2.5 2.5 0 0 1 4 18.5v-13Z" />
                                <path d="M20 5.5A2.5 2.5 0 0 0 17.5 3H12v18h5.5a2.5 2.5 0 0 0 2.5-2.5v-13Z" />
                            </svg>
                        </span>
                        <div class="mb-1 flex-1 overflow-hidden rounded-xl bg-white shadow-[0px_4px_16px_0px_#0F172A14]">
                            <button type="button" @click="openIndex = (openIndex === {{ $index }} ? null : {{ $index }})"
                                class="flex w-full items-start justify-between gap-3 p-4 text-left">
                                <div>
                                    <p class="font-jakarta text-[16px] font-extrabold text-black">{{ $item->topik }}</p>
                                    <p class="mt-0.5 font-inter text-[10px] text-black">{{ $item->tanggal }}</p>
                                    <span class="mt-2 inline-flex items-center gap-1 rounded-xl bg-[#DCFCE7] px-2.5 py-1 font-inter text-[10px] font-medium text-[#16A34A]">
                                        <svg class="h-3 w-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                                            <path d="M5 13l4 4L19 7" />
                                        </svg>
                                        {{ $item->status }}
                                    </span>
                                </div>
                                <svg class="mt-1 h-4 w-4 shrink-0 text-slate-400 transition-transform duration-200"
                                    :class="openIndex === {{ $index }} ? 'rotate-180' : ''"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                    <path d="M6 9l6 6 6-6" />
                                </svg>
                            </button>
                            <div x-show="openIndex === {{ $index }}" x-collapse
                                class="border-t border-slate-100 px-4 pb-4 pt-3">
                                <div class="mb-3 rounded-lg bg-[#EFF3FF] p-3">
                                    <p class="font-inter text-xs font-semibold text-[#2653EB]">Catatan Bimbingan</p>
                                    <p class="mt-1 font-inter text-xs text-black">{{ $item->catatan }}</p>
                                </div>
                                <div class="rounded-lg bg-[#DCFCE7]/50 p-3">
                                    <p class="font-inter text-xs font-semibold text-[#16A34A]">Rekomendasi Dosen</p>
                                    <p class="mt-1 font-inter text-xs text-black">{{ $item->rekomendasi }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection