<?php

namespace App\Service\Vehicle;

use App\Service\Vehicle\Storage\VehicleStorageInterface;

class VehicleSearchingAll
{
    private VehicleStorageInterface $vehicleStorage;

    public function __construct(VehicleStorageInterface $vehicleStorage)
    {
        $this->vehicleStorage = $vehicleStorage;
    }

    public function searchAll(?int $drivingSchoolId)
    {
        return $this->vehicleStorage->getAllVehiclesFromDrivingSchool($drivingSchoolId);
    }
}