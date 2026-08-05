<?php

namespace App\Http\Controllers;

use App\Models\hasil_bimbingan;
use App\Models\jadwal_bimbingan;
use App\Models\penilaian_bimbingan;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class BerandaController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $user?->load('mahasiswa.dosenPA.pengguna');
        $m = $user?->mahasiswa;

        if (!$m) {
            return view('pages.mahasiswa.beranda.index', [
                'mahasiswa' => (object) [
                    'nama' => '-',
                    'nim' => '-',
                    'prodi' => '-',
                    'semester' => '-',
                ],
                'dosenPa' => '-',
                'sesiTotal' => 0,
                'sesiTerpakai' => 0,
                'progressBimbingan' => 0,
                'skor' => [
                    'partisipasi' => 0,
                    'pemahaman' => 0,
                    'keseluruhan' => 0,
                ],
                'bimbinganMendatang' => null,
                'bimbinganTerakhir' => null,
            ]);
        }

        $sesiTotal = jadwal_bimbingan::where('nim', $m->nim)
            ->where('status_jadwal', 1)
            ->count();

        $sesiTerpakai = hasil_bimbingan::whereHas('jadwal_bimbingan', fn($q) => $q->where('nim', $m->nim))
            ->count();

        $progressBimbingan = $sesiTotal > 0 ? (int) round(($sesiTerpakai / $sesiTotal) * 100) : 0;

        $penilaians = penilaian_bimbingan::whereHas('hasilBimbingan.jadwal_bimbingan', fn($q) => $q->where('nim', $m->nim))->get();

        $skorPartisipasi = $penilaians->count() > 0 ? round((float) $penilaians->avg('skor_keaktifan'), 2) : 0;
        $skorPemahaman = $penilaians->count() > 0 ? round((float) $penilaians->avg('skor_pemahaman'), 2) : 0;
        $skorKeseluruhan = $penilaians->count() > 0 ? round((float) $penilaians->avg('nilai_perkembangan'), 2) : 0;

        $data = [
            'mahasiswa' => (object) [
                'nama' => $user->nama,
                'nim' => $m->nim,
                'prodi' => $m->program_studi,
                'semester' => $m->semester,
            ],
            'dosenPa' => $m->dosenPA?->pengguna?->nama ?? '-',
            'sesiTotal' => $sesiTotal,
            'sesiTerpakai' => $sesiTerpakai,
            'progressBimbingan' => $progressBimbingan,
            'skor' => [
                'partisipasi' => $skorPartisipasi,
                'pemahaman' => $skorPemahaman,
                'keseluruhan' => $skorKeseluruhan,
            ],
            'bimbinganMendatang' => null,
            'bimbinganTerakhir' => null,
        ];

        $upcomingJadwal = jadwal_bimbingan::with('dosenPA.pengguna')
            ->where('nim', $m->nim)
            ->where('status_jadwal', 1)
            ->where('tanggal_jadwal', '>=', now()->toDateString())
            ->orderBy('tanggal_jadwal', 'asc')
            ->first();

        if ($upcomingJadwal) {
            $data['bimbinganMendatang'] = (object) [
                'status' => 'Disetujui',
                'topik' => $upcomingJadwal->topik_diskusi,
                'dosen' => $upcomingJadwal->dosenPA?->pengguna?->nama ?? '-',
                'tanggal' => Carbon::parse($upcomingJadwal->tanggal_jadwal)->format('d/m/Y'),
                'jam' => Carbon::parse($upcomingJadwal->jam_jadwal)->format('H.i') . ' WIB',
                'url' => '#',
            ];
        }

        $latestHasil = hasil_bimbingan::whereHas('jadwal_bimbingan', fn($q) => $q->where('nim', $m->nim))
            ->with('jadwal_bimbingan')
            ->orderByDesc('created_at')
            ->first();

        if ($latestHasil) {
            $latestStatus = match ((int) $latestHasil->jadwal_bimbingan?->status_jadwal) {
                1 => 'disetujui',
                2 => 'ditolak',
                default => 'menunggu',
            };

            $data['bimbinganTerakhir'] = (object) [
                'judul' => $latestHasil->jadwal_bimbingan?->topik_diskusi ?? '-',
                'tanggal' => $latestHasil->jadwal_bimbingan?->tanggal_jadwal
                    ? Carbon::parse($latestHasil->jadwal_bimbingan->tanggal_jadwal)->format('d/m/Y')
                    : '-',
                'catatan' => $latestHasil->catatan_bimbingan,
                'status' => $latestStatus,
            ];
        }

        return view('pages.mahasiswa.beranda.index', $data);
    }
}
