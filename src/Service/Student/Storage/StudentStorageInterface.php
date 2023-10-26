<?php

namespace App\Service\Student\Storage;

use App\Service\Student\Entity\StudentEntity;

interface StudentStorageInterface
{
    public function saveStudent(StudentEntity $studentEntity);

    public function updateStudant(StudentEntity $studentEntity);

    public function deleteStudant(StudentEntity $studentEntity);

    public function getStudentWithCpf(int|null $studentId, string $cpf);

    public function getDrivingSchoolExists(int $drivingSchoolId);

    public function getStudantExists(int $studentId);

    public function getAllStudantsFromDrivingSchool(int|null $drivingSchoolId);

    public function getStudantById(int|null $studentId);
}