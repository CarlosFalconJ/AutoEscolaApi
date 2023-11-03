<?php

namespace App\Service\Instructor\Storage;

use App\Service\Instructor\Entity\InstructorEntity;

interface InstructorStorageInterface
{

    public function getInstructorWithCpf(int|null $instructorId, string|null $cpf);

    public function getInstructorWithEmail(int|null $instructorId, string|null $email);

    public function getDrivingSchoolExists(int $drivingSchoolId);

    public function saveInstructor(InstructorEntity $instructorEntity);

    public function getInstructorExists(int $instructorId);

    public function updateInstructor(InstructorEntity $instructorEntity);

    public function deleteInstructor(InstructorEntity $instructorEntity);

    public function getStudantById(int $instructorId);
}