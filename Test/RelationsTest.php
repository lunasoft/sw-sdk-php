<?php

namespace tests;
// include('../SWSDK.php');
use PHPUnit\Framework\TestCase;
use SWServices\Relations\RelationsService as relationsService;
use Exception;

final class RelationsTests extends TestCase
{
	/* -------------------------------------------------------Relacionados UUID-------------------------------------------------------- */
	public function testRelationsByUUID()
	{
		$resultSpect = "success";
		$uuid = "cfc771b4-7d90-459e-ab06-afd2b3c59c10";
		$rfc = "EKU9003173C9";
		$token = getenv('SDKTEST_TOKEN');
		$params = array(
			"url" => "http://services.test.sw.com.mx",
			"token" => $token
		);
		try {
			$relationsService = RelationsService::Set($params);
			$result = $relationsService::ConsultarCFDIRelacionadosUUID($rfc, $uuid);
			$this->assertEquals($resultSpect, $result->status);
			$this->assertNotEmpty($result->data);
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}

	public function testRelationsByUUID_null()
	{
		$resultSpect = "error";
		$uuid = "";
		$rfc = "EKU9003173C9";
		$token = getenv('SDKTEST_TOKEN');
		$params = array(
			"url" => "http://services.test.sw.com.mx",
			"token" => $token
		);
		try {
			$relationsService = RelationsService::Set($params);
			$result = $relationsService::ConsultarCFDIRelacionadosUUID($rfc, $uuid);
			$this->assertEquals($resultSpect, $result->status);
			$this->assertNotEmpty($result->data);
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
		$service = "/relations/csd";
		$params = array(
			"url" => "http://services.test.sw.com.mx",
			"token" => $token
		);
		try {
			$relationsService = RelationsService::Set($params);
			$result = $relationsService::ConsultarCFDIRelacionadosCSD($service, $token, $uuid, $password, $rfc, $cerB64, $keyB64);
			$this->assertEquals($resultSpect, $result->status);
			$this->assertNotEmpty($result->data);
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}

	public function testRelationsByCSD_null()
	{
		$resultSpect = "error";
		$uuid = "cfc771b4-7d90-459e-ab06-afd2b3c59c10";
		$rfc = "EKU9003173C9";
		$cerB64 = base64_encode(file_get_contents(''));
		$keyB64 = base64_encode(file_get_contents(''));
		$password = "12345678a";
		$token = getenv('SDKTEST_TOKEN');
		$service = "/relations/csd";
		$params = array(
			"url" => "http://services.test.sw.com.mx",
			"token" => $token
		);
		try {
			$relationsService = RelationsService::Set($params);
			$result = $relationsService::ConsultarCFDIRelacionadosCSD($service, $token, $uuid, $password, $rfc, "cerNull", $keyB64);
			$this->assertEquals($resultSpect, $result->status);
			$this->assertNotEmpty($result->data);
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
		$service = "/relations/pfx";
		$params = array(
			"url" => "http://services.test.sw.com.mx",
			"token" => $token
		);
		try {
			$relationsService = RelationsService::Set($params);
			$result = $relationsService::ConsultarCFDIRelacionadosPFX($service, $token, $uuid, $password, $rfc, $pfxB64);
			$this->assertEquals($resultSpect, $result->status);
			$this->assertNotEmpty($result->data);
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}

	public function testRelationsByPFX_null()
	{
		$resultSpect = "error";
		$uuid = "cfc771b4-7d90-459e-ab06-afd2b3c59c10";
		$rfc = "EKU9003173C9";
		$password = "12345678a";
		$token = getenv('SDKTEST_TOKEN');
		$service = "/relations/pfx";
		$params = array(
			"url" => "http://services.test.sw.com.mx",
			"token" => $token
		);
		try {
			$relationsService = RelationsService::Set($params);
			$result = $relationsService::ConsultarCFDIRelacionadosPFX($service, $token, $uuid, $password, $rfc, "pfxNull");
			$this->assertEquals($resultSpect, $result->status);
			$this->assertNotEmpty($result->data);
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}
}