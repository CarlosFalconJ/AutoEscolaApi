<?php

namespace App\Service\Student\Entity;

use App\Service\DrivingSchool\Entity\DrivingSchool;

class StudentEntity
{
    private int|null $driving_school_id;
    private int|null $id;
    private string|null $name;
    private string|null $phone;
    private string|null $birth_date;
    private string|null $cpf;

    public function __construct (int|null $driving_school_id, int|null $id, string|null  $name, string|null  $phone, string|null $birth_date, string|null $cpf)
    {
        $this->driving_school_id = $driving_school_id;
        $this->id = $id;
        $this->name = $name;
        $this->phone = $phone;
        $this->birth_date = $birth_date;
        $this->cpf = $cpf;
    }

    public static function create(int|null $driving_school_id, int|null $id, string|null  $name, string|null  $phone, string|null $birth_date, string|null $cpf)
    {
        return new static($driving_school_id, $id, $name, $phone, $birth_date, $cpf);
    }

    public function getDrivingSchoolId(): ?int
    {
        return $this->driving_school_id;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function getBirthDate(): ?string
    {
        return $this->birth_date;
    }

    public function getCpf(): ?string
    {
        return $this->cpf;
    }
}