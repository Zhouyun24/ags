<?php

namespace App\Http\Controllers;

use App\Helpers\IdGenerator;
use App\Http\Requests\HasilBimbinganRequest;
use App\Models\hasil_bimbingan;
use App\Models\jadwal_bimbingan;
use Illuminate\Support\Facades\Auth;

class HasilBimbinganController extends Controller
{
    public function create($id_jadwal)
    {
        $nip = Auth::user()->dosenPA?->nip;
        $jadwal = jadwal_bimbingan::where('id_jadwal', $id_jadwal)->where('nip', $nip)->where('status_jadwal', 1)->firstOrFail();

        return view('pages.dosen.hasil-bimbingan.tambah.index', ['jadwal' => $jadwal]);
    }

    public function store(HasilBimbinganRequest $request, $id_jadwal)
    {
        $nip = Auth::user()->dosenPA?->nip;
        $jadwal = jadwal_bimbingan::where('id_jadwal', $id_jadwal)->where('nip', $nip)->where('status_jadwal', 1)->firstOrFail();

        if ($jadwal->hasil_bimbingan) {
            return redirect()->back()->with('error', 'Hasil bimbingan untuk jadwal ini sudah ada.');
        }

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
        $nip = Auth::user()->dosenPA?->nip;
        $hasil = hasil_bimbingan::whereHas('jadwal_bimbingan', fn($q) => $q->where('nip', $nip))
            ->where('id_hasil', $id_hasil)->firstOrFail();

        return view('pages.dosen.hasil-bimbingan.edit.index', ['hasil' => $hasil]);
    }

    public function update(HasilBimbinganRequest $request, $id_hasil)
    {
        $nip = Auth::user()->dosenPA?->nip;
        $hasil = hasil_bimbingan::whereHas('jadwal_bimbingan', fn($q) => $q->where('nip', $nip))
            ->where('id_hasil', $id_hasil)->firstOrFail();

        $hasil->catatan_bimbingan = $request->validated('catatan_bimbingan');
        $hasil->arahan_akademik = $request->validated('arahan_akademik');
        $hasil->save();

        return redirect()->back()->with('success', 'Hasil bimbingan berhasil diperbarui.');
    }
}
