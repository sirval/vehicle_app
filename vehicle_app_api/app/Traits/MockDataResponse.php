<?php

namespace App\Traits;

class MockDataResponse 
{
    protected function verifyKeys($request)
    {
        $secretKey = $request->header('X-SECRET-KEY');
        $apiKey = $request->header('X-API-KEY');

        return [$secretKey, $apiKey];
    }
}