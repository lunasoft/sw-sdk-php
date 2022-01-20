<?php
    namespace tests;
    
    use PHPUnit\Framework\TestCase;
    use SWServices\SatQuery\SatQueryService as SatQueryService;
    use Exception;

    final class ConsultaEstatusTests extends TestCase{
        public function testSuccess(){
            $resultSpect = "success";
            $url="https://pruebacfdiconsultaqr.cloudapp.net/ConsultaCFDIService.svc";
            $rfcEmisor="IVD920810GU2";
            $rfcReceptor="JILH841117AS9"; 
            $total="0"; 
            $uuid="89c81fe8-b9c5-4df3-9924-4e2ea2cdb4d3"; 
            $fe8="bb2k2g==";
            
            $result = SatQueryService::ServicioConsultaSAT($url,$rfcEmisor, $rfcReceptor, $total, $uuid, $fe8);
			$this->assertEquals($resultSpect, $result->status);
        }
         
    }




?>