<?php
namespace Angelfon\Tests;

use Angelfon\SDK\Rest\Client;
use Angelfon\SDK\Http\Client as HttpClient;
use Angelfon\SDK\Http\Response;
use Angelfon\Tests\Stage;


class ClientTest extends \PHPUnit\Framework\TestCase {

	/**
	 * The Stage on wich the HTTP Request/Responses are simulated
	 * @var \Angelfon\Tests\Stage $stage
	 */
	protected $stage;

	public function setUp() 
	{
		$stage = new Stage();
		$authenticatedResponse = new Response(200, '{
			"access_token": "1234567890abcdef"
		}');
		$stage->mock($authenticatedResponse);
		$this->stage = $stage;
	}

	public function tearDown()
	{
		unset($this->stage);
	}

	public function testHasUser() 
	{
		$client = new Client('username', 'password', 'clientId', 'clientSecret', $this->stage);
		$this->assertEquals('username', $client->getUsername());
	}

	public function testHasPassword() 
	{
		$client = new Client('username', 'password', 'clientId', 'clientSecret', $this->stage);
		$this->assertEquals('password', $client->getPassword());
	}
	
	public function testHasClientID()
	{
		$client = new Client('username', 'password', 'clientId', 'clientSecret', $this->stage);
		$this->assertEquals('clientId', $client->getClientId());
	}	
	
	public function testHasClientSecret()
	{
		$client = new Client('username', 'password', 'clientId', 'clientSecret', $this->stage);
		$this->assertEquals('clientSecret', $client->getClientSecret());
	}
	
	/**
	* @expectedException \Angelfon\SDK\Exceptions\ConfigurationException
	*/
	public function testThrowsWhenNoCredentialsDefined()
	{
		new Client();
	}

	/**
	 * @expectedException \Angelfon\SDK\Exceptions\RestException
	 */
	public function testThrowsWhenWrongCredentials()
	{
		$this->stage->clearMocks();

		$this->stage->mock(new Response(403, '{
	    "success": false,
	    "error": 31,
	    "data": "Incorrect credentials"
		}'));

		new Client('username', 'password', 'clientId', 'clientSecret', $this->stage);
	}

	/**
	 * @expectedException \Angelfon\SDK\Exceptions\RestException
	 */
	public function testThrowsWhenWrongClientCredentials()
	{
		$this->stage->clearMocks();

		$this->stage->mock(new Response(403, '{
	    "error": "invalid_client",
	    "message": "Client authentication failed"
		}'));

		new Client('username', 'password', 'clientId', 'clientSecret', $this->stage);
	}
	
	public function testUsernamePulledFromEnvironment()
	{
		$client = new Client(null, 'password', 'clientId', 'clientSecret', $this->stage, [
			Client::ENV_USERNAME => 'username'
		]);
		$this->assertEquals('username', $client->getUsername());
	}

	public function testPasswordPulledFromEnvironment()
	{
		$client = new Client('username', null, 'clientId', 'clientSecret', $this->stage, [
			Client::ENV_PASSWORD => 'password'
		]);
		$this->assertEquals('password', $client->getPassword());
	}

	public function testClientIDPulledFromEnvironment()
	{
		$client = new Client('username', 'password', null, 'clientSecret', $this->stage, [
			Client::ENV_CLIENT_ID => 'clientId'
		]);
		$this->assertEquals('clientId', $client->getClientId());
	}

	public function testClientSecretPulledFromEnvironment()
	{
		$client = new Client('username', 'password', 'clientId', null, $this->stage, [
			Client::ENV_CLIENT_SECRET => 'clientSecret'
		]);
		$this->assertEquals('clientSecret', $client->getClientSecret());
	}

	public function testTokenInjectionOnCreateClient() {
    $client = new Client('username', 'password', 'clientId', 'clientSecret', $this->stage);
    $this->assertNotNull($client->getAccessToken());
  }

}