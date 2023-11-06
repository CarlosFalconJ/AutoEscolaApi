<?php

namespace App\Dto\Classroom;

class RequestUpdateClassroom
{
    public $id;
    public $date;
    public $studentId;
    public $instructorId;
    public $vehicleId;

    public function __construct($data)
    {
        $this->id = isset($data['id']) ? (int)$data['id'] : null;
        $this->date = (isset($data['date']) && !empty($data['date'])) ? $data['date'] : null;
        $this->studentId = isset($data['student_id']) ? (int)$data['student_id'] : null;
        $this->instructorId = isset($data['instructor_id']) ? (int)$data['instructor_id'] : null;
        $this->vehicleId = isset($data['vehicle_id']) ? (int)$data['vehicle_id'] : null;
    }

    public static function create($data)
    {
        return new static($data);
    }
}