<?php

namespace App\Dto\DrivingSchool;

class RequestDeleteDrivingSchool
{
    public $id;

    public function __construct($data)
    {
        $this->id = isset($data['id']) ? (int)$data['id'] : null;
    }

    public static function create($data)
    {
        return new static($data);
    }
}