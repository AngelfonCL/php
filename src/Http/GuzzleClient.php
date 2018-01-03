<?php
namespace Angelfon\SDK\Http;

use GuzzleHttp\Client as HttpClient; 

class GuzzleClient implements Client {
	const DEFAULT_TIMEOUT = 60;

	public $lastRequest = null;
	public $lastResponse = null;

	public function request($method, $url, $params = [], $data = [], $headers = [], $timeout = DEFAULT_TIMEOUT)
	{
		$client = new HttpClient();

		$response = $client->request($method, $url, array(
			'headers' => $headers,
			'form_params' => $data,
			'query' => $params,
			'timeout' => $timeout,
			'http_errors' => false
		));

		$statusCode = $response->getStatusCode();
		$body = $response->getBody();
		$responseHeaders = $response->getHeaders();

		$this->lastResponse = new Response($statusCode, $body, $responseHeaders);
		return $this->lastResponse;
	}
}
