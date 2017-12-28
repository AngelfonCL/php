<?php
namespace Angelfon\SDK;

use Angelfon\SDK\Exceptions\RestException;
use Angelfon\SDK\Domain;

abstract class Version
{
	protected $domain;
	protected $version;
	
	function __construct(Domain $domain)
	{
		$this->domain = $domain;
    $this->version = null;
	}

  /**
   * Generate an absolute URL from a version relative uri
   * @param string $uri Version relative uri
   * @return string Absolute URL
   */
  public function absoluteUrl($uri) {
    return $this->getDomain()->absoluteUrl($this->relativeUri($uri));
  }

  /**
   * Generate a domain relative uri from a version relative uri
   * @param string $uri Version relative uri
   * @return string Domain relative uri
   */
  public function relativeUri($uri) {
    return trim($this->version, '/') . '/' . trim($uri, '/');
  }
	
  public function request($method, $uri, $params = array(), $data = array(),
                        $headers = array(), $timeout = null) 
  {
    $uri = $this->relativeUri($uri);
    return $this->getDomain()->request(
      $method,
      $uri,
      $params,
      $data,
      $headers,
      $timeout
    );
  }

  /**
   * Create the best possible exception for the response.
   *
   * Attempts to parse the response for Angelfon Standard error messages and use
   * those to populate the exception, falls back to generic error message and
   * HTTP status code.
   *
   * @param Response $response Error response
   * @param string $header Header for exception message
   * @return \Angelfon\SDK\Exceptions\RestException
   */
  protected function exception($response, $header) {
    $message = '[HTTP ' . $response->getStatusCode() . '] ' . $header;

    $content = $response->getContent();
    if (is_array($content)) {
      $message .= isset($content['data']) ? ': ' . $content['data'] : '';
      $code = isset($content['error']) ? $content['error'] : $response->getStatusCode();
      return new RestException($message, $code, $response->getStatusCode());
    } else {
      return new RestException($message, $response->getStatusCode(), $response->getStatusCode());
    }
  }

  public function fetch($method, $uri, $params = array(), $data = array(),
                        $headers = array(), $timeout = null) {
    $response = $this->request(
      $method,
      $uri,
      $params,
      $data,
      $headers,
      $timeout
    );

    if ($response->getStatusCode() < 200 || $response->getStatusCode() >= 300) {
      throw $this->exception($response, 'Unable to fetch record');
    }

    return $response->getContent();
  }

	public function update($method, $uri, $params = array(), $data = array(),
                         $headers = array(), $timeout = null) {
    $response = $this->request(
      $method,
      $uri,
      $params,
      $data,
      $headers,
      $timeout
    );

    if ($response->getStatusCode() < 200 || $response->getStatusCode() >= 300) {
      throw $this->exception($response, 'Unable to update record');
    }

    return $response->getContent();
  }

  public function delete($method, $uri, $params = array(), $data = array(),
                         $headers = array(), $timeout = null) {
    $response = $this->request(
      $method,
      $uri,
      $params,
      $data,
      $headers,
      $timeout
    );

    if ($response->getStatusCode() < 200 || $response->getStatusCode() >= 300) {
    	throw $this->exception($response, 'Unable to delete record');
    }

    return $response->getStatusCode() == 204;
  }

  public function create($method, $uri, $params = array(), $data = array(),
                         $headers = array(), $timeout = null) {
    $response = $this->request(
      $method,
      $uri,
      $params,
      $data,
      $headers,
      $timeout
    );

    if ($response->getStatusCode() < 200 || $response->getStatusCode() >= 300) {
      throw $this->exception($response, 'Unable to create record');
    }

    return $response->getContent();
  }

  public function page($method, $uri, $params = array(), $data = array(),
                       $headers = array(), $timeout = null) {
    return $this->request(
      $method,
      $uri,
      $params,
      $data,
      $headers,
      $timeout
    );
  }

  /**
   * @return \Angelfon\SDK\Domain $domain
   */
  public function getDomain() {
      return $this->domain;
  }

  public function __toString() {
      return '[Version]';
  }

}