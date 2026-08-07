<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DaftarMahasiswaController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        
        // Get nip of the current dosen
        $nip = $user->dosenPA->nip ?? null;

        $query = mahasiswa::with('dosenPA.pengguna');

        if ($nip) {
            $query->where('nip', $nip);
        }

        if ($request->has('cari') && $request->cari != '') {
            $cari = $request->cari;
            $query->where(function($q) use ($cari) {
                $q->where('nim', 'like', "%{$cari}%")
                  ->orWhereHas('pengguna', function($q2) use ($cari) {
                      $q2->where('nama', 'like', "%{$cari}%");
                  });
            });
        }

        $mahasiswas_raw = $query->get();
        $jumlahMahasiswa = $mahasiswas_raw->count();

        $mahasiswas = $mahasiswas_raw->map(function ($mhs) {
            return (object) [
                'id' => $mhs->nim,
                'nama' => $mhs->pengguna->nama ?? '-',
                'nim' => $mhs->nim,
                'program_studi' => $mhs->program_studi,
                'semester' => $mhs->semester,
                'dosenPA' => $mhs->dosenPA
            ];
        });

        return view('pages.dosen.daftar-mahasiswa.index', compact('mahasiswas', 'jumlahMahasiswa'));
    }
}
