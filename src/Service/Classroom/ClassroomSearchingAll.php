<?php

namespace App\Service\Classroom;

use App\Service\Classroom\Storage\ClassroomStorageInterface;

class ClassroomSearchingAll
{
    private ClassroomStorageInterface $classroomStorage;

    public function __construct(ClassroomStorageInterface $classroomStorage)
    {
        $this->classroomStorage = $classroomStorage;
    }

    public function searchAll(?int $drivingSchoolId)
    {
        $classrooms = $this->classroomStorage->getAllClassroomFromDrivingSchool($drivingSchoolId);

        $classroomInfo = array_map(function ($classroom){
            $dateFormat = $classroom['date']->format('Y-m-d H:i:s');

            return [
                'id' => $classroom['id'],
                'student_name' => $classroom['student_name'],
                'instructor_name' => $classroom['instructor_name'],
                'vehicle_model' => $classroom['vehicle_model'],
                'date' => $dateFormat,
            ];
        }, $classrooms);

        return $classroomInfo;
    }
}