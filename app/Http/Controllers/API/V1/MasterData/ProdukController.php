<?php

namespace App\Http\Controllers\API\V1\MasterData;

use App\Http\Controllers\Controller;
use App\Models\Mst\Produk;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ProdukController extends Controller
{
    
    /**
     * Get data all produk
     * 
     * @OA\Get(
     *     path="/api/v1/master-data/produk",
     *     tags={"Master Data - Produk"},
     *     summary="Get all produk",
     *     operationId="get produk /api/v1/master-data/produk",
     *     @OA\Response(response="200", description="Success", @OA\JsonContent(
     *         @OA\Property(property="status", type="integer", example=200),
     *         @OA\Property(property="message", type="string", example="Success get all produk"),
     *         @OA\Property(property="data", type="array", @OA\Items(
     *         @OA\Property(property="produk_id", type="string", example="47d0ae85-17c6-4b80-b2d7-0efa89cf968f"),
     *         @OA\Property(property="nama", type="string", example="Kemeja Flanel"),
     *         @OA\Property(property="brand", type="string", example="Uniqlo"),
     *         @OA\Property(property="harga", type="integer", example=200000),
     *         @OA\Property(property="slug", type="string", example="kemeja-flanel"),
     *         @OA\Property(property="tgl_dibuat", type="string", example="2021-01-01 00:00:00"),
     *         @OA\Property(property="tgl_diubah", type="string", example="2021-01-01 00:00:00"),
     *         @OA\Property(property="tgl_release", type="string", example="2021-01-01 00:00:00"),
     *         @OA\Property(property="tgl_dihapus", type="string", example="2021-01-01 00:00:00")
     *          ))
     *     ))
     * )
     */

    public function index()
    {
        try {
            $produk = Produk::all();
            return $this->apiResponseSuccess($produk, 'Success get all produk');
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
     *     path="/api/v1/master-data/produk",
     *     tags={"Master Data - Produk"},
     *     summary="Create a new produk",
     *     operationId="post produk /api/v1/master-data/produk",
     *     @OA\RequestBody(
     *         required=true,
     *         description="Produck data",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="nama", type="string"),
     *             @OA\Property(property="brand", type="string"),
     *             @OA\Property(property="harga", type="number"),
     *         )
     *     ),
     *     @OA\Response(response="200", description="Success create new produk", @OA\JsonContent(
     *         @OA\Property(property="status", type="integer", example=200),
     *         @OA\Property(property="message", type="string", example="Success get all produk"),
     *         @OA\Property(property="data", type="array", @OA\Items(
     *         @OA\Property(property="produk_id", type="string", example="47d0ae85-17c6-4b80-b2d7-0efa89cf968f"),
     *         @OA\Property(property="nama", type="string", example="Kemeja Flanel"),
     *         @OA\Property(property="brand", type="string", example="Uniqlo"),
     *         @OA\Property(property="harga", type="integer", example=200000),
     *         @OA\Property(property="slug", type="string", example="kemeja-flanel"),
     *         @OA\Property(property="tgl_dibuat", type="string", example="2021-01-01 00:00:00"),
     *         @OA\Property(property="tgl_diubah", type="string", example="2021-01-01 00:00:00"),
     *         @OA\Property(property="tgl_release", type="string", example="2021-01-01 00:00:00"),
     *         @OA\Property(property="tgl_dihapus", type="string", example="2021-01-01 00:00:00")
     *          ))
     *     )),
     *     @OA\Response(response="400", description="Failed create new produk") 
     * )
     */

    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'nama' => 'required',
                'brand' => 'required',
                'harga' => 'required|numeric',
            ]);

            if ($request->slug == null) {
                $data['slug'] = \Str::slug($request->nama);
            }

            $data['tgl_dibuat'] = date('Y-m-d H:i:s');

            $produk = Produk::create($data);
            return $this->apiResponseSuccess($produk, 'Success create new produk');
        } catch (ValidationException $e) {
            return $this->apiResponseFailed($e->validator->errors()->first(), 'Failed create new produk');
        } catch (QueryException $e) {
            return $this->apiResponseFailed($e->getMessage(), 'Failed create new produk');
        }
    }

    /**
     * Get a specific produk by produk_id
     * 
     * @OA\Get(
     *     path="/api/v1/master-data/produk/{produk}",
     *     tags={"Master Data - Produk"},
     *     summary="Get a specific produk",
     *     operationId="get produk by id /api/v1/master-data/produk/{produk}",
     *     @OA\Parameter(
     *         name="produk",
     *         in="path",
     *         required=true,
     *         description="Produk ID",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response="200", description="Success", @OA\JsonContent(
     *         @OA\Property(property="status", type="integer", example=200),
     *         @OA\Property(property="message", type="string", example="Success get produk")
     *     ))
     * )
     */
    public function show(Produk $produk)
    {
        try {
            return $this->apiResponseSuccess($produk, 'Success get produk');
        } catch (QueryException $e) {
            return $this->apiResponseFailed($e->getMessage(), 'Failed get produk');
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
     * Update a specific produk by produk_id
     * 
     * @OA\Put(
     *     path="/api/v1/master-data/produk/{produk}",
     *     tags={"Master Data - Produk"},
     *     summary="Update a specific produk",
     *     operationId="update produk /api/v1/master-data/produk/{produk}",
     *     @OA\Parameter(
     *         name="produk",
     *         in="path",
     *         required=true,
     *         description="Produk ID",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="nama", type="string"),
     *             @OA\Property(property="brand", type="string"),
     *             @OA\Property(property="harga", type="number"),
     *             @OA\Property(property="slug", type="string"),
     *         )
     *     ),
     *     @OA\Response(response="200", description="Success", @OA\JsonContent(
     *         @OA\Property(property="status", type="integer", example=200),
     *         @OA\Property(property="message", type="string", example="Success get all produk"),
     *         @OA\Property(property="data", type="array", @OA\Items(
     *         @OA\Property(property="produk_id", type="string", example="47d0ae85-17c6-4b80-b2d7-0efa89cf968f"),
     *         @OA\Property(property="nama", type="string", example="Kemeja Flanel"),
     *         @OA\Property(property="brand", type="string", example="Uniqlo"),
     *         @OA\Property(property="harga", type="integer", example=200000),
     *         @OA\Property(property="slug", type="string", example="kemeja-flanel"),
     *         @OA\Property(property="tgl_dibuat", type="string", example="2021-01-01 00:00:00"),
     *         @OA\Property(property="tgl_diubah", type="string", example="2021-01-01 00:00:00"),
     *         @OA\Property(property="tgl_release", type="string", example="2021-01-01 00:00:00"),
     *         @OA\Property(property="tgl_dihapus", type="string", example="2021-01-01 00:00:00")
     *          ))
     *     ))
     * )
     */

    public function update(Request $request, Produk $produk)
    {
        try {
            $data = $request->validate([
                'nama' => 'required',
                'brand' => 'required',
                'harga' => 'required|numeric',
            ]);

            if ($request->slug == null) {
                $data['slug'] = \Str::slug($request->nama);
            }

            $data['tgl_diubah'] = date('Y-m-d H:i:s');

            $produk->update($data);
            return $this->apiResponseSuccess($produk, 'Success update produk');
        } catch (ValidationException $e) {
            return $this->apiResponseFailed($e->validator->errors()->first(), 'Failed update produk');
        } catch (QueryException $e) {
            return $this->apiResponseFailed($e->getMessage(), 'Failed update produk');
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
