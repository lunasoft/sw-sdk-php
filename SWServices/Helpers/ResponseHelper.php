<?php 

namespace SWServices\Helpers;

class ResponseHelper { 
    protected static function ToErrorResponse($message, $messageDetail = ""){
        $response = json_encode(array_merge(
            array(
                "status"=> "error",
                "message"=> $message,
                "messageDetail"=> $messageDetail
            ))
        );
        return json_decode($response);
    }
}
?>