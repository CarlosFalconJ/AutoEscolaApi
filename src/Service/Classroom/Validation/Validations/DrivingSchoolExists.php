<?php

namespace App\Service\Classroom\Validation\Validations;

use App\Helper\NotificationError;
use App\Helper\ResponseCodeGenericsHelper;
use App\Service\Classroom\Entity\ClassroomEntity;
use App\Service\Classroom\Storage\ClassroomStorageInterface;

class DrivingSchoolExists
{
    private NotificationError $notificationError;
    private ClassroomStorageInterface $classroomStorage;

    public function __construct(NotificationError $notificationError, ClassroomStorageInterface $classroomStorage)
    {
        $this->notificationError = $notificationError;
        $this->classroomStorage = $classroomStorage;
    }

    public function check(ClassroomEntity $vehicleEntity)
    {
        $drivingSchooExists = $this->classroomStorage->getDrivingSchoolExists($vehicleEntity->getDrivingSchoolId());

        if (!$drivingSchooExists) {
            $this->notificationError->setCodigoErro(ResponseCodeGenericsHelper::CONFLICT);
            $this->notificationError->addErro('driving_school', 'A Autoescola não existe');
        }
    }
}