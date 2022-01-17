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
		$rfc = "JUFA7608212V6";
		$uuid = "7596b277-7c5d-4bb0-826c-7b3951fb87eb";
		$password = "123456789";
		$motivo = "02";
		$b64Cer = "MIIFmjCCA4KgAwIBAgIUMzAwMDEwMDAwMDA0MDAwMDIzMzEwDQYJKoZIhvcNAQELBQAwggErMQ8wDQYDVQQDDAZBQyBVQVQxLjAsBgNVBAoMJVNFUlZJQ0lPIERFIEFETUlOSVNUUkFDSU9OIFRSSUJVVEFSSUExGjAYBgNVBAsMEVNBVC1JRVMgQXV0aG9yaXR5MSgwJgYJKoZIhvcNAQkBFhlvc2Nhci5tYXJ0aW5lekBzYXQuZ29iLm14MR0wGwYDVQQJDBQzcmEgY2VycmFkYSBkZSBjYWRpejEOMAwGA1UEEQwFMDYzNzAxCzAJBgNVBAYTAk1YMRkwFwYDVQQIDBBDSVVEQUQgREUgTUVYSUNPMREwDwYDVQQHDAhDT1lPQUNBTjERMA8GA1UELRMIMi41LjQuNDUxJTAjBgkqhkiG9w0BCQITFnJlc3BvbnNhYmxlOiBBQ0RNQS1TQVQwHhcNMTkwNTI5MTg0MjI1WhcNMjMwNTI5MTg0MjI1WjCBwTEhMB8GA1UEAxMYQURSSUFOQSBKVUFSRVogRkVSTkFOREVaMSEwHwYDVQQpExhBRFJJQU5BIEpVQVJFWiBGRVJOQU5ERVoxITAfBgNVBAoTGEFEUklBTkEgSlVBUkVaIEZFUk5BTkRFWjEWMBQGA1UELRMNSlVGQTc2MDgyMTJWNjEbMBkGA1UEBRMSSlVGQTc2MDgyMU1ER1JSRDA0MSEwHwYDVQQLExhBRFJJQU5BIEpVQVJFWiBGRVJOQU5ERVowggEiMA0GCSqGSIb3DQEBAQUAA4IBDwAwggEKAoIBAQCpXbIyGRpoZ5ZMYLRJBTrB7bbIclWRXINqUM24moy6phoaXNvMtg2+DIksnOoQqSsMhJ087rgBZ1AwCfb1AgEcQ1JeFY7Yk6w5a/b7QGPH9Tblc65OZVZw7xYrBwvFVAlnmvglEtCL8gQxDVlyVd/g3lWVaQohH+vmnQdZVjKSm5RI0NTBl5Na438CytOv+hufF54OSOXZEMFVXt6rBiKLmrEheKIDAMmFuIFxD0O8e2bNvK8Oo+xmC2hH5UXlq/L5jn0rmnEnYp6v5eXs5K1ToRFztah4kaFT6nNUC6H/K6qA1B3rRtGc0ueCP/dt+sBpZG9c5ra6JAPIcozQwayvAgMBAAGjHTAbMAwGA1UdEwEB/wQCMAAwCwYDVR0PBAQDAgbAMA0GCSqGSIb3DQEBCwUAA4ICAQBP+zRQgUwTdebjklxJJ9QydHZGTQ0N7Qs9PlTnCoiC5QRMO9lTOlySi7AUL4V6cLQ4JCt8LgHeWP7gy3fbtIyyAvitJ0cvWvrtr3/Zj+K/0VfHbaOJf+v9Cc64UqU9mKAdAlmd5kteEPDEcFY9noatWpqVJY1Pc7tsWg038MIq+OS1/vYyrhZPRiFMaHLRJsRTthUZHdWg5mlXC8O7pJSsCapToehb1m5lIdHuydYn6d9VuAOe9h4/RLVX9D2fH3hUVi0YMDyCarybDYO32MdZsTguHCnXpAxUj0ANk3KSirt22jLz2kX/mZJ+amaN/hin50Fs23Hl4RSguZnFbJPXCJfcRg0lidq8GGHu2JPQjB0h7M4tojEZYMxAb/0sQkTAcKy2hHvwUQisYjOEwY2NNyeC7veQqqyLPzPeldc2LVfX3aYvB5QWWEn88BZWJJ2FUVsxE4NQmi0IAc2cTRcJj4DLU/sGGW/eZqrutVo+uBL93apxFeAjFC01teVKLAAfqre13aMfWeIgjCnqksnpbAsKSnS8plQF2b10jl10otgEDXHdOl6octjb3zIWoFPBxHI6y0bQxnzsABuZQwgIxzlDDoNeQXcJjX+IyqWTOcjMZ9Kn+pb6JtCjK4mLKJTT3jnYZSSeJMr3AQx1nNV371rBImhTEi90uhDsUCuFbg==";
		$b64Key = "MIIFDjBABgkqhkiG9w0BBQ0wMzAbBgkqhkiG9w0BBQwwDgQIAgEAAoIBAQACAggAMBQGCCqGSIb3DQMHBAgwggS8AgEAMASCBMh4EHl7aNSCaMDA1VlRoXCZ5UUmqErAbucRFLOMmsAaFHvMnY9VMcnZvyAUjwxrGgBpn7Qfm6z/1I6/RcjEQpGl+uI/rSnvCwrO9G4y8MAJnCoA+O9LuLpFrMVXFT2AjBxz/KZH/XbMjL3Okvuv3os25Tw4ZRj+lj1XLy+DkTdv8FiJ5kXbDwwQGp25xQS7xNTHw8x+OMxdRM5Yrj4KuibY1wNW73nqnZUFczUEJa4Zk5W+m4iq11e2FQ3bsJ+y/wxgCEu5IdodmwbRSrXq4VbtTJO7ZCAxxzlRdMalqtTfx6p3yqAJGl+SgPfUy1Xi7EEZ/1loG1RSsJGT3LGifIBxQtXQ03/2tbokoDIXWP2Kf2+9M+FEAz1p7uvoMKqXHunPUNxJ5yd2XWzvBx6r6oXYfkBzQgtiHYjcgH5WtSUMJxp9xcs2SzfND9Lr6Cc1ihwhO889vI+RVsB6COYNSp8r8jr+cV/ncLVdz1Z1Kxfck3hvuLpkssFSHk6OQW++9YGntQrNpONLVxaubrMMGjadmLro89D3JF+RBnrjeYN7oog3mEgtdxos0oCh9Xxz9M7JiyPa3jYWWpppJzrfF/5qvKI10exMyds31W5TNHQ0ETwNaApYFs5SxxM88cx3OjTw42SwYFF6ydznToOt6Km7Hgd395pxzWpXE13697GEF1DgUILAw2BoYup/VBHIGjvAzfLwPWBhpLPQ/QWqpznDXt2kw6P8zx/ey6hSCwuGdz1fWGHqZMIB/XaXOAmhxqFf3hBhrhnLbTQMY5WQpORRx/KRPX0HAmdfWAMUSFHlid6fiiTwAufx5ymgPW4gqnC9dlWj4BCwmMnV6OXtUjYP2N9oZ4kFpj4fWLkuS3JTyZoLUWlkyhpRR7cOKb2FKnGn4lsZbDIOLwKOto6RpsWqW+eXY/4XnBH5tFZeDuMIPVgqjR7tJ+v1Tn5ZEwSexoBS9VMLllqXDf3A7UFXX3jSbOYP6b61u9it7I6HMh+nVP1bXAptEfQtwXBLAaa5jCyxcOVsE1Ja92IP774uzykI3hcmq0i36Lzbd2rS7HWVC7Q0U/CYOa3n+zCG0leNc7T/e3F+5vcDzH1lw49iN5toHxgU3kNCArFgMj28SGQyY6Yc+u0PNuBbroWZROQi8LAR4JJUJGRzEYKRQJGuiwy9jfqmw41zkSHbTcQ1kKQjUwKWWqfXe263OPN0HUJaLtxUjDdC3Y7Sa3JtJaRwtq9b69LL1e68ntrar4lB6gyawBIEHYF4NwTwbt7YOu3tDweEVOrsHX0ervKhevd44ex8NoQwwRr5CaZsqg9j7njXHzTVDQoM+S4Qd+LvOvUjbfoMNcQmgZ4IKrTl29/qVTj8mlru0PfkK/mvkuUMpIRwrVviymWOXsv52knvWszmn1bqB+oaQevcUDHCdAsnBdnxw69bGbiD65NCeQHTRV29ej7X+5SVQdeMb9S1ToxWxAPsfJfwIEtI596cVXaccBASLjP/DK+BOYo0teSY6BFRRDiiLiihIuKDGD2ffG9W8K5kTohH+pxUPWTBP5vA7qMbBdbpw359T2OAkAy8uBdlDVU9zB3vR36kYRwJdlGTkWthPI1oOzXnsS5v5W7Yh02UQsX/Xd9JA3w=";
		//$xml = "<Cancelacion xmlns='http://cancelacfd.sat.gob.mx' xmlns:xsi='http://www.w3.org/2001/XMLSchema-instance' xmlns:xsd='http://www.w3.org/2001/XMLSchema'  Fecha='2021-12-26T18:15:28' RfcEmisor='EKU9003173C9' > <Folios> <Folio UUID='fe4e71b0-8959-4fb9-8091-f5ac4fb0fef8' Motivo='02' FolioSustitucion=''/> </Folios> <Signature xmlns='http://www.w3.org/2000/09/xmldsig#'><SignedInfo><CanonicalizationMethod Algorithm='http://www.w3.org/TR/2001/REC-xml-c14n-20010315' /><SignatureMethod Algorithm='http://www.w3.org/2000/09/xmldsig#rsa-sha1' /><Reference URI=''><Transforms><Transform Algorithm='http://www.w3.org/2000/09/xmldsig#enveloped-signature' /></Transforms><DigestMethod Algorithm='http://www.w3.org/2000/09/xmldsig#sha1' /><DigestValue>XEdUtCptjdlz9DsYAP7nnU6MytU=</DigestValue></Reference></SignedInfo><SignatureValue>ZnWh91e5tUc4/t1ZWnb3yOgB8zuCXNPioND+rv6aLOEwIw26/8sYYb+GT4wgyqlc09wOs32XTUwWoGQwtWMG8Euqq+4xJyobWvPCsX6CiURvD/Pd33xgkH92A0AGQxEMYGVT7wK+GFS2gDTYEYAXvZqzCe6+rXnlQvHML0TOOmhVu/wc8YrCbGt4z/F5sRxhjpa0eqwFEq4RmB4nkWjcD3Pnudn3XAI5NHIiOd8KVGVcDR+LvYvKj7h+18WxZgujpggYjbFN79i1jEsAEPDfgryUdTvjDw+KC7Mg+/ge6pssH42buEMIwVE4VX9Y3NtWSGTwdIK/8pxXk+Y5wyR6Gg==</SignatureValue><KeyInfo><X509Data><X509IssuerSerial><X509IssuerName>OID.1.2.840.113549.1.9.2=responsable: ACDMA-SAT, OID.2.5.4.45=2.5.4.45, L=COYOACAN, S=CIUDAD DE MEXICO, C=MX, PostalCode=06370, STREET=3ra cerrada de cadiz, E=oscar.martinez@sat.gob.mx, OU=SAT-IES Authority, O=SERVICIO DE ADMINISTRACION TRIBUTARIA, CN=AC UAT</X509IssuerName><X509SerialNumber>292233162870206001759766198444326234574038512436</X509SerialNumber></X509IssuerSerial><X509Certificate>MIIFuzCCA6OgAwIBAgIUMzAwMDEwMDAwMDA0MDAwMDI0MzQwDQYJKoZIhvcNAQELBQAwggErMQ8wDQYDVQQDDAZBQyBVQVQxLjAsBgNVBAoMJVNFUlZJQ0lPIERFIEFETUlOSVNUUkFDSU9OIFRSSUJVVEFSSUExGjAYBgNVBAsMEVNBVC1JRVMgQXV0aG9yaXR5MSgwJgYJKoZIhvcNAQkBFhlvc2Nhci5tYXJ0aW5lekBzYXQuZ29iLm14MR0wGwYDVQQJDBQzcmEgY2VycmFkYSBkZSBjYWRpejEOMAwGA1UEEQwFMDYzNzAxCzAJBgNVBAYTAk1YMRkwFwYDVQQIDBBDSVVEQUQgREUgTUVYSUNPMREwDwYDVQQHDAhDT1lPQUNBTjERMA8GA1UELRMIMi41LjQuNDUxJTAjBgkqhkiG9w0BCQITFnJlc3BvbnNhYmxlOiBBQ0RNQS1TQVQwHhcNMTkwNjE3MTk0NDE0WhcNMjMwNjE3MTk0NDE0WjCB4jEnMCUGA1UEAxMeRVNDVUVMQSBLRU1QRVIgVVJHQVRFIFNBIERFIENWMScwJQYDVQQpEx5FU0NVRUxBIEtFTVBFUiBVUkdBVEUgU0EgREUgQ1YxJzAlBgNVBAoTHkVTQ1VFTEEgS0VNUEVSIFVSR0FURSBTQSBERSBDVjElMCMGA1UELRMcRUtVOTAwMzE3M0M5IC8gWElRQjg5MTExNlFFNDEeMBwGA1UEBRMVIC8gWElRQjg5MTExNk1HUk1aUjA1MR4wHAYDVQQLExVFc2N1ZWxhIEtlbXBlciBVcmdhdGUwggEiMA0GCSqGSIb3DQEBAQUAA4IBDwAwggEKAoIBAQCN0peKpgfOL75iYRv1fqq+oVYsLPVUR/GibYmGKc9InHFy5lYF6OTYjnIIvmkOdRobbGlCUxORX/tLsl8Ya9gm6Yo7hHnODRBIDup3GISFzB/96R9K/MzYQOcscMIoBDARaycnLvy7FlMvO7/rlVnsSARxZRO8Kz8Zkksj2zpeYpjZIya/369+oGqQk1cTRkHo59JvJ4Tfbk/3iIyf4H/Ini9nBe9cYWo0MnKob7DDt/vsdi5tA8mMtA953LapNyCZIDCRQQlUGNgDqY9/8F5mUvVgkcczsIgGdvf9vMQPSf3jjCiKj7j6ucxl1+FwJWmbvgNmiaUR/0q4m2rm78lFAgMBAAGjHTAbMAwGA1UdEwEB/wQCMAAwCwYDVR0PBAQDAgbAMA0GCSqGSIb3DQEBCwUAA4ICAQBcpj1TjT4jiinIujIdAlFzE6kRwYJCnDG08zSp4kSnShjxADGEXH2chehKMV0FY7c4njA5eDGdA/G2OCTPvF5rpeCZP5Dw504RZkYDl2suRz+wa1sNBVpbnBJEK0fQcN3IftBwsgNFdFhUtCyw3lus1SSJbPxjLHS6FcZZ51YSeIfcNXOAuTqdimusaXq15GrSrCOkM6n2jfj2sMJYM2HXaXJ6rGTEgYmhYdwxWtil6RfZB+fGQ/H9I9WLnl4KTZUS6C9+NLHh4FPDhSk19fpS2S/56aqgFoGAkXAYt9Fy5ECaPcULIfJ1DEbsXKyRdCv3JY89+0MNkOdaDnsemS2o5Gl08zI4iYtt3L40gAZ60NPh31kVLnYNsmvfNxYyKp+AeJtDHyW9w7ftM0Hoi+BuRmcAQSKFV3pk8j51la+jrRBrAUv8blbRcQ5BiZUwJzHFEKIwTsRGoRyEx96sNnB03n6GTwjIGz92SmLdNl95r9rkvp+2m4S6q1lPuXaFg7DGBrXWC8iyqeWE2iobdwIIuXPTMVqQb12m1dAkJVRO5NdHnP/MpqOvOgLqoZBNHGyBg4Gqm4sCJHCxA1c8Elfa2RQTCk0tAzllL4vOnI1GHkGJn65xokGsaU4B4D36xh7eWrfj4/pgWHmtoDAYa8wzSwo2GVCZOs+mtEgOQB91/g==</X509Certificate> </X509Data> </KeyInfo> </Signature> </Cancelacion>";
		$params = array(
			"url" => "http://services.test.sw.com.mx/",
			"token" => "",
			"uuid" => $uuid,
			"password" => $password,
			"rfc" => $rfc,
			
			"cerB64" => $b64Cer,
			"keyB64" => $b64Key
		);
		try {
			$cancelationService = CancelationService::Set($params);
			$result = $cancelationService::CancelationByCSD();
			$this->assertEquals($resultSpect, $result->status);
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}
	public function testCancelationByCSD_null()
	{
		$resultSpect = "error";
		$rfc = "JUFA7608212V6";
		$uuid = "7596b277-7c5d-4bb0-826c-7b3951fb87eb";
		$password = "123456789";
		$motivo = "02";
		$b64Cer = "MIIFmjCCA4KgAwIBAgIUMzAwMDEwMDAwMDA0MDAwMDIzMzEwDQYJKoZIhvcNAQELBQAwggErMQ8wDQYDVQQDDAZBQyBVQVQxLjAsBgNVBAoMJVNFUlZJQ0lPIERFIEFETUlOSVNUUkFDSU9OIFRSSUJVVEFSSUExGjAYBgNVBAsMEVNBVC1JRVMgQXV0aG9yaXR5MSgwJgYJKoZIhvcNAQkBFhlvc2Nhci5tYXJ0aW5lekBzYXQuZ29iLm14MR0wGwYDVQQJDBQzcmEgY2VycmFkYSBkZSBjYWRpejEOMAwGA1UEEQwFMDYzNzAxCzAJBgNVBAYTAk1YMRkwFwYDVQQIDBBDSVVEQUQgREUgTUVYSUNPMREwDwYDVQQHDAhDT1lPQUNBTjERMA8GA1UELRMIMi41LjQuNDUxJTAjBgkqhkiG9w0BCQITFnJlc3BvbnNhYmxlOiBBQ0RNQS1TQVQwHhcNMTkwNTI5MTg0MjI1WhcNMjMwNTI5MTg0MjI1WjCBwTEhMB8GA1UEAxMYQURSSUFOQSBKVUFSRVogRkVSTkFOREVaMSEwHwYDVQQpExhBRFJJQU5BIEpVQVJFWiBGRVJOQU5ERVoxITAfBgNVBAoTGEFEUklBTkEgSlVBUkVaIEZFUk5BTkRFWjEWMBQGA1UELRMNSlVGQTc2MDgyMTJWNjEbMBkGA1UEBRMSSlVGQTc2MDgyMU1ER1JSRDA0MSEwHwYDVQQLExhBRFJJQU5BIEpVQVJFWiBGRVJOQU5ERVowggEiMA0GCSqGSIb3DQEBAQUAA4IBDwAwggEKAoIBAQCpXbIyGRpoZ5ZMYLRJBTrB7bbIclWRXINqUM24moy6phoaXNvMtg2+DIksnOoQqSsMhJ087rgBZ1AwCfb1AgEcQ1JeFY7Yk6w5a/b7QGPH9Tblc65OZVZw7xYrBwvFVAlnmvglEtCL8gQxDVlyVd/g3lWVaQohH+vmnQdZVjKSm5RI0NTBl5Na438CytOv+hufF54OSOXZEMFVXt6rBiKLmrEheKIDAMmFuIFxD0O8e2bNvK8Oo+xmC2hH5UXlq/L5jn0rmnEnYp6v5eXs5K1ToRFztah4kaFT6nNUC6H/K6qA1B3rRtGc0ueCP/dt+sBpZG9c5ra6JAPIcozQwayvAgMBAAGjHTAbMAwGA1UdEwEB/wQCMAAwCwYDVR0PBAQDAgbAMA0GCSqGSIb3DQEBCwUAA4ICAQBP+zRQgUwTdebjklxJJ9QydHZGTQ0N7Qs9PlTnCoiC5QRMO9lTOlySi7AUL4V6cLQ4JCt8LgHeWP7gy3fbtIyyAvitJ0cvWvrtr3/Zj+K/0VfHbaOJf+v9Cc64UqU9mKAdAlmd5kteEPDEcFY9noatWpqVJY1Pc7tsWg038MIq+OS1/vYyrhZPRiFMaHLRJsRTthUZHdWg5mlXC8O7pJSsCapToehb1m5lIdHuydYn6d9VuAOe9h4/RLVX9D2fH3hUVi0YMDyCarybDYO32MdZsTguHCnXpAxUj0ANk3KSirt22jLz2kX/mZJ+amaN/hin50Fs23Hl4RSguZnFbJPXCJfcRg0lidq8GGHu2JPQjB0h7M4tojEZYMxAb/0sQkTAcKy2hHvwUQisYjOEwY2NNyeC7veQqqyLPzPeldc2LVfX3aYvB5QWWEn88BZWJJ2FUVsxE4NQmi0IAc2cTRcJj4DLU/sGGW/eZqrutVo+uBL93apxFeAjFC01teVKLAAfqre13aMfWeIgjCnqksnpbAsKSnS8plQF2b10jl10otgEDXHdOl6octjb3zIWoFPBxHI6y0bQxnzsABuZQwgIxzlDDoNeQXcJjX+IyqWTOcjMZ9Kn+pb6JtCjK4mLKJTT3jnYZSSeJMr3AQx1nNV371rBImhTEi90uhDsUCuFbg==";
		$b64Key = "MIIFDjBABgkqhkiG9w0BBQ0wMzAbBgkqhkiG9w0BBQwwDgQIAgEAAoIBAQACAggAMBQGCCqGSIb3DQMHBAgwggS8AgEAMASCBMh4EHl7aNSCaMDA1VlRoXCZ5UUmqErAbucRFLOMmsAaFHvMnY9VMcnZvyAUjwxrGgBpn7Qfm6z/1I6/RcjEQpGl+uI/rSnvCwrO9G4y8MAJnCoA+O9LuLpFrMVXFT2AjBxz/KZH/XbMjL3Okvuv3os25Tw4ZRj+lj1XLy+DkTdv8FiJ5kXbDwwQGp25xQS7xNTHw8x+OMxdRM5Yrj4KuibY1wNW73nqnZUFczUEJa4Zk5W+m4iq11e2FQ3bsJ+y/wxgCEu5IdodmwbRSrXq4VbtTJO7ZCAxxzlRdMalqtTfx6p3yqAJGl+SgPfUy1Xi7EEZ/1loG1RSsJGT3LGifIBxQtXQ03/2tbokoDIXWP2Kf2+9M+FEAz1p7uvoMKqXHunPUNxJ5yd2XWzvBx6r6oXYfkBzQgtiHYjcgH5WtSUMJxp9xcs2SzfND9Lr6Cc1ihwhO889vI+RVsB6COYNSp8r8jr+cV/ncLVdz1Z1Kxfck3hvuLpkssFSHk6OQW++9YGntQrNpONLVxaubrMMGjadmLro89D3JF+RBnrjeYN7oog3mEgtdxos0oCh9Xxz9M7JiyPa3jYWWpppJzrfF/5qvKI10exMyds31W5TNHQ0ETwNaApYFs5SxxM88cx3OjTw42SwYFF6ydznToOt6Km7Hgd395pxzWpXE13697GEF1DgUILAw2BoYup/VBHIGjvAzfLwPWBhpLPQ/QWqpznDXt2kw6P8zx/ey6hSCwuGdz1fWGHqZMIB/XaXOAmhxqFf3hBhrhnLbTQMY5WQpORRx/KRPX0HAmdfWAMUSFHlid6fiiTwAufx5ymgPW4gqnC9dlWj4BCwmMnV6OXtUjYP2N9oZ4kFpj4fWLkuS3JTyZoLUWlkyhpRR7cOKb2FKnGn4lsZbDIOLwKOto6RpsWqW+eXY/4XnBH5tFZeDuMIPVgqjR7tJ+v1Tn5ZEwSexoBS9VMLllqXDf3A7UFXX3jSbOYP6b61u9it7I6HMh+nVP1bXAptEfQtwXBLAaa5jCyxcOVsE1Ja92IP774uzykI3hcmq0i36Lzbd2rS7HWVC7Q0U/CYOa3n+zCG0leNc7T/e3F+5vcDzH1lw49iN5toHxgU3kNCArFgMj28SGQyY6Yc+u0PNuBbroWZROQi8LAR4JJUJGRzEYKRQJGuiwy9jfqmw41zkSHbTcQ1kKQjUwKWWqfXe263OPN0HUJaLtxUjDdC3Y7Sa3JtJaRwtq9b69LL1e68ntrar4lB6gyawBIEHYF4NwTwbt7YOu3tDweEVOrsHX0ervKhevd44ex8NoQwwRr5CaZsqg9j7njXHzTVDQoM+S4Qd+LvOvUjbfoMNcQmgZ4IKrTl29/qVTj8mlru0PfkK/mvkuUMpIRwrVviymWOXsv52knvWszmn1bqB+oaQevcUDHCdAsnBdnxw69bGbiD65NCeQHTRV29ej7X+5SVQdeMb9S1ToxWxAPsfJfwIEtI596cVXaccBASLjP/DK+BOYo0teSY6BFRRDiiLiihIuKDGD2ffG9W8K5kTohH+pxUPWTBP5vA7qMbBdbpw359T2OAkAy8uBdlDVU9zB3vR36kYRwJdlGTkWthPI1oOzXnsS5v5W7Yh02UQsX/Xd9JA3w=";
		//$xml = "<Cancelacion xmlns='http://cancelacfd.sat.gob.mx' xmlns:xsi='http://www.w3.org/2001/XMLSchema-instance' xmlns:xsd='http://www.w3.org/2001/XMLSchema'  Fecha='2021-12-26T18:15:28' RfcEmisor='EKU9003173C9' > <Folios> <Folio UUID='fe4e71b0-8959-4fb9-8091-f5ac4fb0fef8' Motivo='02' FolioSustitucion=''/> </Folios> <Signature xmlns='http://www.w3.org/2000/09/xmldsig#'><SignedInfo><CanonicalizationMethod Algorithm='http://www.w3.org/TR/2001/REC-xml-c14n-20010315' /><SignatureMethod Algorithm='http://www.w3.org/2000/09/xmldsig#rsa-sha1' /><Reference URI=''><Transforms><Transform Algorithm='http://www.w3.org/2000/09/xmldsig#enveloped-signature' /></Transforms><DigestMethod Algorithm='http://www.w3.org/2000/09/xmldsig#sha1' /><DigestValue>XEdUtCptjdlz9DsYAP7nnU6MytU=</DigestValue></Reference></SignedInfo><SignatureValue>ZnWh91e5tUc4/t1ZWnb3yOgB8zuCXNPioND+rv6aLOEwIw26/8sYYb+GT4wgyqlc09wOs32XTUwWoGQwtWMG8Euqq+4xJyobWvPCsX6CiURvD/Pd33xgkH92A0AGQxEMYGVT7wK+GFS2gDTYEYAXvZqzCe6+rXnlQvHML0TOOmhVu/wc8YrCbGt4z/F5sRxhjpa0eqwFEq4RmB4nkWjcD3Pnudn3XAI5NHIiOd8KVGVcDR+LvYvKj7h+18WxZgujpggYjbFN79i1jEsAEPDfgryUdTvjDw+KC7Mg+/ge6pssH42buEMIwVE4VX9Y3NtWSGTwdIK/8pxXk+Y5wyR6Gg==</SignatureValue><KeyInfo><X509Data><X509IssuerSerial><X509IssuerName>OID.1.2.840.113549.1.9.2=responsable: ACDMA-SAT, OID.2.5.4.45=2.5.4.45, L=COYOACAN, S=CIUDAD DE MEXICO, C=MX, PostalCode=06370, STREET=3ra cerrada de cadiz, E=oscar.martinez@sat.gob.mx, OU=SAT-IES Authority, O=SERVICIO DE ADMINISTRACION TRIBUTARIA, CN=AC UAT</X509IssuerName><X509SerialNumber>292233162870206001759766198444326234574038512436</X509SerialNumber></X509IssuerSerial><X509Certificate>MIIFuzCCA6OgAwIBAgIUMzAwMDEwMDAwMDA0MDAwMDI0MzQwDQYJKoZIhvcNAQELBQAwggErMQ8wDQYDVQQDDAZBQyBVQVQxLjAsBgNVBAoMJVNFUlZJQ0lPIERFIEFETUlOSVNUUkFDSU9OIFRSSUJVVEFSSUExGjAYBgNVBAsMEVNBVC1JRVMgQXV0aG9yaXR5MSgwJgYJKoZIhvcNAQkBFhlvc2Nhci5tYXJ0aW5lekBzYXQuZ29iLm14MR0wGwYDVQQJDBQzcmEgY2VycmFkYSBkZSBjYWRpejEOMAwGA1UEEQwFMDYzNzAxCzAJBgNVBAYTAk1YMRkwFwYDVQQIDBBDSVVEQUQgREUgTUVYSUNPMREwDwYDVQQHDAhDT1lPQUNBTjERMA8GA1UELRMIMi41LjQuNDUxJTAjBgkqhkiG9w0BCQITFnJlc3BvbnNhYmxlOiBBQ0RNQS1TQVQwHhcNMTkwNjE3MTk0NDE0WhcNMjMwNjE3MTk0NDE0WjCB4jEnMCUGA1UEAxMeRVNDVUVMQSBLRU1QRVIgVVJHQVRFIFNBIERFIENWMScwJQYDVQQpEx5FU0NVRUxBIEtFTVBFUiBVUkdBVEUgU0EgREUgQ1YxJzAlBgNVBAoTHkVTQ1VFTEEgS0VNUEVSIFVSR0FURSBTQSBERSBDVjElMCMGA1UELRMcRUtVOTAwMzE3M0M5IC8gWElRQjg5MTExNlFFNDEeMBwGA1UEBRMVIC8gWElRQjg5MTExNk1HUk1aUjA1MR4wHAYDVQQLExVFc2N1ZWxhIEtlbXBlciBVcmdhdGUwggEiMA0GCSqGSIb3DQEBAQUAA4IBDwAwggEKAoIBAQCN0peKpgfOL75iYRv1fqq+oVYsLPVUR/GibYmGKc9InHFy5lYF6OTYjnIIvmkOdRobbGlCUxORX/tLsl8Ya9gm6Yo7hHnODRBIDup3GISFzB/96R9K/MzYQOcscMIoBDARaycnLvy7FlMvO7/rlVnsSARxZRO8Kz8Zkksj2zpeYpjZIya/369+oGqQk1cTRkHo59JvJ4Tfbk/3iIyf4H/Ini9nBe9cYWo0MnKob7DDt/vsdi5tA8mMtA953LapNyCZIDCRQQlUGNgDqY9/8F5mUvVgkcczsIgGdvf9vMQPSf3jjCiKj7j6ucxl1+FwJWmbvgNmiaUR/0q4m2rm78lFAgMBAAGjHTAbMAwGA1UdEwEB/wQCMAAwCwYDVR0PBAQDAgbAMA0GCSqGSIb3DQEBCwUAA4ICAQBcpj1TjT4jiinIujIdAlFzE6kRwYJCnDG08zSp4kSnShjxADGEXH2chehKMV0FY7c4njA5eDGdA/G2OCTPvF5rpeCZP5Dw504RZkYDl2suRz+wa1sNBVpbnBJEK0fQcN3IftBwsgNFdFhUtCyw3lus1SSJbPxjLHS6FcZZ51YSeIfcNXOAuTqdimusaXq15GrSrCOkM6n2jfj2sMJYM2HXaXJ6rGTEgYmhYdwxWtil6RfZB+fGQ/H9I9WLnl4KTZUS6C9+NLHh4FPDhSk19fpS2S/56aqgFoGAkXAYt9Fy5ECaPcULIfJ1DEbsXKyRdCv3JY89+0MNkOdaDnsemS2o5Gl08zI4iYtt3L40gAZ60NPh31kVLnYNsmvfNxYyKp+AeJtDHyW9w7ftM0Hoi+BuRmcAQSKFV3pk8j51la+jrRBrAUv8blbRcQ5BiZUwJzHFEKIwTsRGoRyEx96sNnB03n6GTwjIGz92SmLdNl95r9rkvp+2m4S6q1lPuXaFg7DGBrXWC8iyqeWE2iobdwIIuXPTMVqQb12m1dAkJVRO5NdHnP/MpqOvOgLqoZBNHGyBg4Gqm4sCJHCxA1c8Elfa2RQTCk0tAzllL4vOnI1GHkGJn65xokGsaU4B4D36xh7eWrfj4/pgWHmtoDAYa8wzSwo2GVCZOs+mtEgOQB91/g==</X509Certificate> </X509Data> </KeyInfo> </Signature> </Cancelacion>";
		$params = array(
			"url" => "http://services.test.sw.com.mx/",
			"token" => ""
		
		);
		try {
			$cancelationService = CancelationService::Set($params);
			$result = $cancelationService::CancelationByCSD();
			$this->assertEquals($resultSpect, $result->status);
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}
	/* -------------------------------------------------------Cancelación XML-------------------------------------------------------- */
	public function testCancelationByXML()
	{
		$xml = "";
		$resultSpect = "success";
		$params = array(
			"url" => "http://services.test.sw.com.mx/",
			"token" => ""
		);
		try {
			$cancelationService = CancelationService::Set($params);
			$result = $cancelationService::CancelationByXML($xml);
			$this->assertEquals($resultSpect, $result->status);
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}
	public function testCancelationByXML_null()
	{
		$xml = "<Cancelacion xmlns='http://cancelacfd.sat.gob.mx' xmlns:xsi='http://www.w3.org/2001/XMLSchema-instance' xmlns:xsd='http://www.w3.org/2001/XMLSchema'  Fecha='2021-12-26T18:15:28' RfcEmisor='EKU9003173C9' > <Folios> <Folio UUID='fe4e71b0-8959-4fb9-8091-f5ac4fb0fef8' Motivo='02' FolioSustitucion=''/> </Folios> <Signature xmlns='http://www.w3.org/2000/09/xmldsig#'><SignedInfo><CanonicalizationMethod Algorithm='http://www.w3.org/TR/2001/REC-xml-c14n-20010315' /><SignatureMethod Algorithm='http://www.w3.org/2000/09/xmldsig#rsa-sha1' /><Reference URI=''><Transforms><Transform Algorithm='http://www.w3.org/2000/09/xmldsig#enveloped-signature' /></Transforms><DigestMethod Algorithm='http://www.w3.org/2000/09/xmldsig#sha1' /><DigestValue>XEdUtCptjdlz9DsYAP7nnU6MytU=</DigestValue></Reference></SignedInfo><SignatureValue>ZnWh91e5tUc4/t1ZWnb3yOgB8zuCXNPioND+rv6aLOEwIw26/8sYYb+GT4wgyqlc09wOs32XTUwWoGQwtWMG8Euqq+4xJyobWvPCsX6CiURvD/Pd33xgkH92A0AGQxEMYGVT7wK+GFS2gDTYEYAXvZqzCe6+rXnlQvHML0TOOmhVu/wc8YrCbGt4z/F5sRxhjpa0eqwFEq4RmB4nkWjcD3Pnudn3XAI5NHIiOd8KVGVcDR+LvYvKj7h+18WxZgujpggYjbFN79i1jEsAEPDfgryUdTvjDw+KC7Mg+/ge6pssH42buEMIwVE4VX9Y3NtWSGTwdIK/8pxXk+Y5wyR6Gg==</SignatureValue><KeyInfo><X509Data><X509IssuerSerial><X509IssuerName>OID.1.2.840.113549.1.9.2=responsable: ACDMA-SAT, OID.2.5.4.45=2.5.4.45, L=COYOACAN, S=CIUDAD DE MEXICO, C=MX, PostalCode=06370, STREET=3ra cerrada de cadiz, E=oscar.martinez@sat.gob.mx, OU=SAT-IES Authority, O=SERVICIO DE ADMINISTRACION TRIBUTARIA, CN=AC UAT</X509IssuerName><X509SerialNumber>292233162870206001759766198444326234574038512436</X509SerialNumber></X509IssuerSerial><X509Certificate>MIIFuzCCA6OgAwIBAgIUMzAwMDEwMDAwMDA0MDAwMDI0MzQwDQYJKoZIhvcNAQELBQAwggErMQ8wDQYDVQQDDAZBQyBVQVQxLjAsBgNVBAoMJVNFUlZJQ0lPIERFIEFETUlOSVNUUkFDSU9OIFRSSUJVVEFSSUExGjAYBgNVBAsMEVNBVC1JRVMgQXV0aG9yaXR5MSgwJgYJKoZIhvcNAQkBFhlvc2Nhci5tYXJ0aW5lekBzYXQuZ29iLm14MR0wGwYDVQQJDBQzcmEgY2VycmFkYSBkZSBjYWRpejEOMAwGA1UEEQwFMDYzNzAxCzAJBgNVBAYTAk1YMRkwFwYDVQQIDBBDSVVEQUQgREUgTUVYSUNPMREwDwYDVQQHDAhDT1lPQUNBTjERMA8GA1UELRMIMi41LjQuNDUxJTAjBgkqhkiG9w0BCQITFnJlc3BvbnNhYmxlOiBBQ0RNQS1TQVQwHhcNMTkwNjE3MTk0NDE0WhcNMjMwNjE3MTk0NDE0WjCB4jEnMCUGA1UEAxMeRVNDVUVMQSBLRU1QRVIgVVJHQVRFIFNBIERFIENWMScwJQYDVQQpEx5FU0NVRUxBIEtFTVBFUiBVUkdBVEUgU0EgREUgQ1YxJzAlBgNVBAoTHkVTQ1VFTEEgS0VNUEVSIFVSR0FURSBTQSBERSBDVjElMCMGA1UELRMcRUtVOTAwMzE3M0M5IC8gWElRQjg5MTExNlFFNDEeMBwGA1UEBRMVIC8gWElRQjg5MTExNk1HUk1aUjA1MR4wHAYDVQQLExVFc2N1ZWxhIEtlbXBlciBVcmdhdGUwggEiMA0GCSqGSIb3DQEBAQUAA4IBDwAwggEKAoIBAQCN0peKpgfOL75iYRv1fqq+oVYsLPVUR/GibYmGKc9InHFy5lYF6OTYjnIIvmkOdRobbGlCUxORX/tLsl8Ya9gm6Yo7hHnODRBIDup3GISFzB/96R9K/MzYQOcscMIoBDARaycnLvy7FlMvO7/rlVnsSARxZRO8Kz8Zkksj2zpeYpjZIya/369+oGqQk1cTRkHo59JvJ4Tfbk/3iIyf4H/Ini9nBe9cYWo0MnKob7DDt/vsdi5tA8mMtA953LapNyCZIDCRQQlUGNgDqY9/8F5mUvVgkcczsIgGdvf9vMQPSf3jjCiKj7j6ucxl1+FwJWmbvgNmiaUR/0q4m2rm78lFAgMBAAGjHTAbMAwGA1UdEwEB/wQCMAAwCwYDVR0PBAQDAgbAMA0GCSqGSIb3DQEBCwUAA4ICAQBcpj1TjT4jiinIujIdAlFzE6kRwYJCnDG08zSp4kSnShjxADGEXH2chehKMV0FY7c4njA5eDGdA/G2OCTPvF5rpeCZP5Dw504RZkYDl2suRz+wa1sNBVpbnBJEK0fQcN3IftBwsgNFdFhUtCyw3lus1SSJbPxjLHS6FcZZ51YSeIfcNXOAuTqdimusaXq15GrSrCOkM6n2jfj2sMJYM2HXaXJ6rGTEgYmhYdwxWtil6RfZB+fGQ/H9I9WLnl4KTZUS6C9+NLHh4FPDhSk19fpS2S/56aqgFoGAkXAYt9Fy5ECaPcULIfJ1DEbsXKyRdCv3JY89+0MNkOdaDnsemS2o5Gl08zI4iYtt3L40gAZ60NPh31kVLnYNsmvfNxYyKp+AeJtDHyW9w7ftM0Hoi+BuRmcAQSKFV3pk8j51la+jrRBrAUv8blbRcQ5BiZUwJzHFEKIwTsRGoRyEx96sNnB03n6GTwjIGz92SmLdNl95r9rkvp+2m4S6q1lPuXaFg7DGBrXWC8iyqeWE2iobdwIIuXPTMVqQb12m1dAkJVRO5NdHnP/MpqOvOgLqoZBNHGyBg4Gqm4sCJHCxA1c8Elfa2RQTCk0tAzllL4vOnI1GHkGJn65xokGsaU4B4D36xh7eWrfj4/pgWHmtoDAYa8wzSwo2GVCZOs+mtEgOQB91/g==</X509Certificate> </X509Data> </KeyInfo> </Signature> </Cancelacion>";
		$resultSpect = "error";
		$params = array(
			"url" => "http://services.test.sw.com.mx/",
			"token" => ""
		);
		try {
			$cancelationService = CancelationService::Set($params);
			$result = $cancelationService::CancelationByXML($xml);
			$this->assertEquals($resultSpect, $result->status);
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}
	/* -------------------------------------------------------Cancelación PFX-------------------------------------------------------- */
	public function testCancelationByPfx()
	{
		$resultSpect = "success";
		$rfc = "EKU9003173C9";
		$password = "12345678a";
		$uuid = "fe4e71b0-8959-4fb9-8091-f5ac4fb0fef8";
		$motivo = "01";
		$foliosustitucion = "0e4c30b8-11d8-40d8-894d-ef8b32eb4bdf";
		$b64Pfx = "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";
		$url = "http://services.test.sw.com.mx/";
		$token = "";

		$params = array(
			"url" => $url,
			"token" => $token,
			"uuid" => $uuid,
			"password" => $password,
			"rfc" => $rfc,
			"motivo" => $motivo,
			"foliosustitucion" => $foliosustitucion,
			"pfxB64" => $b64Pfx,

		);

		try {

			$cancelationService = CancelationService::Set($params);
			$result = $cancelationService::CancelationByPFX();
			$this->assertEquals($resultSpect, $result->status);
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}
	public function testCancelationByPfx_null()
	{
		$resultSpect = "error";
		$rfc = "EKU9003173C9";
		$password = "12345678a";
		$uuid = "fe4e71b0-8959-4fb9-8091-f5ac4fb0fef8";
		$motivo = "01";
		$foliosustitucion = "0e4c30b8-11d8-40d8-894d-ef8b32eb4bdf";
		$b64Pfx = "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";
		$url = "http://services.test.sw.com.mx/";
		$token = "";

		$params = array(
			"url" => $url,
			"token" => $token

		);

		try {

			$cancelationService = CancelationService::Set($params);
			$result = $cancelationService::CancelationByPFX();
			$this->assertEquals($resultSpect, $result->status);
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}
	/* -------------------------------------------------------Cancelación UUID------------------------------------------------------- */
	public function testCancelationByUUID()
	{
		$resultSpect = "success";
		$rfc = "EKU9003173C9";
		$uuid = "fe4e71b0-8959-4fb9-8091-f5ac4fb0fef8";
		$motivo = "01";
		$foliosustitucion = "0e4c30b8-11d8-40d8-894d-ef8b32eb4bdf";
		$params = array(
			"url" => "http://services.test.sw.com.mx",
			"token" => "",
			"rfc" => $rfc,
			"uuid" => $uuid,
			"motivo" => $motivo,
			"foliosustitucion" => $foliosustitucion

		);

		try {
			$cancelationService = CancelationService::Set($params);
			$result = $cancelationService::CancelationByUUID();
			$this->assertEquals($resultSpect, $result->status);
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}
	public function testCancelationByUUID_null()
	{
		$resultSpect = "error";
		$rfc = "EKU9003173C9";
		$uuid = "fe4e71b0-8959-4fb9-8091-f5ac4fb0fef8";
		$motivo = "01";
		$foliosustitucion = "0e4c30b8-11d8-40d8-894d-ef8b32eb4bdf";
		$params = array(
			"url" => "http://services.test.sw.com.mx",
			"token" => "",
			"rfc" => $rfc,
			"uuid" => $uuid,
			"motivo" => $motivo,
			"foliosustitucion" => $foliosustitucion

		);

		try {
			$cancelationService = CancelationService::Set($params);
			$result = $cancelationService::CancelationByUUID();
			$this->assertEquals($resultSpect, $result->status);
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}
}
