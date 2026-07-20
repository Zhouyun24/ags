<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class pengguna extends Model
{  
   protected $table = 'penggunas';
    protected $primaryKey = 'id_pengguna';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['id_pengguna', 'nama', 'email', 'kata_sandi', 'nomor_telepon', 'role'];

    public function operator() { return $this->hasOne(operator::class, 'id_pengguna'); }
    public function mahasiswa() { return $this->hasOne(mahasiswa::class, 'id_pengguna'); }
    public function dosenPA() { return $this->hasOne(dosen_pa::class, 'id_pengguna'); }
}
