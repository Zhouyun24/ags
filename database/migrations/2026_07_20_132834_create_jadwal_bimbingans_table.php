<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('jadwal_bimbingans', function (Blueprint $table) {
            $table->string('id_jadwal')->primary();
            $table->string('topik_diskusi');
            $table->date('tanggal_jadwal');
            $table->time('jam_jadwal');
            $table->integer('status_jadwal');

            // Foreign Keys
            $table->string('nim');
            $table->foreign('nim')->references('nim')->on('mahasiswas')->onDelete('cascade');

            $table->string('nip');
            $table->foreign('nip')->references('nip')->on('dosen_pas')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jadwal_bimbingans');
    }
};
