<?php

namespace App\Service\DrivingSchool\Validation\Validations;

use App\Helper\NotificationError;
use App\Helper\ResponseCodeGenericsHelper;
use App\Service\DrivingSchool\Entity\DrivingSchool;
use App\Service\DrivingSchool\Storage\DrivingSchoolStorageInterface;

class DrivingSchooExists
{
    private DrivingSchoolStorageInterface $drivingSchoolStorage;
    private NotificationError $notificationError;

    public function __construct(DrivingSchoolStorageInterface $drivingSchoolStorage, NotificationError $notificationError)
    {
        $this->drivingSchoolStorage = $drivingSchoolStorage;
        $this->notificationError = $notificationError;
    }

    public function check(DrivingSchool $drivingSchool)
    {
        $drivingSchooExists = $this->drivingSchoolStorage->getDrivingSchooExists($drivingSchool->getId());

        if (!$drivingSchooExists) {
            $this->notificationError->setCodigoErro(ResponseCodeGenericsHelper::CONFLICT);
            $this->notificationError->addErro('driving_school', 'Essa Autoescola não existe');
        }
    }
}