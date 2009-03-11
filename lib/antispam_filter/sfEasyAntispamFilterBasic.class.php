<?php

class sfEasyAntispamFilterBasic
{
  public function rate($text)
  {
    $score = strlen($text) > 50 ? 0 : 2;
    $score += preg_match_all('/http[s]?:\/\//', $text, $result);

    if ($score >= 20)
    {
      return 100;
    }


    foreach ($this->config['words'] as $word)
    {
      $score += 2 * preg_match_all('/'.$word.'/', $text, $result);

      if ($score >= 20)
      {
        return 100;
      }
    }

    return $score * 5;
  }

  public function isSpam($message)
  {
  }
}
