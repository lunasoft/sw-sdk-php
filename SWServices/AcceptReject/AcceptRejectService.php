<?php

namespace SWServices\AcceptReject;
use SWServices\Services as Services;
use SWServices\AcceptReject\AcceptRejectRequest as AcceptRejectRequest;
use Exception;
class AcceptRejectService extends Services
{
    public function __construct($params)
    {
        parent::__construct($params);
    }
    public static function Set($params)
    {
        return new AcceptRejectService($params);
    }

    //AcceptReject - UUID
    public static function AceptarRechazarCancelacionUUID($rfc, $uuid, $accion)
    {
        return AcceptRejectRequest::sendReqUUID(
            Services::get_url(),
            Services::get_token(),
            $rfc,
            $uuid,
            Services::get_proxy(),
            '/acceptreject/',
            $accion
        );
    }

    //AcceptReject - CSD
    public static function AceptarRechazarCancelacionCSD($rfc, $uuids, $cerB64, $keyB64, $password)
    {
        return AcceptRejectRequest::sendReqCSD(
            Services::get_url(),
            Services::get_token(),
            $rfc,
            $uuids,
            $cerB64,
            $keyB64,
            $password,
            Services::get_proxy(),
            '/acceptreject/csd'
        );
    }

    //AcceptReject - PFX 
    public static function AceptarRechazarCancelacionPFX($rfc, $uuids, $pfxB64, $password)
    {
        return AcceptRejectRequest::sendReqPFX(
            Services::get_url(),
            Services::get_token(),
            $rfc,
            $uuids,
            $pfxB64,
            $password,
            Services::get_proxy(),
            '/acceptreject/pfx'
        );
    }

    //AcceptReject - XML
    public static function AceptarRechazarCancelacionXML($xml)
    {
        return AcceptRejectRequest::sendReqXML(
            Services::get_url(), 
            Services::get_token(), 
            $xml, 
            Services::get_proxy(), 
            '/acceptreject/xml'
        );
    }
}

?>