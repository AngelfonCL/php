<?php
namespace Angelfon\SDK;


use Angelfon\SDK\Rest\Client;

/**
 * Class Domain
 * Abstracts an Angelfon sub domain
 * @package Angelfon
 */
abstract class Domain {
    /**
     * @var \Angelfon\SDK\Rest\Client Angelfon Client
     */
    protected $client;

    /**
     * @var string Base URL for this domain
     */
    protected $baseUrl;

    /**
     * Construct a new Domain
     * @param \Angelfon\SDK\Rest\Client $client used to communicate with Angelfon
     */
    public function __construct(Client $client) {
        $this->client = $client;
        $this->baseUrl = '';
    }

    /**
     * Translate version relative URIs into absolute URLs
     *
     * @param string $uri Version relative URI
     * @return string Absolute URL for this domain
     */
    public function absoluteUrl($uri) {
        return implode('/', array(trim($this->baseUrl, '/'), trim($uri, '/')));
    }

    /**
     * Make an HTTP request to the domain
     *
     * @param string $method HTTP Method to make the request with
     * @param string $uri Relative uri to make a request to
     * @param array $params Query string arguments
     * @param array $data Post form data
     * @param array $headers HTTP headers to send with the request
     * @param string $user User to authenticate as
     * @param string $password Password
     * @param null $timeout Request timeout
     * @return \Angelfon\SDK\Http\Response the response for the request
     */
    public function request($method, $uri, $params = array(), $data = array(),
                            $headers = array(), $timeout=null) {
        $url = $this->absoluteUrl($uri);
        return $this->client->request(
            $method,
            $url,
            $params,
            $data,
            $headers,
            $timeout
        );
    }

    /**
     * @return \Angelfon\SDK\Rest\Client
     */
    public function getClient() {
        return $this->client;
    }

    public function __toString() {
        return '[Domain]';
    }
}
