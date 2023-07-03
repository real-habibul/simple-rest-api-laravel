<?php

namespace App\Http\Controllers\API\V1\MasterData;

use App\Http\Controllers\Controller;
use App\Models\Mst\Produk;
use App\Models\Mst\ProdukStok;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class ProdukStokController extends Controller
{
    /**
     * Get all data produk stok
     *
     * @OA\Schema(
     *     schema="ProdukStok",
     *     title="Produk Stok",
     *     description="Model of Produk Stok",
     *     @OA\Property(property="produk_id", type="string", example="47d0ae85-17c6-4b80-b2d7-0efa89cf968f"),
     *     @OA\Property(property="stok", type="number", example="20"),
     *     @OA\Property(property="tgl_diubah", type="string", example="2021-01-01 00:00:00")
     *     ),
     *
     * @OA\Get(
     *     path="/api/v1/master-data/produk-stok",
     *     tags={"Master Data - Produk Stok"},
     *     summary="Get all produk stok",
     *     operationId="getProdukStok",
     *     @OA\Response(response="200", description="Success", @OA\JsonContent(
     *         @OA\Property(property="status", type="integer", example=200),
     *         @OA\Property(property="message", type="string", example="Success get all produk stok"),
     *         @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/ProdukStok"))
     *     ))
     * )
     */

    public function index()
    {
        try {
            $produkStok = ProdukStok::all();
            return $this->apiResponseSuccess($produkStok, 'Success get all produk stok');
        } catch (QueryException $e) {
            return $this->apiResponseFailed($e->getMessage(), 'Failed get all produk stok');
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
     * Store a newly created resource in storage. and update tgl_release in table produk
     *
     * @OA\Post(
     *     path="/api/v1/master-data/produk-stok",
     *     tags={"Master Data - Produk Stok"},
     *     summary="Create a new product stok",
     *     operationId="post produk stok /api/v1/master-data/produk-stok",
     *     @OA\RequestBody(
     *         required=true,
     *         description="Data Produk Stok",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="produk_id", type="string"),
     *             @OA\Property(property="stok", type="number"),
     *         )
     *     ),
     *     @OA\Response(response="200", description="Success create new produk", @OA\JsonContent(
     *         @OA\Property(property="status", type="integer", example=200),
     *         @OA\Property(property="message", type="string", example="Success create new produk stok"),
     *         @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/ProdukStok"))
     *          ))
     *     )),
     *     @OA\Response(response="400", description="Failed create new produk stok")
     * )
     */
    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'produk_id' => [
                    'required',
                    function ($attribute, $value, $fail) {
                        // check if produk_id exists in table produk
                        $exists = DB::selectOne("SELECT EXISTS (SELECT 1 FROM \"Mst\".produk WHERE produk_id = :produk_id)", ['produk_id' => $value]);
                        if (!$exists->exists) {
                            $fail('The selected produk_id is invalid');
                        }
                    },
                ],
                'stok' => 'required|numeric',
            ]);

            $data['tgl_diubah'] = date('Y-m-d H:i:s');

            // check if produk_id exists in table produk_stok
            $exists = DB::selectOne("SELECT EXISTS (SELECT 1 FROM \"Mst\".produk_stok WHERE produk_id = :produk_id)", ['produk_id' => $data['produk_id']]);
            if ($exists->exists) {
                return $this->apiResponseFailed("Produk stok already exists, if you want to add stok in this produk, use post request '{server}/api/v1/master-data/produk-stok/add-stok'", "Failed create new produk stok");
            }

            DB::beginTransaction();

            $produk = Produk::findOrfail($data['produk_id']);
            $produk->tgl_release = $data['tgl_diubah'];
            $produk->save();

            $produkStok = ProdukStok::create($data);

            DB::commit();
            return $this->apiResponseSuccess($data, 'Success create new produk stok');
        } catch (ValidationException $e) {
            return $this->apiResponseFailed($e->validator->errors()->first(), 'Failed create new produk stok');
        } catch (QueryException $e) {
            return $this->apiResponseFailed($e->getMessage(), 'Failed create new produk stok');
        }
    }

    /**
     * Display the specified resource.
     *
     * @OA\Get(
     *      path="/api/v1/master-data/produk-stok/{produk_id}",
     *      tags={"Master Data - Produk Stok"},
     *      summary="Get specific produk stok",
     *      operationId="get specific produk stok /api/v1/master-data/produk-stok/{produk_id}",
     *      @OA\Parameter(
     *          name="produk_id",
     *          description="Produk ID",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string",
     *          )
     *      ),
     *     @OA\Response(response="200", description="Success", @OA\JsonContent(
     *         @OA\Property(property="status", type="integer", example=200),
     *         @OA\Property(property="message", type="string", example="Success get produk stok"),
     *         @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/ProdukStok"))
     *          ))
     *     ))
     * )
     */
    public function show(ProdukStok $produkStok)
    {
        try {
            return $this->apiResponseSuccess($produkStok, 'Success get produk stok');
        } catch (QueryException $e) {
            return $this->apiResponseFailed($e->getMessage(), 'Failed get produk stok');
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
     *    path="/api/v1/master-data/produk-stok/{produk_id}",
     *   tags={"Master Data - Produk Stok"},
     *    summary="Update existing produk stok",
     *    operationId="update existing produk stok /api/v1/master-data/produk-stok/{produk_id}",
     *    @OA\Parameter(
     *        name="produk_id",
     *        description="Produk ID",
     *        required=true,
     *        in="path",
     *        @OA\Schema(
     *            type="string"
     *        )
     *    ),
     *    @OA\RequestBody(
     *        required=true,
     *        description="Data Produk Stok",
     *        @OA\JsonContent(
     *            type="object",
     *            @OA\Property(property="stok", type="number"),
     *        )
     *    ),
     *    @OA\Response(response="200", description="Success update existing produk stok", @OA\JsonContent(
     *       @OA\Property(property="status", type="integer", example=200),
     *       @OA\Property(property="message", type="string", example="Success update produk stok"),
     *       @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/ProdukStok"))
     *        )),
     *    @OA\Response(response="400", description="Failed update existing produk stok")
     * )
     */
    public function update(Request $request, ProdukStok $produkStok)
    {
        try {
            $data = $request->validate([
                'stok' => 'required|numeric',
            ]);

            $data['tgl_diubah'] = date('Y-m-d H:i:s');

            $produkStok->update($data);

            return $this->apiResponseSuccess($produkStok, 'Success update produk stok');
        } catch (ValidationException $e) {
            return $this->apiResponseFailed($e->validator->errors()->first(), 'Failed update produk stok');
        } catch (QueryException $e) {
            return $this->apiResponseFailed($e->getMessage(), 'Failed update produk stok');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    /**
     * Add stok to existing produk stok
     *
     * @OA\Post(
     *     path="/api/v1/master-data/produk-stok/add-stok",
     *     tags={"Master Data - Produk Stok"},
     *     summary="add new value to existing produk stok",
     *     operationId="post add-stok to produk stok /api/v1/master-data/produk-stok",
     *     @OA\RequestBody(
     *         required=true,
     *         description="Data Produk Stok",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="produk_id", type="string"),
     *             @OA\Property(property="stok", type="number"),
     *         )
     *     ),
     *     @OA\Response(response="200", description="Success add stok to existing produk stok", @OA\JsonContent(
     *         @OA\Property(property="status", type="integer", example=200),
     *         @OA\Property(property="message", type="string", example="Success add stok to existing produk stok"),
     *         @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/ProdukStok"))
     *     )),
     *     @OA\Response(response="400", description="Failed add stok to existing produk stok")
     * )
     */
    public function addStok(Request $request)
    {
        try {
            $data = $request->validate([
                'produk_id' => [
                    'required',
                    function ($attribute, $value, $fail) {
                        // check if produk_id exists in table produk
                        $exists = DB::selectOne("SELECT EXISTS (SELECT 1 FROM \"Mst\".produk WHERE produk_id = :produk_id)", ['produk_id' => $value]);
                        if (!$exists->exists) {
                            $fail('The selected produk_id is invalid');
                        }
                    },
                ],
                'stok' => 'required|numeric',
            ]);

            $data['tgl_diubah'] = date('Y-m-d H:i:s');

            DB::beginTransaction();

            $produkStok = ProdukStok::where('produk_id', $data['produk_id'])->first();
            $produkStok->stok += $data['stok'];
            $produkStok->tgl_diubah = $data['tgl_diubah'];
            $produkStok->save();

            DB::commit();
            return $this->apiResponseSuccess($produkStok, 'Success add stok to existing produk stok');
        } catch (ValidationException $e) {
            return $this->apiResponseFailed($e->validator->errors()->first(), 'Failed add stok to existing produk stok');
        } catch (QueryException $e) {
            return $this->apiResponseFailed($e->getMessage(), 'Failed add stok to existing produk stok');
        }
    }
}
