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
		$token = getenv('SDKTEST_TOKEN');
		$params = array(
			"url" => "http://services.test.sw.com.mx/",
			"token" => $token,
		);
		try {
			$cancelationService = CancelationService::Set($params);
			$result = $cancelationService::CancelationByCSD($rfc, $uuid, $motivo, $cerB64, $keyB64, $password);
			$this->assertEquals($resultSpect, $result->status);
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}
	public function testCancelationByCSD_null()
	{
		$resultSpect = "error";
		$messageSpect = "CACFDI33 - Problemas con los campos.";
		$rfc = "EKU9003173C9";
		$uuid = "5643d565-3efb-4a29-98d1-dcf271503cb6";
		$keyB64 = base64_encode(file_get_contents('Test\Resources\cert_pruebas\EKU9003173C9.key'));
		$password = "12345678a";
		$motivo = "02";
		$token = getenv('SDKTEST_TOKEN');
		$params = array(
			"url" => "http://services.test.sw.com.mx/",
			"token" => $token
		);
		try {
			$cancelationService = CancelationService::Set($params);
			$result = $cancelationService::CancelationByCSD($rfc, $uuid, $motivo, null, $keyB64, $password);
			$this->assertEquals($resultSpect, $result->status);
			$this->assertEquals($messageSpect, $result->message);
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}
	/* -------------------------------------------------------Cancelación XML-------------------------------------------------------- */
	public function testCancelationByXML()
	{
		$resultSpect = "success";
		$xml = file_get_contents('Test\Resources\cancel_xml.xml');
		$token = getenv('SDKTEST_TOKEN');
		$params = array(
			"url" => "http://services.test.sw.com.mx/",
			"token" => $token
		);
		try {
			$cancelationService = CancelationService::Set($params);
			$result = $cancelationService::CancelationByXML($xml);
			$this->assertEquals($resultSpect, $result->status);
			$this->assertNotEmpty($result->data, "Acuse vacio");
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}
	public function testCancelationByXML_null()
	{
		$resultSpect = "error";
		$messageSpect = "CASD - Acuse sin descripción específica.";
		$token = getenv('SDKTEST_TOKEN');
		$params = array(
			"url" => "http://services.test.sw.com.mx/",
			"token" => $token
		);
		try {
			$cancelationService = CancelationService::Set($params);
			$result = $cancelationService::CancelationByXML(null);
			$this->assertEquals($resultSpect, $result->status);
			$this->assertEquals($messageSpect, $result->message);
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
		$token = getenv('SDKTEST_TOKEN');
		$params = array(
			"url" => "http://services.test.sw.com.mx/",
			"token" => $token
		);
		try {
			$cancelationService = CancelationService::Set($params);
			$result = $cancelationService::CancelationByPFX($rfc, $uuid, $motivo, $pfxB64, $passwordPfx);
			$this->assertEquals($resultSpect, $result->status);
			$this->assertNotEmpty($result->data,"Acuse vacio");
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}
	public function testCancelationByPfx_null()
	{
		$resultSpect = "error";
		$messageSpect = "CACFDI33 - Problemas con los campos.";
		$passwordPfx = "pass";
		$uuid = "cfc771b4-7d90-459e-ab06-afd2b3c59c10";
		$rfc = "EKU9003173C9";
		$motivo = "02";
		$token = getenv('SDKTEST_TOKEN');
		$params = array(
			"url" => "http://services.test.sw.com.mx/",
			"token" => $token
		);
		try {
			$cancelationService = CancelationService::Set($params);
			$result = $cancelationService::CancelationByPFX($rfc, $uuid, $motivo, null, $passwordPfx);
			$this->assertEquals($resultSpect, $result->status);
			$this->assertEquals($messageSpect, $result->message);
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
		$token = getenv('SDKTEST_TOKEN');
		$params = array(
			"url" => "http://services.test.sw.com.mx",
			"token" => $token
		);
		try {
			$cancelationService = CancelationService::Set($params);
			$result = $cancelationService::CancelationByUUID($rfc, $uuid, $motivo);
			$this->assertEquals($resultSpect, $result->status);
			$this->assertNotEmpty($result->data,"Acuse vacio");
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}
	public function testCancelationByUUID_null()
	{
		$resultSpect = "error";
		$messageSpect = "El UUID proporcionado es invalido. Favor de verificar.";
		$rfc = "EKU9003173C9";
		$motivo = "02";
		$token = getenv('SDKTEST_TOKEN');
		$params = array(
			"url" => "http://services.test.sw.com.mx",
			"token" => $token
		);
		try {
			$cancelationService = CancelationService::Set($params);
			$result = $cancelationService::CancelationByUUID($rfc, "null", $motivo);
			$this->assertEquals($resultSpect, $result->status);
			$this->assertEquals($messageSpect, $result->messageDetail);
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}
}