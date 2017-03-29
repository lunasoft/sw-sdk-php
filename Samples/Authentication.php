<?php
require_once 'vendor/autoload.php';

use SWServices\Authentication\AuthenticationService as Authentication;


$params = array(
    "url"=>"http://services.test.sw.com.mx",
    "user"=>"demo",
    "password"=> "12345678A"
);
try{
    $auth = Authentication::auth($params);
$token = $auth::Token();
header('Content-type: application/json');

echo $token;

}
catch(Exception $e){
    header('Content-type: text/plain');
    echo 'Caught exception: ',  $e->getMessage(), "\n";
}




?>