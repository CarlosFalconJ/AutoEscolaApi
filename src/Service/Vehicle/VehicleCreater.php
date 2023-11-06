<?php

namespace App\Service\Vehicle;

use App\Dto\Vehicle\RequestCreateVehicle;
use App\Helper\NotificationError;
use App\Service\Vehicle\Entity\VehicleEntity;
use App\Service\Vehicle\Storage\VehicleStorageInterface;
use App\Service\Vehicle\Validation\VehicleCreaterValidation;

class VehicleCreater
{
    private NotificationError $notificationError;
    private VehicleStorageInterface $vehicleStorage;
    private VehicleCreaterValidation $validation;

    public function __construct(NotificationError $notificationError, VehicleStorageInterface $vehicleStorage)
    {
        $this->notificationError = $notificationError;
        $this->vehicleStorage = $vehicleStorage;
        $this->validation = new VehicleCreaterValidation($notificationError, $vehicleStorage);
    }
    public function create(RequestCreateVehicle $requestCreateVehicle)
    {
        //Create entity vehicle
        $vehicleEntity = $this->createVehicleEntity($requestCreateVehicle);

        //Validate info vehicle
        $this->validation->validate($vehicleEntity);

        if (!$this->notificationError->hasErrors()){
            //Create student
            $this->vehicleStorage->saveVehicle($vehicleEntity);
        }
    }

    private function createVehicleEntity(RequestCreateVehicle $requestCreateVehicle)
    {
        return new VehicleEntity($requestCreateVehicle->driving_school_id, null, $requestCreateVehicle->plate,
            $requestCreateVehicle->color, $requestCreateVehicle->renavam, $requestCreateVehicle->model);
    }
}