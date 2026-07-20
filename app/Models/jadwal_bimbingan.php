<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class jadwal_bimbingan extends Model
{
    protected $table = 'jadwal_bimbingans';
    protected $primaryKey = 'id_jadwal';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['id_jadwal', 'topik_diskusi', 'tanggal_jadwal', 'jam_jadwal', 'status_jadwal', 'nim', 'nip'];

    public function mahasiswa() { return $this->belongsTo(mahasiswa::class, 'nim'); }
    public function dosenPA() { return $this->belongsTo(dosen_pa::class, 'nip'); }
    public function hasil_bimbingan() { return $this->hasOne(hasil_bimbingan::class, 'id_jadwal'); }
}
