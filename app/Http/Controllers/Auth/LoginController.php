<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\pengguna;

class LoginController extends Controller
{
    /**
     * Tampilkan halaman formulir login.
     */
    public function showLoginForm()
    {
        return view('pages.authentication.login.index', [
            'navbarVisibility' => '0',
            'sidebarVisibility' => '0'
        ]);
    }

    /**
     * Proses autentikasi/login pengguna.
     */
    public function login(Request $request)
    {
        // 1. Validasi input dari form
        $request->validate([
            'email'      => 'required|email',
            'kata_sandi' => 'required',
        ], [
            'email.required'      => 'Email wajib diisi.',
            'email.email'         => 'Format email tidak valid.',
            'kata_sandi.required' => 'Kata sandi wajib diisi.',
        ]);

        // 2. Cari data pengguna berdasarkan email (dengan TRIM untuk mengabaikan spasi/enter dari phpMyAdmin)
        $email = trim($request->email);
        $user = pengguna::whereRaw('TRIM(email) = ?', [$email])->first();


        // 3. Cek keberadaan akun & cocokkan kata_sandi (Plain Text atau Bcrypt Hash)
        $passwordMatches = false;
        if ($user) {
            $inputPassword = trim($request->kata_sandi);
            $dbPassword = trim($user->kata_sandi);

            if ($inputPassword === $dbPassword) {
                $passwordMatches = true;
            } else {
                try {
                    $passwordMatches = Hash::check($inputPassword, $dbPassword);
                } catch (\Throwable $e) {
                    $passwordMatches = false;
                }
            }
        }


        if ($user && $passwordMatches) {
            // Login-kan pengguna ke dalam Session bawaan Laravel
            Auth::login($user, $request->boolean('remember'));
            $request->session()->regenerate();

            // 4. Redirect sesuai Role Pengguna (1 = Operator, 2 = Mahasiswa, 3 = Dosen PA)
            $targetUrl = match ((int)$user->role) {
                1 => route('operator.daftar'),
                2 => route('mahasiswa.beranda.index'),
                3 => route('dosen.beranda.index'),
                default => abort(403, 'Role pengguna tidak valid.'),
            };

            $intended = session()->get('url.intended');
            if ($intended && !str_contains($intended, '/login') && $intended !== url('/')) {
                return redirect()->intended($targetUrl);
            }

            session()->forget('url.intended');
            return redirect()->to($targetUrl);
        }

        // 5. Jika kombinasi email / kata_sandi salah
        return back()->withErrors([
            'email' => 'Email atau kata sandi yang Anda masukkan salah.',
        ])->onlyInput('email');
    }

    /**
     * Proses logout pengguna.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}