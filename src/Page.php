<?php
namespace Angelfon\SDK;

use Angelfon\SDK\Version;
use Angelfon\SDK\Http\Response;
use Angelfon\SDK\Exceptions\RestException;

abstract class Page implements \Iterator 
{
	protected static $metaKeys = array(
    'end',
    'first_page_uri',
    'next_page_uri',
    'last_page_uri',
    'page',
    'page_size',
    'previous_page_uri',
    'total',
    'num_pages',
    'start',
    'uri',
  );

  protected $version;
  protected $payload;
  protected $solution;
  protected $records;

  abstract public function buildInstance(array $payload);

  public function __construct(Version $version, Response $response) {
    $payload = $this->processResponse($response);

    $this->version = $version;
    $this->payload = $payload;
    $this->solution = array();
    $this->records = new \ArrayIterator($this->loadPage());
  }

  protected function processResponse(Response $response) {
  	$content = $response->getContent();
    if ($response->getStatusCode() != 200 && !$this->isPagingEol($response->getContent())) {
      $message = '[HTTP ' . $response->getStatusCode() . '] Unable to fetch page';
      $code = $response->getStatusCode();

      if (is_array($content)) {
	      if (array_key_exists('message', $content)) 
	    		throw new RestException($content['message'], $code, $code);
	    	else if (array_key_exists('data', $content)) 
	    		throw new RestException($content['data'], $content['error'], $code);
	    	else throw new RestException();
      }

      throw new RestException($message, $code, $response->getStatusCode());
    }
    return $content;
  }

  protected function isPagingEol($content) {
    return !is_null($content) && array_key_exists('data', $content) && $content['data'] == null;
  }

  protected function loadPage() {
    return $this->payload['data'];
  }

  public function getPreviousPageUrl() {
    if ($this->hasMeta('previous_page_url')) {
      return $this->getMeta('previous_page_url');
    } else if (array_key_exists('previous_page_uri', $this->payload) && $this->payload['previous_page_uri']) {
      return $this->getVersion()->getDomain()->absoluteUrl($this->payload['previous_page_uri']);
    }
    return null;
  }

  public function getNextPageUrl() {
    if ($this->hasMeta('next_page_url')) {
      return $this->getMeta('next_page_url');
    } else if (array_key_exists('next_page_uri', $this->payload) && $this->payload['next_page_uri']) {
    	return $this->getVersion()->getDomain()->absoluteUrl($this->payload['next_page_uri']);
    }
    return null;
  }

  public function nextPage() {
    if (!$this->getNextPageUrl()) {
      return null;
    }

    $response = $this->getVersion()->getDomain()->getClient()->request('GET', $this->getNextPageUrl());
    return new static($this->getVersion(), $response, $this->solution);
  }

  public function previousPage() {
    if (!$this->getPreviousPageUrl()) {
      return null;
    }

    $response = $this->getVersion()->getDomain()->getClient()->request('GET', $this->getPreviousPageUrl());
    return new static($this->getVersion(), $response, $this->solution);
  }

  /**
   * (PHP 5 &gt;= 5.0.0)<br/>
   * Return the current element
   * @link http://php.net/manual/en/iterator.current.php
   * @return mixed Can return any type.
   */
  public function current() {
    return $this->buildInstance($this->records->current());
  }

  /**
   * (PHP 5 &gt;= 5.0.0)<br/>
   * Move forward to next element
   * @link http://php.net/manual/en/iterator.next.php
   * @return void Any returned value is ignored.
   */
  public function next() {
    $this->records->next();
  }

  /**
   * (PHP 5 &gt;= 5.0.0)<br/>
   * Return the key of the current element
   * @link http://php.net/manual/en/iterator.key.php
   * @return mixed scalar on success, or null on failure.
   */
  public function key() {
    return $this->records->key();
  }

  /**
   * (PHP 5 &gt;= 5.0.0)<br/>
   * Checks if current position is valid
   * @link http://php.net/manual/en/iterator.valid.php
   * @return boolean The return value will be casted to boolean and then evaluated.
   * Returns true on success or false on failure.
   */
  public function valid() {
    return $this->records->valid();
  }

  /**
   * (PHP 5 &gt;= 5.0.0)<br/>
   * Rewind the Iterator to the first element
   * @link http://php.net/manual/en/iterator.rewind.php
   * @return void Any returned value is ignored.
   */
  public function rewind() {
    $this->records->rewind();
  }


  /**
   * @return Version
   */
  public function getVersion() {
    return $this->version;
  }

  public function __toString() {
    return '[Page]';
  }
}