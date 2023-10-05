<?php

namespace SWServices\Cancelation;

use SWServices\Cancelation\CancelationRequest as cancelationRequest;
use SWServices\Cancelation\CancelationHandler as cancelationHandler;
use SWServices\Services as Services;
use Exception;

class CancelationService extends Services
{
    public function __construct($params)
    {
        parent::__construct($params);
    }
    public static function Set($params)
    {
        return new CancelationService($params);
    }
    public static function CancelationByCSD($rfc, $uuid, $motivo, $cerB64, $keyB64, $password, $foliosustitucion = null)
    {
        return CancelationRequest::sendReqCSD(
            Services::get_url(),
            Services::get_token(),
            $rfc,
            $uuid,
            $motivo,
            $cerB64,
            $keyB64,
            $password,
            Services::get_proxy(),
            '/cfdi33/cancel/csd',
            $foliosustitucion ?? null
        );
    }
    public static function CancelationByUUID($rfc, $uuid, $motivo, $foliosustitucion = null)
    {
        return CancelationRequest::sendReqUUID(
            Services::get_url(),
            Services::get_token(),
            $rfc,
            $uuid,
            $motivo,
            Services::get_proxy(),
            '/cfdi33/cancel/',
            $foliosustitucion ?? null,
        );
    }
    public static function CancelationByPFX($rfc, $uuid, $motivo, $pfxB64, $password, $foliosustitucion = null)
    {
        return CancelationRequest::sendReqPFX(
            Services::get_url(),
            Services::get_token(),
            $rfc,
            $uuid,
            $motivo,
            $pfxB64,
            $password,
            Services::get_proxy(),
            '/cfdi33/cancel/pfx',
            $foliosustitucion ?? null
        );
    }
    public static function CancelationByXML($xml)
    {
        return CancelationRequest::sendReqXML(
            Services::get_url(),
            Services::get_token(),
            $xml,
            Services::get_proxy(),
            '/cfdi33/cancel/xml'
        );
    }
    public static function AceptarRechazarCancelacionPFX($rfc, $uuids, $pfxB64, $password)
    {
        return cancelationRequest::sendReqPFX(
            Services::get_url(),
            Services::get_token(),
            $rfc,
            cancelationHandler::uuidsReq($uuids),
            null,
            $pfxB64,
            $password,
            Services::get_proxy(),
            '/acceptreject/pfx'
        );
    }
    public static function AceptarRechazarCancelacionCSD($rfc, $uuids, $cerB64, $keyB64, $password)
    {
        return cancelationRequest::sendReqCSD(
            Services::get_url(),
            Services::get_token(),
            $rfc,
            cancelationHandler::uuidsReq($uuids),
            null,
            $cerB64,
            $keyB64,
            $password,
            Services::get_proxy(),
            '/acceptreject/csd'
        );
    }
    public static function AceptarRechazarCancelacionUUID($rfc, $uuid, $accion)
    {
        return cancelationRequest::sendReqUUID(
            Services::get_url(),
            Services::get_token(),
            $rfc,
            $uuid,
            null,
            Services::get_proxy(),
            '/acceptreject/',
            null,
            $accion
        );
    }
    public static function AceptarRechazarCancelacionXML($xml)
    {
        return cancelationRequest::sendReqXML(Services::get_url(), Services::get_token(), $xml, Services::get_proxy(), '/acceptreject/xml');
    }

    public static function PendientesPorCancelar($rfc)
    {
        return cancelationRequest::sendReqGet(Services::get_url(), Services::get_token(), $rfc, Services::get_proxy(), '/pendings/');
    }

    public static function ConsultarCFDIRelacionadosUUID($rfc, $uuid)
    {
        return cancelationRequest::sendReqUUID(
            Services::get_url(),
            Services::get_token(),
            $rfc,
            $uuid,
            null,
            Services::get_proxy(),
            '/relations/'
        );
    }
    public static function ConsultarCFDIRelacionadosCSD($rfc, $cerB64, $keyB64, $password, $uuid)
    {
        return cancelationRequest::sendReqCSD(
            Services::get_url(),
            Services::get_token(),
            $rfc,
            cancelationHandler::uuidReq($uuid),
            null,
            null,
            $cerB64,
            $keyB64,
            $password,
            Services::get_proxy(),
            '/relations/csd'
        );
    }
    public static function ConsultarCFDIRelacionadosPFX($rfc, $pfxB64, $password, $uuid)
    {
        return cancelationRequest::sendReqPFX(
            Services::get_url(),
            Services::get_token(),
            $rfc,
            cancelationHandler::uuidReq($uuid),
            null,
            null,
            $pfxB64,
            $password,
            Services::get_proxy(),
            '/relations/pfx'
        );
    }
    public static function ConsultarCFDIRelacionadosXML($xml)
    {
        return cancelationRequest::sendReqXML(Services::get_url(), Services::get_token(), $xml, Services::get_proxy(), '/relations/xml');
    }
}
