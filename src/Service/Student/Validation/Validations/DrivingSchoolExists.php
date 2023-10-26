<?php

namespace App\Service\Student\Validation\Validations;

use App\Helper\NotificationError;
use App\Helper\ResponseCodeGenericsHelper;
use App\Service\Student\Entity\StudentEntity;
use App\Service\Student\Storage\StudentStorageInterface;

class DrivingSchoolExists
{
    private NotificationError $notificationError;
    private StudentStorageInterface $studentStorage;

    public function __construct(NotificationError $notificationError, StudentStorageInterface $studentStorage)
    {
        $this->notificationError = $notificationError;
        $this->studentStorage = $studentStorage;
    }

    public function check(StudentEntity $studentEntity)
    {
        $drivingSchooExists = $this->studentStorage->getDrivingSchoolExists($studentEntity->getDrivingSchoolId());

        if (!$drivingSchooExists) {
            $this->notificationError->setCodigoErro(ResponseCodeGenericsHelper::CONFLICT);
            $this->notificationError->addErro('driving_school', 'A Autoescola não existe');
        }
    }
}