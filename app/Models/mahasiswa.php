<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class mahasiswa extends Model
{
    protected $table = 'mahasiswas';
    protected $primaryKey = 'nim';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['nim', 'program_studi', 'semester', 'nilai_bimbingan', 'nip', 'id_pengguna'];

    public function pengguna() { return $this->belongsTo(pengguna::class, 'id_pengguna'); }
    public function dosenPA() { return $this->belongsTo(dosen_pa::class, 'nip'); }
    public function jadwal_bimbingan() { return $this->hasMany(jadwal_bimbingan::class, 'nim'); }
}
