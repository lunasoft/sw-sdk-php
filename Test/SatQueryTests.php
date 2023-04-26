<?php
    namespace tests;
    
    use PHPUnit\Framework\TestCase;
    use SWServices\SatQuery\SatQueryService as SatQueryService;
    use Exception;

    final class SatQueryTests extends TestCase{
        public function testSuccess(){
            $resultSpect = 200;
            $url="https://pruebacfdiconsultaqr.cloudapp.net/ConsultaCFDIService.svc";
            $rfcEmisor="";
            $rfcReceptor=""; 
            $total=""; 
            $uuid=""; 
            $sello="";
            
            $result = SatQueryService::ServicioConsultaSAT($url,$rfcEmisor, $rfcReceptor, $total, $uuid, $sello);
			$this->assertEquals($resultSpect, $result->Status);
        }
         
    }




?>