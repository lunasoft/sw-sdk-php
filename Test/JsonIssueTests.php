<?php

    namespace tests;
    require_once 'SWSDK.php';

    use PHPUnit\Framework\TestCase;
    use SWServices\JSonIssuer\JsonEmisionTimbrado as JsonEmisionTimbrado;
    use SWServices\JSonIssuer\JsonEmisionTimbradoV4 as JsonEmisionTimbradoV4;

    final class JsonIssueTests extends TestCase {
        protected static $generateJson;

        public static function setUpBeforeClass():void {
            self::$generateJson = new GenerateJson();
        }

        public static function tearDownAfterClass():void {
            self::$generateJson = null;
        }

/*---------------------------------------- Issue JSON ---------------------------------------------------------------------------------------------------------------*/
        public function testIssueJsonV1() {
            $params = array(
                "url"=>"https://services.test.sw.com.mx",
                "user"=> getenv('SDKTEST_USER'),
                "password"=> getenv('SDKTEST_PASSWORD')
            );

            $resultSpect = "success";
            $json = file_get_contents(self::$generateJson->dateJson("Test/Resources/cfdi40_json.json"));
            JsonEmisionTimbrado::Set($params);
            $result = JsonEmisionTimbrado::jsonEmisionTimbradoV1($json);

            if($result->status == "error" && strpos($result->message, '307') !== false) {
                $result->status = "success";
            }
            $this->assertEquals($resultSpect, $result->status);
        }

        public function testIssueJsonV1Fail() {
            $resultSpect = "error";
            $json = NULL;
            $params = array(
                "url"=>"https://services.test.sw.com.mx",
                "user"=> getenv('SDKTEST_USER'),
                "password"=> getenv('SDKTEST_PASSWORD')
            );
            JsonEmisionTimbrado::Set($params);
            $result = JsonEmisionTimbrado::jsonEmisionTimbradoV1($json);
            $this->assertEquals($resultSpect, $result->status);
        }

/*-------------------------------- Issue JSON V4 CustomId-----------------------------------------------------------------------------------------------------------------------*/
        public function testIssueJsonV4CustomIdPdf() {
            $resultSpect = "success";
            $prefixOne = date('Y-m-d');
            $prefixTwo = rand(0, 555);
            $customId = "Serie-".$prefixOne."-".$prefixTwo;
            $pdf = false;
            $params = array(
                "url"=>"https://services.test.sw.com.mx",
                "token"=> getenv('SDKTEST_TOKEN')
            );
            $json = file_get_contents(self::$generateJson->dateJson("Test/Resources/cfdi40_json.json"));
            JsonEmisionTimbradoV4::Set($params);
            $result = JsonEmisionTimbradoV4::jsonIssueV4CustomIdPdfV1($json, $customId, $pdf);
            if($result->status == "error" && strpos($result->message, '307') !== false) {
                $result->status = "success";
            }
            $this->assertEquals($resultSpect, $result->status);
        }

        public function testIssueJsonV4CustomIdEmail() {
            $resultSpect = "success";
            $prefixOne = date('Y-m-d');
            $prefixTwo = rand(0, 555);
            $customId = "Serie-".$prefixOne."-".$prefixTwo;
            $email = "correoT@correooest.com";
            $params = array(
                "url"=>"https://services.test.sw.com.mx",
                "token"=> getenv('SDKTEST_TOKEN')
            );
            $json = file_get_contents(self::$generateJson->dateJson("Test/Resources/cfdi40_json.json"));
            JsonEmisionTimbradoV4::Set($params);
            $result = JsonEmisionTimbradoV4::jsonIssueV4CustomIdEmailV1($json, $customId, $email);
            if($result->status == "error" && strpos($result->message, '307') !== false) {
                $result->status = "success";
            }
            $this->assertEquals($resultSpect, $result->status);
        }

        public function testIssueJsonV4CustomIdPdfFail() {
            $resultSpect = "error";
            $customId = NULL;
            $pdf = false;
            $params = array(
                "url"=>"https://services.test.sw.com.mx",
                "token"=> getenv('SDKTEST_TOKEN')
            );
            $json = file_get_contents(self::$generateJson->dateJson("Test/Resources/cfdi40_json.json"));
            JsonEmisionTimbradoV4::Set($params);
            $result = JsonEmisionTimbradoV4::jsonIssueV4CustomIdPdfV1($json, $customId, $pdf);
            $this->assertTrue($resultSpect == $result->status);
        }

        public function testIssueJsonV4CustomIdEmailFail() {
            $resultSpect = "error";
            $customId = NULL;
            $email = NULL;
            $params = array(
                "url"=>"https://services.test.sw.com.mx",
                "token"=> getenv('SDKTEST_TOKEN')
            );
            $json = file_get_contents(self::$generateJson->dateJson("Test/Resources/cfdi40_json.json"));
            JsonEmisionTimbradoV4::Set($params);
            $result = JsonEmisionTimbradoV4::jsonIssueV4CustomIdEmailV1($json, $customId, $email);
            $this->assertTrue($resultSpect == $result->status);
        }
    }

/*-------------------------------------------------------------------------------------------------------------------------------------------------------*/

    final class GenerateJson {
        function dateJson($path) {
            date_default_timezone_set('America/Mexico_City');
            $contentJson = file_get_contents($path);
            $data = json_decode($contentJson, true);
            $data['fecha'] = date('Y-m-d H:i:s');
            $newJson = json_encode($data);
            file_put_contents($path, $newJson);
        
            return "Test/Resources/cfdi40_json.json";
        }
    }