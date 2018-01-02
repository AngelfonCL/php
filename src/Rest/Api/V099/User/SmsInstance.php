<?php
namespace Angelfon\SDK\Rest\Api\V099\User;

use Angelfon\SDK\InstanceResource;
use Angelfon\SDK\Version;
use Angelfon\SDK\Values;
use Angelfon\SDK\Serialize;
use Angelfon\SDK\Exceptions\AngelfonException;

class SmsInstance extends InstanceResource
{
	function __construct(Version $version, array $payload, $id = null)
	{
		parent::__construct($version);

		$this->properties = array(
      'id' => Values::array_get($payload, 'id'),
      'batchId' => Values::array_get($payload, 'batch_id'),
      'batchName' => Values::array_get($payload, 'batch_name'),
      'sendAt' => Serialize::stringToCarbon($payload['send_at']),
      'sendedAt' => Serialize::stringToCarbon($payload['sended_at']),
      'to' => Values::array_get($payload, 'recipient'),
      'recipientName' => Values::array_get($payload, 'addressee'),
      'body' => Values::array_get($payload, 'body'),
      'status' => Values::array_get($payload, 'status'),
      'createdAt' => Serialize::stringToCarbon($payload['created_at']),
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