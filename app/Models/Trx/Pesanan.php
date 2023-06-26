<?php

namespace App\Models\Trx;

use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    protected $table = 'Trx.pesanan';
    protected $primaryKey = 'pesanan_id';

    // Relationships
    public function user()
    {
        return $this->belongsTo(\App\Models\Usr\User::class, 'user_id', 'user_id');
    }

    public function pesananProduk()
    {
        return $this->hasMany(PesananProduk::class, 'pesanan_id', 'pesanan_id');
    }

}
