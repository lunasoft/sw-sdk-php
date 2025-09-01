<?php

namespace SWServices\CancelationRetention;

use SWServices\CancelationRetention\CancelationRetentionRequest as CancelationRetentionRequest;
use SWServices\Services as Services;

class CancelationRetentionService extends Services
{
    public function __construct($params)
    {
        parent::__construct($params);
    }

    public static function Set($params)
    {
        return new CancelationRetentionService($params);
    }

    public static function CancelationByXML($xmlContent)
    {
        return CancelationRetentionRequest::cancelByXML(Services::get_url(), Services::get_token(), $xmlContent);
    }

    public static function CancelationByCSD($rfc, $uuid, $motivo, $b64Cer, $b64Key, $password)
    {
        $data = [
            "uuid"     => $uuid,
            "password" => $password,
            "rfc"      => $rfc,
            "motivo"   => $motivo,
            "b64Cer"   => $b64Cer,
            "b64Key"   => $b64Key
        ];

        if (!empty($folioSustitucion)) {
            $data["folioSustitucion"] = $folioSustitucion;
        }

        return CancelationRetentionRequest::cancelByCSD(Services::get_url(), Services::get_token(), $data);
    }

    public static function CancelationByPFX($rfc, $uuid, $motivo, $b64Pfx, $password, $folioSustitucion = null)
    {
        $data = [
            "uuid"             => $uuid,
            "password"         => $password,
            "rfc"              => $rfc,
            "motivo"           => $motivo,
            "b64Pfx"           => $b64Pfx
        ];

        if (!empty($folioSustitucion)) {
            $data["folioSustitucion"] = $folioSustitucion;
        }

        return CancelationRetentionRequest::cancelByPFX(Services::get_url(), Services::get_token(), $data);
    }
}
