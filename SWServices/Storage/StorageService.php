<?php

namespace SWServices\Storage;

use SWServices\Storage\StorageResponse as Helper;

class StorageService extends StorageRequest
{
    public function __construct($params)
    {
        parent::__construct($params);
    }
    /**
     * Inicializa Storage Service.
     */
    public static function Set($params)
    {
        return new StorageService($params);
    }
    /**
     * Servicio que consulta y obtiene un xml a partir de su UUID.
     * @param string $uuid Folio del comprobante.
     * @return StorageResponse
     */
    //función que realiza la instancia de storarequest para posterio
    //instanciar storagresponse
    public static function getXml($uuid)
    {
        $value = StorageRequest::postStorage($uuid);
        $response = new Helper($value);
        return $response;
    }
}
?>