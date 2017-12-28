<?php
namespace Angelfon\SDK\Rest\Api\V099\User;

use Angelfon\SDK\Page;
use Angelfon\SDK\Rest\Api\V099\User\CallInstance;

class CallPage extends Page
{
	public function __construct($version, $response) {
    parent::__construct($version, $response);
  }

  public function buildInstance(array $payload) {
    return new CallInstance($this->version, $payload);
  }

  /**
   * Provide a friendly representation
   * 
   * @return string Machine friendly representation
   */
  public function __toString() {
    return '[Angelfon.SDK.Api.V099.User.CallPage]';
  }
}