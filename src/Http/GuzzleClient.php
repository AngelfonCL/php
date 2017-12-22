<?php
namespace Angelfon\SDK\Http;

use GuzzleHttp\Client as HttpClient; 

class GuzzleClient implements Client {
	const DEFAULT_TIMEOUT = 60;

	public $lastRequest = null;
	public $lastResponse = null;

	public function request($method, $url, $params = [], $data = [], $headers = [], $timeout = null)
	{


		$this->lastResponse = new Response($statusCode, $body, $responseHeaders);
		return $this->lastResponse;
	}
}
