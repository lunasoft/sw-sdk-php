<?php
    namespace tests;

    use PHPUnit\Framework\TestCase;
    use SWServices\AcceptReject\AcceptRejectService as AcceptRejectService;
    use Exception;

    final class AcceptRejectTests extends TestCase{
        /* -------------------------- Aceptación/Rechazo UUID -------------------------------------------- */
        public function testAcceptRejectServiceByUUID_auth(){
            $resultSpect = "success";
            $rfc = "EKU9003173C9";
            $uuid = "dcbddeb9-a208-42be-ae5b-0390a929fe48";
            $action = "Aceptacion";
            $params = array(
			    "url"=>"http://services.test.sw.com.mx",
			    "user"=> getenv('SDKTEST_USER'),
			    "password"=> getenv('SDKTEST_PASSWORD')
				);
            $acceptReject = AcceptRejectService::Set($params);
            $result = $acceptReject::AceptarRechazarCancelacionUUID($rfc, $uuid, $action);
            $this->assertEquals($resultSpect, $result->status);
            $this->assertEquals("1000", $result->codStatus);
            $this->assertNotEmpty($result->data->acuse, "Acuse vacio");
        }

        public function testAcceptRejectServiceByUUID_success(){
            $resultSpect = "success";
            $rfc = "EKU9003173C9";
            $uuid = "dcbddeb9-a208-42be-ae5b-0390a929fe48";
            $action = "Aceptacion";
            $params = array(
                'url'=> 'services.test.sw.com.mx',
                'token'=> getenv('SDKTEST_TOKEN'),
            );
            $acceptReject = AcceptRejectService::Set($params);
            $result = $acceptReject::AceptarRechazarCancelacionUUID($rfc, $uuid, $action);
            $this->assertEquals($resultSpect, $result->status);
            $this->assertEquals("1000", $result->codStatus);
            $this->assertNotEmpty($result->data->acuse, "Acuse vacio");
        }

        public function testAcceptRejectServiceByUUID_error(){
            $resultSpect = "error";
            $message = "CACFDI33 - Error no controlado";
            $messageDetail = "No se encontró el CSD correspondiente al RFC EKU9003173C .";
            $rfc = "EKU9003173C";
            $uuid = "dcbddeb9-a208-42be-ae5b-0390a929fe48";
            $action = "Aceptacion";
            $params = array(
                'url'=> 'services.test.sw.com.mx',
                'token'=> getenv('SDKTEST_TOKEN'),
            );
            $acceptReject = AcceptRejectService::Set($params);
            $result = $acceptReject::AceptarRechazarCancelacionUUID($rfc, $uuid, $action);
            $this->assertEquals($resultSpect, $result->status);
            $this->assertEquals($message, $result->message);
            $this->assertEquals($messageDetail, $result->messageDetail);
        }
        /* -------------------------- Aceptación/Rechazo CSD -------------------------------------------- */
        public function testAcceptRejectServiceByCSD_auth(){
            $resultSpect = "success";
            $rfc = "EKU9003173C9";
            $list = [
                ['uuid' => 'dcbddeb9-a208-42be-ae5b-0390a929fe48', 'action' => 'Aceptacion']
            ];
            $cerB64 = base64_encode(file_get_contents('Test\Resources\cert_pruebas\EKU9003173C9.cer'));
		    $keyB64 = base64_encode(file_get_contents('Test\Resources\cert_pruebas\EKU9003173C9.key'));
		    $password = "12345678a";
            $params = array(
			    "url"=>"http://services.test.sw.com.mx",
			    "user"=> getenv('SDKTEST_USER'),
			    "password"=> getenv('SDKTEST_PASSWORD')
				);
            $acceptReject = AcceptRejectService::Set($params);
            $result = $acceptReject::AceptarRechazarCancelacionCSD($rfc, $list, $cerB64, $keyB64, $password);
            $this->assertEquals($resultSpect, $result->status);
            $this->assertEquals("1000", $result->codStatus);
            $this->assertNotEmpty($result->data->acuse, "Acuse vacio");
        }
        public function testAcceptRejectServiceByCSD_success(){
            $resultSpect = "success";
            $rfc = "EKU9003173C9";
            $list = [
                ['uuid' => 'dcbddeb9-a208-42be-ae5b-0390a929fe48', 'action' => 'Aceptacion']
            ];
            $cerB64 = base64_encode(file_get_contents('Test\Resources\cert_pruebas\EKU9003173C9.cer'));
		    $keyB64 = base64_encode(file_get_contents('Test\Resources\cert_pruebas\EKU9003173C9.key'));
		    $password = "12345678a";
            $params = array(
                'url'=> 'services.test.sw.com.mx',
                'token'=> getenv('SDKTEST_TOKEN'),
            );
            $acceptReject = AcceptRejectService::Set($params);
            $result = $acceptReject::AceptarRechazarCancelacionCSD($rfc, $list, $cerB64, $keyB64, $password);
            $this->assertEquals($resultSpect, $result->status);
            $this->assertEquals("1000", $result->codStatus);
            $this->assertNotEmpty($result->data->acuse, "Acuse vacio");
        }
        public function testAcceptRejectServiceByCSD_error(){
            $resultSpect = "error";
            $message = "CACFDI33 - Error no controlado";
            $messageDetail = "El Rfc proporcionado es inválido. Favor de verificar.";
            $rfc = "EKU9003173C";
            $list = [
                ['uuid' => 'dcbddeb9-a208-42be-ae5b-0390a929fe48', 'action' => 'Aceptacion']
            ];
            $cerB64 = base64_encode(file_get_contents('Test\Resources\cert_pruebas\EKU9003173C9.cer'));
		    $keyB64 = base64_encode(file_get_contents('Test\Resources\cert_pruebas\EKU9003173C9.key'));
		    $password = "12345678a";
            $params = array(
                'url'=> 'services.test.sw.com.mx',
                'token'=> getenv('SDKTEST_TOKEN'),
            );
            $acceptReject = AcceptRejectService::Set($params);
            $result = $acceptReject::AceptarRechazarCancelacionCSD($rfc, $list, $cerB64, $keyB64, $password);
            $this->assertEquals($resultSpect, $result->status);
            $this->assertEquals($message, $result->message);
            $this->assertEquals($messageDetail, $result->messageDetail);
        }
        /* -------------------------- Aceptación/Rechazo PFX -------------------------------------------- */
        public function testAcceptRejectServiceByPFX_auth(){
            $resultSpect = "success";
            $rfc = "EKU9003173C9";
            $list = [
                ['uuid' => 'dcbddeb9-a208-42be-ae5b-0390a929fe48', 'action' => 'Aceptacion']
            ];
            $pfxB64 = base64_encode(file_get_contents('Test\Resources\cert_pruebas\EKU9003173C9.pfx'));
            $passwordPfx = "swpass";
            $params = array(
			    "url"=>"http://services.test.sw.com.mx",
			    "user"=> getenv('SDKTEST_USER'),
			    "password"=> getenv('SDKTEST_PASSWORD')
				);
            $acceptReject = AcceptRejectService::Set($params);
            $result = $acceptReject::AceptarRechazarCancelacionPFX($rfc, $list, $pfxB64, $passwordPfx);
            $this->assertEquals($resultSpect, $result->status);
            $this->assertEquals("1000", $result->codStatus);
            $this->assertNotEmpty($result->data->acuse, "Acuse vacio");
        }
        public function testAcceptRejectServiceByPFX_success(){
            $resultSpect = "success";
            $rfc = "EKU9003173C9";
            $list = [
                ['uuid' => 'dcbddeb9-a208-42be-ae5b-0390a929fe48', 'action' => 'Aceptacion']
            ];
            $pfxB64 = base64_encode(file_get_contents('Test\Resources\cert_pruebas\EKU9003173C9.pfx'));
            $passwordPfx = "swpass";
            $params = array(
                'url'=> 'services.test.sw.com.mx',
                'token'=> getenv('SDKTEST_TOKEN'),
            );
            $acceptReject = AcceptRejectService::Set($params);
            $result = $acceptReject::AceptarRechazarCancelacionPFX($rfc, $list, $pfxB64, $passwordPfx);
            $this->assertEquals($resultSpect, $result->status);
            $this->assertEquals("1000", $result->codStatus);
            $this->assertNotEmpty($result->data->acuse, "Acuse vacio");
        }

        public function testAcceptRejectServiceByPFX_error(){
            $resultSpect = "error";
            $message = "CACFDI33 - Error no controlado";
            $messageDetail = "El Rfc proporcionado es inválido. Favor de verificar.";
            $rfc = "EKU9003173C";
            $list = [
                ['uuid' => 'dcbddeb9-a208-42be-ae5b-0390a929fe48', 'action' => 'Aceptacion']
            ];
            $pfxB64 = base64_encode(file_get_contents('Test\Resources\cert_pruebas\EKU9003173C9.pfx'));
            $passwordPfx = "swpass";
            $params = array(
                'url'=> 'services.test.sw.com.mx',
                'token'=> getenv('SDKTEST_TOKEN'),
            );
            $acceptReject = AcceptRejectService::Set($params);
            $result = $acceptReject::AceptarRechazarCancelacionPFX($rfc, $list, $pfxB64, $passwordPfx);
            $this->assertEquals($resultSpect, $result->status);
            $this->assertEquals($message, $result->message);
            $this->assertEquals($messageDetail, $result->messageDetail);
        }
        /* -------------------------- Aceptación/Rechazo XML -------------------------------------------- */
        public function testAcceptRejectServiceByXML_auth(){
            $resultSpect = "success";
            $xml = file_get_contents('Test\Resources\acceptReject_xml.xml');
            $params = array(
			    "url"=>"http://services.test.sw.com.mx",
			    "user"=> getenv('SDKTEST_USER'),
			    "password"=> getenv('SDKTEST_PASSWORD')
				);
            $acceptReject = AcceptRejectService::Set($params);
            $result = $acceptReject::AceptarRechazarCancelacionXML($xml);
            $this->assertEquals($resultSpect, $result->status);
            $this->assertEquals("1000", $result->codStatus);
            $this->assertNotEmpty($result->data->acuse, "Acuse vacio");
        }
        public function testAcceptRejectServiceByXML_success(){
            $resultSpect = "success";
            $xml = file_get_contents('Test\Resources\acceptReject_xml.xml');
            $params = array(
                'url'=> 'services.test.sw.com.mx',
                'token'=> getenv('SDKTEST_TOKEN'),
            );
            $acceptReject = AcceptRejectService::Set($params);
            $result = $acceptReject::AceptarRechazarCancelacionXML($xml);
            $this->assertEquals($resultSpect, $result->status);
            $this->assertEquals("1000", $result->codStatus);
            $this->assertNotEmpty($result->data->acuse, "Acuse vacio");
        }
        public function testAcceptRejectServiceByXML_error(){
            $resultSpect = "error";
            $message = "CACFDI33 - Error no controlado";
            $messageDetail = "CA1000 - El xml proporcionado está mal formado o es inválido. There is an error in XML document (0, 0).";
            $xml = null;
            $params = array(
                'url'=> 'services.test.sw.com.mx',
                'token'=> getenv('SDKTEST_TOKEN'),
            );
            $acceptReject = AcceptRejectService::Set($params);
            $result = $acceptReject::AceptarRechazarCancelacionXML($xml);
            $this->assertEquals($resultSpect, $result->status);
            $this->assertEquals($message, $result->message);
            $this->assertEquals($messageDetail, $result->messageDetail);
        }
    }

?>