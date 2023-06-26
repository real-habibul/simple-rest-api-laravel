<?php

namespace App\Domain\Order;

use Illuminate\Support\Facades\DB;

class OrderRepositories
{

    public function getAll()
    {
        $query = "SELECT
            p.pesanan_id AS pesanan_id,
            p.no_pesanan AS no_pesanan,
            p.tgl_pesanan AS tgl_pesanan,
            CONCAT(u.nama_depan, ' ', u.nama_belakang) AS nama_lengkap_user,
            SUM(pr.harga * pp.jumlah) AS total_harga,
            SUM(pp.jumlah) AS jumlah_produk
        FROM
            postgres.\"Trx\".pesanan AS p
        JOIN
            postgres.\"Usr\".user AS u ON p.user_id = u.user_id
        JOIN
            postgres.\"Trx\".pesanan_produk AS pp ON p.pesanan_id = pp.pesanan_id
        JOIN
            postgres.\"Mst\".produk AS pr ON pp.produk_id = pr.produk_id
        GROUP BY
            p.pesanan_id,
            p.no_pesanan,
            p.tgl_pesanan,
            u.nama_depan,
            u.nama_belakang";

        return DB::select($query);
    }

}
