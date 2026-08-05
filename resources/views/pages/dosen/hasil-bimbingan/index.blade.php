@extends('layouts.index')

@section('layouts')
<div class="pb-5"
    x-data='{
        filter: "semua",
        cari: "",
        daftar: @json($daftarBimbingan),
        get filtered() {
            return this.daftar.filter((item) => {
                const cocokFilter = this.filter === "semua" || item.status === this.filter;
                const kataKunci = this.cari.trim().toLowerCase();
                const cocokCari =
                    kataKunci === "" ||
                    item.nama.toLowerCase().includes(kataKunci) ||
                    item.nim.toLowerCase().includes(kataKunci);
                return cocokFilter && cocokCari;
            });
        },
        jumlah(status) {
            return status === "semua"
                ? this.daftar.length
                : this.daftar.filter((item) => item.status === status).length;
        },
    }'
>
    {{-- ================= HEADER ================= --}}
    <div class="relative overflow-hidden bg-gradient-to-br from-[#22C55E] via-[#16A34A] to-[#15803D] px-5 pb-6 pt-5">
        <h1 class="font-jakarta text-xl font-extrabold text-white">Hasil Bimbingan</h1>
        <p class="mt-1 font-inter text-xs text-white">Kelola catatan dan rekomendasi bimbingan</p>
    </div>

    <div class="px-5 pt-6">
        {{-- ================= FILTER TAB ================= --}}
        <div class="mb-4 flex items-center gap-2">
            <button
                type="button"
                @click="filter = 'semua'"
                :class="filter === 'semua' ? 'bg-[#2653EB] text-white' : 'border border-slate-200 bg-white text-black'"
                class="rounded-full px-4 py-2 font-inter text-xs font-semibold transition-colors"
            >
                Semua (<span x-text="jumlah('semua')"></span>)
            </button>
            <button
                type="button"
                @click="filter = 'menunggu'"
                :class="filter === 'menunggu' ? 'bg-[#2653EB] text-white' : 'border border-slate-200 bg-white text-black'"
                class="rounded-full px-4 py-2 font-inter text-xs font-semibold transition-colors"
            >
                Menunggu (<span x-text="jumlah('menunggu')"></span>)
            </button>
            <button
                type="button"
                @click="filter = 'selesai'"
                :class="filter === 'selesai' ? 'bg-[#2653EB] text-white' : 'border border-slate-200 bg-white text-black'"
                class="rounded-full px-4 py-2 font-inter text-xs font-semibold transition-colors"
            >
                Selesai (<span x-text="jumlah('selesai')"></span>)
            </button>
        </div>

        {{-- ================= SEARCH BAR ================= --}}
        <div class="mb-6 flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-3 shadow-[0px_4px_16px_0px_#0F172A14]">
            <input
                type="text"
                x-model="cari"
                placeholder="Cari NIM atau Nama Mahasiswa"
                class="w-full border-none font-inter text-xs text-black placeholder:text-slate-400 focus:outline-none focus:ring-0"
            />
            <svg class="h-4 w-4 shrink-0 text-slate-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="11" cy="11" r="7" />
                <path d="m21 21-4.3-4.3" />
            </svg>
        </div>

        {{-- ================= DAFTAR BIMBINGAN ================= --}}
        <div class="flex flex-col gap-4">
            <template x-for="bimbingan in filtered" :key="bimbingan.id">
                <div class="rounded-2xl bg-white p-4 shadow-[0px_4px_16px_0px_#0F172A14]">
                    {{-- Header kartu --}}
                    <div class="flex items-start justify-between">
                        <div class="flex items-start gap-3">
                            <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-[#2653EB]/15">
                                <svg class="h-6 w-6 text-[#2653EB]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                                    <circle cx="12" cy="7" r="4" />
                                </svg>
                            </span>
                            <div>
                                <p class="font-jakarta text-base font-extrabold text-black" x-text="bimbingan.nama"></p>
                                <p class="font-inter text-xs text-slate-500">
                                    <span x-text="bimbingan.topik"></span> &bull; <span x-text="bimbingan.nim"></span>
                                </p>
                            </div>
                        </div>
                        <span
                            :class="bimbingan.status === 'selesai' ? 'bg-[#DCFCE7] text-[#16A34A]' : 'bg-[#FEF3C7] text-[#F59E0B]'"
                            class="inline-flex shrink-0 items-center gap-1 whitespace-nowrap rounded-xl px-2.5 py-1 font-inter text-[10px]"
                        >
                            <svg x-show="bimbingan.status === 'selesai'" class="h-3 w-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                                <path d="M5 13l4 4L19 7" />
                            </svg>
                            <svg x-show="bimbingan.status !== 'selesai'" class="h-3 w-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                <circle cx="12" cy="12" r="9" />
                                <path d="M12 7v5l3 3" />
                            </svg>
                            <span x-text="bimbingan.status === 'selesai' ? 'Selesai' : 'Menunggu'"></span>
                        </span>
                    </div>

                    {{-- Tanggal & jam --}}
                    <div class="mt-4 flex items-center gap-4 rounded-lg bg-[#E0E7FF]/60 px-3 py-2.5">
                        <span class="flex items-center gap-1.5 font-inter text-xs text-slate-700">
                            <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                <rect x="3" y="4" width="18" height="17" rx="2" />
                                <path d="M3 9h18M8 2v4M16 2v4" />
                            </svg>
                            <span x-text="bimbingan.tanggal"></span>
                        </span>
                        <span class="flex items-center gap-1.5 font-inter text-xs text-slate-700">
                            <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                <circle cx="12" cy="12" r="9" />
                                <path d="M12 7v5l3 3" />
                            </svg>
                            <span x-text="bimbingan.jam"></span>
                        </span>
                    </div>

                    {{-- Catatan Bimbingan --}}
                    <div class="mt-3 rounded-lg bg-[#DBEAFE]/70 p-3">
                        <p class="font-inter text-xs font-semibold text-[#2563EB]">Catatan Bimbingan</p>
                        <p class="mt-1 font-inter text-xs text-slate-700" x-text="bimbingan.catatan"></p>
                    </div>

                    {{-- Rekomendasi Dosen --}}
                    <div class="mt-3 rounded-lg bg-[#DCFCE7]/70 p-3">
                        <p class="font-inter text-xs font-semibold text-[#16A34A]">Rekomendasi Dosen</p>
                        <p class="mt-1 font-inter text-xs text-slate-700" x-text="bimbingan.rekomendasi"></p>
                    </div>

                    {{-- Tombol Aksi --}}
                    <div class="mt-4 flex justify-end">
                        <a
                            :href="bimbingan.urlAksi"
                            :class="bimbingan.status === 'menunggu' ? 'border-[#F59E0B] text-[#F59E0B] hover:bg-[#F59E0B]/10' : 'border-[#16A34A] text-[#16A34A] hover:bg-[#16A34A]/10'"
                            class="rounded-lg border px-8 py-2.5 font-inter text-sm font-semibold"
                            x-text="bimbingan.status === 'menunggu' ? 'Isi Hasil' : 'Edit'"
                        ></a>
                    </div>
                </div>
            </template>

            <div x-show="filtered.length === 0" class="rounded-xl bg-white py-10 text-center shadow-[0px_4px_16px_0px_#0F172A14]">
                <p class="font-inter text-sm text-slate-400">Belum ada data bimbingan.</p>
            </div>
        </div>
    </div>
</div>
@endsection