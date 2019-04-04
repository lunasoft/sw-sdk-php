<?php 
namespace SWServices\Toolkit;
use Exception;
use DOMDocument;
use XSLTProcessor;

	class SignService {
		
		public static function ObtenerSello($params) {
			self::_checkOpenssl();
			if(isset($params['cadenaOriginal']) && isset($params['archivoCerPem']) && isset($params['archivoKeyPem'])){
                $cadena_original = $params['cadenaOriginal'];
                $archivoCerPem = $params['archivoCerPem'];
                $archivoKeyPem = $params['archivoKeyPem'];
            }else{
            	throw new Exception('Se debe especificar una cadena original, archivo .cer.pem, archivo .key.pem');
            }
            self::_existsFile($cadena_original);
			self::_existsFile($archivoCerPem);
			self::_existsFile($archivoKeyPem);
			$cadena_original = file_get_contents($cadena_original);
		    $pkeyid = openssl_get_privatekey(file_get_contents($archivoKeyPem));
    		openssl_sign($cadena_original, $crypttext, $pkeyid, sha256WithRSAEncryption);
    		openssl_free_key($pkeyid);
    		$sello = base64_encode($crypttext);

    		if(!self::_verifySeal($cadena_original, $crypttext, $archivoCerPem)){
				throw new Exception('Ocurrió un error al generar el sello.');
    		}

    		$r= array("status" => "success", "sello"=>$sello);
		    return json_decode(json_encode($r));
		}

	    private static function _verifySeal($cadena_original, $encryptData, $cerPem) {
	    	$pubkeyid = openssl_pkey_get_public(file_get_contents($cerPem));
			$ok = openssl_verify($cadena_original, $encryptData, $pubkeyid, sha256WithRSAEncryption);
			openssl_free_key($pubkeyid);
			return $ok == 1;
	    }

		private static function random_string($length) {
		    $key = '';
		    $keys = array_merge(range(0, 9), range('a', 'z'));

		    for ($i = 0; $i < $length; $i++) {
		        $key .= $keys[array_rand($keys)];
		    }

		    return $key;
		}

		private static function _checkOpenssl() {
			if (!extension_loaded('openssl')) {
			    throw new Exception('No se tiene openssl instalado');
			}
		}

		private static function _existsFile($file){
			if(!file_exists($file)){
            	throw new Exception("El archivo $file no existe");
            }
		}
	}

?>