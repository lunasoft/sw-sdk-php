<?php

namespace SWServices\AccountUser;
use SWServices\Helpers\RequestHelper as HttpRequest;
use Exception;
use SWServices\Services;

class AccountUserRequest{
    public static function sendReqGetUsers() {
        $action = "GET";
        return HttpRequest::sendRequest(Services::get_urlApi(), $action, "/management/api/users", Services::get_token(), null, Services::get_proxy());
    }
    public static function sendReqGetUser($idUser=null) {
        $path = '/management/api/users' . ($idUser ? "/$idUser" : "/info");
        $action = "GET";
        return HttpRequest::sendRequest(Services::get_urlApi(), $action, $path,Services::get_token(), null, Services::get_proxy());
    }

    public static function sendReqServicesUser($idUser, $data, $action)
    {
        $path ='/management/api/users/' . $idUser;
        return HttpRequest::sendRequest(Services::get_urlApi(), $action, $path,Services::get_token(), $data, Services::get_proxy());
    }

}

?>