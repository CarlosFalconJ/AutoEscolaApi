<?php

namespace App\Service\Instructor\Validation\Validations;

use App\Helper\NotificationError;
use App\Helper\ResponseCodeGenericsHelper;
use App\Service\Instructor\Entity\InstructorEntity;
use App\Service\Instructor\Storage\InstructorStorageInterface;

class InstructorExists
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
        $instructorExists = $this->instructorStorage->getInstructorExists($instructorEntity->getId());

        if (!$instructorExists) {
            $this->notificationError->setCodigoErro(ResponseCodeGenericsHelper::CONFLICT);
            $this->notificationError->addErro('instructor', 'O instrutor não existe');
        }
    }
}