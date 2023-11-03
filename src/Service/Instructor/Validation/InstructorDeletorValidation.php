<?php

namespace App\Service\Instructor\Validation;

use App\Helper\NotificationError;
use App\Service\Instructor\Entity\InstructorEntity;
use App\Service\Instructor\Storage\InstructorStorageInterface;
use App\Service\Instructor\Validation\Validations\InstructorExists;

class InstructorDeletorValidation
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
        //Validate if instructor exists
        $instructorExists = new InstructorExists($this->notificationError, $this->instructorStorage);
        $instructorExists->check($instructorEntity);
    }
}