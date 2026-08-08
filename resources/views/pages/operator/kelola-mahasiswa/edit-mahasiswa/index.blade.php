@extends('layouts.index')

@section('layouts')


<div class="pb-5">
    <div class="relative overflow-hidden bg-gradient-to-br from-[#8B5CF6] via-[#7C3AED] to-[#6D28D9] px-5 pb-12 pt-10">
        <div class="flex items-center gap-3">
            <a href="{{ route('operator.kelola-mahasiswa.index') }}"
                class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-white/20 text-white hover:bg-white/30">
                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <path d="M15 6l-6 6 6 6" />
                </svg>
            </a>
            <div>
                <h1 class="font-jakarta text-xl font-extrabold text-white">Edit Mahasiswa</h1>
                <p class="mt-1 font-inter text-xs text-white">Perbarui data mahasiswa</p>
            </div>
        </div>
    </div>

    <div class="px-5 pt-6">
        <form method="POST" action="{{ route('operator.kelola-mahasiswa.update', $mahasiswa->nim) }}">
            @csrf
            @method('PUT')

            <div class="mb-6 flex flex-col gap-4 rounded-2xl bg-white p-5 shadow-[0px_4px_16px_0px_#0F172A14]">

                <div>
                    <label for="nim" class="mb-1.5 block font-inter text-xs font-semibold text-black">NIM</label>
                    <input
                        type="text"
                        id="nim"
                        name="nim"
                        value="{{ old('nim', $mahasiswa->nim) }}"
                        placeholder="1XXXXXXX"
                        readonly
                        class="w-full rounded-lg border border-slate-200 bg-slate-50 px-3.5 py-2.5 font-inter text-sm text-slate-500 placeholder:text-slate-400 focus:outline-none cursor-not-allowed"
                    />
                    @error('nim')
                        <p class="mt-1 font-inter text-[11px] text-[#DC2626]">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="nama" class="mb-1.5 block font-inter text-xs font-semibold text-black">Nama Lengkap</label>
                    <input
                        type="text"
                        id="nama"
                        name="nama"
                        value="{{ old('nama', $mahasiswa->pengguna?->nama) }}"
                        placeholder="Masukkan nama lengkap"
                        class="w-full rounded-lg border border-slate-200 px-3.5 py-2.5 font-inter text-sm text-black placeholder:text-slate-400 focus:border-[#7C3AED] focus:outline-none focus:ring-1 focus:ring-[#7C3AED]"
                    />
                    @error('nama')
                        <p class="mt-1 font-inter text-[11px] text-[#DC2626]">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="email" class="mb-1.5 block font-inter text-xs font-semibold text-black">Email</label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email', $mahasiswa->pengguna?->email) }}"
                        placeholder="nama@email.com"
                        class="w-full rounded-lg border border-slate-200 px-3.5 py-2.5 font-inter text-sm text-black placeholder:text-slate-400 focus:border-[#7C3AED] focus:outline-none focus:ring-1 focus:ring-[#7C3AED]"
                    />
                    @error('email')
                        <p class="mt-1 font-inter text-[11px] text-[#DC2626]">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="nomor_telepon" class="mb-1.5 block font-inter text-xs font-semibold text-black">Nomor Telepon</label>
                    <input
                        type="tel"
                        id="nomor_telepon"
                        name="nomor_telepon"
                        value="{{ old('nomor_telepon', $mahasiswa->pengguna?->nomor_telepon) }}"
                        placeholder="08xxxxxxxxxx"
                        class="w-full rounded-lg border border-slate-200 px-3.5 py-2.5 font-inter text-sm text-black placeholder:text-slate-400 focus:border-[#7C3AED] focus:outline-none focus:ring-1 focus:ring-[#7C3AED]"
                    />
                    @error('nomor_telepon')
                        <p class="mt-1 font-inter text-[11px] text-[#DC2626]">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="program_studi" class="mb-1.5 block font-inter text-xs font-semibold text-black">Program Studi</label>
                    <input
                        type="text"
                        id="program_studi"
                        name="program_studi"
                        value="{{ old('program_studi', $mahasiswa->program_studi) }}"
                        placeholder="Teknik Informatika"
                        class="w-full rounded-lg border border-slate-200 px-3.5 py-2.5 font-inter text-sm text-black placeholder:text-slate-400 focus:border-[#7C3AED] focus:outline-none focus:ring-1 focus:ring-[#7C3AED]"
                    />
                    @error('program_studi')
                        <p class="mt-1 font-inter text-[11px] text-[#DC2626]">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="semester" class="mb-1.5 block font-inter text-xs font-semibold text-black">Semester</label>
                    <input
                        type="number"
                        id="semester"
                        name="semester"
                        value="{{ old('semester', $mahasiswa->semester) }}"
                        placeholder="4"
                        min="0"
                        max="14"
                        class="w-full rounded-lg border border-slate-200 px-3.5 py-2.5 font-inter text-sm text-black placeholder:text-slate-400 focus:border-[#7C3AED] focus:outline-none focus:ring-1 focus:ring-[#7C3AED]"
                    />
                    @error('semester')
                        <p class="mt-1 font-inter text-[11px] text-[#DC2626]">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="kata_sandi" class="mb-1.5 block font-inter text-xs font-semibold text-black">Kata Sandi (Opsional)</label>
                    <input
                        type="password"
                        id="kata_sandi"
                        name="kata_sandi"
                        placeholder="Kosongkan jika tidak ingin mengubah"
                        class="w-full rounded-lg border border-slate-200 px-3.5 py-2.5 font-inter text-sm text-black placeholder:text-slate-400 focus:border-[#7C3AED] focus:outline-none focus:ring-1 focus:ring-[#7C3AED]"
                    />
                    @error('kata_sandi')
                        <p class="mt-1 font-inter text-[11px] text-[#DC2626]">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="nip" class="mb-1.5 block font-inter text-xs font-semibold text-black">Dosen Pembimbing Akademik</label>
                    <select
                        id="nip"
                        name="nip"
                        class="w-full rounded-lg border border-slate-200 px-3.5 py-2.5 font-inter text-sm text-black focus:border-[#7C3AED] focus:outline-none focus:ring-1 focus:ring-[#7C3AED]"
                    >
                        <option value="">Pilih Dosen PA (Opsional)</option>
                        @foreach($dosenList as $dosen)
                            <option value="{{ $dosen->nip }}" {{ old('nip', $mahasiswa->nip) == $dosen->nip ? 'selected' : '' }}>
                                {{ $dosen->pengguna?->nama }}
                            </option>
                        @endforeach
                    </select>
                    @error('nip')
                        <p class="mt-1 font-inter text-[11px] text-[#DC2626]">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mb-6 grid grid-cols-2 gap-3">
                <a href="{{ route('operator.kelola-mahasiswa.index') }}"
                    class="flex items-center justify-center rounded-lg border border-[#7C3AED] py-3 font-inter text-sm font-semibold text-[#7C3AED] hover:bg-[#7C3AED]/5">
                    Batal
                </a>
                <button type="submit"
                    class="flex items-center justify-center rounded-lg bg-[#7C3AED] py-3 font-inter text-sm font-semibold text-white hover:bg-[#6D28D9]">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection