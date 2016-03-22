<?php
// путь до фреймворка и нужного нам конфига
$yii = dirname(__FILE__).'/framework/yii.php';
$config = dirname(__FILE__).'/protected/config/backend.php';
 
// включать дебаг?
defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL', 3);
 
// подключаем фреймворк
require_once($yii);
// стартуем приложение с помощью нашего WebApplicaitonEndBehavior, указав ему, что нужно загрузить бекэнд
Yii::createWebApplication($config)->runEnd('backend');