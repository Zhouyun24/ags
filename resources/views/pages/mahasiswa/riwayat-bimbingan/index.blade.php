@extends('layouts.index')

@section('layouts')
@php
    $riwayat ??= collect([
        (object) [
            'topik' => 'Topik Diskusi',
            'tanggal' => 'DD MM YYYY',
            'status' => 'disetujui',
            'catatan' => 'Perbaiki latar belakang dan rumusan masalah agar lebih spesifik.',
            'rekomendasi' => 'Baca jurnal referensi dan perbaiki dalam satu minggu.',
        ],
        (object) [
            'topik' => 'Topik Diskusi',
            'tanggal' => 'DD MM YYYY',
            'status' => 'ditolak',
            'catatan' => 'Catatan Bimbingan/Arahan Akademik.',
            'rekomendasi' => 'Rekomendasi Dosen Pembimbing.',
        ],
        (object) [
            'topik' => 'Topik Diskusi',
            'tanggal' => 'DD MM YYYY',
            'status' => 'menunggu',
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
            @if ($riwayat->count() > 0)
                <div class="absolute bottom-4 left-[19px] top-4 w-[2px] bg-blue-100"></div>
            @endif
            <div class="space-y-5">
                @forelse ($riwayat as $index => $item)
                    @php
                        $statusConfig = [
                            'disetujui' => [
                                'label' => 'Disetujui',
                                'icon_bg' => 'bg-[#16A34A]/15',
                                'icon_color' => 'text-[#16A34A]',
                                'badge_bg' => 'bg-[#DCFCE7]',
                                'badge_text' => 'text-[#16A34A]',
                            ],
                            'ditolak' => [
                                'label' => 'Ditolak',
                                'icon_bg' => 'bg-[#DC2626]/15',
                                'icon_color' => 'text-[#DC2626]',
                                'badge_bg' => 'bg-[#FEE2E2]',
                                'badge_text' => 'text-[#DC2626]',
                            ],
                            'menunggu' => [
                                'label' => 'Menunggu',
                                'icon_bg' => 'bg-[#F59E0B]/15',
                                'icon_color' => 'text-[#F59E0B]',
                                'badge_bg' => 'bg-[#FEF3C7]',
                                'badge_text' => 'text-[#F59E0B]',
                            ],
                        ][$item->status] ?? [
                            'label' => 'Menunggu',
                            'icon_bg' => 'bg-[#F59E0B]/15',
                            'icon_color' => 'text-[#F59E0B]',
                            'badge_bg' => 'bg-[#FEF3C7]',
                            'badge_text' => 'text-[#F59E0B]',
                        ];
                    @endphp
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
                                    <span class="mt-2 inline-flex items-center gap-1 rounded-xl {{ $statusConfig['badge_bg'] }} px-2.5 py-1 font-inter text-[10px] font-medium {{ $statusConfig['badge_text'] }}">
                                        @if ($item->status === 'disetujui')
                                            <svg class="h-3 w-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                                                <path d="M5 13l4 4L19 7" />
                                            </svg>
                                        @elseif ($item->status === 'ditolak')
                                            <svg class="h-3 w-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                                                <path d="M6 6l12 12M18 6L6 18" />
                                            </svg>
                                        @else
                                            <svg class="h-3 w-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                                <circle cx="12" cy="12" r="9" />
                                                <path d="M12 7v5l3 3" />
                                            </svg>
                                        @endif
                                        {{ $statusConfig['label'] }}
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
                @empty
                    <div class="rounded-xl bg-white py-10 text-center shadow-[0px_4px_16px_0px_#0F172A14]">
                        <p class="font-inter text-sm text-slate-400">Belum ada riwayat bimbingan.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection