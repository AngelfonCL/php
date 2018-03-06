<?php
namespace Angelfon\SDK\Rest;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

use Angelfon\SDK\Exceptions\ConfigurationException;
use Angelfon\SDK\Exceptions\RestException;
use Angelfon\SDK\Exceptions\AngelfonException;
use Angelfon\SDK\Http\Client as HttpClient;
use Angelfon\SDK\Http\GuzzleClient;
use Angelfon\SDK\VersionInfo;


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

	/** @var int App Client ID */
	protected $clientId;

	/** @var string App Client Secret */
	protected $clientSecret = '';

	/** @var \Angelfon\SDK\Http\Client HTTP Client */
	protected $httpClient;

	/** @var string Angelfon API Access Token */
	protected $accessToken = '';

	/** @var \Angelfon\SDK\Rest\Api Api domain */
	protected $_api = null;

	/** @var \Monolog\Logger Logger instance */
	protected $log = null;

	/**
	 * @param string $username Account Username
	 * @param string $password Account Password
	 * @param string $clientId Application Client ID
	 * @param string $clientSecret Application Client Secret
	 * @param \Angelfon\SDK\Http\Client|null $httpClient HTTP Client for requests
	 * @param mixed[] $environment Evironment to look for credentials, defaults to $_ENV
	 * @throws \Angelfon\SDK\Exceptions\ConfigurationException When not valid authentication
	 */
	public function __construct($username = null, $password = null, $clientId = null, $clientSecret = null, HttpClient $httpClient = null, $environment = null)
	{
		$this->log = new Logger('angelfon');
		$this->log->pushHandler(new StreamHandler(__DIR__.'/logs/angelfon.log', Logger::WARNING));

		$this->log->info('env', ['env' => $_ENV]);
    if (is_null($environment)) {
      $environment = $_ENV;
    }

		if ($username) {
			$this->username = $username;
		} elseif (array_key_exists(self::ENV_USERNAME, $environment)) {
			$this->username = $environment[self::ENV_USERNAME];
		} 

		if ($password) {
			$this->password = $password;
		} elseif (array_key_exists(self::ENV_PASSWORD, $environment)) {
			$this->password = $environment[self::ENV_PASSWORD];
		}

		if ($clientId) {
			$this->clientId = $clientId;
		} elseif (array_key_exists(self::ENV_CLIENT_ID, $environment)) {
			$this->clientId = $environment[self::ENV_CLIENT_ID];
		}
		
		if ($clientSecret) {
			$this->clientSecret = $clientSecret;
		} elseif (array_key_exists(self::ENV_CLIENT_SECRET, $environment)) {
			$this->clientSecret = $environment[self::ENV_CLIENT_SECRET];
		}

		if (!$this->username || !$this->password || !$this->clientId || !$this->clientSecret) 
			throw new ConfigurationException("Missing credentials to create a Client");

		if ($httpClient) {
      $this->httpClient = $httpClient;
    } else {
      $this->httpClient = new GuzzleClient();
    }
    $this->obtainAccessToken();
	}

	/**
	 * 
	 * Perform a Request using the HTTP Client
	 * 
	 * @param  string $method Http Method
	 * @param  string $uri Fully qualified URL
	 * @param  string[] $params Query string parameters
	 * @param  string[] $data POST body data
	 * @param  string[] $headers HTTP Headers
	 * @param  string $username Account Username
	 * @param  string $password Account Password
	 * @param  string $clientId Application Client ID
	 * @param  string $clientSecret Application Client Secret
	 * @param  int $timeout HTTP Request timeout
	 * @return \Angelfon\SDK\Http\Response Response from Angelfon API
	 */
	public function request($method, $uri, $params = [], $data = [], $headers = [], $timeout = null)
	{
    $headers['User-Agent'] = 'angelfon-php/' . VersionInfo::string() .
                             ' (PHP ' . phpversion() . ')';
    $headers['Accept-Charset'] = 'utf-8';
    if ($this->accessToken) $headers['Authorization'] = 'Bearer ' . $this->accessToken;
    if ($method == 'POST' && !array_key_exists('Content-Type', $headers)) {
      $headers['Content-Type'] = 'application/x-www-form-urlencoded';
    }
    if (!array_key_exists('Accept', $headers)) {
      $headers['Accept'] = 'application/json';
    }

    return $this->getHttpClient()->request(
      $method,
      $uri,
      $params,
      $data,
      $headers,
      $timeout
    );
	}

	public function obtainAccessToken()
  {
    $data = [
      'client_id' => $this->clientId,
      'client_secret' => $this->clientSecret,
      'grant_type' => 'password',
      'username' => $this->username,
      'password' => $this->password
    ];
    $response = $this->request('POST', 'https://api.angelfon.com/0.99/oauth/token', null, $data);
    $content = $response->getContent();
    $code = $response->getStatusCode();
    $validResponse = array_key_exists('access_token', $content);
    if ($validResponse) $this->accessToken = $content['access_token'];
    else {
    	if (array_key_exists('message', $content)) 
    		throw new RestException($content['message'], $code, $code);
    	else if (array_key_exists('data', $content)) 
    		throw new RestException($content['data'], $content['error'], $code);
    	else throw new RestException();
    }
    
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
  * @return string
  */
	public function getClientSecret(){
		return $this->clientSecret;
	}

	/**
	 * Get current HTTP Client
	 * @return \Angelfon\SDK\Http\Client
	 */
	public function getHttpClient()
	{
		return $this->httpClient;
	}

	/**
	 * Get the Angelfon API Access Token
	 * @return string
	 */
	public function getAccessToken()
	{
		return $this->accessToken;
	}

	/**
	 * Access the Api Angelfon Domain
	 * @return \Angelfon\SDK\Rest\Api The Api Domain
	 */
	public function getApi()
	{
		if (!$this->_api) $this->_api = new Api($this);
		return $this->_api;
	}

	/**
   * @return \Angelfon\SDK\Rest\Api\V099\User\CallList 
   */
  protected function getCalls() {
    return $this->api->v099->user->calls;
  }

  /**
   * @param string $id Sms id that uniquely identifies the Sms to fetch
   * @return \Angelfon\SDK\Rest\Api\V099\User\SmsContext 
   */
  protected function contextSms($id) {
    return $this->api->v099->user->sms($id);
  }

	/**
   * @return \Angelfon\SDK\Rest\Api\V099\User\SmsList 
   */
  protected function getSms() {
    return $this->api->v099->user->sms;
  }

  /**
   * @param string $id Call id that uniquely identifies the Call to fetch
   * @return \Angelfon\SDK\Rest\Api\V099\User\CallContext 
   */
  protected function contextCalls($id) {
    return $this->api->v099->user->calls($id);
  }
	

	/**
   * Magic getter to lazy load domains
   * 
   * @param string $name Domain to return
   * @return \Angelfon\SDK\Domain The requested domain
   * @throws \Angelfon\SDK\Exceptions\AngelfonException For unknown domains
   */
  public function __get($name) {
    $method = 'get' . ucfirst($name);
    if (method_exists($this, $method)) {
        return $this->$method();
    }

    throw new AngelfonException('Unknown domain ' . $name);
  }

  /**
   * Magic call to lazy load contexts
   * 
   * @param string $name Context to return
   * @param mixed[] $arguments Context to return
   * @return \Angelfon\SDK\InstanceContext The requested context
   * @throws \Angelfon\SDK\Exceptions\AngelfonException For unknown contexts
   */
  public function __call($name, $arguments) {
    $method = 'context' . ucfirst($name);
    if (method_exists($this, $method)) {
      return call_user_func_array(array($this, $method), $arguments);
    }

    throw new AngelfonException('Unknown context ' . $name);
  }
}
