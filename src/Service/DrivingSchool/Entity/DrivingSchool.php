<?php

namespace App\Service\DrivingSchool\Entity;

class DrivingSchool
{
    private string|null $name;
    private string|null $cnpj;
    private string|null $address;
    private string|null $phone;
    private int|null $id;

    public function __construct (int|null $id, string|null  $name, string|null  $cnpj, string|null  $address, string|null  $phone)
    {
        $this->name = $name;
        $this->cnpj = $cnpj;
        $this->address = $address;
        $this->phone = $phone;
        $this->id = $id;
    }

    public static function create(int|null $id, string|null  $name, string|null  $cnpj, string|null  $address, string|null  $phone)
    {
        return new static($id, $name, $cnpj, $address, $phone);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getCnpj(): ?string
    {
        return $this->cnpj;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }
}