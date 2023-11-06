<?php

namespace App\Dto\Vehicle;

class RequestCreateVehicle
{
    public $driving_school_id;
    public $plate;
    public $color;
    public $renavam;
    public $model;

    public function __construct($data)
    {
        $this->driving_school_id = isset($data['driving_school_id']) ? (string)$data['driving_school_id'] : null;
        $this->plate = isset($data['plate']) ? (string)$data['plate'] : '';
        $this->color = isset($data['color']) ? (string)$data['color'] : '';
        $this->renavam = isset($data['renavam']) ? (string)$data['renavam'] : '';
        $this->model = isset($data['model']) ? (string)$data['model'] : '';
    }

    public static function create($data)
    {
        return new static($data);
    }
}