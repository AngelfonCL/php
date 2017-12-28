<?php
namespace Angelfon\SDK\Rest\Api;

use Angelfon\SDK\Domain;
use Angelfon\SDK\Version;
use Angelfon\SDK\Exceptions\AngelfonException;
use Angelfon\SDK\Rest\Api\V099\UserContext;

class V099 extends Version
{
	protected $_user = null;

	/**
	 * @param \Angelfon\SDK\Domain $domain Domain where the version resides
	 * @return \Angelfon\SDK\Rest\Api\V099 The 0.99 version of the Angelfon API
	 */
	function __construct(Domain $domain)
	{
		parent::__construct($domain);
		$this->version = '0.99';
	}

	/**
	 * @return \Angelfon\SDK\Rest\Api\V099\UserContext
	 */
	public function getUser()
	{
		if (!$this->_user) $this->_user = new UserContext($this);
		return $this->_user;
	}

	/**
	 * @return \Angelfon\SDK\Rest\Api\V099\User\CallList
	 */
	public function getCalls()
	{
		return $this->user->calls;
	}

	/**
   * Magic getter to lazy load root resources
   * 
   * @param string $name Resource to return
   * @return \Angelfon\SDK\ListResource The requested resource
   * @throws \Angelfon\SDK\Exceptions\AngelfonException For unknown resource
   */
  public function __get($name) {
    $method = 'get' . ucfirst($name);
    if (method_exists($this, $method)) {
      return $this->$method();
    }

    throw new AngelfonException('Unknown resource ' . $name);
  }
}