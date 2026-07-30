<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\jadwal_bimbingan;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class PersetujuanJadwalDosenController extends Controller
{
    /**
     * Tampilkan daftar semua pengajuan jadwal dari mahasiswa bimbingan (KK7).
     */
    public function index()
    {
        $nip = Auth::user()->dosenPA?->nip;

        if (!$nip) {
            return view('pages.dosen.persetujuan-jadwal.index', [
                'jadwals' => collect(),
            ]);
        }

        $records = jadwal_bimbingan::with(['mahasiswa.pengguna', 'hasil_bimbingan.penilaian_bimbingan'])
            ->where('nip', $nip)
            ->orderByDesc('created_at')
            ->get();

        $jadwals = $records->map(function ($j) {
            $statusText = match ((int) $j->status_jadwal) {
                1 => 'disetujui',
                2 => 'ditolak',
                default => 'menunggu',
            };

            return (object) [
                'id_jadwal' => $j->id_jadwal,
                'topik' => $j->topik_diskusi,
                'mahasiswa' => $j->mahasiswa?->pengguna?->nama ?? '-',
                'nim' => $j->nim,
                'tanggal' => $j->tanggal_jadwal
                    ? Carbon::parse($j->tanggal_jadwal)->format('d/m/Y')
                    : '-',
                'jam' => $j->jam_jadwal
                    ? Carbon::parse($j->jam_jadwal)->format('H.i') . ' WIB'
                    : '-',
                'status' => $statusText,
                'status_int' => (int) $j->status_jadwal,
                'has_hasil' => $j->hasil_bimbingan !== null,
                'id_hasil' => $j->hasil_bimbingan?->id_hasil,
                'has_penilaian' => $j->hasil_bimbingan?->penilaian_bimbingan !== null,
                'id_perkembangan' => $j->hasil_bimbingan?->penilaian_bimbingan?->id_perkembangan,
            ];
        });

        return view('pages.dosen.persetujuan-jadwal.index', [
            'jadwals' => $jadwals,
        ]);
    }
}
