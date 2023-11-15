<?php
    namespace tests;
    
    use PHPUnit\Framework\TestCase;
    use SWServices\AccountBalance\AccountBalanceService as AccountBalanceService;
    use Exception;

    final class AccountBalanceTests extends TestCase {
        public function testSuccess(){
            $resultSpect = "success";
            $params = array(
                'url'=> 'services.test.sw.com.mx',
                'token'=> getenv('SDKTEST_TOKEN'),
            );
            $accountBalance = AccountBalanceService::Set($params);
            $result = $accountBalance::GetAccountBalance();
            $this->assertEquals($resultSpect, $result->status);
        }
        public function testError(){
            $resultSpect = "error";
            $params = array(
                'url'=> 'services.test.sw.com.mx',
                'token'=> '1',
            );
            $accountBalance = AccountBalanceService::Set($params);
            $result = $accountBalance::GetAccountBalance();
            $this->assertEquals($resultSpect, $result->status);
        }
         
    }

?>