<?php

namespace App\Service\Vehicle\Validation;

use App\Helper\NotificationError;
use App\Service\Vehicle\Entity\VehicleEntity;
use App\Service\Vehicle\Storage\VehicleStorageInterface;
use App\Service\Vehicle\Validation\Validations\VehicleExists;
use App\Service\Vehicle\Validation\Validations\VehiclePlateAlreadyRegisteredValidation;
use App\Service\Vehicle\Validation\Validations\VehicleRenavamAlreadyRegisteredValidation;
use App\Service\Vehicle\Validation\Validations\VehicleValidation;

class VehicleUpdaterValidation
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
        //Validate if data form is valid
        $studentValidation = new VehicleValidation();
        $studentValidation->setNotificationErrors($this->notificationError);
        $studentValidation->validateData($vehicleEntity);

        //Validate if plate already register
        $vehiclePlateAlreadyRegisteredValidation = new VehiclePlateAlreadyRegisteredValidation($this->notificationError, $this->vehicleStorage);
        $vehiclePlateAlreadyRegisteredValidation->check($vehicleEntity);

        //Validate if renavam already register
        $vehicleRenavamAlreadyRegisteredValidation = new VehicleRenavamAlreadyRegisteredValidation($this->notificationError, $this->vehicleStorage);
        $vehicleRenavamAlreadyRegisteredValidation->check($vehicleEntity);

        //Validate if vehicle exists
        $drivingSchooExists = new VehicleExists($this->notificationError, $this->vehicleStorage);
        $drivingSchooExists->check($vehicleEntity);
    }
}