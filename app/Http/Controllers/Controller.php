<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use OpenApi\Annotations as OA;

class Controller extends BaseController
{
    /**
     * @OA\Info(
     *    title="API Documentation PT. Rembon Karya Digital",
     *    version="1.0.0",
     * ),
     */
    use AuthorizesRequests, ValidatesRequests;

    public function apiResponseSuccess($data, $message = null, $status = 200)
    {
        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => $data
        ], $status);
    }
    
    public function apiResponseFailed($data, $message = null, $status = 400)
    {
        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => $data
        ], $status);
    }
}
