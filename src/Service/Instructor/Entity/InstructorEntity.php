<?php

namespace App\Service\Instructor\Entity;

class InstructorEntity
{
    private int|null $driving_school_id;
    private int|null $id;
    private string|null $name;
    private string|null $email;
    private string|null $phone;
    private string|null $birth_date;
    private string|null $cpf;
    private string|null $category;

    public function __construct (int|null $driving_school_id, int|null $id, string|null  $name, string|null $email, string|null  $phone, string|null $birth_date, string|null $cpf, string|null $category)
    {
        $this->driving_school_id = $driving_school_id;
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->phone = $phone;
        $this->birth_date = $birth_date;
        $this->cpf = $cpf;
        $this->category = $category;
    }

    public static function create(int|null $driving_school_id, int|null $id, string|null $name, string|null $email, string|null  $phone, string|null $birth_date, string|null $cpf, string|null $category)
    {
        return new static($driving_school_id, $id, $name, $email, $phone, $birth_date, $cpf, $category);
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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function getCategory(): ?string
    {
        return $this->category;
    }
}