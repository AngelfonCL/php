<?php
namespace Angelfon\SDK\Rest\Api\V099;

use Angelfon\SDK\InstanceContext;
use Angelfon\SDK\Version;
use Angelfon\SDK\Values;
use Angelfon\SDK\Exceptions\AngelfonException;
use Angelfon\SDK\Rest\Api\V099\UserInstance;
use Angelfon\SDK\Rest\Api\V099\User\CallList;
use Angelfon\SDK\Rest\Api\V099\User\SmsList;

class UserContext extends InstanceContext
{
	protected $_calls = null;
	protected $_sms = null;


	public function __construct(Version $version)
	{
		parent::__construct($version);
		$this->uri = '/user';
	}

	/**
	 * Fetch an User instance
	 * @return \Angelfon\SDK\Rest\Api\V099\UserInstance The User instance
	 */
	public function fetch()
	{
		$params = Values::of(array());

    $payload = $this->version->fetch(
      'GET',
      $this->uri,
      $params
    );

    return new UserInstance($this->version, $payload);
	}

	/**
   * Access the calls
   * 
   * @return \Angelfon\SDK\Rest\Api\V099\User\CallList 
   */
  protected function getCalls() {
    if (!$this->_calls) $this->_calls = new CallList($this->version);
    return $this->_calls;
  }

	/**
   * Access the sms
   * 
   * @return \Angelfon\SDK\Rest\Api\V099\User\SmsList 
   */
  protected function getSms() {
    if (!$this->_sms) $this->_sms = new SmsList($this->version);
    return $this->_sms;
  }

  /**
   * Magic getter to lazy load subresources
   * 
   * @param string $name Subresource to return
   * @return \Angelfon\SDK\ListResource The requested subresource
   * @throws \Angelfon\SDK\Exceptions\AngelfonException For unknown subresources
   */
  public function __get($name) {
    if (property_exists($this, '_' . $name)) {
      $method = 'get' . ucfirst($name);
      return $this->$method();
    }

    throw new AngelfonException('Unknown subresource ' . $name);
  }

  /**
   * Magic caller to get resource contexts
   * 
   * @param string $name Resource to return
   * @param array $arguments Context parameters
   * @return \Angelfon\SDK\InstanceContext The requested resource context
   * @throws \Angelfon\SDK\Exceptions\AngelfonException For unknown resource
   */
  public function __call($name, $arguments) {
    $property = $this->$name;
    if (method_exists($property, 'getContext')) {
      return call_user_func_array(array($property, 'getContext'), $arguments);
    }

    throw new AngelfonException('Resource does not have a context');
  }

  /**
   * Provide a friendly representation
   * 
   * @return string Machine friendly representation
   */
  public function __toString() {
    $context = array();
    foreach ($this->solution as $key => $value) {
      $context[] = "$key=$value";
    }
    return '[Angelfon.SDK.Api.V099.UserContext ' . implode(' ', $context) . ']';
  }
}