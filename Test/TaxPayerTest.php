<?php
    namespace tests;

    use PHPUnit\Framework\TestCase;
    use SWServices\Taxpayer\TaxpayerService as TaxPayerService;
    use Exception;

    final class TaxPayerTest extends TestCase {
        public function testSuccess(){
            try{
                $rfc ="ZNS1101105T3";
                $params = array(
                    "url" => "https://services.test.sw.com.mx",
                    "token"=> "T2lYQ0t4L0RHVkR4dHZ5Nkk1VHNEakZ3Y0J4Nk9GODZuRyt4cE1wVm5tbXB3YVZxTHdOdHAwVXY2NTdJb1hkREtXTzE3dk9pMmdMdkFDR2xFWFVPUXpTUm9mTG1ySXdZbFNja3FRa0RlYURqbzdzdlI2UUx1WGJiKzViUWY2dnZGbFloUDJ6RjhFTGF4M1BySnJ4cHF0YjUvbmRyWWpjTkVLN3ppd3RxL0dJPQ.T2lYQ0t4L0RHVkR4dHZ5Nkk1VHNEakZ3Y0J4Nk9GODZuRyt4cE1wVm5tbFlVcU92YUJTZWlHU3pER1kySnlXRTF4alNUS0ZWcUlVS0NhelhqaXdnWTRncklVSWVvZlFZMWNyUjVxYUFxMWFxcStUL1IzdGpHRTJqdS9Zakw2UGRZbFlVYmJVSkxXa1NZNzN5VUlSUzlJaTYvbi9wczBSRnZGK1NUNUVoM1FNNXZJRUg1Qkx1dXJ1Z09EcHYyQnE4V1dnOHpkczFLdm5MZytxalNBeHdRbmFvb2VhTksrVzhyTTFXU09NbzZVeXMyQ2Q4VC9ncUlqWGZaMFhXSkdmcjJIWlB2Z2RmeFJGNzRkdXh2UHlvdnVhbGN6cGFsRWhSY3BOOWxPc0h4Z2ZJRjBjZEl5WEsvZW0vb0ZxZEJjUGtpRFlWYi9zRDZwZVJFRks0QUpRNkplZ2N4UzVEME40d2RhUHA4c1VUQWJiY1Jvc3NSVFcrRzVyTHNOTWovZlJHQmV6c0lmclE1TXV3aVY3UERtQUo3SjdpTzhuc1R1SGt1R0s0UHUvc3hEZWRtK3U0NExEYUdUVWIxL3NKRE1XY1RlTnNMaENoSFUvVGhaclk2WmNPR2JjUlpib1RPUTN5QUxiU0VEY0NpYmJDcDZHY3pGd0ZJMXcxTEExTnBPdzM.VZBKM8Odz5VdIyhQPZyRaJK1iVLmot-oMf0h69NU4vk"
                );
                $taxpayer = TaxPayerService::Set($params);
                $result = $taxpayer::VerifyTaxPayer($rfc);
                var_dump($result); 
                $this->assertEquals("success", $result->status);
                $this->assertNotNull($result->data);
            }
            catch(Exception $e){
                echo $e->getMessage();
            }
        }
        public function test_Auth_Success(){
            try{
                $rfc ="ZNS1101105T3";
                $params = array(
                    "url" => "https://services.test.sw.com.mx",
                    "user"=> "pruebas_ut@sw.com.mx",
                    "password" => "\$Wpass12345"
                );
                $taxpayer = TaxPayerService::Set($params);
                $result = $taxpayer::VerifyTaxPayer($rfc);
                var_dump($result); 
                $this->assertEquals("success", $result->status);
                $this->assertNotNull($result->data);
            }
            catch(Exception $e){
                echo $e->getMessage();
            }
        }
        public function test_Error(){
            try{
                $rfc ="CACX7605101P8";
                $params = array(
                    "url" => "https://services.test.sw.com.mx",
                    "token" => "T2lYQ0t4L0RHVkR4dHZ5Nkk1VHNEakZ3Y0J4Nk9GODZuRyt4cE1wVm5tbXB3YVZxTHdOdHAwVXY2NTdJb1hkREtXTzE3dk9pMmdMdkFDR2xFWFVPUXpTUm9mTG1ySXdZbFNja3FRa0RlYURqbzdzdlI2UUx1WGJiKzViUWY2dnZGbFloUDJ6RjhFTGF4M1BySnJ4cHF0YjUvbmRyWWpjTkVLN3ppd3RxL0dJPQ.T2lYQ0t4L0RHVkR4dHZ5Nkk1VHNEakZ3Y0J4Nk9GODZuRyt4cE1wVm5tbFlVcU92YUJTZWlHU3pER1kySnlXRTF4alNUS0ZWcUlVS0NhelhqaXdnWTRncklVSWVvZlFZMWNyUjVxYUFxMWFxcStUL1IzdGpHRTJqdS9Zakw2UGRZbFlVYmJVSkxXa1NZNzN5VUlSUzlJaTYvbi9wczBSRnZGK1NUNUVoM1FNNXZJRUg1Qkx1dXJ1Z09EcHYyQnE4V1dnOHpkczFLdm5MZytxalNBeHdRbmFvb2VhTksrVzhyTTFXU09NbzZVeXMyQ2Q4VC9ncUlqWGZaMFhXSkdmcjJIWlB2Z2RmeFJGNzRkdXh2UHlvdnVhbGN6cGFsRWhSY3BOOWxPc0h4Z2ZJRjBjZEl5WEsvZW0vb0ZxZEJjUGtpRFlWYi9zRDZwZVJFRks0QUpRNkplZ2N4UzVEME40d2RhUHA4c1VUQWJiY1Jvc3NSVFcrRzVyTHNOTWovZlJHQmV6c0lmclE1TXV3aVY3UERtQUo3SjdpTzhuc1R1SGt1R0s0UHUvc3hEZWRtK3U0NExEYUdUVWIxL3NKRE1XY1RlTnNMaENoSFUvVGhaclk2WmNPR2JjUlpib1RPUTN5QUxiU0VEY0NpYmJDcDZHY3pGd0ZJMXcxTEExTnBPdzM.VZBKM8Odz5VdIyhQPZyRaJK1iVLmot-oMf0h69NU4vk"
                );
                $taxpayer = TaxPayerService::Set($params);
                $result = $taxpayer::VerifyTaxPayer($rfc);
                var_dump($result); 
                $this->assertEquals("error", $result->status);
                $this->assertNotNull($result->message);
                $this->assertEquals("CS1002 - La consulta no arrojo resultados.", $result->message);
            }
            catch(Exception $e){
                echo $e->getMessage();
            }
        }
        public function test_RfcNull_Error(){
            try{
                $params = array(
                    "url" => "https://services.test.sw.com.mx",
                    "token" => "T2lYQ0t4L0RHVkR4dHZ5Nkk1VHNEakZ3Y0J4Nk9GODZuRyt4cE1wVm5tbXB3YVZxTHdOdHAwVXY2NTdJb1hkREtXTzE3dk9pMmdMdkFDR2xFWFVPUXpTUm9mTG1ySXdZbFNja3FRa0RlYURqbzdzdlI2UUx1WGJiKzViUWY2dnZGbFloUDJ6RjhFTGF4M1BySnJ4cHF0YjUvbmRyWWpjTkVLN3ppd3RxL0dJPQ.T2lYQ0t4L0RHVkR4dHZ5Nkk1VHNEakZ3Y0J4Nk9GODZuRyt4cE1wVm5tbFlVcU92YUJTZWlHU3pER1kySnlXRTF4alNUS0ZWcUlVS0NhelhqaXdnWTRncklVSWVvZlFZMWNyUjVxYUFxMWFxcStUL1IzdGpHRTJqdS9Zakw2UGRZbFlVYmJVSkxXa1NZNzN5VUlSUzlJaTYvbi9wczBSRnZGK1NUNUVoM1FNNXZJRUg1Qkx1dXJ1Z09EcHYyQnE4V1dnOHpkczFLdm5MZytxalNBeHdRbmFvb2VhTksrVzhyTTFXU09NbzZVeXMyQ2Q4VC9ncUlqWGZaMFhXSkdmcjJIWlB2Z2RmeFJGNzRkdXh2UHlvdnVhbGN6cGFsRWhSY3BOOWxPc0h4Z2ZJRjBjZEl5WEsvZW0vb0ZxZEJjUGtpRFlWYi9zRDZwZVJFRks0QUpRNkplZ2N4UzVEME40d2RhUHA4c1VUQWJiY1Jvc3NSVFcrRzVyTHNOTWovZlJHQmV6c0lmclE1TXV3aVY3UERtQUo3SjdpTzhuc1R1SGt1R0s0UHUvc3hEZWRtK3U0NExEYUdUVWIxL3NKRE1XY1RlTnNMaENoSFUvVGhaclk2WmNPR2JjUlpib1RPUTN5QUxiU0VEY0NpYmJDcDZHY3pGd0ZJMXcxTEExTnBPdzM.VZBKM8Odz5VdIyhQPZyRaJK1iVLmot-oMf0h69NU4vk"
                );
                $taxpayer = TaxPayerService::Set($params);
                $result = $taxpayer::VerifyTaxPayer(null);
                var_dump($result); 
                $this->assertEquals("error", $result->status);
                $this->assertNotNull($result->message);
                $this->assertEquals("El RFC no es válido o viene vacío.", $result->message);
            }
            catch(Exception $e){
                echo $e->getMessage();
            }
        }
        public function test_RfcInvalid_Error(){
            try{
                $rfc = "0123456789";
                $params = array(
                    "url" => "https://services.test.sw.com.mx",
                    "token" => "T2lYQ0t4L0RHVkR4dHZ5Nkk1VHNEakZ3Y0J4Nk9GODZuRyt4cE1wVm5tbXB3YVZxTHdOdHAwVXY2NTdJb1hkREtXTzE3dk9pMmdMdkFDR2xFWFVPUXpTUm9mTG1ySXdZbFNja3FRa0RlYURqbzdzdlI2UUx1WGJiKzViUWY2dnZGbFloUDJ6RjhFTGF4M1BySnJ4cHF0YjUvbmRyWWpjTkVLN3ppd3RxL0dJPQ.T2lYQ0t4L0RHVkR4dHZ5Nkk1VHNEakZ3Y0J4Nk9GODZuRyt4cE1wVm5tbFlVcU92YUJTZWlHU3pER1kySnlXRTF4alNUS0ZWcUlVS0NhelhqaXdnWTRncklVSWVvZlFZMWNyUjVxYUFxMWFxcStUL1IzdGpHRTJqdS9Zakw2UGRZbFlVYmJVSkxXa1NZNzN5VUlSUzlJaTYvbi9wczBSRnZGK1NUNUVoM1FNNXZJRUg1Qkx1dXJ1Z09EcHYyQnE4V1dnOHpkczFLdm5MZytxalNBeHdRbmFvb2VhTksrVzhyTTFXU09NbzZVeXMyQ2Q4VC9ncUlqWGZaMFhXSkdmcjJIWlB2Z2RmeFJGNzRkdXh2UHlvdnVhbGN6cGFsRWhSY3BOOWxPc0h4Z2ZJRjBjZEl5WEsvZW0vb0ZxZEJjUGtpRFlWYi9zRDZwZVJFRks0QUpRNkplZ2N4UzVEME40d2RhUHA4c1VUQWJiY1Jvc3NSVFcrRzVyTHNOTWovZlJHQmV6c0lmclE1TXV3aVY3UERtQUo3SjdpTzhuc1R1SGt1R0s0UHUvc3hEZWRtK3U0NExEYUdUVWIxL3NKRE1XY1RlTnNMaENoSFUvVGhaclk2WmNPR2JjUlpib1RPUTN5QUxiU0VEY0NpYmJDcDZHY3pGd0ZJMXcxTEExTnBPdzM.VZBKM8Odz5VdIyhQPZyRaJK1iVLmot-oMf0h69NU4vk"
                );
                $taxpayer = TaxPayerService::Set($params);
                $result = $taxpayer::VerifyTaxPayer($rfc);
                var_dump($result); 
                $this->assertEquals("error", $result->status);
                $this->assertNotNull($result->message);
                $this->assertEquals("El RFC no es válido o viene vacío.", $result->message);
            }
            catch(Exception $e){
                echo $e->getMessage();
            }
        }
    }
?>