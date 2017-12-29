<?php
namespace Angelfon\SDK\Rest\Api\V099\User;

use Angelfon\SDK\ListResource;
use Angelfon\SDK\Values;
use Angelfon\SDK\Version;
use Angelfon\SDK\Serialize;
use Angelfon\SDK\Rest\Api\V099\User\SmsInstance;
use Angelfon\SDK\Rest\Api\V099\User\SmsContext;

class SmsList extends ListResource
{
	function __construct(Version $version)
	{
		parent::__construct($version);
		$this->uri = '/sms';
	}

	/**
	 * Create a new Sms instance
	 */
	public function create($to, $options = array()) 
	{
    $options = new Values($options);

    $data = Values::of(array(
      'recipients' => $to,
      'addressee' => $options['recipientName'],
      'body' => $options['body'],
      'send_at' => $options['sendAt'],
      'batch_name' => $options['batchName'],
      'batch_id' => $options['batchId']
    ));

    $payload = $this->version->create(
      'POST',
      $this->uri,
      array(),
      $data
    );

    $callData = array(
      'id' => $payload['data'][0],
      'batch_id' => $payload['batch_id']
    );

    return new SmsInstance($this->version, $callData);
	}

  /**
   * Construct a Call context
   * 
   * @param  int $id The call ID
   * @return \Angelfon\SDK\Rest\Api\V099\User\SmsContext
   */
  public function getContext($id)
  {
    return new SmsContext($this->version, $id);    
  }

  /**
   * Reads SmsInstance records from the API as a list.
   * Unlike stream(), this operation is eager and will load `limit` records into
   * memory before returning.
   * 
   * @param array|Options $options Optional Arguments
   * @param int $limit Upper limit for the number of records to return. read()
   *                   guarantees to never return more than limit.  Default is no
   *                   limit
   * @param mixed $pageSize Number of records to fetch per request, when not set
   *                        will use the default value of 50 records.  If no
   *                        page_size is defined but a limit is defined, read()
   *                        will attempt to read the limit with the most
   *                        efficient page size, i.e. min(limit, 1000)
   * @return SmsInstance[] Array of results
   */
  public function read($options = array(), $limit = null, $pageSize = null) {
    return iterator_to_array($this->page($options), false);
  }

  /**
   * Retrieve a single page of SmsInstance records from the API.
   * Request is executed immediately
   * 
   * @param array|Options $options Optional Arguments
   * @param mixed $pageSize Number of records to return, defaults to 50
   * @param string $pageToken PageToken provided by the API
   * @param mixed $pageNumber Page Number, this value is simply for client state
   * @return \Angelfon\SDK\SmsPage Page of SmsInstance
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

    return new SmsPage($this->version, $response, $this->solution);
  }
}