<?php

namespace App\Helper;

use Symfony\Component\HttpFoundation\Response;

class StatusCodeHelper extends Response
{
    const HTTP_OK           = Response::HTTP_OK;
    const HTTP_CREATED      = Response::HTTP_CREATED;
    const HTTP_NO_CONTENT   = Response::HTTP_NO_CONTENT;
    const HTTP_BAD_REQUEST  = Response::HTTP_BAD_REQUEST;
    const HTTP_NOT_FOUND    = Response::HTTP_NOT_FOUND;
    const HTTP_CONFLICT     = Response::HTTP_CONFLICT;
    const HTTP_UNAUTHORIZED = Response::HTTP_UNAUTHORIZED;
    const HTTP_FORBIDDEN    = Response::HTTP_FORBIDDEN;
    const HTTP_INTERNAL_SERVER_ERROR = Response::HTTP_INTERNAL_SERVER_ERROR;
    const HTTP_REQUEST_TIMEOUT = Response::HTTP_REQUEST_TIMEOUT;
}