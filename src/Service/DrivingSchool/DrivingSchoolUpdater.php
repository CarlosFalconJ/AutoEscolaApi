<?php

namespace App\Service\DrivingSchool;

use App\Dto\DrivingSchool\RequestUpdateDrivingSchool;
use App\Helper\NotificationError;
use App\Service\DrivingSchool\Entity\DrivingSchool;
use App\Service\DrivingSchool\Storage\DrivingSchoolStorageInterface;
use App\Service\DrivingSchool\Validation\DrivingSchooUpdaterValidation;

class DrivingSchoolUpdater
{
    private DrivingSchoolStorageInterface $drivingSchoolStorage;
    private NotificationError $notificationError;
    private DrivingSchooUpdaterValidation $validation;

    public function __construct(NotificationError $notificationError, DrivingSchoolStorageInterface $drivingSchoolStorage)
    {
        $this->notificationError = $notificationError;
        $this->drivingSchoolStorage = $drivingSchoolStorage;
        $this->validation = new DrivingSchooUpdaterValidation($notificationError, $drivingSchoolStorage);
    }

    public function update(RequestUpdateDrivingSchool $requestUpdateDrivingSchool)
    {
        //Create entity driving school
        $drivingSchool = $this->createDrivingSchoolEntity($requestUpdateDrivingSchool);

        //Validate info driving school
        $this->validation->validate($drivingSchool);

        if (!$this->notificationError->hasErrors()){
            //Update driving school
            $this->drivingSchoolStorage->updateDrivingSchool($drivingSchool);
        }
    }

    private function createDrivingSchoolEntity(RequestUpdateDrivingSchool $requestUpdateDrivingSchool)
    {
        return DrivingSchool::create(
            $requestUpdateDrivingSchool->id, $requestUpdateDrivingSchool->name, $requestUpdateDrivingSchool->cnpj,
            $requestUpdateDrivingSchool->address, $requestUpdateDrivingSchool->phone
        );
    }
}