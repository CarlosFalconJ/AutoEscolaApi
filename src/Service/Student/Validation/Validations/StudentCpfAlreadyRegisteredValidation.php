<?php

namespace App\Service\Student\Validation\Validations;

use App\Helper\NotificationError;
use App\Helper\ResponseCodeGenericsHelper;
use App\Service\Student\Entity\StudentEntity;
use App\Service\Student\Storage\StudentStorageInterface;

class StudentCpfAlreadyRegisteredValidation
{
    private NotificationError $notificationError;
    private StudentStorageInterface $studentStorage;

    public function __construct(NotificationError $notificationError, StudentStorageInterface $studentStorage)
    {
        $this->notificationError = $notificationError;
        $this->studentStorage = $studentStorage;
    }

    public function check(StudentEntity $studentEntity)
    {
        $cpfAlreadyRegistered = $this->studentStorage->getStudentWithCpf($studentEntity->getId(), $studentEntity->getCpf());

        if ($cpfAlreadyRegistered) {
            $this->notificationError->setCodigoErro(ResponseCodeGenericsHelper::CONFLICT);
            $this->notificationError->addErro('cpf', 'Já existe uma aluno com esse cpf');
        }
    }
}