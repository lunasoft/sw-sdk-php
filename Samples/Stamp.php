<?php
    include('../SWSDK.php');
    use SWServices\Stamp\StampService as StampService;

    $params = array(
	      "url"=>"https://services.test.sw.com.mx",
	      "token"=>getenv('SW_TOKEN') ?: 'TU_TOKEN'
	  );

    try
    {
        header('Content-type: application/json');
        $xml = file_get_contents('./file.xml');
        $stamp = StampService::Set($params);
        $result = $stamp::StampV4($xml);
        echo json_encode($result);
    }
    catch(Exception $e)
    {
        header('Content-type: text/plain');
        echo $e->getMessage();
    }
?>