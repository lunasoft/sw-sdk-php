<?php
	namespace tests;
    
    use PHPUnit\Framework\TestCase;
    use SWServices\Toolkit\SealService as Sello;
    use Exception;

    final class SealTests extends TestCase{
    	public function testSeal(){
    		$resultSpect = "success";
    		$params = array(
			    "cadenaOriginal"=> "./Tests/Resources/SealResources/CSD_PAC_CFDI_PRUEBAS/cadenaoriginal.txt",
			    "archivoKeyPem"=> "./Tests/Resources/SealResources/CSD_PAC_CFDI_PRUEBAS/resultado.key.pem",
			    "archivoCerPem"=> "./Tests/Resources/SealResources/CSD_PAC_CFDI_PRUEBAS/resultado.cer.pem"
		    );
    		$result = Sello::obtenerSello($params);
    		$this->assertEquals($resultSpect, $result->status);
    	}
    }

?>