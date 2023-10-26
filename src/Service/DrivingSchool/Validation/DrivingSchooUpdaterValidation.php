<?php

namespace App\Service\DrivingSchool\Validation;

use App\Helper\NotificationError;
use App\Service\DrivingSchool\Entity\DrivingSchool;
use App\Service\DrivingSchool\Storage\DrivingSchoolStorageInterface;
use App\Service\DrivingSchool\Validation\Validations\DrivingSchooExists;
use App\Service\DrivingSchool\Validation\Validations\DrivingSchoolCnpjAlreadyRegisteredValidation;
use App\Service\DrivingSchool\Validation\Validations\DrivingSchoolValidation;

class DrivingSchooUpdaterValidation
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
        //Validate if data form is valid
        $keepaliveConfigDataValidation = new DrivingSchoolValidation();
        $keepaliveConfigDataValidation->setNotificationErrors($this->notificationError);
        $keepaliveConfigDataValidation->validateData($drivingSchool);

        //Validate CNPJ Already Registered Validation
        $drivingSchoolCnpjAlreadyRegisteredValidation = new DrivingSchoolCnpjAlreadyRegisteredValidation($this->drivingSchoolStorage, $this->notificationError);
        $drivingSchoolCnpjAlreadyRegisteredValidation->check($drivingSchool);

        //Validate driving school exist Validation
        $drivingSchooExists = new DrivingSchooExists($this->drivingSchoolStorage, $this->notificationError);
        $drivingSchooExists->check($drivingSchool);
    }
}