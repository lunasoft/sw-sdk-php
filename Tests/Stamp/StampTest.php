<?php

require_once '../../SWSDK.php';

use SWServices\Stamp\StampService as StampService;

	$params = array(
	"url"=>"http://services.test.sw.com.mx",
	"token"=>"T2lYQ0t4L0RHVkR4dHZ5Nkk1VHNEakZ3Y0J4Nk9GODZuRyt4cE1wVm5tbXB3YVZxTHdOdHAwVXY2NTdJb1hkREtXTzE3dk9pMmdMdkFDR2xFWFVPUXpTUm9mTG1ySXdZbFNja3FRa0RlYURqbzdzdlI2UUx1WGJiKzViUWY2dnZGbFloUDJ6RjhFTGF4M1BySnJ4cHF0YjUvbmRyWWpjTkVLN3ppd3RxL0dJPQ.T2lYQ0t4L0RHVkR4dHZ5Nkk1VHNEakZ3Y0J4Nk9GODZuRyt4cE1wVm5tbFlVcU92YUJTZWlHU3pER1kySnlXRTF4alNUS0ZWcUlVS0NhelhqaXdnWTRncklVSWVvZlFZMWNyUjVxYUFxMWFxcStUL1IzdGpHRTJqdS9Zakw2UGRiMTFPRlV3a2kyOWI5WUZHWk85ODJtU0M2UlJEUkFTVXhYTDNKZVdhOXIySE1tUVlFdm1jN3kvRStBQlpLRi9NeWJrd0R3clhpYWJrVUMwV0Mwd3FhUXdpUFF5NW5PN3J5cklMb0FETHlxVFRtRW16UW5ZVjAwUjdCa2g0Yk1iTExCeXJkVDRhMGMxOUZ1YWlIUWRRVC8yalFTNUczZXdvWlF0cSt2UW0waFZKY2gyaW5jeElydXN3clNPUDNvU1J2dm9weHBTSlZYNU9aaGsvalpQMUxrUndzK0dHS2dpTittY1JmR3o2M3NqNkh4MW9KVXMvUHhZYzVLQS9UK2E1SVhEZFJKYWx4ZmlEWDFuSXlqc2ZRYXlUQk1ldlZkU2tEdU10NFVMdHZKUURLblBxakw0SDl5bUxabDFLNmNPbEp6b3Jtd2Q1V2htRHlTdDZ6eTFRdUNnYnVvK2tuVUdhMmwrVWRCZi9rQkU9.7k2gVCGSZKLzJK5Ky3Nr5tKxvGSJhL13Q8W-YhT0uIo"
	);
	$xml = file_get_contents('../Resources/file.xml');

	//Call Test

	StampXMLV1();
	StampXMLV1byToken();

function StampXMLV1(){
	$method = "StampXMLV1 ";
	echo $method;
	$resultSpect = "success";
	$params = array(
	    "url"=>"http://services.test.sw.com.mx",
	    "user"=>"demo",
	    "password"=> "12345678A"
		);
	$xml = $GLOBALS["xml"];

	try{
		$stamp = StampService::Set($params);
		$result = $stamp::StampV1($xml);
		
		if ($result->status === $resultSpect)
		{
			$status = 'OK';
		}else
		{
			$status = 'FAIL'.$result->message;
		}
	}
	catch(Exception $e){
		echo 'Caught exception: ',  $e->getMessage(), "\n".$method;
	}

	echo "<b>[".$status."]</b></br>";
}

function StampXMLV1byToken(){
	$method = "StampXMLV1byToken ";
	echo $method;
	$resultSpect = "success";
	$params = $GLOBALS["params"];
	$xml = $GLOBALS["xml"];
	try{
		$stamp = StampService::Set($params);
		$result = $stamp::StampV1($xml);
		
		if ($result->status === $resultSpect)
		{
			$status = 'OK';
		}else
		{
			$status = 'FAIL'.$result->message;
		}
	}
	catch(Exception $e){
		echo 'Caught exception: ',  $e->getMessage(), "\n".$method;
	}

	echo "<b>[".$status."]</b></br>";
}


?>