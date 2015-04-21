<?php
require(dirname(__FILE__).'/protected/components/GlobalFunctions.php');

// путь до фреймворка и нужного нам конфига
$yii=dirname(__FILE__).'/framework/yii.php';
$config = dirname(__FILE__).'/protected/config/frontend.php';
 
// включать дебаг?
defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL', 3);
 
// подключаем фреймворк
require_once($yii);
// стартуем приложение с помощью нашего WebApplicaitonEndBehavior, указав ему, что нужно загрузить фронтенд
Yii::createWebApplication($config)->runEnd('frontend');


// change the following paths if necessary
/*
$yii=dirname(__FILE__).'/framework/yii.php';
$config=dirname(__FILE__).'/protected/config/main.php';

// remove the following lines when in production mode
defined('YII_DEBUG') or define('YII_DEBUG',true);
// specify how many levels of call stack should be shown in each log message
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);

require_once($yii);
Yii::createWebApplication($config)->run();
*/