<?php
namespace SWServices\Helpers;
use SimpleXMLElement;
use Exception;

class ResponseHelper
{
    protected static function toErrorResponse($message, $messageDetail = "")
    {
        $response = json_encode(
            array_merge(
                array(
                    "status" => "error",
                    "message" => $message,
                    "messageDetail" => $messageDetail
                )
            )
        );
        return json_decode($response);
    }
    protected static function handleException($ex)
    {
        return ResponseHelper::ToErrorResponse($ex->getMessage(), $ex->getTraceAsString());
    }
    public static function handleSoapError($soapResponse)
    {
        $errorMessage = "";
        $messageDetail = "";

        try {

            $xml = new SimpleXMLElement($soapResponse, LIBXML_NOCDATA);
            $fault = $xml->xpath('//s:Fault');
            if (!empty($fault)) {
                $faultcode = (string) $fault[0]->faultcode;
                $faultstring = (string) $fault[0]->faultstring;
                $errorMessage = "SOAP Fault: $faultcode - $faultstring";
                $detail = $fault[0]->detail;
                if (!empty($detail)) {
                    $messageDetail = (string) $detail->children()->Message;
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
?>