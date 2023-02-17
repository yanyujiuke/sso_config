<?php

namespace App\Api\Common;

use Illuminate\Http\JsonResponse;

class ApiJson
{
    /**
     * @param array $data
     * @param string $msg
     * @param int $code
     * @return JsonResponse
     */
    public static function success(array $data, string $msg = 'success', int $code = 1): JsonResponse
    {
        return response()->json([
            'code' => $code,
            'msg' => $msg,
            'data' => $data,
        ]);
    }

    /**
     * @param array $data
     * @param string $msg
     * @param int $code
     * @return JsonResponse
     */
    public static function error(string $msg = 'error', int $code = 0, array $data = []): JsonResponse
    {
        return response()->json([
            'code' => $code,
            'msg' => $msg,
            'data' => $data,
        ]);
    }
}