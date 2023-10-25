<?php

namespace App\Service\DrivingSchool\Validation\Validations;

use App\Helper\NotificationError;
use App\Helper\ResponseCodeGenericsHelper;
use App\Helper\StatusCodeHelper;
use App\Service\DrivingSchool\Entity\DrivingSchool;
use App\Service\DrivingSchool\Storage\DrivingSchoolStorageInterface;

class DrivingSchoolCnpjAlreadyRegisteredValidation
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
        $cnpjAlreadyRegistered = $this->drivingSchoolStorage->getDrivingSchoolWithCnpj($drivingSchool->getId(), $drivingSchool->getCnpj());

        if ($cnpjAlreadyRegistered) {
            $this->notificationError->setCodigoErro(ResponseCodeGenericsHelper::CONFLICT);
            $this->notificationError->addErro('cnpj', 'Já existe uma auto escola registrada com esse cnpj');
        }
    }
}