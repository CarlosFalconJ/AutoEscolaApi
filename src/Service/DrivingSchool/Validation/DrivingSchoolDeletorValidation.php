<?php

namespace App\Service\DrivingSchool\Validation;

use App\Helper\NotificationError;
use App\Service\DrivingSchool\Entity\DrivingSchool;
use App\Service\DrivingSchool\Storage\DrivingSchoolStorageInterface;
use App\Service\DrivingSchool\Validation\Validations\DrivingSchooExists;

class DrivingSchoolDeletorValidation
{
    private NotificationError $notificationError;
    private DrivingSchoolStorageInterface $drivingSchoolStorage;

    public function __construct(NotificationError $notificationError, DrivingSchoolStorageInterface $drivingSchoolStorage)
    {
        $this->notificationError = $notificationError;
        $this->drivingSchoolStorage = $drivingSchoolStorage;
    }

    public function validate(DrivingSchool $drivingSchool)
    {
        //Validate driving school exist Validation
        $drivingSchooExists = new DrivingSchooExists($this->drivingSchoolStorage, $this->notificationError);
        $drivingSchooExists->check($drivingSchool);
    }
}