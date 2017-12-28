<?php
namespace Angelfon\SDK\Rest\Api\V099\User;

use Angelfon\SDK\ListResource;
use Angelfon\SDK\Values;
use Angelfon\SDK\Version;
use Angelfon\SDK\Serialize;
use Angelfon\SDK\Rest\Api\V099\User\CallInstance;
use Angelfon\SDK\Rest\Api\V099\User\CallContext;

class CallList extends ListResource
{
	function __construct(Version $version)
	{
		parent::__construct($version);
		$this->uri = '/calls';
	}

	/**
	 * Create a new Call instance
	 */
	public function create($to, $options = array()) 
	{
    $options = new Values($options);

    $data = Values::of(array(
      'recipient' => $to,
      'callerid' => Serialize::booleanToString($options['callerId']),
      'abrid' => $options['recipientName'],
      'batch_name' => $options['batchName'],
      'batch_id' => $options['batchId'],
      'calltime' => $options['callAt'],
      'type' => $options['type'],
      'audio' => $options['audioId1'],
      'audio1' => $options['audioId2'],
      'audio2' => $options['audioId3'],
      'tts' => $options['tts1'],
      'tts1' => $options['tts2'],
      'force_schedule' => Serialize::booleanToString($options['forceSchedule']),
      'adjust_schedule' => Serialize::booleanToString($options['adjustSchedule']),
    ));

    $payload = $this->version->create(
      'POST',
      $this->uri,
      array(),
      $data
    );

    return new CallInstance($this->version, $payload);
	}

  /**
   * Construct a Call context
   * 
   * @param  int $id The call ID
   * @return \Angelfon\SDK\Rest\Api\V099\User\CallContext
   */
  public function getContext($id)
  {
    return new CallContext($this->version, $id);    
  }

  /**
   * Retrieve a single page of CallInstance records from the API.
   * Request is executed immediately
   * 
   * @param array|Options $options Optional Arguments
   * @param mixed $pageSize Number of records to return, defaults to 50
   * @param string $pageToken PageToken provided by the API
   * @param mixed $pageNumber Page Number, this value is simply for client state
   * @return \Angelfon\SDK\CallPage Page of CallInstance
   */
  public function page($options = array()) {
    $options = new Values($options);
    $params = Values::of(array(
      'recipient' => $options['recipient'],
      'status' => $options['status'],
      'batch_id' => $options['batchId'],
    ));

    $response = $this->version->page(
      'GET',
      $this->uri,
      $params
    );

    return new CallPage($this->version, $response, $this->solution);
  }
}