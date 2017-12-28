<?php
namespace Angelfon\SDK;

class Serialize
{
	public static function booleanToString($boolOrStr) {
    if (is_null($boolOrStr) || is_string($boolOrStr)) {
      return $boolOrStr;
    }
    return $boolOrStr ? 'true' : 'false';
  }
}