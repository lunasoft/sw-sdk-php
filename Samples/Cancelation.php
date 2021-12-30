<?php
    include('../SWSDK.php');
    use SWServices\Cancelation\CancelationService as CancelationService;

/* -------------------------------------------------------Cancelación UUID------------------------------------------------------- */
    $rfc="EKU9003173C9";
    $uuid="fe4e71b0-8959-4fb9-8091-f5ac4fb0fef8";
    $motivo="01";
    $foliosustitucion="0e4c30b8-11d8-40d8-894d-ef8b32eb4bdf";
    $params = array(
    "url"=>"http://services.test.sw.com.mx",  
    "token"=>" ",  
    "rfc"=>$rfc,
    "uuid"=>$uuid,
    "motivo"=>$motivo,
    "foliosustitucion"=>$foliosustitucion
    
    );
    
    try {
        header('Content-type: application/json');
        $cancelationService = CancelationService::Set($params);
        $result = $cancelationService::CancelationByUUID();
        echo json_encode($result);
    } catch(Exception $e) {
        header('Content-type: text/plain');
        echo $e->getMessage();
    }
/* -------------------------------------------------------Cancelación CSD-------------------------------------------------------- */

 $rfc="EKU9003173C9";
    $password="12345678a";
    $uuid="fe4e71b0-8959-4fb9-8091-f5ac4fb0fef8";
    $motivo="02";
    $foliosustitucion="0e4c30b8-11d8-40d8-894d-ef8b32eb4bdf";
    $b64Cer="MIIFuzCCA6OgAwIBAgIUMzAwMDEwMDAwMDA0MDAwMDI0MzQwDQYJKoZIhvcNAQELBQAwggErMQ8wDQYDVQQDDAZBQyBVQVQxLjAsBgNVBAoMJVNFUlZJQ0lPIERFIEFETUlOSVNUUkFDSU9OIFRSSUJVVEFSSUExGjAYBgNVBAsMEVNBVC1JRVMgQXV0aG9yaXR5MSgwJgYJKoZIhvcNAQkBFhlvc2Nhci5tYXJ0aW5lekBzYXQuZ29iLm14MR0wGwYDVQQJDBQzcmEgY2VycmFkYSBkZSBjYWRpejEOMAwGA1UEEQwFMDYzNzAxCzAJBgNVBAYTAk1YMRkwFwYDVQQIDBBDSVVEQUQgREUgTUVYSUNPMREwDwYDVQQHDAhDT1lPQUNBTjERMA8GA1UELRMIMi41LjQuNDUxJTAjBgkqhkiG9w0BCQITFnJlc3BvbnNhYmxlOiBBQ0RNQS1TQVQwHhcNMTkwNjE3MTk0NDE0WhcNMjMwNjE3MTk0NDE0WjCB4jEnMCUGA1UEAxMeRVNDVUVMQSBLRU1QRVIgVVJHQVRFIFNBIERFIENWMScwJQYDVQQpEx5FU0NVRUxBIEtFTVBFUiBVUkdBVEUgU0EgREUgQ1YxJzAlBgNVBAoTHkVTQ1VFTEEgS0VNUEVSIFVSR0FURSBTQSBERSBDVjElMCMGA1UELRMcRUtVOTAwMzE3M0M5IC8gWElRQjg5MTExNlFFNDEeMBwGA1UEBRMVIC8gWElRQjg5MTExNk1HUk1aUjA1MR4wHAYDVQQLExVFc2N1ZWxhIEtlbXBlciBVcmdhdGUwggEiMA0GCSqGSIb3DQEBAQUAA4IBDwAwggEKAoIBAQCN0peKpgfOL75iYRv1fqq+oVYsLPVUR/GibYmGKc9InHFy5lYF6OTYjnIIvmkOdRobbGlCUxORX/tLsl8Ya9gm6Yo7hHnODRBIDup3GISFzB/96R9K/MzYQOcscMIoBDARaycnLvy7FlMvO7/rlVnsSARxZRO8Kz8Zkksj2zpeYpjZIya/369+oGqQk1cTRkHo59JvJ4Tfbk/3iIyf4H/Ini9nBe9cYWo0MnKob7DDt/vsdi5tA8mMtA953LapNyCZIDCRQQlUGNgDqY9/8F5mUvVgkcczsIgGdvf9vMQPSf3jjCiKj7j6ucxl1+FwJWmbvgNmiaUR/0q4m2rm78lFAgMBAAGjHTAbMAwGA1UdEwEB/wQCMAAwCwYDVR0PBAQDAgbAMA0GCSqGSIb3DQEBCwUAA4ICAQBcpj1TjT4jiinIujIdAlFzE6kRwYJCnDG08zSp4kSnShjxADGEXH2chehKMV0FY7c4njA5eDGdA/G2OCTPvF5rpeCZP5Dw504RZkYDl2suRz+wa1sNBVpbnBJEK0fQcN3IftBwsgNFdFhUtCyw3lus1SSJbPxjLHS6FcZZ51YSeIfcNXOAuTqdimusaXq15GrSrCOkM6n2jfj2sMJYM2HXaXJ6rGTEgYmhYdwxWtil6RfZB+fGQ/H9I9WLnl4KTZUS6C9+NLHh4FPDhSk19fpS2S/56aqgFoGAkXAYt9Fy5ECaPcULIfJ1DEbsXKyRdCv3JY89+0MNkOdaDnsemS2o5Gl08zI4iYtt3L40gAZ60NPh31kVLnYNsmvfNxYyKp+AeJtDHyW9w7ftM0Hoi+BuRmcAQSKFV3pk8j51la+jrRBrAUv8blbRcQ5BiZUwJzHFEKIwTsRGoRyEx96sNnB03n6GTwjIGz92SmLdNl95r9rkvp+2m4S6q1lPuXaFg7DGBrXWC8iyqeWE2iobdwIIuXPTMVqQb12m1dAkJVRO5NdHnP/MpqOvOgLqoZBNHGyBg4Gqm4sCJHCxA1c8Elfa2RQTCk0tAzllL4vOnI1GHkGJn65xokGsaU4B4D36xh7eWrfj4/pgWHmtoDAYa8wzSwo2GVCZOs+mtEgOQB91/g==";
    $b64Key="MIIFDjBABgkqhkiG9w0BBQ0wMzAbBgkqhkiG9w0BBQwwDgQIAgEAAoIBAQACAggAMBQGCCqGSIb3DQMHBAgwggS8AgEAMASCBMh4EHl7aNSCaMDA1VlRoXCZ5UUmqErAbucRFLOMmsAaFNkyWR0dXIAh0CMjE6NpQIMZhQ0HH/4tHgmwh4kCawGjIwERoG6/IH3mCt7u19J5+m6gUEGOJdEMXj976E5lKCd/EG6t6lCq66GE3rgux/nFmeQZvsjLlzPyhe2j+X81LrGudITTjDdgLI0EdbdV9CUJwWbibzrVxjuAVShRh07XPL/DiEw3Wk2+kdy4cfWmMvh0U55p0RKZopNkWuVVSvr3ai7ZNCwHZWDVqkUDpwDDGdyt0kYQ7qoKanIxv/A9wv6ekq0LQ/yLlOcelkxQeb8Glu4RXe+krRvrASw1eBAQ3mvNKpngwF8vtlyoil41PjHUOKALMJtNpywckRRYOk4703ylWIzTfdBlrZ6VmDBjdC5723G1HAx3R/x+o+08++RNiFaN06Ly5QbZZvjnealDfSKz1VKRHWeXggaW87rl4n0SOOWnvabKs4ZWRXTS0dhWK+KD/yYYQypTslDSXQrmyMkpc1Zcb4p9RTjodXxGCWdsR5i5+Ro/RiJvxWwwaO3YW6eaSavV0ROqANQ+A+GizMlxsVjl6G5Ooh6ORdA7jTNWmK44Icgyz6QFNh+J3NibxVK2GZxsQRi+N3HXeKYtq5SDXARA0BsaJQzYfDotA9LFgmFKg9jVhtcc1V3rtpaJ5sab8tdBTPPyN/XT8fA0GxlIX+hjLd3E9wB7qzNR6PZ84UKDxhCGWrLuIoSzuCbr+TD9UCJprsfTu8kr8Pur4rrxm7Zu1MsJRR9U5Ut+O9FZfw4SqGykyTGGh0v1gDG8esKpTW5MKNk9dRwDNHEmIF6tE6NeXDlzovf8VW6z9JA6AVUkgiFjDvLUY5MgyTqPB9RJNMSAZBzrkZgXyHlmFz2rvPqQGFbAtukjeRNS+nkVayLqfQnqpgthBvsgDUgFn03z0U2Svb094Q5XHMeQ4KM/nMWTEUC+8cybYhwVklJU7FBl9nzs66wkMZpViIrVWwSB2k9R1r/ZQcmeL+LR+WwgCtRs4It1rNVkxXwYHjsFM2Ce46TWhbVMF/h7Ap4lOTS15EHC8RvIBBcR2w1iJ+3pXiMeihArTELVnQsS31X3kxbBp3dGvLvW7PxDlwwdUQOXnMoimUCI/h0uPdSRULPAQHgSp9+TwqI0Uswb7cEiXnN8PySN5Tk109CYJjKqCxtuXu+oOeQV2I/0knQLd2zol+yIzNLj5a/HvyN+kOhIGi6TrFThuiVbbtnTtRM1CzKtFGuw5lYrwskkkvenoSLNY0N85QCU8ugjc3Bw4JZ9jNrDUaJ1Vb5/+1GQx/q/Dbxnl+FK6wMLjXy5JdFDeQyjBEBqndQxrs9cM5xBnl6AYs2Xymydafm2qK0cEDzwOPMpVcKU8sXS/AHvtgsn+rjMzW0wrQblWE0Ht/74GgfCj4diCDtzxQ0ggi6yJD+yhLZtVVqmKS3Gwnj9RxPLNfpgzPP01eYyBBi/W0RWTzcTb8iMxWX52MTU0oX9//4I7CAPXn0ZhpWAAIvUmkfjwfEModH7iwwaNtZFlT2rlzeshbP++UCEtqbwvveDRhmr5sMYkl+duEOca5156fcRy4tQ8Y3moNcKFKzHGMenShEIHz+W5KE=";
    $url="http://services.test.sw.com.mx/";
    $token=" ";
 
    $params = array(
    "url"=>$url,  
    "token"=>$token,
    "uuid"=>$uuid,
    "password"=>$password,
    "rfc"=>$rfc,
    "motivo"=>$motivo,
    "cerB64"=>$b64Cer,
    "keyB64"=>$b64Key
);
    
try {
    header('Content-type: application/json');
    $cancelationService = CancelationService::Set($params);
    $result = $cancelationService::CancelationByCSD();
    echo json_encode($result);
} catch(Exception $e) {
    header('Content-type: text/plain');
    echo $e->getMessage();
}


/* -------------------------------------------------------Cancelación PFX-------------------------------------------------------- */
    $rfc="EKU9003173C9";
    $password="12345678a";
    $uuid="fe4e71b0-8959-4fb9-8091-f5ac4fb0fef8";
    $motivo="01";
    $foliosustitucion="0e4c30b8-11d8-40d8-894d-ef8b32eb4bdf";
    $b64Pfx="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";
    $url="http://services.test.sw.com.mx/";
    $token=" ";

    $params = array(
    "url"=>$url,  
    "token"=>$token,
    "uuid"=>$uuid,
    "password"=>$password,
    "rfc"=>$rfc,
    "motivo"=>$motivo,
    "foliosustitucion"=>$foliosustitucion,
    "pfxB64"=>$b64Pfx,
    
    );

    try {
    header('Content-type: application/json');
    $cancelationService = CancelationService::Set($params);
    $result = $cancelationService::CancelationByPFX();
    echo json_encode($result);
    } catch(Exception $e) {
    header('Content-type: text/plain');
    echo $e->getMessage();
    }
/* -------------------------------------------------------Cancelación XML-------------------------------------------------------- */
    $resultSpect = "success";
			$params = array(
				"url"=>"http://services.test.sw.com.mx/",	
				"token"=>" "				
			);
            $xml=file_get_contents("../Tests/Resources/CancelationResources/cancelByXml.xml");
		    try {
		        $cancelationService = CancelationService::Set($params);
		        $result = $cancelationService::CancelationByXML($xml);
                echo json_encode($result);
            } catch(Exception $e) {
            header('Content-type: text/plain');
            echo $e->getMessage();
            }
?>
