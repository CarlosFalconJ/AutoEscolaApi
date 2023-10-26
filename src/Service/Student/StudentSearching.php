<?php

namespace App\Service\Student;

use App\Service\Student\Storage\StudentStorageInterface;

class StudentSearching
{
    private StudentStorageInterface $studentStorage;

    public function __construct(StudentStorageInterface $studentStorage)
    {
        $this->studentStorage = $studentStorage;
    }

    public function search(int|null $studentId)
    {
        $student = $this->studentStorage->getStudantById($studentId);

        if (!empty($student)) {
            $student['birth_date'] = $student['birth_date']->format('Y-m-d');
        }


        return $student;
    }

}