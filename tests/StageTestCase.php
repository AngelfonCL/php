<?php
namespace Angelfon\Tests;

use PHPUnit\Framework\TestCase;
use Angelfon\SDK\Rest\Client;
use Angelfon\SDK\Http\Response;
use Angelfon\Tests\Stage;


class StageTestCase extends TestCase
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
	protected $angelfon;

	public function setUp() 
	{
		$stage = new Stage();
		$authenticatedResponse = new Response(200, '{
			"access_token": "1234567890abcdef"
		}');
		$stage->mock($authenticatedResponse);
		$this->stage = $stage;
		$angelfon = new Client('user', 'pass', 'clientId', 'clientSecret', $this->stage);
		$this->angelfon = $angelfon;
	}

	public function tearDown()
	{
		unset($this->stage);
		unset($this->angelfon);
	}

	public function assertRequest($request) {
    $this->stage->assertRequest($request);
    $this->assertTrue(true);
  }
}