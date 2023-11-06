<?php

namespace App\Service\Vehicle;

use App\Helper\NotificationError;
use App\Service\Vehicle\Entity\VehicleEntity;
use App\Service\Vehicle\Storage\VehicleStorageInterface;
use App\Service\Vehicle\Validation\VehicleDeletorValidation;
use App\Service\Vehicle\Validation\VehicleUpdaterValidation;

class VehicleDeletor
{
    private NotificationError $notificationError;
    private VehicleStorageInterface $vehicleStorage;
    private VehicleDeletorValidation $validation;

    public function __construct(NotificationError $notificationError, VehicleStorageInterface $vehicleStorage)
    {
        $this->notificationError = $notificationError;
        $this->vehicleStorage = $vehicleStorage;
        $this->validation = new VehicleDeletorValidation($notificationError, $vehicleStorage);
    }

    public function delete(?int $instructorId)
    {
        //Create entity vehicle
        $vehicleEntity = $this->createVehicleEntity($instructorId);

        //Validate info vehicle
        $this->validation->validate($vehicleEntity);

        if (!$this->notificationError->hasErrors()){
            //Delete student
            $this->vehicleStorage->deleteVehicle($vehicleEntity);
        }
    }

    private function createVehicleEntity(?int $instructorId)
    {
        return new VehicleEntity(null, $instructorId, null,
            null, null, null);
    }
}