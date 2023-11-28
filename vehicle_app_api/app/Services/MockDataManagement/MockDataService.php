<?php

namespace App\Services\MockDataManagement;

class MockDataService implements MockDataInterface
{
    // public $repository;

    // public function __construct(MockDataRepository $repository)
    // {
    //     $this->repository = $repository;
    // }

    public function getVehicleIdentificationNumber($request): array
    {
        $repository = new MockDataRepository();
        $data = $repository->getVin($request);
        if (!empty($data['error'])) {
            return [
                'response' => false,
                'status' => 500,
                'message' => $data['error'],
            ];
        }
        return $data;
    }
}