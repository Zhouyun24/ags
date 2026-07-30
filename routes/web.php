<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\BerandaController;
use App\Http\Controllers\AjukanBimbinganController;
use App\Http\Controllers\StatusJadwalController;
use App\Http\Controllers\RiwayatBimbinganController;
use App\Http\Controllers\HasilBimbinganController;
use App\Http\Controllers\PersetujuanJadwalController;
use App\Http\Controllers\PenilaianBimbinganController;
use App\Http\Controllers\EvaluasiAkademikController;
use App\Http\Controllers\Operator\KelolaOperatorController;
use App\Http\Controllers\Operator\KelolaMahasiswaController;
use App\Http\Controllers\Operator\KelolaDosenController;
use App\Http\Controllers\Operator\MonitoringController;
use App\Http\Controllers\Dosen\DashboardDosenController;
use App\Http\Controllers\Dosen\PersetujuanJadwalDosenController;

use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Public & Guest Routes (Tanpa Auth / Sebelum Login)
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    if (Auth::check()) {
        $user = Auth::user();
        return match ((int)$user->role) {
            1 => redirect()->route('operator.daftar'),
            2 => redirect()->route('mahasiswa.beranda.index'),
            3 => redirect()->route('dosen.beranda.index'),
            default => redirect()->route('login'),
        };
    }

    return view('pages.splash.index', [
        'redirectUrl' => route('login'), 
        'navbarVisibility' => '0', 
        'sidebarVisibility' => '0'
    ]);
});

// Route Khusus Tamu (Hanya bisa diakses jika BELUM login)
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);

    // Registrasi Operator (KK1)
    Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
});

// Route Logout (Harus sudah login)
Route::post('/logout', [LoginController::class, 'logout'])
    ->name('logout')
    ->middleware('auth');

// Route Ubah Kata Sandi (Semua Role - Proses 2.3)
Route::middleware('auth')->post('/ubah-kata-sandi', [ResetPasswordController::class, 'update'])
    ->name('ubah-kata-sandi.update');


/*
|--------------------------------------------------------------------------
| 1. OPERATOR ROUTES (Role: 1)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:1'])->prefix('operator')->name('operator.')->group(function () {
    
    Route::get('/daftar', function () {
        return view('pages.authentication.register.index', [
            'navbarVisibility' => '0', 
            'sidebarVisibility' => '0'
        ]);
    })->name('daftar');

    Route::get('/import-data', function () {
        return view('pages.authentication.register.import-data.index', [
            'navbarVisibility' => '0', 
            'sidebarVisibility' => '0'
        ]);
    })->name('import-data');

    // --- Kelola Data Operator (KK2) ---
    Route::get('/kelola-operator', [KelolaOperatorController::class, 'index'])->name('kelola-operator.index');
    Route::post('/kelola-operator', [KelolaOperatorController::class, 'store'])->name('kelola-operator.store');
    Route::put('/kelola-operator/{id_pengguna}', [KelolaOperatorController::class, 'update'])->name('kelola-operator.update');
    Route::delete('/kelola-operator/{id_pengguna}', [KelolaOperatorController::class, 'destroy'])->name('kelola-operator.destroy');

    // --- Kelola Data Mahasiswa (KK3) ---
    Route::get('/kelola-mahasiswa', [KelolaMahasiswaController::class, 'index'])->name('kelola-mahasiswa.index');
    Route::post('/kelola-mahasiswa', [KelolaMahasiswaController::class, 'store'])->name('kelola-mahasiswa.store');
    Route::put('/kelola-mahasiswa/{nim}', [KelolaMahasiswaController::class, 'update'])->name('kelola-mahasiswa.update');
    Route::delete('/kelola-mahasiswa/{nim}', [KelolaMahasiswaController::class, 'destroy'])->name('kelola-mahasiswa.destroy');

    // --- Kelola Data Dosen PA (KK4) ---
    Route::get('/kelola-dosen', [KelolaDosenController::class, 'index'])->name('kelola-dosen.index');
    Route::post('/kelola-dosen', [KelolaDosenController::class, 'store'])->name('kelola-dosen.store');
    Route::put('/kelola-dosen/{nip}', [KelolaDosenController::class, 'update'])->name('kelola-dosen.update');
    Route::delete('/kelola-dosen/{nip}', [KelolaDosenController::class, 'destroy'])->name('kelola-dosen.destroy');

    // --- Monitoring Data Bimbingan (KK14) ---
    Route::get('/monitoring/jadwal', [MonitoringController::class, 'jadwal'])->name('monitoring.jadwal');
    Route::get('/monitoring/hasil', [MonitoringController::class, 'hasil'])->name('monitoring.hasil');
    Route::get('/monitoring/penilaian', [MonitoringController::class, 'penilaian'])->name('monitoring.penilaian');

    // --- Hapus Jadwal Bimbingan (KK15) ---
    Route::delete('/monitoring/jadwal/{id_jadwal}', [MonitoringController::class, 'destroyJadwal'])->name('monitoring.jadwal.destroy');

});


/*
|--------------------------------------------------------------------------
| 2. MAHASISWA ROUTES (Role: 2)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:2'])->prefix('mahasiswa')->name('mahasiswa.')->group(function () {
    
    // Beranda & Bimbingan
    Route::get('/beranda', [BerandaController::class, 'index'])->name('beranda.index');

    Route::get('/ajukan-bimbingan', [AjukanBimbinganController::class, 'create'])
        ->name('ajukan-bimbingan.index');

    Route::post('/ajukan-bimbingan', [AjukanBimbinganController::class, 'store'])
        ->name('ajukan-bimbingan.store');

    Route::get('/status-jadwal', [StatusJadwalController::class, 'index'])
        ->name('status-jadwal.index');

    Route::get('/riwayat-bimbingan', [RiwayatBimbinganController::class, 'index'])
        ->name('riwayat-bimbingan.index');

    // Evaluasi Akademik / Penilaian Perkembangan (KK12)
    Route::get('/evaluasi-akademik', [EvaluasiAkademikController::class, 'index'])
        ->name('evaluasi-akademik.index');

    Route::get('/notifikasi', function () {
        return view('pages.mahasiswa.notifikasi.index');
    })->name('notifikasi.index');

    // Profile & Pengaturan
    Route::get('/profile', function () {
        return view('pages.mahasiswa.profile.index');
    })->name('profile.index');

    Route::get('/profile/ubah-kata-sandi', function () {
        return view('pages.mahasiswa.profile.ubah-kata-sandi.index');
    })->name('profile.ubah-kata-sandi.index');

    Route::get('/profile/pengaturan-notifikasi', function () {
        return view('pages.mahasiswa.profile.pengaturan-notifikasi.index');
    })->name('profile.pengaturan-notifikasi.index');

    Route::get('/profile/privasi-keamanan', function () {
        return view('pages.mahasiswa.profile.privasi-keamanan.index');
    })->name('profile.privasi-keamanan.index');

});


/*
|--------------------------------------------------------------------------
| 3. DOSEN PA ROUTES (Role: 3)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:3'])->prefix('dosen')->name('dosen.')->group(function () {
    
    // Beranda Dosen / Dashboard Analisis (KK13)
    Route::get('/beranda', [DashboardDosenController::class, 'index'])->name('beranda.index');

    // Persetujuan Jadwal (KK7)
    Route::get('/persetujuan-jadwal', [PersetujuanJadwalDosenController::class, 'index'])
        ->name('persetujuan-jadwal.index');

    Route::patch('/persetujuan-jadwal/{id_jadwal}', [PersetujuanJadwalController::class, 'update'])
        ->name('persetujuan-jadwal.update');

    // Evaluasi Mahasiswa
    Route::get('/evaluasi-mahasiswa', function () {
        return view('pages.dosen.evaluasi-mahasiswa.index');
    })->name('evaluasi-mahasiswa.index');

    // Hasil Bimbingan (KK9)
    Route::get('/hasil-bimbingan/tambah/{id_jadwal}', [HasilBimbinganController::class, 'create'])
        ->name('hasil-bimbingan.create');

    Route::post('/hasil-bimbingan/tambah/{id_jadwal}', [HasilBimbinganController::class, 'store'])
        ->name('hasil-bimbingan.store');

    Route::get('/hasil-bimbingan/edit/{id_hasil}', [HasilBimbinganController::class, 'edit'])
        ->name('hasil-bimbingan.edit');

    Route::patch('/hasil-bimbingan/{id_hasil}', [HasilBimbinganController::class, 'update'])
        ->name('hasil-bimbingan.update');

    // Penilaian Bimbingan (KK11)
    Route::get('/penilaian/tambah/{id_hasil}', [PenilaianBimbinganController::class, 'create'])
        ->name('penilaian.create');

    Route::post('/penilaian/tambah/{id_hasil}', [PenilaianBimbinganController::class, 'store'])
        ->name('penilaian.store');

    Route::get('/penilaian/edit/{id_perkembangan}', [PenilaianBimbinganController::class, 'edit'])
        ->name('penilaian.edit');

    Route::patch('/penilaian/{id_perkembangan}', [PenilaianBimbinganController::class, 'update'])
        ->name('penilaian.update');

});