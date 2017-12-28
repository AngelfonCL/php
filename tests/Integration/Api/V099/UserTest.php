<?php
namespace Angelfon\Tests\Integration\Api\V099;

use Angelfon\Tests\StageTestCase;
use Angelfon\Tests\Request;
use Angelfon\SDK\Http\Response;
use Angelfon\SDK\Exceptions\RestException;

class ClassName extends StageTestCase
{
	public function testFetchesUser()
	{
		$this->stage->mock(new Response(500, ''));
		try {
			$this->client->api->v099->user->fetch();
		} catch (RestException $e) {}

		$this->assertRequest(new Request(
			'get',
			'https://api.angelfon.com/0.99/user'
		));
	}

	public function testSetsUserAfterSuccessfulFetch()
	{
		$this->stage->mock(new Response(200, '
			{
		    "id": 64,
		    "email": "pruebas@angelfon.com",
		    "born": null,
		    "timetorecord": 20,
		    "country": 1,
		    "name": "Pruebas Angelfon",
		    "api": 0,
		    "maxrcp": 50,
		    "callerid": null,
		    "social": 0,
		    "social_type": "",
		    "gmt": 0,
		    "rhm_validated": 1,
		    "rhm_audio_1": 601,
		    "rhm_audio_2": 602,
		    "rhm_audio_3": 603,
		    "plan_id": 1,
		    "rhm_plan_id": 6,
		    "timezone": "America/Santiago",
		    "created_at": null,
		    "updated_at": "2017-12-13 19:13:29"
			}
		'));

		$user = $this->client->api->v099->user->fetch();

		$this->assertNotNull($user);

		return $user;
	}

	/**
	 * @depends testSetsUserAfterSuccessfulFetch
	 */
	public function testCanAccessUserProperties($user)
	{
		$this->assertNotNull($user->email);
		$this->assertNotNull($user->maxRecipients);
	}
}