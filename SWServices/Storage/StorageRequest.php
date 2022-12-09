<?php

namespace SWServices\Storage;

use Exception;
use SWServices\Services;
use SWServices\Helpers\RequestHelper as HttpRequest;
use SWServices\Helpers\ResponseHelper as Response;

class StorageRequest extends Services
{
    /**
     * Método interno que envía parámetros al request.
     * @param string $uuid Folio del comprobante.
     * @return HttpRequest
     */
    protected static function postStorage($uuid)
    {
        try {
            $response = HttpRequest::postPath(Services::get_urlApi(), '/datawarehouse/v1/live/' . $uuid, Services::get_token(), Services::get_proxy());
            return $response;
        } catch (Exception $e) {
            return Response::handleException($e);
        }
    }
}