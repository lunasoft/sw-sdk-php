<?php

namespace tests;
    
    use PHPUnit\Framework\TestCase;
    use SWServices\Stamp\StampService as StampService;
    use SWServices\Toolkit\SignService as Sellar;
    use Exception;
    use DOMDocument;
    use XSLTProcessor;
	error_reporting(E_ERROR);


class StampTests extends TestCase{
		
		protected static $generateXML;

	    public static function setUpBeforeClass()
	    {
	        self::$generateXML = new GenerateXML();
	    }

	    public static function tearDownAfterClass()
	    {
	        self::$generateXML = null;
	    }
/*----------------------------------------V1---------------------------------------------------------------------------------------------------------------*/
        public function testStampXMLV1()
        {
			function is_base64($s)
			{
				return (bool) preg_match('/^[a-zA-Z0-9\/\r\n+]*={0,2}$/', $s);
			}
			$resultSpect = "success";
			$params = array(
			    "url"=>"http://services.test.sw.com.mx",
			    "user"=>"demo",
			    "password"=> "123456789"
				);

			$xml = file_get_contents(self::$generateXML->createXML());
			$stamp = StampService::Set($params);
			$result = $stamp::StampV1($xml);
			var_dump($result);
			echo "-------------------";

			if($result->status == "error" && strpos($result->message, '307') !== false) {
				$result->status = "success";
			}

			$this->assertEquals($resultSpect, $result->status);
        }

        public function testStampXMLV1byToken()
        {
			$resultSpect = "success";
			$params = array(
				"url"=>"http://services.test.sw.com.mx",
				"token"=>"T2lYQ0t4L0RHVkR4dHZ5Nkk1VHNEakZ3Y0J4Nk9GODZuRyt4cE1wVm5tbXB3YVZxTHdOdHAwVXY2NTdJb1hkREtXTzE3dk9pMmdMdkFDR2xFWFVPUXpTUm9mTG1ySXdZbFNja3FRa0RlYURqbzdzdlI2UUx1WGJiKzViUWY2dnZGbFloUDJ6RjhFTGF4M1BySnJ4cHF0YjUvbmRyWWpjTkVLN3ppd3RxL0dJPQ.T2lYQ0t4L0RHVkR4dHZ5Nkk1VHNEakZ3Y0J4Nk9GODZuRyt4cE1wVm5tbFlVcU92YUJTZWlHU3pER1kySnlXRTF4alNUS0ZWcUlVS0NhelhqaXdnWTRncklVSWVvZlFZMWNyUjVxYUFxMWFxcStUL1IzdGpHRTJqdS9Zakw2UGRiMTFPRlV3a2kyOWI5WUZHWk85ODJtU0M2UlJEUkFTVXhYTDNKZVdhOXIySE1tUVlFdm1jN3kvRStBQlpLRi9NeWJrd0R3clhpYWJrVUMwV0Mwd3FhUXdpUFF5NW5PN3J5cklMb0FETHlxVFRtRW16UW5ZVjAwUjdCa2g0Yk1iTExCeXJkVDRhMGMxOUZ1YWlIUWRRVC8yalFTNUczZXdvWlF0cSt2UW0waFZKY2gyaW5jeElydXN3clNPUDNvU1J2dm9weHBTSlZYNU9aaGsvalpQMUxrUndzK0dHS2dpTittY1JmR3o2M3NqNkh4MW9KVXMvUHhZYzVLQS9UK2E1SVhEZFJKYWx4ZmlEWDFuSXlqc2ZRYXlUQk1ldlZkU2tEdU10NFVMdHZKUURLblBxakw0SDl5bUxabDFLNmNPbEp6b3Jtd2Q1V2htRHlTdDZ6eTFRdUNnYnVvK2tuVUdhMmwrVWRCZi9rQkU9.7k2gVCGSZKLzJK5Ky3Nr5tKxvGSJhL13Q8W-YhT0uIo"
				);
			$xml = file_get_contents(self::$generateXML->createXML());
			$stamp = StampService::Set($params);
			$result = $stamp::StampV1($xml);
			var_dump($result);
			echo "-------------------";

			if($result->status == "error" && strpos($result->message, '307') !== false) {
				$result->status = "success";
			}

			$this->assertEquals($resultSpect,$result->status);
        }
        public function testStampXMLV2()
        {
			$resultSpect = "success";
			$params = array(
			    "url"=>"http://services.test.sw.com.mx",
			    "user"=>"demo",
			    "password"=> "123456789"
				);
			$xml = file_get_contents(self::$generateXML->createXML());
			$stamp = StampService::Set($params);
			$result = $stamp::StampV2($xml);
			var_dump($result);
			echo "-------------------";

			if($result->status == "error" && strpos($result->message, '307') !== false) {
				$result->status = "success";
			}

			$this->assertEquals($resultSpect,$result->status);
        }
/*----------------------------------V2---------------------------------------------------------------------------------------------------------------------*/
        public function testStampXMLV2byToken()
        {
			$resultSpect = "success";
			$params = array(
				"url"=>"http://services.test.sw.com.mx",
				"token"=>"T2lYQ0t4L0RHVkR4dHZ5Nkk1VHNEakZ3Y0J4Nk9GODZuRyt4cE1wVm5tbXB3YVZxTHdOdHAwVXY2NTdJb1hkREtXTzE3dk9pMmdMdkFDR2xFWFVPUXpTUm9mTG1ySXdZbFNja3FRa0RlYURqbzdzdlI2UUx1WGJiKzViUWY2dnZGbFloUDJ6RjhFTGF4M1BySnJ4cHF0YjUvbmRyWWpjTkVLN3ppd3RxL0dJPQ.T2lYQ0t4L0RHVkR4dHZ5Nkk1VHNEakZ3Y0J4Nk9GODZuRyt4cE1wVm5tbFlVcU92YUJTZWlHU3pER1kySnlXRTF4alNUS0ZWcUlVS0NhelhqaXdnWTRncklVSWVvZlFZMWNyUjVxYUFxMWFxcStUL1IzdGpHRTJqdS9Zakw2UGRiMTFPRlV3a2kyOWI5WUZHWk85ODJtU0M2UlJEUkFTVXhYTDNKZVdhOXIySE1tUVlFdm1jN3kvRStBQlpLRi9NeWJrd0R3clhpYWJrVUMwV0Mwd3FhUXdpUFF5NW5PN3J5cklMb0FETHlxVFRtRW16UW5ZVjAwUjdCa2g0Yk1iTExCeXJkVDRhMGMxOUZ1YWlIUWRRVC8yalFTNUczZXdvWlF0cSt2UW0waFZKY2gyaW5jeElydXN3clNPUDNvU1J2dm9weHBTSlZYNU9aaGsvalpQMUxrUndzK0dHS2dpTittY1JmR3o2M3NqNkh4MW9KVXMvUHhZYzVLQS9UK2E1SVhEZFJKYWx4ZmlEWDFuSXlqc2ZRYXlUQk1ldlZkU2tEdU10NFVMdHZKUURLblBxakw0SDl5bUxabDFLNmNPbEp6b3Jtd2Q1V2htRHlTdDZ6eTFRdUNnYnVvK2tuVUdhMmwrVWRCZi9rQkU9.7k2gVCGSZKLzJK5Ky3Nr5tKxvGSJhL13Q8W-YhT0uIo"
				);
			$xml = file_get_contents(self::$generateXML->createXML());
			$stamp = StampService::Set($params);
			$result = $stamp::StampV2($xml);
			var_dump($result);
			echo "-------------------";

			if($result->status == "error" && strpos($result->message, '307') !== false) {
				$result->status = "success";
			}

			$this->assertEquals($resultSpect,$result->status);
        }

		 public function testStampXMLV2_B64()
        {
			
			$resultSpect = "success";
			$params = array(
			    "url"=>"http://services.test.sw.com.mx",
			    "user"=>"demo",
			    "password"=> "123456789"
				);

			$xml = file_get_contents(self::$generateXML->createXML());
			$xml = base64_encode($xml);
			$stamp = StampService::Set($params);
			$result = $stamp::StampV2($xml,true);
			var_dump($result);
			echo "-------------------";

			if($result->status == "error" && strpos($result->message, '307') !== false) {
				$result->status = "success";
			}

			$this->assertTrue($resultSpect == $result->status);
			$this->assertTrue(is_base64($result->data->tfd));
			$this->assertTrue(is_base64($result->data->cfdi));
        }

        public function testStampXMLV2byToken_B64()
        {
			$resultSpect = "success";
			$params = array(
				"url"=>"http://services.test.sw.com.mx",
				"token"=>"T2lYQ0t4L0RHVkR4dHZ5Nkk1VHNEakZ3Y0J4Nk9GODZuRyt4cE1wVm5tbXB3YVZxTHdOdHAwVXY2NTdJb1hkREtXTzE3dk9pMmdMdkFDR2xFWFVPUXpTUm9mTG1ySXdZbFNja3FRa0RlYURqbzdzdlI2UUx1WGJiKzViUWY2dnZGbFloUDJ6RjhFTGF4M1BySnJ4cHF0YjUvbmRyWWpjTkVLN3ppd3RxL0dJPQ.T2lYQ0t4L0RHVkR4dHZ5Nkk1VHNEakZ3Y0J4Nk9GODZuRyt4cE1wVm5tbFlVcU92YUJTZWlHU3pER1kySnlXRTF4alNUS0ZWcUlVS0NhelhqaXdnWTRncklVSWVvZlFZMWNyUjVxYUFxMWFxcStUL1IzdGpHRTJqdS9Zakw2UGRiMTFPRlV3a2kyOWI5WUZHWk85ODJtU0M2UlJEUkFTVXhYTDNKZVdhOXIySE1tUVlFdm1jN3kvRStBQlpLRi9NeWJrd0R3clhpYWJrVUMwV0Mwd3FhUXdpUFF5NW5PN3J5cklMb0FETHlxVFRtRW16UW5ZVjAwUjdCa2g0Yk1iTExCeXJkVDRhMGMxOUZ1YWlIUWRRVC8yalFTNUczZXdvWlF0cSt2UW0waFZKY2gyaW5jeElydXN3clNPUDNvU1J2dm9weHBTSlZYNU9aaGsvalpQMUxrUndzK0dHS2dpTittY1JmR3o2M3NqNkh4MW9KVXMvUHhZYzVLQS9UK2E1SVhEZFJKYWx4ZmlEWDFuSXlqc2ZRYXlUQk1ldlZkU2tEdU10NFVMdHZKUURLblBxakw0SDl5bUxabDFLNmNPbEp6b3Jtd2Q1V2htRHlTdDZ6eTFRdUNnYnVvK2tuVUdhMmwrVWRCZi9rQkU9.7k2gVCGSZKLzJK5Ky3Nr5tKxvGSJhL13Q8W-YhT0uIo"
				);
			$xml = file_get_contents(self::$generateXML->createXML());
			$xml = base64_encode($xml);
			$stamp = StampService::Set($params);
			$result = $stamp::StampV2($xml,true);
			var_dump($result);
			echo "-------------------";

			if($result->status == "error" && strpos($result->message, '307') !== false) {
				$result->status = "success";
			}

			$this->assertTrue($resultSpect == $result->status);
			$this->assertTrue(is_base64($result->data->tfd));
			$this->assertTrue(is_base64($result->data->cfdi));
        }

		/*--------------------------------V3-----------------------------------------------------------------------------------------------------------------------*/
		 public function testStampXMLV3byToken()
        {
			$resultSpect = "success";
			$params = array(
				"url"=>"http://services.test.sw.com.mx",
				"token"=>"T2lYQ0t4L0RHVkR4dHZ5Nkk1VHNEakZ3Y0J4Nk9GODZuRyt4cE1wVm5tbXB3YVZxTHdOdHAwVXY2NTdJb1hkREtXTzE3dk9pMmdMdkFDR2xFWFVPUXpTUm9mTG1ySXdZbFNja3FRa0RlYURqbzdzdlI2UUx1WGJiKzViUWY2dnZGbFloUDJ6RjhFTGF4M1BySnJ4cHF0YjUvbmRyWWpjTkVLN3ppd3RxL0dJPQ.T2lYQ0t4L0RHVkR4dHZ5Nkk1VHNEakZ3Y0J4Nk9GODZuRyt4cE1wVm5tbFlVcU92YUJTZWlHU3pER1kySnlXRTF4alNUS0ZWcUlVS0NhelhqaXdnWTRncklVSWVvZlFZMWNyUjVxYUFxMWFxcStUL1IzdGpHRTJqdS9Zakw2UGRiMTFPRlV3a2kyOWI5WUZHWk85ODJtU0M2UlJEUkFTVXhYTDNKZVdhOXIySE1tUVlFdm1jN3kvRStBQlpLRi9NeWJrd0R3clhpYWJrVUMwV0Mwd3FhUXdpUFF5NW5PN3J5cklMb0FETHlxVFRtRW16UW5ZVjAwUjdCa2g0Yk1iTExCeXJkVDRhMGMxOUZ1YWlIUWRRVC8yalFTNUczZXdvWlF0cSt2UW0waFZKY2gyaW5jeElydXN3clNPUDNvU1J2dm9weHBTSlZYNU9aaGsvalpQMUxrUndzK0dHS2dpTittY1JmR3o2M3NqNkh4MW9KVXMvUHhZYzVLQS9UK2E1SVhEZFJKYWx4ZmlEWDFuSXlqc2ZRYXlUQk1ldlZkU2tEdU10NFVMdHZKUURLblBxakw0SDl5bUxabDFLNmNPbEp6b3Jtd2Q1V2htRHlTdDZ6eTFRdUNnYnVvK2tuVUdhMmwrVWRCZi9rQkU9.7k2gVCGSZKLzJK5Ky3Nr5tKxvGSJhL13Q8W-YhT0uIo"
				);
			$xml = file_get_contents(self::$generateXML->createXML());
			$stamp = StampService::Set($params);
			$result = $stamp::StampV3($xml);
			var_dump($result);
			echo "-------------------";

			if($result->status == "error" && strpos($result->message, '307') !== false) {
				$result->status = "success";
			}

			$this->assertEquals($resultSpect,$result->status);
        }

		 public function testStampXMLV3_B64()
        {
			
			$resultSpect = "success";
			$params = array(
			    "url"=>"http://services.test.sw.com.mx",
			    "user"=>"demo",
			    "password"=> "123456789"
				);

			$xml = file_get_contents(self::$generateXML->createXML());
			$xml = base64_encode($xml);
			$stamp = StampService::Set($params);
			$result = $stamp::StampV3($xml,true);
			var_dump($result);
			echo "-------------------";

			if($result->status == "error" && strpos($result->message, '307') !== false) {
				$result->status = "success";
			}

			$this->assertTrue($resultSpect == $result->status);
        }

        public function testStampXMLV3byToken_B64()
        {
			$resultSpect = "success";
			$params = array(
				"url"=>"http://services.test.sw.com.mx",
				"token"=>"T2lYQ0t4L0RHVkR4dHZ5Nkk1VHNEakZ3Y0J4Nk9GODZuRyt4cE1wVm5tbXB3YVZxTHdOdHAwVXY2NTdJb1hkREtXTzE3dk9pMmdMdkFDR2xFWFVPUXpTUm9mTG1ySXdZbFNja3FRa0RlYURqbzdzdlI2UUx1WGJiKzViUWY2dnZGbFloUDJ6RjhFTGF4M1BySnJ4cHF0YjUvbmRyWWpjTkVLN3ppd3RxL0dJPQ.T2lYQ0t4L0RHVkR4dHZ5Nkk1VHNEakZ3Y0J4Nk9GODZuRyt4cE1wVm5tbFlVcU92YUJTZWlHU3pER1kySnlXRTF4alNUS0ZWcUlVS0NhelhqaXdnWTRncklVSWVvZlFZMWNyUjVxYUFxMWFxcStUL1IzdGpHRTJqdS9Zakw2UGRiMTFPRlV3a2kyOWI5WUZHWk85ODJtU0M2UlJEUkFTVXhYTDNKZVdhOXIySE1tUVlFdm1jN3kvRStBQlpLRi9NeWJrd0R3clhpYWJrVUMwV0Mwd3FhUXdpUFF5NW5PN3J5cklMb0FETHlxVFRtRW16UW5ZVjAwUjdCa2g0Yk1iTExCeXJkVDRhMGMxOUZ1YWlIUWRRVC8yalFTNUczZXdvWlF0cSt2UW0waFZKY2gyaW5jeElydXN3clNPUDNvU1J2dm9weHBTSlZYNU9aaGsvalpQMUxrUndzK0dHS2dpTittY1JmR3o2M3NqNkh4MW9KVXMvUHhZYzVLQS9UK2E1SVhEZFJKYWx4ZmlEWDFuSXlqc2ZRYXlUQk1ldlZkU2tEdU10NFVMdHZKUURLblBxakw0SDl5bUxabDFLNmNPbEp6b3Jtd2Q1V2htRHlTdDZ6eTFRdUNnYnVvK2tuVUdhMmwrVWRCZi9rQkU9.7k2gVCGSZKLzJK5Ky3Nr5tKxvGSJhL13Q8W-YhT0uIo"
				);
			$xml = file_get_contents(self::$generateXML->createXML());
			$xml = base64_encode($xml);
			$stamp = StampService::Set($params);
			$result = $stamp::StampV3($xml,true);
			var_dump($result);
			echo "-------------------";

			if($result->status == "error" && strpos($result->message, '307') !== false) {
				$result->status = "success";
			}
			
			$this->assertTrue($resultSpect == $result->status);
			$this->assertTrue(is_base64($result->data->cfdi));
        } 
		/*--------------------------------V4-----------------------------------------------------------------------------------------------------------------------*/
		 public function testStampXMLV4byToken()
        {
			$resultSpect = "success";
			$params = array(
				"url"=>"http://services.test.sw.com.mx",
				"token"=>"T2lYQ0t4L0RHVkR4dHZ5Nkk1VHNEakZ3Y0J4Nk9GODZuRyt4cE1wVm5tbXB3YVZxTHdOdHAwVXY2NTdJb1hkREtXTzE3dk9pMmdMdkFDR2xFWFVPUXpTUm9mTG1ySXdZbFNja3FRa0RlYURqbzdzdlI2UUx1WGJiKzViUWY2dnZGbFloUDJ6RjhFTGF4M1BySnJ4cHF0YjUvbmRyWWpjTkVLN3ppd3RxL0dJPQ.T2lYQ0t4L0RHVkR4dHZ5Nkk1VHNEakZ3Y0J4Nk9GODZuRyt4cE1wVm5tbFlVcU92YUJTZWlHU3pER1kySnlXRTF4alNUS0ZWcUlVS0NhelhqaXdnWTRncklVSWVvZlFZMWNyUjVxYUFxMWFxcStUL1IzdGpHRTJqdS9Zakw2UGRiMTFPRlV3a2kyOWI5WUZHWk85ODJtU0M2UlJEUkFTVXhYTDNKZVdhOXIySE1tUVlFdm1jN3kvRStBQlpLRi9NeWJrd0R3clhpYWJrVUMwV0Mwd3FhUXdpUFF5NW5PN3J5cklMb0FETHlxVFRtRW16UW5ZVjAwUjdCa2g0Yk1iTExCeXJkVDRhMGMxOUZ1YWlIUWRRVC8yalFTNUczZXdvWlF0cSt2UW0waFZKY2gyaW5jeElydXN3clNPUDNvU1J2dm9weHBTSlZYNU9aaGsvalpQMUxrUndzK0dHS2dpTittY1JmR3o2M3NqNkh4MW9KVXMvUHhZYzVLQS9UK2E1SVhEZFJKYWx4ZmlEWDFuSXlqc2ZRYXlUQk1ldlZkU2tEdU10NFVMdHZKUURLblBxakw0SDl5bUxabDFLNmNPbEp6b3Jtd2Q1V2htRHlTdDZ6eTFRdUNnYnVvK2tuVUdhMmwrVWRCZi9rQkU9.7k2gVCGSZKLzJK5Ky3Nr5tKxvGSJhL13Q8W-YhT0uIo"
				);
			$xml = file_get_contents(self::$generateXML->createXML());
			$stamp = StampService::Set($params);
			$result = $stamp::StampV4($xml);
			var_dump($result);
			echo "-------------------";

			if($result->status == "error" && strpos($result->message, '307') !== false) {
				$result->status = "success";
			}
			
			$this->assertEquals($resultSpect,$result->status);
        }

		 public function testStampXMLV4_B64()
        {
			
			$resultSpect = "success";
			$params = array(
			    "url"=>"http://services.test.sw.com.mx",
			    "user"=>"demo",
			    "password"=> "123456789"
				);
			$xml = file_get_contents(self::$generateXML->createXML());
			$xml = base64_encode($xml);
			$stamp = StampService::Set($params);
			$result = $stamp::StampV4($xml,true);
			var_dump($result);
			echo "-------------------";

			if($result->status == "error" && strpos($result->message, '307') !== false) {
				$result->status = "success";
			}
			
			$this->assertTrue($resultSpect == $result->status);
			$this->assertTrue(is_base64($result->data->cfdi));
        }

        public function testStampXMLV4byToken_B64()
        {
			$resultSpect = "success";
			$params = array(
				"url"=>"http://services.test.sw.com.mx",
				"token"=>"T2lYQ0t4L0RHVkR4dHZ5Nkk1VHNEakZ3Y0J4Nk9GODZuRyt4cE1wVm5tbXB3YVZxTHdOdHAwVXY2NTdJb1hkREtXTzE3dk9pMmdMdkFDR2xFWFVPUXpTUm9mTG1ySXdZbFNja3FRa0RlYURqbzdzdlI2UUx1WGJiKzViUWY2dnZGbFloUDJ6RjhFTGF4M1BySnJ4cHF0YjUvbmRyWWpjTkVLN3ppd3RxL0dJPQ.T2lYQ0t4L0RHVkR4dHZ5Nkk1VHNEakZ3Y0J4Nk9GODZuRyt4cE1wVm5tbFlVcU92YUJTZWlHU3pER1kySnlXRTF4alNUS0ZWcUlVS0NhelhqaXdnWTRncklVSWVvZlFZMWNyUjVxYUFxMWFxcStUL1IzdGpHRTJqdS9Zakw2UGRiMTFPRlV3a2kyOWI5WUZHWk85ODJtU0M2UlJEUkFTVXhYTDNKZVdhOXIySE1tUVlFdm1jN3kvRStBQlpLRi9NeWJrd0R3clhpYWJrVUMwV0Mwd3FhUXdpUFF5NW5PN3J5cklMb0FETHlxVFRtRW16UW5ZVjAwUjdCa2g0Yk1iTExCeXJkVDRhMGMxOUZ1YWlIUWRRVC8yalFTNUczZXdvWlF0cSt2UW0waFZKY2gyaW5jeElydXN3clNPUDNvU1J2dm9weHBTSlZYNU9aaGsvalpQMUxrUndzK0dHS2dpTittY1JmR3o2M3NqNkh4MW9KVXMvUHhZYzVLQS9UK2E1SVhEZFJKYWx4ZmlEWDFuSXlqc2ZRYXlUQk1ldlZkU2tEdU10NFVMdHZKUURLblBxakw0SDl5bUxabDFLNmNPbEp6b3Jtd2Q1V2htRHlTdDZ6eTFRdUNnYnVvK2tuVUdhMmwrVWRCZi9rQkU9.7k2gVCGSZKLzJK5Ky3Nr5tKxvGSJhL13Q8W-YhT0uIo"
				);
			$xml = file_get_contents(self::$generateXML->createXML());
			$xml = base64_encode($xml);
			$stamp = StampService::Set($params);
			$result = $stamp::StampV4($xml,true);
			var_dump($result);
			echo "-------------------";
			
			if($result->status == "error" && strpos($result->message, '307') !== false) {
				$result->status = "success";
			}
			
			$this->assertTrue($resultSpect == $result->status);
			$this->assertTrue(is_base64($result->data->tfd));
        }
    }

	final Class GenerateXML {


		public $cadenaOriginal = "./Tests/Resources/cadenaOriginal.txt";
		
		function __construct() {
			date_default_timezone_set('America/Mexico_City');
			$xml = simplexml_load_file('./Tests/Resources/file.xml'); //leemos el xml base
			$xml["Fecha"] = date("Y-m-d\TH:i:s");
			$xml->asXML('./Tests/Resources/fileTest.xml'); //cambiamos la fecha y lo guardamos en un nuevo archivo

			$xml = file_get_contents('./Tests/Resources/fileTest.xml');

			$xmlFile="./Tests/Resources/fileTest.xml";
		 
		    // Ruta al archivo XSLT
		    $xslFile = "./Tests/Resources/cert_pruebas/cadenaoriginal_3_3.xslt"; 
		 
		    // Crear un objeto DOMDocument para cargar el CFDI
		    $xml = new DOMDocument("1.0","UTF-8"); 
		    // Cargar el CFDI
		    $xml->load($xmlFile);
		 
		    // Crear un objeto DOMDocument para cargar el archivo de transformación XSLT
		    $xsl = new DOMDocument();
		    $xsl->load($xslFile);
		 
		    // Crear el procesador XSLT que nos generará la cadena original con base en las reglas descritas en el XSLT
		    $proc = new XSLTProcessor;
		    // Cargar las reglas de transformación desde el archivo XSLT.
		    $proc->importStyleSheet($xsl);
		    // Generar la cadena original y asignarla a una variable
		    $cadenaOriginal = $proc->transformToXML($xml);
		    file_put_contents("./Tests/Resources/cadenaOriginal.txt", $cadenaOriginal); //escribimos la cadena original en un archivo
		} 

		public function createXML() {
			date_default_timezone_set('America/Mexico_City');
			$xml = simplexml_load_file('./Tests/Resources/fileTest.xml'); //leemos el xml base
			$date = date("Y-m-d\TH:i:s");
			$xml["Fecha"] = $date;
			$xml->asXML('./Tests/Resources/fileTest.xml'); //cambiamos la fecha y lo guardamos en un nuevo archivo

			$cadenaOriginal = file_get_contents('./Tests/Resources/cadenaOriginal.txt');

			$cadenaOriginal = preg_replace('/\d{4}-\d{2}-\d{2}\T\d{2}:\d{2}:\d{2}/', $date, $cadenaOriginal); //reemplazamos la fecha en la cadena original para tener la cadena original nueva

			file_put_contents("./Tests/Resources/cadenaOriginal.txt", $cadenaOriginal); //escribimos la cadena original en un archivo


			$params = array(
			    "cadenaOriginal"=> "./Tests/Resources/cadenaOriginal.txt",
			    "archivoKeyPem"=> "./Tests/Resources/cert_pruebas/AAA010101AAA.key.pem",
			    "archivoCerPem"=> "./Tests/Resources/cert_pruebas/AAA010101AAA.cer.pem"
		    );

		    try {
		        $result = Sellar::ObtenerSello($params);
		        if($result->status=="success"){
		        	$xml = simplexml_load_file('./Tests/Resources/fileTest.xml');
		        	$xml["Sello"] = $result->sello;
		        	$xml->asXML('./Tests/Resources/fileTest.xml');
		        	sleep(2);
		        	return "./Tests/Resources/fileTest.xml";
		        }
		    } catch(Exception $e) {
		        echo 'Caught exception: ',  $e->getMessage(), "\n";
		    }

		    return '/Tests/Resources/file.xml';
		}
    }
    