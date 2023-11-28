<?php

namespace App\Traits;

trait ApiResponse
{
    protected function response(mixed $data = null, int $statusCode = 200, string $status = 'success', string $response = 'Request successful')
    {
        return response()->json([
            'status' => $status,
            'statusCode' => $statusCode,
            'response' => $response,
            'data' => $data,
        ]);
    }
}