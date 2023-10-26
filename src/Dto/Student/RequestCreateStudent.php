<?php

namespace App\Dto\Student;

class RequestCreateStudent
{
    public $driving_school_id;
    public $name;
    public $phone;
    public $birth_date;
    public $cpf;

    public function __construct($data)
    {
        $this->driving_school_id = isset($data['driving_school_id']) ? (string)$data['driving_school_id'] : null;
        $this->name = isset($data['name']) ? (string)$data['name'] : '';
        $this->phone = isset($data['phone']) ? (string)$data['phone'] : '';
        $this->birth_date = (isset($data['birth_date']) && !empty($data['birth_date'])) ? $data['birth_date'] : null;
        $this->cpf = isset($data['cpf']) ? (string)$data['cpf'] : '';
    }

    public static function create($data)
    {
        return new static($data);
    }
}