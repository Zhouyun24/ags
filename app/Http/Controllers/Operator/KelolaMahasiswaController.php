<?php

namespace App\Http\Controllers\Operator;

use App\Helpers\IdGenerator;
use App\Http\Controllers\Controller;
use App\Http\Requests\Operator\StoreMahasiswaRequest;
use App\Http\Requests\Operator\UpdateMahasiswaRequest;
use App\Models\dosen_pa;
use App\Models\mahasiswa;
use App\Models\pengguna;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class KelolaMahasiswaController extends Controller
{
    /**
     * Tampilkan daftar semua Mahasiswa (KK3).
     */
    public function index(\Illuminate\Http\Request $request)
    {
        $query = mahasiswa::with(['pengguna', 'dosenPA.pengguna'])
            ->orderByDesc('created_at');

        if ($request->has('cari') && $request->cari != '') {
            $cari = $request->cari;
            $query->where(function($q) use ($cari) {
                $q->where('nim', 'like', "%{$cari}%")
                  ->orWhereHas('pengguna', function($q2) use ($cari) {
                      $q2->where('nama', 'like', "%{$cari}%");
                  });
            });
        }

        $mahasiswas = $query->get();

        $dosenList = dosen_pa::with('pengguna')->get();

        return view('pages.operator.kelola-mahasiswa.index', [
            'mahasiswas' => $mahasiswas,
            'dosenList' => $dosenList,
        ]);
    }

    public function create()
    {
        $dosenList = dosen_pa::with('pengguna')->get();
        return view('pages.operator.kelola-mahasiswa.tambah-mahasiswa.index', compact('dosenList'));
    }

    /**
     * Tambah Mahasiswa baru beserta akun pengguna (KK3).
     */
    public function store(StoreMahasiswaRequest $request)
    {
        $validated = $request->validated();

        DB::transaction(function () use ($validated) {
            $idPengguna = 'USR_' . IdGenerator::generate();

            // 1. Buat akun pengguna (role = 2 / Mahasiswa)
            $user = pengguna::create([
                'id_pengguna' => $idPengguna,
                'nama' => $validated['nama'],
                'email' => $validated['email'],
                'kata_sandi' => Hash::make($validated['kata_sandi']),
                'nomor_telepon' => $validated['nomor_telepon'] ?? null,
                'role' => 2,
            ]);

            // 2. Buat data mahasiswa
            mahasiswa::create([
                'nim' => $validated['nim'],
                'program_studi' => $validated['program_studi'],
                'semester' => $validated['semester'],
                'nilai_bimbingan' => null,
                'nip' => $validated['nip'] ?? null,
                'id_pengguna' => $user->id_pengguna,
            ]);
        });

        return redirect()->route('operator.kelola-mahasiswa.index')
            ->with('success', 'Data mahasiswa berhasil ditambahkan.');
    }

    public function show($nim)
    {
        $mahasiswa = mahasiswa::with(['pengguna', 'dosenPA.pengguna'])->where('nim', $nim)->firstOrFail();
        return view('pages.operator.kelola-mahasiswa.show', compact('mahasiswa'));
    }

    public function edit($nim)
    {
        $mahasiswa = mahasiswa::with('pengguna')->where('nim', $nim)->firstOrFail();
        $dosenList = dosen_pa::with('pengguna')->get();
        return view('pages.operator.kelola-mahasiswa.edit-mahasiswa.index', compact('mahasiswa', 'dosenList'));
    }

    /**
     * Edit data Mahasiswa dan akun pengguna terkait (KK3).
     */
    public function update(UpdateMahasiswaRequest $request, $nim)
    {
        $validated = $request->validated();

        DB::transaction(function () use ($validated, $nim) {
            $mhs = mahasiswa::where('nim', $nim)->firstOrFail();
            $user = pengguna::where('id_pengguna', $mhs->id_pengguna)->firstOrFail();

            // Update akun pengguna
            $user->nama = $validated['nama'];
            $user->email = $validated['email'];
            $user->nomor_telepon = $validated['nomor_telepon'] ?? $user->nomor_telepon;

            if (!empty($validated['kata_sandi'])) {
                $user->kata_sandi = Hash::make($validated['kata_sandi']);
            }

            $user->save();

            // Update data mahasiswa
            $mhs->program_studi = $validated['program_studi'];
            $mhs->semester = $validated['semester'];
            $mhs->nip = $validated['nip'] ?? $mhs->nip;
            $mhs->save();
        });

        return redirect()->route('operator.kelola-mahasiswa.index')
            ->with('success', 'Data mahasiswa berhasil diperbarui.');
    }

    /**
     * Hapus data Mahasiswa beserta akun pengguna (KK3).
     */
    public function destroy($nim)
    {
        DB::transaction(function () use ($nim) {
            $mhs = mahasiswa::where('nim', $nim)->firstOrFail();
            $user = pengguna::where('id_pengguna', $mhs->id_pengguna)->firstOrFail();

            // Hapus pengguna → cascade akan menghapus mahasiswa via FK
            $user->delete();
        });

        return redirect()->route('operator.kelola-mahasiswa.index')
            ->with('success', 'Data mahasiswa berhasil dihapus.');
    }
}
