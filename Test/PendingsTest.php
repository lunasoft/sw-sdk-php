<?php

namespace tests;
// include('../SWSDK.php');
use PHPUnit\Framework\TestCase;
use SWServices\Pendings\PendingsService as pendingsService;
use Exception;

final class PendingsTest extends TestCase
{
	/* -------------------------------------------------------Pendientes por cancelar-------------------------------------------------------- */
	public function testPendings()
	{
        $resultSpect = "success";
		$rfc = "EKU9003173C9";
		$token = getenv('SDKTEST_TOKEN');
		$params = array(
			"url" => "https://services.test.sw.com.mx",
			"token" => $token
		);
		try {
			$pendingsService = PendingsService::Set($params);
			$result = $pendingsService::PendientesPorCancelar($rfc);
			$this->assertEquals($resultSpect, $result->status);
			$this->assertNotEmpty($result->data);
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}

	public function testPendings_Error()
	{
        $resultSpect = "CA1101 - No existen peticiones para el RFC Receptor.";
		$codeSpect = "1101";
		$rfc = "EKU9003173C8";
		$token = getenv('SDKTEST_TOKEN');
		$params = array(
			"url" => "https://services.test.sw.com.mx",
			"token" => $token
		);
		try {
			$pendingsService = PendingsService::Set($params);
			$result = $pendingsService::PendientesPorCancelar($rfc);
			$this->assertEquals($resultSpect, $result->message);
			$this->assertEquals($codeSpect, $result->codStatus);
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}	
}