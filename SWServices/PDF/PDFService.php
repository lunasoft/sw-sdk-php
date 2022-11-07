<?php
namespace SWServices\PDF;

use SWServices\PDF\PDFHelper as pdfhelper;
use SWServices\Services as Services;
use SWServices\PDF\PDFRequest as pdfrequest;

class PDFService extends Services {
    public function __construct($params) {
        parent::__construct($params);
    }

    public static function Set($params){
        
        return new PDFService($params);
        
    }
     public static function GeneratePDF($urlApi, $xml, $logo, $templateId,$extras,$isB64=false){
        $params = array(
            "xml" => $xml,
            "urlApi" => $urlApi
        );  
        $helper = new pdfhelper($params);
        $response = pdfrequest::sendReqGenerate($helper::get_urlApi(), Services::get_token(), $helper::get_xml($isB64), $logo, $templateId,$extras);
        return $helper::get_response($response);
    }
     
}


?>