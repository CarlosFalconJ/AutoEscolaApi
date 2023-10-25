<?php

namespace App\Dto;

class RequestCreateDrivingSchool
{
    public $name;
    public $cnpj;
    public $address;
    public $phone;

    public function __construct($data)
    {
        $this->name = isset($data['name']) ? (string)$data['name'] : '';
        $this->cnpj = isset($data['cnpj']) ? (string)$data['cnpj'] : '';
        $this->address = isset($data['address']) ? (string)$data['address'] : '';
        $this->phone = isset($data['phone']) ? (string)$data['phone'] : '';
    }

    public static function create($data)
    {
        return new static($data);
    }
}