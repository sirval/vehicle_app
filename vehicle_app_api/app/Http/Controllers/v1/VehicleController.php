<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Services\VehicleDetail;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    protected $vehicleService;
    public function __construct(VehicleDetail $vehicleService)
    {
        $this->vehicleService = $vehicleService;
    }

    public function getClientVin(Request $request)
    {
        return $this->vehicleService->getVehicleDetail($request);
    }
}
