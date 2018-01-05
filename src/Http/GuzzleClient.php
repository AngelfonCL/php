<?php
namespace Angelfon\SDK\Http;

use GuzzleHttp\Client as HttpClient; 

use Angelfon\SDK\Http\Response;

class GuzzleClient implements Client {
	const DEFAULT_TIMEOUT = 60;

	public $lastRequest = null;
	public $lastResponse = null;

	/**
	 * @param  string $method The HTTP method of this request
	 * @param  string $url The URL requested
	 * @param  string[] $params Query string params
	 * @param  string[] $data The body of the request
	 * @param  string[] $headers The headers of the request
	 * @param  int $timeout The time in seconds until the request times out
	 * @return \Angelfon\SDK\Http\Response
	 */
	public function request($method, $url, $params = [], $data = [], $headers = [], $timeout = self::DEFAULT_TIMEOUT)
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
