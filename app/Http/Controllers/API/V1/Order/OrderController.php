<?php

namespace App\Http\Controllers\API\V1\Order;

use App\Domain\Order\OrderRepositories;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    protected $repositories;

    public function __construct(OrderRepositories $repositories)
    {
        $this->repositories = $repositories;
    }

    /**
     * @OA\Get(
     *     path="/api/v1/orders/get-all",
     *     tags={"Orders"},
     *     summary="Get all orders",
     *     operationId="getAllOrders",
     *     @OA\Response(
     *         response="200",
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="integer", example=200),
     *             @OA\Property(property="message", type="string", example="Success get all orders"),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(
     *                     @OA\Property(property="pesanan_id", type="string", example="635c0bc6-a8b3-4888-8d96-d4e7e1eb4537"),
     *                     @OA\Property(property="no_pesanan", type="string", example="PES001"),
     *                     @OA\Property(property="tgl_pesanan", type="string", format="datetime", example="2023-06-22 18:02:34.670668"),
     *                     @OA\Property(property="nama_lengkap_user", type="string", example="John Doe"),
     *                     @OA\Property(property="total_harga", type="integer", example=350),
     *                     @OA\Property(property="jumlah_produk", type="integer", example=3)
     *                 )
     *             )
     *         )
     *     ),
     * )
     */
    public function getAll(Request $request)
    {
        try {
            $data = $this->repositories->getAll();
            return $this->apiResponseSuccess($data, 'Success get all orders');
        } catch (\Exception $e) {
            return $this->apiResponseFailed($e->getMessage(), 'Failed get all orders');
        }
    }

    public function index(Request $request)
    {
        return view('order.index');
    }
}
