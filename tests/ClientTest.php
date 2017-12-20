<?php

use Angelfon\SDK\Client;

class ClientTest extends PHPUnit\Framework\TestCase {

	public function testHasUser() 
	{
		$client = new Client('username', 'password', 'clientId', 'clientSecret');
		$this->assertEquals('username', $client->getUsername());
	}

	public function testHasPassword() 
	{
		$client = new Client('username', 'password', 'clientId', 'clientSecret');
		$this->assertEquals('password', $client->getPassword());
	}

	public function testHasClientID()
	{
		$client = new Client('username', 'password', 'clientId', 'clientSecret');
		$this->assertEquals('clientId', $client->getClientId());
	}	

	public function testHasClientSecret()
	{
		$client = new Client('username', 'password', 'clientId', 'clientSecret');
		$this->assertEquals('clientSecret', $client->getClientSecret());
	}
	
	/**
	* @expectedException \Angelfon\SDK\Exceptions\ConfigurationException
	*/
	public function testThrowsWhenNoCredentialsDefined()
	{
		new Client(null, null, null);
	}

}