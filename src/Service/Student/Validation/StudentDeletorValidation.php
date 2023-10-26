<?php

namespace App\Service\Student\Validation;

use App\Helper\NotificationError;
use App\Service\Student\Entity\StudentEntity;
use App\Service\Student\Storage\StudentStorageInterface;
use App\Service\Student\Validation\Validations\StudentExists;

class StudentDeletorValidation
{
    private NotificationError $notificationError;
    private StudentStorageInterface $studentStorage;

    public function __construct(NotificationError $notificationError, StudentStorageInterface $studentStorage)
    {
        $this->notificationError = $notificationError;
        $this->studentStorage = $studentStorage;
    }

    public function validate(StudentEntity $studentEntity)
    {
        //Validate if studant exists
        $studentExists = new StudentExists($this->notificationError, $this->studentStorage);
        $studentExists->check($studentEntity);
    }
}