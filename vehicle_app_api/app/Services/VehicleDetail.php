<?php

namespace App\Services;

use App\Services\MockDataManagement\MockDataRepository;
use App\Services\MockDataManagement\MockDataService;
use App\Traits\ApiResponse;

class VehicleDetail
{

    use ApiResponse;

    public function getVehicleDetail($request)
    {
        $mockDataService = new MockDataService;
        return $mockDataService->getVehicleIdentificationNumber($request);
    }
}
