<?php

namespace SWServices\Stamp;


use SWServices\Services as Services;
use SWServices\Stamp\StampRequest as stampRequest;


class StampService extends Services{
    public function __construct($params) {
        parent::__construct($params);
    }

    public static function Set($params){
        return new StampService($params);
    }
    public static function StampV1($xml){
        return stampRequest::sendReq(Services::get_url(), Services::get_token(), $xml);
    }
}


?>