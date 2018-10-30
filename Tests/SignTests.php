<?php
	namespace tests;
    
    use PHPUnit\Framework\TestCaseTest;
    use SWServices\Toolkit\SignService as Sello;
    use Exception;

    final class SignTests extends TestCaseTest{
    	public function testSign(){
    		$resultSpect = "success";
    		$params = array(
			    "cadenaOriginal"=> "./Tests/Resources/SignResources/CSD_PAC_CFDI_PRUEBAS/cadenaoriginal.txt",
			    "archivoKeyPem"=> "./Tests/Resources/SignResources/CSD_PAC_CFDI_PRUEBAS/resultado.key.pem",
			    "archivoCerPem"=> "./Tests/Resources/SignResources/CSD_PAC_CFDI_PRUEBAS/resultado.cer.pem"
		    );

    		$result = Sello::obtenerSello($params);
    		$this->assertEquals($resultSpect, $result->status);
    	}
    }

?>