<?php
require_once 'SWSDK.php';
use SWServices\Authentication\AuthenticationService as Authentication;
use SWServices\Stamp\Timbrado as timbrado;
use SWServices\Stamp\EmisionTimbrado as emisionTimbrado;
use SWServices\Validation\ValidarXML as validarXML;
use SWServices\Validation\ValidaLco as validaLco;
use SWServices\Validation\ValidaLrfc as validaLrfc;
use SWServices\JSonIssuer\JsonEmisionTimbrado as jsonEmisionTimbrado;
use SWServices\Cancelation\CancelationService as cancelationService;
use SWServices\AccountBalance\AccountBalanceService as accountBalanceService;
use SWServices\SatQuery\ServicioConsultaSAT as consultaCfdiSAT;


header('Content-type: text/plain');


$params = array(
    "url"=>"http://services.test.sw.com.mx",
    "user"=>"demo",
    "password"=> "123456789"
      );

echo "\n\n------------Token---------------------\n\n";
try {
    $auth = Authentication::auth($params);
	$result = $auth::Token();
	
	if($result->status == "success") {
            echo $result->data->token;
            
	} else {
            echo $result->message;
	}
    } catch(Exception $e){
        echo 'Caught exception: ',  $e->getMessage(), "\n";
    }

 echo "\n\n------------ Account Balance ---------------------\n\n"; 
    $accountBalance = accountBalanceService::Set($params);
    $accResponse = $accountBalance::GetAccountBalance();
    var_dump($accResponse);



    $xml = file_get_contents('Tests/Resources/file2.xml');
    
echo "\n\n--------------- Emisión Timbrado ------------------\n\n";
    $issue = emisionTimbrado::Set($params);
    $resultadoIssue = $issue::EmisionTimbradoV4($xml);
    var_dump($resultadoIssue);
    
echo "\n\n--------------- Timbrado ------------------\n\n";
    $stamp = timbrado::Set($params);
    $resultadoStamp = $stamp::TimbradoV4($xml);
    var_dump($resultadoStamp);
       
echo "\n\n-----------------Validación de XML ----------------\n\n";          
    $validateXML = validarXML::Set($params);
    $resultadoValida = $validateXML::ValidaXML($xml);
    var_dump($resultadoValida);
    
echo "\n\n---------------- Validación LCO -----------------\n\n";    
    $validateLCO = validaLco::Set($params);
    $resultadoLCO = $validateLCO::ValidaLco('20001000000300022816');
    var_dump($resultadoLCO);      
      
echo "\n\n----------------- Validación LRFC ----------------\n\n";     
    $validateLCRFC = validaLrfc::Set($params);
    $resultadoLRFC= $validateLCRFC::ValidaLrfc('LAN8507268IA');
    var_dump($resultadoLRFC);
   
echo "\n\n-------------- Emisión Timbrado por JSON -------------------\n\n";     
    $json = file_get_contents("Tests/Resources/cfdi33_json_pagos.json"); 
        
    $jsonIssuerStamp = jsonEmisionTimbrado::Set($params);
    $resultadoJson = $jsonIssuerStamp::jsonEmisionTimbradoV4($json);
    
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
    $cancelRequestUUID = cancelationService::Set($params);
    $cancelationResult = $cancelRequestUUID::CancelationByUUID($rfc, $uuid);
    var_dump($cancelationResult);
 
    
echo "\n\n---------------- Cancelación por PFX -----------------\n\n";    
    $cancelRequestPFX = cancelationService::Set($params);
    $cancelationPFX = $cancelRequestPFX::CancelationByPFX($rfc, $pfxB64, $password, $uuid);
    var_dump($cancelationPFX);
 
 echo "\n\n---------------- Cancelación por XML -----------------\n\n";   
    $cancelRequestXML = cancelationService::Set($params);
    $cancelationXML = $cancelRequestXML::CancelationByXML($xmlCancelacion);
    var_dump($cancelationXML);
      
echo "\n\n-----------------Cancelación por CSD ----------------\n\n";  
    
    $cancelRequestCSD = cancelationService::Set($params);
    $cancelationCSD = $cancelRequestCSD::CancelationByCSD($rfc, $cerB64, $keyB64, $password, $uuid);
    var_dump($cancelationCSD);

echo "\n\n--------------- Consulta Status CFDI SAT ------------------\n\n";  

        $soapUrl = "https://consultaqr.facturaelectronica.sat.gob.x/ConsultaCFDIService.svc";
        $re = "LSO1306189R5";
        $rr = "LSO1306189R5";
        $tt = 1.16;
        $uuidV = "E0AAE6B3-43CC-4B9C-B229-7E221000E2BB";
    
       $consultaCfdi = consultaCfdiSAT::ServicioConsultaSAT($soapUrl, $re, $rr, $tt, $uuidV);
      
       var_dump($consultaCfdi);
       
echo "\n\n--------------- Consulta Pendientes por Cancelar ------------------\n\n";         
       
        $rfc = "LAN7008173R5";
        $consultaPendientes = cancelationService::Set($params);
        $consultaPendientes = cancelationService::PendientesPorCancelar($rfc);
        var_dump($consultaPendientes);    
    
echo "\n\n--------------- Consulta consulta Relacionados ------------------\n\n";      

        $uuidV = "E0AAE6B3-43CC-4B9C-B229-7E221000E2BB";
        $cfdiRelacionados = cancelationService::Set($params);
        $cfdiRelacionados = cancelationService::ConsultarCFDIRelacionadosUUID($rfc, $uuidV);
        var_dump($cfdiRelacionados);
        
echo "\n\n--------------- Aceptar o rechazar Cancelación ------------------\n\n";        
        
        $accion = "Aceptacion";
        $aceptarRechazar = cancelationService::Set($params);
        $aceptarRechazar = cancelationService::AceptarRechazarCancelacionUUID($rfc, $uuidV, $accion);
        var_dump($aceptarRechazar);

?>
