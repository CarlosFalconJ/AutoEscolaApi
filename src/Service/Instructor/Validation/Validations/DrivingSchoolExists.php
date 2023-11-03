<?php

namespace App\Service\Instructor\Validation\Validations;

use App\Helper\NotificationError;
use App\Helper\ResponseCodeGenericsHelper;
use App\Service\Instructor\Entity\InstructorEntity;
use App\Service\Instructor\Storage\InstructorStorageInterface;
use App\Service\Student\Entity\StudentEntity;

class DrivingSchoolExists
{
    private NotificationError $notificationError;
    private InstructorStorageInterface $instructorStorage;

    public function __construct(NotificationError $notificationError, InstructorStorageInterface $instructorStorage)
    {
        $this->notificationError = $notificationError;
        $this->instructorStorage = $instructorStorage;
    }

    public function check(InstructorEntity $instructorEntity)
    {
        $drivingSchooExists = $this->instructorStorage->getDrivingSchoolExists($instructorEntity->getDrivingSchoolId());

        if (!$drivingSchooExists) {
            $this->notificationError->setCodigoErro(ResponseCodeGenericsHelper::CONFLICT);
            $this->notificationError->addErro('driving_school', 'A Autoescola não existe');
        }
    }
}