<?php

namespace SWServices\Resend;

use Exception;
use SWServices\Services;
use SWServices\Helpers\RequestHelper as HttpRequest;
use SWServices\Helpers\ResponseHelper as Response;

class ResendRequest extends Services
{
    protected static function postResendEmail($uuid, $email)
    {
        try {
            if (!self::validateParams($uuid, $email)) {
                return Response::toErrorResponse("El UUID o los correos no son válidos.");
            }
            $data = json_encode(
                array_merge(
                    array(
                        "uuid" => $uuid,
                        "to" => implode(',', $email)
                    )
                )
            );
            return HttpRequest::postJson(Services::get_urlApi(), '/comprobante/resendemail', Services::get_token(), $data, Services::get_proxy());
        } catch (Exception $e) {
            return Response::handleException($e);
        }
    }
    private static function validateParams($uuid, $email)
    {
        if (is_null($uuid) || is_null($email)) {
            return false;
        }
        if (sizeof($email) > 1) {
            if (sizeof($email) > 5) {
                return false;
            }
            for ($i = 0; $i < sizeof($email); $i++) {
                if (!filter_var($email[$i], FILTER_VALIDATE_EMAIL)) {
                    return false;
                }
            }
        } else {
            if (!filter_var($email[0], FILTER_VALIDATE_EMAIL)) {
                return false;
            }
        }
        return true;
    }
}
