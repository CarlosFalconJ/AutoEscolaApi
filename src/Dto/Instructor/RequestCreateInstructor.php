<?php

namespace App\Dto\Instructor;

class RequestCreateInstructor
{
    public $driving_school_id;
    public $name;
    public $email;
    public $phone;
    public $cpf;
    public $birth_date;
    public $category;

    public function __construct($data)
    {
        $this->driving_school_id = isset($data['driving_school_id']) ? (string)$data['driving_school_id'] : null;
        $this->name = isset($data['name']) ? (string)$data['name'] : '';
        $this->email = isset($data['email']) ? (string)$data['email'] : '';
        $this->phone = isset($data['phone']) ? (string)$data['phone'] : '';
        $this->cpf = isset($data['cpf']) ? (string)$data['cpf'] : '';
        $this->birth_date = (isset($data['birth_date']) && !empty($data['birth_date'])) ? $data['birth_date'] : null;
        $this->category = isset($data['category']) ? (string)$data['category'] : '';
    }

    public static function create($data)
    {
        return new static($data);
    }
}