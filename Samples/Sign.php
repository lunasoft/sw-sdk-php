<?php 
	require_once 'vendor/autoload.php';
    use SWServices\Toolkit\SignService as Sellar;

    $params = array(
	    "cadenaOriginal"=> "'./cadenaOriginal.txt'",
	    "archivoKeyPem"=> "./key.pem",
	    "archivoCerPem"=> "./cer.pem"
    );

    try {
        $result = Sellar::ObtenerSello($params);
        var_dump($result);
    } catch(Exception $e) {
        echo 'Caught exception: ',  $e->getMessage(), "\n";
    }
    
?>