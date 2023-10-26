<?php

namespace App\Service\Student;

use App\Service\Student\Storage\StudentStorageInterface;

class StudentSearchingAll
{
    private StudentStorageInterface $studentStorage;

    public function __construct(StudentStorageInterface $studentStorage)
    {
        $this->studentStorage = $studentStorage;
    }

    public function searchAll(int|null $drivingSchoolId)
    {
        $students = $this->studentStorage->getAllStudantsFromDrivingSchool($drivingSchoolId);

        $studentInfo = array_map(function ($student){
            $dateFormat = $student['birth_date']->format('Y-m-d');

            return [
                'id' => $student['id'],
                'name' => $student['name'],
                'phone' => $student['phone'],
                'cpf' => $student['cpf'],
                'birth_date' => $dateFormat,
            ];
        }, $students);

        return $studentInfo;
    }
}