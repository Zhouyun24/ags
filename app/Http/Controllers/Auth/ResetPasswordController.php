<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ResetPasswordController extends Controller
{
    /**
     * Proses ubah kata sandi pengguna (Proses 2.3).
     *
     * Berlaku untuk semua role: Operator, Mahasiswa, Dosen PA.
     */
    public function update(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }

        $oldInput = $request->input('current_password') ?? $request->input('kata_sandi_lama');
        $newInput = $request->input('new_password') ?? $request->input('kata_sandi_baru');
        $confirmInput = $request->input('new_password_confirmation') ?? $request->input('kata_sandi_baru_confirmation');

        if (!$oldInput) {
            return back()->withErrors(['current_password' => 'Kata sandi saat ini wajib diisi.', 'kata_sandi_lama' => 'Kata sandi saat ini wajib diisi.']);
        }

        if (!$newInput || strlen($newInput) < 8) {
            return back()->withErrors(['new_password' => 'Kata sandi baru minimal 8 karakter.', 'kata_sandi_baru' => 'Kata sandi baru minimal 8 karakter.']);
        }

        if ($newInput !== $confirmInput) {
            return back()->withErrors(['new_password_confirmation' => 'Konfirmasi kata sandi baru tidak cocok.', 'kata_sandi_baru_confirmation' => 'Konfirmasi kata sandi baru tidak cocok.']);
        }

        $inputOld = trim($oldInput);
        $dbPassword = trim($user->kata_sandi);

        $oldPasswordMatches = Hash::check($inputOld, $dbPassword);

        if (!$oldPasswordMatches) {
            return back()->withErrors([
                'current_password' => 'Kata sandi saat ini yang Anda masukkan salah.',
                'kata_sandi_lama' => 'Kata sandi saat ini yang Anda masukkan salah.',
            ]);
        }

        // Update kata sandi baru (selalu hash)
        $user->kata_sandi = Hash::make($newInput);
        $user->save();

        $targetRoute = match ((int)($user?->role ?? 0)) {
            1 => 'operator.profile.index',
            2 => 'mahasiswa.profile.index',
            3 => 'dosen.profile.index',
            default => 'login',
        };

        return redirect()->route($targetRoute)->with('success', 'Kata sandi berhasil diperbarui.');
    }
}
