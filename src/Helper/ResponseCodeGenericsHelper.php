<?php

namespace App\Helper;

class ResponseCodeGenericsHelper
{
    const OK           = 1;
    const CREATED      = 2;
    const NO_CONTENT   = 3;
    const BAD_REQUEST  = 4;
    const NOT_FOUND    = 5;
    const CONFLICT     = 6;
    const UNAUTHORIZED = 7;
    const FORBIDDEN    = 8;
    const INTERNAL_SERVER_ERROR = 9;
    const REQUEST_TIMEOUT = 10;

    public static function getStatusCodeHttp($codeGeneric)
    {
        switch ($codeGeneric){
            case self::OK:
                $resposeHttpCode = StatusCodeHelper::HTTP_OK;
                break;
            case self::CREATED:
                $resposeHttpCode = StatusCodeHelper::HTTP_CREATED;
                break;
            case self::NO_CONTENT:
                $resposeHttpCode = StatusCodeHelper::HTTP_NO_CONTENT;
                break;
            case self::BAD_REQUEST:
                $resposeHttpCode = StatusCodeHelper::HTTP_BAD_REQUEST;
                break;
            case self::NOT_FOUND:
                $resposeHttpCode = StatusCodeHelper::HTTP_NOT_FOUND;
                break;
            case self::CONFLICT:
                $resposeHttpCode = StatusCodeHelper::HTTP_CONFLICT;
                break;
            case self::UNAUTHORIZED:
                $resposeHttpCode = StatusCodeHelper::HTTP_UNAUTHORIZED;
                break;
            case self::FORBIDDEN:
                $resposeHttpCode = StatusCodeHelper::HTTP_FORBIDDEN;
                break;
            case self::REQUEST_TIMEOUT:
                $resposeHttpCode = StatusCodeHelper::HTTP_REQUEST_TIMEOUT;
                break;
            default:
                $resposeHttpCode = StatusCodeHelper::HTTP_INTERNAL_SERVER_ERROR;
                break;
        }

        return $resposeHttpCode;
    }
}