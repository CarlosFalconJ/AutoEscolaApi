<?php

namespace App\Service\Classroom;

use App\Dto\Classroom\RequestCreateClassroom;
use App\Helper\NotificationError;
use App\Service\Classroom\Entity\ClassroomEntity;
use App\Service\Classroom\Storage\ClassroomStorageInterface;
use App\Service\Classroom\Validation\ClassroomCreaterValidation;

class ClassroomCreater
{
    private NotificationError $notificationError;
    private ClassroomStorageInterface $classroomStorage;
    private ClassroomCreaterValidation $validation;

    public function __construct(NotificationError $notificationError, ClassroomStorageInterface $classroomStorage)
    {
        $this->notificationError = $notificationError;
        $this->classroomStorage = $classroomStorage;
        $this->validation = new ClassroomCreaterValidation($notificationError, $classroomStorage);
    }

    public function create(RequestCreateClassroom $requestCreateClassroom)
    {
        $classroomEntity = $this->createClassroomEntity($requestCreateClassroom);

        $this->validation->validate($classroomEntity);

        if (!$this->notificationError->hasErrors()){
            //Create classroom
            $this->classroomStorage->saveClassroom($classroomEntity);
        }
    }

    private function createClassroomEntity(RequestCreateClassroom $requestCreateClassroom)
    {
        return new ClassroomEntity($requestCreateClassroom->drivingSchoolId, null, $requestCreateClassroom->date,
            $requestCreateClassroom->studentId, $requestCreateClassroom->instructorId, $requestCreateClassroom->vehicleId);
    }
}