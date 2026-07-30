<?php

namespace App\Http\Controllers\Operator;

use App\Helpers\IdGenerator;
use App\Http\Controllers\Controller;
use App\Http\Requests\Operator\StoreDosenRequest;
use App\Http\Requests\Operator\UpdateDosenRequest;
use App\Models\dosen_pa;
use App\Models\pengguna;
use Illuminate\Support\Facades\Hash;

class KelolaDosenController extends Controller
{
    /**
     * Tampilkan daftar semua Dosen PA (KK4).
     */
    public function index()
    {
        $dosens = dosen_pa::with('pengguna')
            ->orderByDesc('created_at')
            ->get();

        return view('pages.operator.kelola-dosen.index', [
            'dosens' => $dosens,
        ]);
    }

    /**
     * Tambah Dosen PA baru beserta akun pengguna (KK4).
     */
    public function store(StoreDosenRequest $request)
    {
        $validated = $request->validated();

        $idPengguna = 'USR_' . IdGenerator::generate();

        // 1. Buat akun pengguna (role = 3 / Dosen PA)
        $user = pengguna::create([
            'id_pengguna' => $idPengguna,
            'nama' => $validated['nama'],
            'email' => $validated['email'],
            'kata_sandi' => Hash::make($validated['kata_sandi']),
            'nomor_telepon' => $validated['nomor_telepon'] ?? null,
            'role' => 3,
        ]);

        // 2. Buat data dosen PA
        dosen_pa::create([
            'nip' => $validated['nip'],
            'program_studi' => $validated['program_studi'],
            'id_pengguna' => $user->id_pengguna,
        ]);

        return redirect()->route('operator.kelola-dosen.index')
            ->with('success', 'Data Dosen PA berhasil ditambahkan.');
    }

    /**
     * Edit data Dosen PA dan akun pengguna terkait (KK4).
     */
    public function update(UpdateDosenRequest $request, $nip)
    {
        $dosen = dosen_pa::where('nip', $nip)->firstOrFail();
        $user = pengguna::where('id_pengguna', $dosen->id_pengguna)->firstOrFail();

        $validated = $request->validated();

        // Update akun pengguna
        $user->nama = $validated['nama'];
        $user->email = $validated['email'];
        $user->nomor_telepon = $validated['nomor_telepon'] ?? $user->nomor_telepon;

        if (!empty($validated['kata_sandi'])) {
            $user->kata_sandi = Hash::make($validated['kata_sandi']);
        }

        $user->save();

        // Update data dosen
        $dosen->program_studi = $validated['program_studi'];
        $dosen->save();

        return redirect()->route('operator.kelola-dosen.index')
            ->with('success', 'Data Dosen PA berhasil diperbarui.');
    }

    /**
     * Hapus data Dosen PA beserta akun pengguna (KK4).
     */
    public function destroy($nip)
    {
        $dosen = dosen_pa::where('nip', $nip)->firstOrFail();
        $user = pengguna::where('id_pengguna', $dosen->id_pengguna)->firstOrFail();

        // Hapus pengguna → cascade akan menghapus dosen_pa via FK
        $user->delete();

        return redirect()->route('operator.kelola-dosen.index')
            ->with('success', 'Data Dosen PA berhasil dihapus.');
    }
}
