<?php

namespace App\Service\DrivingSchool;

use App\Dto\DrivingSchool\RequestCreateDrivingSchool;
use App\Helper\NotificationError;
use App\Service\DrivingSchool\Entity\DrivingSchool;
use App\Service\DrivingSchool\Storage\DrivingSchoolStorageInterface;
use App\Service\DrivingSchool\Validation\DrivingSchoolCreaterValidation;

class DrivingSchoolCreater
{
    private DrivingSchoolStorageInterface $drivingSchoolStorage;
    private DrivingSchoolCreaterValidation $validation;
    private NotificationError $notificationError;

    public function __construct(NotificationError $notificationError, DrivingSchoolStorageInterface $drivingSchoolStorage)
    {
        $this->notificationError = $notificationError;
        $this->drivingSchoolStorage = $drivingSchoolStorage;
        $this->validation = new DrivingSchoolCreaterValidation($notificationError, $drivingSchoolStorage);
    }

    public function create(RequestCreateDrivingSchool $requestCreateDrivingSchool)
    {
        //Create entity driving school
        $drivingSchool = $this->createDrivingSchoolEntity($requestCreateDrivingSchool);

        //Validate info driving school
        $this->validation->validate($drivingSchool);

        if (!$this->notificationError->hasErrors()){
            //Create driving school
            $this->drivingSchoolStorage->saveDrivingSchool($drivingSchool);
        }
    }

    private function createDrivingSchoolEntity(RequestCreateDrivingSchool $requestCreateDrivingSchool)
    {
        return DrivingSchool::create(
            null, $requestCreateDrivingSchool->name, $requestCreateDrivingSchool->cnpj,
            $requestCreateDrivingSchool->address, $requestCreateDrivingSchool->phone
        );
    }
}