<?php

namespace App\Service\Vehicle\Validation\Validations;

use App\Helper\NotificationError;
use App\Helper\ResponseCodeGenericsHelper;
use App\Service\Vehicle\Entity\VehicleEntity;
use App\Service\Vehicle\Storage\VehicleStorageInterface;

class VehicleRenavamAlreadyRegisteredValidation
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
        $revavamAlreadyRegistered = $this->vehicleStorage->getVehicleWithRenavam($vehicleEntity->getId(), $vehicleEntity->getRenavam());

        if ($revavamAlreadyRegistered) {
            $this->notificationError->setCodigoErro(ResponseCodeGenericsHelper::CONFLICT);
            $this->notificationError->addErro('renavam', 'Já existe um veiculo com esse renavam cadastrado');
        }
    }
}