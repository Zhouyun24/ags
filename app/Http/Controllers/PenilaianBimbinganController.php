<?php

namespace App\Http\Controllers;

use App\Helpers\IdGenerator;
use App\Http\Requests\PenilaianBimbinganRequest;
use App\Models\hasil_bimbingan;
use App\Models\penilaian_bimbingan;
use Illuminate\Support\Facades\Auth;

class PenilaianBimbinganController extends Controller
{
    public function create($id_hasil)
    {
        $nip = Auth::user()->dosenPA?->nip;

        $hasil = hasil_bimbingan::where('id_hasil', $id_hasil)
            ->whereHas('jadwal_bimbingan', function ($query) use ($nip) {
                $query->where('nip', $nip);
            })->firstOrFail();

        if ($hasil->penilaian_bimbingan) {
            return redirect()->route('dosen.evaluasi-mahasiswa.index')->with('error', 'Penilaian untuk hasil ini sudah ada.');
        }

        return view('pages.dosen.penilaian-bimbingan.tambah.index', compact('hasil'));
    }

    public function store(PenilaianBimbinganRequest $request, $id_hasil)
    {
        $nip = Auth::user()->dosenPA?->nip;

        $hasil = hasil_bimbingan::where('id_hasil', $id_hasil)
            ->whereHas('jadwal_bimbingan', function ($query) use ($nip) {
                $query->where('nip', $nip);
            })->firstOrFail();

        if ($hasil->penilaian_bimbingan) {
            return redirect()->route('dosen.evaluasi-mahasiswa.index')->with('error', 'Penilaian untuk hasil ini sudah ada.');
        }

        $validated = $request->validated();
        
        $nilaiPerkembangan = ($validated['skor_keaktifan'] + $validated['skor_pemahaman']) / 2;

        penilaian_bimbingan::create([
            'id_perkembangan' => IdGenerator::generateFor(penilaian_bimbingan::class),
            'skor_keaktifan' => $validated['skor_keaktifan'],
            'skor_pemahaman' => $validated['skor_pemahaman'],
            'nilai_perkembangan' => $nilaiPerkembangan,
            'id_hasil' => $id_hasil,
        ]);

        return redirect()->route('dosen.evaluasi-mahasiswa.index')->with('success', 'Penilaian bimbingan berhasil disimpan.');
    }

    public function edit($id_perkembangan)
    {
        $nip = Auth::user()->dosenPA?->nip;

        $penilaian = penilaian_bimbingan::where('id_perkembangan', $id_perkembangan)
            ->whereHas('hasilBimbingan.jadwal_bimbingan', function ($query) use ($nip) {
                $query->where('nip', $nip);
            })->firstOrFail();

        return view('pages.dosen.penilaian-bimbingan.edit.index', compact('penilaian'));
    }

    public function update(PenilaianBimbinganRequest $request, $id_perkembangan)
    {
        $nip = Auth::user()->dosenPA?->nip;

        $penilaian = penilaian_bimbingan::where('id_perkembangan', $id_perkembangan)
            ->whereHas('hasilBimbingan.jadwal_bimbingan', function ($query) use ($nip) {
                $query->where('nip', $nip);
            })->firstOrFail();

        $validated = $request->validated();
        
        $nilaiPerkembangan = ($validated['skor_keaktifan'] + $validated['skor_pemahaman']) / 2;

        $penilaian->update([
            'skor_keaktifan' => $validated['skor_keaktifan'],
            'skor_pemahaman' => $validated['skor_pemahaman'],
            'nilai_perkembangan' => $nilaiPerkembangan,
        ]);

        return redirect()->route('dosen.evaluasi-mahasiswa.index')->with('success', 'Penilaian bimbingan berhasil diperbarui.');
    }
}
