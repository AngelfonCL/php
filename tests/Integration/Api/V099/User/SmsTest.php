<?php
namespace Angelfon\Tests\Integration\Api\V099\User;

use Angelfon\Tests\StageTestCase;
use Angelfon\Tests\Request;
use Angelfon\SDK\Http\Response;
use Angelfon\SDK\Exceptions\RestException;
use Angelfon\SDK\Rest\Api\V099\User\SmsOptions;

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

	public function testCreateSmsMultipleRecipientsRequest()
	{
		$this->stage->mock(new Response(500, ''));

		$options = SmsOptions::create();
		$options->setBody('Ejemplo de SMS');
		$options->setSendAt('2018-08-23 12:00:00');
		$options->setBatchId('13a5acea1245b7b50f199d5b542b7889efe9dfb4031d332babd3f71074aa3d0dd77b9e482fc8d0dfe0a478f3e4f1fc96454852636c3646a9913d2b5e368a4b05');
		$options->setBatchName('Batch de ejemplo');

		try {
			$sms = $this->client->sms->create(
				[
					'destinatario 1' => '912345678',
					'destinatario 2' => '987654321',
				], 
				$options);
		} catch (RestException $e) {}

		$data = array(
			'recipients[0]' => '912345678',
			'recipients[1]' => '987654321',
			'addressee[0]' => 'destinatario 1',
			'addressee[1]' => 'destinatario 2',
			'body' => 'Ejemplo de SMS',
			'send_at' => '2018-08-23 12:00:00',
			'batch_id' => '13a5acea1245b7b50f199d5b542b7889efe9dfb4031d332babd3f71074aa3d0dd77b9e482fc8d0dfe0a478f3e4f1fc96454852636c3646a9913d2b5e368a4b05',
			'batch_name' => 'Batch de ejemplo'
		);

		$this->assertRequest(new Request(
			'post',
			'https://api.angelfon.com/0.99/sms',
			null,
			$data
		));
	}

	public function testReadSmsWithOptionsRequest()
	{
		$this->stage->mock(new Response(500, ''));

		$options = SmsOptions::read();
		$options->setRecipient('912345678');
		$options->setBatchId('ff9891b45733305b275026ba4218eaf2ed988837750298131a0551d7723acffd1d5cb656825db85668c9d2658b21d4d03fb54d12fc35f3c8ff3e616a92998e23');
		$options->setScheduledAfter('2018-08-22 12:00:00');
		$options->setScheduledBefore('2018-08-23 12:00:00');
		$options->setStatus(1);

		try {
			$this->client->api->v099->user->sms->read($options);
		} catch (RestException $e) {}

		$queryString = array(
			'recipient' => '912345678',
			'batch_id' => 'ff9891b45733305b275026ba4218eaf2ed988837750298131a0551d7723acffd1d5cb656825db85668c9d2658b21d4d03fb54d12fc35f3c8ff3e616a92998e23',
			'status' => 1,
			'scheduled_before' => '2018-08-23 12:00:00',
			'scheduled_after' => '2018-08-22 12:00:00'
		);

		$this->assertRequest(new Request(
			'get',
			'https://api.angelfon.com/0.99/sms',
			$queryString
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
		$this->assertEquals(521, $sms->id);
	}

	public function testCreateSmsMultipleRecipientsResponse()
	{
		$this->stage->mock(new Response(
			200,
			'{
		    "success": true,
		    "text": "SMS agregado(s)",
		    "data": [
		        521,
		        522
		    ],
		    "batch_id": "13a5acea1245b7b50f199d5b542b7889efe9dfb4031d332babd3f71074aa3d0dd77b9e482fc8d0dfe0a478f3e4f1fc96454852636c3646a9913d2b5e368a4b05"
  		}'
		));

		$options = SmsOptions::create();
		$options->setBody('Ejemplo de SMS');
		$options->setSendAt('2018-08-23 12:00:00');
		$options->setBatchId('13a5acea1245b7b50f199d5b542b7889efe9dfb4031d332babd3f71074aa3d0dd77b9e482fc8d0dfe0a478f3e4f1fc96454852636c3646a9913d2b5e368a4b05');
		$options->setBatchName('Batch de ejemplo');


		$sms = $this->client->sms->create(
			[
				'destinatario 1' => '912345678',
				'destinatario 2' => '987654321',
			], 
			$options
		);

		$this->assertNotNull($sms);
		$this->assertEquals(2, count($sms->id));
		$this->assertNotNull($sms->batchId);
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

		public function testFetchSmsHistoryRequest()
	{
		$this->stage->mock(new Response(500, ''));

		try {
			$call = $this->client->api->v099->user->sms->read();
		} catch (RestException $e) {}

		$this->assertRequest(new Request(
			'get',
			'https://api.angelfon.com/0.99/sms'
		));
	}

	public function testReadSmsHistoryResponse()
	{
		$this->stage->mock(new Response(200, '
			{
		    "data": [
		       {
		        "id": 36319,
		        "user_id": 4,
		        "status": 1,
		        "send_at": "2017-10-18 20:09:59",
		        "sended_at": "2017-11-21 18:29:16",
		        "recipient": "912345678",
		        "body": "un SMS",
		        "batch_id": "de2905620532a0b193e9e7167043b2338d455c5b2b08413bf72f95dacca38a67a7533f1fea4be213ae625615846bbe0e1d13e8e9ab22d63443814a06a5dce31d",
		        "batch_name": "MIN 2017-10-18 20:12:21",
		        "created_at": "2017-10-18 20:10:42",
		        "updated_at": "2017-11-21 18:29:33",
		        "response": "",
		        "client_id": 12,
		        "addressee": "Jorge Bustos"
		      },
		      {
		        "id": 48358,
		        "user_id": 4,
		        "status": 1,
		        "send_at": "2017-10-23 15:17:53",
		        "sended_at": "2017-10-23 18:15:55",
		        "recipient": "912345678",
		        "body": "otro SMS",
		        "batch_id": "755514bed204a0d9b427016c18f2dd1a9ae7c8a02ae5db81836d3e3054c0722af677686a5ee1db64770bfcd09ef490ab17cef924a200ecb105c132f7e755e585",
		        "batch_name": "Mensaje 2017-10-23 15:17:53",
		        "created_at": "2017-10-23 18:15:32",
		        "updated_at": "2017-10-23 18:15:32",
		        "response": "",
		        "client_id": 13,
		        "addressee": "Jaime Delgado"
		    	}
		    ]
		  }
		'));

		$sms = $this->client->api->v099->user->sms->read();
		$this->assertEquals(2, count($sms));
		$this->assertEquals('755514bed204a0d9b427016c18f2dd1a9ae7c8a02ae5db81836d3e3054c0722af677686a5ee1db64770bfcd09ef490ab17cef924a200ecb105c132f7e755e585', $sms[1]->batchId);
		$this->assertEquals('2017-10-23 18:15:55', $sms[1]->sendedAt);
		$this->assertEquals('Jaime Delgado', $sms[1]->recipientName);
	}

	public function testDeleteSmsRequest()
	{
		$this->stage->mock(new Response(500,''));

		try {
			$this->client->api->v099->user->sms(75429)->delete();
		} catch (RestException $e) {}

		$this->assertRequest(new Request(
			'delete',
			'https://api.angelfon.com/0.99/sms/75429'
		));
	}

	public function testDeleteSmsResponse()
	{
		$this->stage->mock(new Response(200,'
			{
		    "message": "SMS disabled"
			}
		'));

		$result = $this->client->api->v099->user->sms(75429)->delete();

		$this->assertTrue($result);
	}
}
