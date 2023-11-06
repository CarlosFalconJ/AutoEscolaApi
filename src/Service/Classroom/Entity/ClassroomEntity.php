<?php

namespace App\Service\Classroom\Entity;

class ClassroomEntity
{
    private int|null $drivingSchoolId;
    private int|null $id;
    private string|null $date;
    private int|null $studentId;
    private int|null $instructorId;
    private int|null $vehicleId;

    public function __construct (int|null $drivingSchoolId, int|null $id, string|null  $date, int|null $studentId, int|null $instructorId, int|null $vehicleId)
    {
        $this->drivingSchoolId = $drivingSchoolId;
        $this->id = $id;
        $this->date = $date;
        $this->studentId = $studentId;
        $this->instructorId = $instructorId;
        $this->vehicleId = $vehicleId;
    }

    public static function create(int|null $drivingSchoolId, int|null $id, string|null  $date, int|null $studentId, int|null $instructorId, int|null $vehicleId)
    {
        return new static($drivingSchoolId, $id, $date, $studentId, $instructorId, $vehicleId);
    }

    public function getDrivingSchoolId(): ?int
    {
        return $this->drivingSchoolId;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?string
    {
        return $this->date;
    }

    public function getStudentId(): ?int
    {
        return $this->studentId;
    }

    public function getInstructorId(): ?int
    {
        return $this->instructorId;
    }

    public function getVehicleId(): ?int
    {
        return $this->vehicleId;
    }
}