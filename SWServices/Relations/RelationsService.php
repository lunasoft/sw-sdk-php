<?php

namespace SWServices\Relations;

use SWServices\Relations\RelationsRequest as relationsRequest;
use SWServices\Relations\RelationsHandler as relationsHandler;
use SWServices\Services as Services;
use Exception;

class RelationsService extends Services
{
    public function __construct($params)
    {
        parent::__construct($params);
    }
    public static function Set($params)
    {
        return new RelationsService($params);
    }

    public static function ConsultarCFDIRelacionadosUUID($rfc, $uuid)
    {
        return relationsRequest::sendReqUUID(
            Services::get_url(),
            Services::get_token(),
            $rfc,
            $uuid,
            null,
            Services::get_proxy(),
            '/relations/'
        );
    }
    public static function ConsultarCFDIRelacionadosCSD($token, $uuid, $password, $rfc, $cerB64, $keyB64)
    {
        try {
            $url = Services::get_url();
            $token = Services::get_token();
    
            $formattedUuid = relationsHandler::uuidReq($uuid);
    
            return relationsRequest::sendReqCSDRelations(
                $url,
                '/relations/csd',
                $token,
                $uuid,
                $password,
                $rfc,
                $cerB64,
                $keyB64
            );
        } catch (Exception $e) {
            return ['error' => 'Ocurrió un error durante la solicitud: ' . $e->getMessage()];
        }
    }

    public static function ConsultarCFDIRelacionadosPFX($token, $uuid, $password, $rfc, $pfxB64)
    {
        try {
            $url = Services::get_url();
            $token = Services::get_token();
    
            $formattedUuid = relationsHandler::uuidReq($uuid);
    
            return relationsRequest::sendReqPFXRelations(
                $url,
                '/relations/pfx',
                $token,
                $uuid,
                $password,
                $rfc,
                $pfxB64
            );
        } catch (Exception $e) {
            return ['error' => 'Ocurrió un error durante la solicitud: ' . $e->getMessage()];
        }
    }
}
