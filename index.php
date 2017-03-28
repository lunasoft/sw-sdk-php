<?php

require_once 'SWSDK.php';

use SWServices\Authentication\AuthenticationService as Authentication;

$params = array(
    "url"=>"http://services.test.sw.com.mx",
    "user"=>"demo",
    "password"=> "12345678A"
);

Authentication::auth($params);


?>