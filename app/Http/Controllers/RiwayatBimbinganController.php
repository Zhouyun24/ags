<?php

namespace App\Http\Controllers;

use App\Models\hasil_bimbingan;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class RiwayatBimbinganController extends Controller
{
    public function index()
    {
        $mahasiswa = Auth::user()?->mahasiswa;

        if (!$mahasiswa) {
            return view('pages.mahasiswa.riwayat-bimbingan.index', [
                'riwayat' => collect(),
            ]);
        }

        $records = hasil_bimbingan::whereHas('jadwal_bimbingan', fn($q) => $q->where('nim', $mahasiswa->nim))
            ->with('jadwal_bimbingan')
            ->orderByDesc('created_at')
            ->get();

        $riwayat = $records->map(function ($h) {
            $tanggal = $h->jadwal_bimbingan?->tanggal_jadwal
                ? Carbon::parse($h->jadwal_bimbingan->tanggal_jadwal)->format('d M Y')
                : '-';

            $status = match ((int) $h->jadwal_bimbingan?->status_jadwal) {
                1 => 'disetujui',
                2 => 'ditolak',
                default => 'menunggu',
            };

            return (object) [
                'topik' => $h->jadwal_bimbingan?->topik_diskusi ?? '-',
                'tanggal' => $tanggal,
                'status' => $status,
                'catatan' => $h->catatan_bimbingan,
                'rekomendasi' => $h->arahan_akademik,
            ];
        });

        return view('pages.mahasiswa.riwayat-bimbingan.index', [
            'riwayat' => $riwayat,
        ]);
    }
}
