<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use App\Models\jadwal_bimbingan;
use Illuminate\Http\Request;

class KelolaJadwalController extends Controller
{
    public function index()
    {
        $jadwals = jadwal_bimbingan::with(['mahasiswa.pengguna', 'dosenPA.pengguna'])->get();
        
        $daftarJadwal = $jadwals->map(function($jadwal) {
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
                'urlHapus' => route('operator.kelola-jadwal.destroy', $jadwal->id_jadwal),
            ];
        });

        return view('pages.operator.kelola-jadwal.index', compact('daftarJadwal'));
    }

    public function destroy($id_jadwal)
    {
        $jadwal = jadwal_bimbingan::findOrFail($id_jadwal);
        $jadwal->delete();
        
        return redirect()->route('operator.kelola-jadwal.index')->with('success', 'Data jadwal bimbingan berhasil dihapus.');
    }
}
