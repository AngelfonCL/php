<?php
namespace Angelfon\SDK;

class VersionInfo {
  const MAJOR = 1;
  const MINOR = 2;
  const PATCH = 0;
  /**
   * @return string A friendly representation of the version number
   */
  public static function string() {
      return implode('.', array(self::MAJOR, self::MINOR, self::PATCH));
  }
}