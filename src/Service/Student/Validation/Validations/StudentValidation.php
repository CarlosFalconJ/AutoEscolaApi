<?php

namespace App\Service\Student\Validation\Validations;

use App\Helper\NotificationErrorRespectValidationAdpter;
use App\Helper\ResponseCodeGenericsHelper;
use App\Service\Student\Entity\StudentEntity;
use Respect\Validation\Validator as v;

class StudentValidation extends NotificationErrorRespectValidationAdpter
{
    public function validateData(StudentEntity $studentEntity)
    {
        $dataIsValid = parent::validate([
            'name' => $studentEntity->getName(),
            'phone' => $studentEntity->getPhone(),
            'birth_date' => $studentEntity->getBirthDate(),
            'cpf' => $studentEntity->getCpf(),
        ]);

        if (!$dataIsValid){
            $this->notificationErrors->setCodigoErro(ResponseCodeGenericsHelper::BAD_REQUEST);
        }
    }

    protected function getErrorsMessages($data)
    {
        return [
            'name' => ['Nome invalido', []],
            'phone' => ['Telefone inválido', []],
            'birth_date' => ['Data de nacimento inválido', []],
            'cpf' => ['Cpf inválido', []],
        ];
    }

    protected function getValidation($data)
    {
        return v::arrayType()
            ->key('name', v::stringType()->notEmpty()->setName("name"))
            ->key('phone', v::phone()->notEmpty()->setName("phone"))
            ->key('birth_date', v::dateTime()->notEmpty()->setName("birth_date"))
            ->key('cpf', v::cpf()->notEmpty()->setName("cpf"));
    }
}