<?php

namespace test;

use PHPUnit\Framework\TestCase;
use SWServices\Retention\RetencionesService as RetencionesService;
use SWServices\Toolkit\SignService as Sellar;
use Exception;
use DOMDocument;
use DateInterval;
use DateTime;
use XSLTProcessor;

final class RetencionesTests extends TestCase
{
    protected static $generateXML;

    public static function setUpBeforeClass(): void
    {
        self::$generateXML = new GenerateXML();
    }

    public static function tearDownAfterClass(): void
    {
        self::$generateXML = null;
    }

    public function testStampV1_success()
    {
        $resultSpect = "success";
        $params = array(
            "url" => "http://services.test.sw.com.mx",
            "urlRetention" => "https://pruebascfdi.smartweb.com.mx/Timbrado/wcfTimbradoRetenciones.svc",
            "user" => getenv('SDKTEST_USER'),
            "password" => getenv('SDKTEST_PASSWORD')
        );

        $xml = file_get_contents(self::$generateXML->createXML());
        $retention = RetencionesService::Set($params);
        $result = json_decode($retention::TimbrarRetencionXML($xml));

        $this->assertEquals($resultSpect, $result->status);
        $this->assertNotNull($result->data);
    }

    public function testStampV2_success()
    {
        $resultSpect = "success";
        $params = array(
            "url" => "http://services.test.sw.com.mx",
            "urlRetention" => "https://pruebascfdi.smartweb.com.mx/Timbrado/wcfTimbradoRetenciones.svc",
            "user" => getenv('SDKTEST_USER'),
            "password" => getenv('SDKTEST_PASSWORD')
        );

        $xml = file_get_contents(self::$generateXML->createXML());
        $retention = RetencionesService::Set($params);
        $result = json_decode($retention::TimbrarRetencionXMLV2($xml));

        $this->assertEquals($resultSpect, $result->status);
        $this->assertNotNull($result->data);
    }

    public function testStampV1_error()
    {
        $resultSpect = "error";
        $params = array(
            "url" => "http://services.test.sw.com.mx",
            "urlRetention" => "https://pruebascfdi.smartweb.com.mx/Timbrado/wcfTimbradoRetenciones.svc",
            "user" => getenv('SDKTEST_USER'),
            "password" => getenv('SDKTEST_PASSWORD')
        );

        $xml = "";
        $retention = RetencionesService::Set($params);
        $result = json_decode($retention::TimbrarRetencionXML($xml));

        $this->assertEquals($resultSpect, $result->status);
        $this->isNull($result->data);
    }

    public function testStampV2_error()
    {
        $resultSpect = "error";
        $params = array(
            "url" => "http://services.test.sw.com.mx",
            "urlRetention" => "https://pruebascfdi.smartweb.com.mx/Timbrado/wcfTimbradoRetenciones.svc",
            "user" => getenv('SDKTEST_USER'),
            "password" => getenv('SDKTEST_PASSWORD')
        );

        $xml = "";
        $retention = RetencionesService::Set($params);
        $result = json_decode($retention::TimbrarRetencionXMLV2($xml));

        $this->assertEquals($resultSpect, $result->status);
        $this->isNull($result->data);
    }

    public function testStampV1_errorReten()
    {
        $resultSpect = "error";
        $messageSpect = "Reten20101 - El resultado de la digestión debe ser igual al resultado de la desencripción del sello.";
        $params = array(
            "url" => "http://services.test.sw.com.mx",
            "urlRetention" => "https://pruebascfdi.smartweb.com.mx/Timbrado/wcfTimbradoRetenciones.svc",
            "user" => getenv('SDKTEST_USER'),
            "password" => getenv('SDKTEST_PASSWORD')
        );

        $xml = file_get_contents(self::$generateXML->errorXML());
        $retention = RetencionesService::Set($params);
        $result = json_decode($retention::TimbrarRetencionXML($xml));

        $this->assertEquals($resultSpect, $result->status);
        $this->assertEquals($messageSpect, $result->message);
        $this->isNull($result->data);
    }

    public function testStampV2_errorReten()
    {
        $resultSpect = "error";
        $messageSpect = "Reten20101 - El resultado de la digestión debe ser igual al resultado de la desencripción del sello.";
        $params = array(
            "url" => "http://services.test.sw.com.mx",
            "urlRetention" => "https://pruebascfdi.smartweb.com.mx/Timbrado/wcfTimbradoRetenciones.svc",
            "user" => getenv('SDKTEST_USER'),
            "password" => getenv('SDKTEST_PASSWORD')
        );

        $xml = file_get_contents(self::$generateXML->errorXML());
        $retention = RetencionesService::Set($params);
        $result = json_decode($retention::TimbrarRetencionXMLV2($xml));

        $this->assertEquals($resultSpect, $result->status);
        $this->assertEquals($messageSpect, $result->message);
        $this->isNull($result->data);
    }
}
// -------------------------------------------End UT´s----------------------------------------------------------//
final class GenerateXML
{
    public $cadenaOriginal = "./Test/Resources/cadenaOriginalRetenciones.txt";

    function __construct()
    {
        date_default_timezone_set('America/Mexico_City');
        $xml = simplexml_load_file('./Test/Resources/retencion20.xml');

        $currentDateTime = new DateTime();
        $interval = new DateInterval('PT1H0M0S');
        $currentDateTime->sub($interval);
        $xml["FechaExp"] = $currentDateTime->format('Y-m-d\TH:i:s');
        $xml->asXML('./Test/Resources/retencion20_test.xml');

        $xml = file_get_contents('./Test/Resources/retencion20_test.xml');
        $xmlFile = "./Test/Resources/retencion20_test.xml";
        $xslFile = "./Test/Resources/xslt/retencion_2_0.xslt";

        $xml = new DOMDocument("1.0", "UTF-8");
        $xml->load($xmlFile);

        $xsl = new DOMDocument();
        $xsl->load($xslFile);

        $proc = new XSLTProcessor;
        $proc->importStyleSheet($xsl);
        $cadenaOriginal = $proc->transformToXML($xml);

        file_put_contents("./Test/Resources/cadenaOriginalRetenciones.txt", $cadenaOriginal);
    }

    public function createXML()
    {
        $xml = simplexml_load_file('./Test/Resources/retencion20_test.xml');
        $currentDateTime = new DateTime();
        $interval = new DateInterval('PT1H0M0S');
        $currentDateTime->sub($interval);

        $date = $date = $currentDateTime->format('Y-m-d\TH:i:s');
        $xml["FechaExp"] = $date;
        $xml->asXML('./Test/Resources/retencion20_test.xml');

        $cadenaOriginal = file_get_contents('./Test/Resources/cadenaOriginalRetenciones.txt');
        $cadenaOriginal = preg_replace('/\d{4}-\d{2}-\d{2}\T\d{2}:\d{2}:\d{2}/', $date, $cadenaOriginal);

        file_put_contents("./Test/Resources/cadenaOriginalRetenciones.txt", $cadenaOriginal);

        $params = array(
            "cadenaOriginal" => "./Test/Resources/cadenaOriginalRetenciones.txt",
            "archivoKeyPem" => "./Test/Resources/cert_pruebas/EKU9003173C9_key.pem",
            "archivoCerPem" => "./Test/Resources/cert_pruebas/EKU9003173C9_Cer.pem"
        );

        try {
            $result = Sellar::ObtenerSello($params);
            if ($result->status == "success") {
                $xml = simplexml_load_file('./Test/Resources/retencion20_test.xml');
                $xml["Sello"] = $result->sello;
                $xml->asXML('./Test/Resources/retencion20_test.xml');
                sleep(2);
                return "./Test/Resources/retencion20_test.xml";
            }
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
        return '/Test/Resources/retencion20.xml';
    }

    public function errorXML()
    {
        return './Test/Resources/retencion20_test_error.xml';
    }
}
