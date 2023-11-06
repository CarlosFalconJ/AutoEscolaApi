<?php

namespace App\Service\Vehicle\Validation\Validations;

use App\Helper\NotificationError;
use App\Helper\ResponseCodeGenericsHelper;
use App\Service\Vehicle\Entity\VehicleEntity;
use App\Service\Vehicle\Storage\VehicleStorageInterface;

class VehiclePlateAlreadyRegisteredValidation
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
        $plateAlreadyRegistered = $this->vehicleStorage->getVehicleWithPlate($vehicleEntity->getId(), $vehicleEntity->getPlate());

        if ($plateAlreadyRegistered) {
            $this->notificationError->setCodigoErro(ResponseCodeGenericsHelper::CONFLICT);
            $this->notificationError->addErro('plate', 'Já existe um veiculo com essa placa cadastrado');
        }
    }
}