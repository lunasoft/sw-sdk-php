<?php
    namespace tests;
    
    use PHPUnit\Framework\TestCase;
    use SWServices\SatQuery\SatQueryService as SatQueryService;
    use Exception;

    final class SatQueryTests extends TestCase{
        public function testSuccess(){
            $resultSpect = ["Vigente", "Cancelado","No Encontrado"];
            $url="https://pruebacfdiconsultaqr.cloudapp.net/ConsultaCFDIService.svc";
            $rfcEmisor="EKU9003173C9";
            $rfcReceptor="URE180429TM6"; 
            $total="198.96"; 
            $uuid="372d425a-af92-4c0e-af1e-553e7ca9946a&fe"; 
            $sello="tBhmcQ==";
            
            $result = SatQueryService::ServicioConsultaSAT($url,$rfcEmisor, $rfcReceptor, $total, $uuid, $sello);
			$this->assertContains($result->Status, $resultSpect);
        }
         
    }




?>