<?php
namespace Angelfon\SDK;

use Angelfon\SDK\Version;

class InstanceContext {
  protected $version;
  protected $solution = array();
  protected $uri;

  public function __construct(Version $version) {
    $this->version = $version;
  }

  public function __toString() {
    return '[InstanceContext]';
  }
}