<?php
require_once 'SWSDK.php';
use SWServices\Authentication\AuthenticationService as Authentication;
use SWServices\Stamp\StampService as StampService;
use SWServices\Stamp\EmisionTimbrado as EmisionTimbrado;
use SWServices\Validation\ValidarXML as ValidarXML;
use SWServices\Validation\ValidaLco as ValidaLco;
use SWServices\Validation\ValidaLrfc as ValidaLrfc;
use SWServices\JSonIssuer\JsonEmisionTimbrado as JsonEmisionTimbrado;
use SWServices\Cancelation\CancelationService as CancelationService;
use SWServices\AccountBalance\AccountBalanceService as AccountBalanceService;
use SWServices\SatQuery\ServicioConsultaSAT as ConsultaCfdiSAT;
use SWServices\Csd\CsdService as CsdService;
use SWServices\Taxpayer\TaxpayerService as ValidarListaNegra;
header('Content-type: text/plain');
$params = array(
    "url"=>"http://services.test.sw.com.mx",
    "user"=>"demo",
    "password"=> "123456789"
      );
echo "\n\n------------Token---------------------\n\n";
try{
    Authentication::auth($params);
	$result = Authentication::Token();
	
	if($result->status == "success") {
            echo $result->data->token;
            
    } 
    else {
            echo $result->message;
	}
}
catch(Exception $e){
    echo 'Caught exception: ',  $e->getMessage(), "\n";
}
 echo "\n\n------------ Account Balance ---------------------\n\n"; 
try {
    AccountBalanceService::Set($params);
    $accResponse = AccountBalanceService::GetAccountBalance();
    var_dump($accResponse);
}
catch(Exception $e){
    echo 'Caught exception: ',  $e->getMessage(), "\n";
}
    $xml = file_get_contents('Tests/Resources/file.xml');
    
echo "\n\n--------------- Emisión Timbrado ------------------\n\n";
try {
    EmisionTimbrado::Set($params);
    $resultadoIssue = EmisionTimbrado::EmisionTimbradoV4($xml);
    var_dump($resultadoIssue);
}
catch(Exception $e){
    echo 'Caught exception: ',  $e->getMessage(), "\n";
}
    
echo "\n\n--------------- Timbrado ------------------\n\n";
try {
    StampService::Set($params);
    $resultadoStamp = StampService::StampV4($xml);
    var_dump($resultadoStamp);
}
catch(Exception $e){
    echo 'Caught exception: ',  $e->getMessage(), "\n";
}
       
echo "\n\n-----------------Validación de XML ----------------\n\n";          
try {
    ValidarXML::Set($params);
    $resultadoValida = ValidarXML::ValidaXML($xml);
    var_dump($resultadoValida);
}
catch(Exception $e){
    echo 'Caught exception: ',  $e->getMessage(), "\n";
}
    
echo "\n\n---------------- Validación LCO -----------------\n\n";    
try {
    ValidaLco::Set($params);
    $resultadoLCO = ValidaLco::ValidaLco('20001000000300022816');
    var_dump($resultadoLCO); 
}
catch(Exception $e){
    echo 'Caught exception: ',  $e->getMessage(), "\n";
}     
      
echo "\n\n----------------- Validación LRFC ----------------\n\n";     
try {
    ValidaLrfc::Set($params);
    $resultadoLRFC = ValidaLrfc::ValidaLrfc('LAN8507268IA');
    var_dump($resultadoLRFC);
}
catch(Exception $e){
    echo 'Caught exception: ',  $e->getMessage(), "\n";
}
   
echo "\n\n-------------- Emisión Timbrado por JSON -------------------\n\n";     
try {
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
}
catch(Exception $e){
    echo 'Caught exception: ',  $e->getMessage(), "\n";
}
      
// Parametros   
    $cerB64 = base64_encode(file_get_contents('Tests\Resources\SignResources\CSD_PAC_CFDI_PRUEBAS\CSD_Prueba_CFDI_LAN8507268IA.cer'));
    $keyB64 = base64_encode(file_get_contents('Tests\Resources\SignResources\CSD_PAC_CFDI_PRUEBAS\CSD_Prueba_CFDI_LAN8507268IA.key'));
    $pfxB64 = base64_encode(file_get_contents('Tests\Resources\SignResources\CSD_PAC_CFDI_PRUEBAS\CSD_Prueba_CFDI_LAN8507268IA.pfx'));
   
    $password = "12345678a";
    $uuid = "551b9f77-1045-431d-a7a7-c8c19b3306fc";
    $rfc = "LAN8507268IA";
    $xmlCancelacion = "";
    $rfcListaNegra = "ZNS1101105T3";
    
echo "\n\n---------------- Cancelación directa por UUID -----------------\n\n";     
try {
    CancelationService::Set($params);
    $cancelationResult = CancelationService::CancelationByUUID($rfc, $uuid);
    var_dump($cancelationResult);
}
catch(Exception $e){
    echo 'Caught exception: ',  $e->getMessage(), "\n";
}
 
    
echo "\n\n---------------- Cancelación por PFX -----------------\n\n";
try {
    CancelationService::Set($params);
    $cancelationPFX = CancelationService::CancelationByPFX($rfc, $pfxB64, $password, $uuid);
    var_dump($cancelationPFX);
}
catch(Exception $e){
    echo 'Caught exception: ',  $e->getMessage(), "\n";
}
 
 echo "\n\n---------------- Cancelación por XML -----------------\n\n";
 try {
    CancelationService::Set($params);
    $cancelationXML = CancelationService::CancelationByXML($xmlCancelacion);
    var_dump($cancelationXML);
 }
 catch(Exception $e){
    echo 'Caught exception: ',  $e->getMessage(), "\n";
}
      
echo "\n\n-----------------Cancelación por CSD ----------------\n\n";  
try {
    CancelationService::Set($params);
    $cancelationCSD = CancelationService::CancelationByCSD($rfc, $cerB64, $keyB64, $password, $uuid);
    var_dump($cancelationCSD);
}
catch(Exception $e){
    echo 'Caught exception: ',  $e->getMessage(), "\n";
}
echo "\n\n--------------- Consulta Status CFDI SAT ------------------\n\n";  
        $soapUrl = "https://consultaqr.facturaelectronica.sat.gob.mx/ConsultaCFDIService.svc";
        $re = "LSO1306189R5";
        $rr = "LSO1306189R5";
        $tt = 1.16;
        $uuidV = "E0AAE6B3-43CC-4B9C-B229-7E221000E2BB";
    
       $consultaCfdi = ConsultaCfdiSAT::ServicioConsultaSAT($soapUrl, $re, $rr, $tt, $uuidV);
      
       var_dump($consultaCfdi);
       
echo "\n\n--------------- Consulta Pendientes por Cancelar ------------------\n\n";         
try {       
    $rfc = "LAN7008173R5";
    CancelationService::Set($params);
    $consultaPendientes = CancelationService::PendientesPorCancelar($rfc);
    var_dump($consultaPendientes);    
}
catch(Exception $e){
    echo 'Caught exception: ',  $e->getMessage(), "\n";
}
    
echo "\n\n--------------- Consulta consulta Relacionados ------------------\n\n";      
try {
    $uuidV = "E0AAE6B3-43CC-4B9C-B229-7E221000E2BB";
    CancelationService::Set($params);
    $cfdiRelacionados = CancelationService::ConsultarCFDIRelacionadosUUID($rfc, $uuidV);
    var_dump($cfdiRelacionados);
}
catch(Exception $e){
    echo 'Caught exception: ',  $e->getMessage(), "\n";
}
        
echo "\n\n--------------- Aceptar o rechazar Cancelación ------------------\n\n";        
try { 
    $accion = "Aceptacion";
    CancelationService::Set($params);
    $aceptarRechazar = CancelationService::AceptarRechazarCancelacionUUID($rfc, $uuidV, $accion);
    var_dump($aceptarRechazar);
}
catch(Exception $e){
    echo 'Caught exception: ',  $e->getMessage(), "\n";
}
echo "\n\n--------------- Subir certificado ------------------\n\n";
try {        
    $isActive = true;
    $type = "stamp";
    $password = "12345678a";
    $b64Cer = base64_encode(file_get_contents("Tests\Resources\SignResources\CSD_PAC_CFDI_PRUEBAS\CSD_Prueba_CFDI_LAN8507268IA.cer"));
    $b64Key = base64_encode(file_get_contents("Tests\Resources\SignResources\CSD_PAC_CFDI_PRUEBAS\CSD_Prueba_CFDI_LAN8507268IA.key"));
    CsdService::Set($params);
    $response = CsdService::UploadCsd($isActive, $type, $b64Cer, $b64Key, $password);
    var_dump($response);
}
catch(Exception $e){
    echo 'Caught exception: ',  $e->getMessage(), "\n";
}
echo "\n\n--------------- Lista certificados ------------------\n\n";
try {
    CsdService::Set($params);
    $response = CsdService::GetListCsd();
    var_dump($response);
}
catch(Exception $e){
    echo 'Caught exception: ',  $e->getMessage(), "\n";
}
echo "\n\n--------------- Lista certificados por tipo ------------------\n\n";
try {
    CsdService::Set($params);
    $response = CsdService::GetListCsdByType('stamp');
    var_dump($response);
}
catch(Exception $e){
    echo 'Caught exception: ',  $e->getMessage(), "\n";
}
echo "\n\n--------------- Lista certificados por Rfc ------------------\n\n";
try {
    CsdService::Set($params);
    $response = CsdService::GetListCsdByRfc('LAN7008173R5');
    var_dump($response);
}
catch(Exception $e){
    echo 'Caught exception: ',  $e->getMessage(), "\n";
}
echo "\n\n--------------- Buscar certificado por número de csd ------------------\n\n";
try {
    CsdService::Set($params);
    $response = CsdService::InfoCsd('20001000000300022816');
    var_dump($response);
}
catch(Exception $e){
    echo 'Caught exception: ',  $e->getMessage(), "\n";
}
        
echo "\n\n--------------- Buscar certificado activo por rfc y tipo ------------------\n\n";
try {
    CsdService::Set($params);
    $response = CsdService::InfoActiveCsd('LAN7008173R5', 'stamp');
    var_dump($response);
}
catch(Exception $e){
    echo 'Caught exception: ',  $e->getMessage(), "\n";
}        
echo "\n\n--------------- Desactivar certificado ------------------\n\n";
try {
    CsdService::Set($params);
    $response = CsdService::DisableCsd('20001000000300022763');
    var_dump($response);
}
catch(Exception $e){
    echo 'Caught exception: ',  $e->getMessage(), "\n";
}
  
echo "\n\n------------ListaNegra---------------------\n\n";
ValidarListaNegra::Set($params);
$resultadoListaNegra = ValidarListaNegra::GetTaxpayer($rfcListaNegra);
var_dump($resultadoListaNegra);
?>