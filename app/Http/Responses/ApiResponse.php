<?php

namespace App\Http\Responses;

use Illuminate\Http\JsonResponse;

class ApiResponse
{
    /**
     * @param array<string, mixed>|null $meta
     */
    public static function success(mixed $data, ?array $meta = null, int $status = 200): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => $data,
            'error' => null,
            'meta' => $meta,
        ], $status);
    }

    public static function error(string $message, int $status = 400): JsonResponse
    {
        return response()->json([
            'success' => false,
            'data' => null,
            'error' => [
                'message' => $message,
            ],
            'meta' => null,
        ], $status);
    }
}
