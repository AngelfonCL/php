<?php
namespace Angelfon\SDK\Rest\Api\V099\User;

use Angelfon\SDK\Options;
use Angelfon\SDK\Values;

abstract class SmsOptions
{
	/**
	 *	Build filters for the API response according to the specified parameters
	 * 
	 * @param  string $recipient Filter by phone number
	 * @param  string $batchId Filter by batch ID
	 * @param  string $scheduledBefore Filters sms scheduled before the datetime specified
	 * @param  string $scheduledAfter Filters sms scheduled after the datetime specified
	 * @param  int $status Filters by call status (0 => pending, 1 => sended)
	 * @return \Angelfon\SDK\Rest\Api\V099\User\ReadSmsOptions The builder for read sms options
	 */
	public static function read($recipient = Values::NONE, $batchId = Values::NONE, 
															$scheduledBefore = Values::NONE, $scheduledAfter = Values::NONE, 
															$status = Values::NONE)
	{
		return new ReadSmsOptions(
			$recipient, 
			$batchId, 
			$startedBefore, 
			$startedAfter, 
			$scheduledBefore, 
			$scheduledAfter, 
			$status, 
			$answer
		);
	}

	/**
	 *	Build options for a new Sms
	 * 
	 * @param  string $recipientName The name of the recipient
	 * @param  string $body The content of the Sms. Maximum 160 ASCII characters.
	 * @param  string $sendAt UTC time to schedule the Sms ie. '2017-05-15 14:15:00'
	 * @param  string $batchId Add this Sms to a specific batch
	 * @param  string $batchName Name this batch
	 * @return \Angelfon\SDK\Rest\Api\V099\User\CreateSmsOptions The builder for create Sms options
	 */
	public static function create($recipientName = Values::NONE, $body = Values::NONE, 
																$sendAt = Values::NONE, $batchId = Values::NONE, 
																$batchName = Values::NONE)
	{
		return new CreateSmsOptions(
			$recipientName, 
			$body, 
			$callAt,
			$batchId, 
			$batchName
		);
	}
}

class ReadSmsOptions extends Options
{
	public function __construct($recipient = Values::NONE, $batchId = Values::NONE, 
															$scheduledBefore = Values::NONE, $scheduledAfter = Values::NONE, 
															$status = Values::NONE)
	{
    $this->options['recipient'] = $recipient;
    $this->options['batchId'] = $batchId;
    $this->options['scheduledBefore'] = $scheduledBefore;
    $this->options['scheduledAfter'] = $scheduledAfter;
    $this->options['status'] = $status;
	}

	public function setRecipient($recipient)
	{
    $this->options['recipient'] = $recipient;
	}
	
	public function setBatchId($batchId)
	{
    $this->options['batchId'] = $batchId;
	}
	
	public function setScheduledBefore($datetime)
	{
    $this->options['scheduledBefore'] = $datetime;
	}
	
	public function setScheduledAfter($datetime)
	{
    $this->options['scheduledAfter'] = $datetime;
	}
	
	public function setStatus($status)
	{
    $this->options['status'] = $status;
	}
}

class CreateSmsOptions extends Options
{
	function __construct($recipientName = Values::NONE, $body = Values::NONE, $sendAt = Values::NONE, 
											 $batchId = Values::NONE, $batchName = Values::NONE)
	{
    $this->options['recipientName'] = $recipientName;
    $this->options['body'] = $body;
    $this->options['sendAt'] = $sendAt;
    $this->options['batchId'] = $batchId;
    $this->options['batchName'] = $batchName;
	}
	
	public function setRecipientName($recipientName)
	{
    $this->options['recipientName'] = $recipientName;
	}

	public function setSendAt($sendAt)
	{
    $this->options['sendAt'] = $sendAt;
	}

	public function setBody($body)
	{
    $this->options['body'] = $body;
	}
	
	public function setBatchId($batch)
	{
    $this->options['batchId'] = $batch;
	}

	public function setBatchName($batchName)
	{
    $this->options['batchName'] = $batchName;
	}
}
