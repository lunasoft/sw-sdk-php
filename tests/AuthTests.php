<?php

    use PHPUnit\Framework\TestCase;

    final class AuthTests extends TestCase{
        public function testSuccess(){
            $params = array(
                "url"=>"http://services.test.sw.com.mx",
                "user"=>"demo",
                "password"=> "12345678A"
            );
             $this->assertInstanceOf(
                    AuthenticationService::class,
                    AuthenticationService::auth($params)
                );
        }
    }




?>