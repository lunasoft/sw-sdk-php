<p align="center">
    <img src="https://raw.githubusercontent.com/php-earth/php-resources-assets/master/images/community/elephpant.png">
</p>

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

#### En caso de no usar composer ####
Se puede hacer uso de las clases mediante la implementacion manual haciendo uso del archivo SWSDK.php en lugar del archivo vendor.php

```php
	include('SWSDK.php');
```
----------------
Implementaci&oacute;n
---------
La librería cuenta con dos servicios principales los que son la Autenticacion y el Timbrado de CFDI (XML).

#### Ejemplos ####
 [Descargar Ejemplos](https://github.com/lunasoft/sw-sdk-php/tree/master/Samples) 

#### Datos de conexión #### 
**Url de Pruebas:** http://services.test.sw.com.mx
**Usuario de Pruebas:** demo
**Constraseña de Pruebas:** 123456789
#### Nueva funcionalidad para el soporte con servidores Proxy ####
Si tu posees un servidor proxy en tu empresa y deseas que la libreria lo use, debes pasar un parametro extra llamado "proxy" con el host y puerto de tu servidor proxy.
```php
    $params = array(
        "url"=>"http://services.test.sw.com.mx",
        "proxy"=> "server.domain.com:8888"
    );
```
#### Autenticaci&oacute;n #####
El servicio de Autenticación es utilizado principalmente para obtener el **token** el cual sera utilizado para poder timbrar nuestro CFDI (xml) ya emitido (sellado), para poder utilizar este servicio es necesario que cuente con un **usuario** y **contraseña** para posteriormente obtenga el token, usted puede utilizar los que estan en este ejemplo para el ambiente de **Pruebas**.

**Obtener Token**
```php
<?php
    require_once 'vendor/autoload.php';
    use SWServices\Authentication\AuthenticationService as Authentication;
    
    $params = array(
        "url"=>"http://services.test.sw.com.mx",
        "user"=>"demo",
        "password"=> "123456789"
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
        var_dump($result);
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
#### Nueva funcionalidad para el soporte con servidores Proxy ####
Si tu posees un servidor proxy en tu empresa y deseas que la libreria lo use, debes pasar un parametro extra llamado "proxy".
```php
    $params = array(
        
        "proxy"=> "server.domain.com"
    );
```


#### Timbrar CFDI V2 #####
**StampV2** Recibe el contenido de un **XML** ya emitido (sellado) en formato **String**, posteriormente si la factura y el token son correctos devuelve el complemento timbre en un string (**TFD**),asi como el comprobante ya timbrado en formato string (**CFDI**), en caso contrario lanza una excepción.

**Timbrar XML en formato string utilizando usuario y contraseña**
```php
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
        $result = $stamp::StampV2($xml);
        var_dump($result);

    }
    catch(Exception $e){
        header('Content-type: text/plain');
        echo 'Caught exception: ',  $e->getMessage(), "\n";
    }
?>
```

El ejemplo anterior la respuesta es un objeto tipo **JSON** y dentro de el se encuentra el **TFD**

```json
{"data":{
    "cfdi":"<?xml version=\"1.0\" encoding=\"utf-8\"?><cfdi:Comprobante xsi:schemaLocation=\"http://www.sat.gob.mx/cfd/3 http://www.sat.gob.mx/sitio_internet/cfd/3/cfdv33.xsd http:/...",
    "tfd":"<tfd:TimbreFiscalDigital xsi:schemaLocation=\"http://www.sat.gob.mx/TimbreFiscalDigital http://www.sat.gob.mx/sitio_internet/cfd/TimbreFiscalDigital/TimbreFiscalDigitalv11.xsd..."},"status":"success"}
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
        $result = $stamp::StampV2($xml);
        var_dump($result);
    }
    catch(Exception $e)
    {
        header('Content-type: text/plain');
        echo $e->getMessage();
    }
?>
```
El ejemplo anterior la respuesta es un objeto tipo **JSON** y dentro de el se encuentra el **TFD** y el **CFDI**

```json
{"data":{
    "cfdi":"<?xml version=\"1.0\" encoding=\"utf-8\"?><cfdi:Comprobante xsi:schemaLocation=\"http://www.sat.gob.mx/cfd/3 http://www.sat.gob.mx/sitio_internet/cfd/3/cfdv33.xsd http:/...",
    "tfd":"<tfd:TimbreFiscalDigital xsi:schemaLocation=\"http://www.sat.gob.mx/TimbreFiscalDigital http://www.sat.gob.mx/sitio_internet/cfd/TimbreFiscalDigital/TimbreFiscalDigitalv11.xsd...","status":"success"}
```
**Timbrar XML en formato base64 utilizando token/credenciales**<br>
Si se desea, se puede usar la version 2 en la modalidad base64, esto quiere decir que se puede enviar el xml previamente sellado en formato base64, y la libreria le respondera la misma estructura de respuesta que se usa en v2 normal con el tfd, y cfdi en base64 tambien.
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
        //Se agrega un segundo parametro de tipo boolean para activar la modalidad base64
        $result = $stamp::StampV2($xml,true);
        var_dump($result);
    }
    catch(Exception $e)
    {
        header('Content-type: text/plain');
        echo $e->getMessage();
    }
?>
```

El ejemplo anterior la respuesta es un objeto tipo **JSON** y dentro de el se encuentra el **TFD** y el **CFDI** en base64

```json
{"data":{
    "cfdi":"PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgiPz4NCjxjZmRpOkNvbXByb2JhbnRlIHhzaTpzY2hlbWFMb2NhdGlvbj0iaHR0cDovL3d3dy5zYXQuZ29iLm14L2NmZC8zIGh0dHA6Ly93...",
    "tfd":"PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgiPz4NCjxjZmRpOkNvbXByb2JhbnRlIHhzaTpzY2hlbWFMb2NhdGlvbj0iaHR0cDovL3d3dy5zYXQuZ29iLm14L2NmZC8zIGh0dHA6Ly93...",
    "status":"success"}
```
#### Timbrar CFDI V3 #####
**StampV3** Recibe el contenido de un **XML** ya emitido (sellado) en formato **String**, posteriormente si la factura y el token son correctos devuelve el comprobante ya timbrado en formato string (**CFDI**), en caso contrario lanza una excepción.

**Timbrar XML en formato string utilizando usuario y contraseña**
```php
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
        $result = $stamp::StampV3($xml);
        var_dump($result);

    }
    catch(Exception $e){
        header('Content-type: text/plain');
        echo 'Caught exception: ',  $e->getMessage(), "\n";
    }
?>
```

El ejemplo anterior la respuesta es un objeto tipo **JSON** y dentro de el se encuentra el **CFDI**

```json
{"data":{
    "cfdi":"<?xml version=\"1.0\" encoding=\"utf-8\"?><cfdi:Comprobante xsi:schemaLocation=\"http://www.sat.gob.mx/cfd/3 http://www.sat.gob.mx/sitio_internet/cfd/3/cfdv33.xsd http:/...",
    "status":"success"}
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
        $result = $stamp::StampV3($xml);
        var_dump($result);
    }
    catch(Exception $e)
    {
        header('Content-type: text/plain');
        echo $e->getMessage();
    }
?>
```
El ejemplo anterior la respuesta es un objeto tipo **JSON** y dentro de el se encuentra el **CFDI**

```json
{"data":{
    "cfdi":"<?xml version=\"1.0\" encoding=\"utf-8\"?><cfdi:Comprobante xsi:schemaLocation=\"http://www.sat.gob.mx/cfd/3 http://www.sat.gob.mx/sitio_internet/cfd/3/cfdv33.xsd http:/...",
   "status":"success"}
```
**Timbrar XML en formato base64 utilizando token/credenciales**<br>
Si se desea, se puede usar la version 3 en la modalidad base64, esto quiere decir que se puede enviar el xml previamente sellado en formato base64, y la libreria le respondera la misma estructura de respuesta que se usa en v3 normal con el cfdi en base64 tambien.
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
        //Se agrega un segundo parametro de tipo boolean para activar la modalidad base64
        $result = $stamp::StampV3($xml,true);
        var_dump($result);
    }
    catch(Exception $e)
    {
        header('Content-type: text/plain');
        echo $e->getMessage();
    }
?>
```

El ejemplo anterior la respuesta es un objeto tipo **JSON** y dentro de el se encuentra el **CFDI** en base64

```json
{"data":{
    "cfdi":"PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgiPz4NCjxjZmRpOkNvbXByb2JhbnRlIHhzaTpzY2hlbWFMb2NhdGlvbj0iaHR0cDovL3d3dy5zYXQuZ29iLm14L2NmZC8zIGh0dHA6Ly93...",
    "status":"success"}
```


#### Timbrar CFDI V4 #####
**StampV4** Recibe el contenido de un **XML** ya emitido (sellado) en formato **String**, posteriormente si la factura y el token son correctos devuelve el comprobante ya timbrado en formato string (**CFDI**), asi como otros campos por ejemplo: **cadenaOriginalSAT**, **noCertificadoSAT**, **noCertificadoCFDI**, **uuid**, etc
, en caso contrario lanza una excepción.

**Timbrar XML en formato string utilizando usuario y contraseña**
```php
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
        $result = $stamp::StampV4($xml);
        var_dump($result);

    }
    catch(Exception $e){
        header('Content-type: text/plain');
        echo 'Caught exception: ',  $e->getMessage(), "\n";
    }
?>
```

El ejemplo anterior la respuesta es un objeto tipo **JSON** y dentro de el se encuentra el **CFDI**

```json
{
  "data": {
    "cadenaOriginalSAT": "||1.1|1147a19d-8fd5-44f6-9c83-674974518572|2017-05-12T16:32:27|AAA010101AAA|hFHbbQPvk3tb1o3s4TipRPBGG7kLyC9iRQgS4vVf3apfm1y3XJKeMkarUJ2mTy9oxSrCKbQ3X0XN0ljdEWQtc8qtV1L/arCXy+/yAfcI9pIXBg9hhFZcpRPze9NDyadrQ6bAU0nkxNgxaP1u0xGFei7jDk73WlmiRJle7WBZ81Tj2nXqISA+iiPALV7w68MdESD4JF1AmmuGcVCug7gT0rB5u2bI7S16T335jfYAohsmbwNsmtAH1hWyvtteWNY9lKtpN6/9Wi3/7+Lr9q/rEPcdCuaiiTpkyjPXgeCcPmEP/vH7+DLe2yfMcknbbOaR7MLVm/MEfoFeXMkt+xrEVw==|20001000000300022323||",
    "noCertificadoSAT": "20001000000300022323",
    "noCertificadoCFDI": "20001000000300022763",
    "uuid": "1147a19d-8fd5-44f6-9c83-674974518572",
    "selloSAT": "Pp0n+lzPsVynof5M77t996aZzL7ksx9KfYcKA23meVlfz0bdrT6VesBfKnk48/fVieTHfRCjmIeioiACbyvm8hgF2KdYOfOnhH7U+LPl2QJ9hCJ3U+BQ9VpcjCDM/rSEvMri/mJF9OnbXTboo7BKylzhA1apmP9tnji//Pzwj0qZ3E9BPrdPJ9oH9IXBScK8ugjRHaj2bhQSBp0YzjQhPijPn7SGpXomddkrFiGL3da+bR6lKk4sInWe/2zsKMq1uhF65UTzCe4lShMxlWL8OOEiwILDUY+uGUwf1dsX57EQHiFRwbAkjM8NapkLbdwSF7txU4odEpo3OYUnMOk4sw==",
    "selloCFDI": "hFHbbQPvk3tb1o3s4TipRPBGG7kLyC9iRQgS4vVf3apfm1y3XJKeMkarUJ2mTy9oxSrCKbQ3X0XN0ljdEWQtc8qtV1L/arCXy+/yAfcI9pIXBg9hhFZcpRPze9NDyadrQ6bAU0nkxNgxaP1u0xGFei7jDk73WlmiRJle7WBZ81Tj2nXqISA+iiPALV7w68MdESD4JF1AmmuGcVCug7gT0rB5u2bI7S16T335jfYAohsmbwNsmtAH1hWyvtteWNY9lKtpN6/9Wi3/7+Lr9q/rEPcdCuaiiTpkyjPXgeCcPmEP/vH7+DLe2yfMcknbbOaR7MLVm/MEfoFeXMkt+xrEVw==",
    "fechaTimbrado": "2017-05-12T16:32:27",
    "qrCode": "iVBORw0KGgoAAAANSUhEUgAAAIwAAACMCAYAAACuwEE+AAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsMAAA7DAcdvqGQAAAr0SURBVHhe7ZLRiiS7DgT3/396L2b7ISgUTcpyzRm4DggWUim3dqg/fy+XBveDubS4H8ylxf1gLi3uB3NpcT+YS4v7wVxa3A/m0uJ+MJcW94O5tLgfzKXF/WAuLe4Hc2lxP5hLi+0P5s+fP8ftYrvMaRfbZZ44oXpv6oTt7eqQq...",
    "cfdi": "<?xml version=\"1.0\" encoding=\"utf-8\"?><cfdi:Comprobante xsi:schemaLocation=\"http://www.sat.gob.mx/cfd/3 http://www.sat.gob.mx/sitio_internet/cfd/3/cfdv33.xsd http://www.sat.gob.mx/nomina12 http://www.sat.gob.mx/sitio_internet/cfd/nomina/nomina12.xsd\" xmlns:nomina12=\"http://www.sat.gob.mx/nomina12\" Version=\"3.3\"..."
  },
  "status": "success"
}
```
**Timbrar XML en formato string utilizando token**
```php
<?php
    require_once "vendor/autoload.php";
    use SWServices\Stamp\StampService as StampService;

    $params = array(
    "url"=>"http://services.test.sw.com.mx",
    "token"=>"T2lYQ0t4L0RHVkR4dHZ5Nkk1VHNEakZ3Y0J4Nk9GODZuRyt4cE1wVm5tbXB3YVZxTHdOdHAwVXY2NTdJb1hkREtXTzE3dk9pMmdMdkFDR2xFWFVPUXpTUm9mTG1ySXdZbFNja3FRa0RlYURqbzdzdlI2UUx1WGJiKzViUWY2dnZGbFloUDJ6RjhFTGF4M1BySnJ4cHF0YjUvbmRyWWpjTkVLN3ppd3RxL0dJPQ.T2lYQ0t4L0RHVkR4dHZ5Nkk1VHNEakZ3Y0J4Nk9GODZuRyt4cE1wVm5tbFlVcU92YUJTZWlHU3pER1kySnlXRTF4alNUS0ZWcUlVS0NhelhqaXdnWTRncklVSWVvZlFZMWNyUjVxYUFxMWFxcStUL1IzdGpHRTJqdS9Zakw2UGRiMTFPRlV3a2kyOWI5WUZHWk85ODJtU0M2UlJEUkFTVXhYTDNKZVdhOXIySE1tUVlFdm1jN3kvRStBQlpLRi9NeWJrd0R3clhpYWJrVUMwV0Mwd3FhUXdpUFF5NW5PN3J5cklMb0FETHlxVFRtRW16UW5ZVjAwUjdCa2g0Yk1iTExCeXJkVDRhMGMxOUZ1YWlIUWRRVC8yalFTNUczZXdvWlF0cSt2UW0waFZKY2gyaW5jeElydXN3clNPUDNvU1J2dm9weHBTSlZYNU9aaGsvalpQMUxrUndzK0dHS2dpTittY1JmR3o2M3NqNkh4MW9KVXMvUHhZYzVLQS9UK2E1SVhEZFJKYWx4ZmlEWDFuSXlqc2ZRYXlUQk1ldlZkU2tEdU10NFVMdHZKUURLblBxakw0SDl5bUxabDFLNmNPbEp6b3Jtd2Q1V2htRHlTdDZ6eTFRdUNnYnVvK2tuVUdhMmwrVWRCZi9rQkU9.7k2gVCGSZKLzJK5Ky3Nr5tKxvGSJhL13Q8W-YhT0uIo"
    );

    try
    {
        header("Content-type: application/json");
        $xml = file_get_contents("./file.xml");
        $stamp = StampService::Set($params);
        $result = $stamp::StampV4($xml);
        var_dump($result);
    }
    catch(Exception $e)
    {
        header("Content-type: text/plain");
        echo $e->getMessage();
    }
?>
```
El ejemplo anterior la respuesta es un objeto tipo **JSON** y dentro de el se encuentra el **CFDI**

```json
{
  "data": {
    "cadenaOriginalSAT": "||1.1|1147a19d-8fd5-44f6-9c83-674974518572|2017-05-12T16:32:27|AAA010101AAA|hFHbbQPvk3tb1o3s4TipRPBGG7kLyC9iRQgS4vVf3apfm1y3XJKeMkarUJ2mTy9oxSrCKbQ3X0XN0ljdEWQtc8qtV1L/arCXy+/yAfcI9pIXBg9hhFZcpRPze9NDyadrQ6bAU0nkxNgxaP1u0xGFei7jDk73WlmiRJle7WBZ81Tj2nXqISA+iiPALV7w68MdESD4JF1AmmuGcVCug7gT0rB5u2bI7S16T335jfYAohsmbwNsmtAH1hWyvtteWNY9lKtpN6/9Wi3/7+Lr9q/rEPcdCuaiiTpkyjPXgeCcPmEP/vH7+DLe2yfMcknbbOaR7MLVm/MEfoFeXMkt+xrEVw==|20001000000300022323||",
    "noCertificadoSAT": "20001000000300022323",
    "noCertificadoCFDI": "20001000000300022763",
    "uuid": "1147a19d-8fd5-44f6-9c83-674974518572",
    "selloSAT": "Pp0n+lzPsVynof5M77t996aZzL7ksx9KfYcKA23meVlfz0bdrT6VesBfKnk48/fVieTHfRCjmIeioiACbyvm8hgF2KdYOfOnhH7U+LPl2QJ9hCJ3U+BQ9VpcjCDM/rSEvMri/mJF9OnbXTboo7BKylzhA1apmP9tnji//Pzwj0qZ3E9BPrdPJ9oH9IXBScK8ugjRHaj2bhQSBp0YzjQhPijPn7SGpXomddkrFiGL3da+bR6lKk4sInWe/2zsKMq1uhF65UTzCe4lShMxlWL8OOEiwILDUY+uGUwf1dsX57EQHiFRwbAkjM8NapkLbdwSF7txU4odEpo3OYUnMOk4sw==",
    "selloCFDI": "hFHbbQPvk3tb1o3s4TipRPBGG7kLyC9iRQgS4vVf3apfm1y3XJKeMkarUJ2mTy9oxSrCKbQ3X0XN0ljdEWQtc8qtV1L/arCXy+/yAfcI9pIXBg9hhFZcpRPze9NDyadrQ6bAU0nkxNgxaP1u0xGFei7jDk73WlmiRJle7WBZ81Tj2nXqISA+iiPALV7w68MdESD4JF1AmmuGcVCug7gT0rB5u2bI7S16T335jfYAohsmbwNsmtAH1hWyvtteWNY9lKtpN6/9Wi3/7+Lr9q/rEPcdCuaiiTpkyjPXgeCcPmEP/vH7+DLe2yfMcknbbOaR7MLVm/MEfoFeXMkt+xrEVw==",
    "fechaTimbrado": "2017-05-12T16:32:27",
    "qrCode": "iVBORw0KGgoAAAANSUhEUgAAAIwAAACMCAYAAACuwEE+AAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsMAAA7DAcdvqGQAAAr0SURBVHhe7ZLRiiS7DgT3/396L2b7ISgUTcpyzRm4DggWUim3dqg/fy+XBveDubS4H8ylxf1gLi3uB3NpcT+YS4v7wVxa3A/m0uJ+MJcW94O5tLgfzKXF/WAuLe4Hc2lxP5hLi+0P5s+fP8ftYrvMaRfbZZ44oXpv6oTt7eqQq...",
    "cfdi": "<?xml version=\"1.0\" encoding=\"utf-8\"?><cfdi:Comprobante xsi:schemaLocation=\"http://www.sat.gob.mx/cfd/3 http://www.sat.gob.mx/sitio_internet/cfd/3/cfdv33.xsd http://www.sat.gob.mx/nomina12 http://www.sat.gob.mx/sitio_internet/cfd/nomina/nomina12.xsd\" xmlns:nomina12=\"http://www.sat.gob.mx/nomina12\" Version=\"3.3\"..."
  },
  "status": "success"
}
```
**Timbrar XML en formato base64 utilizando token/credenciales**<br>
Si se desea, se puede usar la version 4 en la modalidad base64, esto quiere decir que se puede enviar el xml previamente sellado en formato base64, y la libreria le respondera la misma estructura de respuesta que se usa en v4 normal con el cfdi  en base64 tambien.
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
        //Se agrega un segundo parametro de tipo boolean para activar la modalidad base64
        $result = $stamp::StampV4($xml,true);
        var_dump($result);
    }
    catch(Exception $e)
    {
        header('Content-type: text/plain');
        echo $e->getMessage();
    }
?>
```

El ejemplo anterior la respuesta es un objeto tipo **JSON** y dentro de el se encuentra el **CFDI** en base64

```json
{
  "data": {
    "cadenaOriginalSAT": "||1.1|1147a19d-8fd5-44f6-9c83-674974518572|2017-05-12T16:32:27|AAA010101AAA|hFHbbQPvk3tb1o3s4TipRPBGG7kLyC9iRQgS4vVf3apfm1y3XJKeMkarUJ2mTy9oxSrCKbQ3X0XN0ljdEWQtc8qtV1L/arCXy+/yAfcI9pIXBg9hhFZcpRPze9NDyadrQ6bAU0nkxNgxaP1u0xGFei7jDk73WlmiRJle7WBZ81Tj2nXqISA+iiPALV7w68MdESD4JF1AmmuGcVCug7gT0rB5u2bI7S16T335jfYAohsmbwNsmtAH1hWyvtteWNY9lKtpN6/9Wi3/7+Lr9q/rEPcdCuaiiTpkyjPXgeCcPmEP/vH7+DLe2yfMcknbbOaR7MLVm/MEfoFeXMkt+xrEVw==|20001000000300022323||",
    "noCertificadoSAT": "20001000000300022323",
    "noCertificadoCFDI": "20001000000300022763",
    "uuid": "1147a19d-8fd5-44f6-9c83-674974518572",
    "selloSAT": "Pp0n+lzPsVynof5M77t996aZzL7ksx9KfYcKA23meVlfz0bdrT6VesBfKnk48/fVieTHfRCjmIeioiACbyvm8hgF2KdYOfOnhH7U+LPl2QJ9hCJ3U+BQ9VpcjCDM/rSEvMri/mJF9OnbXTboo7BKylzhA1apmP9tnji//Pzwj0qZ3E9BPrdPJ9oH9IXBScK8ugjRHaj2bhQSBp0YzjQhPijPn7SGpXomddkrFiGL3da+bR6lKk4sInWe/2zsKMq1uhF65UTzCe4lShMxlWL8OOEiwILDUY+uGUwf1dsX57EQHiFRwbAkjM8NapkLbdwSF7txU4odEpo3OYUnMOk4sw==",
    "selloCFDI": "hFHbbQPvk3tb1o3s4TipRPBGG7kLyC9iRQgS4vVf3apfm1y3XJKeMkarUJ2mTy9oxSrCKbQ3X0XN0ljdEWQtc8qtV1L/arCXy+/yAfcI9pIXBg9hhFZcpRPze9NDyadrQ6bAU0nkxNgxaP1u0xGFei7jDk73WlmiRJle7WBZ81Tj2nXqISA+iiPALV7w68MdESD4JF1AmmuGcVCug7gT0rB5u2bI7S16T335jfYAohsmbwNsmtAH1hWyvtteWNY9lKtpN6/9Wi3/7+Lr9q/rEPcdCuaiiTpkyjPXgeCcPmEP/vH7+DLe2yfMcknbbOaR7MLVm/MEfoFeXMkt+xrEVw==",
    "fechaTimbrado": "2017-05-12T16:32:27",
    "qrCode": "iVBORw0KGgoAAAANSUhEUgAAAIwAAACMCAYAAACuwEE+AAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsMAAA7DAcdvqGQAAAr0SURBVHhe7ZLRiiS7DgT3/396L2b7ISgUTcpyzRm4DggWUim3dqg/fy+XBveDubS4H8ylxf1gLi3uB3NpcT+YS4v7wVxa3A/m0uJ+MJcW94O5tLgfzKXF/WAuLe4Hc2lxP5hLi+0P5s+fP8ftYrvMaRfbZZ44oXpv6oTt7eqQq...",
    "cfdi": "hFHbbQPvk3tb1o3s4TipRPBGG7kLyC9iRQgS4vVf3apfm1y3XJKeMkarUJ2mTy9oxSrCKbQ3X0XN0ljdEWQtc8qtV1L/arCXy+/yAfcI9pIXBg9hhFZcpRPze9NDyadrQ6bAU0nkxNgxaP1u0xGFei7jDk73WlmiRJle7WBZ81Tj2nXqISA..."
  },
  "status": "success"
}

```

#### Generación de sello para CFDI v3.3 con OpenSSL #####
Para la generacón del sello para la versión 3.3 de CFDI usando solo las funciones de **OpenSSL** en PHP se creó el **SealService**. Para obtener el sello es necesario tener habilitada la extensión de OpenSSL. El método **obtenerSello** de la clase **SealService** recibe un arreglo asociativo con los parámetros necesarios para realizar el sello (**cadenaOriginal, archivoCerPem, archivoKeyPem**).

```php
<?php 
    require_once 'vendor/autoload.php';
    use SWServices\Toolkit\SealService as Sellar;

    $params = array(
        "cadenaOriginal"=> "./cadenaOriginal.txt",
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
```

En caso de no ocurrir excepciones, el objeto tipo JSON devuelto sería como el siguiente:
```json
{
    "status": "success",
    "sello": "l3DgkCUJR8BSSvTyrLD8Xl2tYmIZa2Kf733bVEZuTBYcKSYoeBnxYufQUY8paJwJYKq0dwzxy8JYM43qFDR91m\/cyTtaOSaSBGxvdlf5GU3AYen8SDpsbViOWpc0jTz3sOvel7cyRLwMzf0S3cxV6QD3zE3iH+0IbePA\/oCjwnr0zEMwy5HuveHK+U85GdyX+Pr03vywlbeB79ye80lg5hIT2gp4Xo0s00Ilv\/h2X1bHy3\/wlmAq\/izRqtw2Oa3ajT6R7NaGsNjN7WsvlHRVdm\/eEiW9P0Pi7SP4VnXq0SmEDCZtFTmeGWCk6yLfgGOvq6cjLMHllRMZkyb0DSrE1A=="
}
```


### Cancelación CFDI 3.3 ###

#### Cancelación por CSD ####
Como su nombre lo indica, este servicio recibe todos los elementos que componen el CSD los cuales son los siguientes:

* Certificado (.cer)
* Key (.key)
* Password del archivo key
* RFC emisor 

Esto ya que nuestro servidor generara el acuse de cancelación.

Paso 1: Obtener token de acceso, o en su defecto usar token infinito

Primeramente se deberá autenticar en nuestros servicios en orden de obtener token de acceso, o si se desea,  se puede usar el token infinito.

Paso 2: Enviar datos necesarios

Se envían los datos necesarios para la cancelación, que básicamente es el CSD del emisor que desea cancelar un CFDI, así como el RFC de dicho emisor, el uuid correspondientes al CFDI que se desea cancelar,  y por supuesto el token de acceso anteriormente generado.

Cabe mencionar que los archivos **.cer y .key**,  al ser binarios, **deberán enviarse en formato base64** para que podamos procesarlos en nuestro servidor.
```php
<?php 
    require_once 'vendor/autoload.php';
    use SWServices\Cancelation\CancelationService as CancelationService;

    $params = array(
        "url"=>"http://services.test.sw.com.mx/",   
        "token"=>"T2lYQ0t4L0RHVkR4dHZ5Nkk1VHNEakZ3Y0J4Nk9GODZuRyt4cE1wVm5tbXB3YVZxTHdOdHAwVXY2NTdJb1hkREtXTzE3dk9pMmdMdkFDR2xFWFVPUXpTUm9mTG1ySXdZbFNja3FRa0RlYURqbzdzdlI2UUx1WGJiKzViUWY2dnZGbFloUDJ6RjhFTGF4M1BySnJ4cHF0YjUvbmRyWWpjTkVLN3ppd3RxL0dJPQ.T2lYQ0t4L0RHVkR4dHZ5Nkk1VHNEakZ3Y0J4Nk9GODZuRyt4cE1wVm5tbFlVcU92YUJTZWlHU3pER1kySnlXRTF4alNUS0ZWcUlVS0NhelhqaXdnWTRncklVSWVvZlFZMWNyUjVxYUFxMWFxcStUL1IzdGpHRTJqdS9Zakw2UGRiMTFPRlV3a2kyOWI5WUZHWk85ODJtU0M2UlJEUkFTVXhYTDNKZVdhOXIySE1tUVlFdm1jN3kvRStBQlpLRi9NeWJrd0R3clhpYWJrVUMwV0Mwd3FhUXdpUFF5NW5PN3J5cklMb0FETHlxVFRtRW16UW5ZVjAwUjdCa2g0Yk1iTExCeXJkVDRhMGMxOUZ1YWlIUWRRVC8yalFTNUczZXdvWlF0cSt2UW0waFZKY2gyaW5jeElydXN3clNPUDNvU1J2dm9weHBTSlZYNU9aaGsvalpQMUxrUndzK0dHS2dpTittY1JmR3o2M3NqNkh4MW9KVXMvUHhZYzVLQS9UK2E1SVhEZFJKYWx4ZmlEWDFuSXlqc2ZRYXlUQk1ldlZkU2tEdU10NFVMdHZKUURLblBxakw0SDl5bUxabDFLNmNPbEp6b3Jtd2Q1V2htRHlTdDZ6eTFRdUNnYnVvK2tuVUdhMmwrVWRCZi9rQkU9.7k2gVCGSZKLzJK5Ky3Nr5tKxvGSJhL13Q8W-YhT0uIo",
        "uuid"=> "06a46e4b-b154-4c12-bb77-f9a63ed55ff2",
        "password"=> "123456789",
        "rfc"=> "LAN7008173R5",
        "b64Cer"=> file_get_contents("./b64Cer.txt"),
        "b64Key"=> file_get_contents("./b64Key.txt")
    );

    try {
        header('Content-type: application/json');
        $cancelationService = CancelationService::Set($params);
        $result = $cancelationService::CancelationByCSD();
        var_dump($result);
    } catch(Exception $e) {
        echo 'Caught exception: ',  $e->getMessage(), "\n";
    }
?>
```

#### Cancelación por XML ####

Como su nombre lo indica, este servicio recibe únicamente el XML sellado con los UUID a cancelar.

Paso 1: Obtener token de acceso, o en su defecto usar token infinito

Primeramente se deberá autenticar en nuestros servicios en orden de obtener token de acceso, o si se desea,  se puede usar el token infinito.

Paso 2: Enviar datos necesarios

Se envían los datos necesarios para la cancelación, que únicamente es el XML y el token obtenido previamente.

```php
<?php 
    require_once 'vendor/autoload.php';
    use SWServices\Cancelation\CancelationService as CancelationService;

    $params = array(
        "url"=>"http://services.test.sw.com.mx/",   
        "token"=>"T2lYQ0t4L0RHVkR4dHZ5Nkk1VHNEakZ3Y0J4Nk9GODZuRyt4cE1wVm5tbXB3YVZxTHdOdHAwVXY2NTdJb1hkREtXTzE3dk9pMmdMdkFDR2xFWFVPUXpTUm9mTG1ySXdZbFNja3FRa0RlYURqbzdzdlI2UUx1WGJiKzViUWY2dnZGbFloUDJ6RjhFTGF4M1BySnJ4cHF0YjUvbmRyWWpjTkVLN3ppd3RxL0dJPQ.T2lYQ0t4L0RHVkR4dHZ5Nkk1VHNEakZ3Y0J4Nk9GODZuRyt4cE1wVm5tbFlVcU92YUJTZWlHU3pER1kySnlXRTF4alNUS0ZWcUlVS0NhelhqaXdnWTRncklVSWVvZlFZMWNyUjVxYUFxMWFxcStUL1IzdGpHRTJqdS9Zakw2UGRiMTFPRlV3a2kyOWI5WUZHWk85ODJtU0M2UlJEUkFTVXhYTDNKZVdhOXIySE1tUVlFdm1jN3kvRStBQlpLRi9NeWJrd0R3clhpYWJrVUMwV0Mwd3FhUXdpUFF5NW5PN3J5cklMb0FETHlxVFRtRW16UW5ZVjAwUjdCa2g0Yk1iTExCeXJkVDRhMGMxOUZ1YWlIUWRRVC8yalFTNUczZXdvWlF0cSt2UW0waFZKY2gyaW5jeElydXN3clNPUDNvU1J2dm9weHBTSlZYNU9aaGsvalpQMUxrUndzK0dHS2dpTittY1JmR3o2M3NqNkh4MW9KVXMvUHhZYzVLQS9UK2E1SVhEZFJKYWx4ZmlEWDFuSXlqc2ZRYXlUQk1ldlZkU2tEdU10NFVMdHZKUURLblBxakw0SDl5bUxabDFLNmNPbEp6b3Jtd2Q1V2htRHlTdDZ6eTFRdUNnYnVvK2tuVUdhMmwrVWRCZi9rQkU9.7k2gVCGSZKLzJK5Ky3Nr5tKxvGSJhL13Q8W-YhT0uIo",
        "xml"=> file_get_contents("./cancelByXml.xml"),
    );

    try {
        header('Content-type: application/json');
        $cancelationService = CancelationService::Set($params);
        $result = $cancelationService::CancelationByXML();
        var_dump($result);
    } catch(Exception $e) {
        header('Content-type: text/plain');
        echo $e->getMessage();
    }
?>
```

### Respuestas de cancelación ###

Todos los response de cancelación retornan la misma estructura en caso de error o en caso de petición satisfactoria, las cuales son las siguientes:

Tipos de respuesta
> En caso de una respuesta exitosa, se regresará un 200. En caso de una respuesta no exitosa, se regresará un código diferente de 200, el código puede variar dependiendo del problema dado.



#### Respuesta exitosa ####
```json
{
    "data": {
        "acuse": "<?xml version=\"1.0\" encoding=\"utf-8\"?><Acuse xmlns:xsd=\"http://www.w3.org/2001/XMLSchema\" xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\" Fecha=\"2017-06-27T11:00:54.8788503\" RfcEmisor=\"LAN7008173R5\"><Folios xmlns=\"http://cancelacfd.sat.gob.mx\"><UUID>3EAEABC9-EA41-4627-9609-C6856B78E2B1</UUID><EstatusUUID>202</EstatusUUID></Folios><Signature Id=\"SelloSAT\" xmlns=\"http://www.w3.org/2000/09/xmldsig#\"><SignedInfo><CanonicalizationMethod Algorithm=\"http://www.w3.org/TR/2001/REC-xml-c14n-20010315\" /><SignatureMethod Algorithm=\"http://www.w3.org/2001/04/xmldsig-more#hmac-sha512\" /><Reference URI=\"\"><Transforms><Transform Algorithm=\"http://www.w3.org/TR/1999/REC-xpath-19991116\"><XPath>not(ancestor-or-self::*[local-name()='Signature'])</XPath></Transform></Transforms><DigestMethod Algorithm=\"http://www.w3.org/2001/04/xmlenc#sha512\" /><DigestValue>yoO1MKUhUcokwUgyKt5GJbcXvSzZhMKOp2pGhtuwBVrk35Y8HW8s6gJ04liSamflJFNWwUzaFOIf7KpS0SKkaw==</DigestValue></Reference></SignedInfo><SignatureValue>7ZKbUqUVSXkd9Xo9Dm4xOzrqd+j8v3NQWH8HeIPH+opnTOTGNSlVu+a2cqKKB7vmbt2ZTyfsaNsZ+d7up0zEIw==</SignatureValue><KeyInfo><KeyName>00001088888810000001</KeyName><KeyValue><RSAKeyValue><Modulus>vAr6QLmcvW6auTg7a+Ogm0veNvqJ30rD3j0iSAHxGzGVrg1d0xl0Fj5l+JX9EivD+qhkSY7pfLnJoObLpQ3GGZZOOihJVS2tbJDmnn9TW8fKUOVg+jGhcnpCHaUPq/Poj8I2OVb3g7hiaREORm6tLtzOIjkOv9INXxIpRMx54cw46D5F1+0M7ECEVO8Jg+3yoI6OvDNBH+jABsj7SutmSnL1Tov/omIlSWausdbXqykcl10BLu2XiQAc6KLnl0+Ntzxoxk+dPUSdRyR7f3Vls6yUlK/+C/4FacbR+fszT0XIaJNWkHaTOoqz76Ax9XgTv9UuT67j7rdTVzTvAN363w==</Modulus><Exponent>AQAB</Exponent></RSAKeyValue></KeyValue></KeyInfo></Signature></Acuse>",
        "uuid": {
            "3EAEABC9-EA41-4627-9609-C6856B78E2B1": "202"
        }
    },
    "status": "success"
}
```

En este caso se recibe un mensaje JSON, el cual contiene los siguientes datos:

* Acuse: Xml de acuse que regresa el SAT cuando se cancela un CFDI.
* UUID: uuid cancelado y el estatus de el. (Para más información, consulte la lista de códigos de respuesta de UUID aquí)


#### Respuesta no exitosa ####
```json
{
    "message": "Parámetros incompletos",
    "messageDetail": "Son necesarios el .Cer y el .Key en formato B64, la contraseña, el RFC y el UUID de la factura que necesita cancelar",
    "status": "error"
}
```
#### Códigos de respuesta de folios de cancelación ####
| Código  | Mensaje | Descripcion |
| ------------- | ------------- | ------------- |
| 201  | UUID Cancelado exitosamente  | Se considera cancelado correctamente. Deberá aparecer con estatus Cancelado ante el SAT de 0 a 72 hrs posterior a la cancelación. |
| 202 |  UUID Previamente cancelado | Se considera previamente cancelado. Estatus Cancelado ante el SAT. |
| 203 | UUID No corresponde el RFC del emisor y de quien solicita la cancelación.  |  |
| 205 | No Existe  | El sat da una prorroga de 72 hrs para que el comprobante aparezca con estatus Vigente posterior al envió por parte del Proveedor de Certificación de CFDI. Puede que algunos comprobantes no aparezcan al momento, es necesario esperar por lo menos 72 hrs. |


### Consultar Saldo CFDI 3.3 ###

Este servicio recibe el token y genera los elementos que componen la consulta de saldos:

* ID saldo cliente
* ID cliente usuario
* Saldo timbres
* Timbres utilizados
* Fecha de expiracion
* Ilimitado
* Timbres asignados

Paso 1: Obtener token de acceso, o en su defecto usar token infinito. Primeramente se deberá autenticar en nuestros servicios en orden de obtener token de acceso, o si se desea, se puede usar el token infinito.

Paso 2: Enviar token de acceso. Se envía el token para realizar la consulta de saldo. 
```php
<?php
    require_once 'vendor/autoload.php';
    use SWServices\AccountBalance\AccountBalanceService as AccountBalanceService;

    $params = array(
        'url'=> 'services.test.sw.com.mx',
        'token'=> 'T2lYQ0t4L0RHVkR4dHZ5Nkk1VHNEakZ3Y0J4Nk9GODZuRyt4cE1wVm5tbXB3YVZxTHdOdHAwVXY2NTdJb1hkREtXTzE3dk9pMmdMdkFDR2xFWFVPUXpTUm9mTG1ySXdZbFNja3FRa0RlYURqbzdzdlI2UUx1WGJiKzViUWY2dnZGbFloUDJ6RjhFTGF4M1BySnJ4cHF0YjUvbmRyWWpjTkVLN3ppd3RxL0dJPQ.T2lYQ0t4L0RHVkR4dHZ5Nkk1VHNEakZ3Y0J4Nk9GODZuRyt4cE1wVm5tbFlVcU92YUJTZWlHU3pER1kySnlXRTF4alNUS0ZWcUlVS0NhelhqaXdnWTRncklVSWVvZlFZMWNyUjVxYUFxMWFxcStUL1IzdGpHRTJqdS9Zakw2UGRiMTFPRlV3a2kyOWI5WUZHWk85ODJtU0M2UlJEUkFTVXhYTDNKZVdhOXIySE1tUVlFdm1jN3kvRStBQlpLRi9NeWJrd0R3clhpYWJrVUMwV0Mwd3FhUXdpUFF5NW5PN3J5cklMb0FETHlxVFRtRW16UW5ZVjAwUjdCa2g0Yk1iTExCeXJkVDRhMGMxOUZ1YWlIUWRRVC8yalFTNUczZXdvWlF0cSt2UW0waFZKY2gyaW5jeElydXN3clNPUDNvU1J2dm9weHBTSlZYNU9aaGsvalpQMUxrUndzK0dHS2dpTittY1JmR3o2M3NqNkh4MW9KVXMvUHhZYzVLQS9UK2E1SVhEZFJKYWx4ZmlEWDFuSXlqc2ZRYXlUQk1ldlZkU2tEdU10NFVMdHZKUURLblBxakw0SDl5bUxabDFLNmNPbEp6b3Jtd2Q1V2htRHlTdDZ6eTFRdUNnYnVvK2tuVUdhMmwrVWRCZi9rQkU9.7k2gVCGSZKLzJK5Ky3Nr5tKxvGSJhL13Q8W-YhT0uIo',
    );

    try {
        $accountBalance = AccountBalanceService::Set($params);
        $result = $accountBalance::GetAccountBalance();
        var_dump($result);
    } catch(Exception $e) {
        echo 'Caught exception: ',  $e->getMessage(), "\n";
    }
?>
```

#### Respuestas de consulta de saldo ####
El response de consulta de saldo retorna la siguiente estructura en caso de error o en caso de petición satisfactoria:

>Tipos de respuesta
>En caso de una respuesta exitosa, se regresará un 200. En caso de una respuesta no exitosa, se regresará un código >diferente de 200, el código puede variar dependiendo del problema dado.

#### Respuesta exitosa ####
```json
{
    "data": {
        "idSaldoCliente": "126eac70-425d-4493-87af-93505bfca746",
        "idClienteUsuario": "05f731af-4c94-4d6e-aa87-7b19a16ff891",
        "saldoTimbres": 995026340,
        "timbresUtilizados": 1895963,
        "fechaExpiracion": "0001-01-01T00:00:00",
        "unlimited": false,
        "timbresAsignados": 0
    },
    "status": "success"
}
```

En este caso se recibe un mensaje JSON, el cual contiene los siguientes datos:

* idSaldoCliente: Id del registro.
* idClienteUsuario: Id del usuario.
* saldoTimbres: saldo de los timbres.
* timbresUtilizados: timbres utilizados.
* fechaExpiracion: fecha de expiración.
* unlimited: En caso de que sea verdadero la forma de validar el saldo depende del numero de timbres que tenga el * * distribuidor. En caso de verdadero le descontará los timbres al distribuidor.
* timbresAsignados: timbres asignados.

#### Respuesta no exitosa ####
```json
{
    "message": "Parámetros incompletos",
    "status": "error"
}
```