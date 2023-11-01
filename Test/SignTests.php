<?php
	namespace tests;
    
    use PHPUnit\Framework\TestCase;
    use SWServices\Toolkit\SignService as Sello;
    use Exception;

    final class SignTests extends TestCase{
    	public function testSign(){
    		$resultSpect = "success";
    		$params = array(
			    "cadenaOriginal"=> "./Test/Resources/SignResources/cadenaOriginal.txt",
			    "archivoKeyPem"=> "./Test/Resources/SignResources/resultado.key.pem",
			    "archivoCerPem"=> "./Test/Resources/SignResources/resultado.cer.pem"
		    );

    		$result = Sello::obtenerSello($params);
    		$this->assertEquals($resultSpect, $result->status);
    	}
    }

?>