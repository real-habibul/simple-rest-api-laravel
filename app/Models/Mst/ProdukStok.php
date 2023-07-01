<?php

namespace App\Models\Mst;

use Illuminate\Database\Eloquent\Model;

class ProdukStok extends Model
{
    protected $table = 'Mst.produk_stok';
    protected $primaryKey = 'produk_id';
    public $timestamps = false;

    protected $casts = [
        'produk_id' => 'string',
    ];

    protected $fillable = [
        'produk_id',
        'stok',
        'tgl_diubah'
    ];

    // Relationships
    public function produk()
    {
        return $this->belongsTo(Produk::class, 'produk_id', 'produk_id');
    }

}
