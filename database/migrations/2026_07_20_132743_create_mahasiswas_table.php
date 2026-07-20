<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('mahasiswas', function (Blueprint $table) {
            $table->string('nim')->primary();
            $table->string('program_studi');
            $table->integer('semester');
            $table->string('nilai_bimbingan')->nullable();
            
            // Foreign Keys
            $table->string('nip')->nullable();
            $table->foreign('nip')->references('nip')->on('dosen_pas')->onDelete('set null');

            $table->string('id_pengguna');
            $table->foreign('id_pengguna')->references('id_pengguna')->on('penggunas')->onDelete('cascade');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mahasiswas');
    }
};
