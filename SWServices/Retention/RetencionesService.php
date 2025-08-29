<?php

namespace SWServices\Retention;

use SWServices\Services as Services;
use SWServices\Retention\RetencionesRequest as retencionesRequest;

class RetencionesService extends Services
{

    public function __construct($params)
    {
        parent::__construct($params);
    }
    public static function Set($params)
    {
        return new RetencionesService($params);
    }

    public static function TimbrarRetencionXMLV3($xml)
    {
        return retencionesRequest::sendReq(Services::get_url(), Services::get_token(), $xml, 'v3', false);
    }

    public static function TimbrarRetencionXMLV4($xml)
    {
        $raw = retencionesRequest::sendReq(Services::get_url(), Services::get_token(), $xml, 'v3', false);
        return retencionesRequest::normalizeFromRest($raw);
    }
}
