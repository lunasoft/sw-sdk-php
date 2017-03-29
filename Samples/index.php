<?php
require_once 'vendor/autoload.php';

use SWServices\Authentication\AuthenticationService as Authentication;
use SWServices\Stamp\StampService as StampService;

$params = array(
    "url"=>"http://services.test.sw.com.mx",
    "user"=>"demo",
    "password"=> "12345678A"
);
try{
    $auth = Authentication::auth($params);
    $token = $auth::Token();
    $parse_token = json_decode($token, true);

    $paramsStamp = array(
				"url"=>"http://services.test.sw.com.mx",
				"token"=>$parse_token['data']['token']
				);
    
    $xml = file_get_contents('./file.xml');
			
    $stamp = StampService::Set($paramsStamp);
     $result = $stamp::StampV1($xml);
    header('Content-type: application/json');
    echo $result;
   
}
catch(Exception $e){
    header('Content-type: text/plain');
    echo 'Caught exception: ',  $e->getMessage(), "\n";
}




?>