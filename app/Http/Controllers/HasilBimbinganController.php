<?php

namespace App\Http\Controllers;

use App\Helpers\IdGenerator;
use App\Http\Requests\HasilBimbinganRequest;
use App\Models\hasil_bimbingan;
use App\Models\jadwal_bimbingan;

class HasilBimbinganController extends Controller
{
    public function create($id_jadwal)
    {
        $jadwal = jadwal_bimbingan::findOrFail($id_jadwal);

        return view('pages.dosen.hasil-bimbingan.tambah.index', ['jadwal' => $jadwal]);
    }

    public function store(HasilBimbinganRequest $request, $id_jadwal)
    {
        jadwal_bimbingan::findOrFail($id_jadwal);

        $hasil = new hasil_bimbingan();
        $hasil->id_hasil = IdGenerator::generateFor(hasil_bimbingan::class);
        $hasil->catatan_bimbingan = $request->validated('catatan_bimbingan');
        $hasil->arahan_akademik = $request->validated('arahan_akademik');
        $hasil->id_jadwal = $id_jadwal;
        $hasil->save();

        return redirect()->back()->with('success', 'Hasil bimbingan berhasil disimpan.');
    }

    public function edit($id_hasil)
    {
        $hasil = hasil_bimbingan::findOrFail($id_hasil);

        return view('pages.dosen.hasil-bimbingan.edit.index', ['hasil' => $hasil]);
    }

    public function update(HasilBimbinganRequest $request, $id_hasil)
    {
        $hasil = hasil_bimbingan::findOrFail($id_hasil);
        $hasil->catatan_bimbingan = $request->validated('catatan_bimbingan');
        $hasil->arahan_akademik = $request->validated('arahan_akademik');
        $hasil->save();

        return redirect()->back()->with('success', 'Hasil bimbingan berhasil diperbarui.');
    }
}
