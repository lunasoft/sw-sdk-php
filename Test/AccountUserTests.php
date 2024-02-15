<?php

    namespace tests;
    
    use PHPUnit\Framework\TestCase;
    use SWServices\AccountUser\AccountUserService as AccountUserService;
    use Exception;

    final class AccountUserTests extends TestCase {
        public function testGetAllUserSuccess(){
            $resultSpect = "success";
            $params = array(
                'urlApi'=> 'http://api.test.sw.com.mx',
                'token'=> getenv('SDKTEST_TOKEN'),
            );
            $accountUser = AccountUserService::Set($params);
            $result = $accountUser::GetAllUser();
            $this->assertEquals($resultSpect, $result->status);
            var_dump($result);
        }
        public function testGetAllUserError(){
            $resultSpect = "error";
            $params = array(
                'urlApi'=> 'http://api.test.sw.com.mx',
                'token'=> '1',
            );
            $accountUser = AccountUserService::Set($params);
            $result = $accountUser::GetAllUser();
            $this->assertEquals($resultSpect, $result->status);
            var_dump($result);
        }
         
    }
?>