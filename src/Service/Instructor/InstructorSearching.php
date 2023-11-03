<?php

namespace App\Service\Instructor;

use App\Service\Instructor\Storage\InstructorStorage;
use App\Service\Instructor\Storage\InstructorStorageInterface;

class InstructorSearching
{
    private InstructorStorageInterface $instructorStorage;

    public function __construct(InstructorStorageInterface $instructorStorage)
    {
        $this->instructorStorage = $instructorStorage;
    }

    public function search(int $instructorId)
    {
        $instructor = $this->instructorStorage->getStudantById($instructorId);

        if (!empty($instructor)) {
            $instructor['birth_date'] = $instructor['birth_date']->format('Y-m-d');
        }

        return $instructor;
    }
}