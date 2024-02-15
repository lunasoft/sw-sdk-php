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
    public static function CreateUser($email, $password, $name, $rfc, $profile, $stamps, $unlimited, $active){
        $data = array(
            'Email' => $email,
            'Pasword' => $password,
            'Name' => $password,
            'RFC' => $password,
            'Profile' => $password,
            'Stamps' => $password,
            'Unlimited' => $unlimited,
            'Active' => $password
        );
    }
    //Función para consultar usuario por token
    public static function GetUserByToken(){
        return AccountUserRequest::sendReqGetUser();
    }
    //Función para consultar usuarios
    public static function GetAllUser(){
        return AccountUserRequest::sendReqGetUsers();
    }
     //Función para consultar usuario por ID
    public static function GetUserById($idUser){
        return AccountUserRequest::sendReqGetUser($idUser);
    }
    //Función para actualizar usuario
    public static function UpdateUser($idUser, $rfc, $name, $unlimited){
        $data = array(
            'RFC' => $rfc,
            'Name' => $name,
            'Unlimited' => $unlimited
        );
        return AccountUserRequest::sendReqServicesUser($idUser, $data, "update",);
    }
    //Función para eliminar usuario
    public static function DeleteUser($idUser){
        return AccountUserRequest::sendReqServicesUser($idUser, null, "delete");
    }
}
?>
