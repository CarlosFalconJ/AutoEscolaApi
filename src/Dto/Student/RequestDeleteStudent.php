<?php

namespace App\Dto\Student;

class RequestDeleteStudent
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