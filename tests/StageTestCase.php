<?php
namespace Angelfon\Tests;

use PHPUnit\Framework\TestCase;
use Angelfon\SDK\Rest\Client;
use Angelfon\SDK\Http\Response;
use Angelfon\Tests\Stage;


abstract class StageTestCase extends TestCase
{
	/**
	 * The Stage on wich the HTTP Request/Responses are simulated
	 * @var \Angelfon\Tests\Stage $stage
	 */
	protected $stage;

	/**
	 * Angelfon API Client
	 * @var \Angelfon\SDK\Client
	 */
	protected $client;

	public function setUp() 
	{
		$stage = new Stage();
		$authenticatedResponse = new Response(200, '{
			"access_token": "1234567890abcdef"
		}');
		$stage->mock($authenticatedResponse);
		$this->stage = $stage;
		$client = new Client('user', 'pass', 'clientId', 'clientSecret', $this->stage);
		$this->client = $client;
	}

	public function tearDown()
	{
		unset($this->stage);
		unset($this->client);
	}

	public function assertRequest($request) {
    $this->stage->assertRequest($request);
    $this->assertTrue(true);
  }
}