<?php
namespace Angelfon\Tests\Integration\Api\V099\User;

use Angelfon\Tests\StageTestCase;
use Angelfon\Tests\Request;
use Angelfon\SDK\Http\Response;
use Angelfon\SDK\Exceptions\RestException;

class SmsTest extends StageTestCase
{
	public function testCreateSmsRequest()
	{
		$this->stage->mock(new Response(500, ''));

		try {
			$call = $this->client->api->v099->user->sms->create('912345678', array(
				'body' => 'un sms de prueba',
				'sendAt' => '2017-08-23 12:00:00'
			));
		} catch (RestException $e) {}

		$data = array(
			'recipients' => '912345678',
			'body' => 'un sms de prueba',
			'send_at' => '2017-08-23 12:00:00'
		);

		$this->assertRequest(new Request(
			'post',
			'https://api.angelfon.com/0.99/sms',
			null,
			$data
		));
	}

	public function testCreateSmsResponse()
	{
		$this->stage->mock(new Response(
			200,
			'{
		    "success": true,
		    "data": [
	        521
		    ],
		    "message": "SMS agregado(s)",
		    "batch_id": "13a5acea1245b7b50f199d5b542b7889efe9dfb4031d332babd3f71074aa3d0dd77b9e482fc8d0dfe0a478f3e4f1fc96454852636c3646a9913d2b5e368a4b05"
			}'
		));

		$sms = $this->client->api->v099->user->sms->create('912345678', array(
			'body' => 'un sms de prueba',
		));
		$this->assertNotNull($sms);
		$this->assertNotNull($sms->id);
	}

	public function testFetchSmsRequest()
	{
		$this->stage->mock(new Response(500, ''));

		try {
			$call = $this->client->api->v099->user->sms(521)->fetch();
		} catch (RestException $e) {}

		$this->assertRequest(new Request(
			'get',
			'https://api.angelfon.com/0.99/sms/521'
		));
	}

	public function testFetchSmsResponse()
	{
		$this->stage->mock(new Response(200, '
			{
				"data": {
				  "id": 521,
				  "user_id": 129,
				  "status": 0,
				  "send_at": "2018-08-23 12:00:00",
				  "sended_at": "0000-00-00 00:00:00",
				  "recipient": "912345678",
				  "body": "Este es un SMS de prueba",
				  "batch_id": "13a5acea1245b7b50f199d5b542b7889efe9dfb4031d332babd3f71074aa3d0dd77b9e482fc8d0dfe0a478f3e4f1fc96454852636c3646a9913d2b5e368a4b05",
				  "batch_name": "test",
				  "created_at": null,
				  "updated_at": null,
				  "response": "",
				  "client_id": 12,
				  "addressee": null
				}
			}
		'));

		$sms = $this->client->api->v099->user->sms(521)->fetch();

		$this->assertNotNull($sms);
		$this->assertEquals('13a5acea1245b7b50f199d5b542b7889efe9dfb4031d332babd3f71074aa3d0dd77b9e482fc8d0dfe0a478f3e4f1fc96454852636c3646a9913d2b5e368a4b05', $sms->batchId);
	}
}