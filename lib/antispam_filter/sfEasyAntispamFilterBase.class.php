<?php

abstract class sfEasyAntispamFilterBase
{
  protected
    $config = null;

  public function __construct($config)
  {
    $this->config = $config;
  }

  abstract public function isSpam($message);
}
