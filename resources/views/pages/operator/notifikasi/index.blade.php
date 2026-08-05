@extends('layouts.index')

@section('layouts')
@php
    $notifikasi ??= collect([
        (object) [
            'id' => 1,
            'tipe' => 'disetujui',
            'pesan' => 'Jadwal Bimbingan 28 Juni 2026 - 09:00 telah disetujui',
            'waktu' => '2 jam lalu',
            'dibaca' => false,
        ],
        (object) [
            'id' => 2,
            'tipe' => 'info',
            'pesan' => 'Notif buat selain setuju/tolak',
            'waktu' => '2 hari lalu',
            'dibaca' => true,
        ],
        (object) [
            'id' => 3,
            'tipe' => 'ditolak',
            'pesan' => 'Jadwal Bimbingan 27 Juni 2026 - 09:00 telah ditolak',
            'waktu' => '3 hari lalu',
            'dibaca' => true,
        ],
    ]);
@endphp

<div x-data="{
        notifikasi: {{ $notifikasi->map(fn($n) => [
            'id' => $n->id,
            'tipe' => $n->tipe,
            'pesan' => $n->pesan,
            'waktu' => $n->waktu,
            'dibaca' => $n->dibaca,
        ])->values()->toJson() }},
        get belumDibaca() {
            return this.notifikasi.filter(n => !n.dibaca).length;
        },
        tandaiSemuaDibaca() {
            this.notifikasi.forEach(n => n.dibaca = true);
            // TODO: panggil endpoint backend untuk sinkronisasi, misal:
            // fetch('#'}}', { method: 'POST', headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' } });
        },
        tandaiDibaca(id) {
            const item = this.notifikasi.find(n => n.id === id);
            if (item) item.dibaca = true;
        },
    }" class="pb-8">
    <div class="flex items-center justify-between px-5 pt-5">
        <p class="font-inter text-sm text-black/75" x-text="belumDibaca + ' belum dibaca'">
            0 belum dibaca
        </p>
        <button type="button" @click="tandaiSemuaDibaca()"
            class="font-inter text-sm font-semibold text-[#2563EB] hover:text-blue-700">
            Tandai semua dibaca
        </button>
    </div>
    <div class="mt-4 space-y-3 px-5">
        <template x-for="item in notifikasi" :key="item.id">
            <button type="button" @click="tandaiDibaca(item.id)"
                :class="item.dibaca ? 'bg-slate-100' : 'bg-white shadow-[0px_4px_16px_0px_#0F172A14]'"
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
            </button>
        </template>
        <div x-show="notifikasi.length === 0" class="rounded-xl bg-white py-10 text-center shadow-[0px_4px_16px_0px_#0F172A14]">
            <p class="font-inter text-sm text-slate-400">Belum ada notifikasi</p>
        </div>
    </div>
</div>
@endsection