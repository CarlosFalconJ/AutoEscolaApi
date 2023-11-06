<?php

namespace App\Service\Classroom;

use App\Service\Classroom\Storage\ClassroomStorageInterface;

class ClassroomSearching
{
    private ClassroomStorageInterface $classroomStorage;

    public function __construct(ClassroomStorageInterface $classroomStorage)
    {
        $this->classroomStorage = $classroomStorage;
    }

    public function search(?int $classroomId)
    {
        $classroom = $this->classroomStorage->getClassroomById($classroomId);

        if (!empty($classroom)) {
            $classroom['date'] = $classroom['date']->format('Y-m-d H:i:s');
        }

        return $classroom;
    }
}