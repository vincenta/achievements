<?php

// Uncomment below to force Stato in production mode
// when you don't control web server
// $_SERVER['STATO_ENV'] = 'production';

// Dont't change code below. Configuration is done in conf/environment.php

define('STATO_TIME_START', microtime(true));
define('STATO_CORE_PATH', dirname(__FILE__).'/../lib/Stato');
define('STATO_APP_ROOT_PATH', str_replace('\\', '/', realpath(dirname(__FILE__).'/..')));
define('STATO_ENV', ((isset($_SERVER['STATO_ENV'])) ? $_SERVER['STATO_ENV'] : 'development'));

set_include_path(dirname(__FILE__).'/../app' . PATH_SEPARATOR . STATO_APP_ROOT_PATH.'/lib' . PATH_SEPARATOR . get_include_path());

require(STATO_CORE_PATH.'/common/lib/initializer.php');

SInitializer::boot();

