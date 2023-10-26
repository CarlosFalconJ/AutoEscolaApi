<?php

namespace App\Service\Student;

use App\Dto\Student\RequestCreateStudent;
use App\Helper\NotificationError;
use App\Service\Student\Entity\StudentEntity;
use App\Service\Student\Storage\StudentStorageInterface;
use App\Service\Student\Validation\StudentCreaterValidation;

class StudentCreater
{
    private NotificationError $notificationError;
    private StudentStorageInterface $studentStorage;
    private StudentCreaterValidation $validation;

    public function __construct(NotificationError $notificationError, StudentStorageInterface $studentStorage)
    {
        $this->notificationError = $notificationError;
        $this->studentStorage = $studentStorage;
        $this->validation = new StudentCreaterValidation($notificationError, $studentStorage);
    }

    public function create(RequestCreateStudent $requestCreateStudent)
    {
        //Create entity student
        $student = $this->createStudentEntity($requestCreateStudent);

        //Validate info student
        $this->validation->validate($student);

        if (!$this->notificationError->hasErrors()){
            //Create student
            $this->studentStorage->saveStudent($student);
        }
    }

    private function createStudentEntity(RequestCreateStudent $requestCreateStudent)
    {
        return StudentEntity::create($requestCreateStudent->driving_school_id, null, $requestCreateStudent->name,
            $requestCreateStudent->phone, $requestCreateStudent->birth_date, $requestCreateStudent->cpf);
    }
}