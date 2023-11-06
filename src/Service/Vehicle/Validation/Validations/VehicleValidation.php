<?php

namespace App\Service\Vehicle\Validation\Validations;

use App\Helper\NotificationErrorRespectValidationAdpter;
use App\Helper\ResponseCodeGenericsHelper;
use App\Service\Vehicle\Entity\VehicleEntity;
use Respect\Validation\Validator as v;

class VehicleValidation extends NotificationErrorRespectValidationAdpter
{
    public function validateData(VehicleEntity $vehicleEntity)
    {
        $dataIsValid = parent::validate([
            'color' => $vehicleEntity->getColor(),
            'plate' => $vehicleEntity->getPlate(),
            'renavam' => $vehicleEntity->getRenavam(),
            'model' => $vehicleEntity->getModel(),
        ]);

        if (!$dataIsValid){
            $this->notificationErrors->setCodigoErro(ResponseCodeGenericsHelper::BAD_REQUEST);
        }
    }

    protected function getErrorsMessages($data)
    {
        return [
            'color' => ['Cor invalida', []],
            'plate' => ['Placa inválida', []],
            'renavam' => ['Renavam inválido', []],
            'model' => ['Modelo inválido', []]
        ];
    }

    protected function getValidation($data)
    {
        return v::arrayType()
            ->key('color', v::stringType()->notEmpty()->setName("color"))
            ->key('plate', v::regex('/[A-z]{3}-\d[A-j0-9]\d{2}/')->setName("plate"))
            ->key('renavam', v::stringType()->notEmpty()->setName("renavam"))
            ->key('model', v::stringType()->notEmpty()->setName("model"));
    }
}