<?php
    require_once 'vendor/autoload.php';

    use SWServices\Stamp\StampService as StampService;

    try{
        header('Content-type: application/json');

        $params = array(
            "url"=>"http://services.test.sw.com.mx",
            "user"=>"demo",
            "password"=> "123456789"
            );
        $xml = file_get_contents('./file.xml');
        $stamp = StampService::Set($params);
        $result = $stamp::StampV1($xml);
        var_dump($result);
    }
    catch(Exception $e){
        header('Content-type: text/plain');
        echo 'Caught exception: ',  $e->getMessage(), "\n";
    }
?>