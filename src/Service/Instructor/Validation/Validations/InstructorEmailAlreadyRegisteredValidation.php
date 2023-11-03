<?php

namespace App\Service\Instructor\Validation\Validations;

use App\Helper\NotificationError;
use App\Helper\ResponseCodeGenericsHelper;
use App\Service\Instructor\Entity\InstructorEntity;
use App\Service\Instructor\Storage\InstructorStorageInterface;

class InstructorEmailAlreadyRegisteredValidation
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
        $emailAlreadyRegistered = $this->instructorStorage->getInstructorWithEmail($instructorEntity->getId(), $instructorEntity->getEmail());

        if ($emailAlreadyRegistered) {
            $this->notificationError->setCodigoErro(ResponseCodeGenericsHelper::CONFLICT);
            $this->notificationError->addErro('email', 'Já existe uma aluno com esse email');
        }
    }
}