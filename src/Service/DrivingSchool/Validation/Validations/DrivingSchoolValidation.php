<?php

namespace App\Service\DrivingSchool\Validation\Validations;

use App\Helper\NotificationErrorRespectValidationAdpter;
use App\Helper\ResponseCodeGenericsHelper;
use App\Service\DrivingSchool\Entity\DrivingSchool;
use Respect\Validation\Validator as v;

class DrivingSchoolValidation extends NotificationErrorRespectValidationAdpter
{

    public function validateData(DrivingSchool $drivingSchool)
    {
        $dataIsValid = parent::validate([
            'name' => $drivingSchool->getName(),
            'cnpj' => $drivingSchool->getCnpj(),
            'address' => $drivingSchool->getAddress(),
            'phone' => $drivingSchool->getPhone(),
        ]);

        if (!$dataIsValid){
            $this->notificationErrors->setCodigoErro(ResponseCodeGenericsHelper::BAD_REQUEST);
        }
    }

    protected function getErrorsMessages($data)
    {
        return [
            'name' => ['Nome invalido', []],
            'cnpj' => ['Cnpj inválido', []],
            'address' => ['Endereço inválido', []],
            'phone' => ['Telefone inválido', []],
        ];
    }

    protected function getValidation($data)
    {
        return v::arrayType()
            ->key('name', v::stringType()->notEmpty()->setName("name"))
            ->key('cnpj', v::cnpj()->notEmpty()->setName('cnpj'))
            ->key('address', v::stringType()->notEmpty()->setName("address"))
            ->key('phone', v::phone()->notEmpty()->setName("phone"));
    }
}