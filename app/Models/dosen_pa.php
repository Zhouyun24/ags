<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class dosen_pa extends Model
{
    protected $table = 'dosen_pas';
    protected $primaryKey = 'nip';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['nip', 'program_studi', 'id_pengguna'];

    public function pengguna() { return $this->belongsTo(pengguna::class, 'id_pengguna'); }
    public function mahasiswa() { return $this->hasMany(mahasiswa::class, 'nip'); }
    public function jadwal_bimbingan() { return $this->hasMany(jadwal_bimbingan::class, 'nip'); }
}
