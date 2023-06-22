<?php

namespace App\Domain\Stock;

use Illuminate\Support\Facades\DB;

class StockRepositories
{

    public function getAll()
    {
        $query = "SELECT p.produk_id, p.nama AS nama_produk, ps.stok AS stok_sekarang,
                COALESCE(SUM(pp.jumlah), 0) AS stok_terjual
                FROM hrm.\"Mst\".produk AS p
                LEFT JOIN hrm.\"Mst\".produk_stok AS ps ON p.produk_id = ps.produk_id
                LEFT JOIN hrm.\"Trx\".pesanan_produk AS pp ON p.produk_id = pp.produk_id
                GROUP BY p.produk_id, p.nama, ps.stok";

        return DB::connection('pgsql')->select($query);
    }

}
