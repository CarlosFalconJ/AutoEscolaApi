<?php

namespace App\Service\Student;

use App\Dto\Student\RequestUpdateStudent;
use App\Helper\NotificationError;
use App\Service\Student\Entity\StudentEntity;
use App\Service\Student\Storage\StudentStorageInterface;
use App\Service\Student\Validation\StudentUpdaterValidation;

class StudentUpdater
{
    private NotificationError $notificationError;
    private StudentStorageInterface $studentStorage;
    private StudentUpdaterValidation $validation;

    public function __construct(NotificationError $notificationError, StudentStorageInterface $studentStorage)
    {
        $this->notificationError = $notificationError;
        $this->studentStorage = $studentStorage;
        $this->validation = new StudentUpdaterValidation($notificationError, $studentStorage);
    }

    public function update(RequestUpdateStudent $requestUpdateStudent)
    {
        $student = $this->createStudentEntity($requestUpdateStudent);

        //Validate info student
        $this->validation->validate($student);

        if (!$this->notificationError->hasErrors()){
            //Update student
            $this->studentStorage->updateStudant($student);
        }
    }

    private function createStudentEntity(RequestUpdateStudent $requestUpdateStudent)
    {
        return StudentEntity::create($requestUpdateStudent->driving_school_id, $requestUpdateStudent->id, $requestUpdateStudent->name,
            $requestUpdateStudent->phone, $requestUpdateStudent->birth_date, $requestUpdateStudent->cpf);
    }
}