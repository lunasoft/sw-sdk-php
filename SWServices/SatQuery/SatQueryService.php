<?php
namespace SWServices\SatQuery;

use SWServices\Services as Services;
use SWServices\SatQuery\SatQueryRequest as satQueryRequest;

class ServicioConsultaSAT extends Services{
  
    public static function ServicioConsultaSAT($url, $rfcEmisor, $rfcReceptor, $total, $uuid) {
        return satQueryRequest::soapRequest($url, $rfcEmisor, $rfcReceptor, $total, $uuid);
    }
}