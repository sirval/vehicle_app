<?php

namespace App\Http\Controllers\v1\MockData;

use App\Http\Controllers\Controller;
use App\Services\MockDataManagement\MockDataService;
use Illuminate\Http\Request;

class VehicleDataController extends Controller
{
    public $service;

    public function __construct(MockDataService $service)
    {
        $this->service = $service;
    }

    public function getVin(Request $request)
    {
        return response()->json($this->service->getVehicleIdentificationNumber($request));
    }
}
