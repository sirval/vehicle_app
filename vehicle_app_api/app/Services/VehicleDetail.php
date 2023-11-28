<?php

namespace App\Services;

use App\Services\MockDataManagement\MockDataRepository;
use App\Services\MockDataManagement\MockDataService;
use App\Traits\ApiResponse;
use App\Traits\Utils;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class VehicleDetail
{

    use ApiResponse, Utils;
    private string $apiKey;
    private string $secretKey;
    private string $publicKey;
    public $url;
    public function __construct()
    {
        // $this->apiKey = config('vehicle.apiKey');
        $this->secretKey = config('vehicle.secretKey');
        $this->publicKey = config('vehicle.publicKey');
        $this->url = config('vehicle.baseUrl');
    }

    public function getVehicleDetail($request)
    {
        $mockData = new MockDataRepository;
        $response = $mockData->getVin($request);
        $status = $response['status'];
        switch ($status) {
            case 200:
                return $this->response($response['response']);
                break;
            case 409: //invalid input entry
                return $this->response($response['response'], 409, 'error' ,$response['response']);
                break;
                case 404: //VIN nt found
                    return $this->response(null, 404, 'error' , 'VIN not found in our server');
                break;
            default: //case 500 and other exceptions
            return $this->response($response['response'], 500, 'error', 'A server error occurred.');
                break;
        }
    }
}
