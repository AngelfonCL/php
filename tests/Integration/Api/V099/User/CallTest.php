<?php
namespace Angelfon\Tests\Integration\Api\V099\User;

use Angelfon\Tests\StageTestCase;
use Angelfon\Tests\Request;
use Angelfon\SDK\Http\Response;
use Angelfon\SDK\Exceptions\RestException;

class CallTest extends StageTestCase
{
	public function testCreateType0CallRequest()
	{
		$this->stage->mock(new Response(500, ''));

		try {
			$call = $this->client->api->v099->user->calls->create('912345678', array(
				'type' => 0,
				'recipientName' => 'Example recipient',
				'audioId1' => 123
			));
		} catch (RestException $e) {}

		$data = array(
			'recipient' => '912345678',
			'type' => 0,
			'abrid' => 'Example recipient',
			'audio' => 123
		);

		$this->assertRequest(new Request(
			'post',
			'https://api.angelfon.com/0.99/calls',
			null,
			$data
		));
	}

	public function testCreateCallResponse()
	{
		$this->stage->mock(new Response(
			200,
			'{
		    "success": true,
		    "text": "Mensaje(s) Ingresado",
		    "data": [
		        75429
		    ],
		    "batch_id": "48305f9cb05f6ea184dfcdc392c9e8331b3039c969c66c05abeeede64d6fd70ea0edb0d232d2029789c840a880e62f9566b00b9494eb28b5bbd842d1d4bf8e65"
  		}'
		));

		$call = $this->client->api->v099->user->calls->create('912345678', array(
			'type' => 0,
			'recipientName' => 'Example recipient',
			'audioId1' => 123
		));
		$this->assertNotNull($call);
		$this->assertNotNull($call->id);
	}

	/**
	* @expectedException \Angelfon\SDK\Exceptions\RestException
	*/
	public function testFailsOnNoParametersWhenCreatingCall()
	{
		$this->stage->mock(new Response(422, '
			{
		    "success": false,
		    "error": 17,
		    "data": "Fundamental data is missing"
			}
		'));

		$call = $this->client->api->v099->user->calls->create('912345678');
	}

	/**
	* @expectedException \Angelfon\SDK\Exceptions\RestException
	*/
	public function testFailsOnNoTypeDefinedWhenCreatingCall()
	{
		$this->stage->mock(new Response(422, '
			{
		    "success": false,
		    "error": 17,
		    "data": "Fundamental data is missing"
			}
		'));

		$call = $this->client->api->v099->user->calls->create('912345678', array(
			'recipientName' => 'Example recipient',
			'audioId1' => 123
		));
	}

	public function testFetchCallRequest()
	{
		$this->stage->mock(new Response(500, ''));

		try {
			$call = $this->client->api->v099->user->calls(75429)->fetch();
		} catch (RestException $e) {}

		$this->assertRequest(new Request(
			'get',
			'https://api.angelfon.com/0.99/calls/75429'
		));
	}

	public function testFetchCallResponse()
	{
		$this->stage->mock(new Response(200, '
			{
		    "data": {
		        "id": 75429,
		        "calldate": "2017-12-27 21:35:41",
		        "destinatario": "912345678",
		        "callerid": "943402313",
		        "abrid": "Para mi",
		        "dcontext": "type1",
		        "duration": 10,
		        "estado": 2,
		        "answer": 0,
		        "mensaje": "80434",
		        "iduser": 4,
		        "callout": "2017-12-27 21:36:20",
		        "idmsg": 1373,
		        "used": 1,
		        "sistema": 2,
		        "tts1": "Ejemplo de TTS",
		        "tts2": null,
		        "idmsg1": null,
		        "idmsg2": null,
		        "idmsg3": null,
		        "idmsg4": null,
		        "batch_id": "48305f9cb05f6ea184dfcdc392c9e8331b3039c969c66c05abeeede64d6fd70ea0edb0d232d2029789c840a880e62f9566b00b9494eb28b5bbd842d1d4bf8e65",
		        "batch_name": null,
		        "entry_index": 0,
		        "cost": 0,
		        "booking_id": null,
		        "notified": 0,
		        "convocation_id": null,
		        "convocation_capacity": 0,
		        "created_at": "2017-12-27 21:35:41",
		        "updated_at": "2017-12-27 21:35:41"
		    }
			}
		'));

		$call = $this->client->api->v099->user->calls(75429)->fetch();

		$this->assertNotNull($call);
		$this->assertNotNull($call->batchId);
	}

	public function testFetchCallsRequest()
	{
		$this->stage->mock(new Response(500, ''));

		try {
			$call = $this->client->api->v099->user->calls->page();
		} catch (RestException $e) {}

		$this->assertRequest(new Request(
			'get',
			'https://api.angelfon.com/0.99/calls'
		));
	}

}