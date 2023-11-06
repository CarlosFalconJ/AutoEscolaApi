<?php

namespace App\Service\Vehicle\Validation\Validations;

use App\Helper\NotificationError;
use App\Helper\ResponseCodeGenericsHelper;
use App\Service\Vehicle\Entity\VehicleEntity;
use App\Service\Vehicle\Storage\VehicleStorageInterface;

class VehicleExists
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
        $vehicleExists = $this->vehicleStorage->getVehicleExists($vehicleEntity->getId());

        if (!$vehicleExists) {
            $this->notificationError->setCodigoErro(ResponseCodeGenericsHelper::CONFLICT);
            $this->notificationError->addErro('vehicle', 'O veiculo não existe');
        }
    }
}