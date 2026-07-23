<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\HasilBimbinganController;
use App\Http\Controllers\PersetujuanJadwalController;

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
});

// Route Logout (Harus sudah login)
Route::post('/logout', [LoginController::class, 'logout'])
    ->name('logout')
    ->middleware('auth');


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

});


/*
|--------------------------------------------------------------------------
| 2. MAHASISWA ROUTES (Role: 2)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:2'])->prefix('mahasiswa')->name('mahasiswa.')->group(function () {
    
    // Beranda & Bimbingan
    Route::get('/beranda', function () {
        return view('pages.mahasiswa.beranda.index');
    })->name('beranda.index');

    Route::get('/ajukan-bimbingan', function () {
        return view('pages.mahasiswa.ajukan-bimbingan.index');
    })->name('ajukan-bimbingan.index');

    Route::post('/ajukan-bimbingan', function () {
        return view('pages.mahasiswa.ajukan-bimbingan.index');
    })->name('ajukan-bimbingan.store');

    Route::get('/status-jadwal', function () {
        return view('pages.mahasiswa.status-jadwal.index');
    })->name('status-jadwal.index');

    Route::get('/riwayat-bimbingan', function () {
        return view('pages.mahasiswa.riwayat-bimbingan.index');
    })->name('riwayat-bimbingan.index');

    Route::get('/evaluasi-akademik', function () {
        return view('pages.mahasiswa.evaluasi-akademik.index');
    })->name('evaluasi-akademik.index');

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
    
    // Beranda Dosen
    Route::get('/beranda', function () {
        return view('pages.dosen.beranda.index');
    })->name('beranda.index');

    // Persetujuan Jadwal
    Route::get('/persetujuan-jadwal', function () {
        return view('pages.dosen.persetujuan-jadwal.index');
    })->name('persetujuan-jadwal.index');

    Route::patch('/persetujuan-jadwal/{id_jadwal}', [PersetujuanJadwalController::class, 'update'])
        ->name('persetujuan-jadwal.update');

    // Evaluasi Mahasiswa
    Route::get('/evaluasi-mahasiswa', function () {
        return view('pages.dosen.evaluasi-mahasiswa.index');
    })->name('evaluasi-mahasiswa.index');

    // Hasil Bimbingan
    Route::get('/hasil-bimbingan/tambah/{id_jadwal}', [HasilBimbinganController::class, 'create'])
        ->name('hasil-bimbingan.create');

    Route::post('/hasil-bimbingan/tambah/{id_jadwal}', [HasilBimbinganController::class, 'store'])
        ->name('hasil-bimbingan.store');

    Route::get('/hasil-bimbingan/edit/{id_hasil}', [HasilBimbinganController::class, 'edit'])
        ->name('hasil-bimbingan.edit');

    Route::patch('/hasil-bimbingan/{id_hasil}', [HasilBimbinganController::class, 'update'])
        ->name('hasil-bimbingan.update');

});