<?php
namespace Angelfon\Tests\Integration\Api\V099\User;

use Angelfon\Tests\StageTestCase;
use Angelfon\Tests\Request;
use Angelfon\SDK\Http\Response;
use Angelfon\SDK\Exceptions\RestException;
use Angelfon\SDK\Rest\Api\V099\User\CallOptions;

class CallTest extends StageTestCase
{
	public function testCreateCallManuallyRequest()
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
			'recipients' => '912345678',
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

	public function testCreateCallWithOptionsRequest()
	{
		$this->stage->mock(new Response(500, ''));

		$options = CallOptions::create();
		$options->setType(0);
		$options->setRecipientName('Example recipient');
		$options->setAudio1(123);

		try {
			$call = $this->client->api->v099->user->calls->create('912345678', $options);
		} catch (RestException $e) {}

		$data = array(
			'recipients' => '912345678',
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

	public function testCreateCallWithOptionsShortcutRequest()
	{
		$this->stage->mock(new Response(500, ''));

		$options = CallOptions::create();
		$options->setType(0);
		$options->setRecipientName('Example recipient');
		$options->setAudio1(123);

		try {
			$call = $this->client->calls->create('912345678', $options);
		} catch (RestException $e) {}

		$data = array(
			'recipients' => '912345678',
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

	public function testFetchCallShortcutRequest()
	{
		$this->stage->mock(new Response(500, ''));

		try {
			$call = $this->client->calls(75429)->fetch();
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
		$this->assertEquals('48305f9cb05f6ea184dfcdc392c9e8331b3039c969c66c05abeeede64d6fd70ea0edb0d232d2029789c840a880e62f9566b00b9494eb28b5bbd842d1d4bf8e65', $call->batchId);
	}

	public function testReadCallsRequest()
	{
		$this->stage->mock(new Response(500, ''));

		try {
			$call = $this->client->api->v099->user->calls->read();
		} catch (RestException $e) {}

		$this->assertRequest(new Request(
			'get',
			'https://api.angelfon.com/0.99/calls'
		));
	}

	public function testReadCallsWithOptionsRequest()
	{
		$this->stage->mock(new Response(500, ''));

		$options = CallOptions::read();
		$options->setRecipient('912345678');
		$options->setBatchId('ff9891b45733305b275026ba4218eaf2ed988837750298131a0551d7723acffd1d5cb656825db85668c9d2658b21d4d03fb54d12fc35f3c8ff3e616a92998e23');

		try {
			$this->client->api->v099->user->calls->read($options);
		} catch (RestException $e) {}

		$queryString = array(
			'recipient' => '912345678',
			'batch_id' => 'ff9891b45733305b275026ba4218eaf2ed988837750298131a0551d7723acffd1d5cb656825db85668c9d2658b21d4d03fb54d12fc35f3c8ff3e616a92998e23'
		);

		$this->assertRequest(new Request(
			'get',
			'https://api.angelfon.com/0.99/calls',
			$queryString
		));
	}

	public function testReadCallsResponse()
	{
		$this->stage->mock(new Response(200, '
			{
    		"data": [
        	{
            "id": 208,
            "calldate": "2017-07-12 16:00:00",
            "destinatario": "912345678",
            "callerid": "943402313",
            "abrid": "Fernando Mora",
            "dcontext": "rhm0",
            "duration": 24,
            "estado": 2,
            "answer": 0,
            "mensaje": "243",
            "iduser": 4,
            "callout": "2017-08-04 21:06:36",
            "idmsg": 63,
            "used": 1,
            "sistema": 26,
            "tts1": "Fernando Mora",
            "tts2": "mañana a las 12:00 pm",
            "idmsg1": 64,
            "idmsg2": 65,
            "idmsg3": null,
            "idmsg4": null,
            "batch_id": "d2bff2f6bfe63b38eec93a12277713ed1cefe5529571339f048a52afc4d9c9a7c7c06536fad4b89bb2d37c0ade90306f99d9eccf02ab6cadb6e2a0b96e3d8824",
            "batch_name": "RHM 2017-07-18 12:45:08",
            "entry_index": 0,
            "cost": 1,
            "booking_id": null,
            "notified": 0,
            "convocation_id": null,
            "convocation_capacity": 0,
            "created_at": null,
            "updated_at": null
        	},
        	{
            "id": 395,
            "calldate": "2017-07-27 18:00:00",
            "destinatario": "912345678",
            "callerid": "943402313",
            "abrid": "Victor Cerda",
            "dcontext": "rhm0",
            "duration": 36,
            "estado": 2,
            "answer": 0,
            "mensaje": "467",
            "iduser": 4,
            "callout": "2017-08-04 21:06:19",
            "idmsg": 63,
            "used": 1,
            "sistema": 26,
            "tts1": "Victor Cerda",
            "tts2": "hoy a las 16:00 pm",
            "idmsg1": 64,
            "idmsg2": 65,
            "idmsg3": null,
            "idmsg4": null,
            "batch_id": "ff9891b45733305b275026ba4218eaf2ed988837750298131a0551d7723acffd1d5cb656825db85668c9d2658b21d4d03fb54d12fc35f3c8ff3e616a92998e23",
            "batch_name": "RHM 2017-07-27 14:16:16",
            "entry_index": 0,
            "cost": 1,
            "booking_id": null,
            "notified": 0,
            "convocation_id": null,
            "convocation_capacity": 0,
            "created_at": null,
            "updated_at": null
        	}
        ]
      }
		'));

		$calls = $this->client->api->v099->user->calls->read();
		$this->assertEquals(2, count($calls));
		$this->assertEquals(63, $calls[1]->audioId1);
		$this->assertEquals('ff9891b45733305b275026ba4218eaf2ed988837750298131a0551d7723acffd1d5cb656825db85668c9d2658b21d4d03fb54d12fc35f3c8ff3e616a92998e23', $calls[1]->batchId);
		$this->assertEquals('2017-07-27 18:00:00', $calls[1]->callAt);
		$this->assertEquals('hoy a las 16:00 pm', $calls[1]->tts2);
		$this->assertEquals('Victor Cerda', $calls[1]->recipientName);
	}

	public function testDeleteCallRequest()
	{
		$this->stage->mock(new Response(500,''));

		try {
			$this->client->api->v099->user->calls(75429)->delete();
		} catch (RestException $e) {}

		$this->assertRequest(new Request(
			'delete',
			'https://api.angelfon.com/0.99/calls/75429'
		));
	}

	public function testDeleteCallResponse()
	{
		$this->stage->mock(new Response(200,'
			{
		    "message": "Call disabled"
			}
		'));

		$result = $this->client->api->v099->user->calls(75429)->delete();

		$this->assertTrue($result);
	}

}