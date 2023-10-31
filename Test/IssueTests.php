<?php
    
    namespace tests;
    require_once 'SWSDK.php';

    use PHPUnit\Framework\TestCase;
    use SWServices\Stamp\EmisionTimbrado as EmisionTimbrado;
    use SWServices\Services;

    final class IssueTests extends TestCase{
        protected static $generateXML;

	    public static function setUpBeforeClass():void 
	    {
	        self::$generateXML = new GenerateXML();
	    }

	    public static function tearDownAfterClass():void 
	    {
	        self::$generateXML = null;
	    }
/*----------------------------------------V4---------------------------------------------------------------------------------------------------------------*/
        public function testIssueXMLV1()
        {
            $params = array(
			    "url"=>"http://services.test.sw.com.mx",
			    "user"=> getenv('SDKTEST_USER'),
			    "password"=> getenv('SDKTEST_PASSWORD')
				);

			$resultSpect = "success";
            $xml = file_get_contents(self::$generateXML->createXML());
            EmisionTimbrado::Set($params);
			$result = EmisionTimbrado::EmisionTimbradoV4($xml);

			if($result->status == "error" && strpos($result->message, '307') !== false) {
				$result->status = "success";
			}
			$this->assertEquals($resultSpect, $result->status);
        }

		/*--------------------------------Timbrado ISSUE V4 CustomId-----------------------------------------------------------------------------------------------------------------------*/
		public function testIssueV4CustomIdPdf()
		{
			$resultSpect = "success";
			$prefixOne = date('Y-m-d');
			$prefixTwo = rand(0, 555);
			$customId = "Serie-".$prefixOne."-".$prefixTwo;
			$pdf = false;
			$params = array(
				"url"=>"http://services.test.sw.com.mx",
				"token"=> getenv('SDKTEST_TOKEN')
				);
			$xml = file_get_contents(self::$generateXML->createXML());
			EmisionTimbrado::Set($params);
			$result = EmisionTimbrado::issueV4CustomIdPdfV1($xml, $customId, $pdf);
			if($result->status == "error" && strpos($result->message, '307') !== false) {
				$result->status = "success";
			}
			
			$this->assertTrue($resultSpect == $result->status);
		}
		public function testIssueV4CustomIdEmail()
		{
			$resultSpect = "success";
			$prefixOne = date('Y-m-d');
			$prefixTwo = rand(0, 555);
			$customId = "Serie-".$prefixOne."-".$prefixTwo;
			$email = "correoT@correoest.com";
			$params = array(
				"url"=>"http://services.test.sw.com.mx",
				"token"=> getenv('SDKTEST_TOKEN')
				);
			$xml = file_get_contents(self::$generateXML->createXML());
			$stamp = EmisionTimbrado::Set($params);
			$result = $stamp::issueV4CustomIdEmailV1($xml, $customId, $email);
			if($result->status == "error" && strpos($result->message, '307') !== false) {
				$result->status = "success";
			}
			$this->assertTrue($resultSpect == $result->status);
		}
		//Failed Test
		public function testIssueV4CustomIdPdfFail()
		{
			$resultSpect = "error";
			$customId = NULL;
			$pdf = false;
			$params = array(
				"url"=>"http://services.test.sw.com.mx",
				"token"=> getenv('SDKTEST_TOKEN')
				);
			$xml = file_get_contents(self::$generateXML->createXML());
			$stamp = EmisionTimbrado::Set($params);
			$result = $stamp::issueV4CustomIdPdfV1($xml, $customId, $pdf);
			$this->assertTrue($resultSpect == $result->status);
		}
		/*--------------------------------Fin Timbrado ISSUE V4 CustomId-----------------------------------------------------------------------------------------------------------------------*/
    }

final Class GenerateXML {
    public function createXML() {
        date_default_timezone_set('America/Mexico_City');
        $xml = simplexml_load_file('./Test/Resources/cfdi40_test.xml'); //leemos el xml base
        $date = date("Y-m-d\TH:i:s");
        $xml["Fecha"] = $date;
        $xml->asXML('./Test/Resources/cfdi40_test.xml'); //cambiamos la fecha y lo guardamos en un nuevo archivo

        return './Test/Resources/cfdi40_test.xml';
    }
}
?>