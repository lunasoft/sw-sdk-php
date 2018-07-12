<?php
	include('../SWSDK.php');
	use SWServices\Authentication\AuthenticationService as Authentication;
	
  $params = array(
		"proxy"=>"localhost:8888",
	    "url"=>"http://services.test.sw.com.mx",
	    "user"=>"demo",
	    "password"=> "123456789"
	);
	
	try {
	    $auth = Authentication::auth($params);
		$result = $auth::Token();
		header('Content-type: text/plain');
		if($result->status == "success") {
			echo $result->data->token;
		} else { //lógica de error independiente para cada proyecto
			echo $result->message;
		}
	} catch(Exception $e){
	    echo 'Caught exception: ',  $e->getMessage(), "\n";
	}

?>