<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\mahasiswa;
use App\Models\dosen_pa;
use App\Models\operator;
use App\Models\jadwal_bimbingan;
use App\Models\penilaian_bimbingan;
use App\Models\hasil_bimbingan;

class DashboardOperatorController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        $ringkasan = [
            'mahasiswa' => mahasiswa::count(),
            'dosen' => dosen_pa::count(),
            'operator' => operator::count(),
            'jadwalAktif' => jadwal_bimbingan::where('status_jadwal', 1)->count(),
            'sesiSelesai' => hasil_bimbingan::count(),
        ];

        // Ensure we pass an object that matches the view expectations
        $operatorData = (object) [
            'nama' => $user->nama,
            'idOperator' => $user->operator ? $user->operator->id_operator : $user->id_pengguna,
            'institusi' => 'Universitas',
        ];

        // Aktivitas terbaru: ambil 3 jadwal terakhir
        $terbaru = jadwal_bimbingan::with(['mahasiswa.pengguna', 'dosenPA.pengguna'])->orderBy('created_at', 'desc')->take(3)->get();
        $aktivitasTerbaru = [];
        foreach($terbaru as $item) {
            $statusText = $item->status_jadwal == 1 ? 'disetujui' : ($item->status_jadwal == 2 ? 'ditolak' : 'menunggu');
            $statusColor = $item->status_jadwal == 1 ? 'text-[#16A34A]' : ($item->status_jadwal == 2 ? 'text-[#DC2626]' : 'text-[#F59E0B]');
            $aktivitasTerbaru[] = (object) [
                'dot' => 'bg-[#2653EB]',
                'judul' => 'Jadwal bimbingan',
                'sorot' => $statusText,
                'sorot_color' => $statusColor,
                'keterangan' => ($item->dosenPA->pengguna->nama ?? 'Dosen') . ' - ' . ($item->mahasiswa->pengguna->nama ?? 'Mhs') . ' &bull; ' . $item->created_at->diffForHumans(),
            ];
        }

        return view('pages.operator.beranda.index', [
            'ringkasan' => $ringkasan,
            'operator' => $operatorData,
            'aktivitasTerbaru' => $aktivitasTerbaru,
        ]);
    }
}
