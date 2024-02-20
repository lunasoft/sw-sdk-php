<?php

namespace tests;

use PHPUnit\Framework\TestCase;
use SWServices\AccountBalance\AccountBalanceService as AccountBalanceService;
use Exception;

final class AccountBalanceTests extends TestCase
{
    
    public function testSuccessGetBalanceByToken()
    {
        $resultSpect = "success";
        $params = array(
            "url" => "http://services.test.sw.com.mx",
            "token" => getenv('SDKTEST_TOKEN')
        );
        $accountBalance = AccountBalanceService::Set($params);
        $result = $accountBalance::GetAccountBalance();
        $this->assertEquals($resultSpect, $result->status);
    }
    public function testErrorGetBalanceByToken()
    {
        $resultSpect = "error";
        $params = array(
            'url' => 'services.test.sw.com.mx',
            'token' => '1',
        );
        $accountBalance = AccountBalanceService::Set($params);
        $result = $accountBalance::GetAccountBalance();
        $this->assertEquals($resultSpect, $result->status);
    }
    public function testSuccessGetBalanceById()
    {
        $params = array(
            "urlApi" => "http://api.test.sw.com.mx",
            "token" => getenv('SDKTEST_TOKEN')
        );
        $resultSpect = "success";
        $accountBalance = AccountBalanceService::Set($params);
        $result = $accountBalance::GetAccountBalanceById("fafb2ac2-62ca-49f8-91de-14cea73b01eb");
        $this->assertEquals($resultSpect, $result->status);
    }
    public function testErrorGetBalanceById()
    {
        $resultSpect = "error";
        $params = array(
            "urlApi" => "http://api.test.sw.com.mx",
            "token" => "FakeToken"
        );
        $accountBalance = AccountBalanceService::Set($params);
        $result = $accountBalance::GetAccountBalanceById("fafb2ac4-62ca-49f8-91de-14cea73b01eb");
        $this->assertEquals($resultSpect, $result->status);
    }
    public function testSuccessAddStamps()
    {
        $resultSpect = "success";
        $params = array(
            "urlApi" => "http://api.test.sw.com.mx",
            "token" => getenv('SDKTEST_TOKEN')
        );
        $accountBalance = AccountBalanceService::Set($params);
        $result = $accountBalance::AddStamps("fafb2ac2-62ca-49f8-91de-14cea73b01eb", 1, "Prueba PHP");
        $this->assertEquals($resultSpect, $result->status);
    }
    public function testErrorAddStamps()
    {
        $resultSpect = "error";
        $params = array(
            "urlApi" => "http://api.test.sw.com.mx",
            "token" => getenv('SDKTEST_TOKEN')
        );
        $accountBalance = AccountBalanceService::Set($params);
        $result = $accountBalance::AddStamps("fafb2ac2-62ca-49f8-91de-14cea73b01fb", 1, "Prueba PHP");
        $this->assertEquals($resultSpect, $result->status);
    }
    public function testSuccessRemoveStamps()
    {
        $resultSpect = "success";
        $params = array(
            "urlApi" => "http://api.test.sw.com.mx",
            "token" => getenv('SDKTEST_TOKEN')
        );
        $accountBalance = AccountBalanceService::Set($params);
        $result = $accountBalance::AddStamps("fafb2ac2-62ca-49f8-91de-14cea73b01eb", 1, "Prueba PHP Remove");
        $this->assertEquals($resultSpect, $result->status);
    }
    public function testErrorRemoveStamps()
    {
        $resultSpect = "error";
        $params = array(
            "urlApi" => "http://api.test.sw.com.mx",
            "token" => getenv('SDKTEST_TOKEN')
        );
        $accountBalance = AccountBalanceService::Set($params);
        $result = $accountBalance::AddStamps("dec88317-e174-400a-9d23-9bb687444600", 1, "Prueba PHP Remove");
        $this->assertEquals($resultSpect, $result->status);
    }
}
