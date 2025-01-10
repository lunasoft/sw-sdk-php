<?php
namespace tests;
use PHPUnit\Framework\TestCase;
use SWServices\AccountBalance\AccountBalanceService as AccountBalanceService;
final class AccountBalanceTests extends TestCase
{
    public function testSuccessGetBalanceByToken()
    {
        $resultSpect = "success";
        $params = array(
            "urlApi" => "https://api.test.sw.com.mx",
            "token" => getenv('SDKTEST_TOKEN')
        );
        $accountBalance = AccountBalanceService::Set($params);
        $result = $accountBalance::GetAccountBalance();
        $this->assertEquals($resultSpect, $result->status);
        $this->assertNotEmpty($result->data);
    }
    public function testSuccessGetBalanceByAuth()
    {
        $resultSpect = "success";
        $params = array(
            "url"=>"https://services.test.sw.com.mx",
            "urlApi" => "https://api.test.sw.com.mx",
            "user" => getenv('SDKTEST_USER'),
            "password" => getenv('SDKTEST_PASSWORD')
        );
        $accountBalance = AccountBalanceService::Set($params);
        $result = $accountBalance::GetAccountBalance();
        $this->assertEquals($resultSpect, $result->status);
        $this->assertNotEmpty($result->data);
    }
    public function testErrorGetBalanceByToken()
    {
        $resultSpect = "error";
        $msgSpect = "El token debe contener 3 partes";
        $params = array(
            'urlApi' => 'https://api.test.sw.com.mx',
            'token' => '1',
        );
        $accountBalance = AccountBalanceService::Set($params);
        $result = $accountBalance::GetAccountBalance();
        $this->assertEquals($resultSpect, $result->status);
        $this->assertEquals($msgSpect, $result->message);
    }
    public function testSuccessAddStampsByToken()
    {
        $resultSpect = "success";
        $params = array(
            "urlApi" => "https://api.test.sw.com.mx",
            "token" => getenv('SDKTEST_TOKEN')
        );
        $accountBalance = AccountBalanceService::Set($params);
        $result = $accountBalance::AddStamps("fafb2ac2-62ca-49f8-91de-14cea73b01eb", 1, "Prueba PHP");
        $this->assertEquals($resultSpect, $result->status);
        $this->assertNotEmpty($result->data);
    }
    public function testSuccessAddStampsByAuth()
    {
        $resultSpect = "success";
        $params = array(
            "url"=>"https://services.test.sw.com.mx",
            "urlApi" => "https://api.test.sw.com.mx",
            "user" => getenv('SDKTEST_USER'),
            "password" => getenv('SDKTEST_PASSWORD')
        );
        $accountBalance = AccountBalanceService::Set($params);
        $result = $accountBalance::AddStamps("fafb2ac2-62ca-49f8-91de-14cea73b01eb", 1, "Prueba PHP");
        $this->assertEquals($resultSpect, $result->status);
        $this->assertNotEmpty($result->data);
    }
    public function testErrorAddStamps()
    {
        $resultSpect = "error";
        $msgSpect = "El usuario no fue encontrado.";
        $params = array(
            "urlApi" => "https://api.test.sw.com.mx",
            "token" => getenv('SDKTEST_TOKEN')
        );
        $accountBalance = AccountBalanceService::Set($params);
        $result = $accountBalance::AddStamps("fafb2ac2-62ca-49f8-91de-14cea73b01fb", 1, "Prueba PHP");
        $this->assertEquals($resultSpect, $result->status);
        $this->assertEquals($msgSpect, $result->message);
    }
    public function testSuccessRemoveStampsByToken()
    {
        $resultSpect = "success";
        $params = array(
            "urlApi" => "https://api.test.sw.com.mx",
            "token" => getenv('SDKTEST_TOKEN')
        );
        $accountBalance = AccountBalanceService::Set($params);
        $result = $accountBalance::RemoveStamps("fafb2ac2-62ca-49f8-91de-14cea73b01eb", 1, "Prueba PHP Remove");
        $this->assertEquals($resultSpect, $result->status);
    }
    public function testSuccessRemoveStampsByAuth()
    {
        $resultSpect = "success";
        $params = array(
            "url"=>"https://services.test.sw.com.mx",
            "urlApi" => "https://api.test.sw.com.mx",
            "user" => getenv('SDKTEST_USER'),
            "password" => getenv('SDKTEST_PASSWORD')
        );
        $accountBalance = AccountBalanceService::Set($params);
        $result = $accountBalance::RemoveStamps("fafb2ac2-62ca-49f8-91de-14cea73b01eb", 1, "Prueba PHP Remove");
        $this->assertEquals($resultSpect, $result->status);
    }
    public function testErrorRemoveStamps()
    {
        $resultSpect = "error";
        $params = array(
            "urlApi" => "https://api.test.sw.com.mx",
            "token" => getenv('SDKTEST_TOKEN')
        );
        $accountBalance = AccountBalanceService::Set($params);
        $result = $accountBalance::RemoveStamps("dec88317-e174-400a-9d23-9bb687444600", 1, "Prueba PHP Remove");
        $this->assertEquals($resultSpect, $result->status);
    }
}
