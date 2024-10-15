<?php

namespace SWServices\Retention;

use SWServices\Helpers\ResponseHelper as Response;
use SimpleXMLElement;
use Exception;

class RetencionesRequest
{
    private const SOAP_ACTION_V1 = 'http://tempuri.org/IwcfTimbradoRetenciones/TimbrarRetencionXML';
    private const SOAP_ACTION_V2 = 'http://tempuri.org/IwcfTimbradoRetenciones/TimbrarRetencionXMLV2';
    private const XMLNS_TFD = 'http://www.sat.gob.mx/TimbreFiscalDigital';
    private const XMLNS_RETENTION = 'http://www.sat.gob.mx/esquemas/retencionpago/2';
    private const TEM_RETENTION_V1 = 'TimbrarRetencionXML';
    private const TEM_RETENTION_V2 = 'TimbrarRetencionXMLV2';

    public static function sendSoapReq(string $urlRetention, string $tokenAutenticacion, string $xmlRetencion, string $soapAction)
    {
        $curl = curl_init();
        $action = ($soapAction === 'v1') ? self::SOAP_ACTION_V1 : self::SOAP_ACTION_V2;

        curl_setopt_array($curl, [
            CURLOPT_URL => $urlRetention,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => self::createSoapRequest($xmlRetencion, $tokenAutenticacion, $soapAction),
            CURLOPT_HTTPHEADER => [
                'Content-Type: text/xml; charset=utf-8',
                'SOAPAction: ' . $action,
            ],
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_TIMEOUT => 0,
        ]);

        $responseSoap = curl_exec($curl);
        $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $err = curl_error($curl);
        curl_close($curl);

        if ($err) {
            return Response::handleSoapError($err);
        }

        if ($httpcode >= 500) {
            return Response::handleSoapError($responseSoap);
        }

        return self::processSoapResponse($responseSoap);
    }

    private static function createSoapRequest(string $xmlRetencion, string $tokenAutenticacion, string $version)
    {
        $tem = ($version === 'v1') ? self::TEM_RETENTION_V1 : self::TEM_RETENTION_V2;

        return '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:tem="http://tempuri.org/">
            <soapenv:Header/>
            <soapenv:Body>
                <tem:' . $tem . '>
                    <tem:xmlRetencion><![CDATA[' . $xmlRetencion . ']]></tem:xmlRetencion>
                    <tem:tokenAutenticacion>' . $tokenAutenticacion . '</tem:tokenAutenticacion>
                </tem:' . $tem . '>
            </soapenv:Body>
        </soapenv:Envelope>';
    }

    private static function processSoapResponse(string $responseSoap)
    {
        $responseXml = simplexml_load_string($responseSoap);
        if ($responseXml === false) {
            throw new Exception("Failed to parse XML response.");
        }

        $namespaces = $responseXml->getNamespaces(true);
        $body = $responseXml->children($namespaces['s'])->Body;
        $decodedCfdi = $body->children($namespaces[''])->TimbrarRetencionXMLResponse->TimbrarRetencionXMLResult;
        $cfdi = htmlspecialchars_decode($decodedCfdi);

        $tfdDecoded = self::loadXmlWithNamespace($cfdi, self::XMLNS_TFD);
        $retentionDecoded = self::loadXmlWithNamespace($cfdi, self::XMLNS_RETENTION);

        return json_encode(self::buildResponseData($tfdDecoded, $retentionDecoded, $cfdi), JSON_PRETTY_PRINT);
    }

    private static function loadXmlWithNamespace(string $xml, string $namespace)
    {
        $decoded = simplexml_load_string($xml);
        $decoded->registerXPathNamespace('tfd', $namespace);
        return $decoded;
    }

    private static function buildResponseData(SimpleXMLElement $tfd, SimpleXMLElement $retenciones, string $cfdi)
    {
        return [
            'data' => [
                'cadenaOriginalSAT' => '',
                'noCertificadoSAT' => (string)$tfd->xpath('//tfd:TimbreFiscalDigital')[0]['NoCertificadoSAT'],
                'noCertificadoCFDI' => (string)$retenciones->xpath('//retenciones:Retenciones')[0]['NoCertificado'],
                'uuid' => (string)$tfd->xpath('//tfd:TimbreFiscalDigital')[0]['UUID'],
                'selloSAT' => (string)$tfd->xpath('//tfd:TimbreFiscalDigital')[0]['SelloSAT'],
                'selloCFDI' => (string)$tfd->xpath('//tfd:TimbreFiscalDigital')[0]['SelloCFD'] ?? (string)$retenciones->xpath('//retenciones:Retenciones')[0]['Sello'],
                'fechaTimbrado' => (string)$tfd->xpath('//tfd:TimbreFiscalDigital')[0]['FechaTimbrado'],
                'qrCode' => '',
                'cfdi' => $cfdi,
            ],
            'status' => 'success',
        ];
    }
}
