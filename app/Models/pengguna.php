<?php

namespace App\Models;

// 1. UBAH IMPORT DARI Model KE Authenticatable
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

// 2. PASTI KAN EXTENDS Authenticatable (BUKAN Model)
class pengguna extends Authenticatable
{  
    use Notifiable;

    protected $table = 'penggunas';
    protected $primaryKey = 'id_pengguna';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_pengguna', 
        'nama', 
        'email', 
        'kata_sandi', 
        'nomor_telepon', 
        'role'
    ];

    protected $hidden = [
        'kata_sandi',
    ];

    // 3. MEMBERITAHU LARAVEL NAMA KOLOM PASSWORD
    public function getAuthPassword()
    {
        return $this->kata_sandi;
    }

    // Relasi yang sudah ada
    public function operator() { return $this->hasOne(operator::class, 'id_pengguna'); }
    public function mahasiswa() { return $this->hasOne(mahasiswa::class, 'id_pengguna'); }
    public function dosenPA() { return $this->hasOne(dosen_pa::class, 'id_pengguna'); }
}