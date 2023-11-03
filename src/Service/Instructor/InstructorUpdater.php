<?php

namespace App\Service\Instructor;

use App\Dto\Instructor\RequestUpdateInstructor;
use App\Helper\NotificationError;
use App\Service\Instructor\Entity\InstructorEntity;
use App\Service\Instructor\Storage\InstructorStorageInterface;
use App\Service\Instructor\Validation\InstructorUpdaterValidation;

class InstructorUpdater
{
    private NotificationError $notificationError;
    private InstructorStorageInterface $instructorStorage;
    private InstructorUpdaterValidation $validation;

    public function __construct(NotificationError $notificationError, InstructorStorageInterface $instructorStorage)
    {
        $this->notificationError = $notificationError;
        $this->instructorStorage = $instructorStorage;
        $this->validation = new InstructorUpdaterValidation($notificationError, $instructorStorage);
    }

    public function update(RequestUpdateInstructor $requestUpdateInstructor)
    {
        $instructorEntity = $this->createInstructorEntity($requestUpdateInstructor);

        $this->validation->validate($instructorEntity);

        if (!$this->notificationError->hasErrors()){
            //Update instructor
            $this->instructorStorage->updateInstructor($instructorEntity);
        }
    }

    private function createInstructorEntity(RequestUpdateInstructor $requestUpdateInstructor)
    {
        return instructorEntity::create(null, $requestUpdateInstructor->id, $requestUpdateInstructor->name,
            $requestUpdateInstructor->email, $requestUpdateInstructor->phone, $requestUpdateInstructor->birth_date,
            $requestUpdateInstructor->cpf, $requestUpdateInstructor->category);
    }
}