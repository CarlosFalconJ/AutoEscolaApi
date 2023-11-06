<?php

namespace App\Service\Classroom;

use App\Helper\NotificationError;
use App\Service\Classroom\Entity\ClassroomEntity;
use App\Service\Classroom\Storage\ClassroomStorageInterface;
use App\Service\Classroom\Validation\ClassroomDeletorValidation;

class ClassroomDeletor
{
    private NotificationError $notificationError;
    private ClassroomStorageInterface $classroomStorage;
    private ClassroomDeletorValidation $validation;

    public function __construct(NotificationError $notificationError, ClassroomStorageInterface $classroomStorage)
    {
        $this->notificationError = $notificationError;
        $this->classroomStorage = $classroomStorage;
        $this->validation = new ClassroomDeletorValidation($notificationError, $classroomStorage);
    }

    public function delete(?int $classroomId)
    {
        $classroomEntity = $this->createClassroomEntity($classroomId);

        $this->validation->validate($classroomEntity);

        if (!$this->notificationError->hasErrors()){
            //Delete classroom
            $this->classroomStorage->deleteClassroom($classroomEntity);
        }
    }

    private function createClassroomEntity($classroomId)
    {
        return new ClassroomEntity(null, $classroomId, null,
            null, null, null);
    }
}