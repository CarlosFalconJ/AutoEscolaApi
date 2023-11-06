<?php

namespace App\Service\Classroom\Validation\Validations;

use App\Helper\NotificationError;
use App\Helper\ResponseCodeGenericsHelper;
use App\Service\Classroom\Entity\ClassroomEntity;
use App\Service\Classroom\Storage\ClassroomStorageInterface;

class InstructorExists
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
        $instructorExists = $this->classroomStorage->getInstructorExists($classroomEntity->getInstructorId());

        if (!$instructorExists) {
            $this->notificationError->setCodigoErro(ResponseCodeGenericsHelper::CONFLICT);
            $this->notificationError->addErro('instructor', 'O instrutor não existe');
        }
    }
}