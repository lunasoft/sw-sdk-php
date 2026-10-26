<?php

namespace SWServices;

require_once 'SWServices/Helpers/RequestHelper.php';

use SWServices\Authentication\AuthenticationService as Authentication;
use SWServices\Helpers\RequestHelper as Request;
use Exception;

class Services extends Request
{
    private static $_token = null;
    private static $_user = null;
    private static $_password = null;
    private static $_url = null;
    private static $_urlApi = null;
    private static $_expirationDate = null;
    private static $_proxy = null;
    private static $_sslOptions = [];
    private static $_debug = false;
    private static $_timeoutOptions = ['timeout' => null, 'connect_timeout' => null];
    private static $_timeSession = "PT2H";

    public function __construct($params)
    {
        if (isset($params['url'])) {
            self::$_url = $params['url'];
        } else if (isset($params['urlApi'])) {
            self::$_urlApi = $params['urlApi'];
        } else {
            throw new Exception('URL debe especificarse');
        }
        if (isset($params['urlApi'])) {
            self::$_urlApi = $params['urlApi'];
        }
        if (!isset($params['user']) && !isset($params['password']) && !isset($params['token'])) {
            throw new Exception('Datos de autenticación deben especificarse');
        }
        if (isset($params['user'])) {
            self::$_user = $params['user'];
        }
        if (isset($params['password'])) {
            self::$_password = $params['password'];
        }
        if (isset($params['proxy'])) {
            self::$_proxy = $params['proxy'];
        }
        // Reset request options on each service configuration, before authentication.
        self::$_sslOptions = [
            'verify_ssl' => ($params['verify_ssl'] ?? true) !== false,
            'cainfo' => $params['cainfo'] ?? null
        ];
        self::$_debug = ($params['debug'] ?? false) === true;
        self::$_timeoutOptions = [
            'timeout' => $params['timeout'] ?? null,
            'connect_timeout' => $params['connect_timeout'] ?? null
        ];
        if (isset($params['token'])) {
            self::$_token = $params['token'];
            date_default_timezone_set("America/Mexico_City");
            self::$_expirationDate = new \DateTime('NOW');
            self::$_expirationDate->add(new \DateInterval("P5Y"));
        }
    }

    public static function get_token()
    {

        if (self::$_token == null || new \DateTime('NOW') > self::$_expirationDate) {
            $params = array(
                "url" => self::$_url,
                "user" => self::$_user,
                "password" => self::$_password,
                "verify_ssl" => self::$_sslOptions['verify_ssl'] ?? true,
                "cainfo" => self::$_sslOptions['cainfo'] ?? null,
                "debug" => self::$_debug,
                "timeout" => self::$_timeoutOptions['timeout'],
                "connect_timeout" => self::$_timeoutOptions['connect_timeout']
            );

            $auth = Authentication::auth($params);
            $token = $auth::Token();
            if ($token->status == "success") {
                self::set_token($token->data->token);
            } else {
                preg_match('/^.{0,500}/us', (string) $token->message, $message);
                preg_match('/^.{0,500}/us', (string) $token->messageDetail, $messageDetail);
                $message = $message[0] ?? substr((string) $token->message, 0, 500);
                $messageDetail = $messageDetail[0] ?? substr((string) $token->messageDetail, 0, 500);
                throw new Exception("Authentication error: $message Detail: $messageDetail");
            }
            date_default_timezone_set("America/Mexico_City");
        }
        return  self::$_token;
    }

    public static function get_url()
    {
        return  self::$_url;
    }
    public static function get_urlApi()
    {
        return self::$_urlApi;
    }
    public static function get_user()
    {
        return  self::$_user;
    }
    public static function get_password()
    {
        return  self::$_password;
    }

    public static function set_token($token)
    {
        self::$_token = $token;
    }
    /**
     * SSL configuration shared by requests, including token renewal.
     */
    public static function get_ssl_options(): array
    {
        return self::$_sslOptions;
    }

    public static function get_debug()
    {
        return self::$_debug;
    }

    public static function get_timeout_options(): array
    {
        return self::$_timeoutOptions;
    }

    public static function get_proxy()
    {
        return self::$_proxy;
    }
};
