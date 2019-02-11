<?php
require_once 'SWSDK.php';
use SWServices\Authentication\AuthenticationService as Authentication;
use SWServices\Stamp\Timbrado as StampService;
use SWServices\Stamp\EmisionTimbrado as EmisionTimbrado;
use SWServices\Validation\ValidarXML as ValidarXML;
use SWServices\Validation\ValidaLco as ValidaLco;
use SWServices\Validation\ValidaLrfc as ValidaLrfc;
use SWServices\JSonIssuer\JsonEmisionTimbrado as JsonEmisionTimbrado;
use SWServices\Cancelation\CancelationService as CancelationService;
use SWServices\AccountBalance\AccountBalanceService as AccountBalanceService;
use SWServices\SatQuery\ServicioConsultaSAT as ConsultaCfdiSAT;
use SWServices\Csd\CsdService as CsdService;


header('Content-type: text/plain');


$params = array(
    "url"=>"http://services.test.sw.com.mx",
    "user"=>"demo",
    "password"=> "123456789"
      );

echo "\n\n------------Token---------------------\n\n";
try {
    Authentication::auth($params);
	$result = Authentication::Token();
	
	if($result->status == "success") {
            echo $result->data->token;
            
	} else {
            echo $result->message;
	}
    } catch(Exception $e){
        echo 'Caught exception: ',  $e->getMessage(), "\n";
    }

 echo "\n\n------------ Account Balance ---------------------\n\n"; 
    AccountBalanceService::Set($params);
    $accResponse = AccountBalanceService::GetAccountBalance();
    var_dump($accResponse);



    $xml = file_get_contents('Tests/Resources/file.xml');
    
echo "\n\n--------------- Emisión Timbrado ------------------\n\n";
    EmisionTimbrado::Set($params);
    $resultadoIssue = EmisionTimbrado::EmisionTimbradoV4($xml);
    var_dump($resultadoIssue);
    
echo "\n\n--------------- Timbrado ------------------\n\n";
    StampService::Set($params);
    $resultadoStamp = StampService::StampV4($xml);
    var_dump($resultadoStamp);
       
echo "\n\n-----------------Validación de XML ----------------\n\n";          
    ValidarXML::Set($params);
    $resultadoValida = ValidarXML::ValidaXML($xml);
    var_dump($resultadoValida);
    
echo "\n\n---------------- Validación LCO -----------------\n\n";    
    ValidaLco::Set($params);
    $resultadoLCO = ValidaLco::ValidaLco('20001000000300022816');
    var_dump($resultadoLCO);      
      
echo "\n\n----------------- Validación LRFC ----------------\n\n";     
    ValidaLrfc::Set($params);
    $resultadoLRFC = ValidaLrfc::ValidaLrfc('LAN8507268IA');
    var_dump($resultadoLRFC);
   
echo "\n\n-------------- Emisión Timbrado por JSON -------------------\n\n";     
    $json = file_get_contents("Tests/Resources/cfdi33_json_pagos.json"); 
        
    JsonEmisionTimbrado::Set($params);
    $resultadoJson = JsonEmisionTimbrado::JsonEmisionTimbradoV4($json);
    
    $resultadoJson->status=="success" 
            ?
            print_r($resultadoJson->data->cadenaOriginalSAT).
            print_r($resultadoJson->data->noCertificadoSAT).
            print_r($resultadoJson->data->noCertificadoCFDI).
            print_r($resultadoJson->data->uuid).
            print_r($resultadoJson->data->selloSAT).
            print_r($resultadoJson->data->selloCFDI).
            print_r($resultadoJson->data->fechaTimbrado).
            print_r($resultadoJson->data->qrCode).
            print_r($resultadoJson->data->cfdi)
           :
            print_r($resultadoJson->message).
            print_r($resultadoJson->messageDetail);
      
// Parametros   
    $cerB64 = base64_encode(file_get_contents('Tests\Resources\SignResources\CSD_PAC_CFDI_PRUEBAS\CSD_Prueba_CFDI_LAN8507268IA.cer'));
    $keyB64 = base64_encode(file_get_contents('Tests\Resources\SignResources\CSD_PAC_CFDI_PRUEBAS\CSD_Prueba_CFDI_LAN8507268IA.key'));
    $pfxB64 = base64_encode(file_get_contents('Tests\Resources\SignResources\CSD_PAC_CFDI_PRUEBAS\CSD_Prueba_CFDI_LAN8507268IA.pfx'));
   
    $password = "12345678a";
    $uuid = "551b9f77-1045-431d-a7a7-c8c19b3306fc";
    $rfc = "LAN8507268IA";
    $xmlCancelacion = "";

echo "\n\n---------------- Cancelación directa por UUID -----------------\n\n";     
    CancelationService::Set($params);
    $cancelationResult = CancelationService::CancelationByUUID($rfc, $uuid);
    var_dump($cancelationResult);
 
    
echo "\n\n---------------- Cancelación por PFX -----------------\n\n";    
    CancelationService::Set($params);
    $cancelationPFX = CancelationService::CancelationByPFX($rfc, $pfxB64, $password, $uuid);
    var_dump($cancelationPFX);
 
 echo "\n\n---------------- Cancelación por XML -----------------\n\n";   
    CancelationService::Set($params);
    $cancelationXML = CancelationService::CancelationByXML($xmlCancelacion);
    var_dump($cancelationXML);
      
echo "\n\n-----------------Cancelación por CSD ----------------\n\n";  
    
    CancelationService::Set($params);
    $cancelationCSD = CancelationService::CancelationByCSD($rfc, $cerB64, $keyB64, $password, $uuid);
    var_dump($cancelationCSD);

echo "\n\n--------------- Consulta Status CFDI SAT ------------------\n\n";  

        $soapUrl = "https://consultaqr.facturaelectronica.sat.gob.mx/ConsultaCFDIService.svc";
        $re = "LSO1306189R5";
        $rr = "LSO1306189R5";
        $tt = 1.16;
        $uuidV = "E0AAE6B3-43CC-4B9C-B229-7E221000E2BB";
    
       $consultaCfdi = ConsultaCfdiSAT::ServicioConsultaSAT($soapUrl, $re, $rr, $tt, $uuidV);
      
       var_dump($consultaCfdi);
       
echo "\n\n--------------- Consulta Pendientes por Cancelar ------------------\n\n";         
       
        $rfc = "LAN7008173R5";
        CancelationService::Set($params);
        $consultaPendientes = CancelationService::PendientesPorCancelar($rfc);
        var_dump($consultaPendientes);    
    
echo "\n\n--------------- Consulta consulta Relacionados ------------------\n\n";      

        $uuidV = "E0AAE6B3-43CC-4B9C-B229-7E221000E2BB";
        CancelationService::Set($params);
        $cfdiRelacionados = CancelationService::ConsultarCFDIRelacionadosUUID($rfc, $uuidV);
        var_dump($cfdiRelacionados);
        
echo "\n\n--------------- Aceptar o rechazar Cancelación ------------------\n\n";        
        
        $accion = "Aceptacion";
        CancelationService::Set($params);
        $aceptarRechazar = CancelationService::AceptarRechazarCancelacionUUID($rfc, $uuidV, $accion);
        var_dump($aceptarRechazar);

echo "\n\n--------------- Subir certificado ------------------\n\n";
        
        $isActive = true;
        $type = "stamp";
        $password = "12345678a";
        $b64Cer = base64_encode(file_get_contents("Tests\Resources\SignResources\CSD_PAC_CFDI_PRUEBAS\CSD_Prueba_CFDI_LAN8507268IA.cer"));
        $b64Key = base64_encode(file_get_contents("Tests\Resources\SignResources\CSD_PAC_CFDI_PRUEBAS\CSD_Prueba_CFDI_LAN8507268IA.key"));
        $uploadCsd = CsdService::Set($params);
        $response = $uploadCsd::UploadCsd($isActive, $type, $b64Cer, $b64Key, $password);
        var_dump($response);
        
?>
