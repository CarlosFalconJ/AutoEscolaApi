<?php

namespace App\Service\Vehicle\Validation\Validations;

use App\Helper\NotificationError;
use App\Helper\ResponseCodeGenericsHelper;
use App\Service\Vehicle\Entity\VehicleEntity;
use App\Service\Vehicle\Storage\VehicleStorageInterface;

class DrivingSchoolExists
{
    private NotificationError $notificationError;
    private VehicleStorageInterface $vehicleStorage;

    public function __construct(NotificationError $notificationError, VehicleStorageInterface $vehicleStorage)
    {
        $this->notificationError = $notificationError;
        $this->vehicleStorage = $vehicleStorage;
    }

    public function check(VehicleEntity $vehicleEntity)
    {
        $drivingSchooExists = $this->vehicleStorage->getDrivingSchoolExists($vehicleEntity->getDrivingSchoolId());

        if (!$drivingSchooExists) {
            $this->notificationError->setCodigoErro(ResponseCodeGenericsHelper::CONFLICT);
            $this->notificationError->addErro('driving_school', 'A Autoescola não existe');
        }
    }
}