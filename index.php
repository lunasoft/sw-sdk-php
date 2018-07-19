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
  
    $cerB64 = "MIIFxTCCA62gAwIBAgIUMjAwMDEwMDAwMDAzMDAwMjI4MTUwDQYJKoZIhvcNAQELBQAwggFmMSAwHgYDVQQDDBdBLkMuIDIgZGUgcHJ1ZWJhcyg0MDk2KTEvMC0GA1UECgwmU2VydmljaW8gZGUgQWRtaW5pc3RyYWNpw7NuIFRyaWJ1dGFyaWExODA2BgNVBAsML0FkbWluaXN0cmFjacOzbiBkZSBTZWd1cmlkYWQgZGUgbGEgSW5mb3JtYWNpw7NuMSkwJwYJKoZIhvcNAQkBFhphc2lzbmV0QHBydWViYXMuc2F0LmdvYi5teDEmMCQGA1UECQwdQXYuIEhpZGFsZ28gNzcsIENvbC4gR3VlcnJlcm8xDjAMBgNVBBEMBTA2MzAwMQswCQYDVQQGEwJNWDEZMBcGA1UECAwQRGlzdHJpdG8gRmVkZXJhbDESMBAGA1UEBwwJQ295b2Fjw6FuMRUwEwYDVQQtEwxTQVQ5NzA3MDFOTjMxITAfBgkqhkiG9w0BCQIMElJlc3BvbnNhYmxlOiBBQ0RNQTAeFw0xNjEwMjUyMTUyMTFaFw0yMDEwMjUyMTUyMTFaMIGxMRowGAYDVQQDExFDSU5ERU1FWCBTQSBERSBDVjEaMBgGA1UEKRMRQ0lOREVNRVggU0EgREUgQ1YxGjAYBgNVBAoTEUNJTkRFTUVYIFNBIERFIENWMSUwIwYDVQQtExxMQU43MDA4MTczUjUgLyBGVUFCNzcwMTE3QlhBMR4wHAYDVQQFExUgLyBGVUFCNzcwMTE3TURGUk5OMDkxFDASBgNVBAsUC1BydWViYV9DRkRJMIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAgvvCiCFDFVaYX7xdVRhp/38ULWto/LKDSZy1yrXKpaqFXqERJWF78YHKf3N5GBoXgzwFPuDX+5kvY5wtYNxx/Owu2shNZqFFh6EKsysQMeP5rz6kE1gFYenaPEUP9zj+h0bL3xR5aqoTsqGF24mKBLoiaK44pXBzGzgsxZishVJVM6XbzNJVonEUNbI25DhgWAd86f2aU3BmOH2K1RZx41dtTT56UsszJls4tPFODr/caWuZEuUvLp1M3nj7Dyu88mhD2f+1fA/g7kzcU/1tcpFXF/rIy93APvkU72jwvkrnprzs+SnG81+/F16ahuGsb2EZ88dKHwqxEkwzhMyTbQIDAQABox0wGzAMBgNVHRMBAf8EAjAAMAsGA1UdDwQEAwIGwDANBgkqhkiG9w0BAQsFAAOCAgEAJ/xkL8I+fpilZP+9aO8n93+20XxVomLJjeSL+Ng2ErL2GgatpLuN5JknFBkZAhxVIgMaTS23zzk1RLtRaYvH83lBH5E+M+kEjFGp14Fne1iV2Pm3vL4jeLmzHgY1Kf5HmeVrrp4PU7WQg16VpyHaJ/eonPNiEBUjcyQ1iFfkzJmnSJvDGtfQK2TiEolDJApYv0OWdm4is9Bsfi9j6lI9/T6MNZ+/LM2L/t72Vau4r7m94JDEzaO3A0wHAtQ97fjBfBiO5M8AEISAV7eZidIl3iaJJHkQbBYiiW2gikreUZKPUX0HmlnIqqQcBJhWKRu6Nqk6aZBTETLLpGrvF9OArV1JSsbdw/ZH+P88RAt5em5/gjwwtFlNHyiKG5w+UFpaZOK3gZP0su0sa6dlPeQ9EL4JlFkGqQCgSQ+NOsXqaOavgoP5VLykLwuGnwIUnuhBTVeDbzpgrg9LuF5dYp/zs+Y9ScJqe5VMAagLSYTShNtN8luV7LvxF9pgWwZdcM7lUwqJmUddCiZqdngg3vzTactMToG16gZA4CWnMgbU4E+r541+FNMpgAZNvs2CiW/eApfaaQojsZEAHDsDv4L5n3M1CC7fYjE/d61aSng1LaO6T1mh+dEfPvLzp7zyzz+UgWMhi5Cs4pcXx1eic5r7uxPoBwcCTt3YI1jKVVnV7/w=";
    $keyB64 = "MIIFDjBABgkqhkiG9w0BBQ0wMzAbBgkqhkiG9w0BBQwwDgQIAgEAAoIBAQACAggAMBQGCCqGSIb3DQMHBAgwggS9AgEAMASCBMh4EHl7aNSCaMDA1VlRoXCZ5UUmqErAbucRBAKNQXH8t1GNfLDIQejtcocS39VvWnpNXjZJeCg65Y2wI36UGn78gvnU0NOmyUkXksPVrkz7hqNtAVojPUtN65l+MVAsIRVD6OLJeKZ2bLx5z78zrx6Tp1zCGT/NpxL+CJSy5iY6TKqbJcK/9198noOvT2p8rKVqUUF3wLRvD6R/b3BC5wCon/exp3BUTZeiWJqGRRgaW4rn49ZbJPVIcDmUO8mojPesFHjJDSnA0nBnWaUvTYXi0srT+dLZOewsBR8d5GdSWh9ZkM29wJbjYHCMsXkObZjaap3YM8fU29zRyZ8KAqaCnBHCfYjbib56m+Lmnk+ScqMkQQ+S/+2pzn2LzauvBI4p/OjQgBDeblo22X7sX9OA9YaqB3q6CCjQ5tkDNrz3HOgTm+amh/kI8TEn9rcKf4Ru7mC1T7VMaFgBqpIS8YJNbcgegF0IF1FpCS05wjdU5CktYAnPnvC+Pj+MFDeH+184kIHBWqPNG6dAzALxRgtKTlGdJ1l5Do+4EWI+0mvKojREnKoDczFnDeCFnM51u3I9Vce3rkf0djRQKFomPVUnPDqxlR5lDAssYAYNcECAkvGxKcBDbjWi/6NHlwjS1r28+0Jhvfxjx9O6hi4AW82Q2/kBE5P/eOwln/jKSbLgi7Iyim1FFHxkQH1FY5kcKhAzFcIq85rGFlzHRfPF9OIQSmONI9kcWQCxkk8aG1u1zwbjZRYLTxlwmZvynOgaWRpTN8Y4ReBDIG1klhva7nqqoM416oXBG71IKaCtjAwRlE6pgaqnIz/WQAb2FR541pqynX6dB6DB1nIWnatsWZJZlu+Bnhf9DBlUsO9ZSAf9Fa9nJAzwFCzaKIsvGJIeKSZ/h+vInkjaO/rxswErVROTfZy1lO2CJ/xnAgzFGrpDxNJPliv3McO9TGwYy/zHhE6Pdo8Xu6NsMisNU6TB8Bc26uLNv/7kWhNmNnBA1qt5akln6hOHrPBXGBiTNUL0IoFVPNdCbS0834zAYXfgtZLDzVpeLqmeMpqXbIYK0/NXe9etxuOcN40O+B/fTHHmO7dMgBZ4vAApVQUPr7ilumVHsWSMRP/0p5R9q4qr1bDm9S5YCPevdyYWTSceGSrXHmjYzJLBtpc/s77mynNqZEYjhnKk2XRNp6kp/FYRu+QdsX9vaDJbLKR2EnSC4fU6UOTO03IZU15j3wOsg30QrXoKntSJ/beF99cvFHuPrQPWxCtws0lLwkkHNVOm6XNO948Moy1w1pL4i68CwmceYZaYrYhmHGdLuescFQrZQaULDWhpK2Stys8Vs/XwwxNi9MHAFSXpdy/b+Aro5n87w+0MHRcllF8ZKbtQ/ym4oG7aREuo7o71JXJQPjZKTOtVM1EQx/FLM/5brnDSoyvLtoYtv9/tTnIC+8gR6eErkzaGmn8pftPhGNuz6yzx8JeLFoMD7VWbGTefj46KS+yMweFJnpReHEqwnukXpEYq19EWVyQa/Sb7navtKt80y/vRs0aNZp3iL23AOs0u1kQ1CFNY2y12Gor1koaH2FUd5jAQnaSKmgarLy0H/QVvR2g8B3+Fh49QhKYrd8N6LvvI80cwbEoqYWn5DWA=";
    $pfxB64 = base64_encode(
            file_get_contents('C:\Users\SMARTERWEB\Documents\sw-sdk-dotnet\Test_SW-sdk\Resources\CertificadosDePrueba\CSD_Prueba_CFDI_LAN8507268IA.pfx'));
    
    $password = "123456789A";
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
    
?>