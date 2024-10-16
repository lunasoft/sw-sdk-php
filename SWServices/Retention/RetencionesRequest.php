<?php

namespace SWServices\Retention;

use SWServices\Retention\RetencionesHelper as Response;
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

        return self::processSoapResponse($responseSoap, $soapAction);
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

    private static function processSoapResponse(string $responseSoap, string $version)
    {
        $responseXml = simplexml_load_string($responseSoap);
        if ($responseXml === false) {
            return Response::handleSoapError($responseSoap);
        }

        $namespaces = $responseXml->getNamespaces(true);
        $body = $responseXml->children($namespaces['s'])->Body;

        $decodedCfdi = self::getDecodedCfdi($body, $namespaces, $version);

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

    private static function getDecodedCfdi(SimpleXMLElement $body, array $namespaces, string $version): string
    {
        if ($version === 'v1') {
            return (string) $body->children($namespaces[''])->TimbrarRetencionXMLResponse->TimbrarRetencionXMLResult;
        } else {
            return (string) $body->children($namespaces[''])->TimbrarRetencionXMLV2Response->TimbrarRetencionXMLV2Result;
        }
    }

    private static function buildResponseData(SimpleXMLElement $tfd, SimpleXMLElement $retenciones, string $cfdi)
    {

        $tfdXML = $tfd->asXML();
        $tfdNode = $tfd->xpath('//tfd:TimbreFiscalDigital')[0] ?? null;
        $retencionesNode = $retenciones->xpath('//retenciones:Retenciones')[0] ?? null;

        if ($tfdNode === null || $retencionesNode === null) {
            throw new Exception("Nodo TFD o Retenciones no encontrado en el CFDI.");
        }
        $cadenaOriginal = self::generateOriginalChain($tfd);

        return [
            'data' => [
                'cadenaOriginalSAT' => $cadenaOriginal,
                'noCertificadoSAT' => (string)$tfdNode['NoCertificadoSAT'],
                'noCertificadoCFDI' => (string)$retencionesNode['NoCertificado'] ?? '',
                'uuid' => (string)$tfdNode['UUID'],
                'selloSAT' => (string)$tfdNode['SelloSAT'],
                'selloCFDI' => (string)$retencionesNode['Sello'] ?? (string)$tfdNode['SelloCFD'],
                'fechaTimbrado' => (string)$tfdNode['FechaTimbrado'],
                'qrCode' => '',
                'cfdi' => htmlspecialchars($cfdi, ENT_QUOTES | ENT_XML1) ?? htmlspecialchars($tfdXML, ENT_QUOTES | ENT_XML1),
            ],
            'status' => 'success',
        ];
    }

    private static function generateOriginalChain(SimpleXMLElement $tfd)
    {
        $tfdNode = $tfd->xpath('//tfd:TimbreFiscalDigital')[0] ?? null;

        if ($tfdNode === null) {
            return '';
        }

        $attributes = [
            'version' => '||'. (string)$tfdNode['Version'],
            'uuid' => '|' . (string)$tfdNode['UUID'],
            'fechaTimbrado' => '|' . (string)$tfdNode['FechaTimbrado'],
            'rfcProv' => '|' . (string)$tfdNode['RfcProvCertif'],
            'selloCFD' => '|' . (string)$tfdNode['SelloCFD'],
            'noCertSat' => '|' . (string)$tfdNode['NoCertificadoSAT'],
        ];

        $cadenaOriginal = implode('', $attributes);
        return $cadenaOriginal;
    }
}
