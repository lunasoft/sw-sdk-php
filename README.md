![PHP](https://raw.githubusercontent.com/php-earth/php-resources-assets/master/images/community/elephpant.png)

A continuación encontrara la documentación necesaria para consumir nuestro SDK de servicios proveido por **SmarterWeb** para Timbrado de **CFDI 3.3** mediante un servicio **API REST**

Estado Actual
-------------
[![Build Status](https://travis-ci.org/lunasoft/sw-sdk-php.svg?branch=master)](http://travis-ci.org/example/example)

Compatibilidad
-------------
* CFDI 3.3
* PHP 5.6 ó en su versión PHP 7

Dependencias
------------
* [PHPUnit](https://phpunit.de/) Para las pruebas Unitarias
* [Composer](https://getcomposer.org/) Para descargar nuestro SDK

----------------
Instalaci&oacute;n
---------
Para poder hacer uso de nuestro SDK para consumir el servio **REST** que **SmarterWeb** le provee primero es necesario tener instalado una version de PHP ya sea la **5.6** o la version **7** y posteriormente instalar manejador de paquetes de PHP **Composer**

#### Instalar Composer #####
* Paso 1:
Dirigirnos a la siguiente pagina web https://getcomposer.org/
* Paso 2:
Dar click en **Download**
* Paso 3:
Dar clic en **Composer-Setup.exe** esto abrira una ventana en su explorador para que guarde el archivo composer
* Paso 4:
Ejecutar el archivo descargado **Composer-Setup.exe** y seguir los pasos de instalacion

#### Preparar nuestro ambiente de Desarrollo #####
* Paso 1:
Necesitaremos crear un archivo llamador **composer.json** y dentro de el ingresaremos la libreria de la cual queremos hacer uso en nuestro ejemplo es **lunasoft/sw-sdk-php**

```php
{
    "name": "richbarusta/implement",
    "authors": [
        {
            "name": "Rich Barusta",
            "email": "ricardo.barusta@sw.com.mx"
        }
    ],
    "require": {
        "lunasoft/sw-sdk-php": "dev-master"
    }
}
```

* Paso 2
Dentro de tu carpeta de tu proyecto abrir **CMD** o **PowerShell** y escribir lo siguiente:
```
composer install
```
De esta manera descarga las dependencias que antes escribimos dentro del require que en nuestro caso es el **SDK**

----------------
Implementaci&oacute;n
---------
La librería cuenta con dos servicios principales los que son la Autenticacion y el Timbrado de CFDI (XML).

#### Ejemplos ####
 [Descargar Ejemplos](https://github.com/lunasoft/sw-sdk-php/tree/master/Samples) 

#### Datos de conexión #### 
**Url de Pruebas:** http://services.test.sw.com.mx
**Usuario de Pruebas:** demo
**Constraseña de Pruebas:** 12345678A

#### Aunteticaci&oacute;n #####
El servicio de Autenticación es utilizado principalmente para obtener el **token** el cual sera utilizado para poder timbrar nuestro CFDI (xml) ya emitido (sellado), para poder utilizar este servicio es necesario que cuente con un **usuario** y **contraseña** para posteriormente obtenga el token, usted puede utilizar los que estan en este ejemplo para el ambiente de **Pruebas**.

**Obtener Token**
```php
<?php
    require_once 'vendor/autoload.php';
    use SWServices\Authentication\AuthenticationService as Authentication;
    
    $params = array(
        "url"=>"http://services.test.sw.com.mx",
        "user"=>"demo",
        "password"=> "12345678A"
    );
    try
    {
        header('Content-type: application/json');
        $auth = Authentication::auth($params);
        $token = $auth::Token();
        echo $token;
    }
    catch(Exception $e)
    {
        header('Content-type: text/plain');
        echo 'Caught exception: ',  $e->getMessage(), "\n";
    }
?>
```
El ejemplo anterior la respuesta es un objeto tipo **JSON** y dentro de el se encuentra el **Token**

```json
{"data":{"token":"T2lYQ0t4L0RHVkR4dHZ5Nkk1VHNEakZ3Y0J4Nk9GODZuRyt4cE1wVm5tbXB3..."},"status":"success"}
```

#### Timbrar CFDI V1 #####
**StampV1** Recibe el contenido de un **XML** ya emitido (sellado) en formato **String**, posteriormente si la factura y el token son correctos devuelve el complemento timbre en un string (**TFD**), en caso contrario lanza una excepción.

**Timbrar XML en formato string utilizando usuario y contraseña**
```php
<?php
     try{
        header('Content-type: application/json');

        $params = array(
            "url"=>"http://services.test.sw.com.mx",
            "user"=>"demo",
            "password"=> "12345678A"
            );
        $xml = file_get_contents('./file.xml');
        $stamp = StampService::Set($params);
        $result = $stamp::StampV1($xml);
        echo $result;

    }
    catch(Exception $e){
        header('Content-type: text/plain');
        echo 'Caught exception: ',  $e->getMessage(), "\n";
    }
?>
```

El ejemplo anterior la respuesta es un objeto tipo **JSON** y dentro de el se encuentra el **TFD**

```json
{"data":{"tfd":"<tfd:TimbreFiscalDigital xsi:schemaLocation=\"http://www.sat.gob.mx/TimbreFiscalDigital http://www.sat.gob.mx/sitio_internet/cfd/TimbreFiscalDigital/TimbreFiscalDigitalv11.xsd..."},"status":"success"}
```
**Timbrar XML en formato string utilizando token**
```php
<?php
    require_once 'vendor/autoload.php';
    use SWServices\Stamp\StampService as StampService;

    $params = array(
	"url"=>"http://services.test.sw.com.mx",
	"token"=>"T2lYQ0t4L0RHVkR4dHZ5Nkk1VHNEakZ3Y0J4Nk9GODZuRyt4cE1wVm5tbXB3YVZxTHdOdHAwVXY2NTdJb1hkREtXTzE3dk9pMmdMdkFDR2xFWFVPUXpTUm9mTG1ySXdZbFNja3FRa0RlYURqbzdzdlI2UUx1WGJiKzViUWY2dnZGbFloUDJ6RjhFTGF4M1BySnJ4cHF0YjUvbmRyWWpjTkVLN3ppd3RxL0dJPQ.T2lYQ0t4L0RHVkR4dHZ5Nkk1VHNEakZ3Y0J4Nk9GODZuRyt4cE1wVm5tbFlVcU92YUJTZWlHU3pER1kySnlXRTF4alNUS0ZWcUlVS0NhelhqaXdnWTRncklVSWVvZlFZMWNyUjVxYUFxMWFxcStUL1IzdGpHRTJqdS9Zakw2UGRiMTFPRlV3a2kyOWI5WUZHWk85ODJtU0M2UlJEUkFTVXhYTDNKZVdhOXIySE1tUVlFdm1jN3kvRStBQlpLRi9NeWJrd0R3clhpYWJrVUMwV0Mwd3FhUXdpUFF5NW5PN3J5cklMb0FETHlxVFRtRW16UW5ZVjAwUjdCa2g0Yk1iTExCeXJkVDRhMGMxOUZ1YWlIUWRRVC8yalFTNUczZXdvWlF0cSt2UW0waFZKY2gyaW5jeElydXN3clNPUDNvU1J2dm9weHBTSlZYNU9aaGsvalpQMUxrUndzK0dHS2dpTittY1JmR3o2M3NqNkh4MW9KVXMvUHhZYzVLQS9UK2E1SVhEZFJKYWx4ZmlEWDFuSXlqc2ZRYXlUQk1ldlZkU2tEdU10NFVMdHZKUURLblBxakw0SDl5bUxabDFLNmNPbEp6b3Jtd2Q1V2htRHlTdDZ6eTFRdUNnYnVvK2tuVUdhMmwrVWRCZi9rQkU9.7k2gVCGSZKLzJK5Ky3Nr5tKxvGSJhL13Q8W-YhT0uIo"
	);

    try
    {
        header('Content-type: application/json');
        $xml = file_get_contents('./file.xml');
        $stamp = StampService::Set($params);
        $result = $stamp::StampV1($xml);
        echo $result;
    }
    catch(Exception $e)
    {
        header('Content-type: text/plain');
        echo $e->getMessage();
    }
?>
```
El ejemplo anterior la respuesta es un objeto tipo **JSON** y dentro de el se encuentra el **TFD**

```json
{"data":{"tfd":"<tfd:TimbreFiscalDigital xsi:schemaLocation=\"http://www.sat.gob.mx/TimbreFiscalDigital http://www.sat.gob.mx/sitio_internet/cfd/TimbreFiscalDigital/TimbreFiscalDigitalv11.xsd..."},"status":"success"}
```