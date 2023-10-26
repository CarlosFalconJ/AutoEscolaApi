<?php

namespace App\Service\DrivingSchool;

use App\Dto\RequestDeleteDrivingSchool;
use App\Helper\NotificationError;
use App\Service\DrivingSchool\Entity\DrivingSchool;
use App\Service\DrivingSchool\Storage\DrivingSchoolStorageInterface;

class DrivingSchoolDeletor
{
    private DrivingSchoolStorageInterface $drivingSchoolStorage;
    private NotificationError $notificationError;

    public function __construct(NotificationError $notificationError, DrivingSchoolStorageInterface $drivingSchoolStorage)
    {
        $this->notificationError = $notificationError;
        $this->drivingSchoolStorage = $drivingSchoolStorage;
    }

    public function delete(RequestDeleteDrivingSchool $requestDeleteDrivingSchool)
    {
        //Create entity driving school
        $drivingSchool = $this->createDrivingSchoolEntity($requestDeleteDrivingSchool);

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