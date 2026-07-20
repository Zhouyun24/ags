<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class hasil_bimbingan extends Model
{
    protected $table = 'hasil_bimbingans';
    protected $primaryKey = 'id_hasil';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['id_hasil', 'catatan_bimbingan', 'arahan_akademik', 'id_jadwal'];

    public function jadwal_bimbingan() { return $this->belongsTo(jadwal_bimbingan::class, 'id_jadwal'); }
    public function penilaian_bimbingan() { return $this->hasOne(penilaian_bimbingan::class, 'id_hasil'); }
}
