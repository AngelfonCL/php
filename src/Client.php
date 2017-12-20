<?php
namespace Angelfon\SDK;

use Angelfon\SDK\Exceptions\ConfigurationException;

/**
* A client for accessing the Angelfon API
* @author Fernando Mora G.
*/
class Client
{
  const ENV_USERNAME = "ANGELFON_USERNAME";
  const ENV_PASSWORD = "ANGELFON_PASSWORD";
  const ENV_CLIENT_ID = "ANGELFON_CLIENT_ID";
  const ENV_CLIENT_SECRET = "ANGELFON_CLIENT_SECRET";

	/** @var string Account Username */
	protected $username = '';	

	/** @var string Account Password */
	protected $password = '';

	/** @var string App Client ID */
	protected $clientId = '';

	/** @var string App Client Secret */
	protected $clientSecret = '';


	public function __construct($username = null, $password = null, $clientId = null, $clientSecret = null)
	{
		if ($username) $this->username = $username;
		if ($password) $this->password = $password;
		if ($clientId) $this->clientId = $clientId;
		if ($clientSecret) $this->clientSecret = $clientSecret;

		if (!$username || !$password || !$clientId || !$clientSecret) 
			throw new ConfigurationException("Missing credentials to create a Client");
	}

	/**
  * Get current username
  * @return string
  */
	public function getUsername(){
		return $this->username;
	}

	/**
  * Get current password
  * @return string
  */
	public function getPassword(){
		return $this->password;
	}

	/**
  * Get current clientId
  * @return int
  */
	public function getClientId(){
		return $this->clientId;
	}

	/**
  * Get current clientSecret
  * @return int
  */
	public function getClientSecret(){
		return $this->clientSecret;
	}
}
