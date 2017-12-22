<?php
namespace Angelfon\SDK;

class VersionInfo {
  const MAJOR = 1;
  const MINOR = 0;
  const PATCH = 0;
  public static function string() {
      return implode('.', array(self::MAJOR, self::MINOR, self::PATCH));
  }
}