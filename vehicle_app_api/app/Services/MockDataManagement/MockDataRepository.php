<?php

namespace App\Services\MockDataManagement;

use App\Http\Resources\VehicleMockDataResource;
use App\Models\VehicleMockData;
use Illuminate\Support\Facades\Validator;

class MockDataRepository
{
    public function getVin($request)
    {
        try {
            $data = [
                'vin' => $request->vin,
            ];
            $rules = [
                'vin' => 'required|string',
            ];

            $validator = Validator::make($data, $rules);
            if ($validator->fails()) {
                $errors = implode(' ', $validator->errors()->all());
                return [
                    'statusCode' => 409,
                    'response' => $errors
                ];
            }
            $vin = $request->vin;
            $result = VehicleMockData::where('vin', $vin)->first();
            if ($result) {
                $result = new VehicleMockDataResource($result);
                return [
                    'statusCode' => 200,
                    'response' => $result
                ];
            }else {
                return [
                    'statusCode' => 404,
                    'response' => "NOT FOUND"
                ];
            }

        } catch (\Throwable $th) {
           return [
            'statusCode' => 500,
            'response' => $th->getMessage()
           ];
        }
    }
}