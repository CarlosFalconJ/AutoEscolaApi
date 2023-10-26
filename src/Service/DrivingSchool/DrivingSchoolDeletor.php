<?php

namespace App\Service\DrivingSchool;

use App\Dto\RequestDeleteDrivingSchool;
use App\Helper\NotificationError;
use App\Service\DrivingSchool\Entity\DrivingSchool;
use App\Service\DrivingSchool\Storage\DrivingSchoolStorageInterface;
use App\Service\DrivingSchool\Validation\DrivingSchoolDeletorValidation;

class DrivingSchoolDeletor
{
    private DrivingSchoolStorageInterface $drivingSchoolStorage;
    private NotificationError $notificationError;
    private DrivingSchoolDeletorValidation $validation;

    public function __construct(NotificationError $notificationError, DrivingSchoolStorageInterface $drivingSchoolStorage)
    {
        $this->notificationError = $notificationError;
        $this->drivingSchoolStorage = $drivingSchoolStorage;
        $this->validation = new DrivingSchoolDeletorValidation($notificationError, $drivingSchoolStorage);
    }

    public function delete(RequestDeleteDrivingSchool $requestDeleteDrivingSchool)
    {
        //Create entity driving school
        $drivingSchool = $this->createDrivingSchoolEntity($requestDeleteDrivingSchool);

        //Validate info driving school
        $this->validation->validate($drivingSchool);

        if (!$this->notificationError->hasErrors()){
            //Delete driving school
            $this->drivingSchoolStorage->deleteDrivingSchool($drivingSchool);
        }
    }

    private function createDrivingSchoolEntity(RequestDeleteDrivingSchool $requestDeleteDrivingSchool)
    {
        return DrivingSchool::create(
            $requestDeleteDrivingSchool->id, null, null,
            null, null
        );
    }
}