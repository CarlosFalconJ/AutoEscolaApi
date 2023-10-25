<?php

namespace App\Helper;

use Symfony\Component\HttpFoundation\JsonResponse;

class ResponseHttpHelper
{
    public static function setResponse(JsonResponse $response, NotificationError $notificationError, $responseData, $responseCode)
    {
        if (!$notificationError->hasErrors()) {
            $statusCodeHttp = ResponseCodeGenericsHelper::getStatusCodeHttp($responseCode);

            $response->setStatusCode($statusCodeHttp);
            $response->setData($responseData);
        }

        if ($notificationError->hasErrors()) {
            $errors = $notificationError->getErrors();
            $responseCode = $notificationError->getCodigoErro();
            $statusCodeHttp = ResponseCodeGenericsHelper::getStatusCodeHttp($responseCode);

            $response->setStatusCode($statusCodeHttp);
            $response->setData(["erros" => $errors]);

        }
    }

    public static function getResponseError(\Exception $exception)
    {
        var_dump($exception->getMessage());
        return new JsonResponse(["erro" => 'Opa, Algo deu errado'], StatusCodeHelper::HTTP_INTERNAL_SERVER_ERROR);
    }
}