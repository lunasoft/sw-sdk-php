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
     * Bound connection and request time while allowing explicit positive numeric values.
     */
    public static function applyTimeoutOptions($curl, array $params = [], int $defaultTimeout = 60): void
    {
        if (empty($params) && class_exists('SWServices\\Services', false)) {
            $params = \SWServices\Services::get_timeout_options();
        }
        $timeout = max(60, $defaultTimeout);
        $connectTimeout = 15;
        if (isset($params['timeout']) && is_numeric($params['timeout']) && (int)$params['timeout'] > 0) {
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

    /**
     * Limit remote bodies included in diagnostics without requiring mbstring.
     */
    public static function truncateResponse($response): string
    {
        $response = (string)$response;
        if (function_exists('mb_substr')) {
            return mb_substr($response, 0, 500, 'UTF-8');
        }
        if (preg_match('/^.{0,500}/us', $response, $matches) === 1) {
            return $matches[0];
        }

        $truncated = substr($response, 0, 500);
        if (function_exists('mb_convert_encoding')) {
            $truncated = mb_convert_encoding($truncated, 'UTF-8', 'UTF-8');
        } elseif (function_exists('iconv')) {
            $converted = @iconv('UTF-8', 'UTF-8//IGNORE', $truncated);
            if ($converted !== false) {
                $truncated = $converted;
            }
        }
        while ($truncated !== '' && preg_match('//u', $truncated) !== 1) {
            $truncated = substr($truncated, 0, -1);
        }
        return $truncated;
    }
}
