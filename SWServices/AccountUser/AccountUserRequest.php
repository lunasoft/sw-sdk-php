<?php

namespace SWServices\AccountUser;

use SWServices\Helpers\RequestHelper as HttpRequest;
use Exception;
use SWServices\Services;

class AccountUserRequest
{

    public static function sendReqCreateUser($data, $action)
    {
        $path = "/management/v2/api/dealers/users";
        return HttpRequest::sendRequest(Services::get_urlApi(), $action, $path, Services::get_token(), $data, Services::get_proxy());
    }

    public static function sendReqUpdateUser($id, $data, $action)
    {
        $path = "/management/v2/api/dealers/users/" . $id;
        return HttpRequest::sendRequest(Services::get_urlApi(), $action, $path, Services::get_token(), $data, Services::get_proxy());
    }

    public static function sendReqDeleteteUser($id, $action)
    {
        $path = "/management/v2/api/dealers/users/" . $id;
        return HttpRequest::sendRequest(Services::get_urlApi(), $action, $path, Services::get_token(), null, Services::get_proxy());
    }

    public static function sendReqGetUser($data, $action)
    {
        $path = "/management/v2/api/dealers/users";

        $processedData = array_map(function ($value) {
            if (is_bool($value)) {
                return $value ? 'true' : 'false';
            }
            return $value;
        }, $data);

        if (!empty($processedData)) {
            $queryString = http_build_query(array_filter($processedData, function ($value) {
                return $value !== null;
            }));
            if (!empty($queryString)) {
                $path .= '?' . $queryString;
            }
        }

        return HttpRequest::sendRequest(Services::get_urlApi(), $action, $path, Services::get_token(), null, Services::get_proxy());
    }
}
