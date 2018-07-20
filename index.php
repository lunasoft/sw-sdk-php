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


$params = array(
    "url"=>"http://services.test.sw.com.mx",
    "token"=>"T2lYQ0t4L0RHVkR4dHZ5Nkk1VHNEakZ3Y0J4Nk9GODZuRyt4cE1wVm5tbXB3YVZxTHdOdHAwVXY2NTdJb1hkREtXTzE3dk9pMmdMdkFDR2xFWFVPUXpTUm9mTG1ySXdZbFNja3FRa0RlYURqbzdzdlI2UUx1WGJiKzViUWY2dnZGbFloUDJ6RjhFTGF4M1BySnJ4cHF0YjUvbmRyWWpjTkVLN3ppd3RxL0dJPQ.T2lYQ0t4L0RHVkR4dHZ5Nkk1VHNEakZ3Y0J4Nk9GODZuRyt4cE1wVm5tbFlVcU92YUJTZWlHU3pER1kySnlXRTF4alNUS0ZWcUlVS0NhelhqaXdnWTRncklVSWVvZlFZMWNyUjVxYUFxMWFxcStUL1IzdGpHRTJqdS9Zakw2UGRDdGh1Z09sSFhhRG5pWU42V3Nzc1pPcVhFelZMWjZOZ3M5WU1YeGtGbldqVnh3WlpuWTVJdXp0ejJRWm5hY3dld0tqdzF1ZHd1TmtCWnM3Q2M0UlNpUlJmUjR5Y25yeUV5cDhLUzRQZzlPL2RnY0ZSSnF6c0RTWUUzREJiWVhySFBleDViMjcxWXpESmdOVlloK1JFR21xSEdUUHBReUZwaWw0a1RRNnFTUFVEbVhNaUxGOU96cHFid3NnKzd6S0dLRmlZeWxZd3lsSWM4Rm9DeENDTTlaZnlzU2dBdHlSdG5yb2RWU2pZb2hhNjNjcmp5VVFTL3dBNi9La0lXbXo4QXppS1E5cCthN0ROVlVrUTRCWkt0bFRXTGFKaEc5ZzB3eHphYldHcUtxTDUwZWErVllGWEg4cjFNRDVwVUdmMWJ6dTBBamF1elFmZHhLc0p2VG1RVTJwTDFscjNiNTlkemNTQlMvUk1Cc2l1Tzh6UTNxVDdzY2laLy85aXNFNDM.iCmHfUpXObAStbQjW77kqeoQge068vFDL6pRuw4TUBs"
    /*
    "user"=>"demo",
    "password"=> "123456789"
     */
);

    $accountBalance = accountBalanceService::Set($params);
    $accResponse = $accountBalance::GetAccountBalance();
    var_dump($accResponse);
    


/*
try {
    $auth = Authentication::auth($params);
	$result = $auth::Token();
	header('Content-type: text/plain');
	if($result->status == "success") {
            echo $result->data->token;
            echo "\n\n---------------------------------\n\n";
	} else {
            echo $result->message;
            echo "\n\n---------------------------------\n\n";
	}
     
} catch(Exception $e){
    echo 'Caught exception: ',  $e->getMessage(), "\n";
}
*/
    $xml = file_get_contents('Tests/Resources/file.xml');

  /*
    $issue = emisionTimbrado::Set($params);
    $resultadoIssue = $issue::EmisionTimbradoV4($xml);
    var_dump($resultadoIssue);
    
    echo "---------------------------------\n\n";
   

    $stamp = timbrado::Set($params);
    $resultadoStamp = $stamp::TimbradoV4($xml);
    var_dump($resultadoStamp);
        
    echo "---------------------------------\n\n";
         
    $validateXML = validarXML::Set($params);
    $resultadoValida = $validateXML::ValidaXML($xml);
    var_dump($resultadoValida);
    
    echo "---------------------------------\n\n";  
    
    $validateLCO = validaLco::Set($params);
    $resultadoLCO = $validateLCO::ValidaLco('20001000000300022816');
    var_dump($resultadoLCO);      
            
    echo "---------------------------------\n\n";  
    
    $validateLCRFC = validaLrfc::Set($params);
    $resultadoLRFC= $validateLCRFC::ValidaLrfc('COSE860610K59');
    var_dump($resultadoLRFC);
    
    echo "---------------------------------\n\n";  
    */
    $json = '{
    "RFCINC": null,
    "Rates": null,
    "ConfirmationStatus": 0,
    "HasNomina12": false,
    "HasPagos10": false,
    "HasComercioExterior11": false,
    "HasINE11": false,
    "HasECC11": false,
    "HasImpLocales": false,
    "HasComplemento": false,
    "CfdiRelacionados": null,
    "Emisor": {
        "Rfc": "LAN8507268IA",
        "Nombre": "MB IDEAS DIGITALES SC",
        "RegimenFiscal": "601"
    },
    "Receptor": {
        "Rfc": "AAA010101AAA",
        "Nombre": "SW SMARTERWEB",
        "ResidenciaFiscalSpecified": false,
        "NumRegIdTrib": null,
        "UsoCFDI": "G03"
    },
    "Conceptos": [
        {
            "Impuestos": {
                "Traslados": [
                    {
                        "Base": "200.00",
                        "Impuesto": "002",
                        "TipoFactor": "Tasa",
                        "TasaOCuota": "0.160000",
                        "TasaOCuotaSpecified": true,
                        "Importe": "32.00",
                        "ImporteSpecified": true
                    },
                    {
                        "Base": "232.00",
                        "Impuesto": "003",
                        "TipoFactor": "Tasa",
                        "TasaOCuota": "1.600000",
                        "TasaOCuotaSpecified": true,
                        "Importe": "371.20",
                        "ImporteSpecified": true
                    }
                ],
                "Retenciones": null
            },
            "InformacionAduanera": null,
            "CuentaPredial": null,
            "ComplementoConcepto": null,
            "Parte": null,
            "ClaveProdServ": "50211503",
            "NoIdentificacion": "UT421511",
            "Cantidad": 1,
            "ClaveUnidad": "H87",
            "Unidad": "Pieza",
            "Descripcion": "Cigarros",
            "ValorUnitario": "200.00",
            "Importe": "200.00",
            "DescuentoSpecified": false
        },
        {
            "Impuestos": {
                "Traslados": [
                    {
                        "Base": "200.00",
                        "Impuesto": "002",
                        "TipoFactor": "Tasa",
                        "TasaOCuota": "0.160000",
                        "TasaOCuotaSpecified": true,
                        "Importe": "32.00",
                        "ImporteSpecified": true
                    },
                    {
                        "Base": "232.00",
                        "Impuesto": "003",
                        "TipoFactor": "Tasa",
                        "TasaOCuota": "1.600000",
                        "TasaOCuotaSpecified": true,
                        "Importe": "371.20",
                        "ImporteSpecified": true
                    }
                ],
                "Retenciones": null
            },
            "InformacionAduanera": null,
            "CuentaPredial": null,
            "ComplementoConcepto": null,
            "Parte": null,
            "ClaveProdServ": "50211503",
            "NoIdentificacion": "UT421511",
            "Cantidad": 1,
            "ClaveUnidad": "H87",
            "Unidad": "Pieza",
            "Descripcion": "Cigarros",
            "ValorUnitario": "200.00",
            "Importe": "200.00",
            "DescuentoSpecified": false
        }
    ],
    "Impuestos": {
        "Retenciones": null,
        "Traslados": [
            {
                "Impuesto": "002",
                "TipoFactor": "Tasa",
                "TasaOCuota": "0.160000",
                "Importe": "64.00"
            },
            {
                "Impuesto": "003",
                "TipoFactor": "Tasa",
                "TasaOCuota": "1.600000",
                "Importe": "742.40"
            },
        ],
        "TotalImpuestosRetenidosSpecified": false,
        "TotalImpuestosTrasladados": "806.40",
        "TotalImpuestosTrasladadosSpecified": true
    },
    "Complemento": null,
    "Addenda": null,
    "Version": "3.3",
    "Serie": "RogueOne",
    "Folio": "HNFK231",
    "Fecha": "2018-07-18T10:10:30",
    "Sello": "",
    "FormaPago": "01",
    "FormaPagoSpecified": true,
    "NoCertificado": "",
    "Certificado": "",
    "CondicionesDePago": null,
    "SubTotal": "400.00",
    "DescuentoSpecified": false,
    "Moneda": "MXN",
    "TipoCambio": "1",
    "TipoCambioSpecified": true,
    "Total": "1206.40",
    "TipoDeComprobante": "I",
    "MetodoPago": "PUE",
    "MetodoPagoSpecified": true,
    "LugarExpedicion": "06300",
    "Confirmacion": null
}';
    echo "-------------- JSON -------------------\n\n"; 
    
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

  
     echo "---------------------------------\n\n"; 
    /*
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
    
     echo "---------------------------------\n\n";  
    
    $cancelRequestPFX = cancelationService::Set($params);
    $cancelationPFX = $cancelRequestPFX::CancelationByPFX($rfc, $pfxB64, $password, $uuid);
    var_dump($cancelationPFX);
     
     echo "---------------------------------\n\n";  
    
    $cancelRequestXML = cancelationService::Set($params);
    $cancelationXML = $cancelRequestXML::CancelationByXML($xmlCancelacion);
    var_dump($cancelationXML);
        
     echo "---------------------------------\n\n";  
    
    $cancelRequestCSD = cancelationService::Set($params);
    $cancelationCSD = $cancelRequestCSD::CancelationByCSD($rfc, $cerB64, $keyB64, $password, $uuid);
    var_dump($cancelationCSD);
    
     echo "---------------------------------\n\n";  
    */
?>