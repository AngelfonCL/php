<?php
namespace Angelfon\Tests;

use Angelfon\SDK\Rest\Client;
use Angelfon\SDK\Http\Response;
use Angelfon\Tests\Stage;
use Angelfon\Tests\StageTestCase;

class StageTest extends StageTestCase
{
  public function testReturnsMockedResponse()
  {
  	$exampleResponse = new Response(200, '{
			"some_key": "some value"
		}');
		$this->stage->mock($exampleResponse);

		$response = $this->stage->request('GET', 'https://api.angelfon.com/0.99/');

		$this->assertArrayHasKey('some_key', $response->getContent());
  }
}