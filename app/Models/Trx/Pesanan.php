<?php

namespace App\Models\Trx;

use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    protected $table = 'Trx.pesanan';
    protected $primaryKey = 'pesanan_id';
    public $timestamps = false;

    protected $casts = [
        'pesanan_id' => 'string',
        'user_id' => 'string',
    ];

    protected $fillable = [
        'user_id',
        'tgl_pesanan',
        'kode_voucher',
        'tgl_pembayaran_lunas',
        'tgl_dibatalkan',
        'no_pesanan'
    ];

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
