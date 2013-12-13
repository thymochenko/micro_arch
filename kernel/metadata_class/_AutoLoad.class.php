<?php
error_reporting(0);
_AutoLoad::loadConfigClasses();
spl_autoload_register('_AutoLoad::autoload');

class _AutoLoad
{
    protected static $config_classes = array(
        'GlobalConfig.class.php',
        'ConfigPath.class.php',
        'ConfigLogger.class.php',
        'ConfigDatabase.class.php',
        'ConfigTemplate.class.php',
        'ConfigSmarty.class.php',
        'ConfigMail.class.php',
        'ConfigDebug.class.php',
        'ConfigSimpleTest.class.php',
        'ConfigCache.class.php'
    );

    public static function autoload($class) {
        
    foreach (ConfigPath::root() as $pasts){
            if (file_exists("{$pasts}/{$class}.class.php")){
                include "{$pasts}/{$class}.class.php";
            }
            if (file_exists("{$pasts}/{$class}.php")){
                include "{$pasts}/{$class}.php";
            }
        }
    self::loadSuitTest();
  }

    public static function getFrontController()
  {
        return ActionController::getInstance();
    }
  
    public static function loadConfigClasses()
  {
        foreach (self::$config_classes as $classes):
            include $classes;
        endforeach;
    }
  
  public static function loadSuitTest()
  {
      ConfigSimpleTest::loadSuiteTest();
  }
}
?>