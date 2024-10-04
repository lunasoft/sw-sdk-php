<?php
namespace SWServices\Retention;

use SWServices\Services as Services;
use SWServices\Stamp\StampRequest as stampRequest;
use SWServices\Stamp\StampHelper as StampHelper;

class Retenciones extends Services{

    public function __construct($params)
    {
        parent::__construct($params);
    }
    public static function Set($params)
    {
        return new Retenciones($params);
    }

    public static function TimbrarRetencionXML($xml)
    {
        return stampRequest::sendSoapReq(Services::get_urlRetention(), Services::get_token(), $xml, 'v1');
    }
    public static function TimbrarRetencionXMLV2($xml)
    {
        return stampRequest::sendSoapReq(Services::get_urlRetention(), Services::get_token(), $xml, 'v2');
    }


}