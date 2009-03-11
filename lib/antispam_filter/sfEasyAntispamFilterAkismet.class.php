<?php

class sfEasyAntispamFilterAkismet extends sfEasyAntispamFilterBase
{
  public function __construct($config)
  {
    parent::__construct($config);

    set_include_path(get_include_path().':'.realpath(dirname(__FILE__).'/../vendor/'));

    $akismet = new Zend_Service_Akismet($this->config['api_key'], $this->config['site_url']);

    if (!$akismet->verifyKey($apiKey))
    {
      throw new sfConfigurationException('Invalid Akismet api key.');
    }
  }

  public function isSpam($message)
  {

  }
}
