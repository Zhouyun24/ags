<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\ResetPasswordRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ResetPasswordController extends Controller
{
    /**
     * Proses ubah kata sandi pengguna (Proses 2.3).
     *
     * Berlaku untuk semua role: Operator, Mahasiswa, Dosen PA.
     */
    public function update(ResetPasswordRequest $request)
    {
        $user = Auth::user();
        $validated = $request->validated();

        // Verifikasi kata sandi lama (hanya bcrypt hash)
        $inputOld = trim($validated['kata_sandi_lama']);
        $dbPassword = trim($user->kata_sandi);

        $oldPasswordMatches = Hash::check($inputOld, $dbPassword);

        if (!$oldPasswordMatches) {
            return redirect()->back()->withErrors([
                'kata_sandi_lama' => 'Kata sandi lama yang Anda masukkan salah.',
            ]);
        }

        // Update kata sandi baru (selalu hash)
        $user->kata_sandi = Hash::make($validated['kata_sandi_baru']);
        $user->save();

        return redirect()->back()->with('success', 'Kata sandi berhasil diperbarui.');
    }
}
