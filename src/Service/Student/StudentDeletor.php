<?php

namespace App\Service\Student;

use App\Dto\Student\RequestDeleteStudent;
use App\Helper\NotificationError;
use App\Service\Student\Entity\StudentEntity;
use App\Service\Student\Storage\StudentStorageInterface;
use App\Service\Student\Validation\StudentDeletorValidation;

class StudentDeletor
{
    private NotificationError $notificationError;
    private StudentStorageInterface $studentStorage;
    private StudentDeletorValidation $validation;

    public function __construct(NotificationError $notificationError, StudentStorageInterface $studentStorage)
    {
        $this->notificationError = $notificationError;
        $this->studentStorage = $studentStorage;
        $this->validation = new StudentDeletorValidation($this->notificationError, $this->studentStorage);
    }

    public function delete(RequestDeleteStudent $requestDeleteStudent)
    {
        $student = $this->createStudentEntity($requestDeleteStudent);

        //Validate info student
        $this->validation->validate($student);

        if (!$this->notificationError->hasErrors()){
            //Update student
            $this->studentStorage->deleteStudant($student);
        }
    }

    private function createStudentEntity(RequestDeleteStudent $requestDeleteStudent)
    {
        return StudentEntity::create(null, $requestDeleteStudent->id, null,
            null, null, null);
    }
}