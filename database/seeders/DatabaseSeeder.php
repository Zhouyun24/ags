<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\pengguna;
use App\Models\operator;
use App\Models\dosen_pa;
use App\Models\mahasiswa;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Operator (role = 1)
        $opUser = pengguna::updateOrCreate(
            ['email' => 'op@gmail.com'],
            [
                'id_pengguna' => 'USR_OP001',
                'nama' => 'Operator System',
                'kata_sandi' => Hash::make('password123'),
                'nomor_telepon' => '081234567890',
                'role' => 1,
            ]
        );

        operator::updateOrCreate(
            ['id_operator' => 'OP001'],
            [
                'id_pengguna' => $opUser->id_pengguna,
            ]
        );

        // 2. Dosen PA (role = 3)
        $dosUser = pengguna::updateOrCreate(
            ['email' => 'dos@gmail.com'],
            [
                'id_pengguna' => 'USR_DOS001',
                'nama' => 'Dr. Dosen Pembimbing, M.Kom.',
                'kata_sandi' => Hash::make('password123'),
                'nomor_telepon' => '081234567891',
                'role' => 3,
            ]
        );

        $dosenPA = dosen_pa::updateOrCreate(
            ['nip' => '198501012010121001'],
            [
                'program_studi' => 'Teknik Informatika',
                'id_pengguna' => $dosUser->id_pengguna,
            ]
        );

        // 3. Mahasiswa (role = 2)
        $mhsUser = pengguna::updateOrCreate(
            ['email' => 'mhs@gmail.com'],
            [
                'id_pengguna' => 'USR_MHS001',
                'nama' => 'Mahasiswa Utama',
                'kata_sandi' => Hash::make('password123'),
                'nomor_telepon' => '081234567892',
                'role' => 2,
            ]
        );

        mahasiswa::updateOrCreate(
            ['nim' => '220101001'],
            [
                'program_studi' => 'Teknik Informatika',
                'semester' => 4,
                'nilai_bimbingan' => 'A',
                'nip' => $dosenPA->nip,
                'id_pengguna' => $mhsUser->id_pengguna,
            ]
        );
    }
}

