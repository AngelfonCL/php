<?php
namespace Angelfon\SDK\Rest\Api\V099;

use Angelfon\SDK\Values;
use Angelfon\SDK\Version;
use Angelfon\SDK\Exceptions\AngelfonException;
use Angelfon\SDK\InstanceResource;

class UserInstance extends InstanceResource
{
	protected $_calls;
	/**
	 * @param \Angelfon\SDK\Version $version Version that contains the resource
	 * @param mixed[] $payload The response payload
	 */
	function __construct(Version $version, array $payload)
	{
		parent::__construct($version);

		$this->properties = array(
      'id' => Values::array_get($payload, 'id'),
      'email' => Values::array_get($payload, 'email'),
      'name' => Values::array_get($payload, 'name'),
      'maxRecipients' => Values::array_get($payload, 'maxrcp'),
      'callerId' => Values::array_get($payload, 'callerid'),
      'timezone' => Values::array_get($payload, 'timezone'),
    );
	}

	/**
   * Generate an instance context for the instance, the context is capable of
   * performing various actions.  All instance actions are proxied to the context
   * @return \Angelfon\SDK\Rest\Api\V099\UserContext Context for this UserInstance
   */
  protected function proxy() 
  {
    if (!$this->context) {
      $this->context = new AccountContext($this->version);
    }

    return $this->context;
  }

  /**
   * Fetch a UserInstance
   * 
   * @return \Angelfon\SDK\Rest\Api\V099\UserInstance Fetched UserInstance
   */
  public function fetch() {
    return $this->proxy()->fetch();
  }

  /**
   * Update the UserInstance
   * 
   * @param array|Options $options Optional Arguments
   * @return \Angelfon\SDK\Rest\Api\V099\UserInstance Updated UserInstance
   */
  public function update($options = array()) {
    return $this->proxy()->update($options);
  }

  /**
   * Magic getter to access properties
   * 
   * @param string $name Property to access
   * @return mixed The requested property
   * @throws \Angelfon\SDK\Exceptions\AngelfonException For unknown properties
   */
  public function __get($name) {
    if (array_key_exists($name, $this->properties)) {
      return $this->properties[$name];
    }

    if (property_exists($this, '_' . $name)) {
      $method = 'get' . ucfirst($name);
      return $this->$method();
    }

    throw new AngelfonException('Unknown property: ' . $name);
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
    return '[Angelfon.SDK.Api.V099.UserInstance ' . implode(' ', $context) . ']';
  }

}
