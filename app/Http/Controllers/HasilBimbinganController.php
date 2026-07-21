<?php

namespace App\Http\Controllers;

use App\Http\Requests\HasilBimbinganRequest;
use App\Models\hasil_bimbingan;

class HasilBimbinganController extends Controller
{
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
