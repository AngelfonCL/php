<?php
namespace Angelfon\Tests;

use PHPUnit\Framework\TestCase;
use Angelfon\SDK\Domain;
use Angelfon\SDK\Version;
use Angelfon\SDK\Rest\Client;
use Angelfon\SDK\Http\Response;
use Angelfon\Tests\Stage;

/**
 * Simplified Domain
 * @package Angelfon\Tests
 */
class TestDomain extends Domain
{
	/**
	 * Domain methods are simplified to test Version
	 * 
	 * @param  string $uri Version relative URI
	 * @return string Absolute URL on this Domain
	 */
	public function absoluteUrl($uri) 
	{
		return "domain:$uri";
	}
}

class TestVersion extends Version
{
	/**
	 * @return string
	 */
	public function getVersion()
	{
		return $this->version;
	}

	/**
	 * @param string $version The version to be set
	 */
	public function setVersion($version)
	{
		$this->version = $version;
	}
}

class VersionTest extends TestCase
{
	/**
	 * @var \Angelfon\Tests\Stage $stage
	 */
	protected $stage;
	/**
	 * @var \Angelfon\SDK\Rest\Client $client
	 */
	protected $client;
	/**
	 * @var \Angelfon\Tests\TestDomain $domain
	 */
	protected $domain;
	/**
	 * @var \Angelfon\Tests\TestVersion $version
	 */
	protected $version;


	protected function setUp()
	{
		parent::setUp();
		$stage = new Stage();
		$authenticatedResponse = new Response(200, '{
			"access_token": "1234567890abcdef"
		}');
		$stage->mock($authenticatedResponse);
		$this->stage = $stage;
		$this->client = new Client('user', 'pass', 'clientId', 'clientSecret', $this->stage);
		$this->domain = new TestDomain($this->client);
		$this->version = new TestVersion($this->domain);
	}

	public function relativeUriProvider() {
    $cases = array();
    $modes = array(
      'normal' => function($x) { return $x; },
      'prepend' => function($x) { return "/$x"; },
      'append' => function($x) { return "$x/"; },
      'surround' => function($x) { return "/$x/"; },
    );
    foreach ($modes as $prefixMode => $prefixFunc) {
      foreach ($modes as $pathMode => $pathFunc) {
        $prefix = $prefixFunc('v1');
        $path = $pathFunc('path');

        $cases[] = array(
          "Scalar - Prefix $prefixMode - Path $pathMode",
          $prefix,
          $path,
          'v1/path',
        );
      }
    }
    foreach ($modes as $prefixMode => $prefixFunc) {
      foreach ($modes as $pathMode => $pathFunc) {
        $prefix = $prefixFunc('v2');
        $path = $pathFunc('path/to/resource');

        $cases[] = array(
          "Multipart Path - Prefix $prefixMode - Path $pathMode",
          $prefix,
          $path,
          'v2/path/to/resource',
        );
      }
    }
    return $cases;
  }

  /**
   * @param string $message Case message to display on assertion error
   * @param string $prefix Version prefix to test
   * @param string $uri URI to make relative to the version
   * @param string $expected Expected relative URI
   * @dataProvider relativeUriProvider
   */
  public function testRelativeUri($message, $prefix, $uri, $expected) {
    $this->version->setVersion($prefix);
    $actual = $this->version->relativeUri($uri);
    $this->assertEquals($expected, $actual, $message);
  }

  /**
   * @param string $message Case message to display on assertion error
   * @param string $prefix Version prefix to test
   * @param string $uri URI to make absolute to the domain
   * @param string $expected Expected absolute URL
   * @dataProvider absoluteUrlProvider
   */
  public function testAbsoluteUrl($message, $prefix, $uri, $expected) {
    $this->version->setVersion($prefix);
    $actual = $this->version->absoluteUrl($uri);
    $this->assertEquals($expected, $actual, $message);
  }

  public function absoluteUrlProvider() {
    $cases = $this->relativeUriProvider();
    foreach ($cases as &$case) {
      $case[3] = "domain:{$case[3]}";
    }
    return $cases;
  }
}


