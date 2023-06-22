<?php

namespace App\Http\Controllers\API\V1\Stock;

use App\Domain\Stock\StockRepositories;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StockController extends Controller
{
    protected $repositories;

    public function __construct(StockRepositories $repositories)
    {
        $this->repositories = $repositories;
    }

    /**
     * @OA\Get(
     *     path="/api/v1/stocks/get-all",
     *     tags={"Stocks"},
     *     summary="Get all stocks",
     *     operationId="getAllStocks",
     *     @OA\Response(response="200", description="Success", @OA\JsonContent(
     *         @OA\Property(property="status", type="integer", example=200),
     *         @OA\Property(property="message", type="string", example="Success get all stock"),
     *         @OA\Property(property="data", type="array", @OA\Items(
     *             @OA\Property(property="produk_id", type="string", example="d746a0e2-64e9-48d6-a974-c10c91ad0b56"),
     *             @OA\Property(property="nama_produk", type="string", example="Kemeja Flanel"),
     *             @OA\Property(property="stok_sekarang", type="integer", example=90),
     *             @OA\Property(property="stok_terjual", type="integer", example=4)
     *         ))
     *     ))
     * )
     */

    public function getAll(Request $request)
    {
        try {
            $data = $this->repositories->getAll();
            return $this->apiResponseSuccess($data, 'Success get all stock');
        } catch (\Exception $e) {
            return $this->apiResponseFailed($e->getMessage(), 'Failed get all stock');
        }
    }

    public function index(Request $request)
    {
        return view('stock.index');
    }

}
