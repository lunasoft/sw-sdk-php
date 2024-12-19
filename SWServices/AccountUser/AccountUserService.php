<?php

namespace SWServices\AccountUser;

use SWServices\AccountUser\AccountUserRequest as accountUserRequest;
use SWServices\Services as Services;
use Exception;


class AccountUserService extends Services
{
    public function __construct($params)
    {
        parent::__construct($params);
    }
    public static function Set($params)
    {
        return new AccountUserService($params);
    }
    //Función para crear un usuario
    public static function CreateUser($data)
    {
        return AccountUserRequest::sendReqServicesUser(null, $data, "POST");
    }
    //Función para consultar usuario por token
    public static function GetUser()
    {
        return AccountUserRequest::sendReqGetUser();
    }
    //Función para consultar usuarios
    public static function GetAllUser()
    {
        return AccountUserRequest::sendReqGetUsers();
    }
    //Función para consultar usuario por ID
    public static function GetUserById($idUser)
    {
        return AccountUserRequest::sendReqGetUser($idUser);
    }
    //Función para actualizar usuario
    public static function UpdateUser($idUser, $data)
    {
        return AccountUserRequest::sendReqServicesUser($idUser, $data, "PUT");
    }
    //Función para eliminar usuario
    public static function DeleteUser($idUser)
    {
        return AccountUserRequest::sendReqServicesUser($idUser, null, "DELETE");
    }
}
