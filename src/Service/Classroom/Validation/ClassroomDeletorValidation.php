<?php

namespace App\Service\Classroom\Validation;

use App\Helper\NotificationError;
use App\Service\Classroom\Entity\ClassroomEntity;
use App\Service\Classroom\Storage\ClassroomStorageInterface;
use App\Service\Classroom\Validation\Validations\ClassroomExists;

class ClassroomDeletorValidation
{
    private NotificationError $notificationError;
    private ClassroomStorageInterface $classroomStorage;

    public function __construct(NotificationError $notificationError, ClassroomStorageInterface $classroomStorage)
    {
        $this->notificationError = $notificationError;
        $this->classroomStorage = $classroomStorage;
    }

    public function validate(ClassroomEntity $classroomEntity)
    {
        //Validate if classroom exists
        $classroomExists = new ClassroomExists($this->notificationError, $this->classroomStorage);
        $classroomExists->check($classroomEntity);
    }
}