<?php

namespace SWServices\Retention;

use SWServices\Retention\RetencionesHelper as Response;
use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;
use DOMDocument;
use DOMXPath;
use SimpleXMLElement;
use Exception;

class RetencionesRequest
{
    private const XMLNS_TFD = 'http://www.sat.gob.mx/TimbreFiscalDigital';
    private const XMLNS_RETENTION = 'http://www.sat.gob.mx/esquemas/retencionpago/2';
    private const URL_QR = 'https://prodretencionverificacion.clouda.sat.gob.mx?';
    private const PATH_STAMP = '/retencion/stamp/';

    public static function sendReq($url, $token, $xml, $version, $isB64)
    {
        $protocols = [
            CURL_SSLVERSION_TLSv1_2,
            CURL_SSLVERSION_TLSv1_3
        ];

        if ($url === '' || $token === '' || $xml === '') {
            return Response::toErrorResponse('Parámetros inválidos', 'url/token/xml requerido');
        }

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
            $data .= 'Content-Disposition: form-data; name="' . $name . '"; filename="' . $name . '"' . "\r\n";
            $data .= 'Content-Type: ' . $file['type'] . "\r\n";
            $data .= "\r\n";
            $data .= $file['content'] . "\r\n";
        }
        $data .= "--" . $delimiter . "--\r\n";

        $endpoint = $url . rtrim(self::PATH_STAMP, '/') . '/' . $version . ($isB64 ? '/b64' : '');

        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => $endpoint,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $data,
            CURLOPT_HTTPHEADER => [
                'Content-Type: multipart/form-data; boundary=' . $delimiter,
                'Content-Length: ' . strlen($data),
                'Authorization: Bearer ' . $token,
            ],
            CURLOPT_SSLVERSION => $protocols,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_SSL_VERIFYHOST => 0
        ]);

        $response = curl_exec($curl);
        $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $err = curl_error($curl);
        curl_close($curl);

        if ($err) {
            return Response::toErrorResponse('Error de conexión', $err);
        }
        if ($httpcode >= 500) {
            return Response::toErrorResponse('Error HTTP', "HTTPCode: $httpcode, Response: " . substr((string)$response, 0, 500));
        }

        $decoded = json_decode($response, true);
        if (!is_array($decoded)) {
            return Response::toErrorResponse('Respuesta no es JSON', substr((string)$response, 0, 500));
        }

        return json_encode($decoded, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
    }

    public static function normalizeFromRest($rawJson)
    {
        $json = json_decode($rawJson, true);
        if (!is_array($json)) {
            return Response::toErrorResponse('Respuesta no es JSON', substr((string)$rawJson, 0, 500));
        }
        if (($json['status'] ?? '') !== 'success') {
            if (!array_key_exists('data', $json)) {
                $json['data'] = null;
            }
            return json_encode($json, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
        }

        $cfdi = $json['data']['retencion'] ?? null;
        if (empty($cfdi)) {
            return Response::toErrorResponse('Falta data.retencion en respuesta REST', '');
        }

        try {
            $tfd = simplexml_load_string($cfdi);
            if ($tfd === false) {
                return Response::toErrorResponse('No se pudo cargar XML de data.retencion', '');
            }
            $tfd->registerXPathNamespace('tfd', self::XMLNS_TFD);
            $tfd->registerXPathNamespace('retenciones', self::XMLNS_RETENTION);

            $retenciones = $tfd;
            $normalized = self::buildResponseData($tfd, $retenciones, $cfdi);
            return json_encode($normalized, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
        } catch (Exception $e) {
            return Response::toErrorResponse('Error al normalizar', $e->getMessage());
        }
    }

    private static function buildResponseData(SimpleXMLElement $tfd, SimpleXMLElement $retenciones, string $cfdi)
    {
        $tfdNode = $tfd->xpath('//tfd:TimbreFiscalDigital')[0] ?? null;
        $retNode = $retenciones->xpath('//retenciones:Retenciones')[0] ?? null;
        if ($tfdNode === null || $retNode === null) {
            throw new Exception('Nodo TFD o Retenciones no encontrado');
        }

        $cadenaOriginal = self::generateOriginalChain($tfd);
        $qrCode = self::generateQR($cfdi);

        return [
            'data' => [
                'cadenaOriginalSAT' => $cadenaOriginal,
                'noCertificadoSAT' => (string)$tfdNode['NoCertificadoSAT'],
                'noCertificadoCFDI' => (string)$retNode['NoCertificado'] ?? '',
                'uuid' => (string)$tfdNode['UUID'],
                'selloSAT' => (string)$tfdNode['SelloSAT'],
                'selloCFDI' => (string)$retNode['Sello'] ?? (string)$tfdNode['SelloCFD'],
                'fechaTimbrado' => (string)$tfdNode['FechaTimbrado'],
                'qrCode' => $qrCode,
                'cfdi' => htmlspecialchars($cfdi, ENT_QUOTES | ENT_XML1),
            ],
            'status' => 'success',
        ];
    }

    private static function generateOriginalChain(SimpleXMLElement $tfd)
    {
        $tfdNode = $tfd->xpath('//tfd:TimbreFiscalDigital')[0] ?? null;
        if ($tfdNode === null) {
            throw new Exception('Nodo TFD no encontrado');
        }

        $version = (string)$tfdNode['Version'];
        $uuid = (string)$tfdNode['UUID'];
        $fecha = (string)$tfdNode['FechaTimbrado'];
        $rfcProv = (string)$tfdNode['RfcProvCertif'];
        $selloCFD = (string)$tfdNode['SelloCFD'];
        $certSAT = (string)$tfdNode['NoCertificadoSAT'];

        return "||{$version}|{$uuid}|{$fecha}|{$rfcProv}|{$selloCFD}|{$certSAT}||";
    }

    private static function generateQR(string $cfdi)
    {
        try {
            $dom = new DOMDocument();
            $dom->loadXML($cfdi);
            $xp = new DOMXPath($dom);
            $xp->registerNamespace('retenciones', self::XMLNS_RETENTION);
            $xp->registerNamespace('tfd', self::XMLNS_TFD);

            $uuid = $xp->evaluate('string(//tfd:TimbreFiscalDigital/@UUID)');
            $rfcE = $xp->evaluate('string(//retenciones:Emisor/@RfcE)');
            $nac = $xp->evaluate('string(//retenciones:Receptor/@Nacionalidad)');
            $rfcR = ($nac === 'Nacional') ?
                $xp->evaluate('string(//retenciones:Nacional/@RfcR)') :
                $xp->evaluate('string(//retenciones:Extranjero/@NumRegIdTribR)');
            $tt = $xp->evaluate('string(//retenciones:Totales/@MontoTotRet)');
            $fe = substr($xp->evaluate('string(//retenciones:Retenciones/@Certificado)'), -8);

            $params = 'id=' . $uuid . '&re=' . $rfcE . '&rr=' . $rfcR . '&tt=' . $tt . '&fe=' . $fe;

            $options = new QROptions([
                'outputType' => QRCode::OUTPUT_IMAGE_PNG,
                'eccLevel' => QRCode::ECC_L,
                'scale' => 5,
            ]);

            $img = (new QRCode($options))->render(self::URL_QR . $params);
            return str_replace('data:image/png;base64,', '', $img);
        } catch (Exception $e) {
            return '';
        }
    }
}
