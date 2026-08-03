<?php

namespace App\Http\Controllers;

use App\Helpers\IdGenerator;
use App\Http\Requests\AjukanJadwalRequest;
use App\Models\jadwal_bimbingan;
use Illuminate\Support\Facades\Auth;

class AjukanBimbinganController extends Controller
{
    public function create()
    {
        $mahasiswa = Auth::user()->mahasiswa;

        $dosen = (object) [
            'nama' => $mahasiswa?->dosenPA?->pengguna?->nama,
            'prodi' => $mahasiswa?->dosenPA?->program_studi,
            'ketersediaan' => 'Senin - Jum\'at',
        ];

        return view('pages.mahasiswa.ajukan-bimbingan.index', ['dosen' => $dosen]);
    }

    public function store(AjukanJadwalRequest $request)
    {
        $mahasiswa = Auth::user()->mahasiswa;

        if (!$mahasiswa) {
            return redirect()->back()->with('error', 'Data mahasiswa tidak ditemukan.');
        }

        $jadwal = new jadwal_bimbingan();
        $jadwal->id_jadwal = IdGenerator::generateFor(jadwal_bimbingan::class);
        $jadwal->topik_diskusi = $request->validated('topik');
        $jadwal->tanggal_jadwal = $request->validated('tanggal');
        $jadwal->jam_jadwal = $request->validated('waktu');
        $jadwal->status_jadwal = 0;
        $jadwal->nim = $mahasiswa->nim;
        $jadwal->nip = $mahasiswa->nip;
        $jadwal->save();

        return redirect()->route('mahasiswa.status-jadwal.index')->with('success', 'Pengajuan jadwal berhasil disimpan, menunggu persetujuan Dosen Pembimbing Akademik.');
    }
}
