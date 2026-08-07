@extends('layouts.index')

@section('layouts')
@php
    $mahasiswas = collect([
        (object) [
            'id' => 1,
            'nama' => 'Nama Mhs',
            'nim' => '10125698',
            'program_studi' => 'Prodi',
            'semester' => '5',
            'dosenPa' => 'Nama Dosen, Gelar',
        ],
        (object) [
            'id' => 2,
            'nama' => 'Nama Mhs',
            'nim' => '10125690',
            'program_studi' => 'Prodi',
            'semester' => '5',
            'dosenPa' => 'Nama Dosen, Gelar',
        ],
    ]);

    $jumlahMahasiswa = $mahasiswas->count();
@endphp

<div
    class="pb-5"
>
    <div class="overflow-hidden bg-gradient-to-br from-[#22C55E] via-[#16A34A] to-[#15803D] px-5 pb-12 pt-10 text-white">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="font-['Plus_Jakarta_Sans'] text-2xl font-extrabold">
                    Daftar Mahasiswa
                </h1>
                <p class="mt-1 text-sm text-emerald-50">
                    {{ $jumlahMahasiswa }} Mahasiswa terdaftar
                </p>
            </div>
        </div>
    </div>

    <div class="px-5 pt-6">
        <form method="GET" class="mb-6">
            <div class="flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-3 shadow-[0px_4px_16px_0px_#0F172A14]">
                <input
                    type="text"
                    name="cari"
                    value="{{ request('cari') }}"
                    placeholder="Cari NIM atau Nama Mahasiswa"
                    class="w-full border-none font-inter text-xs text-black placeholder:text-slate-400 focus:outline-none focus:ring-0"
                />
                <button type="submit">
                    <svg class="h-4 w-4 text-black" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2">
                        <circle cx="11" cy="11" r="7" />
                        <path d="m21 21-4.3-4.3" />
                    </svg>
                </button>
            </div>
        </form>

        <div class="flex flex-col gap-4">
            @forelse ($mahasiswas as $mhs)
                <div class="mb-4 rounded-xl border border-slate-100 bg-white p-4 shadow-[0px_4px_16px_0px_#0F172A14]">
                    <div class="mb-4 flex items-start gap-4">
                        <img src="{{ 'https://ui-avatars.com/api/?name=' . urlencode($mhs->nama ?? 'M') . '&background=random' }}"
                            alt="Profile" class="h-[52px] w-[52px] rounded-full object-cover">
                        <div class="flex-1">
                            <h2 class="font-jakarta text-base font-extrabold text-black">{{ $mhs->nama ?? '-' }}</h2>
                            <p class="font-inter text-sm text-slate-500">{{ $mhs->nim }}</p>
                        </div>
                    </div>

                    <div class="mb-4 grid grid-cols-2 gap-4 rounded-lg bg-slate-50 p-3">
                        <div>
                            <p class="mb-1 font-inter text-[10px] text-slate-400">Program Studi</p>
                            <p class="font-inter text-xs font-semibold text-black">{{ $mhs->program_studi }}</p>
                        </div>
                        <div>
                            <p class="mb-1 font-inter text-[10px] text-slate-400">Semester</p>
                            <p class="font-inter text-xs font-semibold text-black">Semester {{ $mhs->semester }}</p>
                        </div>
                        <div class="col-span-2 border-t border-slate-200 pt-3">
                            <p class="mb-1 font-inter text-[10px] text-slate-400">Dosen Pembimbing Akademik</p>
                            <p class="font-inter text-xs font-semibold text-black">{{ $mhs->dosenPA?->pengguna?->nama ?? 'Belum Ditentukan' }}</p>
                        </div>
                    </div>

                    <a href="{{ route('dosen.daftar-mahasiswa.show', $mhs->nim) }}"
                        class="flex w-full items-center justify-center gap-1.5 rounded-lg border border-[#2653EB] py-2.5 font-inter text-xs font-semibold text-[#2653EB] transition hover:bg-blue-50">
                        Lihat Profil
                    </a>
                </div>
            @empty
                <div class="rounded-xl bg-white py-10 text-center shadow-[0px_4px_16px_0px_#0F172A14]">
                    <p class="font-inter text-sm text-slate-400">Belum ada data mahasiswa.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
