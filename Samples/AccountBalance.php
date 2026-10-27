<?php
	include('../SWSDK.php');
	use SWServices\AccountBalance\AccountBalanceService as AccountBalanceService;

	$params = array(
		
		'urlApi'=> 'https://api.test.sw.com.mx',
		'token'=> getenv('SW_TOKEN') ?: 'TU_TOKEN',
	);

	try {
		$accountBalance = AccountBalanceService::Set($params);
		$result = $accountBalance::GetAccountBalance();
		header('Content-type: application/json');
		echo json_encode($result);
	} catch(Exception $e) {
		echo 'Caught exception: ',  $e->getMessage(), "\n";
	}
?>