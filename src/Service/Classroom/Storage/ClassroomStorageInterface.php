<?php

namespace App\Service\Classroom\Storage;

use App\Service\Classroom\Entity\ClassroomEntity;

interface ClassroomStorageInterface
{
    public function getDrivingSchoolExists(?int $drivingSchoolId);

    public function getInstructorExists(?int $instructorId);

    public function getStudantExists(?int $studentId);

    public function getVehicleExists(?int $vehicleId);

    public function saveClassroom(ClassroomEntity $classroomEntity);

    public function getClassroomExists(?int $classroomId);

    public function updateClassroom(ClassroomEntity $classroomEntity);

    public function deleteClassroom(ClassroomEntity $classroomEntity);

    public function getAllClassroomFromDrivingSchool(?int $drivingSchoolId);

    public function getClassroomById(?int $classroomId);
}