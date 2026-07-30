<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\jadwal_bimbingan;
use App\Models\mahasiswa;
use App\Models\penilaian_bimbingan;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class DashboardDosenController extends Controller
{
    /**
     * Beranda Dosen PA dengan dashboard analisis (KK13).
     *
     * Proses 6.1: Rekap Data Bimbingan
     * Proses 6.2: Tampilkan Dasbor
     */
    public function index()
    {
        $user = Auth::user();
        $dosen = $user?->dosenPA;

        if (!$dosen) {
            return view('pages.dosen.beranda.index');
        }

        $nip = $dosen->nip;

        // Statistik jadwal
        $totalJadwal = jadwal_bimbingan::where('nip', $nip)->count();
        $jadwalMenunggu = jadwal_bimbingan::where('nip', $nip)->where('status_jadwal', 0)->count();
        $jadwalDisetujui = jadwal_bimbingan::where('nip', $nip)->where('status_jadwal', 1)->count();
        $jadwalDitolak = jadwal_bimbingan::where('nip', $nip)->where('status_jadwal', 2)->count();

        // Jumlah mahasiswa bimbingan
        $totalMahasiswa = mahasiswa::where('nip', $nip)->count();

        // List mahasiswa bimbingan dengan rata-rata penilaian
        $mahasiswas = mahasiswa::with('pengguna')
            ->where('nip', $nip)
            ->get()
            ->map(function ($mhs) {
                $penilaians = penilaian_bimbingan::whereHas(
                    'hasilBimbingan.jadwal_bimbingan',
                    fn($q) => $q->where('nim', $mhs->nim)
                )->get();

                return (object) [
                    'nim' => $mhs->nim,
                    'nama' => $mhs->pengguna?->nama ?? '-',
                    'program_studi' => $mhs->program_studi,
                    'semester' => $mhs->semester,
                    'nilai_bimbingan' => $mhs->nilai_bimbingan ?? '-',
                    'total_sesi' => $penilaians->count(),
                    'rata_keaktifan' => $penilaians->count() > 0 ? round($penilaians->avg('skor_keaktifan'), 1) : 0,
                    'rata_pemahaman' => $penilaians->count() > 0 ? round($penilaians->avg('skor_pemahaman'), 1) : 0,
                    'rata_perkembangan' => $penilaians->count() > 0 ? round($penilaians->avg('nilai_perkembangan'), 1) : 0,
                ];
            });

        // Jadwal bimbingan mendatang
        $jadwalMendatang = jadwal_bimbingan::with('mahasiswa.pengguna')
            ->where('nip', $nip)
            ->where('status_jadwal', 1)
            ->where('tanggal_jadwal', '>=', now()->toDateString())
            ->orderBy('tanggal_jadwal', 'asc')
            ->limit(5)
            ->get()
            ->map(function ($j) {
                return (object) [
                    'id_jadwal' => $j->id_jadwal,
                    'topik' => $j->topik_diskusi,
                    'mahasiswa' => $j->mahasiswa?->pengguna?->nama ?? '-',
                    'tanggal' => Carbon::parse($j->tanggal_jadwal)->format('d/m/Y'),
                    'jam' => Carbon::parse($j->jam_jadwal)->format('H.i') . ' WIB',
                ];
            });

        return view('pages.dosen.beranda.index', [
            'dosen' => (object) [
                'nama' => $user->nama,
                'nip' => $nip,
                'prodi' => $dosen->program_studi,
            ],
            'statistik' => (object) [
                'totalJadwal' => $totalJadwal,
                'jadwalMenunggu' => $jadwalMenunggu,
                'jadwalDisetujui' => $jadwalDisetujui,
                'jadwalDitolak' => $jadwalDitolak,
                'totalMahasiswa' => $totalMahasiswa,
            ],
            'mahasiswas' => $mahasiswas,
            'jadwalMendatang' => $jadwalMendatang,
        ]);
    }
}
