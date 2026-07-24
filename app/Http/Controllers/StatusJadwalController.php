<?php

namespace App\Http\Controllers;

use App\Models\jadwal_bimbingan;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class StatusJadwalController extends Controller
{
    public function index()
    {
        $mahasiswa = Auth::user()?->mahasiswa;

        if (!$mahasiswa) {
            return view('pages.mahasiswa.status-jadwal.index', [
                'jadwal' => collect(),
            ]);
        }

        $records = jadwal_bimbingan::with('dosenPA.pengguna')
            ->where('nim', $mahasiswa->nim)
            ->orderByDesc('created_at')
            ->get();

        $jadwal = $records->map(function ($j) {
            $statusText = match ((int) $j->status_jadwal) {
                1 => 'disetujui',
                2 => 'ditolak',
                default => 'menunggu',
            };

            $tanggal = $j->tanggal_jadwal
                ? Carbon::parse($j->tanggal_jadwal)->format('d/m/Y')
                : '-';

            $jam = $j->jam_jadwal
                ? Carbon::parse($j->jam_jadwal)->format('H.i') . ' WIB'
                : '-';

            return (object) [
                'topik' => $j->topik_diskusi,
                'dosen' => $j->dosenPA?->pengguna?->nama ?? '-',
                'tanggal' => $tanggal,
                'jam' => $jam,
                'status' => $statusText,
            ];
        });

        return view('pages.mahasiswa.status-jadwal.index', [
            'jadwal' => $jadwal,
        ]);
    }
}
