<?php

namespace App\Http\Controllers\API\V1\MasterData;

use App\Http\Controllers\Controller;
use App\Models\Trx\Pesanan;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class PesananController extends Controller
{
    /**
     * Display a listing of the resource.
     * 
     * @OA\Schema(
     *    schema="Pesanan",
     *    title="Pesanan",
     *    description="Model of Pesanan",
     *    @OA\Property(property="pesanan_id", type="string", example="635c0bc6-a8b3-4888-8d96-d4e7e1eb4537"),
     *    @OA\Property(property="user_id", type="string", example="621d1723-b376-4e29-baaf-25fcbf3e7595"),
     *    @OA\Property(property="tgl_pesanan", type="string", example="2023-06-22 00:00:00"),
     *    @OA\Property(property="kode_voucher", type="string", example="FREE"),
     *    @OA\Property(property="tgl_pembayaran_lunas", type="string", example="2021-01-01 00:00:00"),
     *    @OA\Property(property="tgl_dibatalkan", type="string", example="2021-01-01 00:00:00"),
     *    @OA\Property(property="no_pesanan", type="string", example="PES001"),
     *    ),
     * 
     * @OA\Get(
     *     path="/api/v1/master-data/pesanan",
     *     tags={"Master Data - Pesanan"},
     *     summary="Get all pesanan",
     *     operationId="get pesanan /api/v1/master-data/pesanan",
     *     @OA\Response(response="200", description="Success", @OA\JsonContent(
     *         @OA\Property(property="status", type="integer", example=200),
     *         @OA\Property(property="message", type="string", example="Success get all pesanan"),
     *         @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/Pesanan"))
     *    ))
     * )
     */
    public function index()
    {
        try {
            $pesanan = Pesanan::all();
            return $this->apiResponseSuccess($pesanan, 'Success get all produk');
        } catch (QueryException $e) {
            return $this->apiResponseFailed($e->getMessage(), 'Failed get all produk');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     * 
     * @OA\Post(
     *    path="/api/v1/master-data/pesanan",
     *    tags={"Master Data - Pesanan"},
     *    summary="Store Pesanan",
     *    operationId="store pesanan",
     * 
     *    @OA\RequestBody(
     *       required=true,
     *       description="Store Pesanan",
     *       @OA\JsonContent(
     *         @OA\Property(property="user_id", type="string", example="621d1723-b376-4e29-baaf-25fcbf3e7595"),
     *         @OA\Property(property="tgl_pesanan", type="string", example="2023-06-22 00:00:00"),
     *         @OA\Property(property="kode_voucher", type="string", example="FREE"),
     *         @OA\Property(property="tgl_pembayaran_lunas", type="string", example="2021-01-01 00:00:00"),
     *         @OA\Property(property="tgl_dibatalkan", type="string", example="2021-01-01 00:00:00"),
     *         @OA\Property(property="no_pesanan", type="string", example="PES001"),
     *       ),
     *    ),
     * 
     *    @OA\Response(
     *       response=200,
     *       description="Success",
     *       @OA\JsonContent(
     *         @OA\Property(property="status", type="integer", example=200),
     *         @OA\Property(property="message", type="string", example="Success create pesanan"),
     *         @OA\Property(property="data", type="object", ref="#/components/schemas/Pesanan"),
     *       ),
     *    ),
     * )
     */
    public function store(Request $request)
    {
        try {

            

            $data = $request->validate( [
                'user_id' => 'required|string',
                'tgl_pesanan' => 'date',
                'kode_voucher' => 'string|max:20',
                'tgl_pembayaran_lunas' => 'date',
                'tgl_dibatalkan' => 'date',
                'no_pesanan' => 'string|max:10',
            ]);

            if (empty($data['tgl_pesanan'])) {
                $data['tgl_pesanan'] = date('Y-m-d H:i:s');
            }

            $pesanan = Pesanan::create($data);

            return $this->apiResponseSuccess($pesanan, 'Success create pesanan');
        } catch (ValidationException $e) {
            return $this->apiResponseFailed($e->getMessage(), 'Failed create pesanan');
        }
    }

    /**
     * Display the specified resource.
     * 
     * @OA\Get(
     *    path="/api/v1/master-data/pesanan/{id}",
     *     tags={"Master Data - Pesanan"},
     *     summary="Get Pesanan by ID",
     *     operationId="get pesanan by id",
     * 
     *     @OA\Parameter(
     *        name="id",
     *        in="path",
     *        description="Pesanan ID",
     *        required=true,
     *        @OA\Schema(
     *           type="string"
     *        )
     *     ),
     * 
     *     @OA\Response(response="200", description="Success", @OA\JsonContent(
     *         @OA\Property(property="status", type="integer", example=200),
     *         @OA\Property(property="message", type="string", example="Success get pesanan by id"),
     *         @OA\Property(property="data", type="object", ref="#/components/schemas/Pesanan")
     *    ))
     * )
     */
    public function show(Pesanan $pesanan)
    {
        try {
            return $this->apiResponseSuccess($pesanan, 'Success get pesanan');
        } catch (QueryException $e) {
            return $this->apiResponseFailed($e->getMessage(), 'Failed get pesanan');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     * 
     * @OA\Put(
     *    path="/api/v1/master-data/pesanan/{id}",
     *    tags={"Master Data - Pesanan"},
     *    summary="Update Pesanan",
     *    operationId="update pesanan",
     * 
     *    @OA\Parameter(
     *       name="id",
     *       in="path",
     *       description="Pesanan ID",
     *       required=true,
     *       @OA\Schema(
     *          type="string"
     *       )
     *    ),
     * 
     *    @OA\RequestBody(
     *       required=true,
     *       description="Update Pesanan",
     *       @OA\JsonContent(
     *         @OA\Property(property="user_id", type="string", example="621d1723-b376-4e29-baaf-25fcbf3e7595"),
     *         @OA\Property(property="tgl_pesanan", type="string", example="2023-06-22 00:00:00"),
     *         @OA\Property(property="kode_voucher", type="string", example="FREE"),
     *         @OA\Property(property="tgl_pembayaran_lunas", type="string", example="2021-01-01 00:00:00"),
     *         @OA\Property(property="tgl_dibatalkan", type="string", example="2021-01-01 00:00:00"),
     *         @OA\Property(property="no_pesanan", type="string", example="PES001"),
     *       ),
     *    ),
     * 
     *    @OA\Response(
     *       response=200,
     *       description="Success",
     *       @OA\JsonContent(
     *         @OA\Property(property="status", type="integer", example=200),
     *         @OA\Property(property="message", type="string", example="Success update pesanan"),
     *         @OA\Property(property="data", type="object", ref="#/components/schemas/Pesanan"),
     *       ),
     *    ),
     * )
     */
    public function update(Request $request, Pesanan $pesanan)
    {
        try {
            $data = $request->validate( [
                'user_id' => 'required|string',
                'tgl_pesanan' => 'date',
                'kode_voucher' => 'string|max:20',
                'tgl_pembayaran_lunas' => 'date',
                'tgl_dibatalkan' => 'date',
                'no_pesanan' => 'string|max:10',
            ]);

            $pesanan->update($data);

            return $this->apiResponseSuccess($pesanan, 'Success update pesanan');
        } catch (ValidationException $e) {
            return $this->apiResponseFailed($e->getMessage(), 'Failed update pesanan');
        } catch (QueryException $e) {
            return $this->apiResponseFailed($e->getMessage(), 'Failed update pesanan');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
