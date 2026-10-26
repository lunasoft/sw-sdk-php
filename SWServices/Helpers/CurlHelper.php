<?php

namespace SWServices\Helpers;

class CurlHelper
{
    /**
     * Verify certificates by default; only an explicit boolean false opts out.
     * Use an optional custom CA bundle when provided.
     */
    public static function applySslOptions($curl, array $params = []): void
    {
        $verifySsl = ($params['verify_ssl'] ?? true) !== false;
        // TLS 1.2 como mínimo (cURL negocia 1.3 si el servidor lo soporta). Debe ser un entero, no un arreglo.
        curl_setopt($curl, CURLOPT_SSLVERSION, CURL_SSLVERSION_TLSv1_2);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, $verifySsl);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, $verifySsl ? 2 : 0);

        if (isset($params['cainfo'])) {
            curl_setopt($curl, CURLOPT_CAINFO, $params['cainfo']);
        }
    }

    /**
     * Timeout total de 60 s por defecto; `timeout` => 0 desactiva el límite.
     */
    public static function applyTimeoutOptions($curl, array $params = []): void
    {
        if (empty($params) && class_exists('SWServices\\Services', false)) {
            $params = \SWServices\Services::get_timeout_options();
        }
        $timeout = 60;
        $connectTimeout = 15;
        if (isset($params['timeout']) && is_numeric($params['timeout']) && (int)$params['timeout'] >= 0) {
            $timeout = (int)$params['timeout'];
        }
        if (isset($params['connect_timeout']) && is_numeric($params['connect_timeout']) && (int)$params['connect_timeout'] > 0) {
            $connectTimeout = (int)$params['connect_timeout'];
        }
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, $connectTimeout);
        curl_setopt($curl, CURLOPT_TIMEOUT, $timeout);
    }

    /**
     * Only follow redirects when the caller permits it, using HTTP(S) protocols.
     */
    public static function applyRedirectOptions($curl, $url, bool $follow = false): void
    {
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, $follow);
        $protocols = CURLPROTO_HTTPS;
        if (stripos((string)$url, 'http://') === 0) {
            $protocols |= CURLPROTO_HTTP;
        }
        curl_setopt($curl, CURLOPT_PROTOCOLS, $protocols);
        curl_setopt($curl, CURLOPT_REDIR_PROTOCOLS, $follow ? $protocols : 0);
    }
}
