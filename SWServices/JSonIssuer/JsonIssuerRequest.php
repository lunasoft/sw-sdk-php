<?php

namespace SWServices\JSonIssuer;

use Exception;


class JsonIssuerRequest
{


	public static function sendReq($url, $token, $json, $version, $isb64, $proxy)
	{
		$headers = array(
			"Authorization: Bearer " . $token,
			"Content-Type: application/jsontoxml"
		);

		//Path para timbrar, no se coloca como parametro ya que puede afectar a los clientes que ya lo tienen en su codigo
		$path = "/v3/cfdi33/issue/json/";

		$curl = curl_init();

		if (isset($proxy)) {
			curl_setopt($curl, CURLOPT_PROXY, $proxy);
		}

		curl_setopt_array($curl, array(
			CURLOPT_URL => $url . $path . $version . ($isb64 ? '/b64' : ''),
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_SSL_VERIFYPEER => false,
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

		curl_setopt_array($curl, array(
			CURLOPT_URL => $url . $path . $version,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_SSL_VERIFYPEER => false,
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
