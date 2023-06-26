<?php

namespace App\Models\Mst;

use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    protected $table = 'Mst.produk';
    protected $primaryKey = 'produk_id';

    // Relationships
    public function stok()
    {
        return $this->hasOne(ProdukStok::class, 'produk_id', 'produk_id');
    }
}
