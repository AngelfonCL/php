<?php
namespace Angelfon\SDK\Rest\Api\V099\User;

use Angelfon\SDK\InstanceContext;
use Angelfon\SDK\Values;
use Angelfon\SDK\Version;
use Angelfon\SDK\Rest\Api\V099\User\CallInstance;

class CallContext extends InstanceContext
{
	function __construct(Version $version, $id)
	{
		parent::__construct($version);
		$this->solution = array('id' => $id);
		$this->uri = '/calls/' . rawurlencode($id);
	}

	/**
   * Fetch a CallInstance
   * 
   * @return CallInstance Fetched CallInstance
   */
  public function fetch() {
    $params = Values::of(array());

    $payload = $this->version->fetch(
      'GET',
      $this->uri,
      $params
    );

    return new CallInstance(
      $this->version,
      $payload['data'],
      $this->solution['id']
    );
  }
}