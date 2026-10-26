<?php

namespace SWServices\JSonIssuer;

use SWServices\Helpers\CurlHelper;
use SWServices\Services;

use Exception;


class JsonIssuerRequest
{


	public static function sendReq($url, $token, $json, $version, $isb64, $proxy)
	{

		$headers = array(
			"Authorization: Bearer " . $token,
			"Content-Type: application/jsontoxml"
		);

		$path = $url . "/v3/cfdi33/issue/json/" . rawurlencode((string)$version) . ($isb64 ? '/b64' : '');

		$curl = curl_init();

		if (isset($proxy)) {
			curl_setopt($curl, CURLOPT_PROXY, $proxy);
		}

		curl_setopt_array($curl, array(
			CURLOPT_URL => $path,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_CUSTOMREQUEST => "POST",
			CURLOPT_POSTFIELDS => $json,
			CURLOPT_HTTPHEADER => $headers
		));

		try {
			CurlHelper::applySslOptions($curl, Services::get_ssl_options());
			CurlHelper::applyTimeoutOptions($curl, [], 120);
			CurlHelper::applyRedirectOptions($curl, $url, false);
			$response = curl_exec($curl);
			$httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
			$err = curl_error($curl);

			if ($err) {
				throw new Exception("cURL Error #:" . $err);
			} else {
				if ($httpcode < 500) {
					return json_decode($response);
				} else {
					throw new Exception("cUrl Error, HTTPCode: $httpcode, Response: " . CurlHelper::truncateResponse($response));
				}
			}
		} catch (Exception $e) {
			throw new Exception("cUrl Error, HTTPCode: $httpcode, Response: " . CurlHelper::truncateResponse($response));
		}
	}

	public static function sendReqJsonV4($url, $token, $json, $version, $customId, $pdf, $email, $path, $proxy)
	{

		$headers = array(
			"Authorization: Bearer " . $token,
			"Content-Type: application/jsontoxml"
		);

		if ($pdf) {
			$headers[] = "extra: pdf";
		}

		if ($email !== NULL) {
			$email = implode(',', (array) $email);
			$headers[] = "email: " . $email;
		}

		if ($customId !== NULL) {
			$customId = "customid: " . $customId;
			$headers[] = $customId;
		}

		$curl = curl_init();

		if (isset($proxy)) {
			curl_setopt($curl, CURLOPT_PROXY, $proxy);
		}

		$url = $url . $path . rawurlencode((string)$version);

		curl_setopt_array($curl, array(
			CURLOPT_URL => $url,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_CUSTOMREQUEST => "POST",
			CURLOPT_POSTFIELDS => $json,
			CURLOPT_HTTPHEADER => $headers
		));

		try {
			CurlHelper::applySslOptions($curl, Services::get_ssl_options());
			CurlHelper::applyTimeoutOptions($curl, [], 120);
			CurlHelper::applyRedirectOptions($curl, $url, false);
			$response = curl_exec($curl);
			$httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
			$err = curl_error($curl);

			if ($err) {
				throw new Exception("cURL Error #:" . $err);
			} else {
				if ($httpcode < 500) {
					return json_decode($response);
				} else {
					throw new Exception("cUrl Error, HTTPCode: $httpcode, Response: " . CurlHelper::truncateResponse($response));
				}
			}
		} catch (Exception $e) {
			throw new Exception("cUrl Error, HTTPCode: $httpcode, Response: " . CurlHelper::truncateResponse($response));
		}
	}
}
