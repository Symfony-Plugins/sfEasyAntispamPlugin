<?php
class sfEasyAntispamPluginConfigHandler extends sfYamlConfigHandler
{
  public function execute($configFiles)
  {
    // retrieve yaml data
    $config = $this->parseYamls($configFiles);

    // get current environment
    $environment = sfConfig::get('sf_environment');

    // merge default and environment specific config
    $config = sfToolKit::arrayDeepMerge(isset($config['all'])?$config['all']:array(), isset($config[$environment])?$config[$environment]:array());

    $config['basic'] = $this->parseConfigurationFilterBasic(isset($config['basic'])?$config['basic']:array());


    $code = sprintf("<?php\n" .
                    "// auto-generated by %s\n" .
                    "// date: %s\n" .
                    "sfConfig::set('sfEasyAntispamPluginConfiguration', %s);",
                    get_class($this),
                    date('Y-m-d H:i:s'),
                    var_export($config, 1));

    return $code;
  }

  protected function parseConfigurationFilterBasic($config)
  {
    if (!isset($config['words']))
    {
      $config['words'] = array();
    }

    foreach ($config['words'] as $index => $word)
    {
      $word = str_replace(array('a','e','i','o','l','x'), array('@A@','@E@','@I@','@O@','@L@','@X@'), $word);
      $config['words'][$index] = str_replace(array('@A@','@E@','@I@','@O@','@L@','@X@'), array('[a4@]','[e3]','[il1]','([o0]|\(\))','[il1]','(x|><)'), $word);
    }

    return $config;
  }
}