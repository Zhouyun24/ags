<?php

namespace App\Http\Controllers\Operator;

use App\Helpers\IdGenerator;
use App\Http\Controllers\Controller;
use App\Http\Requests\Operator\StoreOperatorRequest;
use App\Http\Requests\Operator\UpdateOperatorRequest;
use App\Models\operator;
use App\Models\pengguna;
use Illuminate\Support\Facades\Hash;

class KelolaOperatorController extends Controller
{
    /**
     * Tampilkan daftar semua Operator (KK2).
     */
    public function index()
    {
        $operators = operator::with('pengguna')->orderByDesc('created_at')->get();

        return view('pages.operator.kelola-operator.index', [
            'operators' => $operators,
        ]);
    }

    /**
     * Tambah Operator baru beserta akun pengguna (KK2).
     */
    public function store(StoreOperatorRequest $request)
    {
        $validated = $request->validated();

        $idPengguna = 'USR_' . IdGenerator::generate();

        $user = pengguna::create([
            'id_pengguna' => $idPengguna,
            'nama' => $validated['nama'],
            'email' => $validated['email'],
            'kata_sandi' => Hash::make($validated['kata_sandi']),
            'nomor_telepon' => $validated['nomor_telepon'] ?? null,
            'role' => 1,
        ]);

        operator::create([
            'id_operator' => 'OP_' . IdGenerator::generate(),
            'id_pengguna' => $user->id_pengguna,
        ]);

        return redirect()->route('operator.kelola-operator.index')
            ->with('success', 'Data operator berhasil ditambahkan.');
    }

    /**
     * Edit data Operator dan akun pengguna terkait (KK2).
     */
    public function update(UpdateOperatorRequest $request, $id_pengguna)
    {
        $user = pengguna::where('id_pengguna', $id_pengguna)
            ->where('role', 1)
            ->firstOrFail();

        $validated = $request->validated();

        $user->nama = $validated['nama'];
        $user->email = $validated['email'];
        $user->nomor_telepon = $validated['nomor_telepon'] ?? $user->nomor_telepon;

        if (!empty($validated['kata_sandi'])) {
            $user->kata_sandi = Hash::make($validated['kata_sandi']);
        }

        $user->save();

        return redirect()->route('operator.kelola-operator.index')
            ->with('success', 'Data operator berhasil diperbarui.');
    }

    /**
     * Hapus data Operator beserta akun pengguna (KK2 - cascade via FK).
     */
    public function destroy($id_pengguna)
    {
        $user = pengguna::where('id_pengguna', $id_pengguna)
            ->where('role', 1)
            ->firstOrFail();

        // Cascade delete: operator record dihapus otomatis oleh FK onDelete('cascade')
        $user->delete();

        return redirect()->route('operator.kelola-operator.index')
            ->with('success', 'Data operator berhasil dihapus.');
    }
}
