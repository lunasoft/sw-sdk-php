<?php

namespace tests;

use PHPUnit\Framework\TestCase;
use SWServices\Storage\StorageService as StorageService;
use Exception;

final class StorageTest extends TestCase
{
    public function testGetAllDataToken_Success()
    {
        $params = array(
            "url" => "https://services.test.sw.com.mx",
            "urlApi" => "https://api.test.sw.com.mx",
            "user" => getenv('SDKTEST_USER'),
            "password" => getenv('SDKTEST_PASSWORD')
        );
        try {
            $resend = StorageService::Set($params);
            $result = $resend::getXml("08b5ed92-9a4f-4423-b284-36324a8aee61");
            $resultSpect = "success";
            $this->assertEquals($resultSpect, $result::getStatus());
        } catch (\PHPUnit\Framework\AssertionFailedError $e) {
        	throw $e;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function testGetAllDataUser_Success()
    {
        $params = array(
            "url" => "https://services.test.sw.com.mx",
            "urlApi" => "https://api.test.sw.com.mx",
            "user" => getenv('SDKTEST_USER'),
            "password" => getenv('SDKTEST_PASSWORD')
        );
        try {
            $resend = StorageService::Set($params);
            $result = $resend::getXml("08b5ed92-9a4f-4423-b284-36324a8aee61");
            $resultSpect = "success";
            $this->assertEquals($resultSpect, $result::getStatus());
        } catch (\PHPUnit\Framework\AssertionFailedError $e) {
        	throw $e;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
    public function testGetXml_Success()
    {
        $params = array(
            "urlApi" => "https://api.test.sw.com.mx",
            "token" => getenv('SDKTEST_TOKEN')
        );
        try {
            $resend = StorageService::Set($params);
            $result = $resend::getXml("08b5ed92-9a4f-4423-b284-36324a8aee61");
            $resultSpect = "success";
            $this->assertNotEmpty($result::getXml(), "url xml vacío");
            $this->assertEquals($resultSpect, $result::getStatus());
        } catch (\PHPUnit\Framework\AssertionFailedError $e) {
        	throw $e;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
    public function testGetPdf_Success()
    {
        $params = array(
            "urlApi" => "https://api.test.sw.com.mx",
            "token" => getenv('SDKTEST_TOKEN')
        );
        try {
            $resend = StorageService::Set($params);
            $result = $resend::getXml("08b5ed92-9a4f-4423-b284-36324a8aee61");
            $resultSpect = "success";
            $this->assertNotEmpty($result::getPdf(), "UUID inválido o no pertenece a la cuenta.");
            $this->assertEquals($resultSpect, $result::getStatus());
        } catch (\PHPUnit\Framework\AssertionFailedError $e) {
        	throw $e;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
    public function testGetXmlCancelation_Success()
    {
        $params = array(
            "url" => "https://services.test.sw.com.mx",
            "urlApi" => "https://api.test.sw.com.mx",
            "user" => getenv('SDKTEST_USER'),
            "password" => getenv('SDKTEST_PASSWORD')
        );
        try {
            $resend = StorageService::Set($params);
            $result = $resend::getXml("a281e1b4-c050-4048-a503-64d3b5ff31b6");
            $resultSpect = "success";
            $this->assertNotEmpty($result::getUrlCancelacion(), "UUID inválido o no pertenece a la cuenta.");
            $this->assertEquals($resultSpect, $result::getStatus());
        } catch (\PHPUnit\Framework\AssertionFailedError $e) {
        	throw $e;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
    public function testGetAllDataToken_Error()
    {
        $params = array(
            "urlApi" => "https://api.test.sw.com.mx",
            "token" => 'token_invalido'
        );
        // StorageResponse descarta el status de error; comprobamos la respuesta del request real.
        $storage = new class($params) extends \SWServices\Storage\StorageRequest {
            public static function getErrorResponse($uuid)
            {
                return parent::postStorage($uuid);
            }
        };
        $result = $storage::getErrorResponse("4714f6f7-ccb4-4eb5-8ba6-3a523092e2b4");
        $this->assertNotEmpty($result);
        $this->assertSame('error', $result->status);
    }

    public function testGetAllDataUser_Error()
    {
        $params = array(
            "url" => "https://services.test.sw.com.mx",
            "urlApi" => "https://api.test.sw.com.mx",
            "user" => getenv('SDKTEST_USER'),
            "password" => "asasa"
        );
        try {
            $resend = StorageService::Set($params);
            $result = $resend::getXml("4714f6f7-ccb4-4eb5-8ba6-3a523092e2b4");
            $this->assertNotEmpty($result, "Authentication error: AU2000 - El usuario y/o contraseña son inválidos, no se puede autenticar el servicio.");
        } catch (\PHPUnit\Framework\AssertionFailedError $e) {
        	throw $e;
        } catch (Exception $e) {
            $this->expectException(\Exception::class);
            $this->expectExceptionMessageMatches('/AU2000/');
            $resend = StorageService::Set($params);
            $result = $resend::getXml("4714f6f7-ccb4-4eb5-8ba6-3a523092e2b4");
        }
    }
}
