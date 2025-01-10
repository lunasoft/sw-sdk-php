<?php

namespace tests;
use PHPUnit\Framework\TestCase;
use SWServices\Csd\CsdService as CsdService;
use Exception;

final class CsdTest extends TestCase
{
    public function testUploadCsd(){
        $resultSpect = "success";
        $isActive = true;
        $type = "stamp";
        $b64Cer = base64_encode(file_get_contents('Test\Resources\cert_pruebas\EKU9003173C9.cer'));
        $b64Key = base64_encode(file_get_contents('Test\Resources\cert_pruebas\EKU9003173C9.key'));
        $password = "12345678a";
        $params = array(
			"url" => "https://services.test.sw.com.mx/",
			"token" => getenv('SDKTEST_TOKEN')
		);
        try {
            $csdService = CsdService::Set($params);
            $result = $csdService::UploadCsd($isActive, $type, $b64Cer, $b64Key, $password);
            $this->assertEquals($resultSpect, $result->status);
        } catch (Exception $e){
            echo $e->getMessage();
        }
    }

    public function testGetListCsd(){
        $resultSpect = "success";
        $params = array(
			"url" => "https://services.test.sw.com.mx/",
			"token" => getenv('SDKTEST_TOKEN')
		);
        try {
            $csdService = CsdService::Set($params);
            $result = $csdService::GetListCsd();
            $this->assertEquals($resultSpect, $result->status);
        } catch (Exception $e){
            echo $e->getMessage();
        }
    }

    public function testGetListCsdByType(){
        $resultSpect = "success";
        $params = array(
			"url" => "https://services.test.sw.com.mx/",
			"token" => getenv('SDKTEST_TOKEN')
		);
        try {
            $csdService = CsdService::Set($params);
            $result = $csdService::GetListCsdByType('stamp');
            $this->assertEquals($resultSpect, $result->status);
        } catch (Exception $e){
            echo $e->getMessage();
        }
    }

    public function testGetListCsdByRfc(){
        $resultSpect = "success";
        $params = array(
			"url" => "https://services.test.sw.com.mx/",
			"token" => getenv('SDKTEST_TOKEN')
		);
        try {
            $csdService = CsdService::Set($params);
            $result = $csdService::GetListCsdByType('EKU9003173C9');
            $this->assertEquals($resultSpect, $result->status);
        } catch (Exception $e){
            echo $e->getMessage();
        }
    }

    public function testInfoCsd(){
        $resultSpect = "success";
        $params = array(
			"url" => "https://services.test.sw.com.mx/",
			"token" => getenv('SDKTEST_TOKEN')
		);
        try {
            $csdService = CsdService::Set($params);
            $result = $csdService::InfoCsd('20001000000300022816');
            $this->assertEquals($resultSpect, $result->status);
        } catch (Exception $e){
            echo $e->getMessage();
        }
    }

    public function testInfoActiveCsd(){
        $resultSpect = "success";
        $params = array(
			"url" => "https://services.test.sw.com.mx/",
			"token" => getenv('SDKTEST_TOKEN')
		);
        try {
            $csdService = CsdService::Set($params);
            $result = $csdService::InfoActiveCsd('EKU9003173C9', 'stamp');
            $this->assertEquals($resultSpect, $result->status);
        } catch (Exception $e){
            echo $e->getMessage();
        }
    }

    public function testDisableCsd(){
        $resultSpect = "success";
        $params = array(
			"url" => "https://services.test.sw.com.mx/",
			"token" => getenv('SDKTEST_TOKEN')
		);
        try {
            $csdService = CsdService::Set($params);
            $result = $csdService::DisableCsd('20001000000300022763');
            $this->assertEquals($resultSpect, $result->status);
        } catch (Exception $e){
            echo $e->getMessage();
        }
    }
}