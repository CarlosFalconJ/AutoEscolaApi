<?php

namespace App\Service\Vehicle\Storage;

use App\Service\Vehicle\Entity\VehicleEntity;

interface VehicleStorageInterface
{
    public function getDrivingSchoolExists(?int $drivingSchoolId);

    public function saveVehicle(VehicleEntity $vehicleEntity);

    public function getVehicleWithPlate(?int $vehicleId, ?string $plate);

    public function getVehicleExists(?int $vehicleId);

    public function updateVehicle(VehicleEntity $vehicleEntity);

    public function getVehicleWithRenavam(?int $vehicleId, ?string $renavam);

    public function deleteVehicle(VehicleEntity $vehicleEntity);

    public function getAllVehiclesFromDrivingSchool(?int $drivingSchoolId);

    public function getVehicleById(?int $instructorId);
}