<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class penilaian_bimbingan extends Model
{
    protected $table = 'penilaian_bimbingans';
    protected $primaryKey = 'id_perkembangan';
    public $incrementing = false;   
    protected $keyType = 'string';

    protected $fillable = ['id_perkembangan', 'skor_keaktifan', 'skor_pemahaman', 'nilai_perkembangan', 'id_hasil'];

    public function hasilBimbingan() { return $this->belongsTo(hasil_bimbingan::class, 'id_hasil'); }
}
