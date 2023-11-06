<?php

namespace App\Service\Vehicle\Entity;

class VehicleEntity
{
    private int|null $driving_school_id;
    private int|null $id;
    private string|null $plate;
    private string|null $color;
    private string|null $renavam;
    private string|null $model;


    public function __construct (int|null $driving_school_id, int|null $id, string|null $plate, string|null $color, string|null $renavam, string|null $model)
    {
        $this->driving_school_id = $driving_school_id;
        $this->id = $id;
        $this->plate = $plate;
        $this->color = $color;
        $this->renavam = $renavam;
        $this->model = $model;
    }

    public static function create(int|null $driving_school_id, int|null $id, string|null $plate, string|null $color, string|null $renavam, string|null $model)
    {
        return new static($driving_school_id, $id, $plate, $color, $renavam, $model);
    }

    public function getDrivingSchoolId(): ?int
    {
        return $this->driving_school_id;
    }

    public function setDrivingSchoolId(?int $driving_school_id): void
    {
        $this->driving_school_id = $driving_school_id;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getPlate(): ?string
    {
        return $this->plate;
    }

    public function setPlate(?string $plate): void
    {
        $this->plate = $plate;
    }

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(?string $color): void
    {
        $this->color = $color;
    }

    public function getRenavam(): ?string
    {
        return $this->renavam;
    }

    public function setRenavam(?string $renavam): void
    {
        $this->renavam = $renavam;
    }

    public function getModel(): ?string
    {
        return $this->model;
    }

    public function setModel(?string $model): void
    {
        $this->model = $model;
    }
}