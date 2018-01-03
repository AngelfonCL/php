<?php
namespace Angelfon\SDK\Rest\Api\V099\User;

use Angelfon\SDK\InstanceResource;
use Angelfon\SDK\Version;
use Angelfon\SDK\Values;
use Angelfon\SDK\Serialize;
use Angelfon\SDK\Exceptions\AngelfonException;

class CallInstance extends InstanceResource
{
	function __construct(Version $version, array $payload, $id = null)
	{
		parent::__construct($version);

		$this->properties = array(
      'id' => Values::array_get($payload, 'id'),
      'batchId' => Values::array_get($payload, 'batch_id'),
      'batchName' => Values::array_get($payload, 'batch_name'),
      'callAt' => Serialize::stringToCarbon(Values::array_get($payload, 'calldate')),
      'calledAt' => Serialize::stringToCarbon(Values::array_get($payload, 'callout')),
      'from' => Values::array_get($payload, 'callerid'),
      'to' => Values::array_get($payload, 'destinatario'),
      'recipientName' => Values::array_get($payload, 'abrid'),
      'type' => Values::array_get($payload, 'dcontext'),
      'duration' => Values::array_get($payload, 'duration'),
      'status' => Values::array_get($payload, 'estado'),
      'answer' => Values::array_get($payload, 'answer'),
      'audioId1' => Values::array_get($payload, 'idmsg'),
      'audioId2' => Values::array_get($payload, 'idmsg1'),
      'audioId3' => Values::array_get($payload, 'idmsg2'),
      'tts1' => Values::array_get($payload, 'tts1'),
      'tts2' => Values::array_get($payload, 'tts2'),
      'cost' => Values::array_get($payload, 'cost'),
      'createdAt' => Serialize::stringToCarbon(Values::array_get($payload, 'created_at')),
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