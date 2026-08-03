<?php

namespace App\Http\Controllers;

use App\Helpers\IdGenerator;
use App\Http\Requests\PenilaianBimbinganRequest;
use App\Models\hasil_bimbingan;
use App\Models\jadwal_bimbingan;
use App\Models\mahasiswa;
use App\Models\penilaian_bimbingan;
use Illuminate\Support\Facades\Auth;

class PenilaianBimbinganController extends Controller
{
    /**
     * Form input penilaian untuk sebuah hasil bimbingan (KK11).
     */
    public function create($id_hasil)
    {
        $nip = Auth::user()->dosenPA?->nip;

        $hasil = hasil_bimbingan::whereHas('jadwal_bimbingan', fn($q) => $q->where('nip', $nip))
            ->where('id_hasil', $id_hasil)
            ->with('jadwal_bimbingan.mahasiswa.pengguna')
            ->firstOrFail();

        return view('pages.dosen.penilaian-bimbingan.tambah.index', [
            'hasil' => $hasil,
        ]);
    }

    /**
     * Simpan penilaian bimbingan baru (KK11).
     *
     * Proses 5.1: Input Penilaian
     * Proses 5.2: Hitung Nilai Perkembangan = rata-rata (skor_keaktifan + skor_pemahaman)
     * Proses 5.3: Hitung Nilai Bimbingan = rata-rata semua nilai_perkembangan → konversi huruf mutu
     */
    public function store(PenilaianBimbinganRequest $request, $id_hasil)
    {
        $nip = Auth::user()->dosenPA?->nip;

        // Pastikan hasil bimbingan milik dosen yang login
        $hasil = hasil_bimbingan::whereHas('jadwal_bimbingan', fn($q) => $q->where('nip', $nip))
            ->where('id_hasil', $id_hasil)
            ->with('jadwal_bimbingan')
            ->firstOrFail();

        // Cegah penilaian ganda untuk hasil bimbingan yang sama
        if ($hasil->penilaian_bimbingan) {
            return redirect()->back()->with('error', 'Penilaian untuk hasil bimbingan ini sudah ada.');
        }

        $validated = $request->validated();

        // Proses 5.2: Hitung nilai perkembangan
        $nilaiPerkembangan = (int) round(($validated['skor_keaktifan'] + $validated['skor_pemahaman']) / 2);

        // Proses 5.1: Simpan penilaian
        penilaian_bimbingan::create([
            'id_perkembangan' => IdGenerator::generateFor(penilaian_bimbingan::class),
            'skor_keaktifan' => $validated['skor_keaktifan'],
            'skor_pemahaman' => $validated['skor_pemahaman'],
            'nilai_perkembangan' => $nilaiPerkembangan,
            'id_hasil' => $id_hasil,
        ]);

        // Proses 5.3: Hitung & update nilai bimbingan mahasiswa
        $nim = $hasil->jadwal_bimbingan->nim;
        $this->hitungNilaiBimbingan($nim);

        return redirect()->back()->with('success', 'Penilaian bimbingan berhasil disimpan.');
    }

    /**
     * Form edit penilaian bimbingan (KK11).
     */
    public function edit($id_perkembangan)
    {
        $nip = Auth::user()->dosenPA?->nip;

        $penilaian = penilaian_bimbingan::whereHas('hasilBimbingan.jadwal_bimbingan', fn($q) => $q->where('nip', $nip))
            ->where('id_perkembangan', $id_perkembangan)
            ->with('hasilBimbingan.jadwal_bimbingan.mahasiswa.pengguna')
            ->firstOrFail();

        return view('pages.dosen.penilaian-bimbingan.edit.index', [
            'penilaian' => $penilaian,
        ]);
    }

    /**
     * Update penilaian bimbingan (KK11).
     */
    public function update(PenilaianBimbinganRequest $request, $id_perkembangan)
    {
        $nip = Auth::user()->dosenPA?->nip;

        $penilaian = penilaian_bimbingan::whereHas('hasilBimbingan.jadwal_bimbingan', fn($q) => $q->where('nip', $nip))
            ->where('id_perkembangan', $id_perkembangan)
            ->with('hasilBimbingan.jadwal_bimbingan')
            ->firstOrFail();

        $validated = $request->validated();

        // Re-hitung nilai perkembangan
        $nilaiPerkembangan = (int) round(($validated['skor_keaktifan'] + $validated['skor_pemahaman']) / 2);

        $penilaian->skor_keaktifan = $validated['skor_keaktifan'];
        $penilaian->skor_pemahaman = $validated['skor_pemahaman'];
        $penilaian->nilai_perkembangan = $nilaiPerkembangan;
        $penilaian->save();

        // Re-hitung nilai bimbingan mahasiswa
        $nim = $penilaian->hasilBimbingan->jadwal_bimbingan->nim;
        $this->hitungNilaiBimbingan($nim);

        return redirect()->back()->with('success', 'Penilaian bimbingan berhasil diperbarui.');
    }

    /**
     * Proses 5.3: Hitung Nilai Bimbingan mahasiswa.
     *
     * Rata-rata seluruh nilai_perkembangan dari semua penilaian bimbingan mahasiswa,
     * lalu konversi ke huruf mutu.
     */
    private function hitungNilaiBimbingan(string $nim): void
    {
        // Ambil semua penilaian yang terkait dengan jadwal bimbingan mahasiswa ini
        $rataRata = penilaian_bimbingan::whereHas('hasilBimbingan.jadwal_bimbingan', fn($q) => $q->where('nim', $nim))
            ->avg('nilai_perkembangan');

        // Konversi ke huruf mutu
        $hurufMutu = $this->konversiHurufMutu($rataRata);

        // Update nilai_bimbingan di tabel mahasiswa
        mahasiswa::where('nim', $nim)->update(['nilai_bimbingan' => $hurufMutu]);
    }

    /**
     * Konversi nilai rata-rata (skala 1-5) ke huruf mutu.
     */
    private function konversiHurufMutu(?float $nilai): string
    {
        if ($nilai === null) return '-';

        return match (true) {
            $nilai >= 4.5 => 'A',
            $nilai >= 3.5 => 'B',
            $nilai >= 2.5 => 'C',
            $nilai >= 1.5 => 'D',
            default => 'E',
        };
    }
}
