<?php

class sfEasyAntispamValidator extends sfValidatorString
{
  public function configure($options=array(), $messages=array())
  {
    $this->addOption('filters', array('basic', 'akismet'));
  }

  public function doClean($value)
  {
    $manager = sfEasyAntispamFilterManager::getInstance();

    foreach ($this->getOption('filters') as $filter)
    {
      if ($manager[$filter]->isSpam($value))
      {
        throw new sfValidatorError($filter.' said spam.');
      }
    }

    return $value;
  }
}
