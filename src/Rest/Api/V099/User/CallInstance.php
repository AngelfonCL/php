<?php
namespace Angelfon\SDK\Rest\Api\V099\User;

use Angelfon\SDK\InstanceResource;
use Angelfon\SDK\Version;
use Angelfon\SDK\Values;
use Angelfon\SDK\Exceptions\AngelfonException;

class CallInstance extends InstanceResource
{
	function __construct(Version $version, array $payload, $id = null)
	{
		parent::__construct($version);

		$this->properties = array(
      'success' => Values::array_get($payload, 'success'),
      'id' => Values::array_get($payload, 'data'),
      'batchId' => Values::array_get($payload, 'batch_id'),
    );

    $this->solution = array('id' => $id ?: $this->properties['id']);
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
}