<?php

namespace App\Models\Mst;

use Illuminate\Database\Eloquent\Model;

class ProdukStok extends Model
{
    protected $table = 'Mst.produk_stok';
    protected $primaryKey = 'produk_id';

    // Relationships
    public function produk()
    {
        return $this->belongsTo(Produk::class, 'produk_id', 'produk_id');
    }

}
