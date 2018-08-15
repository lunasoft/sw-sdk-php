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

header('Content-type: text/plain');

$params = array(
    "url"=>"http://services.test.sw.com.mx",
    "user"=>"demo",
    "password"=> "123456789"
    //"token"=>"T2lYQ0t4L0RHVkR4dHZ5Nkk1VHNEakZ3Y0J4Nk9GODZuRyt4cE1wVm5tbXB3YVZxTHdOdHAwVXY2NTdJb1hkREtXTzE3dk9pMmdMdkFDR2xFWFVPUXpTUm9mTG1ySXdZbFNja3FRa0RlYURqbzdzdlI2UUx1WGJiKzViUWY2dnZGbFloUDJ6RjhFTGF4M1BySnJ4cHF0YjUvbmRyWWpjTkVLN3ppd3RxL0dJPQ.T2lYQ0t4L0RHVkR4dHZ5Nkk1VHNEakZ3Y0J4Nk9GODZuRyt4cE1wVm5tbFlVcU92YUJTZWlHU3pER1kySnlXRTF4alNUS0ZWcUlVS0NhelhqaXdnWTRncklVSWVvZlFZMWNyUjVxYUFxMWFxcStUL1IzdGpHRTJqdS9Zakw2UGRIbjR0VUdSeTE1aFpNR09pNjRKSTFabW1obk8wYUoyeGpkUjBoNkJyZjB4WC9BYXdXdjlBNjd2eHJnRzZrTHlWZ0cwZGJFNWlDWjRaVUJ6MXpJb2xKZi9tMkRIVUZ6M2N3WUw5QVlKQ0dKc3IrSXFZVjNCa2RYN1BQMVp2dXc5VUxLZEc0bHA2ZVIrS3Q5WVZWNmJVWHRsN0V5S3RaZDdheWoyV25YN2d6bHdFREp2Y3N5eWw3SUhXZFdTZVFGSklyQlNRWHRWYmN5SzdKWTZtQTVXNk81ZlNaZTVFY1RwRjJGU2E4TlVTUDVWSDFlbU1URzFEL0laRUwzZDJ4UFNLMS9MK2s3MkhvRkI5NFQzaFRyOTFDUVoyNzQ3ZCttUEk5a0lUTk14NGNKcU9LS2dnbE5qQm5FNUs2YjJTNmoyUE9FUzBpNmVXek9VVmpaUUNWY3ptRklYSTNtT0ZNY25GeWwya0dubjVHZWNzYkI5RVVRUjhyMFArVUpKOFM4NDQ.uJo7ogsQ8hHzCP9brFVoL2YAriISveYSLFkLO_QmWbA"
);



    $accountBalance = accountBalanceService::Set($params);
    $accResponse = $accountBalance::GetAccountBalance();
    var_dump($accResponse);
    
echo "\n\n------------ Account Balance ---------------------\n\n";


try {
    $auth = Authentication::auth($params);
	$result = $auth::Token();
	
	if($result->status == "success") {
            echo $result->data->token;
            echo "\n\n------------Token---------------------\n\n";
	} else {
            echo $result->message;
            echo "\n\n---------------------------------\n\n";
	}
     
} catch(Exception $e){
    echo 'Caught exception: ',  $e->getMessage(), "\n";
}

    $xml = file_get_contents('Tests/Resources/file.xml');

  
    $issue = emisionTimbrado::Set($params);
    $resultadoIssue = $issue::EmisionTimbradoV4($xml);
    var_dump($resultadoIssue);
    
    echo "--------------- Emisión Timbrado ------------------\n\n";
 

    $stamp = timbrado::Set($params);
    $resultadoStamp = $stamp::TimbradoV4($xml);
    var_dump($resultadoStamp);
        
    echo "--------------- Timbrado ------------------\n\n";
         
    $validateXML = validarXML::Set($params);
    $resultadoValida = $validateXML::ValidaXML($xml);
    var_dump($resultadoValida);
    
    echo "-----------------Validación de XML ----------------\n\n";  
    
    $validateLCO = validaLco::Set($params);
    $resultadoLCO = $validateLCO::ValidaLco('20001000000300022816');
    var_dump($resultadoLCO);      
            
    echo "---------------- Validación LCO -----------------\n\n";  
    
    $validateLCRFC = validaLrfc::Set($params);
    $resultadoLRFC= $validateLCRFC::ValidaLrfc('LAN8507268IA');
    var_dump($resultadoLRFC);
    
    echo "----------------- Validación LRFC ----------------\n\n";  
    
    $json = file_get_contents("Tests/Resources/pagos10.json"); 
        
    $jsonIssuerStamp = jsonEmisionTimbrado::Set($params);
    $resultadoJson = $jsonIssuerStamp::jsonEmisionTimbrado4($json);
    
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
     
    echo "-------------- Emisión Timbrado por JSON -------------------\n\n"; 
    
    $cerB64 = base64_encode(file_get_contents('Tests\Resources\SignResources\CSD_PAC_CFDI_PRUEBAS\CSD_Prueba_CFDI_LAN8507268IA.cer'));
    $keyB64 = base64_encode(file_get_contents('Tests\Resources\SignResources\CSD_PAC_CFDI_PRUEBAS\CSD_Prueba_CFDI_LAN8507268IA.key'));
    $pfxB64 = base64_encode(file_get_contents('Tests\Resources\SignResources\CSD_PAC_CFDI_PRUEBAS\CSD_Prueba_CFDI_LAN8507268IA.pfx'));
    
    $password = "12345678a";
    $uuid = "551b9f77-1045-431d-a7a7-c8c19b3306fc";
    $rfc = "LAN8507268IA";
    $xmlCancelacion = "";
        
    $cancelRequestUUID = cancelationService::Set($params);
    $cancelationResult = $cancelRequestUUID::CancelationByUUID($rfc, $uuid);
    var_dump($cancelationResult);
    
    echo "---------------- Cancelación por UUID -----------------\n\n";  
    
    $cancelRequestPFX = cancelationService::Set($params);
    $cancelationPFX = $cancelRequestPFX::CancelationByPFX($rfc, $pfxB64, $password, $uuid);
    var_dump($cancelationPFX);
     
    echo "---------------- Cancelación por PFX -----------------\n\n";  
    
    $cancelRequestXML = cancelationService::Set($params);
    $cancelationXML = $cancelRequestXML::CancelationByXML($xmlCancelacion);
    var_dump($cancelationXML);
        
    echo "-----------------Cancelación por XML ----------------\n\n";  
    
    $cancelRequestCSD = cancelationService::Set($params);
    $cancelationCSD = $cancelRequestCSD::CancelationByCSD($rfc, $cerB64, $keyB64, $password, $uuid);
    var_dump($cancelationCSD);
    
    echo "---------------Cancelación por CSD ------------------\n\n";  

?>