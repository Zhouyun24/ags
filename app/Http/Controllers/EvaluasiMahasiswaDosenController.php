<?php

namespace App\Http\Controllers;

use App\Models\hasil_bimbingan;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class EvaluasiMahasiswaDosenController extends Controller
{
    public function index()
    {
        $nip = Auth::user()->dosenPA?->nip;

        if (!$nip) {
            return view('pages.dosen.evaluasi-mahasiswa.index', [
                'evaluasi' => collect(),
            ]);
        }

        $records = hasil_bimbingan::whereHas('jadwal_bimbingan', fn($q) => $q->where('nip', $nip))
            ->with([
                'jadwal_bimbingan.mahasiswa.pengguna',
                'penilaian_bimbingan',
            ])
            ->orderByDesc('created_at')
            ->get();

        $evaluasi = $records->map(function ($h) {
            $penilaian = $h->penilaian_bimbingan;

            $tanggal = $h->jadwal_bimbingan?->tanggal_jadwal
                ? Carbon::parse($h->jadwal_bimbingan->tanggal_jadwal)->format('d/m/Y')
                : '-';

            $jam = $h->jadwal_bimbingan?->jam_jadwal
                ? Carbon::parse($h->jadwal_bimbingan->jam_jadwal)->format('H.i') . ' WIB'
                : '-';

            $status = match ((int) $h->jadwal_bimbingan?->status_jadwal) {
                1 => 'disetujui',
                2 => 'ditolak',
                default => 'menunggu',
            };

            return (object) [
                'nim' => $h->jadwal_bimbingan?->mahasiswa?->nim ?? '-',
                'nama' => $h->jadwal_bimbingan?->mahasiswa?->pengguna?->nama ?? '-',
                'topik' => $h->jadwal_bimbingan?->topik_diskusi ?? '-',
                'tanggal' => $tanggal,
                'jam' => $jam,
                'status' => $status,
                'partisipasi' => $penilaian ? $penilaian->skor_keaktifan : 0,
                'pemahaman' => $penilaian ? $penilaian->skor_pemahaman : 0,
                'keseluruhan' => $penilaian ? $penilaian->nilai_perkembangan : 0,
                'sudah_dinilai' => $penilaian !== null,
                'id_hasil' => $h->id_hasil,
                'id_perkembangan' => $penilaian?->id_perkembangan,
            ];
        });

        return view('pages.dosen.evaluasi-mahasiswa.index', [
            'evaluasi' => $evaluasi,
        ]);
    }
}
