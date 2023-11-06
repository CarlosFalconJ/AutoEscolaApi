<?php

namespace App\Service\Vehicle;

use App\Dto\Vehicle\RequestUpdateVehicle;
use App\Helper\NotificationError;
use App\Service\Vehicle\Entity\VehicleEntity;
use App\Service\Vehicle\Storage\VehicleStorageInterface;
use App\Service\Vehicle\Validation\VehicleUpdaterValidation;

class VehicleUpdater
{
    private NotificationError $notificationError;
    private VehicleStorageInterface $vehicleStorage;
    private VehicleUpdaterValidation $validation;

    public function __construct(NotificationError $notificationError, VehicleStorageInterface $vehicleStorage)
    {
        $this->notificationError = $notificationError;
        $this->vehicleStorage = $vehicleStorage;
        $this->validation = new VehicleUpdaterValidation($notificationError, $vehicleStorage);
    }

    public function update(RequestUpdateVehicle $requestUpdateVehicle)
    {
        //Create entity vehicle
        $vehicleEntity = $this->createVehicleEntity($requestUpdateVehicle);

        //Validate info student
        $this->validation->validate($vehicleEntity);

        if (!$this->notificationError->hasErrors()){
            //Update student
            $this->vehicleStorage->updateVehicle($vehicleEntity);
        }
    }

    private function createVehicleEntity(RequestUpdateVehicle $requestUpdateVehicle)
    {
        return new VehicleEntity(null, $requestUpdateVehicle->id, $requestUpdateVehicle->plate,
            $requestUpdateVehicle->color, $requestUpdateVehicle->renavam, $requestUpdateVehicle->model);
    }
}