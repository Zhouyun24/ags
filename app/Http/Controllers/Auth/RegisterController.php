<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\IdGenerator;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\operator;
use App\Models\pengguna;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    /**
     * Tampilkan halaman formulir pendaftaran operator.
     */
    public function showRegisterForm()
    {
        return view('pages.authentication.register.index', [
            'navbarVisibility' => '0',
            'sidebarVisibility' => '0',
        ]);
    }

    /**
     * Proses pendaftaran akun Operator baru (KK1).
     */
    public function register(RegisterRequest $request)
    {
        $validated = $request->validated();

        $user = DB::transaction(function () use ($validated) {
            // 1. Buat data pengguna baru (role = 1 / Operator)
            $idPengguna = 'USR_' . IdGenerator::generate();

            $user = pengguna::create([
                'id_pengguna' => $idPengguna,
                'nama' => $validated['nama'],
                'email' => $validated['email'],
                'kata_sandi' => Hash::make($validated['kata_sandi']),
                'nomor_telepon' => $validated['nomor_telepon'] ?? null,
                'role' => 1,
            ]);

            // 2. Buat data operator terkait
            $idOperator = 'OP_' . IdGenerator::generate();

            operator::create([
                'id_operator' => $idOperator,
                'id_pengguna' => $user->id_pengguna,
            ]);

            return $user;
        });

        // 3. Login otomatis setelah registrasi
        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('operator.daftar')->with('success', 'Pendaftaran berhasil! Selamat datang.');
    }
}
