<?php

namespace App\Service\Student\Validation\Validations;

use App\Helper\NotificationError;
use App\Helper\ResponseCodeGenericsHelper;
use App\Service\Student\Entity\StudentEntity;
use App\Service\Student\Storage\StudentStorageInterface;

class StudentExists
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
        $tudantExists = $this->studentStorage->getStudantExists($studentEntity->getId());

        if (!$tudantExists) {
            $this->notificationError->setCodigoErro(ResponseCodeGenericsHelper::CONFLICT);
            $this->notificationError->addErro('student', 'O aluno não existe');
        }
    }
}