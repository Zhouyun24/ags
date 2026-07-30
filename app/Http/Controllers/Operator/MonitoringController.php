<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use App\Models\hasil_bimbingan;
use App\Models\jadwal_bimbingan;
use App\Models\penilaian_bimbingan;
use Illuminate\Support\Carbon;

class MonitoringController extends Controller
{
    /**
     * Lihat seluruh data jadwal bimbingan (KK14).
     */
    public function jadwal()
    {
        $records = jadwal_bimbingan::with(['mahasiswa.pengguna', 'dosenPA.pengguna', 'hasil_bimbingan'])
            ->orderByDesc('created_at')
            ->get();

        $jadwals = $records->map(function ($j) {
            $statusText = match ((int) $j->status_jadwal) {
                1 => 'Disetujui',
                2 => 'Ditolak',
                default => 'Menunggu',
            };

            return (object) [
                'id_jadwal' => $j->id_jadwal,
                'topik' => $j->topik_diskusi,
                'mahasiswa' => $j->mahasiswa?->pengguna?->nama ?? '-',
                'nim' => $j->nim,
                'dosen' => $j->dosenPA?->pengguna?->nama ?? '-',
                'nip' => $j->nip,
                'tanggal' => $j->tanggal_jadwal
                    ? Carbon::parse($j->tanggal_jadwal)->format('d/m/Y')
                    : '-',
                'jam' => $j->jam_jadwal
                    ? Carbon::parse($j->jam_jadwal)->format('H.i') . ' WIB'
                    : '-',
                'status' => $statusText,
                'has_hasil' => $j->hasil_bimbingan !== null,
            ];
        });

        return view('pages.operator.monitoring.jadwal', [
            'jadwals' => $jadwals,
        ]);
    }

    /**
     * Lihat seluruh data hasil bimbingan (KK14).
     */
    public function hasil()
    {
        $records = hasil_bimbingan::with(['jadwal_bimbingan.mahasiswa.pengguna', 'jadwal_bimbingan.dosenPA.pengguna', 'penilaian_bimbingan'])
            ->orderByDesc('created_at')
            ->get();

        $hasils = $records->map(function ($h) {
            $jadwal = $h->jadwal_bimbingan;

            return (object) [
                'id_hasil' => $h->id_hasil,
                'topik' => $jadwal?->topik_diskusi ?? '-',
                'mahasiswa' => $jadwal?->mahasiswa?->pengguna?->nama ?? '-',
                'dosen' => $jadwal?->dosenPA?->pengguna?->nama ?? '-',
                'tanggal' => $jadwal?->tanggal_jadwal
                    ? Carbon::parse($jadwal->tanggal_jadwal)->format('d/m/Y')
                    : '-',
                'catatan_bimbingan' => $h->catatan_bimbingan,
                'arahan_akademik' => $h->arahan_akademik,
                'has_penilaian' => $h->penilaian_bimbingan !== null,
            ];
        });

        return view('pages.operator.monitoring.hasil', [
            'hasils' => $hasils,
        ]);
    }

    /**
     * Lihat seluruh data penilaian bimbingan (KK14).
     */
    public function penilaian()
    {
        $records = penilaian_bimbingan::with(['hasilBimbingan.jadwal_bimbingan.mahasiswa.pengguna', 'hasilBimbingan.jadwal_bimbingan.dosenPA.pengguna'])
            ->orderByDesc('created_at')
            ->get();

        $penilaians = $records->map(function ($p) {
            $jadwal = $p->hasilBimbingan?->jadwal_bimbingan;

            return (object) [
                'id_perkembangan' => $p->id_perkembangan,
                'topik' => $jadwal?->topik_diskusi ?? '-',
                'mahasiswa' => $jadwal?->mahasiswa?->pengguna?->nama ?? '-',
                'dosen' => $jadwal?->dosenPA?->pengguna?->nama ?? '-',
                'tanggal' => $jadwal?->tanggal_jadwal
                    ? Carbon::parse($jadwal->tanggal_jadwal)->format('d/m/Y')
                    : '-',
                'skor_keaktifan' => $p->skor_keaktifan,
                'skor_pemahaman' => $p->skor_pemahaman,
                'nilai_perkembangan' => $p->nilai_perkembangan,
            ];
        });

        return view('pages.operator.monitoring.penilaian', [
            'penilaians' => $penilaians,
        ]);
    }

    /**
     * Hapus jadwal bimbingan beserta data terkait secara cascade (KK15).
     *
     * Cascade: jadwal → hasil_bimbingan → penilaian_bimbingan
     * (sudah ditangani oleh onDelete('cascade') pada FK di migration)
     */
    public function destroyJadwal($id_jadwal)
    {
        $jadwal = jadwal_bimbingan::where('id_jadwal', $id_jadwal)->firstOrFail();

        $jadwal->delete();

        return redirect()->route('operator.monitoring.jadwal')
            ->with('success', 'Data jadwal bimbingan beserta data terkait berhasil dihapus.');
    }
}
