<?php

namespace App\Service\Classroom\Validation;

use App\Helper\NotificationError;
use App\Service\Classroom\Entity\ClassroomEntity;
use App\Service\Classroom\Storage\ClassroomStorageInterface;
use App\Service\Classroom\Validation\Validations\ClassroomExists;
use App\Service\Classroom\Validation\Validations\ClassroomValidation;
use App\Service\Classroom\Validation\Validations\InstructorExists;
use App\Service\Classroom\Validation\Validations\StudentExists;
use App\Service\Classroom\Validation\Validations\VehicleExists;

class ClassroomUpdaterValidation
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
        //Validate if data form is valid
        $classroomValidation = new ClassroomValidation();
        $classroomValidation->setNotificationErrors($this->notificationError);
        $classroomValidation->validateData($classroomEntity);

        //Validate if instructor exists
        $instructorExists = new InstructorExists($this->notificationError, $this->classroomStorage);
        $instructorExists->check($classroomEntity);

        //Validate if student exists
        $instructorExists = new StudentExists($this->notificationError, $this->classroomStorage);
        $instructorExists->check($classroomEntity);

        //Validate if vehicle exists
        $instructorExists = new VehicleExists($this->notificationError, $this->classroomStorage);
        $instructorExists->check($classroomEntity);

        //Validate if classroom exists
        $classroomExists = new ClassroomExists($this->notificationError, $this->classroomStorage);
        $classroomExists->check($classroomEntity);
    }
}