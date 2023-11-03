<?php

namespace App\Service\Instructor\Validation;

use App\Helper\NotificationError;
use App\Service\Instructor\Entity\InstructorEntity;
use App\Service\Instructor\Storage\InstructorStorageInterface;
use App\Service\Instructor\Validation\Validations\DrivingSchoolExists;
use App\Service\Instructor\Validation\Validations\InstructorCpfAlreadyRegisteredValidation;
use App\Service\Instructor\Validation\Validations\InstructorEmailAlreadyRegisteredValidation;
use App\Service\Instructor\Validation\Validations\InstructorValidation;

class InstructorCreaterValidation
{
    private NotificationError $notificationError;
    private InstructorStorageInterface $instructorStorage;

    public function __construct(NotificationError $notificationError, InstructorStorageInterface $instructorStorage)
    {
        $this->notificationError = $notificationError;
        $this->instructorStorage = $instructorStorage;
    }

    public function validate(InstructorEntity $instructorEntity)
    {
        //Validate if data form is valid
        $instructorValidation = new InstructorValidation();
        $instructorValidation->setNotificationErrors($this->notificationError);
        $instructorValidation->validateData($instructorEntity);

        //Validate if cpf already register
        $instructorCpfAlreadyRegisteredValidation = new InstructorCpfAlreadyRegisteredValidation($this->notificationError, $this->instructorStorage);
        $instructorCpfAlreadyRegisteredValidation->check($instructorEntity);

        //Validate if email already register
        $instructorEmailAlreadyRegisteredValidation = new InstructorEmailAlreadyRegisteredValidation($this->notificationError, $this->instructorStorage);
        $instructorEmailAlreadyRegisteredValidation->check($instructorEntity);

        //Validate if drivingSchool exists
        $drivingSchooExists = new DrivingSchoolExists($this->notificationError, $this->instructorStorage);
        $drivingSchooExists->check($instructorEntity);
    }

}