<?php 
	require_once 'vendor/autoload.php';
    use SWServices\Toolkit\SealService as Sellar;

    $params = array(
	    "cadenaOriginal"=> "'./cadenaOriginal.txt'",
	    "archivoKeyPem"=> "./key.pem",
	    "archivoCerPem"=> "./cer.pem"
    );

    try {
        $result = Sellar::obtenerSello($params);
        var_dump($result);
    } catch(Exception $e) {
        echo 'Caught exception: ',  $e->getMessage(), "\n";
    }
    
?>