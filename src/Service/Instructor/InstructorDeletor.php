<?php

namespace App\Service\Instructor;

use App\Dto\Instructor\RequestDeleteInstructor;
use App\Helper\NotificationError;
use App\Service\Instructor\Entity\InstructorEntity;
use App\Service\Instructor\Storage\InstructorStorageInterface;
use App\Service\Instructor\Validation\InstructorDeletorValidation;

class InstructorDeletor
{
    private NotificationError $notificationError;
    private InstructorStorageInterface $instructorStorage;
    private InstructorDeletorValidation $validation;

    public function __construct(NotificationError $notificationError, InstructorStorageInterface $instructorStorage)
    {
        $this->notificationError = $notificationError;
        $this->instructorStorage = $instructorStorage;
        $this->validation = new InstructorDeletorValidation($notificationError, $instructorStorage);
    }

    public function delete(RequestDeleteInstructor $requestDeleteInstructor)
    {
        $instructor = $this->createStudentEntity($requestDeleteInstructor);

        //Validate info instructor
        $this->validation->validate($instructor);

        if (!$this->notificationError->hasErrors()){
            //Delete instructor
            $this->instructorStorage->deleteInstructor($instructor);
        }
    }

    private function createStudentEntity(RequestDeleteInstructor $requestDeleteInstructor)
    {
        return InstructorEntity::create(null, $requestDeleteInstructor->id, null,
            null, null, null, null, null);
    }
}