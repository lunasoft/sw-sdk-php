<?php

namespace SWServices\Stamp;
use SWServices\Helpers\ResponseHelper as Response;
use SimpleXMLElement;
use Exception;
use PHPUnit\Framework\Constraint\IsEqual;
use SWServices\Helpers\ResponseHelper;

class StampRequest
{
    public static function sendReq($url, $token, $xml, $version, $isB64, $proxy, $path)
    {
        $delimiter = '-------------' . uniqid();
        $fileFields = array(
            'xml' => array(
                'type' => 'text/xml',
                'content' => $xml
            )
        );
        $data = '';
        foreach ($fileFields as $name => $file) {
            $data .= "--" . $delimiter . "\r\n";
            $data .= 'Content-Disposition: form-data; name="' . $name . '";' .
                ' filename="' . $name . '"' . "\r\n";
            $data .= 'Content-Type: ' . $file['type'] . "\r\n";
            $data .= "\r\n";
            $data .= $file['content'] . "\r\n";
        }
        $data .= "--" . $delimiter . "--\r\n";

        $curl = curl_init($url . $path . $version . ($isB64 ? '/b64' : ''));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        if (isset($proxy)) {
            curl_setopt($curl, CURLOPT_PROXY, $proxy);
        }

        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'Content-Type: multipart/form-data; boundary=' . $delimiter,
            'Content-Length: ' . strlen($data),
            'Authorization: Bearer ' . $token
        ));
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

        $response = curl_exec($curl);
        $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $err = curl_error($curl);
        curl_close($curl);

        if ($err) {
            throw new Exception("cURL Error #:" . $err);
        } else {
            if ($httpcode < 500)
                return json_decode($response);
            else
                throw new Exception("cUrl Error, HTTPCode: $httpcode, Response: $response");
        }
    }
    public static function sendReqV4($url, $token, $xml, $version, $isb64, $proxy, $path, $customId, $pdf, $email)
    {
        //Esto genera el string junto con la variable que se recibe para generar CURLOPT_HTTPHEADER
        $pdf = ($pdf == false) ? NULL : "'extra: pdf',";
        $email = implode(',', (array) $email);
        $email = ($email == NULL) ? NULL : "'email: " . $email . "'";
        $customId = "customid: " . $customId . "',";

        $delimiter = '-------------' . uniqid();
        $fileFields = array(
            'xml' => array(
                'type' => 'text/xml',
                'content' => $xml
            )
        );
        $data = '';
        foreach ($fileFields as $name => $file) {
            $data .= "--" . $delimiter . "\r\n";
            $data .= 'Content-Disposition: form-data; name="' . $name . '";' .
                ' filename="' . $name . '"' . "\r\n";
            $data .= 'Content-Type: ' . $file['type'] . "\r\n";
            $data .= "\r\n";
            $data .= $file['content'] . "\r\n";
        }
        $data .= "--" . $delimiter . "--\r\n";

        $curl = curl_init($url . $path . $version . ($isb64 ? '/b64' : ''));
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        if (isset($proxy)) {
            curl_setopt($curl, CURLOPT_PROXY, $proxy);
        }

        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'Content-Type: multipart/form-data; boundary=' . $delimiter,
            'Content-Length: ' . strlen($data),
            'Authorization: Bearer ' . $token . '',
            $customId . $pdf . $email
        ));
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

        $response = curl_exec($curl);
        $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $err = curl_error($curl);
        curl_close($curl);

        if ($err) {
            throw new Exception("cURL Error #:" . $err);
        } else {
            if ($httpcode < 500)
                return json_decode($response);
            else
                throw new Exception("cUrl Error, HTTPCode: $httpcode, Response: $response");
        }
    }
    public static function sendSoapReq($urlRetention, $xmlRetencion, $tokenAutenticacion, $soapAction)
    {
        $curl = curl_init();
        $action = ($soapAction === 'v1') ? 'http://tempuri.org/IwcfTimbradoRetenciones/TimbrarRetencionXML' :
            'http://tempuri.org/IwcfTimbradoRetenciones/TimbrarRetencionXMLV2';
        curl_setopt_array($curl, array(
            CURLOPT_URL => $urlRetention,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:tem="http://tempuri.org/">
            <soapenv:Header/>
            <soapenv:Body>
                <tem:TimbrarRetencionXML>
                    <tem:xmlRetencion><![CDATA[' . $xmlRetencion . ']]></tem:xmlRetencion>
                    <tem:tokenAutenticacion>' . $tokenAutenticacion . '</tem:tokenAutenticacion>
                </tem:TimbrarRetencionXML>
            </soapenv:Body>
        </soapenv:Envelope>',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: text/xml; charset=utf-8',
                'SOAPAction: ' . $action . ''
            ),
        ));
        $response = curl_exec($curl);
        $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $err = curl_error($curl);
        curl_close($curl);
        if ($err) {
            throw new Exception("cURL Error #:" . $err);
        } else {
            if ($httpcode < 500) {
                $xml = new SimpleXMLElement($response);
                $data = [
                    'TimbrarRetencionXMLResult' => (string) $xml->xpath('//TimbrarRetencionXMLResponse/TimbrarRetencionXMLResult')[0],
                ];

                return json_encode($data);
            } else {
                //$ex =  new Exception("cUrl Error, HTTPCode: $httpcode, Response: $response");
                return Response::handleSoapError($response);
            }

        }
    }
}
?>