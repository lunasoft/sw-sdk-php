# SDK php

<p align="center">
    <img src="https://www.php.net//images/logos/new-php-logo.svg" width="250" height="150">
</p>

A continuación encontraras una librería php para el timbrado de **CFDI 4.0** mediante el consumo de los servicios de **SW sapien®**.


## Contenido 

- [Compatibilidad](#Compatibilidad)
- [Dependencias](#Dependencias)
- [Documentación](#Documentación)
- [Instalación](#Instalación)
- [Implementación](#Implementación)
---

### Compatibilidad

* CFDI 4.0
* PHP 5.6 ó en su versión PHP 7
------------

### Dependencias

* [PHPUnit](https://phpunit.de/) Para las pruebas Unitarias
* [Composer](https://getcomposer.org/) Para descargar nuestro SDK

----------------

### Documentación
* [Inicio Rápido](https://developers.sw.com.mx/knowledge-base/conoce-el-proceso-de-integracion-en-solo-7-pasos/)
* [Documentacion Oficial Servicios](http://developers.sw.com.mx)

---

### Instalación

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
    "name": "martinflores/implement",
    "authors": [
        {
            "name": "Martin Flores",
            "email": "martin.flores@sw.com.mx"
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

### Implementación 

La librería cuenta con dos servicios principales los que son la Autenticacion y el Timbrado de CFDI (XML).

#### Nueva funcionalidad para el soporte con servidores Proxy ####
Si tu posees un servidor proxy en tu empresa y deseas que la libreria lo use, debes pasar un parametro extra llamado "proxy" con el host y puerto de tu servidor proxy.
```php
    $params = array(
        "url"=>"http://services.test.sw.com.mx",
        "proxy"=> "server.domain.com:8888"
    );
```
## Autenticación ###
El servicio de Autenticación es utilizado principalmente para obtener el **token** el cual sera utilizado para poder timbrar nuestro CFDI (xml) ya emitido (sellado), para poder utilizar este servicio es necesario que cuente con un **usuario** y **contraseña** para posteriormente obtenga el token, usted puede utilizar los que estan en este ejemplo para el ambiente de **Pruebas**.

**Obtener Token**
```php
<?php
    require_once  'SWSDK.php';
	use SWServices\Authentication\AuthenticationService  as Authentication;
    $params = array(
        "url"=>"http://services.test.sw.com.mx",
        "user"=>"cuentaUsuario",
        "password"=> "contraseña"
    );
    try
    {
        header('Content-type: application/json');
        Authentication::auth($params);
        $token = Authentication::Token();
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
{
  "data": {
    "token": "T2lYQ0t4L0RHVkR4dHZ5Nkk1VHNEakZ3Y0J4Nk9GODZuRyt4cE1wVm5tbXB3..."
  },
  "status": "success"
}
```

## Timbrado ##

<details>
<summary>
Timbrado CFDI
</summary>

**Timbrar CFDI** Recibe el contenido de un **XML** ya emitido (sellado) en formato **String**  ó tambien puede ser en **Base64**, posteriormente si la factura y el token son correctos devuelve el complemento timbre en un string (**TFD**), en caso contrario lanza una excepción.

## Timbrar CFDI V1 ##
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
            "user"=>"cuentaUsuario",
            "password"=> "contraseña"
            );
        $xml = file_get_contents('./file.xml');
        StampService::Set($params);
        $result = StampService::StampV1($xml);
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
{
  "data": {
    "tfd": "<tfd:TimbreFiscalDigital xsi:schemaLocation=\"http://www.sat.gob.mx/TimbreFiscalDigital http://www.sat.gob.mx/sitio_internet/cfd/TimbreFiscalDigital/TimbreFiscalDigitalv11.xsd..."
  },
  "status": "success"
}
```
**Timbrar XML en formato string utilizando token**
```php
<?php
    require_once 'vendor/autoload.php';
    use SWServices\Stamp\StampService as StampService;

    $params = array(
        "url"=>"http://services.test.sw.com.mx",
        "token"=>"T2lYQ0t4L0RHVkR4dHZ5Nkk1VHNEakZ3Y0J4Nk9GODZuRyt4cE..............."
    );

    try
    {
        header('Content-type: application/json');
        $xml = file_get_contents('./file.xml');
        StampService::Set($params);
        $result = StampService::StampV1($xml);
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
{
  "data": {
    "tfd": "<tfd:TimbreFiscalDigital xsi:schemaLocation=\"http://www.sat.gob.mx/TimbreFiscalDigital http://www.sat.gob.mx/sitio_internet/cfd/TimbreFiscalDigital/TimbreFiscalDigitalv11.xsd..."
  },
  "status": "success"
}
```
#### Nueva funcionalidad para el soporte con servidores Proxy ####
Si tu posees un servidor proxy en tu empresa y deseas que la libreria lo use, debes pasar un parametro extra llamado "proxy".
```php
    $params = array(
        
        "proxy"=> "server.domain.com"
    );
```

## Timbrar CFDI V2 ##
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
            "user"=>"cuentaUsuario",
            "password"=> "contraseña"
            );
        $xml = file_get_contents('./file.xml');
        StampService::Set($params);
        $result = StampService::StampV2($xml);
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
{
  "data": {
      "tfd": "<tfd:TimbreFiscalDigital xsi:schemaLocation=\"http://www.sat.gob.mx/TimbreFiscalDigital http://www.sat.gob.mx/sitio_internet/cfd/TimbreFiscalDigital/TimbreFiscalDigitalv11.xsd...",
      "cfdi": "<?xml version=\"1.0\" encoding=\"utf-8\"?><cfdi:Comprobante xmlns:cfdi=\"http://www.sat.gob.mx/cfd/4\" xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\" xmlns:pago20=\"http://www.sat.gob.mx/Pagos20\" xsi:schemaLocation=\"http://www.sat.gob.mx/cfd/4 http://www.sat.gob.mx/sitio_internet/cfd/4/cfdv40.xsd http://www.sat.gob.mx/Pagos20 http://www.sat.gob.mx/sitio_internet/cfd/Pagos/Pagos20.xsd\" Version=\"4.0\"..."
  },
  "status": "success"
}
```
**Timbrar XML en formato string utilizando token**
```php
<?php
    require_once 'vendor/autoload.php';
    use SWServices\Stamp\StampService as StampService;

    $params = array(
        "url"=>"http://services.test.sw.com.mx",
        "token"=>"T2lYQ0t4L0RHVkR4dHZ5Nkk1VHNEakZ3Y0J4Nk9GODZuRyt4cE..............."
    );

    try
    {
        header('Content-type: application/json');
        $xml = file_get_contents('./file.xml');
        StampService::Set($params);
        $result = StampService::StampV2($xml);
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
{
  "data": {
    "tfd": "PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgiPz4NCjxjZmRpOkNvbXByb2JhbnRlIHhzaTpzY2hlbWFMb2NhdGlvbj0iaHR0cDovL3d3dy5zYXQuZ29iLm14L2NmZC8zIGh0dHA6Ly93...",
    "cfdi": "PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgiPz4NCjxjZmRpOkNvbXByb2JhbnRlIHhzaTpzY2hlbWFMb2NhdGlvbj0iaHR0cDovL3d3dy5zYXQuZ29iLm14L2NmZC8zIGh0dHA6Ly93..."
  },
  "status": "success"
}
```

**Timbrar XML en formato base64 utilizando token/credenciales**<br>

Si se desea, se puede usar la version 2 en la modalidad base64, esto quiere decir que se puede enviar el xml previamente sellado en formato base64, y la libreria le respondera la misma estructura de respuesta que se usa en v2 normal con el tfd, y cfdi en base64 tambien.
```php
<?php
    require_once 'vendor/autoload.php';
    use SWServices\Stamp\StampService as StampService;

    $params = array(
        "url"=>"http://services.test.sw.com.mx",
        "token"=>"T2lYQ0t4L0RHVkR4dHZ5Nkk1VHNEakZ3Y0J4Nk9GODZuRyt4cE..............."
    );

    try
    {
        header('Content-type: application/json');
        $xml = file_get_contents('./file.xml');
        StampService::Set($params);
        //Se agrega un segundo parametro de tipo boolean para activar la modalidad base64
        $result = StampService::StampV2($xml,true);
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
{
  "data": {
    "tfd": "PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgiPz4NCjxjZmRpOkNvbXByb2JhbnRlIHhzaTpzY2hlbWFMb2NhdGlvbj0iaHR0cDovL3d3dy5zYXQuZ29iLm14L2NmZC8zIGh0dHA6Ly93...",
    "cfdi": "PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgiPz4NCjxjZmRpOkNvbXByb2JhbnRlIHhzaTpzY2hlbWFMb2NhdGlvbj0iaHR0cDovL3d3dy5zYXQuZ29iLm14L2NmZC8zIGh0dHA6Ly93..."
  },
  "status": "success"
}
```
## Timbrar CFDI V3 ##
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
            "user"=>"cuentaUsuario",
            "password"=> "contraseña"
            );
        $xml = file_get_contents('./file.xml');
        StampService::Set($params);
        $result = StampService::StampV3($xml);
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
    "cfdi": "<?xml version=\"1.0\" encoding=\"utf-8\"?><cfdi:Comprobante xmlns:cfdi=\"http://www.sat.gob.mx/cfd/4\" xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\" xmlns:pago20=\"http://www.sat.gob.mx/Pagos20\" xsi:schemaLocation=\"http://www.sat.gob.mx/cfd/4 http://www.sat.gob.mx/sitio_internet/cfd/4/cfdv40.xsd http://www.sat.gob.mx/Pagos20 http://www.sat.gob.mx/sitio_internet/cfd/Pagos/Pagos20.xsd\" Version=\"4.0\"..."
  },
  "status": "success"
}
```
**Timbrar XML en formato string utilizando token**
```php
<?php
    require_once 'vendor/autoload.php';
    use SWServices\Stamp\StampService as StampService;

    $params = array(
        "url"=>"http://services.test.sw.com.mx",
        "token"=>"T2lYQ0t4L0RHVkR4dHZ5Nkk1VHNEakZ3Y0J4Nk9GODZuRyt4cE..............."
    );

    try
    {
        header('Content-type: application/json');
        $xml = file_get_contents('./file.xml');
        StampService::Set($params);
        $result = StampService::StampV3($xml);
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
{
  "data": {
    "cfdi": "<?xml version=\"1.0\" encoding=\"utf-8\"?><cfdi:Comprobante xmlns:cfdi=\"http://www.sat.gob.mx/cfd/4\" xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\" xmlns:pago20=\"http://www.sat.gob.mx/Pagos20\" xsi:schemaLocation=\"http://www.sat.gob.mx/cfd/4 http://www.sat.gob.mx/sitio_internet/cfd/4/cfdv40.xsd http://www.sat.gob.mx/Pagos20 http://www.sat.gob.mx/sitio_internet/cfd/Pagos/Pagos20.xsd\" Version=\"4.0\"..."
  },
  "status": "success"
}
```

## Timbrar CFDI V4 ##
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
            "user"=>"cuentaUsuario",
            "password"=> "contraseña"
            );
        $xml = file_get_contents('./file.xml');
        StampService::Set($params);
        $result = StampService::StampV4($xml);
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
    "cfdi": "<?xml version=\"1.0\" encoding=\"utf-8\"?><cfdi:Comprobante xmlns:cfdi=\"http://www.sat.gob.mx/cfd/4\" xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\" xmlns:pago20=\"http://www.sat.gob.mx/Pagos20\" xsi:schemaLocation=\"http://www.sat.gob.mx/cfd/4 http://www.sat.gob.mx/sitio_internet/cfd/4/cfdv40.xsd http://www.sat.gob.mx/Pagos20 http://www.sat.gob.mx/sitio_internet/cfd/Pagos/Pagos20.xsd\" Version=\"4.0\"..."
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
        "token"=>"T2lYQ0t4L0RHVkR4dHZ5Nkk1VHNEakZ3Y0J4Nk9GODZuRyt4cE..............."
    );

    try
    {
        header("Content-type: application/json");
        $xml = file_get_contents("./file.xml");
        StampService::Set($params);
        $result = StampService::StampV4($xml);
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
    "cfdi": "<?xml version=\"1.0\" encoding=\"utf-8\"?><cfdi:Comprobante xmlns:cfdi=\"http://www.sat.gob.mx/cfd/4\" xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\" xmlns:pago20=\"http://www.sat.gob.mx/Pagos20\" xsi:schemaLocation=\"http://www.sat.gob.mx/cfd/4 http://www.sat.gob.mx/sitio_internet/cfd/4/cfdv40.xsd http://www.sat.gob.mx/Pagos20 http://www.sat.gob.mx/sitio_internet/cfd/Pagos/Pagos20.xsd\" Version=\"4.0\"..."
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
        "token"=>"T2lYQ0t4L0RHVkR4dHZ5Nkk1VHNEakZ3Y0J4Nk9GODZuRyt4cE..............."
    );

    try
    {
        header('Content-type: application/json');
        $xml = file_get_contents('./file.xml');
        StampService::Set($params);
        //Se agrega un segundo parametro de tipo boolean para activar la modalidad base64
        $result = StampService::StampV4($xml,true);
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

</details>

<details>
<summary>
Emisión Timbrado
</summary>

**Emisión Timbrado** Recibe el contenido de un **XML** en formato **String**, posteriormente si la factura y el token son correctos, genera el sellado, y devuelve el comprobante ya timbrado en formato string (**CFDI**), en caso contrario lanza una excepción.

### Emisión timbrado V1 ###
Está versión de timbrado regresa únicamente el ***TFD***.

**Ejemplo de uso**
```php
    use SWServices\Stamp\EmisionTimbrado as EmisionTimbrado;
    $params = array(
        "url"=>"http://services.test.sw.com.mx",
        "user"=>"usuario@demo.com",
        "password"=> "contraseña"
    );

    $xml = file_get_contents('Test/Resources/file.xml');
    EmisionTimbrado::Set($params);
    $resultadoIssue = EmisionTimbrado::EmisionTimbradoV1($xml);
    var_dump($resultadoIssue);
```

### Emisión timbrado V2 ###
Está versión de timbrado regresa ***TFD*** y el ***CFDI***.

**Ejemplo de uso**
```php
    use SWServices\Stamp\EmisionTimbrado as EmisionTimbrado;
    $params = array(
        "url"=>"http://services.test.sw.com.mx",
        "user"=>"usuario@demo.com",
        "password"=> "contraseña"
    );

    $xml = file_get_contents('Test/Resources/file.xml');
    EmisionTimbrado::Set($params);
    $resultadoIssue = EmisionTimbrado::EmisionTimbradoV2($xml);
    var_dump($result);
```
### Emisión timbrado V3 ###
Está versión de timbrado regresa únicamente el ***CFDI***.

**Ejemplo de uso**
```php
    use SWServices\Stamp\EmisionTimbrado as EmisionTimbrado;
    $params = array(
        "url"=>"http://services.test.sw.com.mx",
        "user"=>"usuario@demo.com",
        "password"=> "contraseña"
    );

    $xml = file_get_contents('Test/Resources/file.xml');
    EmisionTimbrado::Set($params);
    $resultadoIssue = EmisionTimbrado::EmisionTimbradoV3($xml);
    var_dump($result);
```

### Emisión timbrado V4 ###
Está versión de timbrado regresa ***CFDI***, ***CadenaOriginalSAT***, ***noCertificadoSat***, ***noCertificadoCFDI***, ***UUID***, ***selloSAT***, ***selloCFDI***, ***fechaTimbrado*** y ***QRCode***.

**Ejemplo de uso**
```php
    use SWServices\Stamp\EmisionTimbrado  as EmisionTimbrado;
    $params = array(
        "url"=>"http://services.test.sw.com.mx",
        "user"=>"usuario@demo.com",
        "password"=> "contraseña"
    );

    $xml = file_get_contents('Test/Resources/file.xml');
    EmisionTimbrado::Set($params);
    $resultadoIssue = EmisionTimbrado::EmisionTimbradoV4($xml);
    var_dump($result);
```
</details>

<details>
<summary>
Emisión Timbrado JSON
</summary>

## Emisión Timbrado JSON ##
**Emisión Timbrado JSON** Recibe el contenido de un **JSON** en formato **String**, posteriormente si el JSON y el token son correctos, genera el armado y sellado del XML, posteriormente devuelve el comprobante ya timbrado en formato string (**CFDI**), en caso contrario mostrará error al ser enviado a timbrar.

### Emisión timbrado JSON V1 ###
Está versión de timbrado regresa únicamente el ***TFD***.

**Ejemplo de uso**
```php
    use SWServices\JSonIssuer\JsonEmisionTimbrado as JsonEmisionTimbrado;
    $params = array(
        "url"=>"http://services.test.sw.com.mx",
        "user"=>"usuario@demo.com",
        "password"=> "contraseña"
    );

    $json = file_get_contents("Test/Resources/cfdi.json");
    JsonEmisionTimbrado::Set($params);
    $resultadoJson = JsonEmisionTimbrado::jsonEmisionTimbradoV1($json);
    var_dump($resultadoJson);
```
### Emisión timbrado JSON V2 ###
Está versión de timbrado regresa el ***TFD*** y ***CFDI***.

**Ejemplo de uso**
```php
    use SWServices\JSonIssuer\JsonEmisionTimbrado as JsonEmisionTimbrado;
    $params = array(
        "url"=>"http://services.test.sw.com.mx",
        "user"=>"usuario@demo.com",
        "password"=> "contraseña"
    );

    $json = file_get_contents("Test/Resources/cfdi.json");
    JsonEmisionTimbrado::Set($params);
    $resultadoJson = JsonEmisionTimbrado::jsonEmisionTimbradoV2($json);
    var_dump($resultadoJson);
```
### Emisión timbrado JSON V3 ###
Está versión de timbrado regresa únicamente el ***CFDI***.

**Ejemplo de uso**
```php
    use SWServices\JSonIssuer\JsonEmisionTimbrado as jsonEmisionTimbrado;
    $params = array(
        "url"=>"http://services.test.sw.com.mx",
        "user"=>"usuario@demo.com",
        "password"=> "contraseña"
    );

    $json = file_get_contents("Test/Resources/cfdi.json");
    jsonEmisionTimbrado::Set($params);
    $resultadoJson = JsonEmisionTimbrado::jsonEmisionTimbradoV3($json);
    var_dump($resultadoJson);
```
### Emisión timbrado JSON V4 ###
Está versión de timbrado regresa ***CFDI***, ***CadenaOriginalSAT***, ***noCertificadoSat***, ***noCertificadoCFDI***, ***UUID***, ***selloSAT***, ***selloCFDI***, ***fechaTimbrado*** y ***QRCode***.

**Ejemplo de uso**
```php
    use SWServices\JSonIssuer\JsonEmisionTimbrado as JsonEmisionTimbrado;
    $params = array(
        "url"=>"http://services.test.sw.com.mx",
        "user"=>"usuario@demo.com",
        "password"=> "contraseña"
    );

    $json = file_get_contents("Test/Resources/cfdi.json");
    JsonEmisionTimbrado::Set($params);
    $resultadoJson = JsonEmisionTimbrado::jsonEmisionTimbradoV4($json);
    var_dump($resultadoJson);
```
</details>

:pushpin: ***NOTA:*** Existen varias versiones de respuesta, las cuales son las siguientes:

| Version |                         Respuesta                             | 
|---------|---------------------------------------------------------------|
|  V1     | Devuelve el timbre fiscal digital                             | 
|  V2     | Devuelve el timbre fiscal digital y el CFDI timbrado          | 
|  V3     | Devuelve el CFDI timbrado                                     | 
|  V4     | Devuelve todos los datos del timbrado                         |

Para mayor referencia de estas versiones de respuesta, favor de visitar el siguiente [link](https://developers.sw.com.mx/knowledge-base/versiones-de-respuesta-timbrado/).

## Cancelación CFDI ##

Este servicio se utiliza para cancelar documentos xml y se puede hacer mediante varios métodos **Cancelación CSD**, **Cancelación PFX**, **Cancelacion por XML** y **Cancelación UUID**.

<details>
<summary>
Cancelación por CSD
</summary>

Se deben incluir los siguientes datos:

* Certificado (.cer)
* Key (.key)
* Password del archivo key
* RFC emisor 
* UUID
* Motivo
* Folio Sustitución (sólo cuando Motivo=01)


Paso 1: Obtener token de acceso, o en su defecto usar token infinito

Primeramente se deberá autenticar en nuestros servicios con el token de acceso, o si se desea,  se puede usar el token infinito.

Paso 2: Enviar datos necesarios

Se envían los datos necesarios para la cancelación en la instancia del metodo de cancelacion

Cabe mencionar que los archivos **.cer y .key**,  al ser binarios, **deberán enviarse en formato base64** para que podamos procesarlos en nuestro servidor.
```php
<?php 
    include('./SWSDK.php');
    use SWServices\Cancelation\CancelationService as CancelationService;

    $rfc="";
    $password="";
    $uuid=" ";
    $motivo="01";
    $foliosustitucion=" ";
    $b64Cer="MIIFuzCCA6OgAwIBAgIU.........";
    $b64Key="MIIFDjBABgkqhkiG9w0B.........";
    $url="http://services.test.sw.com.mx/";
    $token=" ";
 
    $params = array(
        "url"=>$url,  
        "token"=>$token,
    );
    
    try {
        header('Content-type: application/json');
        $cancelationService = CancelationService::Set($params);
        $result = $cancelationService::CancelationByCSD($rfc, $uuid, $motivo, $b64Cer, $b64Key, $password,$foliosustitucion);
        echo json_encode($result);
    } catch(Exception $e) {
        header('Content-type: text/plain');
        echo $e->getMessage();
    }
?>
```
</details>

<details>
<summary>
Cancelación por XML
</summary>

Como su nombre lo indica, este servicio recibe únicamente el XML sellado con los UUID a cancelar.

Paso 1: Obtener token de acceso, o en su defecto usar token infinito

Primeramente se deberá autenticar en nuestros servicios con el token de acceso, o si se desea,  se puede usar el token infinito.

Paso 2: Enviar datos necesarios

Se envían los datos necesarios para la cancelación, que únicamente es el XML.

```php
<?php 
    include('./SWSDK.php');
    use SWServices\Cancelation\CancelationService as CancelationService;

    $resultSpect = "success";
	$params = array(
		"url"=>"http://services.test.sw.com.mx/",	
		"token"=>" "				
	);
            $xml=file_get_contents("../Test/Resources/CancelationResources/cancelByXml.xml");
		    try {
		        $cancelationService = CancelationService::Set($params);
		        $result = $cancelationService::CancelationByXML($xml);
                echo json_encode($result);
            } catch(Exception $e) {
                header('Content-type: text/plain');
                echo $e->getMessage();
            }
?>
```
</details>


<details>
<summary>
Cancelación por PFX
</summary>

Se deben incluir los siguientes datos:

* Pfx 
* Password del archivo key
* RFC emisor 
* UUID
* Motivo
* Folio Sustitución (sólo cuando Motivo=01)

Paso 1: Obtener token de acceso, o en su defecto usar token infinito

Primeramente se deberá autenticar en nuestros servicios con el token de acceso, o si se desea,  se puede usar el token infinito.

Paso 2: Enviar datos necesarios

Se envían los datos necesarios para la cancelación y el token obtenido previamente.

```php
<?php 
    include('./SWSDK.php');
    use SWServices\Cancelation\CancelationService as CancelationService;

    $rfc=" ";
    $password=" ";
    $uuid=" ";
    $motivo=" ";
    $foliosustitucion=" ";
    $b64Pfx="MIIL+QIBAzCCC.................";
    $url="http://services.test.sw.com.mx/";
    $token=" ";

    $params = array(
        "url"=>$url,  
        "token"=>$token
    );

    try {
        header('Content-type: application/json');
        $cancelationService = CancelationService::Set($params);
        $result = $cancelationService::CancelationByPFX($rfc, $uuid, $motivo, $pfxB64, $passwordPfx,$foliosustitucion);
        echo json_encode($result);
    } catch(Exception $e) {
        header('Content-type: text/plain');
        echo $e->getMessage();
    }
?>
```
</details>

<details>
<summary>
Cancelación por UUID
</summary>

Se deben incluir los siguientes datos:

* RFC emisor 
* UUID
* Motivo
* Folio Sustitución (sólo cuando Motivo=01)

Paso 1: Obtener token de acceso, o en su defecto usar token infinito

Primeramente se deberá autenticar en nuestros servicios en orden de obtener token de acceso, o si se desea,  se puede usar el token infinito.

Paso 2: Enviar datos necesarios

Se envían los datos necesarios para la cancelación y el token obtenido previamente.

```php
<?php 
    include('./SWSDK.php');
    use SWServices\Cancelation\CancelationService as CancelationService;

    $rfc=" ";
    $uuid=" ";
    $motivo=" ";
    $foliosustitucion=" ";
    $params = array(
        "url"=>"http://services.test.sw.com.mx",  
        "token"=>" "
    );
    
    try {
        header('Content-type: application/json');
        $cancelationService = CancelationService::Set($params);
        $result = $cancelationService::CancelationByUUID($rfc, $uuid, $motivo,$foliosustitucion);
        echo json_encode($result);
    } catch(Exception $e) {
        header('Content-type: text/plain');
        echo $e->getMessage();
    }
?>
```
</details>

<details>
<summary>
Respuestas de cancelación
</summary>

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
| 201  |Se considera una solicitud de cancelación exitosa, sin embargo esto no asegura su cancelación. |
| 202 |  Folio Fiscal Previamente cancelado | Se considera solicitud de cancelación previamente enviada. Estatus Cancelado ante el SAT. |
| 203 | Folio Fiscal No corresponde al emisor.  |  |
| 204 | Folio Fiscal No Aplicable a Cancelación. |  |
| 205 | Folio Fiscal No Existe.  | El sat da una prorroga de 48 hrs para que el comprobante aparezca con estatus Vigente posterior al envió por parte del Proveedor de Certificación de CFDI. Puede que algunos comprobantes no aparezcan al | 204 | Folio Fiscal No Aplicable a Cancelación. |  |momento, es necesario esperar por lo menos 48 hrs. |
| 206 | UUID no corresponde a un CFDI del Sector Primario. |  |
| 207 | No se especificó el motivo de cancelación o el motivo no es valido. |  |
| 208 | Folio Sustitución invalido. |  |
| 209 | Folio Sustitución no requerido. |  |
| 210 | 	La fecha de solicitud de cancelación es mayor a la fecha de declaración. |  |
| 211 | La fecha de solicitud de cancelación límite para factura global. |  |
| 212 | Relación no valida o inexistente. |  |
| 300 | Usuario No Válido. |  |
| 301 | XML Mal Formado. | Este código de error se regresa cuando el request posee información invalida, ejemplo: un RFC de receptor no válido. |
| 302 | XML Mal Formado. |  |
| 304 | Certificado Revocado o Caduco. | El certificado puede ser inválido por múltiples razones como son el tipo, la vigencia, etc. |
| 305 | Certificado Inválido. | El certificado puede ser inválido por múltiples razones como son el tipo, la vigencia, etc. |
| 309 | Certificado Inválido. | El certificado puede ser inválido por múltiples razones como son el tipo, la vigencia, etc. |
| 310 | CSD Inválido. |
| 311 | Motivo Inválido. | Clave de motivo de cancelación no válida |
| 312 | UUID no relacionado | UUID no relacionado de acuerdo a la clave de motivo de cancelación | |

</details>

## Consultar Saldo ##

<details>
<summary>Ejemplos</summary>

Este servicio recibe el token y genera los elementos que componen la consulta de saldos:

* ID saldo cliente
* ID cliente usuario
* Saldo timbres
* Timbres utilizados
* Fecha de expiracion
* Ilimitado
* Timbres asignados

Paso 1: Se deberá autenticar en nuestros servicios en orden de obtener token de acceso, o si se desea, se puede usar el token infinito.

Paso 2: Enviar token de acceso. Se envía el token para realizar la consulta de saldo.

```php
<?php
    require_once 'vendor/autoload.php';
    use SWServices\AccountBalance\AccountBalanceService as AccountBalanceService;

    $params = array(
        'url'=> 'services.test.sw.com.mx',
        'token'=> 'T2lYQ0t4L0RHVkR4dHZ5Nkk1VHNEakZ3Y0J4Nk9GODZuRyt4cE...............',
    );
    try {
        AccountBalanceService::Set($params);
        $result = AccountBalanceService::GetAccountBalance();
        var_dump($result);
    } catch(Exception $e) {
        echo 'Caught exception: ',  $e->getMessage(), "\n";
    }
?>
```

### Respuestas de consulta de saldo ###
El response de consulta de saldo retorna la siguiente estructura en caso de error o en caso de petición satisfactoria:

>Tipos de respuesta
>En caso de una respuesta exitosa, se regresará un 200. En caso de una respuesta no exitosa, se regresará un código >diferente de 200, el código puede variar dependiendo del problema dado.

### Respuesta exitosa ###
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

### Respuesta no exitosa ###
```json
{
    "message": "Parámetros incompletos",
    "status": "error"
}
```
</details>

## Consulta Estatus ##

<details>
<summary>
Consulta Estatus SAT
</summary>

**Consulta Status SAT** Recibe los parámetros de ***URL Soap***, ***RFC Emisor***, ***RFC Receptor***, ***Total***, y ***UUID*** en formato **String**, posteriormente hace la consulta en el SOAP proporcionado sobre el estatus de la factura.

Ejemplo de uso
```php
    require_once 'SWSDK.php';
    use SWServices\SatQuery\SatQueryService as SatQueryService;

    $soapUrl = "http://consultaqrfacturaelectronicatest.sw.com.mx/ConsultaCFDIService.svc";
    $re = "LAN8507268IA";
    $rr = "LAN7008173R5";
    $tt = 5800.00;
    $uuid = "6ab07bef-4446-43ea-a3fd-04a804309457";
    $sello = "zNDhfw=";
    $consultaCfdi = SatQueryService::ServicioConsultaSAT($soapUrl, $re, $rr, $tt, $uuid, $sello);
    var_dump($consultaCfdi);
```
</details>

## Consulta de Solicitudes pendientes de Aceptar/Rechazar ##
Este servicio devuelve una lista [Array] de UUID correspondientes a las solicitudes que tiene pendientes de aceptar o rechazar determinado RFC. Así mismo este servicio recibe solamente el RFC para consultar.


<details>
  <summary>Ejemplo de uso</summary>

```php
    require_once 'SWSDK.php';
    use SWServices\Cancelation\CancelationService as cancelationService;
    $params = array(
        "url"=>"http://services.test.sw.com.mx",
        "user"=>"cuentaUsuario",
        "password"=> "contraseña"
    );

    $rfc = "LAN7008173R5";
    cancelationService::Set($params);
    $consultaPendientes = cancelationService::PendientesPorCancelar($rfc);
    var_dump($consultaPendientes);
```
</details>

## Aceptar/Rechazar Cancelación ##

**Aceptar/Rechazar** es el servicio mediante el cual el receptor puede aceptar o rechazar un UUID que obtiene de su lista de pendientes. El método tiene varias maneras de ser consumido, por CSD, PFX, sólo UUID y por XML.

<details>
<summary>
Aceptar / Rechazar por CSD
</summary>

<br> Método mediante el cual el receptor podrá manifestar la aceptación o rechazo de la solicitud de cancelación mediante CSD.

Este método recibe los siguientes parámetros:
* Url Servicios SW
* Usuario y contraseña ó token
* Certificado del receptor en Base64
* Llave(key) del receptor en Base64
* RFC del emisor
* Contraseña del certificado
* Arreglo de objetos donde se especifican los UUID y acción a realizar

**Ejemplo de consumo de la librería para la aceptacion/rechazo de la solicitud por CSD mediante usuario y contraseña**

```php
    require_once 'SWSDK.php';
    use SWServices\AcceptReject\AcceptRejectService as AcceptRejectService;

    $params = array(
        "url"=>"http://services.test.sw.com.mx",
        "user"=>"cuentaUsuario",
        "password"=> "contraseña"
    );
    $cerB64 = base64_encode(file_get_contents('Test\Resources\cert_pruebas\EKU9003173C9.cer'));
    $keyB64 = base64_encode(file_get_contents('Test\Resources\cert_pruebas\EKU9003173C9.key'));
    $password = "12345678a";
    $rfc = "EKU9003173C9";
    $list = [
        ['uuid' => 'dcbddeb9-a208-42be-ae5b-0390a929fe48', 'action' => 'Aceptacion']
    ];
    $acceptReject = AcceptRejectService::Set($params);
    $aceptarRechazar = $acceptReject::AceptarRechazarCancelacionCSD($rfc, $list, $cerB64, $keyB64, $password);
    var_dump($aceptarRechazar);
```
</details>

<details>
<summary>
Aceptar / Rechazar por PFX
</summary>

<br> Método mediante el cual el receptor podrá manifestar la aceptación o rechazo de la solicitud de cancelación mediante PFX.

Este método recibe los siguientes parámetros:
* Url Servicios SW
* Usuario y contraseña ó token
* Archivo Pfx en Base64
* Contraseña del certificado
* RFC del emisor
* Arreglo de objetos donde se especifican los UUID y acción a realizar

**Ejemplo de consumo de la librería para la aceptación/rechazo de la solicitud por PFX mediante usuario y contraseña**

```php
    require_once 'SWSDK.php';
    use SWServices\AcceptReject\AcceptRejectService as AcceptRejectService;

    $params = array(
        "url"=>"http://services.test.sw.com.mx",
        "user"=>"cuentaUsuario",
        "password"=> "contraseña"
    );

    $pfxB64 = base64_encode(file_get_contents('Test\Resources\cert_pruebas\EKU9003173C9.pfx'));
    $passwordPfx = "swpass";
    $rfc = "EKU9003173C9";
    $list = [
        ['uuid' => 'dcbddeb9-a208-42be-ae5b-0390a929fe48', 'action' => 'Aceptacion']
    ];
            
    $acceptReject = AcceptRejectService::Set($params);
    $aceptarRechazar = $acceptReject::AceptarRechazarCancelacionPFX($rfc, $list, $pfxB64, $passwordPfx);
    var_dump($aceptarRechazar);
```
</details>

<details>
<summary>
Aceptar / Rechazar por XML
</summary>

<br>Método mediante el cual el receptor podrá manifestar la aceptación o rechazo de la solicitud de cancelación mediante XML.

Este método recibe los siguientes parámetros:
* Url Servicios SW
* Usuario y contraseña ó token
* XML con datos requeridos para la aceptación/rechazo de la cancelación

**Ejemplo de XML**

```xml
<SolicitudAceptacionRechazo xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
    xmlns:xsd="http://www.w3.org/2001/XMLSchema" Fecha="2023-11-13T17:00:44" RfcPacEnviaSolicitud="LSO1306189R5" RfcReceptor="EKU9003173C9"
    xmlns="http://cancelacfd.sat.gob.mx">
    <Folios>
        <UUID>dcbddeb9-a208-42be-ae5b-0390a929fe48</UUID>
        <Respuesta>Aceptacion</Respuesta>
    </Folios>
    <Signature xmlns="http://www.w3.org/2000/09/xmldsig#">
        <SignedInfo>
            <CanonicalizationMethod Algorithm="http://www.w3.org/TR/2001/REC-xml-c14n-20010315" />
            <SignatureMethod Algorithm="http://www.w3.org/2001/04/xmldsig-more#rsa-sha256" />
            <Reference URI="">
                <Transforms>
                    <Transform Algorithm="http://www.w3.org/2000/09/xmldsig#enveloped-signature" />
                </Transforms>
                <DigestMethod Algorithm="http://www.w3.org/2001/04/xmlenc#sha256" />
                <DigestValue>jMSiI7taWgjRDm0zzJF2hmayhWZcEAPQRwXkDhzsXAw=</DigestValue>
            </Reference>
        </SignedInfo>
        <SignatureValue>sRpjcm/c/Prxdp7+JsatvgmwCDl7YwYXMpOdU9Oh3CCzUPyYEM0wwEzQApFnRrr4/DDuYTF/ajaQ2fL9hjhYqm21eR+1W5AWQHCLJ7Pc6BnqCIj/xIGhRoHGMZNnb9ZvT7kEt0P2clG4T5u4rGfL3p31mQaJLxKPYm/BR2zhzQuE33lyv3AnQA8LbpqDoMi/ZW2SSjRgFNhs1JUI6EQQmwLRZ7KU+LjhKDGFBgFJ9RQZgJOXSyRoTToJHLktlcvzvS45HLUJDus5g8B/4mOGy9tafPGtddrzi9BV/XbadFdAF5LXFq6ng7jX3EavBX1/B9u4SIJzEE9YD8pqqcD6Xw==</SignatureValue>
        <KeyInfo>
            <X509Data>
                <X509IssuerSerial>
                    <X509IssuerName>OID.1.2.840.113549.1.9.2=responsable: ACDMA-SAT, OID.2.5.4.45=2.5.4.45, L=COYOACAN, S=CIUDAD DE MEXICO, C=MX, PostalCode=06370, STREET=3ra cerrada de caliz, E=oscar.martinez@sat.gob.mx, OU=SAT-IES Authority, O=SERVICIO DE ADMINISTRACION TRIBUTARIA, CN=AC UAT</X509IssuerName>
                    <X509SerialNumber>292233162870206001759766198462772978647764840758</X509SerialNumber>
                </X509IssuerSerial>
                <X509Certificate>MIIFsDCCA5igAwIBAgIUMzAwMDEwMDAwMDA1MDAwMDM0MTYwDQYJKoZIhvcNAQELBQAwggErMQ8wDQYDVQQDDAZBQyBVQVQxLjAsBgNVBAoMJVNFUlZJQ0lPIERFIEFETUlOSVNUUkFDSU9OIFRSSUJVVEFSSUExGjAYBgNVBAsMEVNBVC1JRVMgQXV0aG9yaXR5MSgwJgYJKoZIhvcNAQkBFhlvc2Nhci5tYXJ0aW5lekBzYXQuZ29iLm14MR0wGwYDVQQJDBQzcmEgY2VycmFkYSBkZSBjYWxpejEOMAwGA1UEEQwFMDYzNzAxCzAJBgNVBAYTAk1YMRkwFwYDVQQIDBBDSVVEQUQgREUgTUVYSUNPMREwDwYDVQQHDAhDT1lPQUNBTjERMA8GA1UELRMIMi41LjQuNDUxJTAjBgkqhkiG9w0BCQITFnJlc3BvbnNhYmxlOiBBQ0RNQS1TQVQwHhcNMjMwNTE4MTE0MzUxWhcNMjcwNTE4MTE0MzUxWjCB1zEnMCUGA1UEAxMeRVNDVUVMQSBLRU1QRVIgVVJHQVRFIFNBIERFIENWMScwJQYDVQQpEx5FU0NVRUxBIEtFTVBFUiBVUkdBVEUgU0EgREUgQ1YxJzAlBgNVBAoTHkVTQ1VFTEEgS0VNUEVSIFVSR0FURSBTQSBERSBDVjElMCMGA1UELRMcRUtVOTAwMzE3M0M5IC8gVkFEQTgwMDkyN0RKMzEeMBwGA1UEBRMVIC8gVkFEQTgwMDkyN0hTUlNSTDA1MRMwEQYDVQQLEwpTdWN1cnNhbCAxMIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAtmecO6n2GS0zL025gbHGQVxznPDICoXzR2uUngz4DqxVUC/w9cE6FxSiXm2ap8Gcjg7wmcZfm85EBaxCx/0J2u5CqnhzIoGCdhBPuhWQnIh5TLgj/X6uNquwZkKChbNe9aeFirU/JbyN7Egia9oKH9KZUsodiM/pWAH00PCtoKJ9OBcSHMq8Rqa3KKoBcfkg1ZrgueffwRLws9yOcRWLb02sDOPzGIm/jEFicVYt2Hw1qdRE5xmTZ7AGG0UHs+unkGjpCVeJ+BEBn0JPLWVvDKHZAQMj6s5Bku35+d/MyATkpOPsGT/VTnsouxekDfikJD1f7A1ZpJbqDpkJnss3vQIDAQABox0wGzAMBgNVHRMBAf8EAjAAMAsGA1UdDwQEAwIGwDANBgkqhkiG9w0BAQsFAAOCAgEAFaUgj5PqgvJigNMgtrdXZnbPfVBbukAbW4OGnUhNrA7SRAAfv2BSGk16PI0nBOr7qF2mItmBnjgEwk+DTv8Zr7w5qp7vleC6dIsZFNJoa6ZndrE/f7KO1CYruLXr5gwEkIyGfJ9NwyIagvHHMszzyHiSZIA850fWtbqtythpAliJ2jF35M5pNS+YTkRB+T6L/c6m00ymN3q9lT1rB03YywxrLreRSFZOSrbwWfg34EJbHfbFXpCSVYdJRfiVdvHnewN0r5fUlPtR9stQHyuqewzdkyb5jTTw02D2cUfL57vlPStBj7SEi3uOWvLrsiDnnCIxRMYJ2UA2ktDKHk+zWnsDmaeleSzonv2CHW42yXYPCvWi88oE1DJNYLNkIjua7MxAnkNZbScNw01A6zbLsZ3y8G6eEYnxSTRfwjd8EP4kdiHNJftm7Z4iRU7HOVh79/lRWB+gd171s3d/mI9kte3MRy6V8MMEMCAnMboGpaooYwgAmwclI2XZCczNWXfhaWe0ZS5PmytD/GDpXzkX0oEgY9K/uYo5V77NdZbGAjmyi8cE2B2ogvyaN2XfIInrZPgEffJ4AB7kFA2mwesdLOCh0BLD9itmCve3A1FGR4+stO2ANUoiI3w3Tv2yQSg4bjeDlJ08lXaaFCLW2peEXMXjQUk7fmpb5MNuOUTW6BE=</X509Certificate>
            </X509Data>
        </KeyInfo>
    </Signature>
</SolicitudAceptacionRechazo>
```

**Ejemplo de consumo de la librería para la aceptación/rechazo de la solicitud por XML mediante usuario y contraseña**
```php
    require_once 'SWSDK.php';
    use SWServices\AcceptReject\AcceptRejectService as AcceptRejectService;

    $params = array(
        "url"=>"http://services.test.sw.com.mx",
        "user"=>"cuentaUsuario",
        "password"=> "contraseña"
    );
    $xml = file_get_contents('Test\Resources\acceptReject_xml.xml');

    $acceptReject = AcceptRejectService::Set($params);
    $aceptarRechazar = $acceptReject::AceptarRechazarCancelacionXML($xml);
    var_dump($aceptarRechazar);
```
</details>

<details>
<summary>
Aceptar / Rechazar por UUID
</summary>

<br>Método mediante el cual el receptor podrá manifestar la aceptación o rechazo de la solicitud de cancelación mediante UUID.

Este método recibe los siguientes parámetros:
* Url Servicios SW
* Usuario y contraseña ó token
* RFC del receptor
* UUID de la factura que se requiere aceptar/rechazar
* Acción que se requiera realizar Aceptación/Rechazo

:pushpin: ***NOTA:*** El usuario deberá tener sus certificados en el administrador de timbres para la utilización de este método.

**Ejemplo de consumo de la librería para la aceptación/rechazo de la solicitud por UUID mediante usuario y contraseña**
```php
    require_once 'SWSDK.php';
    use SWServices\AcceptReject\AcceptRejectService as AcceptRejectService;

    $params = array(
        "url"=>"http://services.test.sw.com.mx",
        "user"=>"cuentaUsuario",
        "password"=> "contraseña"
    );

    $rfc = "EKU9003173C9";
    $uuid = "dcbddeb9-a208-42be-ae5b-0390a929fe48";
    $action = "Rechazo";

    $acceptReject = AcceptRejectService::Set($params);
    $aceptarRechazar = $acceptReject::AceptarRechazarCancelacionUUID($rfc, $uuid, $action);
    var_dump($aceptarRechazar);
```
</details>

## Consulta documentos relacionados ##
Este servicio nos permite conocer las facturas que se encuentren relacionadas a un UUID. El método tiene varias maneras de ser consumido, por CSD, PFX, sólo UUID y por XML.

<details>
<summary>
Documentos relacionados por CSD
</summary>

Está modalidad recibe como parámetros el RFC del Receptor, Certificado y Llave privada [En base64], contraseña de Llave privada y  el UUID a consultar.

Ejemplo de uso
```php
    require_once 'SWSDK.php';
    use SWServices\Cancelation\CancelationService as cancelationService;
    $params = array(
        "url"=>"http://services.test.sw.com.mx",
        "user"=>"cuentaUsuario",
        "password"=> "contraseña"
    );

    $cerB64 = base64_encode(file_get_contents('Test\Resources\CSD_Pruebas_CFDI_LAN7008173R5.cer'));
    $keyB64 = base64_encode(file_get_contents('Test\Resources\CSD_Pruebas_CFDI_LAN7008173R5.key'));
    $rfc = "LAN7008173R5";
    $uuid = "52c02b64-d12e-4163-b581-bf749238896d";
    cancelationService::Set($params);
    $consultaRelacionados = cancelationService::ConsultarCFDIRelacionadosCSD($rfc, $cerB64, $keyB64, $password, $uuid);
    var_dump($consultaRelacionados);
```
</details>

<details>
<summary>
Documentos relacionados con PFX
</summary>

Está modalidad recibe como parámetros el RFC del Receptor, PFX [En base64], contraseña de Llave privada y  el UUID a consultar.

Ejemplo de uso
```php
    require_once 'SWSDK.php';
    use SWServices\Cancelation\CancelationService as cancelationService;
    $params = array(
        "url"=>"http://services.test.sw.com.mx",
        "user"=>"cuentaUsuario",
        "password"=> "contraseña"
    );
    
    $pfxB64 = base64_encode(file_get_contents('Test\Resources\CSD_Pruebas_CFDI_LAN7008173R5.pfx'));
    $rfc = "LAN7008173R5";
    $uuid = "52c02b64-d12e-4163-b581-bf749238896d";
    cancelationService::Set($params);
    $consultaRelacionados = cancelationService::ConsultarCFDIRelacionadosPFX($rfc, $pfxB64, $password, $uuid);
    var_dump($consultaRelacionados);
```
</details>

<details>
<summary>
Documentos relacionados con XML
</summary>

Está modalidad recibe como parámetro el XML para consulta de documentos relacionados.

XML a enviar
```xml
<PeticionConsultaRelacionados RfcPacEnviaSolicitud="DAL050601L35" RfcReceptor="LAN7008173R5" Uuid="52C02B64-D12E-4163-B581-BF749238896D" xmlns="http://cancelacfd.sat.gob.mx" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
	<Signature xmlns="http://www.w3.org/2000/09/xmldsig#">
		<SignedInfo>
			<CanonicalizationMethod Algorithm="http://www.w3.org/TR/2001/REC-xml-c14n-20010315"/>
			<SignatureMethod Algorithm="http://www.w3.org/2000/09/xmldsig#rsa-sha1"/>
			<Reference URI="">
				<Transforms>
					<Transform Algorithm="http://www.w3.org/2000/09/xmldsig#enveloped-signature"/>
				</Transforms>
				<DigestMethod Algorithm="http://www.w3.org/2000/09/xmldsig#sha1"/>
				<DigestValue>4OL2v3i8dqK9qc4T4gbidVv0D3Q=</DigestValue>
			</Reference>
		</SignedInfo>
		<SignatureValue>br/VM4d589tNJFwoXSBxBGv8J8SDyrvun13m26+ohydrLuvNZXMDhffapexZRvIblcU8cEoD6LcWGv/PFzWb4CN2Yqc+uIllYPAVLO6e5kTPRWMQGRH6KPd8vohFEaIAYHVMkrlrHFi8FtH7b6aZHDuBexa8ZWdvSt/WXpudNK8SGtEv2yoGcyqSMxlJ/pysuvsksS/2qzpLeycoF+SLSw5VVLDM7YoW9C3k6QWxJBNo1KsYofBIE5Tk40i0BbKH5r79Xvs3Ye9Q1f0dwSXHooFjrR4s7E5ukBtpk325bHlwPmhGbk+vQrY7lKPQbo3SMJ13eFzlpfW8StNpCp8mpQ==</SignatureValue>
		<KeyInfo>
			<X509Data>
				<X509IssuerSerial>
					<X509IssuerName>OID.1.2.840.113549.1.9.2=Responsable: ACDMA, OID.2.5.4.45=SAT970701NN3, L=Coyoacán, S=Distrito Federal, C=MX, PostalCode=06300, STREET=&quot;Av. Hidalgo 77, Col. Guerrero&quot;, E=asisnet@pruebas.sat.gob.mx, OU=Administración de Seguridad de la Información, O=Servicio de Administración Tributaria, CN=A.C. 2 de pruebas(4096)</X509IssuerName>
					<X509SerialNumber>286524172099382162235533054548081509963388170549</X509SerialNumber>
				</X509IssuerSerial>
				<X509Certificate>MIIFxTCCA62gAwIBAgIUMjAwMDEwMDAwMDAzMDAwMjI4MTUwDQYJKoZIhvcNAQELBQAwggFmMSAwHgYDVQQDDBdBLkMuIDIgZGUgcHJ1ZWJhcyg0MDk2KTEvMC0GA1UECgwmU2VydmljaW8gZGUgQWRtaW5pc3RyYWNpw7NuIFRyaWJ1dGFyaWExODA2BgNVBAsML0FkbWluaXN0cmFjacOzbiBkZSBTZWd1cmlkYWQgZGUgbGEgSW5mb3JtYWNpw7NuMSkwJwYJKoZIhvcNAQkBFhphc2lzbmV0QHBydWViYXMuc2F0LmdvYi5teDEmMCQGA1UECQwdQXYuIEhpZGFsZ28gNzcsIENvbC4gR3VlcnJlcm8xDjAMBgNVBBEMBTA2MzAwMQswCQYDVQQGEwJNWDEZMBcGA1UECAwQRGlzdHJpdG8gRmVkZXJhbDESMBAGA1UEBwwJQ295b2Fjw6FuMRUwEwYDVQQtEwxTQVQ5NzA3MDFOTjMxITAfBgkqhkiG9w0BCQIMElJlc3BvbnNhYmxlOiBBQ0RNQTAeFw0xNjEwMjUyMTUyMTFaFw0yMDEwMjUyMTUyMTFaMIGxMRowGAYDVQQDExFDSU5ERU1FWCBTQSBERSBDVjEaMBgGA1UEKRMRQ0lOREVNRVggU0EgREUgQ1YxGjAYBgNVBAoTEUNJTkRFTUVYIFNBIERFIENWMSUwIwYDVQQtExxMQU43MDA4MTczUjUgLyBGVUFCNzcwMTE3QlhBMR4wHAYDVQQFExUgLyBGVUFCNzcwMTE3TURGUk5OMDkxFDASBgNVBAsUC1BydWViYV9DRkRJMIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAgvvCiCFDFVaYX7xdVRhp/38ULWto/LKDSZy1yrXKpaqFXqERJWF78YHKf3N5GBoXgzwFPuDX+5kvY5wtYNxx/Owu2shNZqFFh6EKsysQMeP5rz6kE1gFYenaPEUP9zj+h0bL3xR5aqoTsqGF24mKBLoiaK44pXBzGzgsxZishVJVM6XbzNJVonEUNbI25DhgWAd86f2aU3BmOH2K1RZx41dtTT56UsszJls4tPFODr/caWuZEuUvLp1M3nj7Dyu88mhD2f+1fA/g7kzcU/1tcpFXF/rIy93APvkU72jwvkrnprzs+SnG81+/F16ahuGsb2EZ88dKHwqxEkwzhMyTbQIDAQABox0wGzAMBgNVHRMBAf8EAjAAMAsGA1UdDwQEAwIGwDANBgkqhkiG9w0BAQsFAAOCAgEAJ/xkL8I+fpilZP+9aO8n93+20XxVomLJjeSL+Ng2ErL2GgatpLuN5JknFBkZAhxVIgMaTS23zzk1RLtRaYvH83lBH5E+M+kEjFGp14Fne1iV2Pm3vL4jeLmzHgY1Kf5HmeVrrp4PU7WQg16VpyHaJ/eonPNiEBUjcyQ1iFfkzJmnSJvDGtfQK2TiEolDJApYv0OWdm4is9Bsfi9j6lI9/T6MNZ+/LM2L/t72Vau4r7m94JDEzaO3A0wHAtQ97fjBfBiO5M8AEISAV7eZidIl3iaJJHkQbBYiiW2gikreUZKPUX0HmlnIqqQcBJhWKRu6Nqk6aZBTETLLpGrvF9OArV1JSsbdw/ZH+P88RAt5em5/gjwwtFlNHyiKG5w+UFpaZOK3gZP0su0sa6dlPeQ9EL4JlFkGqQCgSQ+NOsXqaOavgoP5VLykLwuGnwIUnuhBTVeDbzpgrg9LuF5dYp/zs+Y9ScJqe5VMAagLSYTShNtN8luV7LvxF9pgWwZdcM7lUwqJmUddCiZqdngg3vzTactMToG16gZA4CWnMgbU4E+r541+FNMpgAZNvs2CiW/eApfaaQojsZEAHDsDv4L5n3M1CC7fYjE/d61aSng1LaO6T1mh+dEfPvLzp7zyzz+UgWMhi5Cs4pcXx1eic5r7uxPoBwcCTt3YI1jKVVnV7/w=</X509Certificate>
			</X509Data>
		</KeyInfo>
	</Signature>
</PeticionConsultaRelacionados>
```

Ejemplo de uso
```php
    require_once 'SWSDK.php';
    use SWServices\Cancelation\CancelationService as cancelationService;
    $params = array(
        "url"=>"http://services.test.sw.com.mx",
        "user"=>"cuentaUsuario",
        "password"=> "contraseña"
    );

    $rfc = "LAN7008173R5";
    $uuid = "52c02b64-d12e-4163-b581-bf749238896d";
    $xml = file_get_contents('Test\Resources\fileRelations.xml');
    cancelationService::Set($params);
    $consultaRelacionados = cancelationService::ConsultarCFDIRelacionadosXML($xml);
    var_dump($consultaRelacionados);
```
</details>

<details>
<summary>
Documentos relacionados con UUID
</summary>

Está modalidad recibe como parámetros el RFC del Receptor y el UUID a consultar.

Ejemplo de uso
```php
    require_once 'SWSDK.php';
    use SWServices\Cancelation\CancelationService as cancelationService;
    $params = array(
        "url"=>"http://services.test.sw.com.mx",
        "user"=>"cuentaUsuario",
        "password"=> "contraseña"
    );

    $rfc = "LAN7008173R5";
    $uuid = "52c02b64-d12e-4163-b581-bf749238896d";
    cancelationService::Set($params);
    $consultaRelacionados = cancelationService::ConsultarCFDIRelacionadosUUID($rfc, $uuid);
    var_dump($consultaRelacionados);
```
</details>

## Servicio PDF ##

<details>
<summary>
Generar PDF
</summary>

### Generar PDF ###
Servicio mediante el cual se genera un PDF a  partir de un documento XML y una plantilla.
Se puede utilizar una plantilla genérica o una personalizada más ajustada a sus necesidades.

La función recibe los siguientes parámetros:
* Datos de autenticación (url, urlapi, user, password)
* xml (es necesario que el xml esté timbrado)
* logo (en base64)
* templateId 
* extras (datos adicionales a los contenidos en el xml)

Ejemplo de uso:

```php
require_once 'SWSDK.php';
use SWServices\PDF\PDFService as pdfService;

    $xml = "<?xml version='1.0' encoding='utf-8'?> <cfdi:Comprobante......";
    $logo = "JP39LSM5mdbtAd1...........";
    $templateId = "cfdi40";
    $params = array(
        "urlApi" => "https://api.test.sw.com.mx",
        "url" => "https://services.test.sw.com.mx",
        "user" => "usuario",
        "password" => "contraseña"
    );
    $pdfService = pdfService::Set($params);
    $result = $pdfService::GeneratePDF($xml, $logo, $templateId, null, false);
    var_dump($result);
```
Plantilla con datos adicionales
```php
require_once 'SWSDK.php';
use SWServices\PDF\PDFService as pdfService;

    $xml = "<?xml version='1.0' encoding='utf-8'?> <cfdi:Comprobante......";
    $logo = "JP39LSM5mdbtAd1...........";
    $templateId = "cfdi40";
    $extras =array("DatExtra1"=>"Datos adicionales",
                    "DatoExtra2" => "Datos adicionales");
    $params = array(
        "urlApi" => "https://api.test.sw.com.mx",
        "url" => "https://services.test.sw.com.mx",
        "user" => "usuario",
        "password" => "contraseña"
    );
    $pdfService = pdfService::Set($params);
    $result = $pdfService::GeneratePDF($xml, $logo, $templateId, $extras, false);
    var_dump($result);
```

:pushpin: ***NOTA:*** Existen varias plantillas de PDF segun el tipo de comprobante que necesites, las cuales son las siguientes:

|    Versión 4.0     |  Plantilla para el complemento  | 
|--------------------|---------------------------------|
| :white_check_mark: | Factura ingreso, egreso         | 
| :white_check_mark: | Nómina                          | 
| :white_check_mark: | Pagos                           | 
| :white_check_mark: | Carta porte                     |

Para mayor referencia de estas plantillas de PDF, favor de visitar el siguiente [link](https://developers.sw.com.mx/knowledge-base/plantillas-pdf/).
</details>

<details>
<summary>
Regenerar PDF
</summary>

### Regenerar PDF ###
El servicio podrá generar o regenerar un PDF de un CFDI previamente timbrado y podrá guardar o remplazar el archivo PDF para ser visualizado posteriormente desde el portal ADT.

La función recibe los siguientes parámetros:
* Folio fiscal del comprobante(uuid)
* Extras (datos adicionales a los contenidos en el xml)

Ejemplo de uso
```php
require_once 'SWSDK.php';

use SWServices\PDF\PDFService as pdfService;

    $uuid = "604729a6-a1d9-4969-b35f-e7d04c7ad75c";
    $params = array(
        "urlApi" => "https://api.test.sw.com.mx",
        "url" => "https://services.test.sw.com.mx",
        "user" => "usuario",
        "password" => "contraseña"
    );
    $pdfService = pdfService::Set($params);
    $result = $pdfService::RegeneratePDF($uuid);
    var_dump($result);
```
Con datos adicionales
```php
require_once 'SWSDK.php';

use SWServices\PDF\PDFService as pdfService;
    //Si se cuentan con distintos templateId, 
    //es necesario especificarlo
    $extras =  array(
        "extras"=>array(
            "EDIRECCION1"=>"STERNO PRODUCTS 2483 Harbor Avenue Memphis, TN 38113"
        ),
        "templateId"=>"extradata"
    );
    $params = array(
        "urlApi" => "https://api.test.sw.com.mx",
        "url" => "https://services.test.sw.com.mx",
        "user" => "usuario",
        "password" => "contraseña"
    );
    $pdfService = pdfService::Set($params);
    $result = $pdfService::RegeneratePDF($uuid,$extras);
    var_dump($result);
    
```
</details>

<details>
<summary>
Reenvio Email
</summary>

Servicio de reenvio de email, recibe el uuid del comprobante previamente timbrado y el/los correos a los que se les hará el reenvío.

### Crear una instancia

* Usuario y contraseña:
```php
$params = array(
    "urlApi" => "https://api.test.sw.com.mx",
    "url" => "https://services.test.sw.com.mx",
    "user"=>"user@mail.com",
    "password"=> "password"
);
$resend = ResendService::Set($params);
```

* Token:
```php
$params = array(
    "urlApi" => "https://api.test.sw.com.mx",
    "token" => "T2lYQ0t4L0RHVkR..."
);
$resend = ResendService::Set($params);
```

### Ejemplo

* Un correo:

```php
$emails = array(
    "user@mail.com"
);
$result = $resend::ResendEmail("506aecd4-fc5f-4581-a0e1-9b185967b212", $emails);
```

* Multiples correos (Max 5):
```php
$emails = array(
    "user@mail.com",
    "userB@mail.com"
);
$result = $resend::ResendEmail("506aecd4-fc5f-4581-a0e1-9b185967b212", $emails);
```
</details>

## Certificados ##
Servicio para gestionar los certificados CSD de tu cuenta, será posible cargar, consultar y eliminar los certificados.
Para administrar los certificados de manera gráfica, puede hacerlo desde el [Administrador de timbres](https://portal.sw.com.mx/).

<details>
<summary>
Consultar Certificados
</summary>

Método para consultar todos los certificados cargados en la cuenta.

Este método recibe los siguientes parametros:
* Url Servicios SW
* Usuario y contraseña

**Ejemplo de consumo de la librería para la consulta de certificados mediante usuario y contraseña**
```php
<?php
    require_once 'SWSDK.php';
    use SWServices\Csd\CsdService as CsdService;

    $params = array(
        "url" => "https://services.test.sw.com.mx",
        "user" => "usuario",
        "password" => "contraseña"
    );
    CsdService::Set($params);
    $response = CsdService::GetListCsd();
    var_dump($response);
?>
```
</details>

<details>
<summary>
Consultar Certificado Por RFC
</summary>

Método para obtener un certificado cargado enviando como parámetro el RFC de certificado.

Este método recibe los siguientes parámetros:
* Url Servicios SW
* Usuario y contraseña
* RFC del certificado a obtener

**Ejemplo de consumo de la librería para la consulta de certificados por RFC del Certificado mediante usuario y contraseña**
```php
<?php
    require_once 'SWSDK.php';
    use SWServices\Csd\CsdService as CsdService;

    $params = array(
        "url" => "https://services.test.sw.com.mx",
        "user" => "usuario",
        "password" => "contraseña"
    );
    CsdService::Set($params);
    $response = CsdService::GetListCsdByRfc('EKU9003173C9');
    var_dump($response);
?>
```
</details>

<details>
<summary>
Consultar Certificado Por NoCertificado
</summary>

Método para obtener un certificado cargado enviando como parámetro el número de certificado.

Este método recibe los siguientes parámetros:
* Url Servicios SW
* Usuario y contraseña
* Número de certificado a obtener

**Ejemplo de consumo de la librería para la consulta de certificados por Número de Certificado mediante usuario y contraseña**
```php
<?php
    require_once 'SWSDK.php';
    use SWServices\Csd\CsdService as CsdService;

    $params = array(
        "url" => "https://services.test.sw.com.mx",
        "user" => "usuario",
        "password" => "contraseña"
    );
    CsdService::Set($params);
    $response = CsdService::InfoCsd('20001000000300022816');
    var_dump($response);
?>
```
</details>

<details>
<summary>
Cargar Certificado
</summary>

Método para cargar un certificado en la cuenta.

Este método recibe los siguientes parámetros:
* Url Servicios SW
* Usuario y contraseña
* CSD en Base64
* Key en Base64
* Contraseña del certificado
* Tipo de certificado (Default = “stamp”) 
* Estado del certificado (Default = “true”) 

**Ejemplo de consumo de la libreria para la carga de certificado mediante usuario y contraseña**
```php
<?php
    require_once 'SWSDK.php';
    use SWServices\Csd\CsdService as CsdService;
    
    $b64Cer = base64_encode(file_get_contents('EKU9003173C9.cer'));
    $b64Key = base64_encode(file_get_contents('EKU9003173C9.key'));
    $password = "12345678a";
    $type = "stamp";
    $isActive = true;
    $params = array(
        "url" => "https://services.test.sw.com.mx",
        "user" => "usuario",
        "password" => "contraseña"
    );
    CsdService::Set($params);
    $response = CsdService::UploadCsd($isActive, $type, $b64Cer, $b64Key, $password);
    var_dump($response);
?>
```
</details>

<details>
<summary>
Eliminar Certificado
</summary>

Método para eliminar un certificado de la cuenta.

Este método recibe los siguientes parámetros:
* Url Servicios SW
* Usuario y contraseña
* Número de certificado a eliminar

**Ejemplo de consumo de la libreria para eliminar un certificado mediante usuario y contraseña**
```php
<?php
    require_once 'SWSDK.php';
    use SWServices\Csd\CsdService as CsdService;

    $params = array(
        "url" => "https://services.test.sw.com.mx",
        "user" => "usuario",
        "password" => "contraseña"
    );
    CsdService::Set($params);
    $response = CsdService::DisableCsd('20001000000300022763');
    var_dump($response);
?>
```
</details>


## TimbradoV4 ##

### **CustomId - Pdf** ###

</details>
<details>
<summary>Emisión Timbrado (IssueV4)</summary>

**issueV4CustomIdPdfV1** Recibe el contenido de un **XML** sin sellar en formato **String** se pasa un parametro customId en formato **String**, posteriormente si la factura y el token son correctos devuelve el complemento timbre en un string (**TFD**), en caso contrario lanza una excepción.

```php
<?php
    require_once 'SWSDK.php';

    use SWServices\PDF\PDFService as pdfService;
    use SWServices\Stamp\StampService as StampService;
    use SWServices\Stamp\EmisionTimbrado as EmisionTimbrado;

    $prefixOne = date('Y-m-d');
    $prefixTwo = rand(0, 555);
    $customId = "Serie-" . $prefixOne . "-" . $prefixTwo;
    $resultSpect = "success";
    $params = array(
        "url" => "https://services.test.sw.com.mx",
        "token" => "T2lYQ0t4L0R...."
    );
    $xml = file_get_contents('./file.xml');

    $stamp = EmisionTimbrado::Set($params);
    $result = $stamp::issueV4CustomIdPdfV1($xml, $customId); 
    var_dump($result);

?>
```

**issueV4CustomIdPdfV2** Recibe el contenido de un **XML** sin sellar en formato **String** se pasa un parametro customId en formato **String**, posteriormente si la factura y el token son correctos devuelve el complemento timbre en un string (**TFD**), asi como el comprobante ya timbrado en formato string (**CFDI**) en caso contrario lanza una excepción.

```php
<?php
    require_once 'SWSDK.php';

    use SWServices\PDF\PDFService as pdfService;
    use SWServices\Stamp\StampService as StampService;
    use SWServices\Stamp\EmisionTimbrado as EmisionTimbrado;

    $prefixOne = date('Y-m-d');
    $prefixTwo = rand(0, 555);
    $customId = "Serie-" . $prefixOne . "-" . $prefixTwo;
    $resultSpect = "success";
    $params = array(
        "url" => "https://services.test.sw.com.mx",
        "token" => "T2lYQ0t4L0R...."
    );
    $xml = file_get_contents('./file.xml');

    $stamp = EmisionTimbrado::Set($params);
    $result = $stamp::issueV4CustomIdPdfV2($xml, $customId); 
    var_dump($result);

?>
```

**issueV4CustomIdPdfV3** Recibe el contenido de un **XML** sin sellar en formato **String** se pasa un parametro customId en formato **String**, posteriormente si la factura y el token son correctos devuelve el comprobante ya timbrado en formato string (**CFDI**), en caso contrario lanza una excepción.

```php
<?php
    require_once 'SWSDK.php';

    use SWServices\PDF\PDFService as pdfService;
    use SWServices\Stamp\StampService as StampService;
    use SWServices\Stamp\EmisionTimbrado as EmisionTimbrado;

    $prefixOne = date('Y-m-d');
    $prefixTwo = rand(0, 555);
    $customId = "Serie-" . $prefixOne . "-" . $prefixTwo;
    $resultSpect = "success";
    $params = array(
        "url" => "https://services.test.sw.com.mx",
        "token" => "T2lYQ0t4L0R...."
    );
    $xml = file_get_contents('./file.xml');

    $stamp = EmisionTimbrado::Set($params);
    $result = $stamp::issueV4CustomIdPdfV3($xml, $customId); 
    var_dump($result);
?>
```

**issueV4CustomIdPdfV4** Recibe el contenido de un **XML** sin sellar en formato **String** se pasa un parametro customId en formato **String**, posteriormente regresara todos los datos del timbrado , en caso contrario lanza una excepción.

```php
<?php
    require_once 'SWSDK.php';

    use SWServices\PDF\PDFService as pdfService;
    use SWServices\Stamp\StampService as StampService;
    use SWServices\Stamp\EmisionTimbrado as EmisionTimbrado;

    $prefixOne = date('Y-m-d');
    $prefixTwo = rand(0, 555);
    $customId = "Serie-" . $prefixOne . "-" . $prefixTwo;
    $resultSpect = "success";
    $params = array(
        "url" => "https://services.test.sw.com.mx",
        "token" => "T2lYQ0t4L0R...."
    );
    $xml = file_get_contents('./file.xml');

    $stamp = EmisionTimbrado::Set($params);
    $result = $stamp::issueV4CustomIdPdfV3($xml, $customId); 
    var_dump($result);

?>
```
</details>

### **CustomId - Email** ###

</details>
<details>
<summary>Emisión Timbrado (IssueV4)</summary>

**issueV4CustomIdEmailV1** 

Recibe el contenido de un **XML** sin sellar en formato **String** se pasa un parametro customId en formato **String**, posteriormente si la factura y el token son correctos devuelve el complemento timbre en un string (**TFD**), en caso contrario lanza una excepción.

```php
<?php
    require_once 'SWSDK.php';

    use SWServices\PDF\PDFService as pdfService;
    use SWServices\Stamp\StampService as StampService;
    use SWServices\Stamp\EmisionTimbrado as EmisionTimbrado;

    $prefixOne = date('Y-m-d');
    $prefixTwo = rand(0, 555);
    $customId = "Serie-" . $prefixOne . "-" . $prefixTwo;
    $email = array("correo@correo.com.mx", "correo@correo.com.mx");
    $resultSpect = "success";
    $params = array(
        "url" => "https://services.test.sw.com.mx",
        "token" => "T2lYQ0t4L0R...."
    );
    $xml = file_get_contents('./file.xml');

    $stamp = EmisionTimbrado::Set($params);
    $result = $stamp::issueV4CustomIdEmailV1($xml, $customId); 
    var_dump($result);

?>
```

**issueV4CustomIdEmailV2** Recibe el contenido de un **XML** sin sellar en formato **String** se pasa un parametro customId en formato **String** , se manda un parametro email en formato **String** o un **Array** de hasta maximo 5 correos electronicos, Se genera un pdf por default con este metodo, posteriormente si la factura y el token son correctos devuelve el complemento timbre en un string (**TFD**),asi como el comprobante ya timbrado en formato string (**CFDI**) en caso contrario lanza una excepción.

```php
<?php
    require_once 'SWSDK.php';

    use SWServices\PDF\PDFService as pdfService;
    use SWServices\Stamp\StampService as StampService;
    use SWServices\Stamp\EmisionTimbrado as EmisionTimbrado;

    $prefixOne = date('Y-m-d');
    $prefixTwo = rand(0, 555);
    $customId = "Serie-" . $prefixOne . "-" . $prefixTwo;
    $email = array("correo@correo.com.mx", "correo@correo.com.mx");
    $resultSpect = "success";
    $params = array(
        "url" => "https://services.test.sw.com.mx",
        "token" => "T2lYQ0t4L0R...."
    );
    $xml = file_get_contents('./file.xml');

    $stamp = EmisionTimbrado::Set($params);
    $result = $stamp::issueV4CustomIdEmailV2($xml, $customId); 
    var_dump($result);

?>
```

**issueV4CustomIdEmailV3** Recibe el contenido de un **XML** sin sellar en formato **String** se pasa un parametro customId en formato **String** , se manda un parametro email en formato **String** o un **Array** de hasta maximo 5 correos electronicos, Se genera un pdf por default con este metodo, posteriormente si la factura y el token son correctos devuelve el comprobante ya timbrado en formato string (**CFDI**), en caso contrario lanza una excepción.

```php
<?php
    require_once 'SWSDK.php';

    use SWServices\PDF\PDFService as pdfService;
    use SWServices\Stamp\StampService as StampService;
    use SWServices\Stamp\EmisionTimbrado as EmisionTimbrado;

    $prefixOne = date('Y-m-d');
    $prefixTwo = rand(0, 555);
    $customId = "Serie-" . $prefixOne . "-" . $prefixTwo;
    $email = array("correo@correo.com.mx", "correo@correo.com.mx");
    $resultSpect = "success";
    $params = array(
        "url" => "https://services.test.sw.com.mx",
        "token" => "T2lYQ0t4L0R...."
    );
    $xml = file_get_contents('./file.xml');

    $stamp = EmisionTimbrado::Set($params);
    $result = $stamp::issueV4CustomIdEmailV3($xml, $customId); 
    var_dump($result);

?>
```

**issueV4CustomIdEmailV4** Recibe el contenido de un **XML** sin sellar en formato **String** se pasa un parametro customId en formato **String**, , se manda un parametro email en formato **String** o un **Array** de hasta maximo 5 correos electronicos, Se genera un pdf por default con este metodo, posteriormente regresara todos los datos del timbrado , en caso contrario lanza una excepción.

```php
<?php
    require_once 'SWSDK.php';

    use SWServices\PDF\PDFService as pdfService;
    use SWServices\Stamp\StampService as StampService;
    use SWServices\Stamp\EmisionTimbrado as EmisionTimbrado;

    $prefixOne = date('Y-m-d');
    $prefixTwo = rand(0, 555);
    $customId = "Serie-" . $prefixOne . "-" . $prefixTwo;
    $email = array("correo@correo.com.mx", "correo@correo.com.mx");
    $resultSpect = "success";
    $params = array(
        "url" => "https://services.test.sw.com.mx",
        "token" => "T2lYQ0t4L0R...."
    );
    $xml = file_get_contents('./file.xml');

    $stamp = EmisionTimbrado::Set($params);
    $result = $stamp::issueV4CustomIdEmailV4($xml, $customId); 
    var_dump($result);
?>
```
</details>

-----

Para mayor referencia de un listado completo de los servicios favor de visitar el siguiente [link](http://developers.sw.com.mx/).

Si deseas contribuir a la librería o tienes dudas envianos un correo a **soporte@sw.com.mx**.
