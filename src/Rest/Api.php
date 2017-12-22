<?php
namespace Angelfon\SDK\Rest;

use Angelfon\SDK\Domain;
use Angelfon\SDK\Rest\Client;
use Angelfon\SDK\Rest\Api\V099;

class Api extends Domain
{	
	/**
	 * API Version
	 * @var \Angelfon\SDK\Rest\Api\V099
	 */
	protected $_v099;

	function __construct(Client $client)
	{
			parent::__construct($client);

			$this->baseUrl = 'https://api.angelfon.com';
	}

	function getV099()
	{
		if (!$this->_v099) $this->_v099 = new V099($this);
		return $this->_v099;
	}

	/**
   * Magic getter to lazy load versions
   * 
   * @param string $name Domain to return
   * @return \Angelfon\SDK\Version The requested version
   * @throws \Angelfon\SDK\Exceptions\AngelfonException For unknown versions
   */
  public function __get($name) {
    $method = 'get' . ucfirst($name);
    if (method_exists($this, $method)) {
        return $this->$method();
    }

    throw new AngelfonException('Unknown version ' . $name);
  }
}