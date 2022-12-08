<?php

namespace SWServices\Storage;

use SWServices\Services;
class StorageResponse extends Services
{
    private static $datos;
    private static $xml;
    private static $codigoCancelacion;
    private static $statusSAT;
    private static $urlPDF;
    private static $urlAckCancellation;
    private static $hasAddenda;
    private static $addenda;
    private static $urlAddenda;
    private static $fechaGeneracionPdf;
    private static $idDealer;
    private static $idUser;
    private static $version;
    private static $serie;
    private static $folio;
    private static $fecha;
    private static $numeroCertificado;
    private static $subTotal;
    private static $descuento;
    private static $total;
    private static $moneda;
    private static $tipoCambio;
    private static $tipoDeComprobante;
    private static $metodoPago;
    private static $formaPago;
    private static $condicionesPago;
    private static $luegarExpedicion;
    private static $emisorRfc;
    private static $emisorNombre;
    private static $regimenFiscal;
    private static $receptorRfc;
    private static $receptorNombre;
    private static $residenciaFiscal;
    private static $numRegIdTrib;
    private static $usoCFDI;
    private static $totalImpuestosTraslados;
    private static $totalImpuestosRetencion;
    private static $trasladosIVA;
    private static $trasladosIEPS;
    private static $retencionesISR;
    private static $retencionesIVA;
    private static $retencionesIEPS;
    private static $totalImpuestosLocalesTraslados;
    private static $totalImpuestosLocalesRetencion;
    private static $complementos;
    private static $uuid;
    private static $fechaTimbrado;
    private static $rfcProvCertif;
    private static $selloCFD;
    private static $urlXml;
    private static $yearMonth;
    private static $status;
    /**
     * Inicializa constructor.
     */
    public function __construct($data)
    {
        if (isset($data->data->records[0])) {
            self::$datos = $data->data;
            self::$xml = $data->data->records[0]->urlXml;
            self::$codigoCancelacion = $data->data->records[0]->codigoCancelacion;
            self::$statusSAT = $data->data->records[0]->statusSAT;
            self::$urlPDF = $data->data->records[0]->urlPDF;
            self::$urlAckCancellation = $data->data->records[0]->urlAckCancellation;
            self::$hasAddenda = $data->data->records[0]->hasAddenda;
            self::$addenda = $data->data->records[0]->addenda;
            self::$urlAddenda = $data->data->records[0]->urlAddenda;
            self::$fechaGeneracionPdf = $data->data->records[0]->fechaGeneracionPdf;
            self::$idDealer = $data->data->records[0]->idDealer;
            self::$idUser = $data->data->records[0]->idUser;
            self::$version = $data->data->records[0]->version;
            self::$serie = $data->data->records[0]->serie;
            self::$folio = $data->data->records[0]->folio;
            self::$fecha = $data->data->records[0]->fecha;
            self::$numeroCertificado = $data->data->records[0]->numeroCertificado;
            self::$subTotal = $data->data->records[0]->subTotal;
            self::$descuento = $data->data->records[0]->descuento;
            self::$total = $data->data->records[0]->total;
            self::$moneda = $data->data->records[0]->moneda;
            self::$tipoCambio = $data->data->records[0]->tipoCambio;
            self::$tipoDeComprobante = $data->data->records[0]->tipoDeComprobante;
            self::$metodoPago = $data->data->records[0]->metodoPago;
            self::$formaPago = $data->data->records[0]->formaPago;
            self::$condicionesPago = $data->data->records[0]->condicionesPago;
            self::$luegarExpedicion = $data->data->records[0]->luegarExpedicion;
            self::$emisorRfc = $data->data->records[0]->emisorRfc;
            self::$emisorNombre = $data->data->records[0]->emisorNombre;
            self::$regimenFiscal = $data->data->records[0]->regimenFiscal;
            self::$receptorRfc = $data->data->records[0]->receptorRfc;
            self::$receptorNombre = $data->data->records[0]->receptorNombre;
            self::$residenciaFiscal = $data->data->records[0]->residenciaFiscal;
            self::$numRegIdTrib = $data->data->records[0]->numRegIdTrib;
            self::$usoCFDI = $data->data->records[0]->usoCFDI;
            self::$totalImpuestosTraslados = $data->data->records[0]->totalImpuestosTraslados;
            self::$totalImpuestosRetencion = $data->data->records[0]->totalImpuestosRetencion;
            self::$trasladosIVA = $data->data->records[0]->trasladosIVA;
            self::$trasladosIEPS = $data->data->records[0]->trasladosIEPS;
            self::$retencionesISR = $data->data->records[0]->retencionesISR;
            self::$retencionesIVA = $data->data->records[0]->retencionesIVA;
            self::$retencionesIEPS = $data->data->records[0]->retencionesIEPS;
            self::$totalImpuestosLocalesTraslados = $data->data->records[0]->totalImpuestosLocalesTraslados;
            self::$totalImpuestosLocalesRetencion = $data->data->records[0]->totalImpuestosLocalesRetencion;
            self::$complementos = $data->data->records[0]->complementos;
            self::$uuid = $data->data->records[0]->uuid;
            self::$fechaTimbrado = $data->data->records[0]->fechaTimbrado;
            self::$rfcProvCertif = $data->data->records[0]->rfcProvCertif;
            self::$selloCFD = $data->data->records[0]->selloCFD;
            self::$urlXml = $data->data->records[0]->urlXml;
            self::$yearMonth = $data->data->records[0]->yearMonth;
            self::$status = $data->status;

        } else {
            //se valida credenciales en esta clase ya que es la última en instanciarse
            //en storageservice
            self::ValidateCredentials();
            echo ("UUID inválido o no pertenece a la cuenta. \n");
        }
    }
    /**
     * Getters.
     */
    public static function getData()
    {
        return self::$datos;
    }
    public static function getXml()
    {
        return self::$xml;
    }
    public static function getPdf()
    {
        return self::$urlPDF;
    }
    public static function getCodigoCancelacion()
    {
        return self::$codigoCancelacion;
    }
    public static function getStatusSAT()
    {
        return self::$statusSAT;
    }
    public static function getUrlCancelacion()
    {
        return self::$urlAckCancellation;
    }
    public static function getHasAddenda()
    {
        return self::$hasAddenda;
    }
    public static function getAddenda()
    {
        return self::$addenda;
    }
    public static function setAddenda($addenda)
    {
        self::$addenda = $addenda;
    }
    public static function getUrlAddenda()
    {
        return self::$urlAddenda;
    }
    public static function getFechaGeneracionPdf()
    {
        return self::$fechaGeneracionPdf;
    }
    public static function getIdDealer()
    {
        return self::$idDealer;
    }
    public static function getIdUser()
    {
        return self::$idUser;
    }
    public static function getVersion()
    {
        return self::$version;
    }
    public static function getSerie()
    {
        return self::$serie;
    }
    public static function getFolio()
    {
        return self::$folio;
    }
    public static function getFecha()
    {
        return self::$fecha;
    }
    public static function getNumeroCertificado()
    {
        return self::$numeroCertificado;
    }
    public static function getSubTotal()
    {
        return self::$subTotal;
    }
    public static function getDescuento()
    {
        return self::$descuento;
    }
    public static function getTotal()
    {
        return self::$total;
    }
    public static function getMoneda()
    {
        return self::$moneda;
    }
    public static function getTipoCambio()
    {
        return self::$tipoCambio;
    }
    public static function getTipoDeComprobante()
    {
        return self::$tipoDeComprobante;
    }
    public static function getMetodoPago()
    {
        return self::$metodoPago;
    }
    public static function getFormaPago()
    {
        return self::$formaPago;
    }
    public static function getCondicionesPago()
    {
        return self::$condicionesPago;
    }
    public static function getLuegarExpedicion()
    {
        return self::$luegarExpedicion;
    }
    public static function getEmisorRfc()
    {
        return self::$emisorRfc;
    }
    public static function getEmisorNombre()
    {
        return self::$emisorNombre;
    }
    public static function getRegimenFiscal()
    {
        return self::$regimenFiscal;
    }
    public static function getReceptorRfc()
    {
        return self::$receptorRfc;
    }
    public static function getReceptorNombre()
    {
        return self::$receptorNombre;
    }
    public static function getResidenciaFiscal()
    {
        return self::$residenciaFiscal;
    }
    public static function getNumRegIdTrib()
    {
        return self::$numRegIdTrib;
    }
    public static function getUsoCFDI()
    {
        return self::$usoCFDI;
    }
    public static function getTotalImpuestosTraslados()
    {
        return self::$totalImpuestosTraslados;
    }
    public static function getTotalImpuestosRetencion()
    {
        return self::$totalImpuestosRetencion;
    }
    public static function getTrasladosIVA()
    {
        return self::$trasladosIVA;
    }
    public static function getTrasladosIEPS()
    {
        return self::$trasladosIEPS;
    }
    public static function getRetencionesISR()
    {
        return self::$retencionesISR;
    }
    public static function getRetencionesIVA()
    {
        return self::$retencionesIVA;
    }
    public static function setRetencionesIVA($retencionesIVA)
    {
        self::$retencionesIVA = $retencionesIVA;
    }
    public static function getRetencionesIEPS()
    {
        return self::$retencionesIEPS;
    }
    public static function getTotalImpuestosLocalesTraslados()
    {
        return self::$totalImpuestosLocalesTraslados;
    }
    public static function getTotalImpuestosLocalesRetencion()
    {
        return self::$totalImpuestosLocalesRetencion;
    }
    public static function getComplementos()
    {
        return self::$complementos;
    }
    public static function getUuid()
    {
        return self::$uuid;
    }
    public static function getFechaTimbrado()
    {
        return self::$fechaTimbrado;
    }
    public static function getRfcProvCertif()
    {
        return self::$rfcProvCertif;
    }
    public static function getSelloCFD()
    {
        return self::$selloCFD;
    }
    public static function getUrlXml()
    {
        return self::$urlXml;
    }
    public static function getEarMonth()
    {
        return self::$yearMonth;
    }
    public static function getStatus()
    {
        return self::$status;
    }
    private static function ValidateCredentials()
    {
        Services::get_token();
    }






}