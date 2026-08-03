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
        $user = Auth::user();
        $mahasiswa = $user?->mahasiswa;

        if (!$mahasiswa) {
            return view('pages.mahasiswa.evaluasi-akademik.index', [
                'mahasiswa' => (object) [
                    'nama' => '-',
                    'semester' => '-',
                ],
                'skorKeseluruhan' => 0,
                'skorMaks' => 5,
                'labelSkor' => '-',
                'skor' => [
                    'partisipasi' => 0,
                    'pemahaman' => 0,
                ],
                'trenPerkembangan' => [],
            ]);
        }

        // Ambil semua penilaian bimbingan milik mahasiswa ini
        $records = penilaian_bimbingan::whereHas('hasilBimbingan.jadwal_bimbingan', fn($q) => $q->where('nim', $mahasiswa->nim))
            ->with('hasilBimbingan.jadwal_bimbingan')
            ->orderByDesc('created_at')
            ->get();

        $skorKeseluruhan = 0;
        $skorPartisipasi = 0;
        $skorPemahaman = 0;
        $trenPerkembangan = [];

        if ($records->count() > 0) {
            $skorKeseluruhan = round($records->avg('nilai_perkembangan'), 2);
            $skorPartisipasi = round($records->avg('skor_keaktifan'), 2);
            $skorPemahaman = round($records->avg('skor_pemahaman'), 2);

            // Tren perkembangan diurutkan dari yang paling lama ke paling baru (S1, S2, S3...)
            foreach ($records->reverse()->values() as $index => $p) {
                $label = 'S' . ($index + 1);
                $trenPerkembangan[$label] = $p->nilai_perkembangan;
            }
        }

        return view('pages.mahasiswa.evaluasi-akademik.index', [
            'mahasiswa' => (object) [
                'nama' => $user->nama ?? '-',
                'semester' => $mahasiswa->semester ?? '-',
            ],
            'skorKeseluruhan' => $skorKeseluruhan,
            'skorMaks' => 5,
            'labelSkor' => $mahasiswa->nilai_bimbingan ?? '-',
            'skor' => [
                'partisipasi' => $skorPartisipasi,
                'pemahaman' => $skorPemahaman,
            ],
            'trenPerkembangan' => $trenPerkembangan,
        ]);
    }
}

