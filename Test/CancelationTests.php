<?php

namespace tests;
// include('../SWSDK.php');
use PHPUnit\Framework\TestCase;
use SWServices\Cancelation\CancelationService as CancelationService;
use Exception;

final class CancelationTests extends TestCase
{
	public function testCancelationByCSD()
	{
		$resultSpect = "success";
		$rfc = "EKU9003173C9";
		$uuid = "5643d565-3efb-4a29-98d1-dcf271503cb6";
		$cerB64 = base64_encode(file_get_contents('Test\Resources\cert_pruebas\EKU9003173C9.cer'));
		$keyB64 = base64_encode(file_get_contents('Test\Resources\cert_pruebas\EKU9003173C9.key'));
		$password = "12345678a";
		$motivo = "02";
		$token = "";
		$params = array(
			"url" => "http://services.test.sw.com.mx/",
			"token" => $token,
		);
		try {
			$cancelationService = CancelationService::Set($params);
			$result = $cancelationService::CancelationByCSD($rfc, $uuid, $motivo, $cerB64, $keyB64, $password);
			$this->assertEquals($resultSpect, $result->status);
			echo ($result);
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}
	public function testCancelationByCSD_null()
	{
		$resultSpect = "error";
		$rfc = "EKU9003173C9";
		$uuid = "5643d565-3efb-4a29-98d1-dcf271503cb6";
		$keyB64 = base64_encode(file_get_contents('Test\Resources\cert_pruebas\EKU9003173C9.key'));
		$password = "12345678a";
		$motivo = "02";
		$token = "";
		$params = array(
			"url" => "http://services.test.sw.com.mx/",
			"token" => $token
		);
		try {
			$cancelationService = CancelationService::Set($params);
			$result = $cancelationService::CancelationByCSD($rfc, $uuid, $motivo, null, $keyB64, $password);
			$this->assertEquals($resultSpect, $result->status);
			echo ($result);
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}
	/* -------------------------------------------------------Cancelación XML-------------------------------------------------------- */
	public function testCancelationByXML()
	{
		$resultSpect = "success";
		$xml = "<Cancelacion xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\" xmlns:xsd=\"http://www.w3.org/2001/XMLSchema\" Fecha=\"2023-10-03T16:13:34\" RfcEmisor=\"EKU9003173C9\" xmlns=\"http://cancelacfd.sat.gob.mx\"><Folios><Folio UUID=\"cfc771b4-7d90-459e-ab06-afd2b3c59c10\" Motivo=\"02\" FolioSustitucion=\"\" /></Folios><Signature xmlns=\"http://www.w3.org/2000/09/xmldsig#\"><SignedInfo><CanonicalizationMethod Algorithm=\"http://www.w3.org/TR/2001/REC-xml-c14n-20010315\" /><SignatureMethod Algorithm=\"http://www.w3.org/2000/09/xmldsig#rsa-sha1\" /><Reference URI=\"\"><Transforms><Transform Algorithm=\"http://www.w3.org/2000/09/xmldsig#enveloped-signature\" /></Transforms><DigestMethod Algorithm=\"http://www.w3.org/2000/09/xmldsig#sha1\" /><DigestValue>pbP/jvKYtx2BnQE3phHITknqAKo=</DigestValue></Reference></SignedInfo><SignatureValue>VDzWsmglBTaHEf9FY2FH4lBwExEH48O1NqBFYzDItuUZ3jArEfv3yDDOqD8TJHJC5VlqqNK/2aq8TqCs9waDgmgtH1w3zh5OU+OkPYIKRbN6wXoTFzKsdhOSIY7O3Yood5effR0RXQbX5aMtVwIyA09Twtv3FnTzxwM1gTpugs8GKqfDqlVTedrfIgkmWENmdtfJnj7fehLcS+hzIrfv0L23+E+h2ZLalbUFrdivGwkojELXpaPrQ+bwUqGYJlSCuPUkmSFHvgLp81LOeLx91x2JZlX4jSeJNI+l/Nfn5YEr9MTtsIK9o8kLdJMutiKAtfcG3t3A1IJQe6NhkXwnRg==</SignatureValue><KeyInfo><X509Data><X509IssuerSerial><X509IssuerName>OID.1.2.840.113549.1.9.2=responsable: ACDMA-SAT, OID.2.5.4.45=2.5.4.45, L=COYOACAN, S=CIUDAD DE MEXICO, C=MX, PostalCode=06370, STREET=3ra cerrada de caliz, E=oscar.martinez@sat.gob.mx, OU=SAT-IES Authority, O=SERVICIO DE ADMINISTRACION TRIBUTARIA, CN=AC UAT</X509IssuerName><X509SerialNumber>292233162870206001759766198462772978647764840758</X509SerialNumber></X509IssuerSerial><X509Certificate>MIIFsDCCA5igAwIBAgIUMzAwMDEwMDAwMDA1MDAwMDM0MTYwDQYJKoZIhvcNAQELBQAwggErMQ8wDQYDVQQDDAZBQyBVQVQxLjAsBgNVBAoMJVNFUlZJQ0lPIERFIEFETUlOSVNUUkFDSU9OIFRSSUJVVEFSSUExGjAYBgNVBAsMEVNBVC1JRVMgQXV0aG9yaXR5MSgwJgYJKoZIhvcNAQkBFhlvc2Nhci5tYXJ0aW5lekBzYXQuZ29iLm14MR0wGwYDVQQJDBQzcmEgY2VycmFkYSBkZSBjYWxpejEOMAwGA1UEEQwFMDYzNzAxCzAJBgNVBAYTAk1YMRkwFwYDVQQIDBBDSVVEQUQgREUgTUVYSUNPMREwDwYDVQQHDAhDT1lPQUNBTjERMA8GA1UELRMIMi41LjQuNDUxJTAjBgkqhkiG9w0BCQITFnJlc3BvbnNhYmxlOiBBQ0RNQS1TQVQwHhcNMjMwNTE4MTE0MzUxWhcNMjcwNTE4MTE0MzUxWjCB1zEnMCUGA1UEAxMeRVNDVUVMQSBLRU1QRVIgVVJHQVRFIFNBIERFIENWMScwJQYDVQQpEx5FU0NVRUxBIEtFTVBFUiBVUkdBVEUgU0EgREUgQ1YxJzAlBgNVBAoTHkVTQ1VFTEEgS0VNUEVSIFVSR0FURSBTQSBERSBDVjElMCMGA1UELRMcRUtVOTAwMzE3M0M5IC8gVkFEQTgwMDkyN0RKMzEeMBwGA1UEBRMVIC8gVkFEQTgwMDkyN0hTUlNSTDA1MRMwEQYDVQQLEwpTdWN1cnNhbCAxMIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAtmecO6n2GS0zL025gbHGQVxznPDICoXzR2uUngz4DqxVUC/w9cE6FxSiXm2ap8Gcjg7wmcZfm85EBaxCx/0J2u5CqnhzIoGCdhBPuhWQnIh5TLgj/X6uNquwZkKChbNe9aeFirU/JbyN7Egia9oKH9KZUsodiM/pWAH00PCtoKJ9OBcSHMq8Rqa3KKoBcfkg1ZrgueffwRLws9yOcRWLb02sDOPzGIm/jEFicVYt2Hw1qdRE5xmTZ7AGG0UHs+unkGjpCVeJ+BEBn0JPLWVvDKHZAQMj6s5Bku35+d/MyATkpOPsGT/VTnsouxekDfikJD1f7A1ZpJbqDpkJnss3vQIDAQABox0wGzAMBgNVHRMBAf8EAjAAMAsGA1UdDwQEAwIGwDANBgkqhkiG9w0BAQsFAAOCAgEAFaUgj5PqgvJigNMgtrdXZnbPfVBbukAbW4OGnUhNrA7SRAAfv2BSGk16PI0nBOr7qF2mItmBnjgEwk+DTv8Zr7w5qp7vleC6dIsZFNJoa6ZndrE/f7KO1CYruLXr5gwEkIyGfJ9NwyIagvHHMszzyHiSZIA850fWtbqtythpAliJ2jF35M5pNS+YTkRB+T6L/c6m00ymN3q9lT1rB03YywxrLreRSFZOSrbwWfg34EJbHfbFXpCSVYdJRfiVdvHnewN0r5fUlPtR9stQHyuqewzdkyb5jTTw02D2cUfL57vlPStBj7SEi3uOWvLrsiDnnCIxRMYJ2UA2ktDKHk+zWnsDmaeleSzonv2CHW42yXYPCvWi88oE1DJNYLNkIjua7MxAnkNZbScNw01A6zbLsZ3y8G6eEYnxSTRfwjd8EP4kdiHNJftm7Z4iRU7HOVh79/lRWB+gd171s3d/mI9kte3MRy6V8MMEMCAnMboGpaooYwgAmwclI2XZCczNWXfhaWe0ZS5PmytD/GDpXzkX0oEgY9K/uYo5V77NdZbGAjmyi8cE2B2ogvyaN2XfIInrZPgEffJ4AB7kFA2mwesdLOCh0BLD9itmCve3A1FGR4+stO2ANUoiI3w3Tv2yQSg4bjeDlJ08lXaaFCLW2peEXMXjQUk7fmpb5MNuOUTW6BE=</X509Certificate></X509Data></KeyInfo></Signature></Cancelacion>";
		$token = "";
		$params = array(
			"url" => "http://services.test.sw.com.mx/",
			"token" => $token
		);
		try {
			$cancelationService = CancelationService::Set($params);
			$result = $cancelationService::CancelationByXML($xml);
			$this->assertEquals($resultSpect, $result->status);
			echo ($result);
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}
	public function testCancelationByXML_null()
	{
		$resultSpect = "error";
		$token = "";
		$params = array(
			"url" => "http://services.test.sw.com.mx/",
			"token" => $token
		);
		try {
			$cancelationService = CancelationService::Set($params);
			$result = $cancelationService::CancelationByXML(null);
			$this->assertEquals($resultSpect, $result->status);
			echo ($result);
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}
	/* -------------------------------------------------------Cancelación PFX-------------------------------------------------------- */
	public function testCancelationByPfx()
	{
		$resultSpect = "success";
		$pfxB64 = base64_encode(file_get_contents('Test\Resources\cert_pruebas\EKU9003173C9.pfx'));
		$passwordPfx = "swpass";
		$uuid = "cfc771b4-7d90-459e-ab06-afd2b3c59c10";
		$rfc = "EKU9003173C9";
		$motivo = "02";
		$token = "";
		$params = array(
			"url" => "http://services.test.sw.com.mx/",
			"token" => $token
		);

		try {

			$cancelationService = CancelationService::Set($params);
			$result = $cancelationService::CancelationByPFX($rfc, $uuid, $motivo, $pfxB64, $passwordPfx);
			$this->assertEquals($resultSpect, $result->status);
			echo ($result);
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}
	public function testCancelationByPfx_null()
	{
		$resultSpect = "error";
		$passwordPfx = "swpass";
		$uuid = "cfc771b4-7d90-459e-ab06-afd2b3c59c10";
		$rfc = "EKU9003173C9";
		$motivo = "02";
		$token = "";
		$params = array(
			"url" => "http://services.test.sw.com.mx/",
			"token" => $token
		);
		try {

			$cancelationService = CancelationService::Set($params);
			$result = $cancelationService::CancelationByPFX($rfc, $uuid, $motivo, null, $passwordPfx);
			$this->assertEquals($resultSpect, $result->status);
			echo ($result);
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}
	/* -------------------------------------------------------Cancelación UUID------------------------------------------------------- */
	public function testCancelationByUUID()
	{
		$resultSpect = "success";
		$uuid = "cfc771b4-7d90-459e-ab06-afd2b3c59c10";
		$rfc = "EKU9003173C9";
		$motivo = "02";
		$token = "";
		$params = array(
			"url" => "http://services.test.sw.com.mx",
			"token" => $token
		);

		try {
			$cancelationService = CancelationService::Set($params);
			$result = $cancelationService::CancelationByUUID($rfc, $uuid, $motivo);
			$this->assertEquals($resultSpect, $result->status);
			echo ($result);
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}
	public function testCancelationByUUID_null()
	{
		$resultSpect = "error";
		$rfc = "EKU9003173C9";
		$motivo = "02";
		$token = "";
		$params = array(
			"url" => "http://services.test.sw.com.mx",
			"token" => $token
		);

		try {
			$cancelationService = CancelationService::Set($params);
			$result = $cancelationService::CancelationByUUID($rfc, null, $motivo);
			$this->assertEquals($resultSpect, $result->status);
			echo ($result);
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}
}
