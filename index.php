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


$params = array(
    "url"=>"http://services.test.sw.com.mx",
    "user"=>"demo",
    "password"=> "123456789"
);
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

    $xml = file_get_contents('Tests/Resources/file.xml');

  
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
        }
    ],
    "Impuestos": {
        "Retenciones": null,
        "Traslados": [
            {
                "Impuesto": "002",
                "TipoFactor": "Tasa",
                "TasaOCuota": "0.160000",
                "Importe": "32.00"
            },
            {
                "Impuesto": "003",
                "TipoFactor": "Tasa",
                "TasaOCuota": "1.600000",
                "Importe": "371.20"
            }
        ],
        "TotalImpuestosRetenidosSpecified": false,
        "TotalImpuestosTrasladados": "403.20",
        "TotalImpuestosTrasladadosSpecified": true
    },
    "Complemento": null,
    "Addenda": null,
    "Version": "3.3",
    "Serie": "RogueOne",
    "Folio": "HNFK231",
    "Fecha": "2018-07-12T10:10:51",
    "Sello": "",
    "FormaPago": "01",
    "FormaPagoSpecified": true,
    "NoCertificado": "",
    "Certificado": "",
    "CondicionesDePago": null,
    "SubTotal": "200.00",
    "DescuentoSpecified": false,
    "Moneda": "MXN",
    "TipoCambio": "1",
    "TipoCambioSpecified": true,
    "Total": "603.20",
    "TipoDeComprobante": "I",
    "MetodoPago": "PUE",
    "MetodoPagoSpecified": true,
    "LugarExpedicion": "06300",
    "Confirmacion": null
}';
    
    $jsonIssuerStamp = jsonEmisionTimbrado::Set($params);
    $resultadoJson = $jsonIssuerStamp::jsonEmisionTimbrado4($json);
    var_dump($resultadoJson);
    
?>