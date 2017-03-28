<?php

require_once 'SWSDK.php';

use SWServices\Authentication\AuthenticationService as Authentication;

$params = array(
    "url"=>"http://services.test.sw.com.mx",
    "user"=>"demo",
    "password"=> "12345678A"
);
try{
    $auth = Authentication::auth($params);
$token = $auth::Token();
header('Content-type: text/plain');

echo $token;
}
catch(Exception $e){
    echo 'Caught exception: ',  $e->getMessage(), "\n";
}



?>