<?php

namespace SWServices\Retention;

use SimpleXMLElement;
use Exception;

class RetencionesHelper
{
    protected static function toErrorResponse($message, $messageDetail = "")
    {
        $response = json_encode(
            array_merge(
                array(
                    "message" => $message,
                    "messageDetail" => $messageDetail,
                    "data" => null,
                    "status" => "error"
                )
            )
        );
        return $response;
    }
    protected static function handleException($ex)
    {
        return RetencionesHelper::ToErrorResponse($ex->getMessage(), $ex->getTraceAsString());
    }

    public static function handleSoapError($soapResponse)
    {
        $errorMessage = "";
        $messageDetail = "";

        try {
            $xml = new SimpleXMLElement($soapResponse, LIBXML_NOCDATA);
            $namespaces = $xml->getNamespaces(true);

            $fault = $xml->xpath('//s:Fault');
            if (!empty($fault)) {
                $faultstring = (string) $fault[0]->faultstring;
                $errorMessage = $faultstring;

                $detail = $fault[0]->detail;
                if (!empty($detail)) {
                    $exceptionDetail = $detail->children($namespaces[''])->ExceptionDetail;
                    if (!empty($exceptionDetail)) {
                        $innerException = $exceptionDetail->InnerException;
                        if (!empty($innerException)) {
                            $messageDetail = (string) $innerException->Message;
                        }
                    }
                }
            } else {
                $errorMessage = "Unknown SOAP Error";
            }
        } catch (Exception $e) {
            $errorMessage = "Error parsing SOAP response: " . $e->getMessage();
        }
        return self::toErrorResponse($errorMessage, $messageDetail);
    }
}
