<?php
namespace Angelfon\Tests;

class Request {
  function __construct($method, $url, $params = array(), $data = array(), $headers = array()) {
    $this->method = $method;
    $this->url = $url;
    $this->params = $params;
    $this->data = $data;
    $this->headers = $headers;
  }
}
