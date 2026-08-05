<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\jadwal_bimbingan;
use App\Models\hasil_bimbingan;
use Carbon\Carbon;

class NotificationController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $notifications = collect();

        if ((int)$user->role === 2) {
            // Mahasiswa Notifications
            $mahasiswa = $user->mahasiswa ?? null;
            if ($mahasiswa) {
                // 1. Jadwal Bimbingan Updates (Disetujui / Ditolak)
                $jadwals = jadwal_bimbingan::where('nim', $mahasiswa->nim)
                    ->whereIn('status_jadwal', [1, 2])
                    ->orderBy('updated_at', 'desc')
                    ->take(10)
                    ->get();
                
                foreach ($jadwals as $jadwal) {
                    $statusText = $jadwal->status_jadwal == 1 ? 'disetujui' : 'ditolak';
                    $notifications->push((object)[
                        'id' => 'j_'.$jadwal->id_jadwal,
                        'tipe' => $jadwal->status_jadwal == 1 ? 'disetujui' : 'ditolak',
                        'pesan' => "Jadwal bimbingan '{$jadwal->topik}' telah {$statusText}.",
                        'waktu' => $jadwal->updated_at->diffForHumans(),
                        'dibaca' => false,
                        'created_at' => $jadwal->updated_at
                    ]);
                }

                // 2. Hasil Bimbingan Added
                $hasils = hasil_bimbingan::with('jadwal_bimbingan')
                    ->whereHas('jadwal_bimbingan', function($q) use ($mahasiswa) {
                        $q->where('nim', $mahasiswa->nim);
                    })
                    ->orderBy('created_at', 'desc')
                    ->take(10)
                    ->get();

                foreach ($hasils as $hasil) {
                    $notifications->push((object)[
                        'id' => 'h_'.$hasil->id_hasil,
                        'tipe' => 'info',
                        'pesan' => "Dosen telah mengisi hasil dan rekomendasi bimbingan.",
                        'waktu' => $hasil->created_at->diffForHumans(),
                        'dibaca' => false,
                        'created_at' => $hasil->created_at
                    ]);
                }
            }
        } elseif ((int)$user->role === 3) {
            // Dosen Notifications
            $dosen = $user->dosenPA ?? null;
            if ($dosen) {
                // 1. Jadwal Bimbingan Baru (Menunggu)
                $jadwals = jadwal_bimbingan::with('mahasiswa')
                    ->where('nip', $dosen->nip)
                    ->where('status_jadwal', 0)
                    ->orderBy('created_at', 'desc')
                    ->take(15)
                    ->get();
                
                foreach ($jadwals as $jadwal) {
                    $namaMhs = $jadwal->mahasiswa->pengguna->nama ?? $jadwal->nim;
                    $notifications->push((object)[
                        'id' => 'j_'.$jadwal->id_jadwal,
                        'tipe' => 'info',
                        'pesan' => "Mahasiswa {$namaMhs} mengajukan jadwal bimbingan.",
                        'waktu' => $jadwal->created_at->diffForHumans(),
                        'dibaca' => false,
                        'created_at' => $jadwal->created_at
                    ]);
                }
            }
        }

        // Sort all notifications by latest
        $sortedNotifications = $notifications->sortByDesc('created_at')->values()->all();

        $viewPath = match ((int)$user->role) {
            1 => 'pages.operator.notifikasi.index',
            2 => 'pages.mahasiswa.notifikasi.index',
            3 => 'pages.dosen.notifikasi.index',
            default => 'pages.splash.index'
        };

        if (!view()->exists($viewPath)) {
            return back()->with('error', 'Halaman notifikasi tidak tersedia.');
        }

        return view($viewPath, ['notifications' => $sortedNotifications]);
    }
}
