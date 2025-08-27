<?php

namespace SWServices\Retention;

class RetencionesHelper
{
    public static function toErrorResponse($message, $messageDetail = "")
    {
        return json_encode([
            "message" => $message,
            "messageDetail" => $messageDetail,
            "data" => null,
            "status" => "error"
        ], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
    }

    public static function handleException($ex)
    {
        return self::toErrorResponse($ex->getMessage(), '');
    }
}
