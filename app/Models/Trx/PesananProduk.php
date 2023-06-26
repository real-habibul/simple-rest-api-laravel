<?php

namespace App\Models\Trx;

use Illuminate\Database\Eloquent\Model;

class PesananProduk extends Model
{
    protected $table = 'Trx.pesanan_produk';
    protected $primaryKey = 'pesanan_produk_id';

    // Relationships
    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class, 'pesanan_id', 'pesanan_id');
    }

    public function produk()
    {
        return $this->belongsTo(\App\Models\Mst\Produk::class, 'produk_id', 'produk_id');
    }

}
