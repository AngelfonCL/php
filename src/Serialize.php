<?php
namespace Angelfon\SDK;

use Carbon\Carbon;

class Serialize
{
	public static function stringToCarbon($dateTime) {
    if (is_null($dateTime) || $dateTime == \Angelfon\SDK\Values::NONE) {
      return \Angelfon\SDK\Values::NONE;
    }

    if (is_string($dateTime)) {
      return Carbon::parse($dateTime);
    }
  }

	public static function booleanToString($boolOrStr) {
    if (is_null($boolOrStr) || is_string($boolOrStr)) {
      return $boolOrStr;
    }
    return $boolOrStr ? 'true' : 'false';
  }
}