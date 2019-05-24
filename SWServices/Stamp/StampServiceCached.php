<?php
use Exception as Exception;
namespace SWServices\Stamp;

use SWServices\Services as Services;
use SWServices\Stamp\StampRequest as stampRequest;

class StampServiceCached extends Services {
    public function __construct($params) {
        parent::__construct($params);
    }

    public static function Set($params){
        return new StampServiceCached($params);
    }
    public static function StampV1($xml, $isb64 = false, $ttl = 600){
        try{
            $sello = self::getSignXml($xml);
            if(apc_exists($sello)){
                return self::showError($ttl, apc_fetch($sello));
            }
            else{
                apc_store($sello, sha1($xml), $ttl);
                $response = stampRequest::sendReq(Services::get_url(), Services::get_token(), $xml, "v1", $isb64, Services::get_proxy(), '/cfdi33/stamp/');
                return $response;
            }
        }
        catch(Exeption $ex){
            throw new Exception("Exception: ".$ex->getMessage());
        }
    }
     public static function StampV2($xml, $isb64 = false, $ttl = 600){
        try{
            $sello = self::getSignXml($xml);
            if(apc_exists($sello)){
                return self::showError($ttl, apc_fetch($sello));
            }
            else{
                apc_store($sello, sha1($xml), $ttl);
                $response = stampRequest::sendReq(Services::get_url(), Services::get_token(), $xml, "v2", $isb64, Services::get_proxy(), '/cfdi33/stamp/');
                return $response;
            }
        }
        catch(Exeption $ex){
            throw new Exception("Exception: ".$ex->getMessage());
        }
    }
     public static function StampV3($xml, $isb64 = false, $ttl = 600){
        try{
            $sello = self::getSignXml($xml);
            if(apc_exists($sello)){
                return self::showError($ttl, apc_fetch($sello));
            }
            else{
                apc_store($sello, sha1($xml), $ttl);
                $response = stampRequest::sendReq(Services::get_url(), Services::get_token(), $xml, "v3", $isb64, Services::get_proxy(), '/cfdi33/stamp/');
                return $response;
            }
        }
        catch(Exeption $ex){
            throw new Exception("Exception: ".$ex->getMessage());
        }
    }
     public static function StampV4($xml, $isb64 = false, $ttl = 600){
        try{
            $sello = self::getSignXml($xml);
            if(apc_exists($sello)){
                return self::showError($ttl, apc_fetch($sello));
            }
            else{
                apc_store($sello, sha1($xml), $ttl);
                $response = stampRequest::sendReq(Services::get_url(), Services::get_token(), $xml, "v4", $isb64, Services::get_proxy(), '/cfdi33/stamp/');
                return $response;
            }
        }
        catch(Exeption $ex){
            throw new Exception("Exception: ".$ex->getMessage());
        }
    }

    public static function StampVersion2V1($xml, $isb64 = false, $ttl = 600){
        try{
            $sello = self::getSignXml($xml);
            if(apc_exists($sello)){
                return self::showError($ttl, apc_fetch($sello));
            }
            else{
                apc_store($sello, sha1($xml), $ttl);
                $response = stampRequest::sendReq(Services::get_url(), Services::get_token(), $xml, "v1", $isb64, Services::get_proxy(), '/cfdi33/v2/stamp/');
                return $response;
            }
        }
        catch(Exeption $ex){
            throw new Exception("Exception: ".$ex->getMessage());
        }
    }
    public static function StampVersion2V2($xml, $isb64 = false, $ttl = 600){
        try{
            $sello = self::getSignXml($xml);
            if(apc_exists($sello)){
                return self::showError($ttl, apc_fetch($sello));
            }
            else{
                apc_store($sello, sha1($xml), $ttl);
                $response = stampRequest::sendReq(Services::get_url(), Services::get_token(), $xml, "v2", $isb64, Services::get_proxy(), '/cfdi33/v2/stamp/');
                return $response;
            }
        }
        catch(Exeption $ex){
            throw new Exception("Exception: ".$ex->getMessage());
        }
    }
    public static function StampVersion2V3($xml, $isb64 = false, $ttl = 600){
        try{
            $sello = self::getSignXml($xml);
            if(apc_exists($sello)){
                return self::showError($ttl, apc_fetch($sello));
            }
            else{
                apc_store($sello, sha1($xml), $ttl);
                $response = stampRequest::sendReq(Services::get_url(), Services::get_token(), $xml, "v3", $isb64, Services::get_proxy(), '/cfdi33/v2/stamp/');
                return $response;
            }
        }
        catch(Exeption $ex){
            throw new Exception("Exception: ".$ex->getMessage());
        }
    }
    public static function StampVersion2V4($xml, $isb64 = false, $ttl = 600){
        try{
            $sello = self::getSignXml($xml);
            if(apc_exists($sello)){
                return self::showError($ttl, apc_fetch($sello));
            }
            else{
                apc_store($sello, sha1($xml), $ttl);
                $response = stampRequest::sendReq(Services::get_url(), Services::get_token(), $xml, "v4", $isb64, Services::get_proxy(), '/cfdi33/v2/stamp/');
                return $response;
            }
        }
        catch(Exeption $ex){
            throw new Exception("Exception: ".$ex->getMessage());
        }
    }

    private static function getSignXml($xml){
        $xmlA = simplexml_load_string($xml);
        $json = json_encode($xmlA);
        $xmlA = json_decode($json, TRUE);
        return $xmlA["@attributes"]["Sello"];
    }

    private static function showError($ttl, $hash){
        $error = array(
            "message" => "Se evito un duplicado de la factura. Verifique si la misma ya fue timbrada por alguien más.",
            "messageDetail" => "Factura registrada en la caché hace menos de $ttl segundos por otro proceso, hash(sha1) del xml: $hash",
            "data" => null,
            "status" => "error"
        );
        return json_decode(json_encode($error));
    }
}

?>