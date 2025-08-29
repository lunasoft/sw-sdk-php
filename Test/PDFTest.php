<?php

namespace tests;

use PHPUnit\Framework\TestCase;
use SWServices\PDF\PdfService as PdfService;
use Exception;

final class PDFTest extends TestCase
{
    public function testPDF_Success()
    {
        $xml = file_get_contents('Test\Resources\file_pdf.xml');
        $logo = "";
        $templateId = "cfdi40";
        $params = array(
            "urlApi" => "https://api.test.sw.com.mx",
            "url" => "https://services.test.sw.com.mx",
            "user" => getenv('SDKTEST_USER'),
            "password" => getenv('SDKTEST_PASSWORD')
        );
        try {
            $pdfService = PdfService::Set($params);
            $result = $pdfService::GeneratePDF($xml, $logo, $templateId, null, false);
            $resultSpect = "success";
            $this->assertEquals($resultSpect, $result->status);
            $this->assertNotEmpty($result->data, "Data vacio");
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
    public function testPDF_ExtraSuccess()
    {
        $xml = file_get_contents('Test\Resources\file_pdf.xml');
        $logo = "";
        $extras = array("EDIRECCION1" => "Datos adicionales");
        $templateId = "extradata";
        $params = array(
            "urlApi" => "https://api.test.sw.com.mx",
            "url" => "https://services.test.sw.com.mx",
            "user" => getenv('SDKTEST_USER'),
            "password" => getenv('SDKTEST_PASSWORD')
        );
        try {
            $pdfService = pdfService::Set($params);
            $result = $pdfService::GeneratePDF($xml, $logo, $templateId, $extras, false);
            $resultSpect = "success";
            $this->assertEquals($resultSpect, $result->status);
            $this->assertNotEmpty($result->data, "Data vacio");
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
    public function testPDF_isB64true()
    {
        $xmlb64 = file_get_contents('Test\Resources\xml_b64.txt');
        $logo = "";
        $templateId = "cfdi40";
        $params = array(
            "urlApi" => "https://api.test.sw.com.mx",
            "url" => "https://services.test.sw.com.mx",
            "user" => getenv('SDKTEST_USER'),
            "password" => getenv('SDKTEST_PASSWORD')
        );
        try {
            $pdfService = pdfService::Set($params);
            $result = $pdfService::GeneratePDF($xmlb64, $logo, $templateId, null, true);
            $resultSpect = "success";
            $this->assertEquals($resultSpect, $result->status);
            $this->assertNotEmpty($result->data, "Data vacio");
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
    public function testPDF_UrlNull()
    {
        $xml = file_get_contents('Test\Resources\file_pdf.xml');
        $logo = "";
        $templateId = "extradata";
        $extras = array("EDIRECCION1" => "Datos adicionales");
        $params = array(
            "urlApi" => "",
            "url" => "https://services.test.sw.com.mx",
            "user" => getenv('SDKTEST_USER'),
            "password" => getenv('SDKTEST_PASSWORD')
        );
        try {
            $pdfService = pdfService::Set($params);
            $result = $pdfService::GeneratePDF($xml, $logo, $templateId, $extras, false);
            $this->assertEquals($result, NULL);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
    public function testPDF_XmlNull()
    {
        $xml = "xml";
        $logo = "";
        $templateId = "cfdi40";
        $params = array(
            "urlApi" => "https://api.test.sw.com.mx",
            "url" => "https://services.test.sw.com.mx",
            "user" => getenv('SDKTEST_USER'),
            "password" => getenv('SDKTEST_PASSWORD')
        );
        try {
            $pdfService = pdfService::Set($params);
            $result = $pdfService::GeneratePDF($xml, $logo, $templateId, null, true);
            $this->assertIsObject($result);
            $this->assertTrue(property_exists($result, 'error'));
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    /*-----------------------------Pruebas para Regenerate Service----------------------------------------*/
    public function testRegeneratePdf_TokenSuccess()
    {
        $uuid = "e560ab08-f093-4e5e-a59d-4e5e6d24d06b";
        $params = array(
            "urlApi" => "https://api.test.sw.com.mx",
            "url" => "https://services.test.sw.com.mx",
            "token" => getenv('SDKTEST_TOKEN'),
        );
        try {
            $pdfService = pdfService::Set($params);
            $result = $pdfService::RegeneratePDF($uuid);
            $resultSpect = "Solicitud se proceso correctamente.";
            $this->assertEquals($resultSpect, $result->message);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
    public function testRegeneratePdf_AuthSuccess()
    {
        $uuid = "e560ab08-f093-4e5e-a59d-4e5e6d24d06b";
        $params = array(
            "urlApi" => "https://api.test.sw.com.mx",
            "url" => "https://services.test.sw.com.mx",
            "token" => getenv('SDKTEST_TOKEN'),
        );
        try {
            $pdfService = pdfService::Set($params);
            $result = $pdfService::RegeneratePDF($uuid);
            $resultSpect = "Solicitud se proceso correctamente.";
            $this->assertEquals($resultSpect, $result->message);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
    public function testRegeneratePdfExtra_Success()
    {
        $extras =  array(
            "extras" => array(
                "EDIRECCION1" => "STERNO PRODUCTS 2483 Harbor Avenue Memphis, TN 38113"
            ),
            "templateId" => "extradata"
        );
        $uuid = "e560ab08-f093-4e5e-a59d-4e5e6d24d06b";
        $params = array(
            "urlApi" => "https://api.test.sw.com.mx",
            "url" => "https://services.test.sw.com.mx",
            "user" => getenv('SDKTEST_USER'),
            "password" => getenv('SDKTEST_PASSWORD')
        );
        try {
            $pdfService = pdfService::Set($params);
            $result = $pdfService::RegeneratePDF($uuid, $extras);
            $resultSpect = "Solicitud se proceso correctamente.";
            $this->assertEquals($resultSpect, $result->message);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
    public function testRegenerate_Error()
    {
        $uuid = "cddad1da-0141-438a-ba94-d3036a8ee82d";
        $params = array(
            "urlApi" => "https://api.test.sw.com.mx",
            "url" => "https://services.test.sw.com.mx",
            "user" => getenv('SDKTEST_USER'),
            "password" => getenv('SDKTEST_PASSWORD')
        );
        try {
            $pdfService = pdfService::Set($params);
            $result = $pdfService::RegeneratePDF($uuid);
            $this->assertEquals("No se encontro el UUID.", $result->message);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
    public function testRegenerate_UuidNull()
    {
        $uuid = null;
        $params = array(
            "urlApi" => "https://api.test.sw.com.mx",
            "url" => "https://services.test.sw.com.mx",
            "user" => getenv('SDKTEST_USER'),
            "password" => getenv('SDKTEST_PASSWORD')
        );
        try {
            $pdfService = pdfService::Set($params);
            $result = $pdfService::RegeneratePDF($uuid);
            $this->assertEquals("UUID vacío o es inválido", $result->message);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}
