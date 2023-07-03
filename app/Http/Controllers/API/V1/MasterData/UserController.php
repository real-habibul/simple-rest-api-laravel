<?php

namespace App\Http\Controllers\API\V1\MasterData;

use App\Http\Controllers\Controller;
use App\Models\Usr\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @OA\Schema(
     *    schema="User",
     *    title="User",
     *    description="Model of User",
     *    @OA\Property(property="user_id", type="string", example="eb478114-48ae-4988-9030-4374e5558587"),
     *    @OA\Property(property="nama_depan", type="string", example="Rudi"),
     *    @OA\Property(property="nama_belakang", type="string", example="Setiawan"),
     *    @OA\Property(property="alamat", type="string", example="Jl. Raya Kedung Halang"),
     *    @OA\Property(property="nomor_hp", type="string", example="081234567890"),
     *    @OA\Property(property="jk", type="string", example="L"),
     *    @OA\Property(property="tgl_lahir", type="string", example="1990-01-01")
     *    ),
     *
     *
     * @OA\Get(
     *     path="/api/v1/master-data/user",
     *     tags={"Master Data - User"},
     *     summary="Get all user",
     *     operationId="get user /api/v1/master-data/user",
     *     @OA\Response(response="200", description="Success", @OA\JsonContent(
     *         @OA\Property(property="status", type="integer", example=200),
     *         @OA\Property(property="message", type="string", example="Success get all user"),
     *         @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/User"))
     *     )),
     *     @OA\Response(response="400", description="Bad Request", @OA\JsonContent(
     *         @OA\Property(property="status", type="integer", example=400),
     *         @OA\Property(property="message", type="string", example="Failed get all user")
     *     ))
     * )
     */
    public function index()
    {
        try {
            $data = User::all();
            return $this->apiResponseSuccess($data, 'Success get all user');
        } catch (QueryException $e) {
            return $this->apiResponseFailed($e->getMessage(), 'Failed get all user');
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
     *  @OA\Post(
     *     path="/api/v1/master-data/user",
     *     tags={"Master Data - User"},
     *     summary="Create user",
     *     operationId="create user /api/v1/master-data/user",
     *     @OA\RequestBody(
     *         required=true,
     *         description="User object that needs to be added to the store",
     *         @OA\JsonContent(ref="#/components/schemas/User")
     *     ),
     *     @OA\Response(response="200", description="Success", @OA\JsonContent(
     *         @OA\Property(property="status", type="integer", example=200),
     *         @OA\Property(property="message", type="string", example="Success create user"),
     *         @OA\Property(property="data", type="array", @OA\Items(
     *         @OA\Property(property="nama_depan", type="string", example="Rudi"),
     *         @OA\Property(property="nama_belakang", type="string", example="Setiawan"),
     *         @OA\Property(property="alamat", type="string", example="Medan"),
     *         @OA\Property(property="nomor_hp", type="string", example="08567890123"),
     *         @OA\Property(property="jk", type="string", example="M"),
     *         @OA\Property(property="tgl_lahir", type="string", example="1994-11-27"),
     *          ))
     *     ))
     
     * )
     */
    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'nama_depan' => 'required|string|max:30',
                'nama_belakang' => 'required|string|max:30',
                'alamat' => 'string|max:200',
                'nomor_hp' => 'string|max:15',
                'jk' => 'required|string|max:1',
                'tgl_lahir' => 'required|date',
            ]);

            if ($request->has('user_id')) {
                unset($data['user_id']);
            } 

            $data = User::create($data);
            return $this->apiResponseSuccess($data, 'Success create user');
        } catch (ValidationException $e) {
            return $this->apiResponseFailed($e->getMessage(), 'Failed create user');
        }
    }

    /**
     * Display the specified resource.
     * 
     * @OA\Get(
     *     path="/api/v1/master-data/user/{id}",
     *     tags={"Master Data - User"},
     *     summary="Get user by id",
     *     operationId="get user by id /api/v1/master-data/user/{id}",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="id of user",
     *         required=true,
     *         @OA\Schema(
     *           type="string"
     *         )
     *     ),
     *     @OA\Response(response="200", description="Success", @OA\JsonContent(
     *         @OA\Property(property="status", type="integer", example=200),
     *         @OA\Property(property="message", type="string", example="Success get user"),
     *         @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/User"))
     *     )),
     *     @OA\Response(response="400", description="Not Found", @OA\JsonContent(
     *         @OA\Property(property="status", type="integer", example=404),
     *         @OA\Property(property="message", type="string", example="Failed get user")
     *     ))
     * )
     *
     */
    public function show(string $id)
    {
        try {
            $data = User::findOrFail($id);
            return $this->apiResponseSuccess($data, 'Success get user');
        } catch (QueryException $e) {
            return $this->apiResponseFailed($e->getMessage(), 'Failed get user');
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
     *     path="/api/v1/master-data/user/{id}",
     *     tags={"Master Data - User"},
     *     summary="Update user",
     *     operationId="update user /api/v1/master-data/user/{id}",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="id user",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *             format="uuid"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         description="User object that needs to be added to the store",
     *         @OA\JsonContent(ref="#/components/schemas/User")
     *     ),
     *     @OA\Response(response="200", description="Success", @OA\JsonContent(
     *         @OA\Property(property="status", type="integer", example=200),
     *         @OA\Property(property="message", type="string", example="Success update user"),
     *         @OA\Property(property="data", type="array", @OA\Items(
     *         @OA\Property(property="nama_depan", type="string", example="Rudi"),
     *         @OA\Property(property="nama_belakang", type="string", example="Setiawan"),
     *         @OA\Property(property="alamat", type="string", example="Medan"),
     *         @OA\Property(property="nomor_hp", type="string", example="08567890123"),
     *         @OA\Property(property="jk", type="string", example="M"),
     *         @OA\Property(property="tgl_lahir", type="string", example="1994-11-27"),
     *          ))
     *     ))
     * )
     */
    public function update(Request $request, string $id)
    {
        try {
            $data = $request->validate([
                'nama_depan' => 'string|max:30',
                'nama_belakang' => 'string|max:30',
                'alamat' => 'string|max:200',
                'nomor_hp' => 'string|max:15',
                'jk' => 'string|max:1',
                'tgl_lahir' => 'date',
            ]);

            $user = User::findOrFail($id);
            $user->update($data);

            return $this->apiResponseSuccess($user, 'Success update user');
        } catch (QueryException $e) {
            return $this->apiResponseFailed($e->getMessage(), 'Failed update user');
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
