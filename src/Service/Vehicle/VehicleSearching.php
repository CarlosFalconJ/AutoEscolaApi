<?php

namespace App\Service\Vehicle;

use App\Service\Vehicle\Storage\VehicleStorageInterface;

class VehicleSearching
{
    private VehicleStorageInterface $vehicleStorage;

    public function __construct(VehicleStorageInterface $vehicleStorage)
    {
        $this->vehicleStorage = $vehicleStorage;
    }

    public function search(?int $instructorId)
    {
        return $this->vehicleStorage->getVehicleById($instructorId);
    }
}