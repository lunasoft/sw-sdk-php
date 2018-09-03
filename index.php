<?php
require_once 'SWSDK.php';
use SWServices\Authentication\AuthenticationService as Authentication;
use SWServices\Stamp\Timbrado as timbrado;
use SWServices\Stamp\EmisionTimbrado as emisionTimbrado;
use SWServices\Validation\ValidarXML as validarXML;
use SWServices\Validation\ValidaLco as validaLco;
use SWServices\Validation\ValidaLrfc as validaLrfc;
use SWServices\JSonIssuer\JsonIssuerService as jsonIssuerService;
use SWServices\JSonIssuer\JsonEmisionTimbrado as jsonEmisionTimbrado;
use SWServices\Cancelation\CancelationService as cancelationService;
use SWServices\AccountBalance\AccountBalanceService as accountBalanceService;
use SWServices\SatQuery\ServicioConsultaSAT as consultaCfdiSAT;

header('Content-type: text/plain');

echo "\n\n------------ Account Balance ---------------------\n\n";
$params = array(
    "url"=>"http://services.test.sw.com.mx",
    //"token" => "T2lYQ0t4L0RHVkR4dHZ5Nkk1VHNEakZ3Y0J4Nk9GODZuRyt4cE1wVm5tbXB3YVZxTHdOdHAwVXY2NTdJb1hkREtXTzE3dk9pMmdMdkFDR2xFWFVPUXpTUm9mTG1ySXdZbFNja3FRa0RlYURqbzdzdlI2UUx1WGJiKzViUWY2dnZGbFloUDJ6RjhFTGF4M1BySnJ4cHF0YjUvbmRyWWpjTkVLN3ppd3RxL0dJPQ.T2lYQ0t4L0RHVkR4dHZ5Nkk1VHNEakZ3Y0J4Nk9GODZuRyt4cE1wVm5tbFlVcU92YUJTZWlHU3pER1kySnlXRTF4alNUS0ZWcUlVS0NhelhqaXdnWTRncklVSWVvZlFZMWNyUjVxYUFxMWFxcStUL1IzdGpHRTJqdS9Zakw2UGRkcVNTMno1eU9QV2t1UWdPSFg0TDliYmF4NGp1RjVka1BRM2hNMTNGWjNaM1NXZTE1SFJWSW9mQkFuYmRwaHhEYUd4NFB1YUtDU1p1bzQwR2ttVS9raTFPUDRqRFVudHB6cHdGMVQ5dnB0aGVLN1R6cFBqaStiUFlsbzcwdDgzMjNiMlk2azVwayszNVlWZWhxSGF4VFQ4d1Z1ampsZHRtU252V1JJU216YUwwMml1S3dOR3JaQ216ekFyZUdEbVRaRk9FUzFkaE5BQWRpRXZYT3N5bk44YzVLUlBROWpKay9MZXRPbWhXdmRreENwT1RDbURpQW82UkxsbFlqN3RySWxHdzZLZ1NjQzB6WjFlajNCYkFUeXRtK0MrWHJ3RWh2QzJzWDdYeEpWRXpwdkFLRmd1VGRudFhvWExjRllHRisvdnYyM1B5TmE4TWQvZm9pZTVuaS9tdUxvRkh2T2FBV2hyMzkweDdBeXcrZ2ptSE4wUnFBUnhBdyt0dGhpZVc.FB_Y2NmPBmfDdPBC0zFCgTLSnVkVaHrWU_pXpeljbYU"
    "user"=>"demo",
    "password"=> "123456789"
      );

    $accountBalance = accountBalanceService::Set($params);
    $accResponse = $accountBalance::GetAccountBalance();
    var_dump($accResponse);

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

        $soapUrl = "https://consultaqr.facturaelectronica.sat.gob.mx/ConsultaCFDIService.svc";
        $re = "LSO1306189R5";
        $rr = "LSO1306189R5";
        $tt = 1.16;
        $uuidV = "E0AAE6B3-43CC-4B9C-B229-7E221000E2BB";
    
       $consultaCfdi = consultaCfdiSAT::ServicioConsultaSAT($soapUrl, $re, $rr, $tt, $uuidV);
      
       var_dump($consultaCfdi);
       

?>