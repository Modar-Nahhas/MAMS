<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public static function getJsonResponse($message, $data = null, $result = true, $code = 200): JsonResponse
    {
        $response = [
            'message' => $message,
            'data' => $data,
            'status' => $result,
            'code' => $code,
        ];
        return response()->json($response, $code);
    }
}
