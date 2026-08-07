<?php

namespace App\Http\Controllers\Operator;

use App\Helpers\IdGenerator;
use App\Http\Controllers\Controller;
use App\Http\Requests\Operator\StoreOperatorRequest;
use App\Http\Requests\Operator\UpdateOperatorRequest;
use App\Models\operator;
use App\Models\pengguna;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class KelolaOperatorController extends Controller
{
    /**
     * Tampilkan daftar semua Operator (KK2).
     */
    public function index(\Illuminate\Http\Request $request)
    {
        $query = operator::with('pengguna')->orderByDesc('created_at');

        if ($request->has('cari') && $request->cari != '') {
            $cari = $request->cari;
            $query->whereHas('pengguna', function ($q) use ($cari) {
                $q->where('nama', 'like', "%{$cari}%")
                  ->orWhere('id_pengguna', 'like', "%{$cari}%");
            });
        }

        $operators = $query->get();

        return view('pages.operator.kelola-operator.index', [
            'operators' => $operators,
        ]);
    }

    public function create()
    {
        return view('pages.operator.kelola-operator.tambah-operator.index');
    }

    /**
     * Tambah Operator baru beserta akun pengguna (KK2).
     */
    public function store(StoreOperatorRequest $request)
    {
        $validated = $request->validated();

        DB::transaction(function () use ($validated) {
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
        });

        return redirect()->route('operator.kelola-operator.index')
            ->with('success', 'Data operator berhasil ditambahkan.');
    }

    public function show($id_pengguna)
    {
        $operator = operator::with('pengguna')->where('id_pengguna', $id_pengguna)->firstOrFail();
        return view('pages.operator.kelola-operator.show', compact('operator'));
    }

    public function edit($id_pengguna)
    {
        $operator = operator::with('pengguna')->where('id_pengguna', $id_pengguna)->firstOrFail();
        return view('pages.operator.kelola-operator.edit-operator.index', compact('operator'));
    }

    /**
     * Edit data Operator dan akun pengguna terkait (KK2).
     */
    public function update(UpdateOperatorRequest $request, $id_pengguna)
    {
        $validated = $request->validated();

        DB::transaction(function () use ($validated, $id_pengguna) {
            $user = pengguna::where('id_pengguna', $id_pengguna)
                ->where('role', 1)
                ->firstOrFail();

            $user->nama = $validated['nama'];
            $user->email = $validated['email'];
            $user->nomor_telepon = $validated['nomor_telepon'] ?? $user->nomor_telepon;

            if (!empty($validated['kata_sandi'])) {
                $user->kata_sandi = Hash::make($validated['kata_sandi']);
            }

            $user->save();
        });

        return redirect()->route('operator.kelola-operator.index')
            ->with('success', 'Data operator berhasil diperbarui.');
    }

    /**
     * Hapus data Operator beserta akun pengguna (KK2 - cascade via FK).
     */
    public function destroy($id_pengguna)
    {
        DB::transaction(function () use ($id_pengguna) {
            $user = pengguna::where('id_pengguna', $id_pengguna)
                ->where('role', 1)
                ->firstOrFail();

            // Cascade delete: operator record dihapus otomatis oleh FK onDelete('cascade')
            $user->delete();
        });

        return redirect()->route('operator.kelola-operator.index')
            ->with('success', 'Data operator berhasil dihapus.');
    }
}
