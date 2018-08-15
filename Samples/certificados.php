<?php 

class Certificados{
	private $_path = '';
	public $_keyPem = '';
	public $_cerPem = '';
	public $_pfx = '';
	private $_return = array();
	
	function __construct($pathCertificados = null){
            $this->_path = $pathCertificados;
	}
	
	private function _estableceError($result, $mensajeError = null, $arrayExtras = null){
            $this->_return = array();
            $this->_return['result'] = $result;
            if($mensajeError != null){
                    $this->_return['error'] = $mensajeError;
            }
            if($arrayExtras != null){
                    foreach ($arrayExtras as $key => $val){
                            $this->_return[$key] = $val;
                    }
            }
	}
	
        function isEnabled($func) {
            return is_callable($func) && false === stripos(ini_get('disable_functions'), $func);
        }
                
	public function generaKeyPem($nombreKey, $password){
	
            $nombreKey = $this->_path.$nombreKey;

            if (file_exists($nombreKey)) {
                $salida = shell_exec('openssl pkcs8 -inform DER -in '.$nombreKey.' -out '.$nombreKey.'.pem -passin pass:'.$password.' 2>&1');
                if($salida == '' || $salida == false || $salida == null){
                    $this->_keyPem = $nombreKey.'.pem';
                    $this->_estableceError(1);
                    return $this->_return;
                }else if (strpos($salida, 'Error decrypting') !== false) {
                    $this->_estableceError(0, 'Contraseña incorrecta');
                    return $this->_return;
                }else {
                    $this->_estableceError(0, 'No se logro generar el key.pem');
                    return $this->_return;
                }

            }else {
                $this->_estableceError(0, 'El archivo requerido no esta disponible');
                return $this->_return;
            }
	}
        
	public function generaKeyPemPrivado($nombreKey){
            
            $nombreKey = $this->_path.$nombreKey;
            $salida = shell_exec('openssl pkcs8 -inform DER -in '.$nombreKey.' -out '.$nombreKey.'.pem 2>&1');
            if($salida == '' || $salida == false || $salida == null){
                    $this->_keyPem = $nombreKey.'.pem';
                    $this->_estableceError(1);
            return $this->_return;
            }else if (strpos($salida, 'Error decrypting') !== false) {
                    $this->_estableceError(0, 'Contraseña incorrecta');
                    return $this->_return;
                }else {
                    $this->_estableceError(0, 'No se logro generar el key.pem');
                    return $this->_return;
                }
        }
        
	public function generaCerPem($nombreCer){
		
            $nombreCer = $this->_path.$nombreCer;	
            if (file_exists($nombreCer)) {
                $salida = shell_exec('openssl x509 -inform DER -outform PEM -in '.$nombreCer.' -pubkey -out '.$nombreCer.'.pem 2>&1');
                if (strpos($salida, 'BEGIN PUBLIC KEY') !== false){
                    $this->_cerPem = $nombreCer.'.pem';
                    $this->_estableceError(1);
                    return $this->_return;
                }else {
                    $this->_estableceError(0, 'No se logro generar el cer.pem');
                    return $this->_return;
                }
            }else {
                $this->_estableceError(0, 'El archivo requerido no esta disponible.');
                return $this->_return;
            }
	}
        
	public function generaPFX($password, $nombreCerPem = null, $nombreKeyPem = null){
		
            if($nombreCerPem == null || $nombreKeyPem == null){
                if($this->_cerPem != null && $this->_keyPem != null){
                    $nombreCerPem = $this->_cerPem;
                    $nombreKeyPem = $this->_keyPem;
                }else {
                    $nombreKeyPem = $this->_path.'desconocido.ccg';
                    $nombreCerPem = $this->_path.'desconocido.ccg';
                }
            }else {
                $nombreKeyPem = $this->_path.$nombreKeyPem;
                $nombreCerPem = $this->_path.$nombreCerPem;
            }

            $pfx = explode('.', $nombreKeyPem);
            $pfx = $pfx[0].'.pfx';

            if (file_exists($nombreKeyPem) && file_exists($nombreCerPem)) {
                $salida = shell_exec('echo 4xBbCfSj | sudo -S openssl pkcs12 -export -inkey '.$nombreKeyPem.' -in '.$nombreCerPem.' -out '.$pfx.' -passout pass:'.$password.' 2>&1');
                if (strpos($salida, '[sudo] password for sandbox2014') !== false){
                    $this->_pfx = $pfx;
                    $this->_estableceError(1);
                    return $this->_return;
                } else {
                    $this->_estableceError(0, 'No se logro generar el archivo .pfx');
                    return $this->_return;
                }
            } else {
                $this->_estableceError(0, 'Al menos uno de los archivos requeridos no esta disponible');
                return $this->_return;
            }
	}
	
	public function getSerialCert($nombreCerPem){
		
            if($nombreCerPem == null){
                if($this->_cerPem != null){
                    $nombreCerPem = $this->_cerPem;
                }else {
                    $nombreCerPem = $this->_path.'desconocido.ccg';
                }
            }else {
                $nombreCerPem = $this->_path.$nombreCerPem;
            }

            if (file_exists($nombreCerPem)){
                $salida = shell_exec('openssl x509 -in '.$nombreCerPem.' -noout -serial  2>&1');

                if (strpos($salida, 'serial=') !== false){
                    $salida = str_replace('serial=', '', $salida);
                    $serial = '';
                    for ($i = 0; $i<strlen($salida); $i++){
                        if($i%2!=0)
                        {
                            $serial .= $salida[$i];
                        }
                    }
                    $this->_estableceError(1, null, array('serial' => $serial));
                    return $this->_return;
                }else {
                    $this->_estableceError(0, 'No se logro obtener el seria del certificado');
                    return $this->_return;
                }
            }else {
                $this->_estableceError(0, 'El archivo requerido no esta disponible');
                return $this->_return;
            }
	}
	
	public function getFechaInicio($nombreCerPem = null){
		if($nombreCerPem == null){
			if($this->_cerPem != null){
				$nombreCerPem = $this->_cerPem;
			}else {
				$nombreCerPem = $this->_path.'desconocido.ccg';
			}
		}else {
			$nombreCerPem = $this->_path.$nombreCerPem;
		}
	
		if (file_exists($nombreCerPem)){
			$salida = shell_exec('openssl x509 -in '.$nombreCerPem.' -noout -startdate 2>&1');
			$salida = trim(str_replace('notBefore=', '', $salida));
			$info_preg = array();
			$salida = str_replace('  ', ' ', $salida);
			preg_match('#([A-z]{3}) ([0-9]{1,2}) ([0-2][0-9]:[0-5][0-9]:[0-5][0-9]) ([0-9]{4})#',
			$salida, $info_preg);
			if(!empty($info_preg)){
				$fecha = $info_preg[2].'-'.$info_preg[1].'-'.$info_preg[4].' '.$info_preg[3];
				$this->_estableceError(1, null, array('fecha' => $fecha));
				return $this->_return;
			}else {
				$this->_estableceError(0, 'No se logro obtener la fecha de inicio del certificado');
				return $this->_return;
			}			
		}else {
			$this->_estableceError(0, 'El archivo requerido no esta disponible');
			return $this->_return;
		}
	}
	
	public function getFechaVigencia($nombreCerPem = null){
		if($nombreCerPem == null){
			if($this->_cerPem != null){
				$nombreCerPem = $this->_cerPem;
			}else {
				$nombreCerPem = $this->_path.'desconocido.ccg';
			}
		}else {
			$nombreCerPem = $this->_path.$nombreCerPem;
		}
		
		if (file_exists($nombreCerPem)){
			$salida = shell_exec('openssl x509 -in '.$nombreCerPem.' -noout -enddate 2>&1');
			$salida = str_replace('notAfter=', '', $salida );
			$info_preg = array();
			$salida = str_replace('  ', ' ', $salida);
			preg_match('#([A-z]{3}) ([0-9]{1,2}) ([0-2][0-9]:[0-5][0-9]:[0-5][0-9]) ([0-9]{4})#',
			$salida,$info_preg);
			if(!empty($info_preg)){
				$fecha =  $info_preg[2].'-'.$info_preg[1].'-'.$info_preg[4].' '.$info_preg[3];
				$this->_estableceError(1, null, array('fecha' => $fecha));
				return $this->_return;
			}else {
				$this->_estableceError(0, 'No se logro obtener la fecha de vigencia del certificado');
				return $this->_return;
			}
		}else {
			$this->_estableceError(0, 'El archivo requerido no esta disponible');
			return $this->_return;
		}
	}
        
	public function validarCertificado($nombreCerPem = null){
		if($nombreCerPem == null){
			if($this->_cerPem != null){
				$nombreCerPem = $this->_cerPem;
			}else {
				$nombreCerPem = $this->_path.'desconocido.ccg';
			}
		}else {
			$nombreCerPem = $this->_path.$nombreCerPem;
		}
		
		if (file_exists($nombreCerPem)){
			$salida = shell_exec('openssl x509 -in '.$nombreCerPem.' -noout -subject 2>&1');
			$salida = str_replace('notBefore=', '', $salida);
			$info_preg = array();
			preg_match('#/OU=(.*)#',
			$salida,$info_preg);
			if(!empty($info_preg)){
				$this->_estableceError(1, null, array('OU' => $info_preg[1]));
				return $this->_return;
			}else {
				$this->_estableceError(0, 'No se logro validar el certificado');
				return $this->_return;
			}
		}else {
			$this->_estableceError(0, 'El archivo requerido no esta disponible');
			return $this->_return;
		}
	}
	
	public function pareja($nombreCerPem = null, $nombreKeyPem = null){
		
		if($nombreCerPem == null || $nombreKeyPem == null){
			if($this->_cerPem != null && $this->_keyPem != null){
				$nombreCerPem = $this->_cerPem;
				$nombreKeyPem = $this->_keyPem;
			}else{
				$nombreKeyPem = $this->_path.'desconocido.ccg';
				$nombreCerPem = $this->_path.'desconocido.ccg';
			}
		}else{
			$nombreKeyPem = $this->_path.$nombreKeyPem;
			$nombreCerPem = $this->_path.$nombreCerPem;
		}
		
		if (file_exists($nombreCerPem) && file_exists($nombreKeyPem)){
			$salidaCer = shell_exec('openssl x509 -noout -modulus -in '.$nombreCerPem.' 2>&1');
			$salidaKey = shell_exec('openssl rsa -noout -modulus -in '.$nombreKeyPem.' 2>&1');
			if($salidaCer == $salidaKey){
				$this->_estableceError(1);
				return $this->_return;
			}else {
				$this->_estableceError(0, 'Los archivos no son pareja');
				return $this->_return;
			}
		}else {
			$this->_estableceError(0, 'Al menos uno de los archivos requeridos no esta disponible');
			return $this->_return;
		}
	}
        
        public function certificadoBase64($nombreCer = null){
            if($nombreCer == null){
			if($this->_cer != null){
				$nombreCer = $this->_cer;
			}else {
				$nombreCer = $this->_path.'desconocido.ccg';
			}
		}else {
			$nombreCer = $this->_path.$nombreCer;
		}
            return base64_encode(implode(file($this->_path.$nombreCer)));
        }
        
        public function selloGenerar($cadenaOriginal){
            return shell_exec('openssl dgst -sha256 -sign '.$this->_keyPem.' '.$cadenaOriginal.' 2>&1 | openssl enc -base64 -A 2>&1');
        }
        
        public  function getDatosCertificado($nombreCerPem = null){
            return openssl_x509_parse(file_get_contents($nombreCerPem));
        }
        
        public function getOwnerCertificado($nombreCerPem = null ){
            return openssl_x509_parse(file_get_contents($nombreCerPem))['subject']['name'];
        }
        
        public function getRFC($nombreCerPem = null){
             return (string)trim(explode('/', openssl_x509_parse(file_get_contents($nombreCerPem))['subject']['x500UniqueIdentifier'])[0]);
        } 
        
        public function getSerialNumberPHP($nombreCerPem){
           $salida = openssl_x509_parse(file_get_contents($nombreCerPem))['serialNumberHex'];
           $string='';
            for ($i=0; $i < strlen($salida)-1; $i+=2){
                $string .= chr(hexdec($salida[$i].$salida[$i+1]));
            }
            return $string;
        }
}