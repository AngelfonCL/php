<?php
namespace Angelfon\SDK;

use Angelfon\SDK\Values;

class Serialize
{
  /**
   * @param  string $dateTime The time to be casted
   * @return string The parsed dateTime
   */
	public static function stringToCarbon($dateTime) {
    if (is_null($dateTime) || $dateTime == Values::NONE) {
      return Values::NONE;
    }

    if (is_string($dateTime)) {
      return $dateTime;
    }
  }

	public static function booleanToString($boolOrStr) {
    if (is_null($boolOrStr) || is_string($boolOrStr)) {
      return $boolOrStr;
    }
    return $boolOrStr ? 'true' : 'false';
  }
}