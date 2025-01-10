<?php

namespace tests;
// include('../SWSDK.php');
use PHPUnit\Framework\TestCase;
use SWServices\Relations\RelationsService as relationsService;
use Exception;

final class RelationsTest extends TestCase
{
	/* -------------------------------------------------------Relacionados UUID-------------------------------------------------------- */
	public function testRelationsByUUID()
	{
		$resultSpect = "success";
		$uuid = "cfc771b4-7d90-459e-ab06-afd2b3c59c10";
		$rfc = "EKU9003173C9";
		$token = getenv('SDKTEST_TOKEN');
		$params = array(
			"url" => "https://services.test.sw.com.mx",
			"token" => $token
		);
		try {
			$relationsService = RelationsService::Set($params);
			$result = $relationsService::ConsultarCFDIRelacionadosUUID($rfc, $uuid);
			$this->assertEquals($resultSpect, $result->status);
			$this->assertEmpty($result->data);
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}

	public function testRelationsByUUID_NoData()
	{
		$resultSpect = "CACFDI33 - Error no controlado";
		$uuid = "22061fa1-dd22-4e2a-9ec5-a80c08b6532a";
		$rfc = "EKU9003173C9";
		$token = getenv('SDKTEST_TOKEN');
		$params = array(
			"url" => "https://services.test.sw.com.mx",
			"token" => $token
		);
		try {
			$relationsService = RelationsService::Set($params);
			$result = $relationsService::ConsultarCFDIRelacionadosUUID($rfc, $uuid);
			$this->assertEquals($resultSpect, $result->message);
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}	
	/* -------------------------------------------------------Relacionados CSD-------------------------------------------------------- */
	public function testRelationsByCSD()
	{
		$resultSpect = "success";
		$uuid = "cfc771b4-7d90-459e-ab06-afd2b3c59c10";
		$rfc = "EKU9003173C9";
		$cerB64 = base64_encode(file_get_contents('Test\Resources\cert_pruebas\EKU9003173C9.cer'));
		$keyB64 = base64_encode(file_get_contents('Test\Resources\cert_pruebas\EKU9003173C9.key'));
		$password = "12345678a";
		$token = getenv('SDKTEST_TOKEN');
		$params = array(
			"url" => "https://services.test.sw.com.mx",
			"token" => $token
		);
		try {
			$relationsService = RelationsService::Set($params);
			$result = $relationsService::ConsultarCFDIRelacionadosCSD($uuid, $password, $rfc, $cerB64, $keyB64);
			$this->assertEquals($resultSpect, $result->status);
			$this->assertEmpty($result->data);
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}

	public function testRelationsByCSD_NoData()
	{
		$resultSpect = "CACFDI33 - Error no controlado";
		$uuid = "22061fa1-dd22-4e2a-9ec5-a80c08b6532a";
		$rfc = "EKU9003173C9";
		$cerB64 = base64_encode(file_get_contents('Test\Resources\cert_pruebas\EKU9003173C9.cer'));
		$keyB64 = base64_encode(file_get_contents('Test\Resources\cert_pruebas\EKU9003173C9.key'));
		$password = "12345678a";
		$token = getenv('SDKTEST_TOKEN');
		$params = array(
			"url" => "https://services.test.sw.com.mx",
			"token" => $token
		);
		try {
			$relationsService = RelationsService::Set($params);
			$result = $relationsService::ConsultarCFDIRelacionadosCSD($uuid, $password, $rfc, $cerB64, $keyB64);
			$this->assertEquals($resultSpect, $result->message);
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}
	/* -------------------------------------------------------Relacionados PFX-------------------------------------------------------- */
	public function testRelationsByPFX()
	{
		$resultSpect = "success";
		$uuid = "cfc771b4-7d90-459e-ab06-afd2b3c59c10";
		$rfc = "EKU9003173C9";
		$password = "12345678a";
		$pfxB64 = base64_encode(file_get_contents('Test\Resources\cert_pruebas\EKU9003173C9.pfx'));
		$token = getenv('SDKTEST_TOKEN');
		$params = array(
			"url" => "https://services.test.sw.com.mx",
			"token" => $token
		);
		try {
			$relationsService = RelationsService::Set($params);
			$result = $relationsService::ConsultarCFDIRelacionadosPFX($uuid, $password, $rfc, $pfxB64);
			$this->assertEquals($resultSpect, $result->status);
			$this->assertEmpty($result->data);
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}

	public function testRelationsByPFX_NoData()
	{
		$resultSpect = "CACFDI33 - Error no controlado";
		$uuid = "22061fa1-dd22-4e2a-9ec5-a80c08b6532a";
		$rfc = "EKU9003173C9";
		$password = "12345678a";
		$pfxB64 = base64_encode(file_get_contents('Test\Resources\cert_pruebas\EKU9003173C9.pfx'));
		$token = getenv('SDKTEST_TOKEN');
		$params = array(
			"url" => "https://services.test.sw.com.mx",
			"token" => $token
		);
		try {
			$relationsService = RelationsService::Set($params);
			$result = $relationsService::ConsultarCFDIRelacionadosPFX($uuid, $password, $rfc, $pfxB64);
			$this->assertEquals($resultSpect, $result->message);
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}
}