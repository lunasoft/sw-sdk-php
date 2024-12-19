<?php

namespace SWServices\AccountUser;

use SWServices\AccountUser\AccountUserRequest as accountUserRequest;
use SWServices\Services as Services;
use Exception;

/**
 * Clase AccountUserService
 * 
 * Consumo de los métodos de la API Usuarios.
 */
class AccountUserService extends Services
{
    public function __construct($params)
    {
        parent::__construct($params);
    }

    /**
     * Inicializa AccountUserService.
     *
     */
    public static function Set($params)
    {
        return new AccountUserService($params);
    }

    /**
     * Servicio que permite crear un nuevo usuario.
     *
     * @param array $data Datos del usuario a crear.
     */
    public static function CreateUser($data)
    {
        return AccountUserRequest::sendReqCreateUser($data, "POST");
    }

    /**
     * Servicio que actualiza un usuario existente.
     *
     * @param string $id Id del usuario a actualizar.
     * @param array $data Datos a actualizar del usuario.
     */
    public static function UpdateUser($id, $data)
    {
        return AccountUserRequest::sendReqUpdateUser($id, $data, "PUT");
    }

    /**
     * Servicio que elimina un usuario.
     *
     * @param string $id Id del usuario a eliminar.
     */
    public static function DeleteUser($id)
    {
        return AccountUserRequest::sendReqDeleteteUser($id, "DELETE");
    }

    /**
     * Servicio que obtiene información de usuario(s).
     *
     * @param array $data Filtros o parámetros de búsqueda (opcionales).
     */
    public static function GetUser($data)
    {
        return AccountUserRequest::sendReqGetUser($data, "GET");
    }
}
