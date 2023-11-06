<?php

namespace App\Service\Classroom;

use App\Dto\Classroom\RequestUpdateClassroom;
use App\Helper\NotificationError;
use App\Service\Classroom\Entity\ClassroomEntity;
use App\Service\Classroom\Storage\ClassroomStorageInterface;
use App\Service\Classroom\Validation\ClassroomUpdaterValidation;

class ClassroomUpdater
{
    private NotificationError $notificationError;
    private ClassroomStorageInterface $classroomStorage;
    private ClassroomUpdaterValidation $validation;

    public function __construct(NotificationError $notificationError, ClassroomStorageInterface $classroomStorage)
    {
        $this->notificationError = $notificationError;
        $this->classroomStorage = $classroomStorage;
        $this->validation = new ClassroomUpdaterValidation($notificationError, $classroomStorage);
    }

    public function update(RequestUpdateClassroom $requestUpdateClassroom)
    {
        $classroomEntity = $this->createClassroomEntity($requestUpdateClassroom);

        $this->validation->validate($classroomEntity);

        if (!$this->notificationError->hasErrors()){
            //Update classroom
            $this->classroomStorage->updateClassroom($classroomEntity);
        }
    }

    private function createClassroomEntity(RequestUpdateClassroom $requestUpdateClassroom)
    {
        return new ClassroomEntity(null, $requestUpdateClassroom->id, $requestUpdateClassroom->date,
            $requestUpdateClassroom->studentId, $requestUpdateClassroom->instructorId, $requestUpdateClassroom->vehicleId);
    }
}