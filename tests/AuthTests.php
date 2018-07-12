<?php
    namespace tests;

    use SWServices\Authentication\AuthenticationService as AuthenticationService;
    use Exception;

    final class AuthTests {
        public function testSuccess(){
            $params = array(
                "url"=>"http://services.test.sw.com.mx",
                "user"=>"demo",
                "password"=> "123456789"
            );
             $this->assertInstanceOf(
                    AuthenticationService::class,
                    AuthenticationService::auth($params)
                );
        }
        public function testError(){
            $this->expectException(Exception::class);
            AuthenticationService::auth('');
            
        }
         
    }




?>