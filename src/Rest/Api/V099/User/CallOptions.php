<?php
namespace Angelfon\SDK\Rest\Api\V099\User;

use Angelfon\SDK\Options;
use Angelfon\SDK\Values;

abstract class CallOptions
{
	/**
	 *	Build filters for the API response according to the specified parameters
	 * 
	 * @param  string $recipient The phone number to call
	 * @param  string $batchId The ID of the batch to which this call will be added
	 * @param  string $startedBefore Filters calls answered before the datetime specified
	 * @param  string $startedAfter Filters calls answered after the datetime specified
	 * @param  string $scheduledBefore Filters calls scheduled before the datetime specified
	 * @param  string $scheduledAfter Filters calls scheduled after the datetime specified
	 * @param  string $callFrom Filters by phone number used to make the call
	 * @param  int $status Filters by call status (0 => pending, 1 => failed, 2 => answered)
	 * @param  int $answer Filters by numeric option dialed during the call
	 * @return \Angelfon\SDK\Rest\Api\V099\User\ReadCallOptions The builder for read calls options
	 */
	public static function read(
		$recipient = Values::NONE, 
		$batch = Values::NONE, 
		$startedBefore = Values::NONE, 
		$startedAfter = Values::NONE, 
		$scheduledBefore = Values::NONE, 
		$scheduledAfter = Values::NONE, 
		$callFrom = Values::NONE, 
		$status = Values::NONE, 
		$answer = Values::NONE
	){
		return new ReadCallOptions(
			$recipient, 
			$batch, 
			$startedBefore, 
			$startedAfter, 
			$scheduledBefore, 
			$scheduledAfter, 
			$callFrom,
			$status, 
			$answer
		);
	}

	/**
	 *	Build options for a new call
	 * 
	 * @param  int $type The call type
	 * @param  int $audioId1 The ID of the audio first in the play queue
	 * @param  string $tts1 A text to be readed
	 * @param  int $audioId2 The ID of the audio third in the play queue
	 * @param  string $tts2 A text to be readed
	 * @param  int $audioId3 The ID of the audio fifth in the play queue
	 * @param  boolean $callerId Use a validated phone to show on the call
	 * @param  string $callFrom Use a phone number to make the call from (special users only)
	 * @param  string $recipientName The name of the recipient
	 * @param  string $callAt UTC time to schedule the call ie. '2017-05-15 14:15:00'
	 * @param  boolean $forceSchedule Schedule call regardless of user's defined restriction periods
	 * @param  boolean $adjustSchedule Schedule call at the end of the restricted period
	 * @param  string $batchId Add this call to a specific batch
	 * @param  string $batchName Name this batch
	 * @return \Angelfon\SDK\Rest\Api\V099\User\CreateCallOptions The builder for create call options
	 */
	public static function create(
		$type = Values::NONE, 
		$audioId1 = Values::NONE, 
		$tts1 = Values::NONE, 
		$audioId2 = Values::NONE, 
		$tts2 = Values::NONE, 
		$audioId3 = Values::NONE, 
		$callerId = Values::NONE, 
		$callFrom = Values::NONE, 
		$recipientName = Values::NONE, 
		$callAt = Values::NONE, 
		$forceSchedule = Values::NONE, 
		$adjustSchedule = Values::NONE, 
		$batchId = Values::NONE, 
		$batchName = Values::NONE
	){
		return new CreateCallOptions(
			$type, 
			$audioId1, 
			$tts1, 
			$audioId2, 
			$tts2, 
			$audioId3, 
			$callerId, 
			$callFrom, 
			$recipientName, 
			$callAt, 
			$forceSchedule, 
			$adjustSchedule, 
			$batchId, 
			$batchName
		);
	}	

	/**
	 *	Build options for a new call of type 0, which has no cost.
	 * 
	 * @param  int $audioId1 The ID of the audio to play in the call
	 * @param  string $callAt UTC time to schedule the call ie. '2017-05-15 14:15:00'
	 * @param  boolean $callerId Use a validated phone to show on the call
	 * @param  string $callFrom Use a phone number to make the call from (special users only)
	 * @param  string $batchName Name this batch
	 * @param  string $batchId Add this call to a specific batch
	 * @param  string $recipientName The name of the recipient
	 * @param  boolean $forceSchedule Schedule call regardless of user's defined restriction periods
	 * @param  boolean $adjustSchedule Schedule call at the end of the restricted period
	 * @return \Angelfon\SDK\Rest\Api\V099\User\CreateCallOptions The builder for create call options
	 */
	public static function createFree(
		$audioId1 = Values::NONE, 
		$callAt = Values::NONE, 
		$callerId = Values::NONE, 
		$callFrom = Values::NONE, 
		$batchName = Values::NONE, 
		$batchId = Values::NONE, 
		$recipientName = Values::NONE, 
		$forceSchedule = Values::NONE, 
		$adjustSchedule = Values::NONE
	){
		return new CreateCallOptions(
			0, 
			$audioId1, 
			Values::NONE, 
			Values::NONE, 
			Values::NONE, 
			Values::NONE, 
			$callerId, 
			$callFrom, 
			$recipientName, 
			$callAt, 
			$forceSchedule, 
			$adjustSchedule, 
			$batchId, 
			$batchName
		);
	}

	/**
	 *	Build options for a new call of type 1, with a single audio.
	 * 
	 * @param  int $audioId1 The ID of the audio to play in the call
	 * @param  string $callAt UTC time to schedule the call ie. '2017-05-15 14:15:00'
	 * @param  boolean $callerId Use a validated phone to show on the call
	 * @param  string $callFrom Use a phone number to make the call from (special users only)
	 * @param  string $batchName Name this batch
	 * @param  string $batchId Add this call to a specific batch
	 * @param  string $recipientName The name of the recipient
	 * @param  boolean $forceSchedule Schedule call regardless of user's defined restriction periods
	 * @param  boolean $adjustSchedule Schedule call at the end of the restricted period
	 * @return \Angelfon\SDK\Rest\Api\V099\User\CreateCallOptions The builder for create call options
	 */
	public static function createWithSingleAudio(
		$audioId1 = Values::NONE, 
		$callAt = Values::NONE, 
		$callerId = Values::NONE, 
		$callFrom = Values::NONE, 
		$batchName = Values::NONE, 
		$batchId = Values::NONE, 
		$recipientName = Values::NONE, 
		$forceSchedule = Values::NONE, 
		$adjustSchedule = Values::NONE
	){
		return new CreateCallOptions(
			1, 
			$audioId1, 
			Values::NONE, 
			Values::NONE, 
			Values::NONE, 
			Values::NONE, 
			$callerId, 
			$callFrom, 
			$recipientName, 
			$callAt, 
			$forceSchedule, 
			$adjustSchedule, 
			$batchId, 
			$batchName
		);
	}

	/**
	 *	Build options for a new call of type 2, with a single audio and answer registration.
	 * 
	 * @param  int $audioId1 The ID of the audio to play in the call
	 * @param  string $callAt UTC time to schedule the call ie. '2017-05-15 14:15:00'
	 * @param  boolean $callerId Use a validated phone to show on the call
	 * @param  string $callFrom Use a phone number to make the call from (special users only)
	 * @param  string $batchName Name this batch
	 * @param  string $batchId Add this call to a specific batch
	 * @param  string $recipientName The name of the recipient
	 * @param  boolean $forceSchedule Schedule call regardless of user's defined restriction periods
	 * @param  boolean $adjustSchedule Schedule call at the end of the restricted period
	 * @return \Angelfon\SDK\Rest\Api\V099\User\CreateCallOptions The builder for create call options
	 */
	public static function createWithAnswer(
		$audioId1 = Values::NONE, 
		$callAt = Values::NONE, 
		$callerId = Values::NONE, 
		$callFrom = Values::NONE, 
		$batchName = Values::NONE, 
		$batchId = Values::NONE, 
		$recipientName = Values::NONE, 
		$forceSchedule = Values::NONE, 
		$adjustSchedule = Values::NONE
	){
		return new CreateCallOptions(
			2, 
			$audioId1, 
			Values::NONE, 
			Values::NONE, 
			Values::NONE, 
			Values::NONE, 
			$callerId, 
			$callFrom, 
			$recipientName, 
			$callAt, 
			$forceSchedule, 
			$adjustSchedule, 
			$batchId, 
			$batchName
		);
	}

	/**
	 *	Build options for a new call of type 6, with a single TTS.
	 * 
	 * @param  string $tts1 The text to be readed in the call
	 * @param  string $callAt UTC time to schedule the call ie. '2017-05-15 14:15:00'
	 * @param  boolean $callerId Use a validated phone to show on the call
	 * @param  string $callFrom Use a phone number to make the call from (special users only)
	 * @param  string $batchName Name this batch
	 * @param  string $batchId Add this call to a specific batch
	 * @param  string $recipientName The name of the recipient
	 * @param  boolean $forceSchedule Schedule call regardless of user's defined restriction periods
	 * @param  boolean $adjustSchedule Schedule call at the end of the restricted period
	 * @return \Angelfon\SDK\Rest\Api\V099\User\CreateCallOptions The builder for create call options
	 */
	public static function createWithSingleTts(
		$tts1 = Values::NONE, 
		$callAt = Values::NONE, 
		$callerId = Values::NONE, 
		$callFrom = Values::NONE, 
		$batchName = Values::NONE, 
		$batchId = Values::NONE, 
		$recipientName = Values::NONE, 
		$forceSchedule = Values::NONE, 
		$adjustSchedule = Values::NONE
	){
		return new CreateCallOptions(
			6, 
			Values::NONE, 
			$tts1, 
			Values::NONE, 
			Values::NONE, 
			Values::NONE, 
			$callerId, 
			$callFrom, 
			$recipientName, 
			$callAt, 
			$forceSchedule, 
			$adjustSchedule, 
			$batchId, 
			$batchName
		);
	}

	/**
	 *	Build options for a new call of type 4, with two TTS and three Audios.
	 * 
	 * @param  int $audioId1 The ID of the audio first in the play queue
	 * @param  string $tts1 A text to be readed
	 * @param  int $audioId2 The ID of the audio third in the play queue
	 * @param  string $tts2 A text to be readed
	 * @param  int $audioId3 The ID of the audio fifth in the play queue
	 * @param  string $callAt UTC time to schedule the call ie. '2017-05-15 14:15:00'
	 * @param  boolean $callerId Use a validated phone to show on the call
	 * @param  string $callFrom Use a phone number to make the call from (special users only)
	 * @param  string $batchName Name this batch
	 * @param  string $batchId Add this call to a specific batch
	 * @param  string $recipientName The name of the recipient
	 * @param  boolean $forceSchedule Schedule call regardless of user's defined restriction periods
	 * @param  boolean $adjustSchedule Schedule call at the end of the restricted period
	 * @return \Angelfon\SDK\Rest\Api\V099\User\CreateCallOptions The builder for create call options
	 */
	public static function createWithAudioAndTts(
		$audioId1 = Values::NONE, 
		$tts1 = Values::NONE, 
		$audioId2 = Values::NONE, 
		$tts2 = Values::NONE, 
		$audioId3 = Values::NONE, 
		$callAt = Values::NONE, 
		$callerId = Values::NONE, 
		$callFrom = Values::NONE, 
		$batchName = Values::NONE, 
		$batchId = Values::NONE, 
		$recipientName = Values::NONE, 
		$forceSchedule = Values::NONE, 
		$adjustSchedule = Values::NONE
	){
		return new CreateCallOptions(
			4, 
			$audioId1, 
			$tts1, 
			$audioId2, 
			$tts2, 
			$audioId3, 
			$callerId, 
			$callFrom, 
			$recipientName, 
			$callAt, 
			$forceSchedule, 
			$adjustSchedule, 
			$batchId, 
			$batchName
		);
	}
}

class ReadCallOptions extends Options
{
	/**
	 * @param string $recipient The phone number to filter the results
	 * @param string $batchId Returns only calls in this batch
	 * @param string $startedBefore Returns calls started before the date time specified
	 * @param string $startedAfter Returns calls started after the date time specified
	 * @param string $scheduledBefore Returns calls scheduled before the date time specified
	 * @param string $scheduledAfter Returns calls scheduled after the date time specified
	 * @param string $callFrom Filters by phone number used to make the call
	 * @param int $status Filter by call status
	 * @param int $answer Filter by call answer
	 */
	public function __construct(
		$recipient = Values::NONE, 
		$batchId = Values::NONE, 
		$startedBefore = Values::NONE, 
		$startedAfter = Values::NONE, 
		$scheduledBefore = Values::NONE, 
		$scheduledAfter = Values::NONE, 
		$callFrom = Values::NONE, 
		$status = Values::NONE, 
		$answer = Values::NONE
	){
    $this->options['recipient'] = $recipient;
    $this->options['batchId'] = $batchId;
    $this->options['startedBefore'] = $startedBefore;
    $this->options['startedAfter'] = $startedAfter;
    $this->options['scheduledBefore'] = $scheduledBefore;
    $this->options['scheduledAfter'] = $scheduledAfter;
    $this->options['callFrom'] = $callFrom;
    $this->options['status'] = $status;
    $this->options['answer'] = $answer;
	}

	public function setRecipient($recipient)
	{
    $this->options['recipient'] = $recipient;
	}
	
	public function setBatchId($batchId)
	{
    $this->options['batchId'] = $batchId;
	}
	
	public function setStartedBefore($datetime)
	{
    $this->options['startedBefore'] = $datetime;
	}
	
	public function setStartedAfter($datetime)
	{
    $this->options['startedAfter'] = $datetime;
	}
	
	public function setScheduledBefore($datetime)
	{
    $this->options['scheduledBefore'] = $datetime;
	}
	
	public function setScheduledAfter($datetime)
	{
    $this->options['scheduledAfter'] = $datetime;
	}	

	public function setCallFrom($callFrom)
	{
    $this->options['callFrom'] = $callFrom;
	}
	
	public function setStatus($status)
	{
    $this->options['status'] = $status;
	}
	
	public function setAnswer($answer)
	{
    $this->options['answer'] = $answer;
	}
}

class CreateCallOptions extends Options
{
	/**
	 * @param  int $type The call type
	 * @param  int $audioId1 The ID of the audio first in the play queue
	 * @param  string $tts1 A text to be readed
	 * @param  int $audioId2 The ID of the audio third in the play queue
	 * @param  string $tts2 A text to be readed
	 * @param  int $audioId3 The ID of the audio fifth in the play queue
	 * @param  boolean $callerId Use a validated phone to show on the call
	 * @param  string $callFrom Use a phone number to make the call from (special users only)
	 * @param  string $recipientName The name of the recipient
	 * @param  string $callAt UTC time to schedule the call ie. '2017-05-15 14:15:00'
	 * @param  boolean $forceSchedule Schedule call regardless of user's defined restriction periods
	 * @param  boolean $adjustSchedule Schedule call at the end of the restricted period
	 * @param  string $batchId Add this call to a specific batch
	 * @param  string $batchName Name this batch
	 * @return \Angelfon\SDK\Rest\Api\V099\User\CreateCallOptions The builder for create call options
	 */	
	function __construct(
		$type = Values::NONE, 
		$audioId1 = Values::NONE, 
		$tts1 = Values::NONE, 
		$audioId2 = Values::NONE, 
		$tts2 = Values::NONE, 
		$audioId3 = Values::NONE, 
		$callerId = Values::NONE, 
		$callFrom = Values::NONE, 
		$recipientName = Values::NONE, 
		$callAt = Values::NONE, 
		$forceSchedule = Values::NONE, 
		$adjustSchedule = Values::NONE, 
		$batchId = Values::NONE, 
		$batchName = Values::NONE
	){
    $this->options['type'] = $type;
    $this->options['audioId1'] = $audioId1;
    $this->options['audioId2'] = $audioId2;
    $this->options['audioId3'] = $audioId3;
    $this->options['tts1'] = $tts1;
    $this->options['tts2'] = $tts2;
    $this->options['callerId'] = $callerId;
    $this->options['callFrom'] = $callFrom;
    $this->options['recipientName'] = $recipientName;
    $this->options['callAt'] = $callAt;
    $this->options['forceSchedule'] = $forceSchedule;
    $this->options['adjustSchedule'] = $adjustSchedule;
    $this->options['batchId'] = $batchId;
    $this->options['batchName'] = $batchName;
	}
	
	public function setBatchId($batchId)
	{
    $this->options['batchId'] = $batchId;
	}

	public function setBatchName($batchName)
	{
    $this->options['batchName'] = $batchName;
	}

	public function setType($type)
	{
    $this->options['type'] = $type;
	}

	public function setAudio1($audioId1)
	{
    $this->options['audioId1'] = $audioId1;
	}

	public function setAudio2($audioId2)
	{
    $this->options['audioId2'] = $audioId2;
	}

	public function setAudio3($audioId3)
	{
    $this->options['audioId3'] = $audioId3;
	}

	public function setTts1($tts)
	{
    $this->options['tts1'] = $tts;
	}

	public function setTts2($tts)
	{
    $this->options['tts2'] = $tts;
	}

	public function setCallerId($callerId)
	{
    $this->options['callerId'] = $callerId;
	}

	public function setCallFrom($callFrom)
	{
    $this->options['callFrom'] = $callFrom;
	}

	public function setRecipientName($recipientName)
	{
    $this->options['recipientName'] = $recipientName;
	}

	public function setCallAt($callAt)
	{
    $this->options['callAt'] = $callAt;
	}

	public function setForceSchedule($forceSchedule)
	{
    $this->options['forceSchedule'] = $forceSchedule;
	}

	public function setAdjustSchedule($adjustSchedule)
	{
    $this->options['adjustSchedule'] = $adjustSchedule;
	}
}
