<?php
    namespace tests;
    
    use PHPUnit\Framework\TestCase;
    use SWServices\Authentication\AuthenticationService as AuthenticationService;
    use Exception;

    final class AuthTests extends TestCase{
        public function testSuccess(){
            $params = array(
                "url"=>"http://services.test.sw.com.mx",
                "user"=> getenv('SDKTEST_USER'),
                "password"=> getenv('SDKTEST_PASSWORD')
            );
            $authenticate = AuthenticationService::auth($params);
            $result = $authenticate::Token();
            $result->status;
                  
            $this->assertEquals($result->status, "success");
        }
        public function testError(){
            $params = array(
                "url"=>"http://services.test.sw.com.mx",
                "user"=>getenv('SDKTEST_USER'),
                "password"=> ""
            );
            $authenticate = AuthenticationService::auth($params);
            $result = $authenticate::Token();
            $result->status;
                  
            $this->assertEquals($result->status, "error");
        }
         
    }
?>