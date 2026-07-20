<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('penggunas', function (Blueprint $table) {
            $table->string('id_pengguna')->primary();
            $table->string('nama');
            $table->string('email')->unique();
            $table->string('kata_sandi');
            $table->string('nomor_telepon')->nullable();
            $table->integer('role'); // 1. Operator, 2. Mahasiswa , 3. Dosen PA
            $table->timestamps();
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penggunas');
    }
};
