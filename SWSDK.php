<?php
    file_exists("vendor/autoload.php")?require "vendor/autoload.php":"";
    require_once dirname(__FILE__) . '/SWServices/Services.php';
    require_once dirname(__FILE__) . '/SWServices/Authentication/AuthenticationService.php';
    require_once dirname(__FILE__) . '/SWServices/Authentication/AuthRequest.php';
    require_once dirname(__FILE__) . '/SWServices/Stamp/StampRequest.php';
    require_once dirname(__FILE__) . '/SWServices/Stamp/StampService.php';
    require_once dirname(__FILE__) . '/SWServices/Issuer/IssuerService.php';
    require_once dirname(__FILE__) . '/SWServices/Cancelation/CancelationService.php';
    require_once dirname(__FILE__) . '/SWServices/Cancelation/CancelationRequest.php';
    require_once dirname(__FILE__) . '/SWServices/Cancelation/CancelationHandler.php';
    require_once dirname(__FILE__) . '/SWServices/AccountBalance/AccountBalanceRequest.php';
    require_once dirname(__FILE__) . '/SWServices/AccountBalance/AccountBalanceService.php';
    require_once dirname(__FILE__) . '/SWServices/Validation/ValidateRequest.php';
    require_once dirname(__FILE__) . '/SWServices/Validation/ValidateXMLService.php';
    require_once dirname(__FILE__) . '/SWServices/Validation/ValidateLcoService.php';
    require_once dirname(__FILE__) . '/SWServices/Validation/ValidateLrfcService.php';
    require_once dirname(__FILE__) . '/SWServices/JSonIssuer/JsonIssuerRequest.php';
    require_once dirname(__FILE__) . '/SWServices/JSonIssuer/JsonIssuerService.php';
    require_once dirname(__FILE__) . '/SWServices/Toolkit/SignService.php';
    require_once dirname(__FILE__) . '/SWServices/SatQuery/SatQueryRequest.php';
    require_once dirname(__FILE__) . '/SWServices/SatQuery/SatQueryService.php';
    require_once dirname(__FILE__) . '/SWServices/Csd/CsdRequest.php';
    require_once dirname(__FILE__) . '/SWServices/Csd/CsdService.php';
    require_once dirname(__FILE__) . '/SWServices/Taxpayer/TaxpayerRequest.php';
    require_once dirname(__FILE__) . '/SWServices/Taxpayer/TaxpayerService.php';
    
?>