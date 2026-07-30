<?php

namespace App\Http\Controllers;

use App\Models\penilaian_bimbingan;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class EvaluasiAkademikController extends Controller
{
    /**
     * Tampilkan penilaian perkembangan akademik mahasiswa yang login (KK12).
     *
     * Proses 5.4: Tampilkan Penilaian
     */
    public function index()
    {
        $mahasiswa = Auth::user()?->mahasiswa;

        if (!$mahasiswa) {
            return view('pages.mahasiswa.evaluasi-akademik.index', [
                'penilaians' => collect(),
                'ringkasan' => null,
            ]);
        }

        // Ambil semua penilaian bimbingan milik mahasiswa ini
        $records = penilaian_bimbingan::whereHas('hasilBimbingan.jadwal_bimbingan', fn($q) => $q->where('nim', $mahasiswa->nim))
            ->with('hasilBimbingan.jadwal_bimbingan')
            ->orderByDesc('created_at')
            ->get();

        $penilaians = $records->map(function ($p) {
            $jadwal = $p->hasilBimbingan?->jadwal_bimbingan;

            $tanggal = $jadwal?->tanggal_jadwal
                ? Carbon::parse($jadwal->tanggal_jadwal)->format('d M Y')
                : '-';

            return (object) [
                'topik' => $jadwal?->topik_diskusi ?? '-',
                'tanggal' => $tanggal,
                'skor_keaktifan' => $p->skor_keaktifan,
                'skor_pemahaman' => $p->skor_pemahaman,
                'nilai_perkembangan' => $p->nilai_perkembangan,
            ];
        });

        // Ringkasan rata-rata
        $ringkasan = null;
        if ($records->count() > 0) {
            $ringkasan = (object) [
                'rata_keaktifan' => round($records->avg('skor_keaktifan'), 2),
                'rata_pemahaman' => round($records->avg('skor_pemahaman'), 2),
                'rata_perkembangan' => round($records->avg('nilai_perkembangan'), 2),
                'nilai_bimbingan' => $mahasiswa->nilai_bimbingan ?? '-',
                'total_sesi' => $records->count(),
            ];
        }

        return view('pages.mahasiswa.evaluasi-akademik.index', [
            'penilaians' => $penilaians,
            'ringkasan' => $ringkasan,
        ]);
    }
}
