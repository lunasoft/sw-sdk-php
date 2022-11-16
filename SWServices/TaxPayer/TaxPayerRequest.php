<?php

namespace SWServices\TaxPayer;

use Exception;
use SWServices\Services;
use SWServices\Helpers\ResponseHelper as Response;
use SWServices\Helpers\RequestHelper as HttpRequest;

class TaxPayerRequest extends Services
{
    protected static function getTaxPayer($url, $token, $rfc, $proxy)
    {
        try{
            if (!isset($rfc) || strlen($rfc) < 12 || strlen($rfc) > 13) {
                return Response::toErrorResponse("El RFC no es válido o viene vacío.");
            }
            return HttpRequest::get($url, '/taxpayers/'. $rfc, $token, $proxy);
        }
        catch(Exception $ex) {
            return Response::handleException($ex);
        }
    }
}