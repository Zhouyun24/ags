<?php

namespace App\Http\Controllers;

use App\Http\Requests\KeputusanJadwalRequest;
use App\Models\jadwal_bimbingan;
use Illuminate\Support\Facades\Auth;

class PersetujuanJadwalController extends Controller
{
    public function update(KeputusanJadwalRequest $request, $id_jadwal)
    {
        $nip = Auth::user()->dosenPA?->nip;

        $jadwal = jadwal_bimbingan::where('id_jadwal', $id_jadwal)
            ->where('nip', $nip)
            ->firstOrFail();

        $jadwal->status_jadwal = $request->validated('status_jadwal');
        $jadwal->save();

        return redirect()->back()->with('success', 'Status jadwal berhasil diperbarui.');
    }
}
