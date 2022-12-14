<?php

namespace tests;

use PHPUnit\Framework\TestCase;
use SWServices\PDF\PdfService as PdfService;
use Exception;

final class PDFTest extends TestCase
{
    public function testPDF_Success()
    {
        $xml = "<?xml version='1.0' encoding='utf-8'?> <cfdi:Comprobante xsi:schemaLocation='http://www.sat.gob.mx/cfd/4 http://www.sat.gob.mx/sitio_internet/cfd/4/cfdv40.xsd' Version='4.0' Serie='Serie' Folio='Folio' Fecha='2022-10-22T00:18:10' Sello='Hm+9BL6j8nimtjsB6dUzoitYAzYqDF4n0mtyOdf+xaszVSO2jWVwMhIvfJisA/m84jSPEBJm1k16j11ibpvTfAOCrDdvxyf9LDi+AMlcCpy6Ibnub4/P6RUkKFg49Xnlx/9JeHijrTCVUGqGjkHzxKZD3CIhA8UfIIuxNCeUsxLYj1W4xab44MHULs0VoZd2/d4pGilSKpxMZgT0gfch9uyHePNL9lHI4OobpEI6NAklOffkPy4uDZJa2m7qt+I4p+fSmcluR/x2My8TrnaA4tNo3PaqdYWDvIcSBBMF3F/9aUUgorc8mjycKQHwcU6b+/lEL+DnUuONEHom66kyYA==' CondicionesDePago='CondicionesDePago' SubTotal='200' Descuento='1' Moneda='AMD' TipoCambio='1' Total='198.96' TipoDeComprobante='I' Exportacion='01' MetodoPago='PPD' FormaPago='99' LugarExpedicion='20000' xmlns:cfdi='http://www.sat.gob.mx/cfd/4' xmlns:xsi='http://www.w3.org/2001/XMLSchema-instance' NoCertificado='30001000000400002434' Certificado='MIIFuzCCA6OgAwIBAgIUMzAwMDEwMDAwMDA0MDAwMDI0MzQwDQYJKoZIhvcNAQELBQAwggErMQ8wDQYDVQQDDAZBQyBVQVQxLjAsBgNVBAoMJVNFUlZJQ0lPIERFIEFETUlOSVNUUkFDSU9OIFRSSUJVVEFSSUExGjAYBgNVBAsMEVNBVC1JRVMgQXV0aG9yaXR5MSgwJgYJKoZIhvcNAQkBFhlvc2Nhci5tYXJ0aW5lekBzYXQuZ29iLm14MR0wGwYDVQQJDBQzcmEgY2VycmFkYSBkZSBjYWRpejEOMAwGA1UEEQwFMDYzNzAxCzAJBgNVBAYTAk1YMRkwFwYDVQQIDBBDSVVEQUQgREUgTUVYSUNPMREwDwYDVQQHDAhDT1lPQUNBTjERMA8GA1UELRMIMi41LjQuNDUxJTAjBgkqhkiG9w0BCQITFnJlc3BvbnNhYmxlOiBBQ0RNQS1TQVQwHhcNMTkwNjE3MTk0NDE0WhcNMjMwNjE3MTk0NDE0WjCB4jEnMCUGA1UEAxMeRVNDVUVMQSBLRU1QRVIgVVJHQVRFIFNBIERFIENWMScwJQYDVQQpEx5FU0NVRUxBIEtFTVBFUiBVUkdBVEUgU0EgREUgQ1YxJzAlBgNVBAoTHkVTQ1VFTEEgS0VNUEVSIFVSR0FURSBTQSBERSBDVjElMCMGA1UELRMcRUtVOTAwMzE3M0M5IC8gWElRQjg5MTExNlFFNDEeMBwGA1UEBRMVIC8gWElRQjg5MTExNk1HUk1aUjA1MR4wHAYDVQQLExVFc2N1ZWxhIEtlbXBlciBVcmdhdGUwggEiMA0GCSqGSIb3DQEBAQUAA4IBDwAwggEKAoIBAQCN0peKpgfOL75iYRv1fqq+oVYsLPVUR/GibYmGKc9InHFy5lYF6OTYjnIIvmkOdRobbGlCUxORX/tLsl8Ya9gm6Yo7hHnODRBIDup3GISFzB/96R9K/MzYQOcscMIoBDARaycnLvy7FlMvO7/rlVnsSARxZRO8Kz8Zkksj2zpeYpjZIya/369+oGqQk1cTRkHo59JvJ4Tfbk/3iIyf4H/Ini9nBe9cYWo0MnKob7DDt/vsdi5tA8mMtA953LapNyCZIDCRQQlUGNgDqY9/8F5mUvVgkcczsIgGdvf9vMQPSf3jjCiKj7j6ucxl1+FwJWmbvgNmiaUR/0q4m2rm78lFAgMBAAGjHTAbMAwGA1UdEwEB/wQCMAAwCwYDVR0PBAQDAgbAMA0GCSqGSIb3DQEBCwUAA4ICAQBcpj1TjT4jiinIujIdAlFzE6kRwYJCnDG08zSp4kSnShjxADGEXH2chehKMV0FY7c4njA5eDGdA/G2OCTPvF5rpeCZP5Dw504RZkYDl2suRz+wa1sNBVpbnBJEK0fQcN3IftBwsgNFdFhUtCyw3lus1SSJbPxjLHS6FcZZ51YSeIfcNXOAuTqdimusaXq15GrSrCOkM6n2jfj2sMJYM2HXaXJ6rGTEgYmhYdwxWtil6RfZB+fGQ/H9I9WLnl4KTZUS6C9+NLHh4FPDhSk19fpS2S/56aqgFoGAkXAYt9Fy5ECaPcULIfJ1DEbsXKyRdCv3JY89+0MNkOdaDnsemS2o5Gl08zI4iYtt3L40gAZ60NPh31kVLnYNsmvfNxYyKp+AeJtDHyW9w7ftM0Hoi+BuRmcAQSKFV3pk8j51la+jrRBrAUv8blbRcQ5BiZUwJzHFEKIwTsRGoRyEx96sNnB03n6GTwjIGz92SmLdNl95r9rkvp+2m4S6q1lPuXaFg7DGBrXWC8iyqeWE2iobdwIIuXPTMVqQb12m1dAkJVRO5NdHnP/MpqOvOgLqoZBNHGyBg4Gqm4sCJHCxA1c8Elfa2RQTCk0tAzllL4vOnI1GHkGJn65xokGsaU4B4D36xh7eWrfj4/pgWHmtoDAYa8wzSwo2GVCZOs+mtEgOQB91/g=='> <cfdi:Emisor Rfc='EKU9003173C9' Nombre='ESCUELA KEMPER URGATE' RegimenFiscal='601' /> <cfdi:Receptor Rfc='URE180429TM6' Nombre='UNIVERSIDAD ROBOTICA ESPAÑOLA' DomicilioFiscalReceptor='65000' RegimenFiscalReceptor='601' UsoCFDI='G01' /> <cfdi:Conceptos> <cfdi:Concepto ClaveProdServ='50211503' Cantidad='1' ClaveUnidad='H87' Unidad='Pieza' Descripcion='Cigarros' ValorUnitario='200.00' Descuento='1' Importe='200.00' ObjetoImp='02'> <cfdi:Impuestos> <cfdi:Traslados> <cfdi:Traslado Base='1' Importe='0.16' Impuesto='002' TasaOCuota='0.160000' TipoFactor='Tasa' /> </cfdi:Traslados> <cfdi:Retenciones> <cfdi:Retencion Base='1' Impuesto='001' TipoFactor='Tasa' TasaOCuota='0.100000' Importe='0.10' /> <cfdi:Retencion Base='1' Impuesto='002' TipoFactor='Tasa' TasaOCuota='0.106666' Importe='0.10' /> </cfdi:Retenciones> </cfdi:Impuestos> </cfdi:Concepto> </cfdi:Conceptos> <cfdi:Impuestos TotalImpuestosRetenidos='0.20' TotalImpuestosTrasladados='0.16'> <cfdi:Retenciones> <cfdi:Retencion Impuesto='001' Importe='0.10' /> <cfdi:Retencion Impuesto='002' Importe='0.10' /> </cfdi:Retenciones> <cfdi:Traslados> <cfdi:Traslado Base='1' Importe='0.16' Impuesto='002' TasaOCuota='0.160000' TipoFactor='Tasa' /> </cfdi:Traslados> </cfdi:Impuestos> <cfdi:Complemento> <tfd:TimbreFiscalDigital xsi:schemaLocation='http://www.sat.gob.mx/TimbreFiscalDigital http://www.sat.gob.mx/sitio_internet/cfd/TimbreFiscalDigital/TimbreFiscalDigitalv11.xsd' Version='1.1' UUID='96b0ed9e-4f1a-43b0-b720-f77663891c68' FechaTimbrado='2022-10-23T19:35:10' RfcProvCertif='SPR190613I52' SelloCFD='Hm+9BL6j8nimtjsB6dUzoitYAzYqDF4n0mtyOdf+xaszVSO2jWVwMhIvfJisA/m84jSPEBJm1k16j11ibpvTfAOCrDdvxyf9LDi+AMlcCpy6Ibnub4/P6RUkKFg49Xnlx/9JeHijrTCVUGqGjkHzxKZD3CIhA8UfIIuxNCeUsxLYj1W4xab44MHULs0VoZd2/d4pGilSKpxMZgT0gfch9uyHePNL9lHI4OobpEI6NAklOffkPy4uDZJa2m7qt+I4p+fSmcluR/x2My8TrnaA4tNo3PaqdYWDvIcSBBMF3F/9aUUgorc8mjycKQHwcU6b+/lEL+DnUuONEHom66kyYA==' NoCertificadoSAT='30001000000400002495' SelloSAT='jozWLGYIFBawPbhKgKxRIsiGnu1yrXqoZOtJqn9RsqvKpyKpDowVEcCR/jiTcOl7+inShzorn/SAckgyoO/0KWEf8JL0RS1UgHMzFjV1iHzEMUahxZanRQRJ8DDlZZKSlGecW+kmaH/wF1e8D430vbreLOAdQuJsOnR7eGnkG6PlZKP0DgnwTnOUPb0I3I8AcL9yj3IVgyhIuxv7t/9/0V2FlUV8K9UhxZYvSfUH5ELP+VqIF05J4qIIKOFgIbpoKrCirUTjHip9FPlS3vBfWRe60g5E6iq7hIqmpGfdl4lhiBxX7ioulqnnrjMvOI94nEyCbErtY1jau1ZZLmvKOA==' xmlns:tfd='http://www.sat.gob.mx/TimbreFiscalDigital' xmlns:xsi='http://www.w3.org/2001/XMLSchema-instance' /> </cfdi:Complemento> </cfdi:Comprobante>";
        $xmlb64 = "PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgiPz48Y2ZkaTpDb21wcm9iYW50ZSBDZXJ0aWZpY2Fkbz0iTUlJRnlEQ0NBN0NnQXdJQkFnSVVNekF3TURFd01EQXdNREEwTURBd01ESTBORE13RFFZSktvWklodmNOQVFFTEJRQXdnZ0VyTVE4d0RRWURWUVFEREFaQlF5QlZRVlF4TGpBc0JnTlZCQW9NSlZORlVsWkpRMGxQSUVSRklFRkVUVWxPU1ZOVVVrRkRTVTlPSUZSU1NVSlZWRUZTU1VFeEdqQVlCZ05WQkFzTUVWTkJWQzFKUlZNZ1FYVjBhRzl5YVhSNU1TZ3dKZ1lKS29aSWh2Y05BUWtCRmhsdmMyTmhjaTV0WVhKMGFXNWxla0J6WVhRdVoyOWlMbTE0TVIwd0d3WURWUVFKREJRemNtRWdZMlZ5Y21Ga1lTQmtaU0JqWVdScGVqRU9NQXdHQTFVRUVRd0ZNRFl6TnpBeEN6QUpCZ05WQkFZVEFrMVlNUmt3RndZRFZRUUlEQkJEU1ZWRVFVUWdSRVVnVFVWWVNVTlBNUkV3RHdZRFZRUUhEQWhEVDFsUFFVTkJUakVSTUE4R0ExVUVMUk1JTWk0MUxqUXVORFV4SlRBakJna3Foa2lHOXcwQkNRSVRGbkpsYzNCdmJuTmhZbXhsT2lCQlEwUk5RUzFUUVZRd0hoY05NVGt3TmpFM01qQTBNRFV4V2hjTk1qTXdOakUzTWpBME1EVXhXakNCN3pFcU1DZ0dBMVVFQXhNaFdFVk9UMDRnU1U1RVZWTlVVa2xCVENCQlVsUkpRMHhGVXlCVElFUkZJRU5XTVNvd0tBWURWUVFwRXlGWVJVNVBUaUJKVGtSVlUxUlNTVUZNSUVGU1ZFbERURVZUSUZNZ1JFVWdRMVl4S2pBb0JnTlZCQW9USVZoRlRrOU9JRWxPUkZWVFZGSkpRVXdnUVZKVVNVTk1SVk1nVXlCRVJTQkRWakVsTUNNR0ExVUVMUk1jV0VsQk1Ua3dNVEk0U2pZeElDOGdTMEZJVHpZME1URXdNVUl6T1RFZU1Cd0dBMVVFQlJNVklDOGdTMEZJVHpZME1URXdNVWhPVkV4TFV6QTJNU0l3SUFZRFZRUUxFeGxZWlc1dmJpQkpibVIxYzNSeWFXRnNJRUZ5ZEdsamJHVnpNSUlCSWpBTkJna3Foa2lHOXcwQkFRRUZBQU9DQVE4QU1JSUJDZ0tDQVFFQWlKUTVZY1NnandzR2YyOSszZ283VkdkdE1aQ2NIOXdVcG40NlpNQWxGd1Vvam5DUFR2d0ozK2NTd2pxSm53OGFocjNEdVJ3ZWt2R1I0QkpBYjViOVhpOGt5b2lXdHdjR09TV3hPMzhCcDlKMWUvQk85SE1iUUJQQXRMRHVHNDdvcW5IOHpXTE9lYW9ZUkpEcEFSdzRSWDFrbzIrOXRiajBudEJ0TTdWazFFOEVXaUEvaDJNZXEwTEl2MSt5U0dUVXJFVzQ2Rk0wMUo1cHpFTHY1WHVwQmdodUp4UjVERzlmaU9XN3UzZFI1czN0Wm9WTHdBMUtkakp0WTBtbW5mQ3d4ZzZpNUFxaHZZK0ZBSTVENkNGNi9sSEE4UFdnNjNXYXN2cmh1SXY3MHhDTGpnUFQvajAwWmNQckx2QmYxRGVmR1ZpYzk4MENoL1NEdkMrTWRKMUY1d0lEQVFBQm94MHdHekFNQmdOVkhSTUJBZjhFQWpBQU1Bc0dBMVVkRHdRRUF3SUd3REFOQmdrcWhraUc5dzBCQVFzRkFBT0NBZ0VBQ2pmVFBvS1kyTjVNeGptQU1sdGQ1WFpDVjF2Z0F3RXRySVJZVG9kaEU4UjBUcDFRYW5BWGIwbHVQeUJ2NWhJWFdLNFZxQUk0ZmNUdFArbjdra3J3ZmhhNkVya1BXRk5KV0ptOFpzTW1ieS8zV2dWb0prT0Z5UllRcXI1SWwzTjZ3TWE1a2lEQnREUmJxQjNpRVhtdnRydmpXU0h5eEFFUit6bzNqV0dGbGhCWjBuUU5SdGp4OHNQRmloVmM1VFVINjgySEppVTRvV3ZUNjNEbnJhOG5jcWlXL3VDdVk4NmNyblVxMGZXN0x3LzMrUFk1eFhqTnhSL0hoM3NVUElUZkpyR2FMV3VyRDFKOW5wcjl5R0FKNnQ5enJoaFpuZXBJQzBEVU1jNStqNHBnMURyTzMyanp3VU9MUXFFckRpemg4NE5vSkNXd2JnK1VTOHdpM3pEMFpLaUR2N1hzVE5XQVcyQXAySmt6eWtLSGpGVFppRW0zdVpPa0pOZmN1M28ra2VmcjVIZlhGVCtpTjlLNUZVRWhhUXdnVWVaQlJKOFY1RjZnbWh6M2Q2aXhWYmlab0ZOaFlSOGUyazhnRjlnR3JWTXJFYkpHUXJsKzYrWllRTEZpYXVYZUc3ZnUxc3ZrMTlQdXlyZWRSSkduc2VKcXlWNFJ6Y1JHaEpBK2NMbm1wZERPVEVoaWdubnZuaEV1WTZIVlJZWVhoT1R5ZWVsdUVUN0tSQ3hiSkdxTzdUZFdnanJITDNIUmJORTROWTVHQWRPWnVMYVd4RWxHNVpWQ0hxdEcwTmg3VVFBaGN6K0VLeVpCQWV3djVYdUgwT29tWlh3Nm1NMm1ZMnNvTDZ6MTIyNE51c004L0JiSmNZVFFVbEFFS2JsRUNoaEdLMVhseGlWT1UybmM5S0U9IiBGZWNoYT0iMjAyMi0xMS0wNlQyMjo0MzoxMCIgRm9saW89IjYzODAzNDE0NTkwNDUzNzc5NjI0IiBGb3JtYVBhZ289IjAxIiBMdWdhckV4cGVkaWNpb249IjA2MzAwIiBNZXRvZG9QYWdvPSJQVUUiIE1vbmVkYT0iTVhOIiBOb0NlcnRpZmljYWRvPSIzMDAwMTAwMDAwMDQwMDAwMjQ0MyIgU2VsbG89ImdHUVJKRE9hRWN3blpLeHJiVmlGTlA3TXFGNU9YaEdObUwveE9BMThteXNVaXQ1Y3JTL2pFOTZvU3pZL3BIOGdCd1lwdW5WdmZybWtkc0h1V2dwVlcrOGtuVjRrS1EwbmxYVFU1QVp0WTVScG96TFpCT0NreFhyVysrZ2t5d2lNaE5rdVJSdnZqeXVPZWZXdUxiQUROMVYzS1VWK2ErejhMQ3d1Tm5WZVlVWUYxOTUzLy9jMGJtRGp3OGtJTTBJdU5KZDFVZWQvbzNYVFQ3N3RqUlAwQ1VKaEQ0WE1GZm1OWktadm5ZMjhIbGd3clQzWVF3UVo2ejZHZW5YUUJsNDYwb0tLRkJJek5HMUZFTm9pZCs0M3gvbXl5L0J5NWxGK0NKeFVLZ2F1SXhyVzVDY1lEYWFNeHVOeG5adUswQjM2MHRkcnFJOWY0MS9LU2IwWSs2NVNxdz09IiBTZXJpZT0iUm9ndWVPbmUiIFN1YlRvdGFsPSIyMDAuMDAiIFRpcG9DYW1iaW89IjEiIFRpcG9EZUNvbXByb2JhbnRlPSJJIiBUb3RhbD0iNjAzLjIwIiBWZXJzaW9uPSIzLjMiIHhtbG5zOmNmZGk9Imh0dHA6Ly93d3cuc2F0LmdvYi5teC9jZmQvMyIgeG1sbnM6eHNpPSJodHRwOi8vd3d3LnczLm9yZy8yMDAxL1hNTFNjaGVtYS1pbnN0YW5jZSIgeHNpOnNjaGVtYUxvY2F0aW9uPSJodHRwOi8vd3d3LnNhdC5nb2IubXgvY2ZkLzMgaHR0cDovL3d3dy5zYXQuZ29iLm14L3NpdGlvX2ludGVybmV0L2NmZC8zL2NmZHYzMy54c2QiPjxjZmRpOkVtaXNvciBOb21icmU9Ik1CIElERUFTIERJR0lUQUxFUyBTQyIgUmVnaW1lbkZpc2NhbD0iNjAxIiBSZmM9IlhJQTE5MDEyOEo2MSIgLz48Y2ZkaTpSZWNlcHRvciBOb21icmU9IlNXIFNNQVJURVJXRUIiIFJmYz0iQUFBMDEwMTAxQUFBIiBVc29DRkRJPSJHMDMiIC8+PGNmZGk6Q29uY2VwdG9zPjxjZmRpOkNvbmNlcHRvIENhbnRpZGFkPSIxIiBDbGF2ZVByb2RTZXJ2PSI1MDIxMTUwMyIgQ2xhdmVVbmlkYWQ9Ikg4NyIgRGVzY3JpcGNpb249IkNpZ2Fycm9zIiBJbXBvcnRlPSIyMDAuMDAiIE5vSWRlbnRpZmljYWNpb249IlVUNDIxNTExIiBVbmlkYWQ9IlBpZXphIiBWYWxvclVuaXRhcmlvPSIyMDAuMDAiPjxjZmRpOkltcHVlc3Rvcz48Y2ZkaTpUcmFzbGFkb3M+PGNmZGk6VHJhc2xhZG8gQmFzZT0iMjAwLjAwIiBJbXBvcnRlPSIzMi4wMCIgSW1wdWVzdG89IjAwMiIgVGFzYU9DdW90YT0iMC4xNjAwMDAiIFRpcG9GYWN0b3I9IlRhc2EiIC8+PGNmZGk6VHJhc2xhZG8gQmFzZT0iMjMyLjAwIiBJbXBvcnRlPSIzNzEuMjAiIEltcHVlc3RvPSIwMDMiIFRhc2FPQ3VvdGE9IjEuNjAwMDAwIiBUaXBvRmFjdG9yPSJUYXNhIiAvPjwvY2ZkaTpUcmFzbGFkb3M+PC9jZmRpOkltcHVlc3Rvcz48L2NmZGk6Q29uY2VwdG8+PC9jZmRpOkNvbmNlcHRvcz48Y2ZkaTpJbXB1ZXN0b3MgVG90YWxJbXB1ZXN0b3NUcmFzbGFkYWRvcz0iNDAzLjIwIj48Y2ZkaTpUcmFzbGFkb3M+PGNmZGk6VHJhc2xhZG8gSW1wb3J0ZT0iMzIuMDAiIEltcHVlc3RvPSIwMDIiIFRhc2FPQ3VvdGE9IjAuMTYwMDAwIiBUaXBvRmFjdG9yPSJUYXNhIiAvPjxjZmRpOlRyYXNsYWRvIEltcG9ydGU9IjM3MS4yMCIgSW1wdWVzdG89IjAwMyIgVGFzYU9DdW90YT0iMS42MDAwMDAiIFRpcG9GYWN0b3I9IlRhc2EiIC8+PC9jZmRpOlRyYXNsYWRvcz48L2NmZGk6SW1wdWVzdG9zPjxjZmRpOkNvbXBsZW1lbnRvPjx0ZmQ6VGltYnJlRmlzY2FsRGlnaXRhbCB4c2k6c2NoZW1hTG9jYXRpb249Imh0dHA6Ly93d3cuc2F0LmdvYi5teC9UaW1icmVGaXNjYWxEaWdpdGFsIGh0dHA6Ly93d3cuc2F0LmdvYi5teC9zaXRpb19pbnRlcm5ldC9jZmQvVGltYnJlRmlzY2FsRGlnaXRhbC9UaW1icmVGaXNjYWxEaWdpdGFsdjExLnhzZCIgVmVyc2lvbj0iMS4xIiBVVUlEPSIxNmQ2Y2VmZC03OGI4LTQ5ZmUtOTYzMS0yNTFiZGEwZjQwMzIiIEZlY2hhVGltYnJhZG89IjIwMjItMTEtMDdUMTA6NDM6MTIiIFJmY1Byb3ZDZXJ0aWY9IlNQUjE5MDYxM0k1MiIgU2VsbG9DRkQ9ImdHUVJKRE9hRWN3blpLeHJiVmlGTlA3TXFGNU9YaEdObUwveE9BMThteXNVaXQ1Y3JTL2pFOTZvU3pZL3BIOGdCd1lwdW5WdmZybWtkc0h1V2dwVlcrOGtuVjRrS1EwbmxYVFU1QVp0WTVScG96TFpCT0NreFhyVysrZ2t5d2lNaE5rdVJSdnZqeXVPZWZXdUxiQUROMVYzS1VWK2ErejhMQ3d1Tm5WZVlVWUYxOTUzLy9jMGJtRGp3OGtJTTBJdU5KZDFVZWQvbzNYVFQ3N3RqUlAwQ1VKaEQ0WE1GZm1OWktadm5ZMjhIbGd3clQzWVF3UVo2ejZHZW5YUUJsNDYwb0tLRkJJek5HMUZFTm9pZCs0M3gvbXl5L0J5NWxGK0NKeFVLZ2F1SXhyVzVDY1lEYWFNeHVOeG5adUswQjM2MHRkcnFJOWY0MS9LU2IwWSs2NVNxdz09IiBOb0NlcnRpZmljYWRvU0FUPSIzMDAwMTAwMDAwMDQwMDAwMjQ5NSIgU2VsbG9TQVQ9Ikozd2lQRkFSMnlvZkRqMGFneDM0RWhHM2YrRUsxTCt3RFFyYUdheDhpWlBiOXN2V0VKQlpneCt1MXNNQTZUYjVNRGkxNHpHb3Uwbnh2Yk9CY0dEYnpUdXBvL0N5ZjdlR2hrNC9WckVhQklINkZ5ZEhWNHRpZHh4ZUZxSFIrYlh0bGJzZkwzQnJyUUN3THBjblphVS9UNXZ1clhEOUVqUFg2MGRla0JlWnlzcUUwWFlxZTJTZ0kybmFxTFNqTGJURXUwMHFBWXJuMS9XZmRYU1M1d1Q3WEdhckRHM0lySEhVT1Blb3Nmc2VPWmJ1ZE5ISGRIL09BdmY4Lzl0S3lobll5M2VQYThGWWpNU282YlN3bXRlNXREUndOUjU3bTdTd0QvR3F2TkxXUS9peFVCeUpPOGgzU1VseWsxMytzNkJCZDRkcW9Ha1JnOHVXL0dKZmRWN2svdz09IiB4bWxuczp0ZmQ9Imh0dHA6Ly93d3cuc2F0LmdvYi5teC9UaW1icmVGaXNjYWxEaWdpdGFsIiB4bWxuczp4c2k9Imh0dHA6Ly93d3cudzMub3JnLzIwMDEvWE1MU2NoZW1hLWluc3RhbmNlIiAvPjwvY2ZkaTpDb21wbGVtZW50bz48L2NmZGk6Q29tcHJvYmFudGU+";
        $logo = "";
        $templateId = "cfdi33";
        $params = array(
            "urlApi" => "https://api.test.sw.com.mx",
            "url" => "https://services.test.sw.com.mx",
            "user" => "userforut@sw.com",
            "password" => "swpassut"
        );
        try {
            $pdfService = PdfService::Set($params);
            $result = $pdfService::GeneratePDF($xml, $logo, $templateId, null, false);
            $resultSpect = "success";
            $this->assertEquals($resultSpect, $result->status);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
    public function testPDF_ExtraSuccess()
    {
        $xml = "<?xml version='1.0' encoding='utf-8'?> <cfdi:Comprobante xsi:schemaLocation='http://www.sat.gob.mx/cfd/4 http://www.sat.gob.mx/sitio_internet/cfd/4/cfdv40.xsd' Version='4.0' Serie='Serie' Folio='Folio' Fecha='2022-10-22T00:18:10' Sello='Hm+9BL6j8nimtjsB6dUzoitYAzYqDF4n0mtyOdf+xaszVSO2jWVwMhIvfJisA/m84jSPEBJm1k16j11ibpvTfAOCrDdvxyf9LDi+AMlcCpy6Ibnub4/P6RUkKFg49Xnlx/9JeHijrTCVUGqGjkHzxKZD3CIhA8UfIIuxNCeUsxLYj1W4xab44MHULs0VoZd2/d4pGilSKpxMZgT0gfch9uyHePNL9lHI4OobpEI6NAklOffkPy4uDZJa2m7qt+I4p+fSmcluR/x2My8TrnaA4tNo3PaqdYWDvIcSBBMF3F/9aUUgorc8mjycKQHwcU6b+/lEL+DnUuONEHom66kyYA==' CondicionesDePago='CondicionesDePago' SubTotal='200' Descuento='1' Moneda='AMD' TipoCambio='1' Total='198.96' TipoDeComprobante='I' Exportacion='01' MetodoPago='PPD' FormaPago='99' LugarExpedicion='20000' xmlns:cfdi='http://www.sat.gob.mx/cfd/4' xmlns:xsi='http://www.w3.org/2001/XMLSchema-instance' NoCertificado='30001000000400002434' Certificado='MIIFuzCCA6OgAwIBAgIUMzAwMDEwMDAwMDA0MDAwMDI0MzQwDQYJKoZIhvcNAQELBQAwggErMQ8wDQYDVQQDDAZBQyBVQVQxLjAsBgNVBAoMJVNFUlZJQ0lPIERFIEFETUlOSVNUUkFDSU9OIFRSSUJVVEFSSUExGjAYBgNVBAsMEVNBVC1JRVMgQXV0aG9yaXR5MSgwJgYJKoZIhvcNAQkBFhlvc2Nhci5tYXJ0aW5lekBzYXQuZ29iLm14MR0wGwYDVQQJDBQzcmEgY2VycmFkYSBkZSBjYWRpejEOMAwGA1UEEQwFMDYzNzAxCzAJBgNVBAYTAk1YMRkwFwYDVQQIDBBDSVVEQUQgREUgTUVYSUNPMREwDwYDVQQHDAhDT1lPQUNBTjERMA8GA1UELRMIMi41LjQuNDUxJTAjBgkqhkiG9w0BCQITFnJlc3BvbnNhYmxlOiBBQ0RNQS1TQVQwHhcNMTkwNjE3MTk0NDE0WhcNMjMwNjE3MTk0NDE0WjCB4jEnMCUGA1UEAxMeRVNDVUVMQSBLRU1QRVIgVVJHQVRFIFNBIERFIENWMScwJQYDVQQpEx5FU0NVRUxBIEtFTVBFUiBVUkdBVEUgU0EgREUgQ1YxJzAlBgNVBAoTHkVTQ1VFTEEgS0VNUEVSIFVSR0FURSBTQSBERSBDVjElMCMGA1UELRMcRUtVOTAwMzE3M0M5IC8gWElRQjg5MTExNlFFNDEeMBwGA1UEBRMVIC8gWElRQjg5MTExNk1HUk1aUjA1MR4wHAYDVQQLExVFc2N1ZWxhIEtlbXBlciBVcmdhdGUwggEiMA0GCSqGSIb3DQEBAQUAA4IBDwAwggEKAoIBAQCN0peKpgfOL75iYRv1fqq+oVYsLPVUR/GibYmGKc9InHFy5lYF6OTYjnIIvmkOdRobbGlCUxORX/tLsl8Ya9gm6Yo7hHnODRBIDup3GISFzB/96R9K/MzYQOcscMIoBDARaycnLvy7FlMvO7/rlVnsSARxZRO8Kz8Zkksj2zpeYpjZIya/369+oGqQk1cTRkHo59JvJ4Tfbk/3iIyf4H/Ini9nBe9cYWo0MnKob7DDt/vsdi5tA8mMtA953LapNyCZIDCRQQlUGNgDqY9/8F5mUvVgkcczsIgGdvf9vMQPSf3jjCiKj7j6ucxl1+FwJWmbvgNmiaUR/0q4m2rm78lFAgMBAAGjHTAbMAwGA1UdEwEB/wQCMAAwCwYDVR0PBAQDAgbAMA0GCSqGSIb3DQEBCwUAA4ICAQBcpj1TjT4jiinIujIdAlFzE6kRwYJCnDG08zSp4kSnShjxADGEXH2chehKMV0FY7c4njA5eDGdA/G2OCTPvF5rpeCZP5Dw504RZkYDl2suRz+wa1sNBVpbnBJEK0fQcN3IftBwsgNFdFhUtCyw3lus1SSJbPxjLHS6FcZZ51YSeIfcNXOAuTqdimusaXq15GrSrCOkM6n2jfj2sMJYM2HXaXJ6rGTEgYmhYdwxWtil6RfZB+fGQ/H9I9WLnl4KTZUS6C9+NLHh4FPDhSk19fpS2S/56aqgFoGAkXAYt9Fy5ECaPcULIfJ1DEbsXKyRdCv3JY89+0MNkOdaDnsemS2o5Gl08zI4iYtt3L40gAZ60NPh31kVLnYNsmvfNxYyKp+AeJtDHyW9w7ftM0Hoi+BuRmcAQSKFV3pk8j51la+jrRBrAUv8blbRcQ5BiZUwJzHFEKIwTsRGoRyEx96sNnB03n6GTwjIGz92SmLdNl95r9rkvp+2m4S6q1lPuXaFg7DGBrXWC8iyqeWE2iobdwIIuXPTMVqQb12m1dAkJVRO5NdHnP/MpqOvOgLqoZBNHGyBg4Gqm4sCJHCxA1c8Elfa2RQTCk0tAzllL4vOnI1GHkGJn65xokGsaU4B4D36xh7eWrfj4/pgWHmtoDAYa8wzSwo2GVCZOs+mtEgOQB91/g=='> <cfdi:Emisor Rfc='EKU9003173C9' Nombre='ESCUELA KEMPER URGATE' RegimenFiscal='601' /> <cfdi:Receptor Rfc='URE180429TM6' Nombre='UNIVERSIDAD ROBOTICA ESPAÑOLA' DomicilioFiscalReceptor='65000' RegimenFiscalReceptor='601' UsoCFDI='G01' /> <cfdi:Conceptos> <cfdi:Concepto ClaveProdServ='50211503' Cantidad='1' ClaveUnidad='H87' Unidad='Pieza' Descripcion='Cigarros' ValorUnitario='200.00' Descuento='1' Importe='200.00' ObjetoImp='02'> <cfdi:Impuestos> <cfdi:Traslados> <cfdi:Traslado Base='1' Importe='0.16' Impuesto='002' TasaOCuota='0.160000' TipoFactor='Tasa' /> </cfdi:Traslados> <cfdi:Retenciones> <cfdi:Retencion Base='1' Impuesto='001' TipoFactor='Tasa' TasaOCuota='0.100000' Importe='0.10' /> <cfdi:Retencion Base='1' Impuesto='002' TipoFactor='Tasa' TasaOCuota='0.106666' Importe='0.10' /> </cfdi:Retenciones> </cfdi:Impuestos> </cfdi:Concepto> </cfdi:Conceptos> <cfdi:Impuestos TotalImpuestosRetenidos='0.20' TotalImpuestosTrasladados='0.16'> <cfdi:Retenciones> <cfdi:Retencion Impuesto='001' Importe='0.10' /> <cfdi:Retencion Impuesto='002' Importe='0.10' /> </cfdi:Retenciones> <cfdi:Traslados> <cfdi:Traslado Base='1' Importe='0.16' Impuesto='002' TasaOCuota='0.160000' TipoFactor='Tasa' /> </cfdi:Traslados> </cfdi:Impuestos> <cfdi:Complemento> <tfd:TimbreFiscalDigital xsi:schemaLocation='http://www.sat.gob.mx/TimbreFiscalDigital http://www.sat.gob.mx/sitio_internet/cfd/TimbreFiscalDigital/TimbreFiscalDigitalv11.xsd' Version='1.1' UUID='96b0ed9e-4f1a-43b0-b720-f77663891c68' FechaTimbrado='2022-10-23T19:35:10' RfcProvCertif='SPR190613I52' SelloCFD='Hm+9BL6j8nimtjsB6dUzoitYAzYqDF4n0mtyOdf+xaszVSO2jWVwMhIvfJisA/m84jSPEBJm1k16j11ibpvTfAOCrDdvxyf9LDi+AMlcCpy6Ibnub4/P6RUkKFg49Xnlx/9JeHijrTCVUGqGjkHzxKZD3CIhA8UfIIuxNCeUsxLYj1W4xab44MHULs0VoZd2/d4pGilSKpxMZgT0gfch9uyHePNL9lHI4OobpEI6NAklOffkPy4uDZJa2m7qt+I4p+fSmcluR/x2My8TrnaA4tNo3PaqdYWDvIcSBBMF3F/9aUUgorc8mjycKQHwcU6b+/lEL+DnUuONEHom66kyYA==' NoCertificadoSAT='30001000000400002495' SelloSAT='jozWLGYIFBawPbhKgKxRIsiGnu1yrXqoZOtJqn9RsqvKpyKpDowVEcCR/jiTcOl7+inShzorn/SAckgyoO/0KWEf8JL0RS1UgHMzFjV1iHzEMUahxZanRQRJ8DDlZZKSlGecW+kmaH/wF1e8D430vbreLOAdQuJsOnR7eGnkG6PlZKP0DgnwTnOUPb0I3I8AcL9yj3IVgyhIuxv7t/9/0V2FlUV8K9UhxZYvSfUH5ELP+VqIF05J4qIIKOFgIbpoKrCirUTjHip9FPlS3vBfWRe60g5E6iq7hIqmpGfdl4lhiBxX7ioulqnnrjMvOI94nEyCbErtY1jau1ZZLmvKOA==' xmlns:tfd='http://www.sat.gob.mx/TimbreFiscalDigital' xmlns:xsi='http://www.w3.org/2001/XMLSchema-instance' /> </cfdi:Complemento> </cfdi:Comprobante>";
        $logo = "";
        $extras = array("EDIRECCION1" => "Datos adicionales");
        $templateId = "extradata";
        $params = array(
            "urlApi" => "https://api.test.sw.com.mx",
            "url" => "https://services.test.sw.com.mx",
            "user" => "userforut@sw.com",
            "password" => "swpassut"
        );
        try {
            $pdfService = pdfService::Set($params);
            $result = $pdfService::GeneratePDF($xml, $logo, $templateId, $extras, false);
            $resultSpect = "success";
            $this->assertEquals($resultSpect, $result->status);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
    public function testPDF_isB64true()
    {
        $xmlb64 = "PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgiPz48Y2ZkaTpDb21wcm9iYW50ZSBDZXJ0aWZpY2Fkbz0iTUlJRnlEQ0NBN0NnQXdJQkFnSVVNekF3TURFd01EQXdNREEwTURBd01ESTBORE13RFFZSktvWklodmNOQVFFTEJRQXdnZ0VyTVE4d0RRWURWUVFEREFaQlF5QlZRVlF4TGpBc0JnTlZCQW9NSlZORlVsWkpRMGxQSUVSRklFRkVUVWxPU1ZOVVVrRkRTVTlPSUZSU1NVSlZWRUZTU1VFeEdqQVlCZ05WQkFzTUVWTkJWQzFKUlZNZ1FYVjBhRzl5YVhSNU1TZ3dKZ1lKS29aSWh2Y05BUWtCRmhsdmMyTmhjaTV0WVhKMGFXNWxla0J6WVhRdVoyOWlMbTE0TVIwd0d3WURWUVFKREJRemNtRWdZMlZ5Y21Ga1lTQmtaU0JqWVdScGVqRU9NQXdHQTFVRUVRd0ZNRFl6TnpBeEN6QUpCZ05WQkFZVEFrMVlNUmt3RndZRFZRUUlEQkJEU1ZWRVFVUWdSRVVnVFVWWVNVTlBNUkV3RHdZRFZRUUhEQWhEVDFsUFFVTkJUakVSTUE4R0ExVUVMUk1JTWk0MUxqUXVORFV4SlRBakJna3Foa2lHOXcwQkNRSVRGbkpsYzNCdmJuTmhZbXhsT2lCQlEwUk5RUzFUUVZRd0hoY05NVGt3TmpFM01qQTBNRFV4V2hjTk1qTXdOakUzTWpBME1EVXhXakNCN3pFcU1DZ0dBMVVFQXhNaFdFVk9UMDRnU1U1RVZWTlVVa2xCVENCQlVsUkpRMHhGVXlCVElFUkZJRU5XTVNvd0tBWURWUVFwRXlGWVJVNVBUaUJKVGtSVlUxUlNTVUZNSUVGU1ZFbERURVZUSUZNZ1JFVWdRMVl4S2pBb0JnTlZCQW9USVZoRlRrOU9JRWxPUkZWVFZGSkpRVXdnUVZKVVNVTk1SVk1nVXlCRVJTQkRWakVsTUNNR0ExVUVMUk1jV0VsQk1Ua3dNVEk0U2pZeElDOGdTMEZJVHpZME1URXdNVUl6T1RFZU1Cd0dBMVVFQlJNVklDOGdTMEZJVHpZME1URXdNVWhPVkV4TFV6QTJNU0l3SUFZRFZRUUxFeGxZWlc1dmJpQkpibVIxYzNSeWFXRnNJRUZ5ZEdsamJHVnpNSUlCSWpBTkJna3Foa2lHOXcwQkFRRUZBQU9DQVE4QU1JSUJDZ0tDQVFFQWlKUTVZY1NnandzR2YyOSszZ283VkdkdE1aQ2NIOXdVcG40NlpNQWxGd1Vvam5DUFR2d0ozK2NTd2pxSm53OGFocjNEdVJ3ZWt2R1I0QkpBYjViOVhpOGt5b2lXdHdjR09TV3hPMzhCcDlKMWUvQk85SE1iUUJQQXRMRHVHNDdvcW5IOHpXTE9lYW9ZUkpEcEFSdzRSWDFrbzIrOXRiajBudEJ0TTdWazFFOEVXaUEvaDJNZXEwTEl2MSt5U0dUVXJFVzQ2Rk0wMUo1cHpFTHY1WHVwQmdodUp4UjVERzlmaU9XN3UzZFI1czN0Wm9WTHdBMUtkakp0WTBtbW5mQ3d4ZzZpNUFxaHZZK0ZBSTVENkNGNi9sSEE4UFdnNjNXYXN2cmh1SXY3MHhDTGpnUFQvajAwWmNQckx2QmYxRGVmR1ZpYzk4MENoL1NEdkMrTWRKMUY1d0lEQVFBQm94MHdHekFNQmdOVkhSTUJBZjhFQWpBQU1Bc0dBMVVkRHdRRUF3SUd3REFOQmdrcWhraUc5dzBCQVFzRkFBT0NBZ0VBQ2pmVFBvS1kyTjVNeGptQU1sdGQ1WFpDVjF2Z0F3RXRySVJZVG9kaEU4UjBUcDFRYW5BWGIwbHVQeUJ2NWhJWFdLNFZxQUk0ZmNUdFArbjdra3J3ZmhhNkVya1BXRk5KV0ptOFpzTW1ieS8zV2dWb0prT0Z5UllRcXI1SWwzTjZ3TWE1a2lEQnREUmJxQjNpRVhtdnRydmpXU0h5eEFFUit6bzNqV0dGbGhCWjBuUU5SdGp4OHNQRmloVmM1VFVINjgySEppVTRvV3ZUNjNEbnJhOG5jcWlXL3VDdVk4NmNyblVxMGZXN0x3LzMrUFk1eFhqTnhSL0hoM3NVUElUZkpyR2FMV3VyRDFKOW5wcjl5R0FKNnQ5enJoaFpuZXBJQzBEVU1jNStqNHBnMURyTzMyanp3VU9MUXFFckRpemg4NE5vSkNXd2JnK1VTOHdpM3pEMFpLaUR2N1hzVE5XQVcyQXAySmt6eWtLSGpGVFppRW0zdVpPa0pOZmN1M28ra2VmcjVIZlhGVCtpTjlLNUZVRWhhUXdnVWVaQlJKOFY1RjZnbWh6M2Q2aXhWYmlab0ZOaFlSOGUyazhnRjlnR3JWTXJFYkpHUXJsKzYrWllRTEZpYXVYZUc3ZnUxc3ZrMTlQdXlyZWRSSkduc2VKcXlWNFJ6Y1JHaEpBK2NMbm1wZERPVEVoaWdubnZuaEV1WTZIVlJZWVhoT1R5ZWVsdUVUN0tSQ3hiSkdxTzdUZFdnanJITDNIUmJORTROWTVHQWRPWnVMYVd4RWxHNVpWQ0hxdEcwTmg3VVFBaGN6K0VLeVpCQWV3djVYdUgwT29tWlh3Nm1NMm1ZMnNvTDZ6MTIyNE51c004L0JiSmNZVFFVbEFFS2JsRUNoaEdLMVhseGlWT1UybmM5S0U9IiBGZWNoYT0iMjAyMi0xMS0wNlQyMjo0MzoxMCIgRm9saW89IjYzODAzNDE0NTkwNDUzNzc5NjI0IiBGb3JtYVBhZ289IjAxIiBMdWdhckV4cGVkaWNpb249IjA2MzAwIiBNZXRvZG9QYWdvPSJQVUUiIE1vbmVkYT0iTVhOIiBOb0NlcnRpZmljYWRvPSIzMDAwMTAwMDAwMDQwMDAwMjQ0MyIgU2VsbG89ImdHUVJKRE9hRWN3blpLeHJiVmlGTlA3TXFGNU9YaEdObUwveE9BMThteXNVaXQ1Y3JTL2pFOTZvU3pZL3BIOGdCd1lwdW5WdmZybWtkc0h1V2dwVlcrOGtuVjRrS1EwbmxYVFU1QVp0WTVScG96TFpCT0NreFhyVysrZ2t5d2lNaE5rdVJSdnZqeXVPZWZXdUxiQUROMVYzS1VWK2ErejhMQ3d1Tm5WZVlVWUYxOTUzLy9jMGJtRGp3OGtJTTBJdU5KZDFVZWQvbzNYVFQ3N3RqUlAwQ1VKaEQ0WE1GZm1OWktadm5ZMjhIbGd3clQzWVF3UVo2ejZHZW5YUUJsNDYwb0tLRkJJek5HMUZFTm9pZCs0M3gvbXl5L0J5NWxGK0NKeFVLZ2F1SXhyVzVDY1lEYWFNeHVOeG5adUswQjM2MHRkcnFJOWY0MS9LU2IwWSs2NVNxdz09IiBTZXJpZT0iUm9ndWVPbmUiIFN1YlRvdGFsPSIyMDAuMDAiIFRpcG9DYW1iaW89IjEiIFRpcG9EZUNvbXByb2JhbnRlPSJJIiBUb3RhbD0iNjAzLjIwIiBWZXJzaW9uPSIzLjMiIHhtbG5zOmNmZGk9Imh0dHA6Ly93d3cuc2F0LmdvYi5teC9jZmQvMyIgeG1sbnM6eHNpPSJodHRwOi8vd3d3LnczLm9yZy8yMDAxL1hNTFNjaGVtYS1pbnN0YW5jZSIgeHNpOnNjaGVtYUxvY2F0aW9uPSJodHRwOi8vd3d3LnNhdC5nb2IubXgvY2ZkLzMgaHR0cDovL3d3dy5zYXQuZ29iLm14L3NpdGlvX2ludGVybmV0L2NmZC8zL2NmZHYzMy54c2QiPjxjZmRpOkVtaXNvciBOb21icmU9Ik1CIElERUFTIERJR0lUQUxFUyBTQyIgUmVnaW1lbkZpc2NhbD0iNjAxIiBSZmM9IlhJQTE5MDEyOEo2MSIgLz48Y2ZkaTpSZWNlcHRvciBOb21icmU9IlNXIFNNQVJURVJXRUIiIFJmYz0iQUFBMDEwMTAxQUFBIiBVc29DRkRJPSJHMDMiIC8+PGNmZGk6Q29uY2VwdG9zPjxjZmRpOkNvbmNlcHRvIENhbnRpZGFkPSIxIiBDbGF2ZVByb2RTZXJ2PSI1MDIxMTUwMyIgQ2xhdmVVbmlkYWQ9Ikg4NyIgRGVzY3JpcGNpb249IkNpZ2Fycm9zIiBJbXBvcnRlPSIyMDAuMDAiIE5vSWRlbnRpZmljYWNpb249IlVUNDIxNTExIiBVbmlkYWQ9IlBpZXphIiBWYWxvclVuaXRhcmlvPSIyMDAuMDAiPjxjZmRpOkltcHVlc3Rvcz48Y2ZkaTpUcmFzbGFkb3M+PGNmZGk6VHJhc2xhZG8gQmFzZT0iMjAwLjAwIiBJbXBvcnRlPSIzMi4wMCIgSW1wdWVzdG89IjAwMiIgVGFzYU9DdW90YT0iMC4xNjAwMDAiIFRpcG9GYWN0b3I9IlRhc2EiIC8+PGNmZGk6VHJhc2xhZG8gQmFzZT0iMjMyLjAwIiBJbXBvcnRlPSIzNzEuMjAiIEltcHVlc3RvPSIwMDMiIFRhc2FPQ3VvdGE9IjEuNjAwMDAwIiBUaXBvRmFjdG9yPSJUYXNhIiAvPjwvY2ZkaTpUcmFzbGFkb3M+PC9jZmRpOkltcHVlc3Rvcz48L2NmZGk6Q29uY2VwdG8+PC9jZmRpOkNvbmNlcHRvcz48Y2ZkaTpJbXB1ZXN0b3MgVG90YWxJbXB1ZXN0b3NUcmFzbGFkYWRvcz0iNDAzLjIwIj48Y2ZkaTpUcmFzbGFkb3M+PGNmZGk6VHJhc2xhZG8gSW1wb3J0ZT0iMzIuMDAiIEltcHVlc3RvPSIwMDIiIFRhc2FPQ3VvdGE9IjAuMTYwMDAwIiBUaXBvRmFjdG9yPSJUYXNhIiAvPjxjZmRpOlRyYXNsYWRvIEltcG9ydGU9IjM3MS4yMCIgSW1wdWVzdG89IjAwMyIgVGFzYU9DdW90YT0iMS42MDAwMDAiIFRpcG9GYWN0b3I9IlRhc2EiIC8+PC9jZmRpOlRyYXNsYWRvcz48L2NmZGk6SW1wdWVzdG9zPjxjZmRpOkNvbXBsZW1lbnRvPjx0ZmQ6VGltYnJlRmlzY2FsRGlnaXRhbCB4c2k6c2NoZW1hTG9jYXRpb249Imh0dHA6Ly93d3cuc2F0LmdvYi5teC9UaW1icmVGaXNjYWxEaWdpdGFsIGh0dHA6Ly93d3cuc2F0LmdvYi5teC9zaXRpb19pbnRlcm5ldC9jZmQvVGltYnJlRmlzY2FsRGlnaXRhbC9UaW1icmVGaXNjYWxEaWdpdGFsdjExLnhzZCIgVmVyc2lvbj0iMS4xIiBVVUlEPSIxNmQ2Y2VmZC03OGI4LTQ5ZmUtOTYzMS0yNTFiZGEwZjQwMzIiIEZlY2hhVGltYnJhZG89IjIwMjItMTEtMDdUMTA6NDM6MTIiIFJmY1Byb3ZDZXJ0aWY9IlNQUjE5MDYxM0k1MiIgU2VsbG9DRkQ9ImdHUVJKRE9hRWN3blpLeHJiVmlGTlA3TXFGNU9YaEdObUwveE9BMThteXNVaXQ1Y3JTL2pFOTZvU3pZL3BIOGdCd1lwdW5WdmZybWtkc0h1V2dwVlcrOGtuVjRrS1EwbmxYVFU1QVp0WTVScG96TFpCT0NreFhyVysrZ2t5d2lNaE5rdVJSdnZqeXVPZWZXdUxiQUROMVYzS1VWK2ErejhMQ3d1Tm5WZVlVWUYxOTUzLy9jMGJtRGp3OGtJTTBJdU5KZDFVZWQvbzNYVFQ3N3RqUlAwQ1VKaEQ0WE1GZm1OWktadm5ZMjhIbGd3clQzWVF3UVo2ejZHZW5YUUJsNDYwb0tLRkJJek5HMUZFTm9pZCs0M3gvbXl5L0J5NWxGK0NKeFVLZ2F1SXhyVzVDY1lEYWFNeHVOeG5adUswQjM2MHRkcnFJOWY0MS9LU2IwWSs2NVNxdz09IiBOb0NlcnRpZmljYWRvU0FUPSIzMDAwMTAwMDAwMDQwMDAwMjQ5NSIgU2VsbG9TQVQ9Ikozd2lQRkFSMnlvZkRqMGFneDM0RWhHM2YrRUsxTCt3RFFyYUdheDhpWlBiOXN2V0VKQlpneCt1MXNNQTZUYjVNRGkxNHpHb3Uwbnh2Yk9CY0dEYnpUdXBvL0N5ZjdlR2hrNC9WckVhQklINkZ5ZEhWNHRpZHh4ZUZxSFIrYlh0bGJzZkwzQnJyUUN3THBjblphVS9UNXZ1clhEOUVqUFg2MGRla0JlWnlzcUUwWFlxZTJTZ0kybmFxTFNqTGJURXUwMHFBWXJuMS9XZmRYU1M1d1Q3WEdhckRHM0lySEhVT1Blb3Nmc2VPWmJ1ZE5ISGRIL09BdmY4Lzl0S3lobll5M2VQYThGWWpNU282YlN3bXRlNXREUndOUjU3bTdTd0QvR3F2TkxXUS9peFVCeUpPOGgzU1VseWsxMytzNkJCZDRkcW9Ha1JnOHVXL0dKZmRWN2svdz09IiB4bWxuczp0ZmQ9Imh0dHA6Ly93d3cuc2F0LmdvYi5teC9UaW1icmVGaXNjYWxEaWdpdGFsIiB4bWxuczp4c2k9Imh0dHA6Ly93d3cudzMub3JnLzIwMDEvWE1MU2NoZW1hLWluc3RhbmNlIiAvPjwvY2ZkaTpDb21wbGVtZW50bz48L2NmZGk6Q29tcHJvYmFudGU+";
        $logo = "";
        $templateId = "cfdi33";
        $params = array(
            "urlApi" => "https://api.test.sw.com.mx",
            "url" => "https://services.test.sw.com.mx",
            "user" => "userforut@sw.com",
            "password" => "swpassut"
        );
        try {
            $pdfService = pdfService::Set($params);
            $result = $pdfService::GeneratePDF($xmlb64, $logo, $templateId, null, true);
            $resultSpect = "success";
            $this->assertEquals($resultSpect, $result->status);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
    public function testPDF_UrlNull()
    {
        $xml = "<?xml version='1.0' encoding='utf-8'?> <cfdi:Comprobante xsi:schemaLocation='http://www.sat.gob.mx/cfd/4 http://www.sat.gob.mx/sitio_internet/cfd/4/cfdv40.xsd' Version='4.0' Serie='Serie' Folio='Folio' Fecha='2022-10-22T00:18:10' Sello='Hm+9BL6j8nimtjsB6dUzoitYAzYqDF4n0mtyOdf+xaszVSO2jWVwMhIvfJisA/m84jSPEBJm1k16j11ibpvTfAOCrDdvxyf9LDi+AMlcCpy6Ibnub4/P6RUkKFg49Xnlx/9JeHijrTCVUGqGjkHzxKZD3CIhA8UfIIuxNCeUsxLYj1W4xab44MHULs0VoZd2/d4pGilSKpxMZgT0gfch9uyHePNL9lHI4OobpEI6NAklOffkPy4uDZJa2m7qt+I4p+fSmcluR/x2My8TrnaA4tNo3PaqdYWDvIcSBBMF3F/9aUUgorc8mjycKQHwcU6b+/lEL+DnUuONEHom66kyYA==' CondicionesDePago='CondicionesDePago' SubTotal='200' Descuento='1' Moneda='AMD' TipoCambio='1' Total='198.96' TipoDeComprobante='I' Exportacion='01' MetodoPago='PPD' FormaPago='99' LugarExpedicion='20000' xmlns:cfdi='http://www.sat.gob.mx/cfd/4' xmlns:xsi='http://www.w3.org/2001/XMLSchema-instance' NoCertificado='30001000000400002434' Certificado='MIIFuzCCA6OgAwIBAgIUMzAwMDEwMDAwMDA0MDAwMDI0MzQwDQYJKoZIhvcNAQELBQAwggErMQ8wDQYDVQQDDAZBQyBVQVQxLjAsBgNVBAoMJVNFUlZJQ0lPIERFIEFETUlOSVNUUkFDSU9OIFRSSUJVVEFSSUExGjAYBgNVBAsMEVNBVC1JRVMgQXV0aG9yaXR5MSgwJgYJKoZIhvcNAQkBFhlvc2Nhci5tYXJ0aW5lekBzYXQuZ29iLm14MR0wGwYDVQQJDBQzcmEgY2VycmFkYSBkZSBjYWRpejEOMAwGA1UEEQwFMDYzNzAxCzAJBgNVBAYTAk1YMRkwFwYDVQQIDBBDSVVEQUQgREUgTUVYSUNPMREwDwYDVQQHDAhDT1lPQUNBTjERMA8GA1UELRMIMi41LjQuNDUxJTAjBgkqhkiG9w0BCQITFnJlc3BvbnNhYmxlOiBBQ0RNQS1TQVQwHhcNMTkwNjE3MTk0NDE0WhcNMjMwNjE3MTk0NDE0WjCB4jEnMCUGA1UEAxMeRVNDVUVMQSBLRU1QRVIgVVJHQVRFIFNBIERFIENWMScwJQYDVQQpEx5FU0NVRUxBIEtFTVBFUiBVUkdBVEUgU0EgREUgQ1YxJzAlBgNVBAoTHkVTQ1VFTEEgS0VNUEVSIFVSR0FURSBTQSBERSBDVjElMCMGA1UELRMcRUtVOTAwMzE3M0M5IC8gWElRQjg5MTExNlFFNDEeMBwGA1UEBRMVIC8gWElRQjg5MTExNk1HUk1aUjA1MR4wHAYDVQQLExVFc2N1ZWxhIEtlbXBlciBVcmdhdGUwggEiMA0GCSqGSIb3DQEBAQUAA4IBDwAwggEKAoIBAQCN0peKpgfOL75iYRv1fqq+oVYsLPVUR/GibYmGKc9InHFy5lYF6OTYjnIIvmkOdRobbGlCUxORX/tLsl8Ya9gm6Yo7hHnODRBIDup3GISFzB/96R9K/MzYQOcscMIoBDARaycnLvy7FlMvO7/rlVnsSARxZRO8Kz8Zkksj2zpeYpjZIya/369+oGqQk1cTRkHo59JvJ4Tfbk/3iIyf4H/Ini9nBe9cYWo0MnKob7DDt/vsdi5tA8mMtA953LapNyCZIDCRQQlUGNgDqY9/8F5mUvVgkcczsIgGdvf9vMQPSf3jjCiKj7j6ucxl1+FwJWmbvgNmiaUR/0q4m2rm78lFAgMBAAGjHTAbMAwGA1UdEwEB/wQCMAAwCwYDVR0PBAQDAgbAMA0GCSqGSIb3DQEBCwUAA4ICAQBcpj1TjT4jiinIujIdAlFzE6kRwYJCnDG08zSp4kSnShjxADGEXH2chehKMV0FY7c4njA5eDGdA/G2OCTPvF5rpeCZP5Dw504RZkYDl2suRz+wa1sNBVpbnBJEK0fQcN3IftBwsgNFdFhUtCyw3lus1SSJbPxjLHS6FcZZ51YSeIfcNXOAuTqdimusaXq15GrSrCOkM6n2jfj2sMJYM2HXaXJ6rGTEgYmhYdwxWtil6RfZB+fGQ/H9I9WLnl4KTZUS6C9+NLHh4FPDhSk19fpS2S/56aqgFoGAkXAYt9Fy5ECaPcULIfJ1DEbsXKyRdCv3JY89+0MNkOdaDnsemS2o5Gl08zI4iYtt3L40gAZ60NPh31kVLnYNsmvfNxYyKp+AeJtDHyW9w7ftM0Hoi+BuRmcAQSKFV3pk8j51la+jrRBrAUv8blbRcQ5BiZUwJzHFEKIwTsRGoRyEx96sNnB03n6GTwjIGz92SmLdNl95r9rkvp+2m4S6q1lPuXaFg7DGBrXWC8iyqeWE2iobdwIIuXPTMVqQb12m1dAkJVRO5NdHnP/MpqOvOgLqoZBNHGyBg4Gqm4sCJHCxA1c8Elfa2RQTCk0tAzllL4vOnI1GHkGJn65xokGsaU4B4D36xh7eWrfj4/pgWHmtoDAYa8wzSwo2GVCZOs+mtEgOQB91/g=='> <cfdi:Emisor Rfc='EKU9003173C9' Nombre='ESCUELA KEMPER URGATE' RegimenFiscal='601' /> <cfdi:Receptor Rfc='URE180429TM6' Nombre='UNIVERSIDAD ROBOTICA ESPAÑOLA' DomicilioFiscalReceptor='65000' RegimenFiscalReceptor='601' UsoCFDI='G01' /> <cfdi:Conceptos> <cfdi:Concepto ClaveProdServ='50211503' Cantidad='1' ClaveUnidad='H87' Unidad='Pieza' Descripcion='Cigarros' ValorUnitario='200.00' Descuento='1' Importe='200.00' ObjetoImp='02'> <cfdi:Impuestos> <cfdi:Traslados> <cfdi:Traslado Base='1' Importe='0.16' Impuesto='002' TasaOCuota='0.160000' TipoFactor='Tasa' /> </cfdi:Traslados> <cfdi:Retenciones> <cfdi:Retencion Base='1' Impuesto='001' TipoFactor='Tasa' TasaOCuota='0.100000' Importe='0.10' /> <cfdi:Retencion Base='1' Impuesto='002' TipoFactor='Tasa' TasaOCuota='0.106666' Importe='0.10' /> </cfdi:Retenciones> </cfdi:Impuestos> </cfdi:Concepto> </cfdi:Conceptos> <cfdi:Impuestos TotalImpuestosRetenidos='0.20' TotalImpuestosTrasladados='0.16'> <cfdi:Retenciones> <cfdi:Retencion Impuesto='001' Importe='0.10' /> <cfdi:Retencion Impuesto='002' Importe='0.10' /> </cfdi:Retenciones> <cfdi:Traslados> <cfdi:Traslado Base='1' Importe='0.16' Impuesto='002' TasaOCuota='0.160000' TipoFactor='Tasa' /> </cfdi:Traslados> </cfdi:Impuestos> <cfdi:Complemento> <tfd:TimbreFiscalDigital xsi:schemaLocation='http://www.sat.gob.mx/TimbreFiscalDigital http://www.sat.gob.mx/sitio_internet/cfd/TimbreFiscalDigital/TimbreFiscalDigitalv11.xsd' Version='1.1' UUID='96b0ed9e-4f1a-43b0-b720-f77663891c68' FechaTimbrado='2022-10-23T19:35:10' RfcProvCertif='SPR190613I52' SelloCFD='Hm+9BL6j8nimtjsB6dUzoitYAzYqDF4n0mtyOdf+xaszVSO2jWVwMhIvfJisA/m84jSPEBJm1k16j11ibpvTfAOCrDdvxyf9LDi+AMlcCpy6Ibnub4/P6RUkKFg49Xnlx/9JeHijrTCVUGqGjkHzxKZD3CIhA8UfIIuxNCeUsxLYj1W4xab44MHULs0VoZd2/d4pGilSKpxMZgT0gfch9uyHePNL9lHI4OobpEI6NAklOffkPy4uDZJa2m7qt+I4p+fSmcluR/x2My8TrnaA4tNo3PaqdYWDvIcSBBMF3F/9aUUgorc8mjycKQHwcU6b+/lEL+DnUuONEHom66kyYA==' NoCertificadoSAT='30001000000400002495' SelloSAT='jozWLGYIFBawPbhKgKxRIsiGnu1yrXqoZOtJqn9RsqvKpyKpDowVEcCR/jiTcOl7+inShzorn/SAckgyoO/0KWEf8JL0RS1UgHMzFjV1iHzEMUahxZanRQRJ8DDlZZKSlGecW+kmaH/wF1e8D430vbreLOAdQuJsOnR7eGnkG6PlZKP0DgnwTnOUPb0I3I8AcL9yj3IVgyhIuxv7t/9/0V2FlUV8K9UhxZYvSfUH5ELP+VqIF05J4qIIKOFgIbpoKrCirUTjHip9FPlS3vBfWRe60g5E6iq7hIqmpGfdl4lhiBxX7ioulqnnrjMvOI94nEyCbErtY1jau1ZZLmvKOA==' xmlns:tfd='http://www.sat.gob.mx/TimbreFiscalDigital' xmlns:xsi='http://www.w3.org/2001/XMLSchema-instance' /> </cfdi:Complemento> </cfdi:Comprobante>";
        $logo = "";
        $templateId = "extradata";
        $extras = array("EDIRECCION1" => "Datos adicionales");
        $params = array(
            "urlApi" => "",
            "url" => "https://services.test.sw.com.mx",
            "user" => "userforut@sw.com",
            "password" => "swpassut"
        );
        try {
            $pdfService = pdfService::Set($params);
            $result = $pdfService::GeneratePDF($xml, $logo, $templateId, $extras, false);
            $resultSpect = 'xml null o dañado';
            $this->assertEquals($resultSpect, $result);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
    public function testPDF_XmlNull()
    {
        $xml = null;
        $logo = "";
        $templateId = "cfdi40";
        $params = array(
            "urlApi" => "https://api.test.sw.com.mx",
            "url" => "https://services.test.sw.com.mx",
            "user" => "userforut@sw.com",
            "password" => "swpassut"
        );
        try {
            $pdfService = pdfService::Set($params);
            $result = $pdfService::GeneratePDF($xml, $logo, $templateId, null, true);
            $resultSpect = 'xml vacio o no es válido.';
            $this->assertEquals($resultSpect, $result);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    /*-----------------------------Pruebas para Regenerate Service----------------------------------------*/
    public function testRegeneratePdf_TokenSuccess()
    {
        $uuid = "cddad1da-0141-438a-ba94-d3036a8ee82d";
        $params = array(
            "urlApi" => "https://api.test.sw.com.mx",
            "url" => "https://services.test.sw.com.mx",
            "token" => "T2lYQ0t4L0RHVkR4dHZ5Nkk1VHNEakZ3Y0J4Nk9GODZuRyt4cE1wVm5tbXB3YVZxTHdOdHAwVXY2NTdJb1hkREtXTzE3dk9pMmdMdkFDR2xFWFVPUXpTUm9mTG1ySXdZbFNja3FRa0RlYURqbzdzdlI2UUx1WGJiKzViUWY2dnZGbFloUDJ6RjhFTGF4M1BySnJ4cHF0YjUvbmRyWWpjTkVLN3ppd3RxL0dJPQ.T2lYQ0t4L0RHVkR4dHZ5Nkk1VHNEakZ3Y0J4Nk9GODZuRyt4cE1wVm5tbFlVcU92YUJTZWlHU3pER1kySnlXRTF4alNUS0ZWcUlVS0NhelhqaXdnWTRncklVSWVvZlFZMWNyUjVxYUFxMWFxcStUL1IzdGpHRTJqdS9Zakw2UGRZbFlVYmJVSkxXa1NZNzN5VUlSUzlJaTYvbi9wczBSRnZGK1NUNUVoM1FNNXZJRUg1Qkx1dXJ1Z09EcHYyQnE4V1dnOHpkczFLdm5MZytxalNBeHdRbmFvb2VhTksrVzhyTTFXU09NbzZVeXMyQ2Q4VC9ncUlqWGZaMFhXSkdmcjJIWlB2Z2RmeFJGNzRkdXh2UHlvdnVhbGN6cGFsRWhSY3BOOWxPc0h4Z2ZJRjBjZEl5WEsvZW0vb0ZxZEJjUGtpRFlWYi9zRDZwZVJFRks0QUpRNkplZ2N4UzVEME40d2RhUHA4c1VUQWJiY1Jvc3NSVFcrRzVyTHNOTWovZlJHQmV6c0lmclE1TXV3aVY3UERtQUo3SjdpTzhuc1R1SGt1R0s0UHUvc3hEZWRtK3U0NExEYUdUVWIxL3NKRE1XY1RlTnNMaENoSFUvVGhaclk2WmNPR2JjUlpib1RPUTN5QUxiU0VEY0NpYmJDcDZHY3pGd0ZJMXcxTEExTnBPdzM.VZBKM8Odz5VdIyhQPZyRaJK1iVLmot-oMf0h69NU4vk",
        );
        try {
            $pdfService = pdfService::Set($params);
            $result = $pdfService::RegeneratePDF($uuid);
            $resultSpect = "success";
            $this->assertEquals($resultSpect, $result->message);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
    public function testRegeneratePdf_AuthSuccess()
    {
        $uuid = "cddad1da-0141-438a-ba94-d3036a8ee82d";
        $params = array(
            "urlApi" => "https://api.test.sw.com.mx",
            "url" => "https://services.test.sw.com.mx",
            "token" => "T2lYQ0t4L0RHVkR4dHZ5Nkk1VHNEakZ3Y0J4Nk9GODZuRyt4cE1wVm5tbXB3YVZxTHdOdHAwVXY2NTdJb1hkREtXTzE3dk9pMmdMdkFDR2xFWFVPUXpTUm9mTG1ySXdZbFNja3FRa0RlYURqbzdzdlI2UUx1WGJiKzViUWY2dnZGbFloUDJ6RjhFTGF4M1BySnJ4cHF0YjUvbmRyWWpjTkVLN3ppd3RxL0dJPQ.T2lYQ0t4L0RHVkR4dHZ5Nkk1VHNEakZ3Y0J4Nk9GODZuRyt4cE1wVm5tbFlVcU92YUJTZWlHU3pER1kySnlXRTF4alNUS0ZWcUlVS0NhelhqaXdnWTRncklVSWVvZlFZMWNyUjVxYUFxMWFxcStUL1IzdGpHRTJqdS9Zakw2UGRZbFlVYmJVSkxXa1NZNzN5VUlSUzlJaTYvbi9wczBSRnZGK1NUNUVoM1FNNXZJRUg1Qkx1dXJ1Z09EcHYyQnE4V1dnOHpkczFLdm5MZytxalNBeHdRbmFvb2VhTksrVzhyTTFXU09NbzZVeXMyQ2Q4VC9ncUlqWGZaMFhXSkdmcjJIWlB2Z2RmeFJGNzRkdXh2UHlvdnVhbGN6cGFsRWhSY3BOOWxPc0h4Z2ZJRjBjZEl5WEsvZW0vb0ZxZEJjUGtpRFlWYi9zRDZwZVJFRks0QUpRNkplZ2N4UzVEME40d2RhUHA4c1VUQWJiY1Jvc3NSVFcrRzVyTHNOTWovZlJHQmV6c0lmclE1TXV3aVY3UERtQUo3SjdpTzhuc1R1SGt1R0s0UHUvc3hEZWRtK3U0NExEYUdUVWIxL3NKRE1XY1RlTnNMaENoSFUvVGhaclk2WmNPR2JjUlpib1RPUTN5QUxiU0VEY0NpYmJDcDZHY3pGd0ZJMXcxTEExTnBPdzM.VZBKM8Odz5VdIyhQPZyRaJK1iVLmot-oMf0h69NU4vk",
        );
        try {
            $pdfService = pdfService::Set($params);
            $result = $pdfService::RegeneratePDF($uuid);
            $resultSpect = "success";
            $this->assertEquals($resultSpect, $result->message);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
    public function testRegeneratePdfExtra_Success()
    {
        $extras =  array(
            "extras"=>array(
                "EDIRECCION1"=>"STERNO PRODUCTS 2483 Harbor Avenue Memphis, TN 38113"
            ),
            "templateId"=>"extradata"
        );
        $uuid = "cddad1da-0141-438a-ba94-d3036a8ee82d";
        $params = array(
            "urlApi" => "https://api.test.sw.com.mx",
            "url" => "https://services.test.sw.com.mx",
            "user" => "pruebas_ut@sw.com.mx",
            "password" => "SWpass12345"
        );
        try {
            $pdfService = pdfService::Set($params);
            $result = $pdfService::RegeneratePDF($uuid, $extras);
            $resultSpect = "success";
            $this->assertEquals($resultSpect, $result->message);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
    public function testRegenerate_Error()
    {
        $uuid = "cddad1da-0141-438a-ba94-d3036a8ee82d";
        $params = array(
            "urlApi" => "https://api.test.sw.com.mx",
            "user" => "pruebas_ut@sw.com.mx",
            "password" => "SWpass12345"
        );
        try {
            $pdfService = pdfService::Set($params);
            $result = $pdfService::RegeneratePDF($uuid);
            $this->assertEquals("error", $result->status);
            $this->assertEquals("URL debe especificarse", $result->message);
            $this->assertNotEmpty($result->messageDetail);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
    public function testRegenerate_UuidNull()
    {
        $uuid = null;
        $params = array(
            "urlApi" => "https://api.test.sw.com.mx",
            "url" => "https://services.test.sw.com.mx",
            "user" => "pruebas_ut@sw.com.mx",
            "password" => "SWpass12345"
        );
        try {
            $pdfService = pdfService::Set($params);
            $result = $pdfService::RegeneratePDF($uuid);
            $this->assertEquals("error", $result->status);
            $this->assertEquals("UID vacío o es inválido", $result->message);
            $this->assertNotEmpty($result->messageDetail);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

}
