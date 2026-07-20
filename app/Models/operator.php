<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class operator extends Model
{
    protected $table = 'operators';
    protected $primaryKey = 'id_operator';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['id_operator', 'id_pengguna'];

    public function pengguna() { return $this->belongsTo(pengguna::class, 'id_pengguna'); }
}
