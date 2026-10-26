<?php 
namespace SWServices\Helpers;

class ResponseHelper { 
    protected static function toErrorResponse($message, $messageDetail = ""){
        $response = json_encode(array_merge(
            array(
                "status"=> "error",
                "message"=> $message,
                "messageDetail"=> $messageDetail
            ))
        );
        return json_decode($response);
    }
    protected static function handleException($ex){
        $debug = class_exists('SWServices\\Services', false) && \SWServices\Services::get_debug();
        return ResponseHelper::ToErrorResponse($ex->getMessage(), $debug ? $ex->getTraceAsString() : '');
    }
}
?>