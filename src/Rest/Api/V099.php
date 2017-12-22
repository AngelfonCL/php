<?php
namespace Angelfon\SDK\Rest\Api;

use Angelfon\SDK\Domain;
use Angelfon\SDK\Version;

class V099 extends Version
{
	
	function __construct(Domain $domain)
	{
		parent::__construct($domain);
		$this->version = '0.99';
	}
}