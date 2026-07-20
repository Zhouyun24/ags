<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('pages.splash.index', ['redirectUrl' => route('login'), 'navbarVisibility' => '0', 'sidebarVisibility' => '0']);
});

Route::get('/login', function () {
    return view('pages.authentication.login.index', ['navbarVisibility' => '0', 'sidebarVisibility' => '0']);
})->name('login');

Route::get('/operator/daftar', function () {
    return view('pages.authentication.register.index', ['navbarVisibility' => '0', 'sidebarVisibility' => '0']);
})->name('operator.daftar');

Route::get('/operator/import-data', function () {
    return view('pages.authentication.register.import-data.index', ['navbarVisibility' => '0', 'sidebarVisibility' => '0']);
})->name('operator.import-data');

Route::get('/mahasiswa/beranda', function () {
    return view('pages.mahasiswa.beranda.index');
})->name('mahasiswa.beranda.index');

Route::get('/mahasiswa/ajukan-bimbingan', function () {
    return view('pages.mahasiswa.ajukan-bimbingan.index');
})->name('mahasiswa.ajukan-bimbingan.index');

Route::post('/mahasiswa/ajukan-bimbingan', function () {
    return view('pages.mahasiswa.ajukan-bimbingan.index');
})->name('mahasiswa.ajukan-bimbingan.store');

Route::get('/mahasiswa/status-jadwal', function () {
    return view('pages.mahasiswa.status-jadwal.index');
})->name('mahasiswa.status-jadwal.index');

Route::get('/mahasiswa/riwayat-bimbingan', function () {
    return view('pages.mahasiswa.riwayat-bimbingan.index');
})->name('mahasiswa.riwayat-bimbingan.index');

Route::get('/mahasiswa/evaluasi-akademik', function () {
    return view('pages.mahasiswa.evaluasi-akademik.index');
})->name('mahasiswa.evaluasi-akademik.index');

Route::get('/mahasiswa/notifikasi', function () {
    return view('pages.mahasiswa.notifikasi.index');
})->name('mahasiswa.notifikasi.index');

Route::get('/mahasiswa/profile', function () {
    return view('pages.mahasiswa.profile.index');
})->name('mahasiswa.profile.index');

Route::get('/mahasiswa/profile/ubah-kata-sandi', function () {
    return view('pages.mahasiswa.profile.ubah-kata-sandi.index');
})->name('mahasiswa.profile.ubah-kata-sandi.index');

Route::get('/mahasiswa/profile/pengaturan-notifikasi', function () {
    return view('pages.mahasiswa.profile.pengaturan-notifikasi.index');
})->name('mahasiswa.profile.pengaturan-notifikasi.index');

Route::get('/mahasiswa/profile/privasi-keamanan', function () {
    return view('pages.mahasiswa.profile.privasi-keamanan.index');
})->name('mahasiswa.profile.privasi-keamanan.index');