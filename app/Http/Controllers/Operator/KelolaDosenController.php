<?php

namespace App\Http\Controllers\Operator;

use App\Helpers\IdGenerator;
use App\Http\Controllers\Controller;
use App\Http\Requests\Operator\StoreDosenRequest;
use App\Http\Requests\Operator\UpdateDosenRequest;
use App\Models\dosen_pa;
use App\Models\pengguna;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class KelolaDosenController extends Controller
{
    /**
     * Tampilkan daftar semua Dosen PA (KK4).
     */
    public function index(\Illuminate\Http\Request $request)
    {
        $query = dosen_pa::with('pengguna')
            ->withCount('mahasiswa')
            ->orderByDesc('created_at');

        if ($request->has('cari') && $request->cari != '') {
            $cari = $request->cari;
            $query->where(function($q) use ($cari) {
                $q->where('nip', 'like', "%{$cari}%")
                  ->orWhereHas('pengguna', function($q2) use ($cari) {
                      $q2->where('nama', 'like', "%{$cari}%");
                  });
            });
        }

        $dosens = $query->get();

        return view('pages.operator.kelola-dosen.index', [
            'dosens' => $dosens,
        ]);
    }

    public function create()
    {
        return view('pages.operator.kelola-dosen.tambah-dosen.index');
    }

    /**
     * Tambah Dosen PA baru beserta akun pengguna (KK4).
     */
    public function store(StoreDosenRequest $request)
    {
        $validated = $request->validated();

        DB::transaction(function () use ($validated) {
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
        });

        return redirect()->route('operator.kelola-dosen.index')
            ->with('success', 'Data Dosen PA berhasil ditambahkan.');
    }

    public function show($nip)
    {
        $dosen = dosen_pa::with('pengguna')->where('nip', $nip)->firstOrFail();
        return view('pages.operator.kelola-dosen.show', compact('dosen'));
    }

    public function edit($nip)
    {
        $dosen = dosen_pa::with('pengguna')->where('nip', $nip)->firstOrFail();
        return view('pages.operator.kelola-dosen.edit-dosen.index', compact('dosen'));
    }

    /**
     * Edit data Dosen PA dan akun pengguna terkait (KK4).
     */
    public function update(UpdateDosenRequest $request, $nip)
    {
        $validated = $request->validated();

        DB::transaction(function () use ($validated, $nip) {
            $dosen = dosen_pa::where('nip', $nip)->firstOrFail();
            $user = pengguna::where('id_pengguna', $dosen->id_pengguna)->firstOrFail();

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
        });

        return redirect()->route('operator.kelola-dosen.index')
            ->with('success', 'Data Dosen PA berhasil diperbarui.');
    }

    /**
     * Hapus data Dosen PA beserta akun pengguna (KK4).
     */
    public function destroy($nip)
    {
        DB::transaction(function () use ($nip) {
            $dosen = dosen_pa::where('nip', $nip)->firstOrFail();
            $user = pengguna::where('id_pengguna', $dosen->id_pengguna)->firstOrFail();

            // Hapus pengguna → cascade akan menghapus dosen_pa via FK
            $user->delete();
        });

        return redirect()->route('operator.kelola-dosen.index')
            ->with('success', 'Data Dosen PA berhasil dihapus.');
    }
    public function import(\Illuminate\Http\Request $request)
    {
        $request->validate([
            "file" => "required|mimes:xlsx,xls,csv"
        ]);

        try {
            \Maatwebsite\Excel\Facades\Excel::import(new \App\Imports\DosenImport, $request->file("file"));
            return redirect()->route("operator.kelola-dosen.index")->with("success", "Data Dosen berhasil diimport.");
        } catch (\Exception $e) {
            return redirect()->back()->with("error", "Terjadi kesalahan saat import data: " . $e->getMessage());
        }
    }
}
