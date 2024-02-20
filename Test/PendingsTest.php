<?php

namespace tests;
// include('../SWSDK.php');
use PHPUnit\Framework\TestCase;
use SWServices\Pendings\PendingsService as pendingsService;
use Exception;

final class PendingsTests extends TestCase
{
	/* -------------------------------------------------------Pendientes por cancelar-------------------------------------------------------- */
	public function testPendings()
	{
        $resultSpect = "success";
		$rfc = "EKU9003173C9";
		$token = getenv('SDKTEST_TOKEN');
		$params = array(
			"url" => "http://services.test.sw.com.mx",
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

	public function testPendings_null()
	{
        $resultSpect = "error";
		$rfc = "";
		$token = getenv('SDKTEST_TOKEN');
		$params = array(
			"url" => "http://services.test.sw.com.mx",
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
}