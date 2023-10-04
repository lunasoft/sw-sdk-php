<?php
require_once 'SWSDK.php';

use SWServices\Authentication\AuthenticationService as Authentication;
use SWServices\Stamp\StampService as StampService;
use SWServices\Stamp\EmisionTimbrado as EmisionTimbrado;
use SWServices\Validation\ValidarXML as ValidarXML;
use SWServices\JSonIssuer\JsonEmisionTimbrado as JsonEmisionTimbrado;
use SWServices\Cancelation\CancelationService as CancelationService;
use SWServices\AccountBalance\AccountBalanceService as AccountBalanceService;
use SWServices\SatQuery\SatQueryService as SatQueryService;
use SWServices\Csd\CsdService as CsdService;
use SWServices\Services;

header('Content-type: text/plain');


$params = array(
    "url" => "http://services.test.sw.com.mx",
    "user" => "cuentasw@sw.com.mx",
    "password" => "12345678"
);

echo "\n\n------------Token---------------------\n\n";
try {
    Authentication::auth($params);
    $result = Authentication::Token();

    if ($result->status == "success") {
        echo $result->data->token;
    } else {
        echo $result->message;
    }
} catch (Exception $e) {
    echo 'Caught exception: ',  $e->getMessage(), "\n";
}

echo "\n\n------------ Account Balance ---------------------\n\n";
try {
    AccountBalanceService::Set($params);
    $accResponse = AccountBalanceService::GetAccountBalance();
    var_dump($accResponse);
} catch (Exception $e) {
    echo 'Caught exception: ',  $e->getMessage(), "\n";
}
$xml = file_get_contents('Test/Resources/file.xml');

echo "\n\n--------------- Emisión Timbrado ------------------\n\n";
try {
    EmisionTimbrado::Set($params);
    $resultadoIssue = EmisionTimbrado::EmisionTimbradoV4($xml);
    var_dump($resultadoIssue);
} catch (Exception $e) {
    echo 'Caught exception: ',  $e->getMessage(), "\n";
}

echo "\n\n--------------- Timbrado ------------------\n\n";
try {
    StampService::Set($params);
    $resultadoStamp = StampService::StampV4($xml);
    var_dump($resultadoStamp);
} catch (Exception $e) {
    echo 'Caught exception: ',  $e->getMessage(), "\n";
}

echo "\n\n-----------------Validación de XML ----------------\n\n";
try {
    ValidarXML::Set($params);
    $resultadoValida = ValidarXML::ValidaXML($xml);
    var_dump($resultadoValida);
} catch (Exception $e) {
    echo 'Caught exception: ',  $e->getMessage(), "\n";
}


echo "\n\n-------------- Emisión Timbrado por JSON -------------------\n\n";
try {
    $json = file_get_contents("Test/Resources/cfdi33_json_pagos.json");
    JsonEmisionTimbrado::Set($params);
    $resultadoJson = JsonEmisionTimbrado::JsonEmisionTimbradoV4($json);

    $resultadoJson->status == "success"
        ?
        print_r($resultadoJson->data->cadenaOriginalSAT) .
        print_r($resultadoJson->data->noCertificadoSAT) .
        print_r($resultadoJson->data->noCertificadoCFDI) .
        print_r($resultadoJson->data->uuid) .
        print_r($resultadoJson->data->selloSAT) .
        print_r($resultadoJson->data->selloCFDI) .
        print_r($resultadoJson->data->fechaTimbrado) .
        print_r($resultadoJson->data->qrCode) .
        print_r($resultadoJson->data->cfdi) :
        print_r($resultadoJson->message) .
        print_r($resultadoJson->messageDetail);
} catch (Exception $e) {
    echo 'Caught exception: ',  $e->getMessage(), "\n";
}

// Parametros   
$cerB64 = base64_encode(file_get_contents('Test\Resources\cert_pruebas\EKU9003173C9.cer'));
$keyB64 = base64_encode(file_get_contents('Test\Resources\cert_pruebas\EKU9003173C9.key'));
$pfxB64 = base64_encode(file_get_contents('Test\Resources\cert_pruebas\EKU9003173C9.pfx'));
$password = "12345678a";
$passwordPfx = "swpass";
$uuid = "cfc771b4-7d90-459e-ab06-afd2b3c59c10";
$rfc = "EKU9003173C9";
$xmlCancelacion = "<Cancelacion xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\" xmlns:xsd=\"http://www.w3.org/2001/XMLSchema\" Fecha=\"2023-10-03T16:13:34\" RfcEmisor=\"EKU9003173C9\" xmlns=\"http://cancelacfd.sat.gob.mx\"><Folios><Folio UUID=\"cfc771b4-7d90-459e-ab06-afd2b3c59c10\" Motivo=\"02\" FolioSustitucion=\"\" /></Folios><Signature xmlns=\"http://www.w3.org/2000/09/xmldsig#\"><SignedInfo><CanonicalizationMethod Algorithm=\"http://www.w3.org/TR/2001/REC-xml-c14n-20010315\" /><SignatureMethod Algorithm=\"http://www.w3.org/2000/09/xmldsig#rsa-sha1\" /><Reference URI=\"\"><Transforms><Transform Algorithm=\"http://www.w3.org/2000/09/xmldsig#enveloped-signature\" /></Transforms><DigestMethod Algorithm=\"http://www.w3.org/2000/09/xmldsig#sha1\" /><DigestValue>pbP/jvKYtx2BnQE3phHITknqAKo=</DigestValue></Reference></SignedInfo><SignatureValue>VDzWsmglBTaHEf9FY2FH4lBwExEH48O1NqBFYzDItuUZ3jArEfv3yDDOqD8TJHJC5VlqqNK/2aq8TqCs9waDgmgtH1w3zh5OU+OkPYIKRbN6wXoTFzKsdhOSIY7O3Yood5effR0RXQbX5aMtVwIyA09Twtv3FnTzxwM1gTpugs8GKqfDqlVTedrfIgkmWENmdtfJnj7fehLcS+hzIrfv0L23+E+h2ZLalbUFrdivGwkojELXpaPrQ+bwUqGYJlSCuPUkmSFHvgLp81LOeLx91x2JZlX4jSeJNI+l/Nfn5YEr9MTtsIK9o8kLdJMutiKAtfcG3t3A1IJQe6NhkXwnRg==</SignatureValue><KeyInfo><X509Data><X509IssuerSerial><X509IssuerName>OID.1.2.840.113549.1.9.2=responsable: ACDMA-SAT, OID.2.5.4.45=2.5.4.45, L=COYOACAN, S=CIUDAD DE MEXICO, C=MX, PostalCode=06370, STREET=3ra cerrada de caliz, E=oscar.martinez@sat.gob.mx, OU=SAT-IES Authority, O=SERVICIO DE ADMINISTRACION TRIBUTARIA, CN=AC UAT</X509IssuerName><X509SerialNumber>292233162870206001759766198462772978647764840758</X509SerialNumber></X509IssuerSerial><X509Certificate>MIIFsDCCA5igAwIBAgIUMzAwMDEwMDAwMDA1MDAwMDM0MTYwDQYJKoZIhvcNAQELBQAwggErMQ8wDQYDVQQDDAZBQyBVQVQxLjAsBgNVBAoMJVNFUlZJQ0lPIERFIEFETUlOSVNUUkFDSU9OIFRSSUJVVEFSSUExGjAYBgNVBAsMEVNBVC1JRVMgQXV0aG9yaXR5MSgwJgYJKoZIhvcNAQkBFhlvc2Nhci5tYXJ0aW5lekBzYXQuZ29iLm14MR0wGwYDVQQJDBQzcmEgY2VycmFkYSBkZSBjYWxpejEOMAwGA1UEEQwFMDYzNzAxCzAJBgNVBAYTAk1YMRkwFwYDVQQIDBBDSVVEQUQgREUgTUVYSUNPMREwDwYDVQQHDAhDT1lPQUNBTjERMA8GA1UELRMIMi41LjQuNDUxJTAjBgkqhkiG9w0BCQITFnJlc3BvbnNhYmxlOiBBQ0RNQS1TQVQwHhcNMjMwNTE4MTE0MzUxWhcNMjcwNTE4MTE0MzUxWjCB1zEnMCUGA1UEAxMeRVNDVUVMQSBLRU1QRVIgVVJHQVRFIFNBIERFIENWMScwJQYDVQQpEx5FU0NVRUxBIEtFTVBFUiBVUkdBVEUgU0EgREUgQ1YxJzAlBgNVBAoTHkVTQ1VFTEEgS0VNUEVSIFVSR0FURSBTQSBERSBDVjElMCMGA1UELRMcRUtVOTAwMzE3M0M5IC8gVkFEQTgwMDkyN0RKMzEeMBwGA1UEBRMVIC8gVkFEQTgwMDkyN0hTUlNSTDA1MRMwEQYDVQQLEwpTdWN1cnNhbCAxMIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAtmecO6n2GS0zL025gbHGQVxznPDICoXzR2uUngz4DqxVUC/w9cE6FxSiXm2ap8Gcjg7wmcZfm85EBaxCx/0J2u5CqnhzIoGCdhBPuhWQnIh5TLgj/X6uNquwZkKChbNe9aeFirU/JbyN7Egia9oKH9KZUsodiM/pWAH00PCtoKJ9OBcSHMq8Rqa3KKoBcfkg1ZrgueffwRLws9yOcRWLb02sDOPzGIm/jEFicVYt2Hw1qdRE5xmTZ7AGG0UHs+unkGjpCVeJ+BEBn0JPLWVvDKHZAQMj6s5Bku35+d/MyATkpOPsGT/VTnsouxekDfikJD1f7A1ZpJbqDpkJnss3vQIDAQABox0wGzAMBgNVHRMBAf8EAjAAMAsGA1UdDwQEAwIGwDANBgkqhkiG9w0BAQsFAAOCAgEAFaUgj5PqgvJigNMgtrdXZnbPfVBbukAbW4OGnUhNrA7SRAAfv2BSGk16PI0nBOr7qF2mItmBnjgEwk+DTv8Zr7w5qp7vleC6dIsZFNJoa6ZndrE/f7KO1CYruLXr5gwEkIyGfJ9NwyIagvHHMszzyHiSZIA850fWtbqtythpAliJ2jF35M5pNS+YTkRB+T6L/c6m00ymN3q9lT1rB03YywxrLreRSFZOSrbwWfg34EJbHfbFXpCSVYdJRfiVdvHnewN0r5fUlPtR9stQHyuqewzdkyb5jTTw02D2cUfL57vlPStBj7SEi3uOWvLrsiDnnCIxRMYJ2UA2ktDKHk+zWnsDmaeleSzonv2CHW42yXYPCvWi88oE1DJNYLNkIjua7MxAnkNZbScNw01A6zbLsZ3y8G6eEYnxSTRfwjd8EP4kdiHNJftm7Z4iRU7HOVh79/lRWB+gd171s3d/mI9kte3MRy6V8MMEMCAnMboGpaooYwgAmwclI2XZCczNWXfhaWe0ZS5PmytD/GDpXzkX0oEgY9K/uYo5V77NdZbGAjmyi8cE2B2ogvyaN2XfIInrZPgEffJ4AB7kFA2mwesdLOCh0BLD9itmCve3A1FGR4+stO2ANUoiI3w3Tv2yQSg4bjeDlJ08lXaaFCLW2peEXMXjQUk7fmpb5MNuOUTW6BE=</X509Certificate></X509Data></KeyInfo></Signature></Cancelacion>";
$motivo = "02";

echo "\n\n---------------- Cancelación por UUID -----------------\n\n";
try {
    CancelationService::Set($params);
    $cancelationResult = CancelationService::CancelationByUUID($rfc, $uuid, $motivo);
    var_dump($cancelationResult);
} catch (Exception $e) {
    echo 'Caught exception: ',  $e->getMessage(), "\n";
}
echo "\n\n---------------- Cancelación por PFX -----------------\n\n";
try {
    CancelationService::Set($params);
    $cancelationPFX = CancelationService::CancelationByPFX($rfc, $uuid, $motivo, $pfxB64, $passwordPfx);
    var_dump($cancelationPFX);
} catch (Exception $e) {
    echo 'Caught exception: ',  $e->getMessage(), "\n";
}
echo "\n\n---------------- Cancelación por XML -----------------\n\n";
try {
    CancelationService::Set($params);
    $cancelationXML = CancelationService::CancelationByXML($xmlCancelacion);
    var_dump($cancelationXML);
} catch (Exception $e) {
    echo 'Caught exception: ',  $e->getMessage(), "\n";
}
echo "\n\n-----------------Cancelación por CSD ----------------\n\n";
try {
    CancelationService::Set($params);
    $cancelationCSD = CancelationService::CancelationByCSD($rfc, $uuid, $motivo, $cerB64, $keyB64, $password);
    var_dump($cancelationCSD);
} catch (Exception $e) {
    echo 'Caught exception: ',  $e->getMessage(), "\n";
}

echo "\n\n--------------- Consulta Status CFDI SAT ------------------\n\n";

$soapUrl = "https://consultaqr.facturaelectronica.sat.gob.mx/ConsultaCFDIService.svc";
$re = "LSO1306189R5";
$rr = "LSO1306189R5";
$tt = 1.16;
$uuid = "E0AAE6B3-43CC-4B9C-B229-7E221000E2BB";
$sello = "bb2k2g==";

$consultaCfdi = SatQueryService::ServicioConsultaSAT($soapUrl, $re, $rr, $tt, $uuid, $sello);
var_dump($consultaCfdi);

echo "\n\n--------------- Consulta Pendientes por Cancelar ------------------\n\n";
try {
    $rfc = "LAN7008173R5";
    CancelationService::Set($params);
    $consultaPendientes = CancelationService::PendientesPorCancelar($rfc);
    var_dump($consultaPendientes);
} catch (Exception $e) {
    echo 'Caught exception: ',  $e->getMessage(), "\n";
}

echo "\n\n--------------- Consulta Relacionados ------------------\n\n";
try {
    $uuid = "E0AAE6B3-43CC-4B9C-B229-7E221000E2BB";
    CancelationService::Set($params);
    $cfdiRelacionados = CancelationService::ConsultarCFDIRelacionadosUUID($rfc, $uuid);
    var_dump($cfdiRelacionados);
} catch (Exception $e) {
    echo 'Caught exception: ',  $e->getMessage(), "\n";
}

echo "\n\n--------------- Aceptar o rechazar Cancelación ------------------\n\n";
try {
    $accion = "Aceptacion";
    CancelationService::Set($params);
    $aceptarRechazar = CancelationService::AceptarRechazarCancelacionUUID($rfc, $uuid, $accion);
    var_dump($aceptarRechazar);
} catch (Exception $e) {
    echo 'Caught exception: ',  $e->getMessage(), "\n";
}

echo "\n\n--------------- Subir certificado ------------------\n\n";
try {
    $isActive = true;
    $type = "stamp";
    $password = "12345678a";
    $b64Cer = base64_encode(file_get_contents("Test\Resources\SignResources\CSD_PAC_CFDI_PRUEBAS\CSD_Prueba_CFDI_LAN8507268IA.cer"));
    $b64Key = base64_encode(file_get_contents("Test\Resources\SignResources\CSD_PAC_CFDI_PRUEBAS\CSD_Prueba_CFDI_LAN8507268IA.key"));
    CsdService::Set($params);
    $response = CsdService::UploadCsd($isActive, $type, $b64Cer, $b64Key, $password);
    var_dump($response);
} catch (Exception $e) {
    echo 'Caught exception: ',  $e->getMessage(), "\n";
}

echo "\n\n--------------- Lista certificados ------------------\n\n";
try {
    CsdService::Set($params);
    $response = CsdService::GetListCsd();
    var_dump($response);
} catch (Exception $e) {
    echo 'Caught exception: ',  $e->getMessage(), "\n";
}

echo "\n\n--------------- Lista certificados por tipo ------------------\n\n";
try {
    CsdService::Set($params);
    $response = CsdService::GetListCsdByType('stamp');
    var_dump($response);
} catch (Exception $e) {
    echo 'Caught exception: ',  $e->getMessage(), "\n";
}

echo "\n\n--------------- Lista certificados por Rfc ------------------\n\n";
try {
    CsdService::Set($params);
    $response = CsdService::GetListCsdByRfc('LAN7008173R5');
    var_dump($response);
} catch (Exception $e) {
    echo 'Caught exception: ',  $e->getMessage(), "\n";
}

echo "\n\n--------------- Buscar certificado por número de csd ------------------\n\n";
try {
    CsdService::Set($params);
    $response = CsdService::InfoCsd('20001000000300022816');
    var_dump($response);
} catch (Exception $e) {
    echo 'Caught exception: ',  $e->getMessage(), "\n";
}


echo "\n\n--------------- Buscar certificado activo por rfc y tipo ------------------\n\n";
try {
    CsdService::Set($params);
    $response = CsdService::InfoActiveCsd('LAN7008173R5', 'stamp');
    var_dump($response);
} catch (Exception $e) {
    echo 'Caught exception: ',  $e->getMessage(), "\n";
}

echo "\n\n--------------- Desactivar certificado ------------------\n\n";
try {
    CsdService::Set($params);
    $response = CsdService::DisableCsd('20001000000300022763');
    var_dump($response);
} catch (Exception $e) {
    echo 'Caught exception: ',  $e->getMessage(), "\n";
}
