<?php

namespace App\Service\Instructor\Validation\Validations;

use App\Service\Instructor\Entity\InstructorEntity;
use App\Helper\NotificationErrorRespectValidationAdpter;
use App\Helper\ResponseCodeGenericsHelper;
use Respect\Validation\Validator as v;

class InstructorValidation extends NotificationErrorRespectValidationAdpter
{
    public function validateData(InstructorEntity $instructorEntity)
    {
        $dataIsValid = parent::validate([
            'name' => $instructorEntity->getName(),
            'email' => $instructorEntity->getEmail(),
            'phone' => $instructorEntity->getPhone(),
            'birth_date' => $instructorEntity->getBirthDate(),
            'cpf' => $instructorEntity->getCpf(),
            'category' => $instructorEntity->getCategory(),
        ]);

        if (!$dataIsValid){
            $this->notificationErrors->setCodigoErro(ResponseCodeGenericsHelper::BAD_REQUEST);
        }
    }

    protected function getErrorsMessages($data)
    {
        return [
            'name' => ['Nome invalido', []],
            'email' => ['Email invalido', []],
            'phone' => ['Telefone inválido', []],
            'birth_date' => ['Data de nacimento inválido', []],
            'cpf' => ['Cpf inválido', []],
            'category' => ['Categoria da CNH inválida', []],
        ];
    }

    protected function getValidation($data)
    {
        return v::arrayType()
            ->key('name', v::stringType()->notEmpty()->setName("name"))
            ->key('email', v::email()->notEmpty()->setName("email"))
            ->key('phone', v::phone()->notEmpty()->setName("phone"))
            ->key('birth_date', v::dateTime()->notEmpty()->setName("birth_date"))
            ->key('cpf', v::cpf()->notEmpty()->setName("cpf"))
            ->key('category', v::in(['A', 'B', 'C', 'D', 'E'])->setName("category"));
    }

}