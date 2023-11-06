<?php

namespace App\Service\Vehicle\Validation;

use App\Helper\NotificationError;
use App\Service\Vehicle\Entity\VehicleEntity;
use App\Service\Vehicle\Storage\VehicleStorageInterface;
use App\Service\Vehicle\Validation\Validations\VehicleExists;

class VehicleDeletorValidation
{
    private NotificationError $notificationError;
    private VehicleStorageInterface $vehicleStorage;

    public function __construct(NotificationError $notificationError, VehicleStorageInterface $vehicleStorage)
    {
        $this->notificationError = $notificationError;
        $this->vehicleStorage = $vehicleStorage;
    }

    public function validate(VehicleEntity $vehicleEntity)
    {
        //Validate if vehicle exists
        $drivingSchooExists = new VehicleExists($this->notificationError, $this->vehicleStorage);
        $drivingSchooExists->check($vehicleEntity);
    }
}