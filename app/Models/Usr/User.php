<?php

namespace App\Models\Usr;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'Usr.user';
    protected $primaryKey = 'user_id';

    // Relationships
    public function pesanan()
    {
        return $this->hasMany(\App\Models\Trx\Pesanan::class, 'user_id', 'user_id');
    }

}
