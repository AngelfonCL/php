<?php
namespace Angelfon\SDK\Rest\Api\V099\User;

use Angelfon\SDK\InstanceContext;
use Angelfon\SDK\Values;
use Angelfon\SDK\Version;
use Angelfon\SDK\Rest\Api\V099\User\SmsInstance;

class SmsContext extends InstanceContext
{
	function __construct(Version $version, $id)
	{
		parent::__construct($version);
		$this->solution = array('id' => $id);
		$this->uri = '/sms/' . rawurlencode($id);
	}

	/**
   * Fetch a SmsInstance
   * 
   * @return SmsInstance Fetched SmsInstance
   */
  public function fetch() {
    $params = Values::of(array());

    $payload = $this->version->fetch(
      'GET',
      $this->uri,
      $params
    );

    return new SmsInstance(
      $this->version,
      $payload['data'],
      $this->solution['id']
    );
  }

  /**
   * Deletes the SmsInstance
   * 
   * @return boolean True if delete succeeds, false otherwise
   */
  public function delete() {
      return $this->version->delete('delete', $this->uri);
  }

}