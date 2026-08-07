<?php

namespace App\Imports;

use App\Models\dosen_pa;
use App\Models\pengguna;
use App\Helpers\IdGenerator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class DosenImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        DB::transaction(function () use ($rows) {
            foreach ($rows as $row) {
                // Pastikan ada data nip dan nama
                if (empty($row['nip']) || empty($row['nama'])) {
                    continue;
                }

                $idPengguna = 'USR_' . IdGenerator::generate();
                $defaultPassword = 'password123';

                // Buat pengguna
                $user = pengguna::create([
                    'id_pengguna' => $idPengguna,
                    'nama' => $row['nama'],
                    'email' => $row['email'] ?? $row['nip'] . '@dosen.example.com',
                    'kata_sandi' => Hash::make($defaultPassword),
                    'nomor_telepon' => $row['nomor_telepon'] ?? null,
                    'role' => 3,
                ]);

                // Buat dosen_pa
                dosen_pa::create([
                    'nip' => $row['nip'],
                    'program_studi' => $row['program_studi'] ?? '-',
                    'id_pengguna' => $user->id_pengguna,
                ]);
            }
        });
    }
}
