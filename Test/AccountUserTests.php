<?php

namespace tests;

use PHPUnit\Framework\TestCase;
use SWServices\AccountUser\AccountUserService as AccountUserService;
use Exception;

final class AccountUserTests extends TestCase
{

    private $params;
    private $tokenParams;

    public function setUp(): void
    {
        $this->params = array(
            "url" => "https://services.test.sw.com.mx",
            "urlApi" => "https://api.test.sw.com.mx",
            "user" => getenv('SDKTEST_USER'),
            "password" => getenv('SDKTEST_PASSWORD')
        );

        $this->tokenParams = array(
            "urlApi" => "https://api.test.sw.com.mx",
            "token" => getenv('SDKTEST_TOKEN')
        );
    }

    public function testCreateUserSuccess()
    {
        $resultSpect = "El email 'pruebas3_test@gmail.com' ya esta en uso.";
        $data = array(
            'name' => "Valentin Nuño",
            'taxId' => "XIA190128J61",
            'email' => "pruebas3_test@gmail.com",
            'stamps' => 1,
            'isUnlimited' => false,
            'password' => "SWpass1!",
            'notificationEmail' => "pruebas3_test@gmail.com",
            'phone' => "5550123457"
        );

        $accountUser = AccountUserService::Set($this->params);
        $result = $accountUser::CreateUser($data);
        $this->assertEquals($resultSpect, $result->message);
    }

    public function testCreateUserSuccessToken()
    {
        $resultSpect = "El email 'pruebas3_test@gmail.com' ya esta en uso.";
        $data = array(
            'name' => "Valentin Nuño",
            'taxId' => "XIA190128J61",
            'email' => "pruebas3_test@gmail.com",
            'stamps' => 1,
            'isUnlimited' => false,
            'password' => "SWpass1!",
            'notificationEmail' => "pruebas3_test@gmail.com",
            'phone' => "5550123457"
        );

        $accountUser = AccountUserService::Set($this->tokenParams);
        $result = $accountUser::CreateUser($data);
        $this->assertEquals($resultSpect, $result->message);
    }

    public function testUpdateUserSuccess()
    {
        $resultSpect = "No es posible actualizar, los datos enviados son identicos a los actuales";
        $idUser = '32501CF2-DC62-4370-B47D-25024C44E131';
        $data = array(
            'name' => "Valentin Nuño",
            'taxId' => "XIA190128J61",
            'isUnlimited' => false,
            'iduser' => "32501CF2-DC62-4370-B47D-25024C44E131",
            'notificationEmail' => "pruebas3_test@gmail.com",
            'phone' => "5550123457"
        );

        $accountUser = AccountUserService::Set($this->params);
        $result = $accountUser::UpdateUser($idUser, $data);
        $this->assertEquals($resultSpect, $result->message);
    }

    public function testUpdateUserSuccessToken()
    {
        $resultSpect = "No es posible actualizar, los datos enviados son identicos a los actuales";
        $idUser = '32501CF2-DC62-4370-B47D-25024C44E131';
        $data = array(
            'name' => "Valentin Nuño",
            'taxId' => "XIA190128J61",
            'isUnlimited' => false,
            'iduser' => "32501CF2-DC62-4370-B47D-25024C44E131",
            'notificationEmail' => "pruebas3_test@gmail.com",
            'phone' => "5550123457"
        );

        $accountUser = AccountUserService::Set($this->tokenParams);
        $result = $accountUser::UpdateUser($idUser, $data);
        $this->assertEquals($resultSpect, $result->message);
    }

    public function testDeleteUserSuccess()
    {
        $resultSpect = "El usuario ya ha sido previamente removido";
        $idUser = '1136157b-671a-4ae5-88d2-4e7479fdc1ce';

        $accountUser = AccountUserService::Set($this->params);
        $result = $accountUser::DeleteUser($idUser);
        $this->assertEquals($resultSpect, $result->message);
    }

    public function testDeleteUserSuccessToken()
    {
        $resultSpect = "El usuario ya ha sido previamente removido";
        $idUser = '1136157b-671a-4ae5-88d2-4e7479fdc1ce';

        $accountUser = AccountUserService::Set($this->tokenParams);
        $result = $accountUser::DeleteUser($idUser);
        $this->assertEquals($resultSpect, $result->message);
    }

    public function testGetUserSuccessWithAllParams()
    {
        $resultSpect = "success";
        $data = array(
            'taxId' => "XIA190128J61",
            'email' => "prueba_php@gmail.com",
            'name' => "PruebaPHP",
            'idUser' => "583493d3-5a17-4453-9ac5-4cb2e4e2fbf9",
            'isActive' => true,
            'Page' => "1",
            'PerPage' => "10"
        );

        $accountUser = AccountUserService::Set($this->params);
        $result = $accountUser::GetUser($data);
        $this->assertEquals($resultSpect, $result->status);
        $this->assertNotEmpty($result->data);
    }

    public function testGetUserSuccessWithSomeParams()
    {
        $resultSpect = "success";
        $data = array(
            'taxId' => null,
            'email' => null,
            'name' => "PruebaPHP",
            'idUser' => "583493d3-5a17-4453-9ac5-4cb2e4e2fbf9",
            'isActive' => true,
            // 'Page' => "1",
            // 'PerPage' => "10"
        );

        $accountUser = AccountUserService::Set($this->params);
        $result = $accountUser::GetUser($data);
        $this->assertEquals($resultSpect, $result->status);
        $this->assertNotEmpty($result->data);
    }

    public function testGetUserSuccessWithOutParams()
    {
        $resultSpect = "success";
        $data = [];

        $accountUser = AccountUserService::Set($this->params);
        $result = $accountUser::GetUser($data);
        $this->assertEquals($resultSpect, $result->status);
        $this->assertNotEmpty($result->data);
    }
}
