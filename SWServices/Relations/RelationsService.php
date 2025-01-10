<?php

namespace SWServices\Relations;

use SWServices\Relations\RelationsRequest as relationsRequest;
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
        try {
            $url = Services::get_url();
            $token = Services::get_token();

            return relationsRequest::sendReqUUID(
                $url,
                '/relations/',
                $token,
                $rfc,
                $uuid,
                Services::get_proxy(),
            );
        } catch (Exception $e) {
            return ['error' => 'Ocurrió un error durante la solicitud: ' . $e->getMessage()];
        }
    }
    public static function ConsultarCFDIRelacionadosCSD($uuid, $password, $rfc, $cerB64, $keyB64)
    {
        try {
            $url = Services::get_url();
            $token = Services::get_token();

            return relationsRequest::sendReqCSDRelations(
                $url,
                '/relations/csd',
                $token,
                $uuid,
                $password,
                $rfc,
                $cerB64,
                $keyB64,
                Services::get_proxy(),
            );
        } catch (Exception $e) {
            return ['error' => 'Ocurrió un error durante la solicitud: ' . $e->getMessage()];
        }
    }

    public static function ConsultarCFDIRelacionadosPFX($uuid, $password, $rfc, $pfxB64)
    {
        try {
            $url = Services::get_url();
            $token = Services::get_token();

            return relationsRequest::sendReqPFXRelations(
                $url,
                '/relations/pfx',
                $token,
                $uuid,
                $password,
                $rfc,
                $pfxB64,
                Services::get_proxy(),
            );
        } catch (Exception $e) {
            return ['error' => 'Ocurrió un error durante la solicitud: ' . $e->getMessage()];
        }
    }
}
