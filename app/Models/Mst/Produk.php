<?php

namespace App\Models\Mst;

use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    protected $table = 'Mst.produk';
    protected $primaryKey = 'produk_id';
    public $timestamps = false;

    protected $casts = [
        'produk_id' => 'string',
    ];

    protected $fillable = [
        'nama',
        'brand',
        'harga',
        'slug',
        'tgl_dibuat',
        'tgl_diubah',
        'tgl_release',
        'tgl_dihapus'
    ];

    // Relationships
    public function stok()
    {
        return $this->hasOne(ProdukStok::class, 'produk_id', 'produk_id');
    }
}
