<?php

namespace App\Service\Classroom\Validation\Validations;

use App\Helper\NotificationError;
use App\Helper\ResponseCodeGenericsHelper;
use App\Service\Classroom\Entity\ClassroomEntity;
use App\Service\Classroom\Storage\ClassroomStorage;
use App\Service\Classroom\Storage\ClassroomStorageInterface;

class VehicleExists
{
    private NotificationError $notificationError;
    private ClassroomStorageInterface $classroomStorage;

    public function __construct(NotificationError $notificationError, ClassroomStorageInterface $classroomStorage)
    {
        $this->notificationError = $notificationError;
        $this->classroomStorage = $classroomStorage;
    }

    public function check(ClassroomEntity $classroomEntity)
    {
        $vehicleExists = $this->classroomStorage->getVehicleExists($classroomEntity->getVehicleId());

        if (!$vehicleExists) {
            $this->notificationError->setCodigoErro(ResponseCodeGenericsHelper::CONFLICT);
            $this->notificationError->addErro('vehicle', 'O veiculo não existe');
        }
    }
}