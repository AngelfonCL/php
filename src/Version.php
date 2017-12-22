<?php
namespace Angelfon\SDK;

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


}