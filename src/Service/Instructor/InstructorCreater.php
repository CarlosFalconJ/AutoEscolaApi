<?php

namespace App\Service\Instructor;

use App\Dto\Instructor\RequestCreateInstructor;
use App\Helper\NotificationError;
use App\Service\Instructor\Entity\InstructorEntity;
use App\Service\Instructor\Storage\InstructorStorageInterface;
use App\Service\Instructor\Validation\InstructorCreaterValidation;

class InstructorCreater
{
    private NotificationError $notificationError;
    private InstructorStorageInterface $instructorStorage;
    private InstructorCreaterValidation $validation;

    public function __construct(NotificationError $notificationError, InstructorStorageInterface $instructorStorage)
    {
        $this->notificationError = $notificationError;
        $this->instructorStorage = $instructorStorage;
        $this->validation = new InstructorCreaterValidation($notificationError, $instructorStorage);
    }

    public function create(RequestCreateInstructor $requestCreateInstructor)
    {
        $instructorEntity = $this->createInstructorEntity($requestCreateInstructor);

        $this->validation->validate($instructorEntity);

        if (!$this->notificationError->hasErrors()){
            //Create instructor
            $this->instructorStorage->saveInstructor($instructorEntity);
        }
    }

    private function createInstructorEntity(RequestCreateInstructor $requestCreateInstructor)
    {
        return instructorEntity::create($requestCreateInstructor->driving_school_id, null, $requestCreateInstructor->name,
            $requestCreateInstructor->email, $requestCreateInstructor->phone, $requestCreateInstructor->birth_date,
            $requestCreateInstructor->cpf, $requestCreateInstructor->category);
    }

}