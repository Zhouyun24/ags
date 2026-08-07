<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use App\Models\jadwal_bimbingan;
use Illuminate\Http\Request;

class KelolaBimbinganController extends Controller
{
    public function index()
    {
        $jadwals = jadwal_bimbingan::with(['mahasiswa.pengguna', 'dosenPA.pengguna', 'hasil_bimbingan.penilaian_bimbingan'])->get();
        
        $daftarBimbingan = $jadwals->map(function($jadwal) {
            $hasil = $jadwal->hasil_bimbingan;
            $penilaian = $hasil ? $hasil->penilaian_bimbingan : null;
            
            return [
                'id' => $jadwal->id_jadwal,
                'namaMhs' => $jadwal->mahasiswa->pengguna->nama ?? '-',
                'nim' => $jadwal->nim,
                'topik' => $jadwal->topik_diskusi,
                'namaDosen' => $jadwal->dosenPA->pengguna->nama ?? '-',
                'nip' => $jadwal->nip,
                'tanggal' => \Carbon\Carbon::parse($jadwal->tanggal_jadwal)->format('d/m/Y'),
                'jam' => \Carbon\Carbon::parse($jadwal->jam_jadwal)->format('H:i') . ' WIB',
                'status' => $jadwal->status_jadwal,
                'catatan' => $hasil->catatan_bimbingan ?? '-',
                'rekomendasi' => $hasil->arahan_akademik ?? '-',
                'evaluasi' => [
                    'partisipasi' => $penilaian->skor_keaktifan ?? 0,
                    'pemahaman' => $penilaian->skor_pemahaman ?? 0,
                    'keseluruhan' => $penilaian->nilai_perkembangan ?? 0,
                ],
                'urlHapus' => route('operator.kelola-bimbingan.destroy', $jadwal->id_jadwal),
            ];
        });

        return view('pages.operator.kelola-bimbingan.index', compact('daftarBimbingan'));
    }

    public function destroy($id_jadwal)
    {
        $jadwal = jadwal_bimbingan::findOrFail($id_jadwal);
        $jadwal->delete();
        
        return redirect()->route('operator.kelola-bimbingan.index')->with('success', 'Data bimbingan berhasil dihapus.');
    }
}
