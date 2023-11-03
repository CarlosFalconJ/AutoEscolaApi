<?php

namespace App\Service\Instructor;

use App\Service\Instructor\Storage\InstructorStorage;

class InstructorSearchingAll
{
    private InstructorStorage $instructorStorage;

    public function __construct(InstructorStorage $instructorStorage)
    {
        $this->instructorStorage = $instructorStorage;
    }

    public function searchAll(int|null $drivingSchoolId)
    {
        $instructors = $this->instructorStorage->getAllInstructorsFromDrivingSchool($drivingSchoolId);

        $instructorInfo = array_map(function ($instructor){
            $dateFormat = $instructor['birth_date']->format('Y-m-d');

            return [
                'id' => $instructor['id'],
                'name' => $instructor['name'],
                'email' => $instructor['email'],
                'phone' => $instructor['phone'],
                'cpf' => $instructor['cpf'],
                'category' => $instructor['category'],
                'birth_date' => $dateFormat,
            ];
        }, $instructors);

        return $instructorInfo;
    }
}