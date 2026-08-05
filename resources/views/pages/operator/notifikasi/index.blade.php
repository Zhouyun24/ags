@extends('layouts.index')

@section('layouts')
<div x-data="{
        notifikasi: {{ collect($notifications)->map(fn($n) => [
            'id' => $n->id,
            'tipe' => $n->tipe,
            'pesan' => $n->pesan,
            'waktu' => $n->waktu,
            'dibaca' => $n->dibaca,
        ])->values()->toJson() }},
        get belumDibaca() {
            return this.notifikasi.filter(n => !n.dibaca).length;
        }
    }" class="pb-8">
    <div class="flex items-center justify-between px-5 pt-5">
        <div class="flex items-center gap-3">
            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-blue-100 text-blue-600">
                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9" />
                    <path d="M13.73 21a2 2 0 0 1-3.46 0" />
                </svg>
            </div>
            <div>
                <h1 class="font-jakarta text-2xl font-extrabold text-slate-900">Notifikasi</h1>
                <p class="mt-1 font-inter text-sm text-slate-500">Pemberitahuan aktivitas terbaru</p>
            </div>
        </div>
        <p class="font-inter text-sm text-black/75" x-text="belumDibaca + ' belum dibaca'">
            0 belum dibaca
        </p>
    </div>
    <div class="mt-4 space-y-3 px-5">
        <template x-for="item in notifikasi" :key="item.id">
            <div :class="item.dibaca ? 'bg-slate-100' : 'bg-white shadow-[0px_4px_16px_0px_#0F172A14]'"
                class="flex w-full items-start gap-3 rounded-xl p-4 text-left transition-colors">
                <span x-show="item.tipe === 'disetujui'"
                    class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#16A34A]/15">
                    <svg class="h-5 w-5 text-[#16A34A]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M5 13l4 4L19 7" />
                    </svg>
                </span>
                <span x-show="item.tipe === 'ditolak'"
                    class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#DC2626]/15">
                    <svg class="h-5 w-5 text-[#DC2626]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M6 6l12 12M18 6L6 18" />
                    </svg>
                </span>
                <span x-show="item.tipe === 'info'"
                    class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#2653EB]/15">
                    <svg class="h-5 w-5 text-[#2653EB]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="9" />
                        <path d="M12 8h.01M11 12h1v4h1" />
                    </svg>
                </span>
                <div class="min-w-0 flex-1">
                    <p class="font-inter text-[13px] leading-snug"
                        :class="item.dibaca ? 'text-slate-400' : 'text-black'"
                        x-text="item.pesan"></p>
                    <p class="mt-1 font-inter text-[11px]"
                        :class="item.dibaca ? 'text-slate-300' : 'text-slate-400'"
                        x-text="item.waktu"></p>
                </div>
                <span x-show="!item.dibaca" class="mt-1.5 h-2 w-2 shrink-0 rounded-full bg-[#2653EB]"></span>
            </div>
        </template>
        <div x-show="notifikasi.length === 0" class="rounded-xl bg-white py-10 text-center shadow-[0px_4px_16px_0px_#0F172A14]">
            <p class="font-inter text-sm text-slate-400">Belum ada notifikasi</p>
        </div>
    </div>
</div>
@endsection
