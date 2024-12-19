<?php

namespace tests;

use PHPUnit\Framework\TestCase;
use SWServices\Validation\ValidateXMLService as ValidateXMLService;
use Exception;

final class ValidateXMLTest extends TestCase
{
    public function testValidate_Auth()
    {
        $resultSpect = "success";
        $params = array(
            "url" => "https://services.test.sw.com.mx",
            "user" => getenv('SDKTEST_USER'),
            "password" => getenv('SDKTEST_PASSWORD')
        );

        $xml = file_get_contents('Test\Resources\cfdi40_sellado.xml');
        $validateStatus = false;
        $validateXml = ValidateXMLService::Set($params);
        $result = $validateXml::ValidaXML($xml, $validateStatus);
        $this->assertEquals($resultSpect, $result->status);
        $this->assertNotEmpty($result->detail);
    }

    public function testValidate_Token()
    {
        $resultSpect = "success";
        $params = array(
            "url" => "https://services.test.sw.com.mx",
            "token" => getenv('SDKTEST_TOKEN')
        );

        $xml = file_get_contents('Test\Resources\cfdi40_sellado.xml');
        $validateStatus =  false;
        $validateXml = ValidateXMLService::Set($params);
        $result = $validateXml::ValidaXML($xml, $validateStatus);
        $this->assertEquals($resultSpect, $result->status);
        $this->assertNotEmpty($result->detail);
    }
}
