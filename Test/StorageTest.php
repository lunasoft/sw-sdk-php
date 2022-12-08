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
            "urlApi" => "https://api.test.sw.com.mx",
            "token" => "T2lYQ0t4L0RHVkR4dHZ5Nkk1VHNEakZ3Y0J4Nk9GODZuRyt4cE1wVm5tbXB3YVZxTHdOdHAwVXY2NTdJb1hkREtXTzE3dk9pMmdMdkFDR2xFWFVPUXpTUm9mTG1ySXdZbFNja3FRa0RlYURqbzdzdlI2UUx1WGJiKzViUWY2dnZGbFloUDJ6RjhFTGF4M1BySnJ4cHF0YjUvbmRyWWpjTkVLN3ppd3RxL0dJPQ.T2lYQ0t4L0RHVkR4dHZ5Nkk1VHNEakZ3Y0J4Nk9GODZuRyt4cE1wVm5tbFlVcU92YUJTZWlHU3pER1kySnlXRTF4alNUS0ZWcUlVS0NhelhqaXdnWTRncklVSWVvZlFZMWNyUjVxYUFxMWFxcStUL1IzdGpHRTJqdS9Zakw2UGRZbFlVYmJVSkxXa1NZNzN5VUlSUzlJaTYvbi9wczBSRnZGK1NUNUVoM1FNNXZJRUg1Qkx1dXJ1Z09EcHYyQnE4V1dnOHpkczFLdm5MZytxalNBeHdRbmFvb2VhTksrVzhyTTFXU09NbzZVeXMyQ2Q4VC9ncUlqWGZaMFhXSkdmcjJIWlB2Z2RmeFJGNzRkdXh2UHlvdnVhbGN6cGFsRWhSY3BOOWxPc0h4Z2ZJRjBjZEl5WEsvZW0vb0ZxZEJjUGtpRFlWYi9zRDZwZVJFRks0QUpRNkplZ2N4UzVEME40d2RhUHA4c1VUQWJiY1Jvc3NSVFcrRzVyTHNOTWovZlJHQmV6c0lmclE1TXV3aVY3UERtQUo3SjdpTzhuc1R1SGt1R0s0UHUvc3hEZWRtK3U0NExEYUdUVWIxL3NKRE1XY1RlTnNMaENoSFUvVGhaclk2WmNPR2JjUlpib1RPUTN5QUxiU0VEY0NpYmJDcDZHY3pGd0ZJMXcxTEExTnBPdzM.VZBKM8Odz5VdIyhQPZyRaJK1iVLmot-oMf0h69NU4vk"
        );
        try {
            $resend = StorageService::Set($params);
            $result = $resend::getXml("0089fe04-89bd-479e-9679-f9e5e87644c7");
            $resultSpect = "success";
            $this->assertEquals($resultSpect, $result::getStatus());
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function testGetAllDataUser_Success()
    {
        $params = array(
            "url" => "https://services.test.sw.com.mx",
            "urlApi" => "https://api.test.sw.com.mx",
            "user" => "pruebas_ut@sw.com.mx",
            "password" => "SWpass12345"
        );
        try {
            $resend = StorageService::Set($params);
            $result = $resend::getXml("0089fe04-89bd-479e-9679-f9e5e87644c7");
            $resultSpect = "success";
            $this->assertEquals($resultSpect, $result::getStatus());
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
    public function testGetXml_Success()
    {
        $params = array(
            "url" => "https://services.test.sw.com.mx",
            "urlApi" => "https://api.test.sw.com.mx",
            "user" => "pruebas_ut@sw.com.mx",
            "password" => "SWpass12345"
        );
        try {
            $resend = StorageService::Set($params);
            $result = $resend::getXml("0089fe04-89bd-479e-9679-f9e5e87644c");
            $resultSpect = "success";
            $this->assertNotEmpty($result::getXml(),"url xml vacío");
            $this->assertEquals($resultSpect, $result::getStatus());
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
    public function testGetPdf_Success()
    {
        $params = array(
            "url" => "https://services.test.sw.com.mx",
            "urlApi" => "https://api.test.sw.com.mx",
            "user" => "pruebas_ut@sw.com.mx",
            "password" => "SWpass12345"
        );
        try {
            $resend = StorageService::Set($params);
            $result = $resend::getXml("05cc0b68-bfa8-4162-b1cc-50d8fa33bf7c");
            $resultSpect = "success";
            $this->assertNotEmpty($result::getPdf(),"UUID inválido o no pertenece a la cuenta.");
            $this->assertEquals($resultSpect, $result::getStatus());
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
    public function testGetXmlCancelation_Success()
    {
        $params = array(
            "url" => "https://services.test.sw.com.mx",
            "urlApi" => "https://api.test.sw.com.mx",
            "user" => "pruebas_ut@sw.com.mx",
            "password" => "SWpass12345"
        );
        try {
            $resend = StorageService::Set($params);
            $result = $resend::getXml("05cc0b68-bfa8-4162-b1cc-50d8fa33bf7c");
            $resultSpect = "success";
            $this->assertNotEmpty($result::getUrlCancelacion(),"UUID inválido o no pertenece a la cuenta.");
            $this->assertEquals($resultSpect, $result::getStatus());
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
    public function testGetAllDataToken_Error()
    {
        $params = array(
            "urlApi" => "https://api.test.sw.com.mx",
            "token" => "T2lYQ0t4L0RHVkR5Nkk1VHNEakZ3Y0J4Nk9GODZuRyt4cE1wVm5tbXB3YVZxTHdOdHAwVXY2NTdJb1hkREtXTzE3dk9pMmdMdkFDR2xFWFVPUXpTUm9mTG1ySXdZbFNja3FRa0RlYURqbzdzdlI2UUx1WGJiKzViUWY2dnZGbFloUDJ6RjhFTGF4M1BySnJ4cHF0YjUvbmRyWWpjTkVLN3ppd3RxL0dJPQ.T2lYQ0t4L0RHVkR4dHZ5Nkk1VHNEakZ3Y0J4Nk9GODZuRyt4cE1wVm5tbFlVcU92YUJTZWlHU3pER1kySnlXRTF4alNUS0ZWcUlVS0NhelhqaXdnWTRncklVSWVvZlFZMWNyUjVxYUFxMWFxcStUL1IzdGpHRTJqdS9Zakw2UGRZbFlVYmJVSkxXa1NZNzN5VUlSUzlJaTYvbi9wczBSRnZGK1NUNUVoM1FNNXZJRUg1Qkx1dXJ1Z09EcHYyQnE4V1dnOHpkczFLdm5MZytxalNBeHdRbmFvb2VhTksrVzhyTTFXU09NbzZVeXMyQ2Q4VC9ncUlqWGZaMFhXSkdmcjJIWlB2Z2RmeFJGNzRkdXh2UHlvdnVhbGN6cGFsRWhSY3BOOWxPc0h4Z2ZJRjBjZEl5WEsvZW0vb0ZxZEJjUGtpRFlWYi9zRDZwZVJFRks0QUpRNkplZ2N4UzVEME40d2RhUHA4c1VUQWJiY1Jvc3NSVFcrRzVyTHNOTWovZlJHQmV6c0lmclE1TXV3aVY3UERtQUo3SjdpTzhuc1R1SGt1R0s0UHUvc3hEZWRtK3U0NExEYUdUVWIxL3NKRE1XY1RlTnNMaENoSFUvVGhaclk2WmNPR2JjUlpib1RPUTN5QUxiU0VEY0NpYmJDcDZHY3pGd0ZJMXcxTEExTnBPdzM.VZBKM8Odz5VdIyhQPZyRaJK1iVLmot-oMf0h69NU4vk"
        );
        try {
            $resend = StorageService::Set($params);
            $result = $resend::getXml("0089fe04-89bd-479e-9679-f9e5e87644c7");
            $this->assertNotEmpty($result,"Authentication error: AU2000 - El usuario y/o contraseña son inválidos, no se puede autenticar el servicio.");
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function testGetAllDataUser_Error()
    {
        $params = array(
            "url" => "https://services.test.sw.com.mx",
            "urlApi" => "https://api.test.sw.com.mx",
            "user" => "pruebas_ut@sw.com.mx",
            "password" => "asasa"
        );
        try {
            $resend = StorageService::Set($params);
            $result = $resend::getXml("0089fe04-89bd-479e-9679-f9e5e87644c7");
            $this->assertNotEmpty($result,"Authentication error: AU2000 - El usuario y/o contraseña son inválidos, no se puede autenticar el servicio.");
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}
