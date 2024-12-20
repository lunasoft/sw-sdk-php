<?php

namespace SWServices\AccountBalance;

use SWServices\AccountBalance\AccountBalanceRequest as accountBalanceRequest;
use SWServices\Services as Services;
use Exception;

class AccountBalanceService extends Services
{
    public function __construct($params)
    {
        parent::__construct($params);
    }
    public static function Set($params)
    {
        return new AccountBalanceService($params);
    }
    //Método público para obtener el Balance por Token
    public static function GetAccountBalance()
    {
        return accountBalanceRequest::getBalanceByTokenRequest(Services::get_urlApi(), Services::get_token(), Services::get_proxy());
    }
    //Método público para añadir timbres
    public static function AddStamps($id, $stamps, $comment = null)
    {
        return accountBalanceRequest::distributionStampRequest(Services::get_urlApi(), Services::get_token(), "POST", $id, $stamps, $comment, Services::get_proxy());
    }
    //Método público para eliminar timbres
    public static function RemoveStamps($id, $stamps, $comment = null)
    {
        return accountBalanceRequest::distributionStampRequest(Services::get_urlApi(), Services::get_token(), "DELETE", $id, $stamps, $comment, Services::get_proxy());
    }
}
