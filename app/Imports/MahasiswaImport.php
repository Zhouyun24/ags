<?php

namespace App\Imports;

use App\Models\mahasiswa;
use App\Models\pengguna;
use App\Helpers\IdGenerator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class MahasiswaImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        DB::transaction(function () use ($rows) {
            foreach ($rows as $row) {
                // Pastikan ada data nim dan nama
                if (empty($row['nim']) || empty($row['nama'])) {
                    continue;
                }

                $idPengguna = 'USR_' . IdGenerator::generate();
                $defaultPassword = 'password123';

                // Buat pengguna
                $user = pengguna::create([
                    'id_pengguna' => $idPengguna,
                    'nama' => $row['nama'],
                    'email' => $row['email'] ?? $row['nim'] . '@student.example.com',
                    'kata_sandi' => Hash::make($defaultPassword),
                    'nomor_telepon' => $row['nomor_telepon'] ?? null,
                    'role' => 2,
                ]);

                $nip = $row['nip'] ?? null;
                if (!empty($nip)) {
                    $dosenExists = \App\Models\dosen_pa::where('nip', $nip)->exists();
                    if (!$dosenExists) {
                        throw new \Exception("Gagal import: NIP {$nip} pada data mahasiswa {$row['nama']} tidak ditemukan. Harap import data Dosen terkait terlebih dahulu.");
                    }
                }

                // Buat mahasiswa
                mahasiswa::create([
                    'nim' => $row['nim'],
                    'program_studi' => $row['program_studi'] ?? '-',
                    'semester' => $row['semester'] ?? 1,
                    'nip' => $nip,
                    'id_pengguna' => $user->id_pengguna,
                ]);
            }
        });
    }
}
