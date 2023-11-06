<?php

namespace App\Service\Classroom\Validation\Validations;

use App\Helper\NotificationErrorRespectValidationAdpter;
use App\Helper\ResponseCodeGenericsHelper;
use App\Service\Classroom\Entity\ClassroomEntity;
use Respect\Validation\Validator as v;

class ClassroomValidation extends NotificationErrorRespectValidationAdpter
{
    public function validateData(ClassroomEntity $classroomEntity)
    {
        $dataIsValid = parent::validate([
            'date' => $classroomEntity->getDate()
        ]);

        if (!$dataIsValid){
            $this->notificationErrors->setCodigoErro(ResponseCodeGenericsHelper::BAD_REQUEST);
        }
    }

    protected function getErrorsMessages($data)
    {
        return [
            'date' => ['Data invalida', []]
        ];
    }

    protected function getValidation($data)
    {
        return v::arrayType()
            ->key('date', v::dateTime()->notEmpty()->setName("date"));
    }
}