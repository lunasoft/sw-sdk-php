<?php
namespace SWServices\Retention;

use SWServices\Services as Services;
use SWServices\Retention\RetencionesRequest as retencionesRequest;

class RetencionesService extends Services{

    public function __construct($params)
    {
        parent::__construct($params);
    }
    public static function Set($params)
    {
        return new RetencionesService($params);
    }

    public static function TimbrarRetencionXML($xml)
    {
        return retencionesRequest::sendSoapReq(Services::get_urlRetention(), Services::get_token(), $xml, 'v1');
    }
    public static function TimbrarRetencionXMLV2($xml)
    {
        return retencionesRequest::sendSoapReq(Services::get_urlRetention(), Services::get_token(), $xml, 'v2');
    }


}