<?php

namespace tests;

use PHPUnit\Framework\TestCase;
use SWServices\CancelationRetention\CancelationRetentionService as CancelRetentionService;
use Exception;

final class CancelationRetentionTests extends TestCase
{
    private $xmlCancel;

    protected function setUp(): void
    {
        $paramsath = 'Test/Resources/cancel_retention_xml.xml';
        $this->xmlCancel = is_file($paramsath) ? file_get_contents($paramsath) : '';
    }

    private function paramsCSD(): array
    {
        $cerB64 = base64_encode(file_get_contents('Test/Resources/cert_pruebas/EKU9003173C9.cer'));
        $keyB64 = base64_encode(file_get_contents('Test/Resources/cert_pruebas/EKU9003173C9.key'));
        return [
            "rfc"      => "EKU9003173C9",
            "uuid"     => "1fae5735-ca51-4be4-9180-827c44fdb227",
            "motivo"   => "01",
            "b64Cer"   => $cerB64,
            "b64Key"   => $keyB64,
            "password" => "12345678a"
        ];
    }

    private function paramsPFX(): array
    {
        $paramsfxB64 = base64_encode(file_get_contents('Test/Resources/cert_pruebas/EKU9003173C9.pfx'));
        return [
            "rfc"              => "EKU9003173C9",
            "uuid"             => "578052ce-710f-4d0b-9ffc-6ca73daf92a5",
            "motivo"           => "02",
            "b64Pfx"           => $paramsfxB64,
            "password"         => "12345678a"
        ];
    }

    private function paramsAuth(): array
    {
        return [
            "url"      => "https://services.test.sw.com.mx",
            "user"     => getenv('SDKTEST_USER'),
            "password" => getenv('SDKTEST_PASSWORD')
        ];
    }

    private function paramsToken(): array
    {
        return [
            "url"   => "https://services.test.sw.com.mx",
            "token" => getenv('SDKTEST_TOKEN')
        ];
    }

    /* ================== XML ================== */

    public function testCancelationRetentionByXML_Auth()
    {
        try {
            $service = CancelRetentionService::Set($this->paramsAuth());
            $response = $service::CancelationByXML($this->xmlCancel);
            $this->assertEquals('success', $response->status);
            $this->assertNotEmpty($response->data);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function testCancelationRetentionByXML_Token()
    {
        try {
            $service = CancelRetentionService::Set($this->paramsToken());
            $response = $service::CancelationByXML($this->xmlCancel);
            $this->assertEquals('success', $response->status);
            $this->assertNotEmpty($response->data);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function testCancelationRetentionByXML_Error()
    {
        try {
            $service = CancelRetentionService::Set($this->paramsToken());
            $response = $service::CancelationByXML('<Cancelacion/>');
            $this->assertEquals('error', $response->status);
            $this->assertEquals('CASD - Acuse sin descripción específica.', $response->message);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    /* ================== CSD ================== */

    public function testCancelationRetentionByCSD_Auth()
    {
        try {
            $service = CancelRetentionService::Set($this->paramsAuth());
            $params   = $this->paramsCSD();
            $response = $service::CancelationByCSD($params['rfc'], $params['uuid'], $params['motivo'], $params['b64Cer'], $params['b64Key'], $params['password']);
            $this->assertEquals('success', $response->status);
            $this->assertNotEmpty($response->data);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function testCancelationRetentionByCSD_Token()
    {
        try {
            $service = CancelRetentionService::Set($this->paramsToken());
            $params   = $this->paramsCSD();
            $response = $service::CancelationByCSD($params['rfc'], $params['uuid'], $params['motivo'], $params['b64Cer'], $params['b64Key'], $params['password']);
            $this->assertEquals('success', $response->status);
            $this->assertNotEmpty($response->data);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function testCancelationRetentionByCSD_Error()
    {
        try {
            $service = CancelRetentionService::Set($this->paramsToken());
            $params   = $this->paramsCSD();
            $response = $service::CancelationByCSD($params['rfc'], "000000000000", $params['motivo'], $params['b64Cer'], $params['b64Key'], $params['password']);
            $this->assertEquals('error', $response->status);
            $this->assertEquals('CACFDI33 - Problemas con el xml.', $response->message);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    /* ================== PFX ================== */

    public function testCancelationRetentionByPFX_Auth()
    {
        try {
            $service = CancelRetentionService::Set($this->paramsAuth());
            $params   = $this->paramsPFX();
            $response = $service::CancelationByPFX($params['rfc'], $params['uuid'], $params['motivo'], $params['b64Pfx'], $params['password']);
            $this->assertEquals('success', $response->status);
            $this->assertNotEmpty($response->data);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function testCancelationRetentionByPFX_Token()
    {
        try {
            $service = CancelRetentionService::Set($this->paramsToken());
            $params   = $this->paramsPFX();
            $response = $service::CancelationByPFX($params['rfc'], $params['uuid'], $params['motivo'], $params['b64Pfx'], $params['password']);
            $this->assertEquals('success', $response->status);
            $this->assertNotEmpty($response->data);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function testCancelationRetentionByPFX_Error()
    {
        try {
            $service = CancelRetentionService::Set($this->paramsToken());
            $params   = $this->paramsPFX();
            $response = $service::CancelationByPFX($params['rfc'], "00000000-0000-0000-0000-000000000000", $params['motivo'], "AAA", $params['password']);
            $this->assertEquals('error', $response->status);
            $this->assertEquals('CACFDI33 - Problemas con los campos.', $response->message);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}
