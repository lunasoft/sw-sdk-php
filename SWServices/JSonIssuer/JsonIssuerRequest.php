<?php

namespace SWServices\JSonIssuer;

use Exception;


class JsonIssuerRequest
{


	public static function sendReq($url, $token, $json, $version, $isb64, $proxy)
	{
		$protocols = [
            CURL_SSLVERSION_TLSv1_2,
            CURL_SSLVERSION_TLSv1_3
        ];

		$headers = array(
			"Authorization: Bearer " . $token,
			"Content-Type: application/jsontoxml"
		);

		$path = $url . "/v3/cfdi33/issue/json/" . $version . ($isb64 ? '/b64' : '');

		$curl = curl_init();

		if (isset($proxy)) {
			curl_setopt($curl, CURLOPT_PROXY, $proxy);
		}

		curl_setopt_array($curl, array(
			CURLOPT_URL => $path,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_SSLVERSION => $protocols,
			CURLOPT_SSL_VERIFYPEER => 0,
			CURLOPT_SSL_VERIFYHOST => 0,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_CUSTOMREQUEST => "POST",
			CURLOPT_POSTFIELDS => $json,
			CURLOPT_HTTPHEADER => $headers
		));

		try {
			$response = curl_exec($curl);
			$httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
			$err = curl_error($curl);
			curl_close($curl);

			if ($err) {
				throw new Exception("cURL Error #:" . $err);
			} else {
				if ($httpcode < 500) {
					return json_decode($response);
				} else {
					throw new Exception("cUrl Error, HTTPCode: $httpcode, Response: $response");
				}
			}
		} catch (Exception $e) {
			throw new Exception("cUrl Error, HTTPCode: $httpcode, Response: $response");
		}
	}

	public static function sendReqJsonV4($url, $token, $json, $version, $customId, $pdf, $email, $path, $proxy)
	{
		$protocols = [
            CURL_SSLVERSION_TLSv1_2,
            CURL_SSLVERSION_TLSv1_3
        ];

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

		$url = $url . $path . $version;

		curl_setopt_array($curl, array(
			CURLOPT_URL => $url,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_SSLVERSION => $protocols,
			CURLOPT_SSL_VERIFYPEER => 0,
			CURLOPT_SSL_VERIFYHOST => 0,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_CUSTOMREQUEST => "POST",
			CURLOPT_POSTFIELDS => $json,
			CURLOPT_HTTPHEADER => $headers
		));

		try {
			$response = curl_exec($curl);
			$httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
			$err = curl_error($curl);
			curl_close($curl);

			if ($err) {
				throw new Exception("cURL Error #:" . $err);
			} else {
				if ($httpcode < 500) {
					return json_decode($response);
				} else {
					throw new Exception("cUrl Error, HTTPCode: $httpcode, Response: $response");
				}
			}
		} catch (Exception $e) {
			throw new Exception("cUrl Error, HTTPCode: $httpcode, Response: $response");
		}
	}
}
