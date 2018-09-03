<?php
namespace SWServices\SatQuery;

use SWServices\Services as Services;
use SWServices\SatQuery\SatQueryRequest as satQueryRequest;

class ServicioConsultaSAT extends Services{
    
    public function __construct($params) {
        parent::__construct($params);
    }
    
    public static function Set($params){
        return new CancelationService($params);
    }
    
    public static function ServicioConsultaSAT($url, $rfcEmisor, $rfcReceptor, $total, $uuid) {
        return satQueryRequest::soapRequest($url, $rfcEmisor, $rfcReceptor, $total, $uuid);
    }
}