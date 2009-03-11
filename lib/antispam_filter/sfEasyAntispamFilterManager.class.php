<?php

class sfEasyAntispamFilterManager implements ArrayAccess
{
  static protected
    $instance = null;

  protected
    $filters = array(),
    $config  = null;

  protected function __construct()
  {
    require_once(sfContext::getInstance()->getConfiguration()->getConfigCache()->checkConfig('config/sfEasyAntispamPlugin.yml'));

    $this->config = sfConfig::get('sfEasyAntispamPluginConfiguration');
  }

  public function getInstance()
  {
    if (is_null(self::$instance))
    {
      self::$instance = new self();
    }

    return self::$instance;
  }

  protected function getFilterConfiguration($filter)
  {
    if (array_key_exists($filter, $this->config))
    {
      return $this->config[$filter];
    }
    else
    {
      return array();
    }
  }

  protected function getFilterClass($filter)
  {
    return 'sfEasyAntispamFilter'.sfInflector::camelize($filter);
  }

  protected function getFilter($filter)
  {
    if (!isset($this->filters[$filter]))
    {
      $filterClass = $this->getFilterClass($filter);

      $this->filters[$filter] = new $filterClass($this->getFilterConfiguration($filter));
    }

    return $this->filters[$filter];
  }

  public function offsetGet($filter)
  {
    return $this->getFilter($filter);
  }

  public function offsetExists($filter)
  {
    return class_exists($this->getFilterClass($filter));
  }

  public function offsetUnset($filter)
  {
    throw new BadMethodCallException('invalid.');
  }

  public function offsetSet($filter, $value)
  {
    throw new BadMethodCallException('invalid.');
  }
}
