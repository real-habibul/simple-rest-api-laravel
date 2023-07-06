<?php

namespace App\Http\Controllers\API\V1\MasterData;

use App\Http\Controllers\Controller;
use App\Models\Trx\PesananProduk;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class PesananProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @OA\Schema(
     *    schema="PesananProduk",
     *    title="PesananProduk",
     *    description="Model of PesananProduk",
     *    @OA\Property(property="pesanan_produk_id", type="string", example="15c4028b-a6a7-4a2e-ae4e-69ea53d21599"),
     *    @OA\Property(property="pesanan_id", type="string", example="68aed5db-c3fa-491e-85fa-c7134dbb4a9d"),
     *    @OA\Property(property="produk_id", type="string", example="d746a0e2-64e9-48d6-a974-c10c91ad0b56"),
     *    @OA\Property(property="jumlah", type="integer", example=1),
     *    @OA\Property(property="tgl_dibuat", type="string", example="2021-01-01 00:00:00"),
     *    @OA\Property(property="tgl_diubah", type="string", example="2021-01-01 00:00:00"),
     *    @OA\Property(property="tgl_dihapus", type="string", example="2021-01-01 00:00:00"),
     *    ),
     *
     * @OA\Get(
     *    path="/api/v1/master-data/pesanan-produk",
     *   tags={"Master Data - Pesanan Produk"},
     *    summary="Get all pesanan produk",
     *    operationId="get pesanan produk /api/v1/master-data/pesanan-produk",
     *    @OA\Response(response="200", description="Success", @OA\JsonContent(
     *       @OA\Property(property="status", type="integer", example=200),
     *       @OA\Property(property="message", type="string", example="Success get all pesanan produk"),
     *       @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/PesananProduk"))
     *    ))
     * )
     *
     */
    public function index()
    {
        try {
            $pesananProduk = PesananProduk::all();
            return $this->apiResponseSuccess($pesananProduk, 'Success get all pesanan produk');
        } catch (QueryException $e) {
            return $this->apiResponseFailed($e->getMessage(), 'Failed get all pesanan produk');
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
     *    path="/api/v1/master-data/pesanan-produk",
     *   tags={"Master Data - Pesanan Produk"},
     *    summary="Store pesanan produk",
     *    operationId="store pesanan produk /api/v1/master-data/pesanan-produk",
     *    @OA\RequestBody(
     *       required=true,
     *       description="Store pesanan produk",
     *       @OA\JsonContent(
     *           required={"pesanan_id", "produk_id", "jumlah"},
     *           @OA\Property(property="pesanan_id", type="string", example="68aed5db-c3fa-491e-85fa-c7134dbb4a9d"),
     *           @OA\Property(property="produk_id", type="string", example="d746a0e2-64e9-48d6-a974-c10c91ad0b56"),
     *           @OA\Property(property="jumlah", type="integer", example=2),
     *       ),
     *    ),
     *    @OA\Response(response="201", description="Success", @OA\JsonContent(
     *       @OA\Property(property="status", type="integer", example=201),
     *       @OA\Property(property="message", type="string", example="Success store pesanan produk"),
     *       @OA\Property(property="data", ref="#/components/schemas/PesananProduk")
     *        )
     *     )
     * )
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'pesanan_id' => 'required|string',
            'produk_id' => 'required|string',
            'jumlah' => 'required|integer',
            'tgl_dibuat' => 'date',
            'tgl_diubah' => 'nullable|date',
            'tgl_dihapus' => 'nullable|date',
        ]);

        if (empty($data['tgl_dibuat'])) {
            $data['tgl_dibuat'] = date('Y-m-d H:i:s');
        }

        try {
            $pesananProduk = PesananProduk::create($data);
            return $this->apiResponseSuccess($pesananProduk, 'Success create pesanan produk');
        } catch (QueryException $e) {
            return $this->apiResponseFailed($e->getMessage(), 'Failed create pesanan produk');
        } catch (\Exception $e) {
            return $this->apiResponseFailed($e->getMessage(), 'Failed create pesanan produk');
        }

    }

    /**
     * Display the specified resource.
     *
     * @OA\Get(
     *    path="/api/v1/master-data/pesanan-produk/{pesanan_produk}",
     *   tags={"Master Data - Pesanan Produk"},
     *    summary="Get pesanan produk by id",
     *    operationId="get pesanan produk by id /api/v1/master-data/pesanan-produk/{pesanan_produk}",
     *    @OA\Parameter(
     *        name="pesanan_produk",
     *        description="Pesanan Produk Id",
     *        required=true,
     *        in="path",
     *        @OA\Schema(type="string")
     *    ),
     *    @OA\Response(response="200", description="Success", @OA\JsonContent(
     *       @OA\Property(property="status", type="integer", example=200),
     *       @OA\Property(property="message", type="string", example="Success get pesanan produk by id"),
     *       @OA\Property(property="data", ref="#/components/schemas/PesananProduk")
     *        )
     *     )
     * )
     *
     */
    public function show(PesananProduk $pesananProduk)
    {
        try {
            return $this->apiResponseSuccess($pesananProduk, 'Success get pesanan produk');
        } catch (QueryException $e) {
            return $this->apiResponseFailed($e->getMessage(), 'Failed get pesanan produk');
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
     *   path="/api/v1/master-data/pesanan-produk/{pesanan_produk}",
     *   tags={"Master Data - Pesanan Produk"},
     *    summary="Update pesanan produk by id",
     *    operationId="update pesanan produk by id /api/v1/master-data/pesanan-produk/{pesanan_produk}",
     *    @OA\Parameter(
     *        name="pesanan_produk",
     *        description="Pesanan Produk Id",
     *        required=true,
     *        in="path",
     *        @OA\Schema(type="string")
     *    ),
     *    @OA\RequestBody(
     *       required=true,
     *       description="Update pesanan produk by id",
     *       @OA\JsonContent(
     *           required={"pesanan_id", "produk_id", "jumlah"},
     *           @OA\Property(property="pesanan_id", type="string", example="68aed5db-c3fa-491e-85fa-c7134dbb4a9d"),
     *           @OA\Property(property="produk_id", type="string", example="d746a0e2-64e9-48d6-a974-c10c91ad0b56"),
     *           @OA\Property(property="jumlah", type="integer", example=2),
     *       ),
     *    ),
     *    @OA\Response(response="200", description="Success", @OA\JsonContent(
     *       @OA\Property(property="status", type="integer", example=200),
     *       @OA\Property(property="message", type="string", example="Success update pesanan produk"),
     *       @OA\Property(property="data", ref="#/components/schemas/PesananProduk")
     *        )
     *     )
     * )
     */
    public function update(Request $request, PesananProduk $pesananProduk)
    {
        try {
            $data = $request->validate([
                'pesanan_id' => 'required|string',
                'produk_id' => 'required|string',
                'jumlah' => 'required|integer',
                'tgl_dibuat' => 'date',
                'tgl_diubah' => 'nullable|date',
                'tgl_dihapus' => 'nullable|date',
            ]);

            if (empty($data['tgl_diubah'])) {
                $data['tgl_diubah'] = date('Y-m-d H:i:s');
            }

            $pesananProduk->update($data);

            return $this->apiResponseSuccess($pesananProduk, 'Success update pesanan produk');
        } catch (QueryException $e) {
            return $this->apiResponseFailed($e->getMessage(), 'Failed update pesanan produk');
        } catch (\Exception $e) {
            return $this->apiResponseFailed($e->getMessage(), 'Failed update pesanan produk');
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
