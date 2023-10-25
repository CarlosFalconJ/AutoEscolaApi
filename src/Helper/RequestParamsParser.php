<?php

namespace App\Helper;

use Symfony\Component\HttpFoundation\Request;

class RequestParamsParser
{
    public static function requestToArray(Request $request, array $parametrosRequisicao = [], array $parametrosExtras = [])
    {
        $parametrosTratados = [];

        foreach ($parametrosRequisicao as $parametro){
            $parametrosTratados[$parametro] = $request->attributes->get($parametro);
        }

        return array_merge_recursive($request->query->all(), $request->request->all(), $parametrosTratados, $parametrosExtras);
    }
}