<?php

namespace SWServices\Pendings;

use SWServices\Pendings\PendingsRequest as PendingsRequest;
use SWServices\Pendings\PendingsHandler as PendingsHandler;
use SWServices\Services as Services;
use Exception;

class PendingsService extends Services
{
    public function __construct($params)
    {
        parent::__construct($params);
    }
    public static function Set($params)
    {
        return new PendingsService($params);
    }
    public static function PendientesPorCancelar($rfc)
    {
        return PendingsRequest::sendReqGet(Services::get_url(), Services::get_token(), $rfc, Services::get_proxy(), '/pendings/');
    }
}
