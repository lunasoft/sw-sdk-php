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
                "token"=> "T2lYQ0t4L0RHVkR4dHZ5Nkk1VHNEakZ3Y0J4Nk9GODZuRyt4cE1wVm5tbXB3YVZxTHdOdHAwVXY2NTdJb1hkREtXTzE3dk9pMmdMdkFDR2xFWFVPUXpTUm9mTG1ySXdZbFNja3FRa0RlYURqbzdzdlI2UUx1WGJiKzViUWY2dnZGbFloUDJ6RjhFTGF4M1BySnJ4cHF0YjUvbmRyWWpjTkVLN3ppd3RxL0dJPQ.T2lYQ0t4L0RHVkR4dHZ5Nkk1VHNEakZ3Y0J4Nk9GODZuRyt4cE1wVm5tbFlVcU92YUJTZWlHU3pER1kySnlXRTF4alNUS0ZWcUlVS0NhelhqaXdnWTRncklVSWVvZlFZMWNyUjVxYUFxMWFxcStUL1IzdGpHRTJqdS9Zakw2UGRZbFlVYmJVSkxXa1NZNzN5VUlSUzlJaTYvbi9wczBSRnZGK1NUNUVoM1FNNXZJRUg1Qkx1dXJ1Z09EcHYyQnE4V1dnOHpkczFLdm5MZytxalNBeHdRbmFvb2VhTksrVzhyTTFXU09NbzZVeXMyQ2Q4VC9ncUlqWGZaMFhXSkdmcjJIWlB2Z2RmeFJGNzRkdXh2UHlvdnVhbGN6cGFsRWhSY3BOOWxPc0h4Z2ZJRjBjZEl5WEsvZW0vb0ZxZEJjUGtpRFlWYi9zRDZwZVJFRks0QUpRNkplZ2N4UzVEME40d2RhUHA4c1VUQWJiY1Jvc3NSVFcrRzVyTHNOTWovZlJHQmV6c0lmclE1TXV3aVY3UERtQUo3SjdpTzhuc1R1SGt1R0s0UHUvc3hEZWRtK3U0NExEYUdUVWIxL3NKRE1XY1RlTnNMaENoSFUvVGhaclk2WmNPR2JjUlpib1RPUTN5QUxiU0VEY0NpYmJDcDZHY3pGd0ZJMXcxTEExTnBPdzM.VZBKM8Odz5VdIyhQPZyRaJK1iVLmot-oMf0h69NU4vk"
            );
            $resend = ResendService::Set($params);
			$result = $resend::ResendEmail("506aecd4-fc5f-4581-a0e1-9b185967b212", "pruebas_ut@sw.com.mx");
            echo $result->data;
			$this->assertEquals("success", $result->status, "El status fue" . $result->status);
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
                "user"=>"pruebas_ut@sw.com.mx",
                "password"=> "\$Wpass12345"
            );
            $resend = ResendService::Set($params);
			$result = $resend::ResendEmail("506aecd4-fc5f-4581-a0e1-9b185967b212", "pruebas_ut@sw.com.mx");
            echo $result->data;
			$this->assertEquals("success", $result->status, "El status fue" . $result->status);
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
                "user"=>"pruebas_ut@sw.com.mx",
                "password"=> "\$Wpass12345"
            );
            $resend = ResendService::Set($params);
			$result = $resend::ResendEmail("506aecd4-fc5f-4581-a0e1-9b185967b212", "test@mail.com,test@mail.com,test@mail.com,test@mail.com,test@mail.com");
            echo $result->data;
			$this->assertEquals("success", $result->status, "El status fue" . $result->status);
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
                "user"=>"pruebas_ut@sw.com.mx",
                "password"=> "\$Wpass12345"
            );
            $resend = ResendService::Set($params);
			$result = $resend::ResendEmail("506aecd4-fc5f-4581-a0e1-9b185967b212", "test@mail.com,test@mail.com,test@mail.com,test@mail.com,test@mail.com,test@mail.com");
			$this->assertEquals("error", $result->status, "El status fue " . $result->status);
            $this->assertNotEmpty($result->message, "Message viene vacio.");
            $this->assertEquals("El UUID o los correos no son válidos.", $result->message);
            echo $result->message;
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
                "user"=>"pruebas_ut@sw.com.mx",
                "password"=> "\$Wpass12345"
            );
            $resend = ResendService::Set($params);
			$result = $resend::ResendEmail("006aeac1-fc5f-4581-a0e1-9b185967b212", "test@mail.com,test@mail.com,test@mail.com,test@mail.com,test@mail.com");
			$this->assertEquals("error", $result->status, "El status fue " . $result->status);
            $this->assertNotEmpty($result->message, "Message viene vacio.");
            $this->assertNotEmpty($result->messageDetail, "Message viene vacio.");
            echo $result->message;
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
                "user"=>"pruebas_ut@sw.com.mx",
                "password"=> "\$Wpass12345"
            );
            $resend = ResendService::Set($params);
			$result = $resend::ResendEmail(null, "test@mail.com,test@mail.com,test@mail.com,test@mail.com,test@mail.com");
			$this->assertEquals("error", $result->status, "El status fue " . $result->status);
            $this->assertNotEmpty($result->message, "Message viene vacio.");
            $this->assertEquals("El UUID o los correos no son válidos.", $result->message);
            echo $result->message;
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
                "user"=>"pruebas_ut@sw.com.mx",
                "password"=> "\$Wpass12345"
            );
            $resend = ResendService::Set($params);
			$result = $resend::ResendEmail("506aecd4-fc5f-4581-a0e1-9b185967b212", "correoInvalido,test@mail.com,test@mail.com");
			$this->assertEquals("error", $result->status, "El status fue " . $result->status);
            $this->assertNotEmpty($result->message, "Message viene vacio.");
            $this->assertEquals("El UUID o los correos no son válidos.", $result->message);
            echo $result->message;
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
                "user"=>"pruebas_ut@sw.com.mx",
                "password"=> "\$Wpass12345"
            );
            $resend = ResendService::Set($params);
			$result = $resend::ResendEmail("506aecd4-fc5f-4581-a0e1-9b185967b212", null);
			$this->assertEquals("error", $result->status, "El status fue " . $result->status);
            $this->assertNotEmpty($result->message, "Message viene vacio.");
            $this->assertEquals("El UUID o los correos no son válidos.", $result->message);
            echo $result->message;
		} catch (Exception $e) {
			echo $e->getMessage();
		}
    }
}
?>