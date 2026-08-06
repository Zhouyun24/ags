<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        if (!$user) {
            return redirect()->route('login');
        }

        $profileData = (object) [
            'nama' => $user->nama,
            'email' => $user->email,
            'role' => match ((int)$user->role) {
                1 => 'Operator',
                2 => 'Mahasiswa',
                3 => 'Dosen PA',
                default => 'Unknown'
            },
            'foto' => null,
            'telepon' => $user->nomor_telepon ?? '-',
            'id_operator' => '-',
            'nim' => '-',
            'nip' => '-',
            'prodi' => '-',
            'semester' => '-',
            'dosenPa' => '-',
        ];

        // Specific data depending on role
        if ((int)$user->role === 1) { // Operator
            $operator = $user->operator ?? null;
            if ($operator) {
                $profileData->id_operator = $operator->id_operator ?? '-';
            }
        } elseif ((int)$user->role === 2) { // Mahasiswa
            $mahasiswa = $user->mahasiswa ?? null; 
            
            if ($mahasiswa) {
                $profileData->nim = $mahasiswa->nim ?? '-';
                $profileData->prodi = $mahasiswa->program_studi ?? '-';
                $profileData->semester = $mahasiswa->semester ?? '-';
                $profileData->dosenPa = $mahasiswa->dosenPA?->pengguna?->nama ?? '-';
            }
        } elseif ((int)$user->role === 3) { // Dosen
            $dosen = $user->dosenPA ?? null;
            if ($dosen) {
                $profileData->nip = $dosen->nip ?? '-';
                $profileData->prodi = $dosen->program_studi ?? '-';
            }
        }

        $viewPath = match ((int)$user->role) {
            1 => 'pages.operator.profile.index',
            2 => 'pages.mahasiswa.profile.index',
            3 => 'pages.dosen.profile.index',
            default => 'pages.splash.index'
        };

        // Fallback to avoid error if view not found
        if (!view()->exists($viewPath)) {
            return back()->with('error', 'Halaman profil tidak tersedia.');
        }

        return view($viewPath, ['user' => $profileData]);
    }
}
