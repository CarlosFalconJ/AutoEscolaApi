<?php

namespace App\Service\Classroom\Validation\Validations;

use App\Helper\NotificationError;
use App\Helper\ResponseCodeGenericsHelper;
use App\Service\Classroom\Entity\ClassroomEntity;
use App\Service\Classroom\Storage\ClassroomStorageInterface;

class StudentExists
{
    private NotificationError $notificationError;
    private ClassroomStorageInterface $classroomStorage;

    public function __construct(NotificationError $notificationError, ClassroomStorageInterface $classroomStorage)
    {
        $this->notificationError = $notificationError;
        $this->classroomStorage = $classroomStorage;
    }

    public function check(ClassroomEntity $classroomEntity)
    {
        $studantExists = $this->classroomStorage->getStudantExists($classroomEntity->getStudentId());

        if (!$studantExists) {
            $this->notificationError->setCodigoErro(ResponseCodeGenericsHelper::CONFLICT);
            $this->notificationError->addErro('student', 'O aluno não existe');
        }
    }
}