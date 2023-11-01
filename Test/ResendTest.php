<?php
namespace tests;

use PHPUnit\Framework\TestCase;
use SWServices\Resend\ResendService as ResendService;
use Exception;

final class ResendTest extends TestCase
{
    public function testResend_Success()
	{
        try {
            $params = array(
                "urlApi" => "https://api.test.sw.com.mx",
                "token"=> getenv('SDKTEST_TOKEN')
            );
            $emails = array(
                "pruebas_ut@sw.com.mx"
            );
            $resend = ResendService::Set($params);
			$result = $resend::ResendEmail("5643d565-3efb-4a29-98d1-dcf271503cb6", $emails);
			$this->assertEquals("success", $result->status, "El status fue " . $result->status);
            $this->assertNotEmpty($result->message, "Message viene vacio.");
            $this->assertNotEmpty($result->messageDetail, "MessageDetail viene vacio.");
            $this->assertNotEmpty($result->data, "Data viene vacio.");
		} catch (Exception $e) {
			echo $e->getMessage();
		}
    }

	public function testResend_Auth_Success()
	{
        try {
            $params = array(
                "urlApi" => "https://api.test.sw.com.mx",
                "url" => "https://services.test.sw.com.mx",
                "user"=> getenv('SDKTEST_USER'),
                "password"=> getenv('SDKTEST_PASSWORD')
            );
            $emails = array(
                "pruebas_ut@sw.com.mx"
            );
            $resend = ResendService::Set($params);
			$result = $resend::ResendEmail("5643d565-3efb-4a29-98d1-dcf271503cb6", $emails);
			$this->assertEquals("success", $result->status, "El status fue " . $result->status);
            $this->assertNotEmpty($result->message, "Message viene vacio.");
            $this->assertNotEmpty($result->messageDetail, "MessageDetail viene vacio.");
            $this->assertNotEmpty($result->data, "Data viene vacio.");
		} catch (Exception $e) {
			echo $e->getMessage();
		}
    }
    public function testResend_EmailArray_Success()
	{
        try {
            $params = array(
                "urlApi" => "https://api.test.sw.com.mx",
                "url" => "https://services.test.sw.com.mx",
                "user"=> getenv('SDKTEST_USER'),
                "password"=> getenv('SDKTEST_PASSWORD')
            );
            $emails = array(
                "test@mail.com",
                "test@mail.com",
                "test@mail.com",
                "test@mail.com",
                "test@mail.com"
            );
            $resend = ResendService::Set($params);
			$result = $resend::ResendEmail("5643d565-3efb-4a29-98d1-dcf271503cb6", $emails);
			$this->assertEquals("success", $result->status, "El status fue " . $result->status);
            $this->assertNotEmpty($result->message, "Message viene vacio.");
            $this->assertNotEmpty($result->messageDetail, "MessageDetail viene vacio.");
            $this->assertNotEmpty($result->data, "Data viene vacio.");
		} catch (Exception $e) {
			echo $e->getMessage();
		}
    }
    public function testResend_EmailArray_Error()
	{
        try {
            $params = array(
                "urlApi" => "https://api.test.sw.com.mx",
                "url" => "https://services.test.sw.com.mx",
                "user"=> getenv('SDKTEST_USER'),
                "password"=> getenv('SDKTEST_PASSWORD')
            );
            $emails = array(
                "test@mail.com",
                "test@mail.com",
                "test@mail.com",
                "test@mail.com",
                "test@mail.com",
                "test@mail.com"
            );
            $resend = ResendService::Set($params);
			$result = $resend::ResendEmail("506aecd4-fc5f-4581-a0e1-9b185967b212", $emails);
			$this->assertEquals("error", $result->status, "El status fue " . $result->status);
            $this->assertNotEmpty($result->message, "Message viene vacio.");
            $this->assertEquals("El UUID o los correos no son válidos.", $result->message);
		} catch (Exception $e) {
			echo $e->getMessage();
		}
    }
    public function testResend_UUIDNotFound_Error()
	{
        try {
            $params = array(
                "urlApi" => "https://api.test.sw.com.mx",
                "url" => "https://services.test.sw.com.mx",
                "user"=> getenv('SDKTEST_USER'),
                "password"=> getenv('SDKTEST_PASSWORD')
            );
            $emails = array(
                "pruebas_ut@sw.com.mx"
            );
            $resend = ResendService::Set($params);
			$result = $resend::ResendEmail("00000000-fc5f-4581-a0e1-9b185967b212", $emails);
			$this->assertEquals("error", $result->status, "El status fue " . $result->status);
            $this->assertNotEmpty($result->message, "Message viene vacio.");
            $this->assertNotEmpty($result->messageDetail, "Message viene vacio.");
		} catch (Exception $e) {
			echo $e->getMessage();
		}
    }
    public function testResend_UUIDInvalid_Error()
	{
        try {
            $params = array(
                "urlApi" => "https://api.test.sw.com.mx",
                "url" => "https://services.test.sw.com.mx",
                "user"=> getenv('SDKTEST_USER'),
                "password"=> getenv('SDKTEST_PASSWORD')
            );
            $emails = array(
                "pruebas_ut@sw.com.mx"
            );
            $resend = ResendService::Set($params);
			$result = $resend::ResendEmail(null, $emails);
			$this->assertEquals("error", $result->status, "El status fue " . $result->status);
            $this->assertNotEmpty($result->message, "Message viene vacio.");
            $this->assertEquals("El UUID o los correos no son válidos.", $result->message);
		} catch (Exception $e) {
			echo $e->getMessage();
		}
    }
    public function testResend_EmailInvalid_Error()
	{
        try {
            $params = array(
                "urlApi" => "https://api.test.sw.com.mx",
                "url" => "https://services.test.sw.com.mx",
                "user"=> getenv('SDKTEST_USER'),
                "password"=> getenv('SDKTEST_PASSWORD')
            );
            $emails = array(
                "pruebas_ut@sw.com.mx",
                "correoInvalido"
            );
            $resend = ResendService::Set($params);
			$result = $resend::ResendEmail("506aecd4-fc5f-4581-a0e1-9b185967b212", $emails);
			$this->assertEquals("error", $result->status, "El status fue " . $result->status);
            $this->assertNotEmpty($result->message, "Message viene vacio.");
            $this->assertEquals("El UUID o los correos no son válidos.", $result->message);
		} catch (Exception $e) {
			echo $e->getMessage();
		}
    }
    public function testResend_EmailNull_Error()
	{
        try {
            $params = array(
                "urlApi" => "https://api.test.sw.com.mx",
                "url" => "https://services.test.sw.com.mx",
                "user"=> getenv('SDKTEST_USER'),
                "password"=> getenv('SDKTEST_PASSWORD')
            );
            $resend = ResendService::Set($params);
			$result = $resend::ResendEmail("506aecd4-fc5f-4581-a0e1-9b185967b212", null);
			$this->assertEquals("error", $result->status, "El status fue " . $result->status);
            $this->assertNotEmpty($result->message, "Message viene vacio.");
            $this->assertEquals("El UUID o los correos no son válidos.", $result->message);
		} catch (Exception $e) {
			echo $e->getMessage();
		}
    }
}
?>