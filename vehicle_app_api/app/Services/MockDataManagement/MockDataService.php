<?php

namespace App\Services\MockDataManagement;

use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;

class MockDataService implements MockDataInterface
{
    use ApiResponse;

    public function getVehicleIdentificationNumber($request): JsonResponse
    {
        $repository = new MockDataRepository;
        $response = $repository->getVin($request);
        $statusCode = $response['statusCode'];
        switch ($statusCode) {
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