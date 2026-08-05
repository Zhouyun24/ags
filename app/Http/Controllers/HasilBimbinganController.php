<?php

namespace App\Http\Controllers;

use App\Helpers\IdGenerator;
use App\Http\Requests\HasilBimbinganRequest;
use App\Models\hasil_bimbingan;
use App\Models\jadwal_bimbingan;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class HasilBimbinganController extends Controller
{
    public function index()
    {
        $nip = Auth::user()->dosenPA?->nip;

        if (!$nip) {
            return view('pages.dosen.hasil-bimbingan.index', [
                'daftarBimbingan' => collect(),
            ]);
        }

        $records = jadwal_bimbingan::where('nip', $nip)
            ->where('status_jadwal', 1)
            ->with([
                'mahasiswa.pengguna',
                'hasil_bimbingan',
            ])
            ->orderByDesc('tanggal_jadwal')
            ->get();

        $daftarBimbingan = $records->map(function ($j) {
            $tanggal = $j->tanggal_jadwal
                ? Carbon::parse($j->tanggal_jadwal)->format('d/m/Y')
                : '-';

            $jam = $j->jam_jadwal
                ? Carbon::parse($j->jam_jadwal)->format('H.i') . ' WIB'
                : '-';

            $hasHasil = $j->hasil_bimbingan !== null;
            $status = $hasHasil ? 'selesai' : 'menunggu';

            $urlAksi = $hasHasil
                ? route('dosen.hasil-bimbingan.edit', $j->hasil_bimbingan->id_hasil)
                : route('dosen.hasil-bimbingan.create', $j->id_jadwal);

            return (object) [
                'id' => $hasHasil ? $j->hasil_bimbingan->id_hasil : $j->id_jadwal,
                'nama' => $j->mahasiswa?->pengguna?->nama ?? '-',
                'nim' => $j->mahasiswa?->nim ?? ($j->nim ?? '-'),
                'topik' => $j->topik_diskusi ?? '-',
                'tanggal' => $tanggal,
                'jam' => $jam,
                'catatan' => $j->hasil_bimbingan?->catatan_bimbingan ?? '-',
                'rekomendasi' => $j->hasil_bimbingan?->arahan_akademik ?? '-',
                'status' => $status,
                'urlAksi' => $urlAksi,
            ];
        });

        return view('pages.dosen.hasil-bimbingan.index', [
            'daftarBimbingan' => $daftarBimbingan,
        ]);
    }

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

        $jadwal->topik_diskusi = $request->validated('topik_diskusi');
        $jadwal->save();

        $hasil = new hasil_bimbingan();
        $hasil->id_hasil = IdGenerator::generateFor(hasil_bimbingan::class);
        $hasil->catatan_bimbingan = $request->validated('catatan_bimbingan');
        $hasil->arahan_akademik = $request->validated('arahan_akademik');
        $hasil->id_jadwal = $id_jadwal;
        $hasil->save();

        return redirect()->route('dosen.hasil-bimbingan.index')->with('success', 'Hasil bimbingan berhasil disimpan.');
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

        if ($hasil->jadwal_bimbingan) {
            $hasil->jadwal_bimbingan->topik_diskusi = $request->validated('topik_diskusi');
            $hasil->jadwal_bimbingan->save();
        }

        $hasil->catatan_bimbingan = $request->validated('catatan_bimbingan');
        $hasil->arahan_akademik = $request->validated('arahan_akademik');
        $hasil->save();

        return redirect()->route('dosen.hasil-bimbingan.index')->with('success', 'Hasil bimbingan berhasil diperbarui.');
    }
}
