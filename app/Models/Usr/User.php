<?php

namespace App\Models\Usr;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'Usr.user';
    protected $primaryKey = 'user_id';
    public $timestamps = false;

    protected $casts = [
        'user_id' => 'string',
    ];

    protected $fillable = [
        'nama_depan',
        'nama_belakang',
        'alamat',
        'nomor_hp',
        'jk',
        'tgl_lahir'
    ];

    // Relationships
    public function pesanan()
    {
        return $this->hasMany(\App\Models\Trx\Pesanan::class, 'user_id', 'user_id');
    }

}
